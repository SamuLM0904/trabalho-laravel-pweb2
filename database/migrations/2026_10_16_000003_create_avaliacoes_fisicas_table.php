<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avaliacoes_fisicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->unique()->constrained('alunos')->cascadeOnDelete();
            $table->decimal('peso', 5, 2);
            $table->decimal('altura', 3, 2);
            $table->decimal('imc', 6, 2);
            $table->text('observacoes')->nullable();
            $table->date('data_avaliacao');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avaliacoes_fisicas');
    }
};
