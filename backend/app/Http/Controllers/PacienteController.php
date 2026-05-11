<?php

class PacienteController extends Controller
{
    public function store (Request $request)
    {
        $request->validate([
            'nome' => 'required|max:100',
            'cpf' => 'required|unique:pacientes',
            'telefone' => 'required',
            'email' => 'nullable|email'
        ]);

        $ultimaSenha = Paciente::max('senha') ?? 0;
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

        return response()->json([
            'message' => 'Paciente cadastrado com sucesso',
            'senha' => $novaSenha,
            'paciente' => $paciente
        ], 201);
    }
}
