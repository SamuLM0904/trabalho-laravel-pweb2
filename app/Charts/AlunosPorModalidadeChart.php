<?php

namespace App\Charts;

use App\Models\Modalidade;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use ArielMejiaDev\LarapexCharts\PieChart;

class AlunosPorModalidadeChart
{
    public function build(): PieChart
    {
        $modalidades = Modalidade::withCount('alunos')->orderBy('nome')->get();

        return (new LarapexChart)->pieChart()
            ->setTitle('Alunos por modalidade')
            ->setSubtitle('Quantidade de alunos cadastrados em cada modalidade')
            ->addData($modalidades->isEmpty() ? [0] : $modalidades->pluck('alunos_count')->all())
            ->setLabels($modalidades->isEmpty() ? ['Sem modalidades cadastradas'] : $modalidades->pluck('nome')->all());
    }
}
