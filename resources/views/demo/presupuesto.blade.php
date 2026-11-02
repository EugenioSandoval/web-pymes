@extends('demo.layout')

@section('titulo', 'Pedir presupuesto')

@php
    $clp = fn ($n) => \App\Support\Formato::clp($n);
    $campo = 'mt-1 w-full rounded-xl border border-slate-300 px-3.5 py-2.5 focus:border-marca-500 focus:outline-none focus:ring-2 focus:ring-marca-100';
@endphp

@section('contenido')
<main class="mx-auto grid max-w-6xl gap-10 px-4 py-12 lg:grid-cols-[1.3fr_1fr]">
    <div>
        <h1 class="text-4xl font-bold text-marca-900">Pide tu presupuesto</h1>
        <p class="mt-3 text-lg text-slate-600">Marca los servicios que te interesan y cuántas sesiones crees necesitar. Te enviamos el presupuesto formal por correo o WhatsApp.</p>

        @if (session('cotizacion'))
            <div class="mt-8 rounded-3xl bg-emerald-50 p-6 ring-1 ring-emerald-200">
                <p class="text-lg font-bold text-emerald-800">¡Solicitud recibida! Presupuesto {{ session('cotizacion') }}</p>
                <p class="mt-1 text-emerald-700">Recepción la revisa y te la envía hoy mismo.</p>
                <div class="mt-4 rounded-2xl bg-white p-4 text-sm text-slate-600">
                    <p class="font-semibold text-marca-900">¿Cómo lo ve el centro?</p>
                    <p class="mt-1">Tu solicitud ya está en el panel como un presupuesto en borrador, con tus servicios y el total calculado.</p>
                    <a href="{{ url('demo/panel/cotizaciones') }}" class="mt-3 inline-block font-semibold text-marca-700 hover:underline">Verlo en el panel →</a>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mt-6 rounded-xl bg-red-50 p-4 text-sm text-red-700">@foreach ($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
        @endif

        <form method="POST" action="{{ route('demo.presupuesto.guardar') }}" class="mt-8" id="form-presupuesto">
            @csrf
            <h2 class="font-semibold text-marca-900">1. Servicios</h2>
            <div class="mt-3 flex flex-col gap-2">
                @foreach ($servicios as $s)
                    <div class="flex items-center gap-3 rounded-2xl border border-slate-200 p-4 has-[:checked]:border-marca-500 has-[:checked]:bg-marca-50">
                        <input type="checkbox" id="s{{ $s->id }}" name="servicios[{{ $s->id }}][activo]" value="1" data-precio="{{ $s->precio }}" class="item size-5 accent-marca-600" @checked(old("servicios.{$s->id}.activo"))>
                        <label for="s{{ $s->id }}" class="flex-1 cursor-pointer"><span class="block font-medium text-marca-900">{{ $s->nombre }}</span><span class="text-sm text-slate-500">{{ $clp($s->precio) }} por sesión</span></label>
                        <label class="text-sm text-slate-500">Sesiones
                            <input type="number" min="1" max="30" name="servicios[{{ $s->id }}][cantidad]" value="{{ old("servicios.{$s->id}.cantidad", 1) }}" class="cantidad ml-1 w-16 rounded-lg border border-slate-300 px-2 py-1 text-center">
                        </label>
                    </div>
                @endforeach
            </div>

            <h2 class="mt-8 font-semibold text-marca-900">2. Tus datos</h2>
            <div class="mt-3 grid gap-4 sm:grid-cols-2">
                <label class="text-sm font-medium text-slate-700">Nombre completo *<input name="nombre" value="{{ old('nombre') }}" required class="{{ $campo }}"></label>
                <label class="text-sm font-medium text-slate-700">Teléfono / WhatsApp *<input name="telefono" type="tel" value="{{ old('telefono') }}" required class="{{ $campo }}"></label>
                <label class="text-sm font-medium text-slate-700">Correo<input name="email" type="email" value="{{ old('email') }}" class="{{ $campo }}"></label>
                <label class="text-sm font-medium text-slate-700">Previsión
                    <select name="prevision" class="{{ $campo }}">
                        @foreach (['Fonasa', 'Isapre', 'Particular'] as $p)<option @selected(old('prevision') === $p)>{{ $p }}</option>@endforeach
                    </select>
                </label>
                <label class="text-sm font-medium text-slate-700 sm:col-span-2">Comentarios<textarea name="comentarios" rows="3" class="{{ $campo }}" placeholder="Cuéntanos tu lesión o lo que buscas">{{ old('comentarios') }}</textarea></label>
            </div>
            <button class="mt-6 w-full rounded-full bg-marca-600 px-6 py-3.5 font-semibold text-white hover:bg-marca-700">Enviar solicitud</button>
        </form>
    </div>

    <aside class="h-fit rounded-3xl bg-slate-900 p-7 text-white lg:sticky lg:top-24">
        <h2 class="text-xl font-bold">Resumen estimado</h2>
        <ul id="resumen" class="mt-5 space-y-2 text-sm text-slate-300"><li>Marca uno o más servicios.</li></ul>
        <div class="mt-5 border-t border-white/10 pt-4">
            <p class="flex justify-between text-sm text-slate-300"><span>Descuento por 10 o más sesiones</span><span id="descuento">$0</span></p>
            <p class="mt-2 flex items-end justify-between"><span class="text-slate-300">Total estimado</span><span id="total" class="text-3xl font-bold">$0</span></p>
        </div>
        <p class="mt-5 text-xs text-slate-400">Valor referencial. Con Fonasa o isapre el copago puede ser menor.</p>
    </aside>
</main>

<script>
    // Calcula el total en vivo mientras el paciente marca servicios.
    (() => {
        const clp = (n) => '$' + Math.round(n).toLocaleString('es-CL');
        const calcular = () => {
            let total = 0, sesiones = 0, lineas = [];
            document.querySelectorAll('#form-presupuesto .item').forEach((check) => {
                if (!check.checked) return;
                const fila = check.closest('div');
                const cantidad = Math.max(1, parseInt(fila.querySelector('.cantidad').value || 1));
                const nombre = fila.querySelector('label span').textContent;
                total += cantidad * check.dataset.precio;
                sesiones += cantidad;
                lineas.push(`<li class="flex justify-between gap-3"><span>${cantidad} × ${nombre}</span><span class="text-white">${clp(cantidad * check.dataset.precio)}</span></li>`);
            });
            const descuento = sesiones >= 10 ? total * 0.1 : 0;
            document.getElementById('resumen').innerHTML = lineas.join('') || '<li>Marca uno o más servicios.</li>';
            document.getElementById('descuento').textContent = '-' + clp(descuento);
            document.getElementById('total').textContent = clp(total - descuento);
        };
        document.getElementById('form-presupuesto').addEventListener('input', calcular);
        calcular();
    })();
</script>
@endsection
