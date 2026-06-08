<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
    protected $table = 'atendimentos';

    protected $fillable = [
<<<<<<< HEAD
        'paciente_id',
=======
        'pacientes_id',
>>>>>>> 2deb5b54f161ab5a70467eea16dcd98d18dc2924
        'medico_id',
        'consultorio',
        'status',
        'data_inicio',
        'data_fim'
    ];

    public $timestamps = false;

    public function paciente()
    {
<<<<<<< HEAD
        return $this->belongsTo(Paciente::class, 'paciente_id');
=======
        return $this->belongsTo(Paciente::class, 'pacientes_id');
>>>>>>> 2deb5b54f161ab5a70467eea16dcd98d18dc2924
    }   

    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }
}
