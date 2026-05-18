<?php
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/dashboard', function () {
    if (!session()->has('medico_id')) {
        return redirect('/login');
    }

    return 'Dashboard do médico';
});