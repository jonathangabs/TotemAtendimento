<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'enderecos';

    protected $fillable = [
<<<<<<< HEAD
        'paciente_id',
=======
        'pacientes_id',
>>>>>>> 2deb5b54f161ab5a70467eea16dcd98d18dc2924
        'cep',
        'logradouro',
        'numero',
        'bairro',
        'cidade'
    ];

    public $timestamps = false;
<<<<<<< HEAD

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}


=======
}
>>>>>>> 2deb5b54f161ab5a70467eea16dcd98d18dc2924
