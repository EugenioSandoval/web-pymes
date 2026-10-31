@extends('layouts.app')

@php
    $wa = 'https://wa.me/'.config('negocio.whatsapp').'?text='.urlencode('Hola, quiero información sobre una página web para mi negocio');
    $clp = fn ($n) => '$'.number_format($n, 0, ',', '.');
@endphp

@section('contenido')
{{-- Encabezado --}}
<header class="sticky top-0 z-40 border-b border-slate-100 bg-white/90 backdrop-blur">
    <nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
        <a href="#" class="flex items-center gap-2 font-semibold text-marca-900">
            <span class="grid size-8 place-items-center rounded-lg bg-marca-600 text-sm font-bold text-white">WP</span>
            {{ config('negocio.nombre') }}
        </a>
        <div class="hidden items-center gap-6 text-sm text-slate-600 md:flex">
            <a href="#servicios" class="hover:text-marca-700">Servicios</a>
            <a href="#rubros" class="hover:text-marca-700">Rubros</a>
            <a href="#planes" class="hover:text-marca-700">Planes</a>
            <a href="#preguntas" class="hover:text-marca-700">Preguntas</a>
        </div>
        <a href="#contacto" class="rounded-lg bg-marca-600 px-4 py-2 text-sm font-semibold text-white hover:bg-marca-700">Cotizar</a>
    </nav>
</header>

