@extends('demo.layout')

@section('titulo', $especialidad['nombre'])

@php
    use App\Support\Formato;

    $clp = fn ($n) => Formato::clp($n);
    $iniciales = fn ($nombre) => collect(explode(' ', $nombre))->map(fn ($x) => mb_substr($x, 0, 1))->join('');
@endphp

@section('contenido')
<section class="bg-marca-50">
    <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 py-14 lg:grid-cols-2">
        <div>
            <nav class="text-sm text-slate-500"><a href="{{ route('demo') }}" class="hover:text-marca-700">Inicio</a> / <a href="{{ route('demo') }}#especialidades" class="hover:text-marca-700">Especialidades</a> / <span class="text-marca-900">{{ $especialidad['nombre'] }}</span></nav>
            <h1 class="mt-4 text-4xl font-bold text-marca-900 md:text-5xl">{{ $especialidad['nombre'] }}</h1>
            <p class="mt-4 text-lg text-slate-600">{{ $especialidad['resumen'] }}</p>
            <div class="mt-7 flex flex-wrap gap-3">
                <a href="{{ route('demo.reservar', ['servicio' => $servicios->first()?->id]) }}" class="rounded-full bg-marca-600 px-6 py-3 font-semibold text-white hover:bg-marca-700">Reservar hora</a>
                <a href="{{ route('demo.presupuesto') }}" class="rounded-full border border-marca-600 px-6 py-3 font-semibold text-marca-700 hover:bg-white">Pedir presupuesto</a>
            </div>
        </div>
        <img src="{{ Formato::foto($especialidad['foto'], 1000) }}" alt="{{ $especialidad['nombre'] }}" class="aspect-[4/3] w-full rounded-3xl bg-marca-100 object-cover shadow-lg">
    </div>
</section>

<section class="mx-auto grid max-w-6xl gap-12 px-4 py-16 lg:grid-cols-[1.4fr_1fr]">
    <div>
        <h2 class="text-2xl font-bold text-marca-900">¿En qué te ayudamos?</h2>
        <p class="mt-3 leading-relaxed text-slate-600">{{ $especialidad['detalle'] }}</p>
        <ul class="mt-6 grid gap-3 sm:grid-cols-2">
            @foreach ($especialidad['trata'] as $item)
                <li class="flex items-center gap-2 rounded-xl bg-slate-50 px-4 py-3"><x-icono nombre="check" class="size-5 shrink-0 text-marca-600" />{{ $item }}</li>
            @endforeach
        </ul>

        <h2 class="mt-12 text-2xl font-bold text-marca-900">Servicios y valores</h2>
        <div class="mt-5 divide-y divide-slate-100 rounded-2xl border border-slate-200">
            @foreach ($servicios as $s)
                <div class="flex items-center gap-4 p-5">
                    <div class="flex-1"><p class="font-semibold text-marca-900">{{ $s->nombre }}</p><p class="text-sm text-slate-500">{{ $s->descripcion }} · {{ $s->duracion_minutos }} min</p></div>
                    <p class="font-bold text-marca-900">{{ $clp($s->precio) }}</p>
                    <a href="{{ route('demo.reservar', ['servicio' => $s->id]) }}" class="rounded-full bg-marca-50 px-4 py-1.5 text-sm font-semibold text-marca-700 hover:bg-marca-100">Reservar</a>
                </div>
            @endforeach
        </div>
    </div>

    <aside class="flex flex-col gap-5">
        <div class="rounded-3xl bg-slate-50 p-6">
            <h2 class="font-bold text-marca-900">Profesionales</h2>
            <div class="mt-4 flex flex-col gap-3">
                @foreach ($profesionales as $p)
                    <a href="{{ route('demo.profesional', $p) }}" class="flex items-center gap-3 rounded-2xl bg-white p-3 hover:ring-2 hover:ring-marca-100">
                        <span class="grid size-12 place-items-center rounded-xl font-bold text-white" style="background: {{ $p->color }}">{{ $iniciales($p->nombre) }}</span>
                        <span><span class="block font-semibold text-marca-900">{{ $p->nombre }}</span><span class="text-sm text-slate-500">{{ $p->especialidad }}</span></span>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="rounded-3xl bg-marca-900 p-6 text-marca-100">
            <h2 class="font-bold text-white">Horario de atención</h2>
            <ul class="mt-3 space-y-2 text-sm">
                @foreach (config('demo.centro.horario') as [$dia, $horas])
                    <li class="flex justify-between gap-3"><span>{{ $dia }}</span><span class="text-right text-white">{{ $horas }}</span></li>
                @endforeach
            </ul>
        </div>
        <div class="rounded-3xl border border-slate-200 p-6">
            <h2 class="font-bold text-marca-900">Otras especialidades</h2>
            <ul class="mt-3 space-y-2">
                @foreach (config('demo.especialidades') as $slug => $e)
                    @continue($e['nombre'] === $especialidad['nombre'])
                    <li><a href="{{ route('demo.especialidad', $slug) }}" class="font-medium text-marca-700 hover:underline">{{ $e['nombre'] }} →</a></li>
                @endforeach
            </ul>
        </div>
    </aside>
</section>
@endsection
