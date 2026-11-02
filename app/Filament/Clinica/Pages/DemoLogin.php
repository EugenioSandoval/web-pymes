<?php

namespace App\Filament\Clinica\Pages;

use Filament\Auth\Pages\Login;
use Illuminate\Contracts\Support\Htmlable;

/** Login del demo: deja el usuario y la clave de prueba ya escritos. */
class DemoLogin extends Login
{
    public function mount(): void
    {
        parent::mount();

        $this->form->fill([
            'email' => 'demo@centrokine.cl',
            'password' => 'demo1234',
            'remember' => true,
        ]);
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Demo: los datos de acceso ya están escritos, solo presiona Entrar.';
    }
}
