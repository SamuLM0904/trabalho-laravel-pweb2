<?php

namespace App\Http\Controllers;

use App\Models\Plano;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PlanoController extends Controller
{
    public function index()
    {
        $dados = Plano::orderBy('nome')->get();

        return view('plano.list', compact('dados'));
    }

    public function create()
    {
        return view('plano.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:100',
            'valor' => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'nome.max' => 'O nome não pode ter mais de 100 caracteres.',
            'valor.required' => 'O valor é obrigatório.',
            'valor.numeric' => 'O valor deve ser numérico.',
            'valor.min' => 'O valor não pode ser negativo.',
            'descricao.string' => 'A descrição deve ser um texto.',
        ]);

        Plano::create($data);

        return redirect('plano')->with('success', 'Plano salvo com sucesso!');
    }

    public function edit($id)
    {
        $data = Plano::findOrFail($id);

        return view('plano.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:100',
            'valor' => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'nome.max' => 'O nome não pode ter mais de 100 caracteres.',
            'valor.required' => 'O valor é obrigatório.',
            'valor.numeric' => 'O valor deve ser numérico.',
            'valor.min' => 'O valor não pode ser negativo.',
            'descricao.string' => 'A descrição deve ser um texto.',
        ]);

        Plano::findOrFail($id)->update($data);

        return redirect('plano')->with('success', 'Plano atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $plano = Plano::findOrFail($id);

        if ($plano->alunos()->exists()) {
            return redirect('plano')->with(
                'error',
                "Não é possível remover o plano $plano->nome, pois existem alunos associados a ele!"
            );
        }

        $plano->delete();

        return redirect('plano')->with('success', 'Plano removido com sucesso!');
    }

    public function search(Request $request)
    {
        $request->validate([
            'valor' => 'nullable|string|max:100',
        ]);

        $consulta = Plano::query();

        if ($request->filled('valor')) {
            $consulta->where('nome', 'like', '%' . $request->input('valor') . '%');
        }

        $dados = $consulta->orderBy('nome')->get();

        return view('plano.list', compact('dados'));
    }

    public function report()
    {
        $dados = Plano::withCount('alunos')->orderBy('nome')->get()->map(fn (Plano $plano) => [
            'nome' => $plano->nome,
            'valor' => 'R$ ' . number_format((float) $plano->valor, 2, ',', '.'),
            'descricao' => $plano->descricao,
            'alunos' => $plano->alunos_count,
        ]);

        return Pdf::loadView('relatorios.tabela', [
            'titulo' => 'Relatório de Planos',
            'data' => now()->format('d/m/Y'),
            'colunas' => [
                'nome' => 'Nome',
                'valor' => 'Valor',
                'descricao' => 'Descrição',
                'alunos' => 'Alunos',
            ],
            'dados' => $dados,
        ])->download('relatorio_planos.pdf');
    }
}
