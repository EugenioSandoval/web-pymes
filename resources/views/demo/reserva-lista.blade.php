@extends('demo.layout')

@section('titulo', 'Reserva recibida')

@section('contenido')
<main class="mx-auto max-w-xl px-4 py-16 text-center">
    <div class="mx-auto grid size-16 place-items-center rounded-full bg-marca-100 text-marca-700"><x-icono nombre="check" class="size-8" /></div>
    <h1 class="mt-6 text-3xl font-bold text-marca-900">¡Reserva recibida!</h1>
    <p class="mt-3 text-slate-600">{{ $cita->paciente->nombre }}, te escribiremos por WhatsApp para confirmar tu hora.</p>
    <dl class="mt-8 divide-y divide-slate-100 rounded-2xl border border-slate-200 text-left">
        <div class="flex justify-between p-4"><dt class="text-slate-500">Servicio</dt><dd class="font-medium">{{ $cita->servicio->nombre }}</dd></div>
        <div class="flex justify-between p-4"><dt class="text-slate-500">Profesional</dt><dd class="font-medium">{{ $cita->profesional->nombre }}</dd></div>
        <div class="flex justify-between p-4"><dt class="text-slate-500">Fecha</dt><dd class="font-medium">{{ ucfirst($cita->inicio->translatedFormat('l d \d\e F, H:i')) }}</dd></div>
    </dl>
    <div class="mt-10 rounded-2xl bg-marca-900 p-6 text-left text-marca-100">
        <p class="font-semibold text-white">¿Cómo lo ve el centro?</p>
        <p class="mt-1 text-sm">Esta reserva ya aparece en el panel de gestión como "pendiente", lista para que recepción la confirme.</p>
        <a href="{{ url('demo/panel/agenda') }}" class="mt-4 inline-block rounded-full bg-acento px-5 py-2 text-sm font-semibold text-marca-900">Ver en la agenda del panel →</a>
    </div>
</main>
@endsection
