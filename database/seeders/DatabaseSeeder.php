<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            PlanoSeeder::class,
            ModalidadeSeeder::class,
            AlunoSeeder::class,
            EquipamentoSeeder::class,
        ]);

        User::firstOrCreate(
            ['email' => 'admin@academia.com'],
            [
                'name' => 'Administrador da Academia',
                'password' => Hash::make('password'),
            ]
        );
    }
}
