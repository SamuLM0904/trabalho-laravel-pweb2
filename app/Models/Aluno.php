<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
        'imagem',
        'categoria_id',
        'plano_id',
    ];

    protected $casts = [
        'categoria_id' => 'integer',
        'plano_id' => 'integer',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaAluno::class, 'categoria_id');
    }

    public function plano()
    {
        return $this->belongsTo(Plano::class);
    }

    public function avaliacaoFisica()
    {
        return $this->hasOne(AvaliacaoFisica::class);
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }
}
