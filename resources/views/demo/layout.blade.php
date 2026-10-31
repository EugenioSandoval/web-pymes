<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Centro Kine Ñuble') · Demo</title>
    <meta name="robots" content="noindex">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-800 antialiased">
    {{-- Franja que recuerda que esto es un demo --}}
    <div class="bg-marca-900 px-4 py-2 text-center text-sm text-marca-100">
        Demo de <a href="{{ route('inicio') }}" class="font-semibold text-white underline">{{ config('negocio.nombre') }}</a>: un centro de salud ficticio.
        <a href="{{ url('demo/panel') }}" class="ml-1 font-semibold text-acento hover:underline">Ver el panel de gestión →</a>
    </div>

    <header class="border-b border-slate-100">
        <nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
            <a href="{{ route('demo') }}" class="flex items-center gap-2 text-lg font-bold text-marca-900">
                <span class="grid size-9 place-items-center rounded-full bg-marca-500 text-white">
                    <x-icono nombre="salud" class="size-5" />
                </span>
                Centro Kine Ñuble
            </a>
            <div class="flex items-center gap-5 text-sm">
                <a href="{{ route('demo') }}#servicios" class="hidden text-slate-600 hover:text-marca-700 sm:inline">Servicios</a>
                <a href="{{ route('demo') }}#equipo" class="hidden text-slate-600 hover:text-marca-700 sm:inline">Equipo</a>
                <a href="{{ route('demo.reservar') }}" class="rounded-full bg-marca-600 px-4 py-2 font-semibold text-white hover:bg-marca-700">Reservar hora</a>
            </div>
        </nav>
    </header>

    @yield('contenido')

    <footer class="mt-20 bg-slate-50 py-10 text-sm text-slate-500">
        <div class="mx-auto grid max-w-6xl gap-6 px-4 sm:grid-cols-3">
            <div><p class="font-semibold text-marca-900">Centro Kine Ñuble</p><p>Av. Libertad 123, Chillán (dirección ficticia)</p></div>
            <div><p class="font-semibold text-marca-900">Horario</p><p>Lunes a viernes, 09:00 a 18:30</p></div>
            <div><p class="font-semibold text-marca-900">Contacto</p><p>+56 9 0000 0000 · contacto@centrokine.cl</p></div>
        </div>
    </footer>
</body>
</html>
