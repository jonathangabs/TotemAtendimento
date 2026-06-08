<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\AtendimentoController;
<<<<<<< HEAD
use App\Http\Controllers\PacienteController;

Route::post('/login', [AuthController::class, 'login']);
Route::get('/medicos', [MedicoController::class, 'index']);
Route::get('/atendimentos', [AtendimentoController::class, 'index']);
Route::post('/pacientes', [PacienteController::class, 'store']);
=======

Route::post('/login', [AuthController::class, 'login']);
Route::get('/medicos', [MedicoController::class, 'index']);
Route::get('/atendimentos', [AtendimentoController::class, 'index']);
>>>>>>> 2deb5b54f161ab5a70467eea16dcd98d18dc2924
