<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
    protected $table = 'atendimentos';

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'consultorio',
        'status',
        'data_inicio',
        'data_fim'
    ];

    public $timestamps = false;

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }   

    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }
}
