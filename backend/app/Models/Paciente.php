<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'cpf',
        'rg',
        'telefone',
        'email',
        'genero',
        'estado_civil',
        'senha',
        'status'
    ];

    public $timestamps = false;

    public function endereco()
    {
        return $this->hasOne(Endereco::class);
    }
    
    public function informacaoMedica()
    {
        return $this->hasOne(InformacaoMedica::class);
    }
    
    public function atendimentos()
    {
        return $this->hasMany(Atendimento::class, 'paciente_id');
    }
}
