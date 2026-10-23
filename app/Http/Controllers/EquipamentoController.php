<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ManagesImages;
use App\Models\Equipamento;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EquipamentoController extends Controller
{
    use ManagesImages;

    public function index()
    {
        $dados = Equipamento::orderBy('nome')->get();

        return view('equipamento.list', compact('dados'));
    }

    public function create()
    {
        return view('equipamento.form', ['estados' => Equipamento::ESTADOS]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:120',
            'numero_serie' => 'required|string|max:100|unique:equipamentos,numero_serie',
            'estado' => ['required', 'string', Rule::in(Equipamento::ESTADOS)],
            'imagem' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $data['imagem'] = $this->storeImage($request, 'imagem/equipamento');
        Equipamento::create($data);

        return redirect('equipamento')->with('success', 'Equipamento salvo com sucesso!');
    }

    public function edit($id)
    {
        $data = Equipamento::findOrFail($id);

        return view('equipamento.form', [
            'data' => $data,
            'estados' => Equipamento::ESTADOS,
        ]);
    }

    public function update(Request $request, $id)
    {
        $equipamento = Equipamento::findOrFail($id);
        $data = $request->validate([
            'nome' => 'required|string|max:120',
            'numero_serie' => [
                'required',
                'string',
                'max:100',
                Rule::unique('equipamentos', 'numero_serie')->ignore($equipamento->id),
            ],
            'estado' => ['required', 'string', Rule::in(Equipamento::ESTADOS)],
            'imagem' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $imagemAnterior = $equipamento->imagem;
        $novaImagem = $this->storeImage($request, 'imagem/equipamento');
        if ($novaImagem) {
            $data['imagem'] = $novaImagem;
        }

        $equipamento->update($data);

        if ($novaImagem) {
            $this->deleteImage($imagemAnterior);
        }

        return redirect('equipamento')->with('success', 'Equipamento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $equipamento = Equipamento::findOrFail($id);
        $this->deleteImage($equipamento->imagem);
        $equipamento->delete();

        return redirect('equipamento')->with('success', 'Equipamento removido com sucesso!');
    }

    public function search(Request $request)
    {
        $data = $request->validate([
            'tipo' => ['required', 'string', Rule::in(['nome', 'numero_serie', 'estado'])],
            'valor' => 'nullable|string|max:100',
        ]);

        $consulta = Equipamento::query();
        if (!empty($data['valor'])) {
            $consulta->where($data['tipo'], 'like', '%' . $data['valor'] . '%');
        }
        $dados = $consulta->orderBy('nome')->get();

        return view('equipamento.list', compact('dados'));
    }

    public function report()
    {
        $dados = Equipamento::orderBy('nome')->get()->map(fn (Equipamento $equipamento) => [
            'nome' => $equipamento->nome,
            'numero_serie' => $equipamento->numero_serie,
            'estado' => $equipamento->estado,
        ]);

        return Pdf::loadView('relatorios.tabela', [
            'titulo' => 'Relatório de Equipamentos',
            'data' => now()->format('d/m/Y'),
            'colunas' => ['nome' => 'Nome', 'numero_serie' => 'Número de série', 'estado' => 'Estado'],
            'dados' => $dados,
        ])->download('relatorio_equipamentos.pdf');
    }
}
