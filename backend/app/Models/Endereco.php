<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'enderecos';

    protected $fillable = [
        'paciente_id',
        'cep',
        'logradouro',
        'numero',
        'bairro',
        'cidade'
    ];

    public $timestamps = false;

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}


