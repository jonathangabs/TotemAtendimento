<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medico;

class AuthController extends Controller
{
public function login(Request $request)
{
    try {

        $medico = Medico::where('email', $request->email)
            ->where('senha', $request->senha)
            ->first();

        if (!$medico) {

            return response()->json([
                'success' => false,
                'message' => 'Credenciais inválidas'
            ], 401);
        }

        session([
            'medico_id' => $medico->id,
            'medico_nome' => $medico->nome
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Login realizado com sucesso',
            'medico' => $medico
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => 'Erro interno do servidor',
            'error' => $e->getMessage()
        ], 500);
    }
}
}