<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'enderecos';

    protected $fillable = [
        'pacientes_id',
        'cep',
        'logradouro',
        'numero',
        'bairro',
        'cidade'
    ];

    public $timestamps = false;
}
