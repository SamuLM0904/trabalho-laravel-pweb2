<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use App\Models\Curso;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    public function index(Curso $curso)
    {
        $dados = $curso->turmas;

        return view('turma.list')->with([
            'dados' => $dados,
            'curso' => $curso,
        ]);
    }

    function create(Curso $curso)
    {
        return view('turma.form')->with(compact('curso'));
    }


    function validateForm(Request $request)
    {
        $request->validate([
            'nome' => 'required',
        ], [
            'nome.required' => "O :attribute é obrigatorio",
        ]);
    }

    function store(Request $request)
    {
        //dd($request->all());
        $this->validateForm($request);

        $data = $request->all();

        $turma = Turma::create($data);

        return redirect()->route('curso.turmas', $turma->curso_id)->with("success", 'Registro Salvo com sucesso!');
    }

    function edit($id)
    {
        $data = Turma::find($id);
        $curso = Curso::find($data->curso_id);

        // dd($categorias);
        return view('turma.form')->with(compact('data', 'curso'));
    }


    function update(Request $request, $id)
    {
        $this->validateForm($request);

        $data = $request->all();

        Turma::find($id)->update($data);

        return redirect()->route('curso.turmas', $request->curso_id)->with("success", 'Registro Atualizado com sucesso!');
    }

    function destroy($id)
    {
        $data = Turma::find($id);

        Turma::destroy($id);

        return redirect()->route('curso.turmas', $data->curso_id)->with("success", 'Registro removido com sucesso!');
    }

    public function search(Request $request)
    {
        //dd('teste');
        $curso = Turma::findOrFail($request->curso_id);

        if (!empty($request->valor)) {
            $dados = Turma::where(
                $request->tipo,
                'like',
                "%$request->valor%"
            )->get();
        } else {
            $dados = Turma::All();
        }

        return redirect()->route('curso.turmas', $request->curso_id)->with([
            'dados' => $dados,
            'curso' => $curso,
        ]);
    }
}
