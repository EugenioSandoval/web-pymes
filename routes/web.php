<?php

use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing')->name('inicio');
Route::post('/contacto', [LeadController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contacto');

// El demo del centro de salud se construye en el paso 3.
Route::view('/demo', 'demo-pronto')->name('demo');
