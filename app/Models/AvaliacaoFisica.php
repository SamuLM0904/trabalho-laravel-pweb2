<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvaliacaoFisica extends Model
{
    use HasFactory;

    protected $table = 'avaliacoes_fisicas';

    protected $fillable = [
        'aluno_id',
        'peso',
        'altura',
        'imc',
        'observacoes',
        'data_avaliacao',
    ];

    protected $casts = [
        'peso' => 'decimal:2',
        'altura' => 'decimal:2',
        'imc' => 'decimal:2',
        'data_avaliacao' => 'date',
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }
}
