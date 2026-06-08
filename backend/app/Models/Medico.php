<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medicos';

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'crm',
        'especialidade',
        'telefone',
        'ativo'
    ];

    public $timestamps = false;
}
