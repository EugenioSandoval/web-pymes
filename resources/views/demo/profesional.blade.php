@extends('demo.layout')

@section('titulo', $profesional->nombre)

@php
    $clp = fn ($n) => \App\Support\Formato::clp($n);
    $iniciales = collect(explode(' ', $profesional->nombre))->map(fn ($x) => mb_substr($x, 0, 1))->join('');
@endphp

@section('contenido')
<main class="mx-auto max-w-6xl px-4 py-12">
    <nav class="text-sm text-slate-500"><a href="{{ route('demo') }}" class="hover:text-marca-700">Inicio</a> / <a href="{{ route('demo') }}#equipo" class="hover:text-marca-700">Equipo</a> / <span class="text-marca-900">{{ $profesional->nombre }}</span></nav>

    <div class="mt-6 grid gap-10 lg:grid-cols-[1.4fr_1fr]">
        <div>
            <div class="flex flex-wrap items-center gap-6">
                <span class="grid size-28 place-items-center rounded-3xl text-4xl font-bold text-white shadow-lg" style="background: {{ $profesional->color }}">{{ $iniciales }}</span>
                <div>
                    <h1 class="text-4xl font-bold text-marca-900">{{ $profesional->nombre }}</h1>
                    <p class="mt-1 text-lg font-medium" style="color: {{ $profesional->color }}">{{ $profesional->especialidad }}</p>
                    <p class="mt-2 text-sm text-slate-500"><span class="text-acento">★★★★★</span> 5,0 · Atiende de lunes a viernes</p>
                </div>
            </div>

            <h2 class="mt-10 text-2xl font-bold text-marca-900">Sobre mí</h2>
            <p class="mt-3 text-lg leading-relaxed text-slate-600">{{ $profesional->bio }}</p>

            <h2 class="mt-10 text-2xl font-bold text-marca-900">Servicios que atiende</h2>
            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                @foreach ($profesional->servicios as $s)
                    <a href="{{ route('demo.reservar', ['servicio' => $s->id, 'profesional' => $profesional->id]) }}" class="rounded-2xl border border-slate-200 p-5 hover:border-marca-500">
                        <p class="font-semibold text-marca-900">{{ $s->nombre }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ $s->duracion_minutos }} min · {{ $clp($s->precio) }}</p>
                        <p class="mt-3 text-sm font-semibold text-marca-700">Reservar con {{ \Illuminate\Support\Str::before($profesional->nombre, ' ') }} →</p>
                    </a>
                @endforeach
            </div>
        </div>

        <aside class="h-fit rounded-3xl bg-marca-50 p-7">
            <h2 class="text-xl font-bold text-marca-900">Próximas horas libres</h2>
            @if ($proximas->isEmpty())
                <p class="mt-3 text-slate-600">No quedan horas esta semana. Escríbenos y te avisamos si se libera una.</p>
            @else
                <div class="mt-5 flex flex-col gap-2">
                    @foreach ($proximas as $hora)
                        <a href="{{ route('demo.reservar', ['servicio' => $servicio->id, 'profesional' => $profesional->id, 'fecha' => $hora->toDateString()]) }}" class="flex items-center justify-between rounded-xl bg-white px-4 py-3 hover:ring-2 hover:ring-marca-500">
                            <span class="font-medium text-marca-900">{{ ucfirst($hora->translatedFormat('l d/m')) }}</span>
                            <span class="font-bold text-marca-700">{{ $hora->format('H:i') }}</span>
                        </a>
                    @endforeach
                </div>
                <p class="mt-3 text-xs text-slate-500">Horas para {{ mb_strtolower($servicio->nombre) }}, se actualizan en tiempo real.</p>
            @endif
            <a href="{{ route('demo.reservar', ['servicio' => $servicio?->id, 'profesional' => $profesional->id]) }}" class="mt-6 block rounded-full bg-marca-600 py-3 text-center font-semibold text-white hover:bg-marca-700">Ver todas las horas</a>
        </aside>
    </div>
</main>
@endsection
