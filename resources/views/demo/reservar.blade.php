@extends('demo.layout')

@section('titulo', 'Reservar hora')

@php
    $clp = fn ($n) => \App\Support\Formato::clp($n);
    $url = fn (array $extra) => route('demo.reservar', array_filter(array_merge([
        'servicio' => $servicio?->id, 'profesional' => $profesional?->id, 'fecha' => $fecha?->toDateString(),
    ], $extra)));
    $chip = 'rounded-xl border px-4 py-3 text-left transition';
    $activo = 'border-marca-600 bg-marca-50 ring-2 ring-marca-100';
    $inactivo = 'border-slate-200 hover:border-marca-500';
@endphp

@section('contenido')
<main class="mx-auto max-w-3xl px-4 py-12">
    <h1 class="text-3xl font-bold text-marca-900">Reserva tu hora</h1>
    <p class="mt-2 text-slate-600">Elige el servicio, el profesional y el horario. Te confirmaremos por WhatsApp.</p>

    {{-- 1. Servicio --}}
    <section class="mt-10">
        <h2 class="font-semibold text-marca-900"><span class="mr-2 inline-grid size-6 place-items-center rounded-full bg-marca-600 text-sm text-white">1</span>Servicio</h2>
        <div class="mt-4 grid gap-3 sm:grid-cols-2">
            @foreach ($servicios as $s)
                <a href="{{ route('demo.reservar', ['servicio' => $s->id]) }}" class="{{ $chip }} {{ $servicio?->is($s) ? $activo : $inactivo }}">
                    <span class="block font-medium text-marca-900">{{ $s->nombre }}</span>
                    <span class="text-sm text-slate-500">{{ $s->duracion_minutos }} min · {{ $clp($s->precio) }}</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- 2. Profesional --}}
    @if ($servicio)
        <section class="mt-10">
            <h2 class="font-semibold text-marca-900"><span class="mr-2 inline-grid size-6 place-items-center rounded-full bg-marca-600 text-sm text-white">2</span>Profesional</h2>
            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                @foreach ($profesionales as $p)
                    <a href="{{ $url(['profesional' => $p->id, 'fecha' => null]) }}" class="{{ $chip }} {{ $profesional?->is($p) ? $activo : $inactivo }} flex items-center gap-3">
                        <span class="size-3 rounded-full" style="background: {{ $p->color }}"></span>
                        <span><span class="block font-medium text-marca-900">{{ $p->nombre }}</span><span class="text-sm text-slate-500">{{ $p->especialidad }}</span></span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- 3. Día --}}
    @if ($profesional)
        <section class="mt-10">
            <h2 class="font-semibold text-marca-900"><span class="mr-2 inline-grid size-6 place-items-center rounded-full bg-marca-600 text-sm text-white">3</span>Día</h2>
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach ($dias as $d)
                    <a href="{{ $url(['fecha' => $d->toDateString()]) }}" class="rounded-xl border px-3 py-2 text-center text-sm {{ $fecha?->isSameDay($d) ? $activo : $inactivo }}">
                        <span class="block text-xs uppercase text-slate-500">{{ $d->translatedFormat('D') }}</span>
                        <span class="font-semibold text-marca-900">{{ $d->format('d/m') }}</span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- 4. Hora y datos --}}
    @if ($fecha)
        <form method="POST" action="{{ route('demo.reservar.guardar') }}" class="mt-10">
            @csrf
            <input type="hidden" name="servicio_id" value="{{ $servicio->id }}">
            <input type="hidden" name="profesional_id" value="{{ $profesional->id }}">

            <h2 class="font-semibold text-marca-900"><span class="mr-2 inline-grid size-6 place-items-center rounded-full bg-marca-600 text-sm text-white">4</span>Hora</h2>
            @if ($horas->isEmpty())
                <p class="mt-4 rounded-xl bg-amber-50 p-4 text-sm text-amber-800">No quedan horas libres ese día. Prueba con otro día u otro profesional.</p>
            @else
                <div class="mt-4 grid grid-cols-4 gap-2 sm:grid-cols-6">
                    @foreach ($horas as $h)
                        <label class="cursor-pointer">
                            <input type="radio" name="inicio" value="{{ $h->format('Y-m-d H:i') }}" class="peer sr-only" required @checked(old('inicio') === $h->format('Y-m-d H:i'))>
                            <span class="block rounded-lg border border-slate-200 py-2 text-center text-sm font-medium peer-checked:border-marca-600 peer-checked:bg-marca-600 peer-checked:text-white hover:border-marca-500">{{ $h->format('H:i') }}</span>
                        </label>
                    @endforeach
                </div>

                <h2 class="mt-10 font-semibold text-marca-900"><span class="mr-2 inline-grid size-6 place-items-center rounded-full bg-marca-600 text-sm text-white">5</span>Tus datos</h2>
                @if ($errors->any())
                    <div class="mt-4 rounded-lg bg-red-50 p-3 text-sm text-red-700">@foreach ($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
                @endif
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <label class="text-sm font-medium text-slate-700">Nombre completo *
                        <input name="nombre" value="{{ old('nombre') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-marca-500 focus:outline-none focus:ring-2 focus:ring-marca-100">
                    </label>
                    <label class="text-sm font-medium text-slate-700">RUT
                        <input name="rut" value="{{ old('rut') }}" placeholder="12.345.678-9" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-marca-500 focus:outline-none focus:ring-2 focus:ring-marca-100">
                    </label>
                    <label class="text-sm font-medium text-slate-700">Teléfono / WhatsApp *
                        <input name="telefono" type="tel" value="{{ old('telefono') }}" required placeholder="+56 9 1234 5678" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-marca-500 focus:outline-none focus:ring-2 focus:ring-marca-100">
                    </label>
                    <label class="text-sm font-medium text-slate-700">Correo
                        <input name="email" type="email" value="{{ old('email') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-marca-500 focus:outline-none focus:ring-2 focus:ring-marca-100">
                    </label>
                    <label class="text-sm font-medium text-slate-700 sm:col-span-2">Motivo de consulta
                        <textarea name="notas" rows="3" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-marca-500 focus:outline-none focus:ring-2 focus:ring-marca-100">{{ old('notas') }}</textarea>
                    </label>
                </div>
                <button class="mt-6 w-full rounded-full bg-marca-600 px-6 py-3 font-semibold text-white hover:bg-marca-700">Confirmar reserva · {{ $servicio->nombre }} con {{ $profesional->nombre }}</button>
            @endif
        </form>
    @endif
</main>
@endsection
