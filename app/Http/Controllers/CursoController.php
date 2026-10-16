<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Charts\CursoChart;
use App\Charts\QtdAlunoCursoChart;

class CursoController extends Controller
{
    public function index()
    {
        $dados = Curso::All();

        return view('curso.list')->with(['dados' => $dados]);
    }

    function create()
    {
        return view('curso.form');
    }


    function validateForm(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'requisito' => 'nullable|string',
            'carga_horaria' => 'nullable|numeric',
            'valor' => 'nullable|numeric',
        ], [
            'nome.required' => "O :attribute é obrigatorio",
            'requisito.string' => "O :attribute deve ser caracter",
            'carga_horaria.numeric' => "O :attribute deve ser númerico",
            'valor.numeric' => "O :attribute deve ser númerico",
        ]);
    }

    function store(Request $request)
    {
        //dd($request->all());
        $this->validateForm($request);

        $data = $request->all();

        Curso::create($data);

        return redirect('curso')->with("success", 'Registro Salvo com sucesso!');
    }

    function edit($id)
    {
        $data = Curso::find($id);

        // dd($categorias);
        return view('curso.form')->with(compact('data'));
    }

    function update(Request $request, $id)
    {
        //dd($request->all());
        $this->validateForm($request);

        $data = $request->all();

        Curso::find($id)->update($data);

        return redirect('curso')->with("success", 'Registro Atualizado com sucesso!');
    }

    function destroy($id)
    {
        $curso = Curso::findOrFail($id);
        // dd($curso->matriculas->count());

        if ($curso->matriculas->count() > 0) {
            return redirect('curso')->with("error", "Não é possível remover o
                    curso $curso->nome, pois existem dados associados a ele!");
        }
        Curso::destroy($id);

        return redirect('curso')->with("success", 'Registro removido com sucesso!');
    }

    public function search(Request $request)
    {
        if (!empty($request->valor)) {
            $dados = Curso::where(
                $request->tipo,
                'like',
                "%$request->valor%"
            )->get();
        } else {
            $dados = Curso::All();
        }

        return view('curso.list', compact('dados'));
    }

    public function report()
    {
        $curso = Curso::orderBy('nome')->get();

        $data = [
            'titulo' => 'Relatório Listagem de Cursos',
            'date' => date('m/d/Y'),
            'dados' => $curso
        ];

        $pdf = Pdf::loadView('curso.report', $data);

        return $pdf->download('relatorio_cursos.pdf');
    }


    public function reportMatriculados()
    {
        $curso = Curso::with('alunos.categoria')->orderBy('id')->get();

        $data = [
            'titulo' => 'Relatório Matriculados por Cursos',
            'date' => date('m/d/Y'),
            'dados' => $curso
        ];

        $pdf = Pdf::loadView('curso.reportMatriculados', $data);

        return $pdf->download('relatorio_alunos_matriculados_cursos.pdf');
    }

    public function chart(CursoChart $chart)
    {
        return view('curso.chart', ['chart' => $chart->build()]);
    }

    public function chartQtdAlunoCurso(QtdAlunoCursoChart $chart)
    {
        return view('curso.qtdAlunoCursoChart', ['chart' => $chart->build()]);
    }
}
