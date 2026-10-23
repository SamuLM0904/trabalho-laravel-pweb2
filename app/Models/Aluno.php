<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
        'email',
        'endereco',
        'data_nascimento',
        'ativo',
        'imagem',
        'plano_id',
        'modalidade_id',
    ];

    protected $casts = [
        'plano_id' => 'integer',
        'modalidade_id' => 'integer',
        'data_nascimento' => 'date',
        'ativo' => 'boolean',
    ];

    public function getCpfAttribute(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $digitos = preg_replace('/\D/', '', $value);

        if (strlen($digitos) !== 11) {
            return $value;
        }

        return substr($digitos, 0, 3).'.'.substr($digitos, 3, 3).'.'.substr($digitos, 6, 3).'-'.substr($digitos, 9, 2);
    }

    public function getTelefoneAttribute(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $digitos = preg_replace('/\D/', '', $value);
        $quantidade = strlen($digitos);

        if (! in_array($quantidade, [10, 11], true)) {
            return $value;
        }

        $ddd = substr($digitos, 0, 2);
        $numero = substr($digitos, 2);
        $separador = $quantidade === 11 ? 5 : 4;

        return '('.$ddd.') '.substr($numero, 0, $separador).'-'.substr($numero, $separador);
    }

    public function plano()
    {
        return $this->belongsTo(Plano::class);
    }

    public function modalidade()
    {
        return $this->belongsTo(Modalidade::class);
    }

    public function avaliacaoFisica()
    {
        return $this->hasOne(AvaliacaoFisica::class);
    }

}
