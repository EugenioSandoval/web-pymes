@extends('demo.layout')

@php $clp = fn ($n) => \App\Support\Formato::clp($n); @endphp

@section('contenido')
<section class="bg-gradient-to-br from-marca-50 via-white to-amber-50">
    <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 py-16 md:grid-cols-2 md:py-24">
        <div>
            <h1 class="text-4xl font-bold leading-tight text-marca-900 md:text-5xl">Kinesiología, nutrición y psicología en el centro de Chillán</h1>
            <p class="mt-5 text-lg text-slate-600">Reserva tu hora en línea en menos de un minuto. Atendemos Fonasa, Isapre y particular.</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('demo.reservar') }}" class="rounded-full bg-marca-600 px-6 py-3 font-semibold text-white shadow-sm hover:bg-marca-700">Reservar hora</a>
                <a href="#servicios" class="rounded-full border border-marca-600 px-6 py-3 font-semibold text-marca-700 hover:bg-marca-50">Ver servicios</a>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            @foreach ([['+2.000', 'pacientes atendidos'], ['4', 'profesionales'], ['4,9 ★', 'valoración en Google'], ['24/7', 'reservas en línea']] as [$numero, $texto])
                <div class="rounded-2xl bg-white p-6 text-center shadow-sm ring-1 ring-slate-100">
                    <p class="text-3xl font-bold text-marca-700">{{ $numero }}</p>
                    <p class="mt-1 text-sm text-slate-500">{{ $texto }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="servicios" class="mx-auto max-w-6xl px-4 py-16">
    <h2 class="text-3xl font-bold text-marca-900">Servicios</h2>
    <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($servicios as $servicio)
            <div class="flex flex-col rounded-2xl border border-slate-200 p-6">
                <h3 class="font-semibold text-marca-900">{{ $servicio->nombre }}</h3>
                <p class="mt-2 flex-1 text-sm text-slate-600">{{ $servicio->descripcion }}</p>
                <div class="mt-4 flex items-center justify-between">
                    <span class="text-sm text-slate-500">{{ $servicio->duracion_minutos }} min · <strong class="text-marca-900">{{ $clp($servicio->precio) }}</strong></span>
                    <a href="{{ route('demo.reservar', ['servicio' => $servicio->id]) }}" class="text-sm font-semibold text-marca-700 hover:underline">Reservar →</a>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section id="equipo" class="bg-slate-50 py-16">
    <div class="mx-auto max-w-6xl px-4">
        <h2 class="text-3xl font-bold text-marca-900">Nuestro equipo</h2>
        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($profesionales as $p)
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <div class="grid size-14 place-items-center rounded-full text-lg font-bold text-white" style="background: {{ $p->color }}">
                        {{ collect(explode(' ', $p->nombre))->map(fn ($x) => mb_substr($x, 0, 1))->join('') }}
                    </div>
                    <h3 class="mt-4 font-semibold text-marca-900">{{ $p->nombre }}</h3>
                    <p class="text-sm font-medium" style="color: {{ $p->color }}">{{ $p->especialidad }}</p>
                    <p class="mt-2 text-sm text-slate-600">{{ $p->bio }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
