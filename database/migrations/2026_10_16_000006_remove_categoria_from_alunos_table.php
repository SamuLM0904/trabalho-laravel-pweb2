<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('categoria_id');
        });

        Schema::dropIfExists('categoria_alunos');
    }

    public function down(): void
    {
        Schema::create('categoria_alunos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 80);
            $table->string('nivel', 40)->nullable();
            $table->timestamps();
        });

        Schema::table('alunos', function (Blueprint $table) {
            $table->foreignId('categoria_id')
                ->nullable()
                ->constrained('categoria_alunos')
                ->nullOnDelete();
        });
    }
};
