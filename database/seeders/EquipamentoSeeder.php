<?php

namespace Database\Seeders;

use App\Models\Equipamento;
use Illuminate\Database\Seeder;

class EquipamentoSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['nome' => 'Esteira', 'numero_serie' => 'EST-001', 'estado' => 'Bom'],
            ['nome' => 'Bicicleta ergométrica', 'numero_serie' => 'BIC-001', 'estado' => 'Bom'],
            ['nome' => 'Leg press', 'numero_serie' => 'LEG-001', 'estado' => 'Regular'],
        ] as $dados) {
            Equipamento::firstOrCreate(['numero_serie' => $dados['numero_serie']], $dados);
        }
    }
}
