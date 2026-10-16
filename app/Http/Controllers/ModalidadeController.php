<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ManagesImages;
use App\Models\Modalidade;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ModalidadeController extends Controller
{
    use ManagesImages;

    public function index()
    {
        $dados = Modalidade::orderBy('nome')->get();

        return view('modalidade.list', compact('dados'));
    }

    public function create()
    {
        return view('modalidade.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:100',
            'descricao' => 'nullable|string|max:2000',
            'imagem' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data['imagem'] = $this->storeImage($request, 'imagem/modalidade');
        Modalidade::create($data);

        return redirect('modalidade')->with('success', 'Modalidade salva com sucesso!');
    }

    public function edit($id)
    {
        $data = Modalidade::findOrFail($id);

        return view('modalidade.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:100',
            'descricao' => 'nullable|string|max:2000',
            'imagem' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $modalidade = Modalidade::findOrFail($id);
        $imagemAnterior = $modalidade->imagem;
        $novaImagem = $this->storeImage($request, 'imagem/modalidade');

        if ($novaImagem) {
            $data['imagem'] = $novaImagem;
        }

        $modalidade->update($data);

        if ($novaImagem) {
            $this->deleteImage($imagemAnterior);
        }

        return redirect('modalidade')->with('success', 'Modalidade atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $modalidade = Modalidade::findOrFail($id);
        $this->deleteImage($modalidade->imagem);
        $modalidade->delete();

        return redirect('modalidade')->with('success', 'Modalidade removida com sucesso!');
    }

    public function search(Request $request)
    {
        $data = $request->validate([
            'valor' => 'nullable|string|max:100',
        ]);

        $consulta = Modalidade::query();
        if (!empty($data['valor'])) {
            $consulta->where('nome', 'like', '%' . $data['valor'] . '%');
        }
        $dados = $consulta->orderBy('nome')->get();

        return view('modalidade.list', compact('dados'));
    }

    public function report()
    {
        $dados = Modalidade::orderBy('nome')->get()->map(fn (Modalidade $modalidade) => [
            'nome' => $modalidade->nome,
            'descricao' => $modalidade->descricao,
        ]);

        return Pdf::loadView('relatorios.tabela', [
            'titulo' => 'Relatório de Modalidades',
            'data' => now()->format('d/m/Y'),
            'colunas' => ['nome' => 'Nome', 'descricao' => 'Descrição'],
            'dados' => $dados,
        ])->download('relatorio_modalidades.pdf');
    }
}
