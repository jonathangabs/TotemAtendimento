<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformacaoMedica extends Model
{
    protected $table = 'informacoes_medicas';

    protected $fillable = [
        'pacientes_id',
        'tipo_sanguineo',
        'plano_saude',
        'alergias',
        'doencas_pre_existentes',
        'medicamentos'
    ];

    public $timestamps = false;
}
