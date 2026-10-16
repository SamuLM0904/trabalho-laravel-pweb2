<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    use HasFactory;

    public const ESTADOS = ['Bom', 'Regular', 'Em manutenção'];

    protected $fillable = [
        'nome',
        'numero_serie',
        'estado',
        'imagem',
    ];
}
