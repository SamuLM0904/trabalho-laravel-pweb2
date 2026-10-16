<?php

namespace App\Http\Controllers;

use App\Charts\AlunosPorPlanoChart;
use App\Charts\EquipamentosPorEstadoChart;
use App\Models\Aluno;
use App\Models\AvaliacaoFisica;
use App\Models\Equipamento;
use App\Models\Modalidade;
use App\Models\Plano;

class DashboardController extends Controller
{
    public function index(AlunosPorPlanoChart $alunosPorPlano, EquipamentosPorEstadoChart $equipamentosPorEstado)
    {
        $totais = [
            'alunos' => Aluno::count(),
            'planos' => Plano::count(),
            'modalidades' => Modalidade::count(),
            'avaliacoes' => AvaliacaoFisica::count(),
            'equipamentos' => Equipamento::count(),
        ];

        return view('dashboard', [
            'totais' => $totais,
            'alunosPorPlano' => $alunosPorPlano->build(),
            'equipamentosPorEstado' => $equipamentosPorEstado->build(),
        ]);
    }
}
