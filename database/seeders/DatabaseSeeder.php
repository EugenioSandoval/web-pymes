<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario administrador para ver los contactos de la página de venta (/admin).
        // Define ADMIN_EMAIL y ADMIN_PASSWORD en el .env antes de ejecutar el seeder.
        if (env('ADMIN_EMAIL') && env('ADMIN_PASSWORD')) {
            User::updateOrCreate(
                ['email' => env('ADMIN_EMAIL')],
                ['name' => 'Administrador', 'rol' => 'admin', 'password' => env('ADMIN_PASSWORD')],
            );
        }

        $this->call(DemoClinicaSeeder::class);
    }
}
