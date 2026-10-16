<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Aluno;
use App\Models\CategoriaAluno;
use App\Models\Plano;
use App\Http\Controllers\Concerns\ManagesImages;
use Barryvdh\DomPDF\Facade\Pdf;

class AlunoController extends Controller
{
    use ManagesImages;

    public function index()
    {
        $dados = Aluno::with(['categoria', 'plano', 'avaliacaoFisica'])->orderBy('nome')->get();

        return view('aluno.list')->with(['dados' => $dados]);
    }

    function create()
    {
        $categorias = CategoriaAluno::orderBy('nome')->get();
        $planos = Plano::orderBy('nome')->get();

        return view('aluno.form')->with(compact('categorias', 'planos'));
    }


    function validateForm(Request $request, ?int $alunoId = null): array
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
            'categoria_id' => 'required|exists:categoria_alunos,id',
            'plano_id' => 'required|exists:planos,id',
            'imagem' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.unique' => 'Já existe um aluno cadastrado com este CPF.',
            'categoria_id.required' => 'A categoria é obrigatória.',
            'categoria_id.exists' => 'A categoria selecionada não existe.',
            'plano_id.required' => 'O plano é obrigatório.',
            'plano_id.exists' => 'O plano selecionado não existe.',
            'imagem.image' => 'O arquivo enviado deve ser uma imagem.',
            'imagem.mimes' => 'A imagem deve estar no formato PNG, JPEG ou JPG.',
            'imagem.max' => 'A imagem não pode ter mais de 2 MB.',
        ]);
    }

    function store(Request $request)
    {
        $data = $this->validateForm($request);
        $data['imagem'] = $this->storeImage($request, 'imagem/aluno');

        Aluno::create($data);

        return redirect('aluno')->with('success', 'Aluno salvo com sucesso!');
    }

    function edit($id)
    {
        $data = Aluno::findOrFail($id);
        $categorias = CategoriaAluno::orderBy('nome')->get();
        $planos = Plano::orderBy('nome')->get();

        // dd($categorias);
        return view('aluno.form')->with(compact('data', 'categorias', 'planos'));
    }


    function update(Request $request, $id)
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

    function destroy($id)
    {
        $aluno = Aluno::with('matriculas')->findOrFail($id);
        if ($aluno->matriculas->isNotEmpty()) {
            return redirect('aluno')->with(
                'error',
                "Não é possível remover o aluno $aluno->nome, pois existem matrículas associadas a ele."
            );
        }

        $this->deleteImage($aluno->imagem);
        $aluno->delete();

        return redirect('aluno')->with('success', 'Aluno removido com sucesso!');
    }

    public function search(Request $request)
    {
        $data = $request->validate([
            'tipo' => ['required', 'string', Rule::in(['nome', 'cpf', 'telefone', 'plano'])],
            'valor' => 'nullable|string|max:150',
        ]);

        $consulta = Aluno::with(['categoria', 'plano', 'avaliacaoFisica']);
        if (!empty($data['valor'])) {
            if ($data['tipo'] === 'plano') {
                $consulta->whereHas('plano', function ($query) use ($data) {
                    $query->where('nome', 'like', '%' . $data['valor'] . '%');
                });
            } else {
                $consulta->where($data['tipo'], 'like', '%' . $data['valor'] . '%');
            }
        }
        $dados = $consulta->orderBy('nome')->get();

        return view('aluno.list', compact('dados'));
    }

    public function report()
    {
        $dados = Aluno::with(['categoria', 'plano'])->orderBy('nome')->get()->map(fn (Aluno $aluno) => [
            'nome' => $aluno->nome,
            'cpf' => $aluno->cpf,
            'telefone' => $aluno->telefone,
            'categoria' => $aluno->categoria->nome ?? '',
            'plano' => $aluno->plano->nome ?? 'Sem plano',
        ]);

        return Pdf::loadView('relatorios.tabela', [
            'titulo' => 'Relatório de Alunos',
            'data' => now()->format('d/m/Y'),
            'colunas' => [
                'nome' => 'Nome',
                'cpf' => 'CPF',
                'telefone' => 'Telefone',
                'categoria' => 'Categoria',
                'plano' => 'Plano',
            ],
            'dados' => $dados,
        ])->download('relatorio_alunos.pdf');
    }
}
