@php
    $centro = config('demo.centro');
    $especialidades = config('demo.especialidades');
@endphp
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Kinesiología, nutrición y psicología en Chillán') · {{ $centro['nombre'] }}</title>
    <meta name="robots" content="noindex">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-800 antialiased">
    {{-- Franja que recuerda que esto es un demo --}}
    <div class="bg-slate-900 px-4 py-2 text-center text-sm text-slate-300">
        Demo de <a href="{{ route('inicio') }}" class="font-semibold text-white underline">{{ config('negocio.nombre') }}</a>: un centro de salud ficticio.
        <a href="{{ url('demo/panel') }}" class="ml-1 font-semibold text-acento hover:underline">Ver el panel de gestión →</a>
    </div>

    {{-- Barra de contacto --}}
    <div class="hidden bg-marca-900 text-sm text-marca-100 md:block">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-2">
            <div class="flex items-center gap-6">
                <span class="flex items-center gap-1.5"><x-icono nombre="calendario" class="size-4" />Lun a vie {{ $centro['horario'][0][1] }} · Sáb {{ \Illuminate\Support\Str::before($centro['horario'][1][1], ' (') }}</span>
                <span>{{ $centro['direccion'] }}</span>
            </div>
            <div class="flex items-center gap-6">
                <span class="flex items-center gap-1.5"><x-icono nombre="whatsapp" class="size-4" />{{ $centro['telefono'] }}</span>
                <span class="rounded-full bg-marca-700 px-2.5 py-0.5 text-xs font-semibold text-white">Fonasa · Isapres · Particular</span>
            </div>
        </div>
    </div>

    <header class="sticky top-0 z-40 border-b border-slate-100 bg-white/95 backdrop-blur">
        <nav class="mx-auto flex max-w-6xl items-center justify-between gap-3 px-4 py-3">
            <a href="{{ route('demo') }}" class="flex items-center gap-2.5">
                <span class="grid size-10 place-items-center rounded-xl bg-marca-600 text-white"><x-icono nombre="salud" class="size-5" /></span>
                <span class="leading-tight"><span class="block whitespace-nowrap text-base font-bold text-marca-900 sm:text-lg">{{ $centro['nombre'] }}</span><span class="hidden text-xs text-slate-500 sm:block">Centro de salud integral</span></span>
            </a>

            <div class="hidden items-center gap-1 text-[15px] lg:flex">
                <div class="group relative">
                    <button class="flex items-center gap-1 rounded-lg px-3 py-2 text-slate-700 hover:bg-marca-50 hover:text-marca-700">Especialidades <span class="text-xs">▾</span></button>
                    <div class="invisible absolute left-0 top-full w-72 translate-y-1 rounded-2xl border border-slate-100 bg-white p-2 opacity-0 shadow-xl transition group-focus-within:visible group-focus-within:opacity-100 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100">
                        @foreach ($especialidades as $slug => $e)
                            <a href="{{ route('demo.especialidad', $slug) }}" class="block rounded-xl px-3 py-2.5 hover:bg-marca-50">
                                <span class="block font-semibold text-marca-900">{{ $e['nombre'] }}</span>
                                <span class="block text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($e['resumen'], 60) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('demo') }}#servicios" class="rounded-lg px-3 py-2 text-slate-700 hover:bg-marca-50 hover:text-marca-700">Servicios y precios</a>
                <a href="{{ route('demo') }}#equipo" class="rounded-lg px-3 py-2 text-slate-700 hover:bg-marca-50 hover:text-marca-700">Equipo</a>
                <a href="{{ route('demo') }}#convenios" class="rounded-lg px-3 py-2 text-slate-700 hover:bg-marca-50 hover:text-marca-700">Convenios</a>
                <a href="{{ route('demo.presupuesto') }}" class="rounded-lg px-3 py-2 text-slate-700 hover:bg-marca-50 hover:text-marca-700">Presupuesto</a>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('demo.reservar') }}" class="whitespace-nowrap rounded-full bg-marca-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-marca-700 sm:px-5">Reservar <span class="hidden sm:inline">hora</span></a>
                {{-- Menú en celular --}}
                <details class="group relative lg:hidden">
                    <summary class="grid size-10 cursor-pointer list-none place-items-center rounded-xl border border-slate-200 text-marca-900 [&::-webkit-details-marker]:hidden" aria-label="Abrir menú">
                        <span class="text-xl leading-none group-open:hidden">☰</span><span class="hidden text-xl leading-none group-open:inline">✕</span>
                    </summary>
                    <div class="absolute right-0 top-12 w-72 rounded-2xl border border-slate-100 bg-white p-3 shadow-xl">
                        <p class="px-3 pb-1 pt-2 text-xs font-semibold uppercase tracking-wide text-slate-400">Especialidades</p>
                        @foreach ($especialidades as $slug => $e)
                            <a href="{{ route('demo.especialidad', $slug) }}" class="block rounded-lg px-3 py-2 text-marca-900 hover:bg-marca-50">{{ $e['nombre'] }}</a>
                        @endforeach
                        <hr class="my-2 border-slate-100">
                        <a href="{{ route('demo') }}#servicios" class="block rounded-lg px-3 py-2 hover:bg-marca-50">Servicios y precios</a>
                        <a href="{{ route('demo') }}#equipo" class="block rounded-lg px-3 py-2 hover:bg-marca-50">Equipo</a>
                        <a href="{{ route('demo') }}#convenios" class="block rounded-lg px-3 py-2 hover:bg-marca-50">Convenios</a>
                        <a href="{{ route('demo.presupuesto') }}" class="block rounded-lg px-3 py-2 hover:bg-marca-50">Pedir presupuesto</a>
                    </div>
                </details>
            </div>
        </nav>
    </header>

    @yield('contenido')

    {{-- Llamado final --}}
    <section class="mx-auto mt-20 max-w-6xl px-4">
        <div class="flex flex-col items-start justify-between gap-6 rounded-3xl bg-gradient-to-r from-marca-600 to-marca-700 p-8 text-white sm:p-10 md:flex-row md:items-center">
            <div>
                <h2 class="text-2xl font-bold sm:text-3xl">¿Listo para sentirte mejor?</h2>
                <p class="mt-2 text-marca-100">Reserva en línea o escríbenos por WhatsApp. Respondemos en minutos.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('demo.reservar') }}" class="rounded-full bg-white px-6 py-3 font-semibold text-marca-700 hover:bg-marca-50">Reservar hora</a>
                <a href="{{ route('demo.presupuesto') }}" class="rounded-full border border-white/60 px-6 py-3 font-semibold text-white hover:bg-white/10">Pedir presupuesto</a>
            </div>
        </div>
    </section>

    <footer class="mt-16 bg-marca-900 text-sm text-marca-100">
        <div class="mx-auto grid max-w-6xl gap-10 px-4 py-14 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <p class="flex items-center gap-2 text-lg font-bold text-white"><span class="grid size-8 place-items-center rounded-lg bg-marca-500"><x-icono nombre="salud" class="size-4" /></span>{{ $centro['nombre'] }}</p>
                <p class="mt-3 leading-relaxed">Kinesiología, rehabilitación deportiva, nutrición y psicología en el centro de Chillán.</p>
                <p class="mt-4 text-xs text-marca-100/70">Dirección y datos ficticios, solo para el demo.</p>
            </div>
            <div>
                <p class="font-semibold text-white">Especialidades</p>
                <ul class="mt-3 space-y-2">
                    @foreach ($especialidades as $slug => $e)
                        <li><a href="{{ route('demo.especialidad', $slug) }}" class="hover:text-white">{{ $e['nombre'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <p class="font-semibold text-white">Horario</p>
                <ul class="mt-3 space-y-2">
                    @foreach ($centro['horario'] as [$dia, $horas])
                        <li><span class="block text-white/90">{{ $dia }}</span>{{ $horas }}</li>
                    @endforeach
                </ul>
            </div>
            <div>
                <p class="font-semibold text-white">Contacto</p>
                <ul class="mt-3 space-y-2">
                    <li>{{ $centro['direccion'] }}</li>
                    <li>{{ $centro['telefono'] }}</li>
                    <li>{{ $centro['email'] }}</li>
                    <li class="pt-2"><a href="{{ route('demo.reservar') }}" class="font-semibold text-acento hover:underline">Reservar hora en línea →</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10">
            <div class="mx-auto flex max-w-6xl flex-wrap justify-between gap-2 px-4 py-5 text-xs text-marca-100/70">
                <p>© {{ now()->year }} {{ $centro['nombre'] }} · Sitio de ejemplo hecho por {{ config('negocio.nombre') }}</p>
                <p>Fotos: Pexels</p>
            </div>
        </div>
    </footer>

    {{-- Botón flotante de WhatsApp --}}
    <a href="#" class="fixed bottom-5 right-5 z-40 flex items-center gap-2 rounded-full bg-[#25D366] px-4 py-3 font-semibold text-white shadow-lg hover:brightness-95" aria-label="Escríbenos por WhatsApp (demo)">
        <x-icono nombre="whatsapp" class="size-5" /><span class="hidden sm:inline">¿Dudas? Escríbenos</span>
    </a>
</body>
</html>
