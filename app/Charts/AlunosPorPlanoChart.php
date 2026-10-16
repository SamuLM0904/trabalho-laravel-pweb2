<?php

namespace App\Charts;

use App\Models\Plano;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class AlunosPorPlanoChart
{
    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $planos = Plano::withCount('alunos')->orderBy('nome')->get();

        return (new LarapexChart)->pieChart()
            ->setTitle('Alunos por plano')
            ->setSubtitle('Quantidade de alunos em cada plano')
            ->addData($planos->isEmpty() ? [0] : $planos->pluck('alunos_count')->all())
            ->setLabels($planos->isEmpty() ? ['Sem planos cadastrados'] : $planos->pluck('nome')->all());
    }
}
