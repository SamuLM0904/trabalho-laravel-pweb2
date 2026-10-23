<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AlunoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'cpf' => fake()->numerify('###.###.###-##'),
            'telefone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'endereco' => fake()->streetAddress().', '.fake()->city(),
            'data_nascimento' => fake()->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d'),
        ];
    }
}