<main>
    {{-- Portada --}}
    <section class="bg-gradient-to-b from-marca-50 to-white">
        <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 py-16 md:grid-cols-2 md:py-24">
            <div>
                <p class="mb-4 inline-block rounded-full bg-marca-100 px-3 py-1 text-sm font-medium text-marca-700">Hecho en {{ config('negocio.ciudad') }}</p>
                <h1 class="text-4xl font-bold leading-tight text-marca-900 md:text-5xl">Tu negocio en internet y tu gestión en un solo lugar</h1>
                <p class="mt-5 text-lg text-slate-600">Creamos tu página web y el sistema para manejar clientes, trabajadores, cotizaciones y agenda. Deja atrás el cuaderno, el Excel y los cien chats de WhatsApp.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('demo') }}" class="rounded-lg bg-marca-600 px-6 py-3 font-semibold text-white shadow-sm hover:bg-marca-700">Ver demo</a>
                    <a href="#contacto" class="rounded-lg border border-marca-600 px-6 py-3 font-semibold text-marca-700 hover:bg-marca-50">Pedir cotización</a>
                </div>
                <p class="mt-6 text-sm text-slate-500">Primera reunión gratis, presencial en Chillán o por videollamada.</p>
            </div>

            {{-- Ilustración del panel --}}
            <div class="relative mb-6" aria-hidden="true">
                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-xl">
                    <div class="mb-4 flex gap-1.5"><span class="size-3 rounded-full bg-red-300"></span><span class="size-3 rounded-full bg-amber-300"></span><span class="size-3 rounded-full bg-green-300"></span></div>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="rounded-lg bg-marca-50 p-3"><p class="text-xs text-slate-500">Horas hoy</p><p class="text-2xl font-bold text-marca-700">14</p></div>
                        <div class="rounded-lg bg-marca-50 p-3"><p class="text-xs text-slate-500">Clientes</p><p class="text-2xl font-bold text-marca-700">328</p></div>
                        <div class="rounded-lg bg-amber-50 p-3"><p class="text-xs text-slate-500">Cotizaciones</p><p class="text-2xl font-bold text-amber-600">6</p></div>
                    </div>
                    <div class="mt-4 space-y-2">
                        @foreach ([['09:00', 'Control kinesiología', 'Camila R.'], ['10:30', 'Evaluación inicial', 'Jorge M.'], ['12:00', 'Sesión de seguimiento', 'Ana P.']] as [$hora, $servicio, $cliente])
                            <div class="flex items-center justify-between rounded-lg border border-slate-100 px-3 py-2 text-sm">
                                <span class="font-medium text-marca-700">{{ $hora }}</span>
                                <span class="text-slate-700">{{ $servicio }}</span>
                                <span class="text-slate-400">{{ $cliente }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="absolute -bottom-8 left-3 md:-left-4 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-lg">
                    <p class="text-xs text-slate-500">Nueva reserva desde la web</p>
                    <p class="text-sm font-semibold text-marca-900">Viernes 15:00 · Confirmada</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Qué hacemos --}}
    <section id="servicios" class="mx-auto max-w-6xl px-4 py-20">
        <h2 class="text-3xl font-bold text-marca-900">Dos partes, un solo sistema</h2>
        <p class="mt-3 max-w-2xl text-slate-600">Tus clientes ven una web pública clara y rápida. Tú y tu equipo usan un panel privado donde todo queda ordenado.</p>
        <div class="mt-10 grid gap-6 md:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 p-6">
                <h3 class="text-xl font-semibold text-marca-900">Web pública</h3>
                <ul class="mt-4 space-y-2 text-slate-600">
                    @foreach (['Muestra tus servicios, precios y ubicación', 'Recibe reservas, pedidos y solicitudes de cotización', 'Se ve bien en celular y aparece en Google', 'Botón directo a tu WhatsApp'] as $item)
                        <li class="flex gap-2"><x-icono nombre="check" class="mt-0.5 size-5 shrink-0 text-marca-500" />{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="rounded-2xl border border-slate-200 p-6">
                <h3 class="text-xl font-semibold text-marca-900">Panel privado de gestión</h3>
                <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                    @foreach ([['usuarios', 'Clientes y trabajadores'], ['documento', 'Cotizaciones en PDF'], ['calendario', 'Agenda y eventos'], ['celular', 'Funciona desde el celular']] as [$icono, $texto])
                        <div class="flex items-center gap-2 rounded-lg bg-marca-50 p-3 text-marca-900"><x-icono :nombre="$icono" class="size-5 text-marca-600" />{{ $texto }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Rubros --}}
    <section id="rubros" class="bg-slate-50 py-20">
        <div class="mx-auto max-w-6xl px-4">
            <h2 class="text-3xl font-bold text-marca-900">Pensado para negocios de Ñuble</h2>
            <p class="mt-3 max-w-2xl text-slate-600">Cada rubro trabaja distinto. Adaptamos el sistema a cómo funciona el tuyo.</p>
            <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach (config('negocio.rubros') as $rubro)
                    <div class="rounded-2xl bg-white p-6 shadow-sm">
                        <div class="grid size-11 place-items-center rounded-xl bg-marca-100 text-marca-700"><x-icono :nombre="$rubro['icono']" class="size-6" /></div>
                        <h3 class="mt-4 font-semibold text-marca-900">{{ $rubro['nombre'] }}</h3>
                        <p class="mt-2 text-sm text-slate-600">{{ $rubro['detalle'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Demo --}}
    <section class="mx-auto max-w-6xl px-4 py-20">
        <div class="flex flex-col items-start gap-6 rounded-3xl bg-marca-900 p-8 text-white md:flex-row md:items-center md:justify-between md:p-12">
            <div>
                <h2 class="text-3xl font-bold">Prueba un ejemplo real</h2>
                <p class="mt-3 max-w-xl text-marca-100">Explora la web y el panel de un centro de salud ficticio: reserva una hora, revisa la agenda, crea una cotización.</p>
            </div>
            <a href="{{ route('demo') }}" class="shrink-0 rounded-lg bg-acento px-6 py-3 font-semibold text-marca-900 hover:brightness-95">Abrir demo</a>
        </div>
    </section>

    {{-- Planes --}}
    <section id="planes" class="bg-slate-50 py-20">
        <div class="mx-auto max-w-6xl px-4">
            <h2 class="text-3xl font-bold text-marca-900">Planes</h2>
            <p class="mt-3 max-w-2xl text-slate-600">Un valor inicial por el desarrollo y una mensualidad que incluye hosting, soporte y horas de mejoras. Empieza simple y crece cuando lo necesites.</p>
            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                @foreach (config('negocio.paquetes') as $plan)
                    <div @class(['flex flex-col rounded-2xl bg-white p-7', 'ring-2 ring-marca-500 shadow-lg' => $plan['destacado'], 'border border-slate-200' => ! $plan['destacado']])>
                        @if ($plan['destacado'])<p class="mb-3 self-start rounded-full bg-marca-100 px-3 py-1 text-xs font-semibold text-marca-700">Más pedido</p>@endif
                        <h3 class="text-xl font-semibold text-marca-900">{{ $plan['nombre'] }}</h3>
                        <p class="mt-2 text-sm text-slate-600">{{ $plan['para'] }}</p>
                        <p class="mt-6"><span class="text-sm text-slate-500">desde</span> <span class="text-3xl font-bold text-marca-900">{{ $clp($plan['desde']) }}</span></p>
                        <p class="text-sm text-slate-500">+ {{ $clp($plan['mensual']) }} al mes</p>
                        <ul class="mt-6 flex-1 space-y-2 text-sm text-slate-700">
                            @foreach ($plan['incluye'] as $item)
                                <li class="flex gap-2"><x-icono nombre="check" class="mt-0.5 size-4 shrink-0 text-marca-500" />{{ $item }}</li>
                            @endforeach
                        </ul>
                        <a href="#contacto" data-plan="{{ $plan['nombre'] }}" class="elegir-plan mt-8 rounded-lg px-4 py-2.5 text-center font-semibold {{ $plan['destacado'] ? 'bg-marca-600 text-white hover:bg-marca-700' : 'border border-marca-600 text-marca-700 hover:bg-marca-50' }}">Cotizar este plan</a>
                    </div>
                @endforeach
            </div>
            <p class="mt-6 text-sm text-slate-500">Valores en pesos chilenos, más IVA. Contrato de mantención mínimo de 12 meses.</p>
        </div>
    </section>

    {{-- Proceso --}}
    <section class="mx-auto max-w-6xl px-4 py-20">
        <h2 class="text-3xl font-bold text-marca-900">Cómo trabajamos</h2>
        <ol class="mt-10 grid gap-6 md:grid-cols-4">
            @foreach ([['Conversamos', 'Nos cuentas cómo funciona tu negocio y qué te quita más tiempo.'], ['Te cotizamos', 'Recibes una propuesta clara con alcance, plazo y precio.'], ['Construimos', 'Te mostramos avances cada semana hasta que quede como lo necesitas.'], ['Te acompañamos', 'Publicamos, te enseñamos a usarlo y seguimos mejorándolo cada mes.']] as $i => [$titulo, $texto])
                <li class="rounded-2xl border border-slate-200 p-6">
                    <span class="grid size-9 place-items-center rounded-full bg-marca-600 font-bold text-white">{{ $i + 1 }}</span>
                    <h3 class="mt-4 font-semibold text-marca-900">{{ $titulo }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $texto }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- Preguntas frecuentes --}}
    <section id="preguntas" class="bg-slate-50 py-20">
        <div class="mx-auto max-w-3xl px-4">
            <h2 class="text-3xl font-bold text-marca-900">Preguntas frecuentes</h2>
            <div class="mt-8 space-y-3">
                @foreach ([
                    ['¿Cuánto se demora?', 'Una web informativa toma entre 1 y 2 semanas. Una plataforma con gestión, entre 4 y 8 semanas según los módulos.'],
                    ['¿Qué incluye la mensualidad?', 'Hosting, dominio, certificado de seguridad, respaldos, soporte y una bolsa de horas al mes para cambios y mejoras.'],
                    ['¿Puedo empezar con la web y después sumar el sistema?', 'Sí. Todo se construye sobre la misma base, así que puedes subir de plan sin empezar de cero.'],
                    ['¿Los datos son míos?', 'Sí. Tus datos y los de tus clientes son tuyos, y si algún día te vas te los entregamos.'],
                    ['¿Necesito saber de computación?', 'No. Te enseñamos a usar el panel y quedamos disponibles por WhatsApp para cualquier duda.'],
                ] as [$pregunta, $respuesta])
                    <details class="group rounded-xl bg-white p-5 shadow-sm">
                        <summary class="flex cursor-pointer list-none items-center justify-between font-semibold text-marca-900">{{ $pregunta }}<span class="text-marca-500 transition group-open:rotate-45">+</span></summary>
                        <p class="mt-3 text-slate-600">{{ $respuesta }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Contacto --}}
    <section id="contacto" class="mx-auto max-w-6xl px-4 py-20">
        <div class="grid gap-10 md:grid-cols-5">
            <div class="md:col-span-2">
                <h2 class="text-3xl font-bold text-marca-900">Conversemos</h2>
                <p class="mt-3 text-slate-600">Déjanos tus datos y te contactamos dentro de 24 horas hábiles. O escríbenos directo.</p>
                <div class="mt-6 space-y-3 text-sm">
                    <a href="{{ $wa }}" target="_blank" rel="noopener" class="flex items-center gap-2 font-semibold text-marca-700 hover:underline"><x-icono nombre="whatsapp" class="size-5" />WhatsApp</a>
                    <a href="mailto:{{ config('negocio.email') }}" class="block text-slate-600 hover:underline">{{ config('negocio.email') }}</a>
                    <p class="text-slate-600">{{ config('negocio.ciudad') }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('contacto') }}" class="space-y-4 rounded-2xl border border-slate-200 p-6 md:col-span-3">
                @csrf
                @if (session('ok'))
                    <p class="rounded-lg bg-marca-50 p-3 text-sm font-medium text-marca-700">{{ session('ok') }}</p>
                @endif
                @if ($errors->any())
                    <div class="rounded-lg bg-red-50 p-3 text-sm text-red-700">
                        @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                    </div>
                @endif
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm font-medium text-slate-700">Nombre *
                        <input name="nombre" value="{{ old('nombre') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-marca-500 focus:outline-none focus:ring-2 focus:ring-marca-100">
                    </label>
                    <label class="block text-sm font-medium text-slate-700">Nombre del negocio
                        <input name="negocio" value="{{ old('negocio') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-marca-500 focus:outline-none focus:ring-2 focus:ring-marca-100">
                    </label>
                    <label class="block text-sm font-medium text-slate-700">Teléfono / WhatsApp *
                        <input name="telefono" type="tel" value="{{ old('telefono') }}" required placeholder="+56 9 1234 5678" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-marca-500 focus:outline-none focus:ring-2 focus:ring-marca-100">
                    </label>
                    <label class="block text-sm font-medium text-slate-700">Correo
                        <input name="email" type="email" value="{{ old('email') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-marca-500 focus:outline-none focus:ring-2 focus:ring-marca-100">
                    </label>
                    <label class="block text-sm font-medium text-slate-700">Rubro
                        <select name="rubro" class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 focus:border-marca-500 focus:outline-none focus:ring-2 focus:ring-marca-100">
                            <option value="">Selecciona</option>
                            @foreach (config('negocio.rubros') as $rubro)
                                <option @selected(old('rubro') === $rubro['nombre'])>{{ $rubro['nombre'] }}</option>
                            @endforeach
                            <option @selected(old('rubro') === 'Otro')>Otro</option>
                        </select>
                    </label>
                    <label class="block text-sm font-medium text-slate-700">Plan de interés
                        <select name="paquete" id="campo-paquete" class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 focus:border-marca-500 focus:outline-none focus:ring-2 focus:ring-marca-100">
                            <option value="">No sé todavía</option>
                            @foreach (config('negocio.paquetes') as $plan)
                                <option @selected(old('paquete') === $plan['nombre'])>{{ $plan['nombre'] }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <label class="block text-sm font-medium text-slate-700">¿Qué te gustaría resolver?
                    <textarea name="mensaje" rows="4" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-marca-500 focus:outline-none focus:ring-2 focus:ring-marca-100">{{ old('mensaje') }}</textarea>
                </label>
                <button class="w-full rounded-lg bg-marca-600 px-6 py-3 font-semibold text-white hover:bg-marca-700">Enviar</button>
            </form>
        </div>
    </section>
</main>

<footer class="border-t border-slate-100 py-8 text-center text-sm text-slate-500">
    © {{ date('Y') }} {{ config('negocio.nombre') }} · {{ config('negocio.ciudad') }}
</footer>

<script>
    // Al elegir un plan, lo deja seleccionado en el formulario.
    document.querySelectorAll('.elegir-plan').forEach(boton => {
        boton.addEventListener('click', () => {
            document.getElementById('campo-paquete').value = boton.dataset.plan;
        });
    });
</script>
@endsection
