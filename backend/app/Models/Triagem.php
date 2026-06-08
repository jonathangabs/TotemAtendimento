<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Triagem extends Model
{
    protected $table = 'triagens';

    protected $fillable = [
        'paciente_id',
        'queixa_principal',
        'sintomas',
        'duracao_sintomas',
        'intensidade_dor',
        'fatores_melhora',
        'fatores_piora',
        'historico_doenca_atual'
    ];

    public $timestamps = false;
}