<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('matriculas');
        Schema::dropIfExists('turmas');
        Schema::dropIfExists('cursos');
    }

    public function down(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150);
            $table->string('requisito', 100)->nullable();
            $table->decimal('carga_horaria', 8, 2)->nullable();
            $table->decimal('valor', 10, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('turmas', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150);
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->string('codigo', 20)->nullable();
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->timestamps();
        });

        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 50);
            $table->foreignId('curso_id')->constrained('cursos');
            $table->foreignId('turma_id')->constrained('turmas');
            $table->foreignId('aluno_id')->constrained('alunos');
            $table->date('data_matricula');
            $table->timestamps();
        });
    }
};
