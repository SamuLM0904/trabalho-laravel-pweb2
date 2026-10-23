<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ManagesImages;
use App\Models\Aluno;
use App\Models\Modalidade;
use App\Models\Plano;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AlunoController extends Controller
{
    use ManagesImages;

    public function index()
    {
        $dados = Aluno::with(['plano', 'modalidade', 'avaliacaoFisica'])->orderBy('nome')->get();

        return view('aluno.list', compact('dados'));
    }

    public function create()
    {
        $planos = Plano::orderBy('nome')->get();
        $modalidades = Modalidade::orderBy('nome')->get();

        return view('aluno.form', compact('planos', 'modalidades'));
    }

    public function validateForm(Request $request, ?int $alunoId = null): array
    {
        $cpfRule = Rule::unique('alunos', 'cpf');
        if ($alunoId !== null) {
            $cpfRule->ignore($alunoId);
        }

        return $request->validate([
            'nome' => 'required|string|max:150',
            'cpf' => [
                'required',
                'string',
                'max:16',
                $cpfRule,
            ],
            'telefone' => 'nullable|string|max:20',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('alunos', 'email')->ignore($alunoId),
            ],
            'endereco' => 'required|string|max:255',
            'data_nascimento' => 'required|date|before_or_equal:today',
            'ativo' => 'required|boolean',
            'plano_id' => 'required|exists:planos,id',
            'modalidade_id' => 'required|exists:modalidades,id',
            'imagem' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.unique' => 'Já existe um aluno cadastrado com este CPF.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um endereço de e-mail válido.',
            'email.unique' => 'Já existe um aluno cadastrado com este e-mail.',
            'endereco.required' => 'O endereço é obrigatório.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.before_or_equal' => 'A data de nascimento não pode ser futura.',
            'ativo.required' => 'Informe se o aluno está ativo.',
            'plano_id.required' => 'O plano é obrigatório.',
            'plano_id.exists' => 'O plano selecionado não existe.',
            'modalidade_id.required' => 'A modalidade é obrigatória.',
            'modalidade_id.exists' => 'A modalidade selecionada não existe.',
            'imagem.image' => 'O arquivo enviado deve ser uma imagem.',
            'imagem.mimes' => 'A imagem deve estar no formato PNG, JPEG ou JPG.',
            'imagem.max' => 'A imagem não pode ter mais de 5 MB.',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateForm($request);
        $data['imagem'] = $this->storeImage($request, 'imagem/aluno');

        Aluno::create($data);

        return redirect('aluno')->with('success', 'Aluno salvo com sucesso!');
    }

    public function edit($id)
    {
        $data = Aluno::findOrFail($id);
        $planos = Plano::orderBy('nome')->get();
        $modalidades = Modalidade::orderBy('nome')->get();

        return view('aluno.form', compact('data', 'planos', 'modalidades'));
    }

    public function update(Request $request, $id)
    {
        $aluno = Aluno::findOrFail($id);
        $data = $this->validateForm($request, $aluno->id);
        $imagemAnterior = $aluno->imagem;
        $novaImagem = $this->storeImage($request, 'imagem/aluno');

        if ($novaImagem) {
            $data['imagem'] = $novaImagem;
        }

        $aluno->update($data);

        if ($novaImagem) {
            $this->deleteImage($imagemAnterior);
        }

        return redirect('aluno')->with('success', 'Aluno atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $aluno = Aluno::findOrFail($id);
        $imagem = $aluno->imagem;
        $possuiAvaliacao = $aluno->avaliacaoFisica()->exists();

        DB::transaction(function () use ($aluno) {
            $aluno->avaliacaoFisica()->delete();
            $aluno->delete();
        });

        $this->deleteImage($imagem);

        $mensagem = $possuiAvaliacao
            ? 'Aluno removido com sucesso, junto com a avaliação física associada.'
            : 'Aluno removido com sucesso!';

        return redirect('aluno')->with('success', $mensagem);
    }

    public function search(Request $request)
    {
        $data = $request->validate([
            'tipo' => ['required', 'string', Rule::in(['nome', 'cpf', 'telefone', 'email', 'plano', 'modalidade'])],
            'valor' => 'nullable|string|max:150',
        ]);

        $consulta = Aluno::with(['plano', 'modalidade', 'avaliacaoFisica']);
        if (! empty($data['valor'])) {
            if ($data['tipo'] === 'plano') {
                $consulta->whereHas('plano', function ($query) use ($data) {
                    $query->where('nome', 'like', '%'.$data['valor'].'%');
                });
            } elseif ($data['tipo'] === 'modalidade') {
                $consulta->whereHas('modalidade', function ($query) use ($data) {
                    $query->where('nome', 'like', '%'.$data['valor'].'%');
                });
            } else {
                $consulta->where($data['tipo'], 'like', '%'.$data['valor'].'%');
            }
        }
        $dados = $consulta->orderBy('nome')->get();

        return view('aluno.list', compact('dados'));
    }

    public function report()
    {
        $dados = Aluno::with(['plano', 'modalidade'])
            ->where('ativo', true)
            ->orderBy('plano_id')
            ->orderBy('nome')
            ->get()
            ->map(fn (Aluno $aluno) => [
                'nome' => $aluno->nome,
                'cpf' => $aluno->cpf,
                'telefone' => $aluno->telefone,
                'plano' => $aluno->plano->nome ?? 'Sem plano',
                'modalidade' => $aluno->modalidade->nome ?? 'Sem modalidade',
            ]);

        return Pdf::loadView('relatorios.alunos-por-plano', [
            'data' => now()->format('d/m/Y'),
            'dados' => $dados,
        ])->download('relatorio_alunos.pdf');
    }
}
