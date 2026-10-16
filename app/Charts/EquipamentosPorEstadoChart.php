<?php

namespace App\Charts;

use App\Models\Equipamento;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class EquipamentosPorEstadoChart
{
    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $estados = Equipamento::query()
            ->select('estado', DB::raw('count(*) as quantidade'))
            ->groupBy('estado')
            ->orderBy('estado')
            ->get();

        return (new LarapexChart)->pieChart()
            ->setTitle('Equipamentos por estado')
            ->setSubtitle('Estado de conservação')
            ->addData($estados->isEmpty() ? [0] : $estados->pluck('quantidade')->all())
            ->setLabels($estados->isEmpty() ? ['Sem equipamentos cadastrados'] : $estados->pluck('estado')->all());
    }
}
