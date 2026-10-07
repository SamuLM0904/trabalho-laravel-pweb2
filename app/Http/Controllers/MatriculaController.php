<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Curso;
use App\Models\Turma;
use App\Models\Aluno;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    public function index()
    {
        $dados = Matricula::All();

        return view('matricula.list')->with(['dados' => $dados]);
    }

    function create()
    {
        $cursos = Curso::orderBy('nome')->get();
        $turmas = Turma::orderBy('nome')->get();
        $alunos = Aluno::orderBy('nome')->get();

        return view('matricula.form')->with(compact('cursos', 'turmas', 'alunos'));
    }


    function validateForm(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'turma_id' => 'required|exists:turmas,id',
            'aluno_id' => 'required|exists:alunos,id',
            'data_matricula' => 'required',
        ], [
            'curso_id.required' => "O :attribute é obrigatorio",
            'turma_id.required' => "O :attribute é obrigatorio",
            'aluno_id.required' => "O :attribute é obrigatorio",
            'data_matricula.required' => "O :attribute é obrigatorio",
        ]);
    }

    function store(Request $request)
    {
        //dd($request->all());
        $this->validateForm($request);

        $data = $request->all();

        Matricula::create($data);

        return redirect('matricula')->with("success", 'Registro Salvo com sucesso!');
    }

    function edit($id)
    {
        $data = Matricula::find($id);
        $cursos = Curso::orderBy('nome')->get();
        $turmas = Turma::orderBy('nome')->get();
        $alunos = Aluno::orderBy('nome')->get();

        // dd($categorias);
        return view('matricula.form')->with(compact('data', 'cursos', 'turmas', 'alunos'));
    }


    function update(Request $request, $id)
    {
        //dd($request->all());
        $this->validateForm($request);

        $data = $request->all();

        Matricula::find($id)->update($data);

        return redirect('matricula')->with("success", 'Registro Atualizado com sucesso!');
    }

    function destroy($id)
    {
        Matricula::destroy($id);

        return redirect('matricula')->with("success", 'Registro removido com sucesso!');
    }

    public function search(Request $request)
    {
        if (!empty($request->valor)) {
            $query = Matricula::with(['curso', 'turma', 'aluno']);

            $valor = $request->valor;

            $dados = $query->whereHas(
                $request->tipo,
                function ($q) use ($valor) {
                    $q->where('nome', 'like', "%$valor%");
                }
            )->get();
        } else {
            $dados = Matricula::All();
        }

        return view('matricula.list', compact('dados'));
    }
}
