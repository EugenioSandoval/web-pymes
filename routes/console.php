<?php

use Database\Seeders\DemoClinicaSeeder;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Schema;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Borra y vuelve a crear los datos del demo del centro de salud (no toca los contactos de la página de venta).
Artisan::command('demo:reset', function () {
    Schema::disableForeignKeyConstraints();
    foreach (['cotizacion_items', 'cotizaciones', 'citas', 'pacientes', 'profesional_servicio', 'servicios', 'profesionales'] as $tabla) {
        DB::table($tabla)->truncate();
    }
    Schema::enableForeignKeyConstraints();
    $this->call('db:seed', ['--class' => DemoClinicaSeeder::class, '--force' => true]);
    $this->info('Demo reiniciado.');
})->purpose('Reinicia los datos del demo del centro de salud');

// Cada noche se limpia lo que los visitantes cambiaron en el demo.
Schedule::command('demo:reset')->dailyAt('04:00');
