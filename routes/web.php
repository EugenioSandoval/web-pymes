<?php

use App\Http\Controllers\DemoClinicaController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

// Página de venta
Route::view('/', 'landing')->name('inicio');
Route::post('/contacto', [LeadController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contacto');

// Demo: web pública del "Centro Kine Ñuble". Su panel de gestión está en /demo/panel (Filament).
Route::prefix('demo')->controller(DemoClinicaController::class)->group(function () {
    Route::get('/', 'inicio')->name('demo');
    Route::get('/reservar', 'reservar')->name('demo.reservar');
    Route::post('/reservar', 'guardarReserva')->middleware('throttle:10,1')->name('demo.reservar.guardar');
    Route::get('/reserva/{cita}', 'reservaLista')->name('demo.reserva-lista');
    Route::get('/especialidades/{slug}', 'especialidad')->name('demo.especialidad');
    Route::get('/equipo/{profesional}', 'profesional')->name('demo.profesional');
    Route::get('/presupuesto', 'presupuesto')->name('demo.presupuesto');
    Route::post('/presupuesto', 'guardarPresupuesto')->middleware('throttle:10,1')->name('demo.presupuesto.guardar');
    Route::get('/panel/cotizaciones/{cotizacion}/imprimir', 'imprimirCotizacion')
        ->middleware('auth')
        ->name('clinica.cotizacion.imprimir');
});
