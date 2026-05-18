<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AtendimentoController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Controller de atendimentos funcionando'
        ], 200);
    }
}