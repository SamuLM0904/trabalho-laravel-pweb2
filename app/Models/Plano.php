<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plano extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'valor',
        'descricao',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
    ];

    public function alunos(): HasMany
    {
        return $this->hasMany(Aluno::class);
    }
}
