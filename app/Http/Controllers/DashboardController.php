<?php

namespace App\Http\Controllers;

use App\Charts\AlunosPorModalidadeChart;
use App\Charts\NovosAlunosPorMesChart;
use App\Models\Aluno;
use App\Models\AvaliacaoFisica;
use App\Models\Equipamento;
use App\Models\Modalidade;
use App\Models\Plano;

class DashboardController extends Controller
{
    public function index(AlunosPorModalidadeChart $alunosPorModalidade, NovosAlunosPorMesChart $novosAlunosPorMes)    {
        $totais = [
            'alunos' => Aluno::count(),
            'planos' => Plano::count(),
            'modalidades' => Modalidade::count(),
            'avaliacoes' => AvaliacaoFisica::count(),
            'equipamentos' => Equipamento::count(),
        ];

        return view('dashboard', [
            'totais' => $totais,
            'alunosPorModalidade' => $alunosPorModalidade->build(),
            'novosAlunosPorMes' => $novosAlunosPorMes->build(),
        ]);
    }
}
