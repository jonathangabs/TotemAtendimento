<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Atendimento;
use App\Models\Endereco;
use App\Models\InformacaoMedica;
use App\Models\Triagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PacienteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
        'nome' => 'required|max:100',
        'cpf' => 'required|unique:pacientes',
        'telefone' => 'required',
        'email' => 'nullable|email',
        'cep' => 'required',
        'logradouro' => 'required',
        'numero' => 'required',
        'bairro' => 'required',
        'cidade' => 'required'
    ]);

        $paciente = DB::transaction(function () use ($request) {

            $ultimaSenha = Paciente::lockForUpdate()->max('senha') ?? 0;
            $novaSenha = $ultimaSenha + 1;

            $paciente = Paciente::create([
                'nome' => $request->nome,
                'data_nascimento' => $request->data_nascimento,
                'cpf' => $request->cpf,
                'rg' => $request->rg,
                'telefone' => $request->telefone,
                'email' => $request->email,
                'genero' => $request->genero,
                'estado_civil' => $request->estado_civil,
                'senha' => $novaSenha,
                'status' => 'aguardando'
            ]);

            Endereco::create([
                'paciente_id' => $paciente->id,
                'cep' => $request->cep,
                'logradouro' => $request->logradouro,
                'numero' => $request->numero,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade
            ]);

            InformacaoMedica::create([
                'paciente_id' => $paciente->id,
                'tipo_sanguineo' => $request->tipo_sanguineo,
                'plano_saude' => $request->plano_saude,
                'alergias' => $request->alergias,
                'doencas_pre_existentes' => $request->doencas_pre_existentes,
                'medicamentos' => $request->medicamentos
            ]);

            Triagem::create([
                'paciente_id' => $paciente->id,
                'queixa_principal' => $request->queixa_principal,
                'sintomas' => $request->sintomas,
                'duracao_sintomas' => $request->duracao_sintomas,
                'intensidade_dor' => $request->intensidade_dor,
                'fatores_melhora' => $request->fatores_melhora,
                'fatores_piora' => $request->fatores_piora,
                'historico_doenca_atual' => $request->historico_doenca_atual
            ]);

            Atendimento::create([
                'paciente_id' => $paciente->id,
                'medico_id' => null,
                'status' => 'aguardando',
                'data_inicio' => now()
            ]);

            $paciente->novaSenha = $novaSenha;

            return $paciente;
        });

        return response()->json([
            'message' => 'Paciente cadastrado com sucesso',
            'senha' => $paciente->novaSenha,
            'paciente' => $paciente
        ], 201);
    }
}