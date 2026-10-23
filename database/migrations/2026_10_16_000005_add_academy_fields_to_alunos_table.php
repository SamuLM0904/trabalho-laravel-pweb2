<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->string('email')->nullable()->unique();
            $table->string('endereco')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->boolean('ativo')->default(true);
            $table->foreignId('modalidade_id')
                ->nullable()
                ->constrained('modalidades')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('modalidade_id');
            $table->dropUnique(['email']);
            $table->dropColumn(['email', 'endereco', 'data_nascimento', 'ativo']);
        });
    }
};
