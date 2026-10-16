<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\AvaliacaoFisica;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AvaliacaoFisicaController extends Controller
{
    public function index()
    {
        $dados = AvaliacaoFisica::with('aluno')->orderByDesc('data_avaliacao')->get();

        return view('avaliacao.list', compact('dados'));
    }

    public function create()
    {
        $alunos = Aluno::whereDoesntHave('avaliacaoFisica')->orderBy('nome')->get();

        return view('avaliacao.form', compact('alunos'));
    }

    public function store(Request $request)
    {
        $data = $this->validateForm($request);
        $data['imc'] = round((float) $data['peso'] / ((float) $data['altura'] ** 2), 2);
        AvaliacaoFisica::create($data);

        return redirect('avaliacao')->with('success', 'Avaliação física salva com sucesso!');
    }

    public function edit($id)
    {
        $data = AvaliacaoFisica::findOrFail($id);
        $alunos = Aluno::orderBy('nome')->get();

        return view('avaliacao.form', compact('data', 'alunos'));
    }

    public function update(Request $request, $id)
    {
        $avaliacao = AvaliacaoFisica::findOrFail($id);
        $data = $this->validateForm($request, $avaliacao->id);
        $data['imc'] = round((float) $data['peso'] / ((float) $data['altura'] ** 2), 2);
        $avaliacao->update($data);

        return redirect('avaliacao')->with('success', 'Avaliação física atualizada com sucesso!');
    }

    public function destroy($id)
    {
        AvaliacaoFisica::findOrFail($id)->delete();

        return redirect('avaliacao')->with('success', 'Avaliação física removida com sucesso!');
    }

    public function search(Request $request)
    {
        $data = $request->validate([
            'valor' => 'nullable|string|max:100',
        ]);

        $consulta = AvaliacaoFisica::with('aluno');
        if (!empty($data['valor'])) {
            $consulta->whereHas('aluno', function ($query) use ($data) {
                $query->where('nome', 'like', '%' . $data['valor'] . '%');
            });
        }
        $dados = $consulta->orderByDesc('data_avaliacao')->get();

        return view('avaliacao.list', compact('dados'));
    }

    public function report()
    {
        $dados = AvaliacaoFisica::with('aluno')->orderByDesc('data_avaliacao')->get()
            ->map(fn (AvaliacaoFisica $avaliacao) => [
                'aluno' => $avaliacao->aluno->nome,
                'data' => $avaliacao->data_avaliacao->format('d/m/Y'),
                'peso' => $avaliacao->peso . ' kg',
                'altura' => $avaliacao->altura . ' m',
                'imc' => $avaliacao->imc,
                'observacoes' => $avaliacao->observacoes,
            ]);

        return Pdf::loadView('relatorios.tabela', [
            'titulo' => 'Relatório de Avaliações Físicas',
            'data' => now()->format('d/m/Y'),
            'colunas' => [
                'aluno' => 'Aluno',
                'data' => 'Data',
                'peso' => 'Peso',
                'altura' => 'Altura',
                'imc' => 'IMC',
                'observacoes' => 'Observações',
            ],
            'dados' => $dados,
        ])->download('relatorio_avaliacoes_fisicas.pdf');
    }

    private function validateForm(Request $request, ?int $avaliacaoId = null): array
    {
        $alunoRule = Rule::unique('avaliacoes_fisicas', 'aluno_id');
        if ($avaliacaoId !== null) {
            $alunoRule->ignore($avaliacaoId);
        }

        return $request->validate([
            'aluno_id' => [
                'required',
                'integer',
                'exists:alunos,id',
                $alunoRule,
            ],
            'peso' => 'required|numeric|gt:0|lte:500',
            'altura' => 'required|numeric|gte:0.5|lte:3',
            'observacoes' => 'nullable|string|max:2000',
            'data_avaliacao' => 'required|date',
        ], [
            'aluno_id.unique' => 'Este aluno já possui uma avaliação física cadastrada.',
            'peso.gt' => 'O peso deve ser maior que zero.',
            'peso.lte' => 'O peso não pode ser maior que 500 kg.',
            'altura.gte' => 'A altura deve ser igual ou maior que 0,5 m.',
            'altura.lte' => 'A altura não pode ser maior que 3 metros.',
        ]);
    }
}
