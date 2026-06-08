<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\AtendimentoController;
use App\Http\Controllers\PacienteController;

Route::post('/login', [AuthController::class, 'login']);
Route::get('/medicos', [MedicoController::class, 'index']);
Route::get('/atendimentos', [AtendimentoController::class, 'index']);
Route::post('/pacientes', [PacienteController::class, 'store']);