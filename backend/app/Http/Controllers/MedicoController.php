<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedicoController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Controller de médicos funcionando'
        ], 200);
    }
}