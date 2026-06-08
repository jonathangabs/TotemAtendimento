<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformacaoMedica extends Model
{
    protected $table = 'informacoes_medicas';

    protected $fillable = [
<<<<<<< HEAD
        'paciente_id',
=======
        'pacientes_id',
>>>>>>> 2deb5b54f161ab5a70467eea16dcd98d18dc2924
        'tipo_sanguineo',
        'plano_saude',
        'alergias',
        'doencas_pre_existentes',
        'medicamentos'
    ];

    public $timestamps = false;
<<<<<<< HEAD

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
=======
>>>>>>> 2deb5b54f161ab5a70467eea16dcd98d18dc2924
}
