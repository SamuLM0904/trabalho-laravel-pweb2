<?php

namespace App\Charts;

use App\Models\Aluno;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use ArielMejiaDev\LarapexCharts\LineChart;

class NovosAlunosPorMesChart
{
    public function build(): LineChart
    {
        $inicio = now()->startOfMonth()->subMonths(11);
        $alunosPorMes = Aluno::query()
            ->where('created_at', '>=', $inicio)
            ->get(['created_at'])
            ->groupBy(fn (Aluno $aluno) => $aluno->created_at->format('Y-m'));

        $meses = collect(range(0, 11))->map(fn (int $offset) => $inicio->copy()->addMonths($offset));
        $rotulos = $meses->map(fn ($mes) => $mes->translatedFormat('M/Y'))->all();
        $quantidades = $meses->map(
            fn ($mes) => $alunosPorMes->get($mes->format('Y-m'), collect())->count()
        )->all();

        return (new LarapexChart)->lineChart()
            ->setTitle('Novos alunos por mês')
            ->setSubtitle('Cadastros realizados nos últimos 12 meses')
            ->addData($quantidades, 'Novos alunos')
            ->setXAxis($rotulos);
    }
}
