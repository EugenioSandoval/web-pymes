@extends('layouts.app')

@section('titulo', 'Demo | '.config('negocio.nombre'))

@section('contenido')
<main class="grid min-h-screen place-items-center bg-marca-50 px-4">
    <div class="max-w-md text-center">
        <h1 class="text-3xl font-bold text-marca-900">El demo viene pronto</h1>
        <p class="mt-3 text-slate-600">Estamos preparando un centro de salud de ejemplo con su web y su panel de gestión. Mientras tanto, conversemos.</p>
        <a href="{{ route('inicio') }}#contacto" class="mt-6 inline-block rounded-lg bg-marca-600 px-6 py-3 font-semibold text-white hover:bg-marca-700">Pedir una reunión</a>
    </div>
</main>
@endsection
