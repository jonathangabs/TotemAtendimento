<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformacaoMedica extends Model
{
    protected $table = 'informacoes_medicas';

    protected $fillable = [
        'paciente_id',
        'tipo_sanguineo',
        'plano_saude',
        'alergias',
        'doencas_pre_existentes',
        'medicamentos'
    ];

    public $timestamps = false;

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}
