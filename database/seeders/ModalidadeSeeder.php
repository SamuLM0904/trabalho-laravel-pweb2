<?php

namespace Database\Seeders;

use App\Models\Modalidade;
use Illuminate\Database\Seeder;

class ModalidadeSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['nome' => 'Musculação', 'descricao' => 'Treinamento de força com pesos e aparelhos.'],
            ['nome' => 'Pilates', 'descricao' => 'Exercícios de mobilidade, força e postura.'],
            ['nome' => 'Dança', 'descricao' => 'Aulas coletivas de dança e condicionamento.'],
        ] as $dados) {
            Modalidade::firstOrCreate(['nome' => $dados['nome']], $dados);
        }
    }
}
