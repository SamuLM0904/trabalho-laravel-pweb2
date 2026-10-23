<?php

namespace Database\Seeders;

use App\Models\Plano;
use Illuminate\Database\Seeder;

class PlanoSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['nome' => 'Mensal', 'valor' => 119.90, 'descricao' => 'Acesso mensal à academia.'],
            ['nome' => 'Trimestral', 'valor' => 319.90, 'descricao' => 'Acesso por três meses.'],
            ['nome' => 'Anual', 'valor' => 999.90, 'descricao' => 'Acesso por doze meses.'],
        ] as $dados) {
            Plano::firstOrCreate(['nome' => $dados['nome']], $dados);
        }
    }
}
