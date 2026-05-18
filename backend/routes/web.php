<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AtendimentoController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'index']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/painel', [AtendimentoController::class, 'painel'])->name('painel');
Route::get('/chamadas/historico', [AtendimentoController::class, 'historico'])->name('chamadas.historico');
Route::post('/atendimento/finalizar/{id}', [AtendimentoController::class, 'finalizar'])->name('atendimento.finalizar');

Route::get('/dashboard', function () {
    if (!session()->has('medico_id')) {
        return redirect('/login');
    }

    return 'Dashboard do médico';
});

Route::get('/teste', function () {
    return 'FUNCIONOU';
});

