<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medico;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $medico = Medico::where('email', $request->email)
            ->where('senha', $request->senha)
            ->first();

            if (!$medico) {
                return back()->with('erro', 'Credenciais inválidas');
            }

            session([
                'medico_id' => $medico->id,
                'medico_nome' =>$medico->nome
            ]);

            return redirect('/dashboard');
    }
        
        public function logout()
        {
            session()->flush();

            return redirect('/login');
        }
}

