<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class QtdAlunoCursoChart
{
    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {

        $qtdAlunoPorCurso = DB::table('matriculas')
            ->join('cursos', 'cursos.id', '=', 'matriculas.curso_id')
            ->select('cursos.nome', DB::raw('count(1) as qtd_alunos'))
            ->groupBy('cursos.nome')
            ->orderBy('qtd_alunos', 'desc')
            ->get();

        $qtdAlunos = [];
        $nomeCursos = [];

        foreach ($qtdAlunoPorCurso as $item) {
            $nomeCursos[] = $item->nome;
            $qtdAlunos[] = $item->qtd_alunos;
        }

        return (new LarapexChart)->pieChart()
            ->setTitle('Alunos matriculados por curso')
            ->setSubtitle('Semestre 2026.2')
            ->addData($qtdAlunos)
            ->setLabels($nomeCursos);
    }
}
