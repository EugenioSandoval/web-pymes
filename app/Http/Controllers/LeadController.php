<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'negocio' => ['nullable', 'string', 'max:120'],
            'rubro' => ['nullable', 'string', 'max:60'],
            'paquete' => ['nullable', 'string', 'max:60'],
            'telefono' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:120'],
            'mensaje' => ['nullable', 'string', 'max:2000'],
        ], [], [
            'nombre' => 'nombre',
            'telefono' => 'teléfono',
            'email' => 'correo',
        ]);

        Lead::create($datos);

        return redirect()->to(route('inicio').'#contacto')
            ->with('ok', '¡Gracias! Te contactaremos dentro de 24 horas hábiles.');
    }
}
