<?php

use App\Models\Paciente;
use App\Models\Atendimento;
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
            'email' => 'nullable|email'
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

            Atendimento::create([
                'pacientes_id' => $paciente->id,
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