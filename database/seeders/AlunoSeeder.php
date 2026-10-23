<?php

namespace Database\Seeders;

use App\Models\Aluno;
use App\Models\Modalidade;
use App\Models\Plano;
use Illuminate\Database\Seeder;

class AlunoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Aluno::factory()->count(5)->create([
            'plano_id' => Plano::query()->firstOrFail()->id,
            'modalidade_id' => Modalidade::query()->firstOrFail()->id,
        ]);
    }
}
