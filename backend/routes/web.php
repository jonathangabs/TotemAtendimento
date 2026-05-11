<?php

use App\Models\Paciente;

Route::get('/pacientes', function () {
    return Paciente::all();
});
