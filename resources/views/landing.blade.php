@extends('layouts.app')

@php
    use App\Support\Formato;

    $negocio = config('negocio');
    $rubros = $negocio['rubros'];
    $portada = collect($rubros)->where('portada', true);
    $slider = $negocio['slider'];
    $clp = fn ($n) => Formato::clp($n);
    $titulo = 'font-titulo font-extrabold tracking-tight';
    $etiqueta = 'inline-flex items-center gap-2 rounded-full bg-naranja-suave px-3.5 py-1.5 text-sm font-semibold text-naranja-oscuro';
    $campo = 'mt-1.5 w-full rounded-xl border border-stone-300 bg-white px-3.5 py-3 focus:border-tinta focus:outline-none focus:ring-2 focus:ring-naranja/30';
    $whatsapp = 'https://wa.me/'.$negocio['whatsapp'].'?text='.urlencode('Hola, quiero información para mi negocio');
    $nuevo = ['Nuevo', 'Nueva', 'Borrador', 'Presupuesto', 'En proceso', 'En taller'];
@endphp

@section('contenido')
{{-- Franja de oferta --}}
<div class="bg-tinta px-4 py-2 text-center text-sm font-medium text-white">
    <span class="mr-1.5 inline-block rounded-full bg-naranja px-2 py-0.5 text-xs font-bold">GRATIS</span>
    Primera reunión y diagnóstico de tu negocio. <a href="#contacto" class="font-semibold text-orange-300 underline-offset-2 hover:underline">Agenda la tuya →</a>
</div>

{{-- Encabezado --}}
<header class="sticky top-0 z-40 border-b border-stone-200/70 bg-white/80 backdrop-blur-xl">
    <nav class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3">
        <a href="#" class="flex items-center gap-2.5 text-tinta">
            <x-logo class="size-9" />
            <span class="{{ $titulo }} whitespace-nowrap text-lg sm:text-xl">{{ $negocio['nombre'] }}</span>
        </a>
        <div class="hidden items-center gap-1 text-[15px] font-medium text-stone-600 lg:flex">
            @foreach (['#rubros' => 'Rubros', '#whatsapp' => 'WhatsApp', '#servicios' => 'Qué hacemos', '#antes-despues' => 'Antes y después', '#planes' => 'Planes'] as $ancla => $texto)
                <a href="{{ $ancla }}" class="rounded-full px-3.5 py-2 hover:bg-arena hover:text-tinta">{{ $texto }}</a>
            @endforeach
            <a href="{{ route('demo') }}" class="rounded-full px-3.5 py-2 hover:bg-arena hover:text-tinta">Demo</a>
        </div>
        <a href="#contacto" class="group inline-flex shrink-0 items-center gap-1.5 whitespace-nowrap rounded-full bg-naranja px-4 py-2.5 text-sm sm:px-5 font-semibold text-white shadow-lg shadow-naranja/30 hover:bg-naranja-oscuro">Cotiza gratis <x-icono nombre="flecha" class="size-4 transition group-hover:translate-x-0.5" /></a>
    </nav>
</header>

<main>
    {{-- ============ PORTADA ============ --}}
    <section class="slider relative overflow-hidden bg-[#fbf8f4]" aria-roledescription="carrusel" aria-label="Ejemplos por rubro">
        <div class="fondo-puntos pointer-events-none absolute inset-0 [mask-image:linear-gradient(to_bottom,black,transparent)]"></div>
        <div class="pointer-events-none absolute -right-32 -top-40 size-[38rem] rounded-full bg-naranja/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-40 top-1/2 size-[30rem] rounded-full bg-sky-300/25 blur-3xl"></div>

        <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 pb-16 pt-10 lg:grid-cols-[1.02fr_1fr] lg:gap-8 lg:pb-24 lg:pt-16">
            {{-- Texto --}}
            <div class="flex flex-col gap-6">
                <p class="inline-flex items-center gap-2 self-start rounded-full bg-white px-3.5 py-1.5 text-sm font-medium text-tinta shadow-sm ring-1 ring-stone-200">
                    <span class="relative flex size-2.5"><span class="absolute inline-flex size-full animate-ping rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex size-2.5 rounded-full bg-emerald-500"></span></span>
                    Webs y sistemas hechos en {{ $negocio['ciudad'] }}
                </p>
                <h1 class="{{ $titulo }} text-[2.6rem] leading-[1.02] text-tinta sm:text-6xl lg:text-[4.4rem]">
                    Software a medida para
                    <span class="mt-2 block [perspective:600px]">
                        <span class="inline-block rounded-2xl bg-tinta px-4 pb-2 pt-1 text-white shadow-xl shadow-tinta/20 ring-4 ring-naranja/20 sm:rounded-3xl sm:px-5">
                            <span id="palabra" class="palabra-entra inline-block text-orange-300">{{ $slider[0]['palabra'] }}</span>
                        </span>
                    </span>
                </h1>
                <p class="max-w-xl text-lg leading-relaxed text-stone-600">Tu web para vender y recibir reservas las 24 horas, y un panel privado para ordenar <strong class="text-tinta">clientes, trabajadores, agenda y cotizaciones</strong>. Con soporte cercano por WhatsApp.</p>
                <div class="flex flex-wrap gap-3">
                    <a href="#contacto" class="group inline-flex items-center gap-2 rounded-full bg-naranja px-7 py-4 font-semibold text-white shadow-xl shadow-naranja/30 transition hover:-translate-y-0.5 hover:bg-naranja-oscuro">Quiero mi sistema <x-icono nombre="flecha" class="size-5 transition group-hover:translate-x-1" /></a>
                    <a href="{{ route('demo') }}" class="inline-flex items-center gap-2 rounded-full bg-white px-7 py-4 font-semibold text-tinta shadow-sm ring-1 ring-stone-300 transition hover:-translate-y-0.5 hover:ring-tinta">
                        <span class="grid size-6 place-items-center rounded-full bg-tinta text-[10px] text-white">▶</span> Ver demo en vivo
                    </a>
                </div>

                {{-- Selector de rubro (controla el slider) --}}
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-stone-500">Elige tu rubro</p>
                    <div class="mt-2.5 flex flex-wrap gap-2">
                        @foreach ($slider as $i => $slide)
                            <button type="button" data-ir="{{ $i }}" aria-label="Ver {{ $slide['rubro'] }}" @class(['punto flex items-center gap-1.5 rounded-full px-3 py-1.5 text-sm font-semibold ring-1 transition', 'bg-tinta text-white ring-tinta' => $i === 0, 'bg-white text-stone-600 ring-stone-200 hover:text-tinta hover:ring-tinta' => $i !== 0])>
                                <x-icono :nombre="$slide['icono']" class="size-4" />{{ $slide['corto'] }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Foto + tarjetas flotantes --}}
            <div class="relative lg:pl-6 lg:pr-16 xl:pr-24">
                <div class="relative aspect-[4/4.4] sm:aspect-[4/3.6] lg:aspect-[4/4.6]">
                    @foreach ($slider as $i => $slide)
                        <div class="slide absolute inset-0 transition-opacity duration-700 @if ($i !== 0) pointer-events-none opacity-0 @endif" data-slide="{{ $i }}" data-palabra="{{ $slide['palabra'] }}" aria-hidden="{{ $i === 0 ? 'false' : 'true' }}">
                            {{-- Foto --}}
                            <div class="absolute inset-0 overflow-hidden rounded-[2.5rem] bg-tinta shadow-2xl shadow-tinta/25 ring-8 ring-white">
                                <img src="{{ Formato::foto($slide['foto'], 1000) }}" alt="{{ $slide['rubro'] }}" @if ($i !== 0) loading="lazy" @endif class="size-full object-cover" style="object-position: {{ $slide['posicion'] ?? 'center' }}">
                                <div class="absolute inset-0 bg-gradient-to-t from-tinta/90 via-tinta/10 to-transparent"></div>
                                <div class="absolute inset-x-0 bottom-0 p-5 pr-24 text-white sm:p-7 sm:pb-36 sm:pr-40 lg:pr-28">
                                    <p class="inline-flex items-center gap-1.5 rounded-full bg-naranja px-2.5 py-1 text-xs font-bold"><x-icono :nombre="$slide['icono']" class="size-3.5" />{{ $slide['rubro'] }}</p>
                                    <p class="mt-2 text-lg font-semibold leading-snug sm:text-xl">{{ $slide['frase'] }}</p>
                                </div>
                            </div>

                            {{-- Funciones conectadas con línea punteada --}}
                            <div class="absolute -right-2 top-[14%] flex flex-col items-end gap-3 sm:-right-6 lg:-right-16 xl:-right-24" aria-hidden="true">
                                <svg class="absolute -left-5 top-6 h-[calc(100%-3rem)] w-4 overflow-visible text-naranja" viewBox="0 0 16 100" preserveAspectRatio="none"><path d="M8 0V100" stroke="currentColor" stroke-width="2.5" fill="none" class="linea-viva" vector-effect="non-scaling-stroke"/></svg>
                                @foreach ($slide['funciones'] as $j => [$icono, $texto])
                                    <div class="flotar{{ $j ? '-'.($j + 1) : '' }} relative flex items-center gap-2.5 rounded-2xl bg-white/85 py-2 pl-2 pr-4 text-sm font-bold text-tinta shadow-xl shadow-tinta/15 ring-1 ring-white backdrop-blur-md sm:text-[15px]">
                                        <span class="absolute -left-[1.6rem] size-3 rounded-full border-[3px] border-white bg-naranja shadow"></span>
                                        <span class="grid size-9 place-items-center rounded-xl bg-naranja-suave text-naranja-oscuro"><x-icono :nombre="$icono" class="size-5" /></span>{{ $texto }}
                                    </div>
                                @endforeach
                            </div>

                            {{-- Aviso flotante --}}
                            <div class="flotar-2 absolute -top-5 left-4 flex items-center gap-2.5 rounded-2xl bg-white px-3.5 py-2.5 text-tinta shadow-xl ring-1 ring-stone-100 sm:-left-6" aria-hidden="true">
                                <span class="grid size-9 place-items-center rounded-full bg-emerald-500 text-white"><x-icono nombre="check" class="size-5" /></span>
                                <span class="text-xs text-stone-500"><strong class="block text-sm text-tinta">{{ $slide['aviso'][0] }}</strong>{{ $slide['aviso'][1] }}</span>
                            </div>

                            {{-- Mini panel --}}
                            <div class="absolute -bottom-12 -left-3 hidden w-72 rounded-2xl bg-white/95 p-3.5 text-tinta shadow-2xl ring-1 ring-stone-100 backdrop-blur sm:block lg:-left-10" aria-hidden="true">
                                <div class="flex items-center justify-between">
                                    <p class="flex items-center gap-1.5 text-xs font-bold"><x-logo class="size-4" />{{ $slide['panel'] }}</p>
                                    <span class="flex gap-1"><span class="size-2 rounded-full bg-red-300"></span><span class="size-2 rounded-full bg-amber-300"></span><span class="size-2 rounded-full bg-emerald-300"></span></span>
                                </div>
                                <div class="mt-2.5 space-y-1.5 text-xs">
                                    @foreach ($slide['filas'] as [$texto, $estado])
                                        <div class="flex items-center justify-between gap-2 rounded-lg bg-stone-50 px-2.5 py-2">
                                            <span class="truncate">{{ $texto }}</span>
                                            <span @class(['shrink-0 rounded-full px-2 py-0.5 text-[10px] font-bold', 'bg-naranja-suave text-naranja-oscuro' => in_array($estado, $nuevo), 'bg-emerald-50 text-emerald-700' => ! in_array($estado, $nuevo)])>{{ $estado }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- Barra de progreso del slider --}}
                <div class="mt-16 hidden h-1 overflow-hidden rounded-full bg-stone-200 sm:block lg:mt-14"><div id="progreso" class="h-full w-0 rounded-full bg-naranja"></div></div>
            </div>
        </div>
    </section>

    {{-- Cinta de rubros --}}
    <div class="relative overflow-hidden bg-tinta py-5" aria-hidden="true">
        <div class="cinta flex w-max gap-12 whitespace-nowrap text-white">
            @foreach ([1, 2] as $vuelta)
                @foreach ($rubros as $rubro)
                    <span class="flex items-center gap-3 font-titulo text-xl font-semibold"><x-icono :nombre="$rubro['icono']" class="size-6 text-naranja" />{{ $rubro['nombre'] }}<span class="ml-9 text-naranja">✦</span></span>
                @endforeach
            @endforeach
        </div>
    </div>

    {{-- Cifras --}}
    <section class="border-b border-stone-200 bg-white">
        <div class="mx-auto grid max-w-7xl grid-cols-2 divide-stone-200 px-4 lg:grid-cols-4 lg:divide-x">
            @foreach ($negocio['cifras'] as [$cifra, $texto])
                <div class="revelar px-2 py-8 sm:px-6">
                    <p class="{{ $titulo }} texto-degradado text-5xl sm:text-6xl">{{ $cifra }}</p>
                    <p class="mt-1 max-w-[14rem] text-[15px] leading-snug text-stone-600">{{ $texto }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============ ¿TE PASA ESTO? ============ --}}
    <section id="preguntas" class="mx-auto max-w-7xl px-4 py-24">
        <div class="grid items-end gap-6 lg:grid-cols-[1.3fr_1fr]">
            <div>
                <p class="{{ $etiqueta }}">¿Te pasa esto?</p>
                <h2 class="{{ $titulo }} mt-4 text-4xl leading-[1.05] text-tinta sm:text-6xl">Estamos en {{ now()->year }}. <span class="texto-degradado">¿Tu negocio ya está en internet?</span></h2>
            </div>
            <p class="text-lg text-stone-600">Si respondes “sí” a alguna, tienes una oportunidad de vender más y trabajar menos. Pasa el mouse o toca cada tarjeta.</p>
        </div>
        <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($negocio['preguntas'] as $item)
                <div tabindex="0" class="revelar group relative flex min-h-56 flex-col overflow-hidden rounded-3xl bg-white p-7 ring-1 ring-stone-200 transition duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-naranja/15 focus:outline-none">
                    <span class="grid size-12 place-items-center rounded-2xl bg-naranja-suave text-naranja-oscuro"><x-icono :nombre="$item['icono']" class="size-6" /></span>
                    <p class="mt-5 text-xl font-bold leading-snug text-tinta">{{ $item['pregunta'] }}</p>
                    {{-- La solución sube al pasar el mouse --}}
                    <div class="absolute inset-0 flex translate-y-full flex-col justify-end bg-gradient-to-br from-naranja to-naranja-oscuro p-7 text-white transition duration-500 group-hover:translate-y-0 group-focus:translate-y-0">
                        <span class="grid size-12 place-items-center rounded-2xl bg-white/20"><x-icono nombre="check" class="size-6" /></span>
                        <p class="mt-4 text-xs font-bold uppercase tracking-widest text-white/75">La solución</p>
                        <p class="mt-1 text-2xl font-bold leading-snug">{{ $item['respuesta'] }}</p>
                    </div>
                    <p class="mt-auto flex items-center gap-1.5 pt-4 text-sm font-semibold text-naranja-oscuro">Ver solución <x-icono nombre="flecha" class="size-4" /></p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============ RUBROS ============ --}}
    <section id="rubros" class="relative overflow-hidden bg-tinta py-24 text-white">
        <div class="fondo-puntos-claro pointer-events-none absolute inset-0"></div>
        <div class="pointer-events-none absolute -right-40 top-0 size-[32rem] rounded-full bg-naranja/25 blur-3xl"></div>
        <div class="relative mx-auto max-w-7xl px-4">
            <div class="grid items-end gap-6 lg:grid-cols-[1.3fr_1fr]">
                <div>
                    <p class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3.5 py-1.5 text-sm font-semibold text-orange-300 ring-1 ring-white/15">Rubros</p>
                    <h2 class="{{ $titulo }} mt-4 text-4xl leading-[1.05] sm:text-6xl">Hecho a la medida de <span class="text-naranja">tu rubro</span></h2>
                </div>
                <p class="text-lg text-white/70">No es una plantilla genérica: cada sistema se arma según cómo trabaja tu negocio. Toca tu rubro y mira qué cambia.</p>
            </div>

            <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($portada as $i => $rubro)
                    <a href="#antes-despues" data-abrir-caso="{{ $i }}" class="revelar group relative block h-64 overflow-hidden sm:h-80 rounded-[2rem] bg-tinta-2 ring-1 ring-white/10">
                        <img src="{{ Formato::foto($rubro['foto'], 800) }}" alt="{{ $rubro['nombre'] }}" loading="lazy" class="absolute inset-0 size-full object-cover transition duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-tinta via-tinta/50 to-tinta/0 transition group-hover:via-tinta/70"></div>
                        <span class="absolute right-4 top-4 grid size-11 place-items-center rounded-full bg-white/15 text-white ring-1 ring-white/30 backdrop-blur transition group-hover:rotate-[-45deg] group-hover:bg-naranja"><x-icono nombre="flecha" class="size-5" /></span>
                        <div class="absolute inset-x-0 bottom-0 p-6">
                            <span class="grid size-11 place-items-center rounded-2xl bg-naranja shadow-lg shadow-naranja/40"><x-icono :nombre="$rubro['icono']" class="size-6" /></span>
                            <p class="mt-3 font-titulo text-2xl font-bold leading-tight">{{ $rubro['nombre'] }}</p>
                            <p class="mt-1 max-h-0 overflow-hidden text-sm text-white/80 opacity-0 transition-all duration-500 group-hover:max-h-24 group-hover:opacity-100">{{ $rubro['detalle'] }}</p>
                            <div class="mt-3 flex flex-wrap gap-1.5">
                                @foreach ($rubro['claves'] as $clave)
                                    <span class="rounded-full bg-white/15 px-2.5 py-1 text-xs font-semibold ring-1 ring-white/20 backdrop-blur">{{ $clave }}</span>
                                @endforeach
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-8 flex flex-wrap items-center gap-3 text-sm text-white/70">
                <span>También trabajamos con:</span>
                @foreach (collect($rubros)->where('portada', false) as $rubro)
                    <span class="rounded-full bg-white/10 px-3 py-1.5 font-medium text-white ring-1 ring-white/15">{{ $rubro['nombre'] }}</span>
                @endforeach
                <a href="#contacto" class="font-semibold text-orange-300 hover:underline">¿Tu rubro no está? Conversemos →</a>
            </div>
        </div>
    </section>

    {{-- ============ WHATSAPP ============ --}}
    <section id="whatsapp" class="relative overflow-hidden bg-gradient-to-br from-emerald-50 via-white to-[#fbf8f4] py-24">
        <div class="fondo-puntos pointer-events-none absolute inset-0 opacity-60"></div>
        <div class="relative mx-auto grid max-w-7xl items-center gap-14 px-4 lg:grid-cols-[1fr_1fr]">
            <div class="revelar">
                <p class="inline-flex items-center gap-2 rounded-full bg-[#25D366]/15 px-3.5 py-1.5 text-sm font-semibold text-emerald-800"><x-icono nombre="whatsapp" class="size-4" />Agenda y avisos por WhatsApp</p>
                <h2 class="{{ $titulo }} mt-4 text-4xl leading-[1.05] text-tinta sm:text-6xl">¡Chao <span class="relative whitespace-nowrap">inasistencias<svg class="absolute -bottom-2 left-0 h-3 w-full text-[#25D366]" viewBox="0 0 200 12" preserveAspectRatio="none" aria-hidden="true"><path d="M2 9C50 3 150 2 198 7" stroke="currentColor" stroke-width="4" fill="none" stroke-linecap="round"/></svg></span>!</h2>
                <p class="mt-5 max-w-xl text-lg leading-relaxed text-stone-600">Tus clientes piden su hora por WhatsApp a cualquier hora, reciben la confirmación al instante y un recordatorio antes de llegar. Tú solo miras la agenda llena.</p>
                <ul class="mt-8 space-y-4">
                    @foreach ([
                        ['calendario', 'Reserva automática', 'Ofrece las horas libres de tu agenda y la confirma sola.'],
                        ['campana', 'Recordatorios', 'Un aviso el día antes y otro un par de horas antes.'],
                        ['chispa', 'Asistente con IA (opcional)', 'Responde precios, horarios y dudas frecuentes de tu negocio.'],
                    ] as [$icono, $tituloItem, $texto])
                        <li class="flex gap-4">
                            <span class="grid size-12 shrink-0 place-items-center rounded-2xl bg-white text-emerald-600 shadow-sm ring-1 ring-emerald-100"><x-icono :nombre="$icono" class="size-6" /></span>
                            <span><strong class="block text-lg text-tinta">{{ $tituloItem }}</strong><span class="text-stone-600">{{ $texto }}</span></span>
                        </li>
                    @endforeach
                </ul>
                <a href="#contacto" class="mt-9 inline-flex items-center gap-2 rounded-full bg-[#25D366] px-7 py-4 font-semibold text-white shadow-xl shadow-emerald-500/30 hover:brightness-95"><x-icono nombre="whatsapp" class="size-5" />Lo quiero en mi negocio</a>
            </div>

            {{-- Teléfono con conversación --}}
            <div class="relative mx-auto w-full max-w-sm" aria-hidden="true">
                <div class="pointer-events-none absolute -inset-10 rounded-full bg-[#25D366]/20 blur-3xl"></div>
                <div class="relative rounded-[3rem] bg-tinta p-3 shadow-2xl shadow-tinta/40">
                    <div class="overflow-hidden rounded-[2.4rem] bg-[#efe7dd]">
                        <div class="flex items-center gap-3 bg-[#075E54] px-5 pb-3 pt-7 text-white">
                            <span class="grid size-10 place-items-center rounded-full bg-white"><x-logo class="size-7" /></span>
                            <span class="text-sm"><strong class="block">Veterinaria Patitas</strong><span class="text-white/70">en línea</span></span>
                        </div>
                        <div id="chat" class="flex min-h-[26rem] flex-col gap-2.5 p-4 text-[14px] leading-snug">
                            <p class="mx-auto rounded-lg bg-white/70 px-2.5 py-1 text-[11px] text-stone-500">HOY</p>
                            @foreach ($negocio['chat'] as [$quien, $texto, $hora])
                                <div @class(['burbuja max-w-[82%] rounded-2xl px-3.5 py-2 shadow-sm', 'self-end rounded-tr-sm bg-[#d9fdd3] text-stone-800' => $quien === 'cliente', 'self-start rounded-tl-sm bg-white text-stone-800' => $quien !== 'cliente'])>
                                    {{ $texto }}<span class="ml-2 inline-block translate-y-1 text-[10px] text-stone-400">{{ $hora }} @if ($quien === 'cliente')<span class="text-sky-500">✓✓</span>@endif</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{-- Tarjeta flotante: agenda --}}
                <div class="flotar absolute -bottom-6 -left-6 rounded-2xl bg-white p-3.5 shadow-2xl ring-1 ring-stone-100 sm:-left-20">
                    <p class="text-[11px] font-semibold text-stone-500">Agenda · mañana</p>
                    <p class="mt-1 flex items-center gap-2 text-sm font-bold text-tinta"><span class="size-2.5 rounded-full bg-emerald-500"></span>10:00 Luna · Control</p>
                    <p class="text-xs text-emerald-600">Agendada por WhatsApp</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ QUÉ HACEMOS (bento) ============ --}}
    <section id="servicios" class="mx-auto max-w-7xl px-4 py-24">
        <div class="grid items-end gap-6 lg:grid-cols-[1.3fr_1fr]">
            <div>
                <p class="{{ $etiqueta }}">Qué hacemos</p>
                <h2 class="{{ $titulo }} mt-4 text-4xl leading-[1.05] text-tinta sm:text-6xl">Todo lo que tu negocio necesita, <span class="texto-degradado">en un solo lugar</span></h2>
            </div>
            <p class="text-lg text-stone-600">Elige solo lo que te sirve hoy. Cada parte se suma a las demás cuando creces.</p>
        </div>
        @php $s = $negocio['servicios']; @endphp
        <div class="mt-12 grid gap-4 md:grid-cols-3">
            {{-- Web: tarjeta grande con navegador --}}
            <div class="revelar group relative overflow-hidden rounded-[2rem] bg-[#fbf8f4] p-8 ring-1 ring-stone-200 md:col-span-2 md:min-h-[19rem]">
                <div class="max-w-sm">
                    <span class="grid size-12 place-items-center rounded-2xl bg-tinta text-white"><x-icono :nombre="$s[0]['icono']" class="size-6" /></span>
                    <h3 class="mt-5 font-titulo text-2xl font-bold text-tinta">{{ $s[0]['titulo'] }}</h3>
                    <p class="mt-2 text-stone-600">{{ $s[0]['texto'] }}</p>
                </div>
                <div class="pointer-events-none mt-6 rounded-2xl bg-white shadow-xl ring-1 ring-stone-200 transition duration-500 group-hover:-translate-y-2 md:absolute md:-bottom-6 md:-right-6 md:mt-0 md:w-[52%]" aria-hidden="true">
                    <div class="flex items-center gap-1.5 border-b border-stone-100 px-4 py-2.5"><span class="size-2.5 rounded-full bg-red-300"></span><span class="size-2.5 rounded-full bg-amber-300"></span><span class="size-2.5 rounded-full bg-emerald-300"></span><span class="ml-3 flex-1 rounded-full bg-stone-100 px-3 py-0.5 text-[11px] text-stone-500">🔒 tunegocio.cl</span></div>
                    <div class="p-4">
                        <div class="h-20 rounded-xl bg-gradient-to-r from-tinta to-tinta-2 p-3"><div class="h-2.5 w-24 rounded bg-white/80"></div><div class="mt-2 h-2 w-32 rounded bg-white/40"></div><div class="mt-3 h-5 w-20 rounded-full bg-naranja"></div></div>
                        <div class="mt-3 grid grid-cols-3 gap-2"><div class="h-12 rounded-lg bg-stone-100"></div><div class="h-12 rounded-lg bg-stone-100"></div><div class="h-12 rounded-lg bg-naranja-suave"></div></div>
                    </div>
                </div>
            </div>
            {{-- WhatsApp: tarjeta alta --}}
            <div class="revelar relative overflow-hidden rounded-[2rem] bg-[#075E54] p-8 text-white md:row-span-2">
                <div class="pointer-events-none absolute -bottom-16 -right-16 size-64 rounded-full bg-[#25D366]/40 blur-2xl"></div>
                <span class="relative grid size-12 place-items-center rounded-2xl bg-[#25D366]"><x-icono :nombre="$s[1]['icono']" class="size-6" /></span>
                <h3 class="relative mt-5 font-titulo text-2xl font-bold">{{ $s[1]['titulo'] }}</h3>
                <p class="relative mt-2 text-white/80">{{ $s[1]['texto'] }}</p>
                <div class="relative mt-8 space-y-2.5 text-sm" aria-hidden="true">
                    @foreach (['✅ Tu hora quedó confirmada para mañana a las 10:00', '⏰ Te esperamos hoy a las 16:00. ¿Confirmas?', '🚗 ¡Tu auto ya está listo para retiro!', '🎂 Tu torta estará lista el sábado a las 11:00'] as $msj)
                        <p class="rounded-2xl rounded-tl-sm bg-white/95 px-3.5 py-2.5 text-stone-800 shadow">{{ $msj }}</p>
                    @endforeach
                </div>
            </div>
            @foreach (array_slice($s, 2) as $k => $item)
                <div class="revelar group rounded-[2rem] bg-white p-7 ring-1 ring-stone-200 transition hover:-translate-y-1 hover:shadow-xl hover:ring-naranja/40 @if ($k === 0) bg-gradient-to-br from-naranja to-naranja-oscuro text-white ring-0 @endif">
                    <span @class(['grid size-12 place-items-center rounded-2xl transition', 'bg-white/20 text-white' => $k === 0, 'bg-naranja-suave text-naranja-oscuro group-hover:bg-naranja group-hover:text-white' => $k !== 0])><x-icono :nombre="$item['icono']" class="size-6" /></span>
                    <h3 @class(['mt-5 font-titulo text-xl font-bold', 'text-tinta' => $k !== 0])>{{ $item['titulo'] }}</h3>
                    <p @class(['mt-2 leading-relaxed', 'text-white/85' => $k === 0, 'text-stone-600' => $k !== 0])>{{ $item['texto'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============ ANTES Y DESPUÉS ============ --}}
    <section id="antes-despues" class="bg-[#fbf8f4] py-24">
        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4">
            <div class="text-center">
                <p class="{{ $etiqueta }}">Antes y después</p>
                <h2 class="{{ $titulo }} mx-auto mt-4 max-w-4xl text-4xl leading-[1.05] text-tinta sm:text-6xl">Del cuaderno y el teléfono a <span class="texto-degradado">todo en un solo lugar</span></h2>
            </div>

            <div class="-mx-4 overflow-x-auto px-4 pb-1">
                <div class="mx-auto flex w-max gap-2 rounded-full bg-white p-1.5 shadow-sm ring-1 ring-stone-200" role="tablist" aria-label="Rubros">
                    @foreach ($rubros as $i => $rubro)
                        <button type="button" role="tab" data-caso="{{ $i }}" aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
                            class="caso-tab flex items-center gap-2 whitespace-nowrap rounded-full px-4 py-2.5 text-[15px] font-semibold text-stone-600 transition hover:text-tinta aria-selected:bg-tinta aria-selected:text-white">
                            <x-icono :nombre="$rubro['icono']" class="size-4" />{{ $rubro['corto'] }}
                        </button>
                    @endforeach
                </div>
            </div>

            @foreach ($rubros as $i => $rubro)
                <div class="caso-panel overflow-hidden rounded-[2rem] bg-white shadow-xl shadow-tinta/5 ring-1 ring-stone-200" data-caso="{{ $i }}" role="tabpanel" @if ($i !== 0) hidden @endif>
                    <div class="grid lg:grid-cols-[1fr_auto_1fr]">
                        <div class="p-8 sm:p-10">
                            <p class="inline-flex items-center gap-2 rounded-full bg-red-50 px-3 py-1 text-sm font-bold text-red-600">😩 Antes</p>
                            <ul class="mt-6 space-y-4">
                                @foreach ($rubro['antes'] as $item)
                                    <li class="flex gap-3 leading-relaxed text-stone-500 line-through decoration-red-300/70 decoration-2"><span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-red-50 text-xs text-red-500 no-underline" aria-hidden="true">✕</span><span>{{ $item }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="relative hidden w-56 lg:block">
                            <img src="{{ Formato::foto($rubro['foto'], 500) }}" alt="{{ $rubro['nombre'] }}" loading="lazy" class="absolute inset-0 size-full object-cover">
                            <div class="absolute inset-0 bg-tinta/30"></div>
                            <span class="absolute left-1/2 top-1/2 grid size-16 -translate-x-1/2 -translate-y-1/2 place-items-center rounded-full bg-naranja text-white shadow-2xl ring-8 ring-white"><x-icono nombre="flecha" class="size-7" /></span>
                        </div>
                        <div class="relative bg-tinta p-8 text-white sm:p-10">
                            <div class="pointer-events-none absolute -right-10 -top-10 size-48 rounded-full bg-naranja/30 blur-3xl"></div>
                            <p class="relative inline-flex items-center gap-2 rounded-full bg-naranja px-3 py-1 text-sm font-bold">🚀 Con {{ $negocio['nombre'] }}</p>
                            <ul class="relative mt-6 space-y-4">
                                @foreach ($rubro['ahora'] as $item)
                                    <li class="flex gap-3 leading-relaxed"><span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-emerald-500"><x-icono nombre="check" class="size-4" /></span>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center justify-between gap-4 border-t border-stone-200 bg-naranja-suave px-8 py-5 sm:px-10">
                        <p class="flex items-center gap-3 text-lg font-bold text-tinta"><span class="grid size-10 place-items-center rounded-xl bg-naranja text-white"><x-icono :nombre="$rubro['icono']" class="size-5" /></span>{{ $rubro['resultado'] }}</p>
                        <a href="#contacto" class="font-semibold text-naranja-oscuro hover:underline">Lo quiero para mi negocio →</a>
                    </div>
                </div>
            @endforeach

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($negocio['beneficios'] as $b)
                    <div class="revelar rounded-3xl bg-white p-6 ring-1 ring-stone-200">
                        <p class="font-titulo text-xl font-bold text-tinta">{{ $b['titulo'] }}</p>
                        <p class="mt-1.5 text-[15px] leading-relaxed text-stone-600">{{ $b['texto'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ LO QUE VE TU CLIENTE / LO QUE VES TÚ ============ --}}
    <section class="relative overflow-hidden bg-tinta text-white">
        <div class="fondo-puntos-claro pointer-events-none absolute inset-0"></div>
        <div class="pointer-events-none absolute -left-32 top-10 size-96 rounded-full bg-naranja/25 blur-3xl"></div>
        <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 py-24 lg:grid-cols-2">
            <div class="flex flex-col gap-5">
                <h2 class="{{ $titulo }} text-4xl leading-[1.05] sm:text-6xl">Lo que ve tu cliente.<br><span class="text-naranja">Lo que ves tú.</span></h2>
                <p class="text-lg leading-relaxed text-white/70">Tu cliente entra a tu web, elige el servicio y reserva o pide una cotización. Tú lo ves al instante en tu panel, desde el computador o el celular.</p>
                <img src="{{ Formato::foto($negocio['foto_portada'], 900) }}" alt="Trabajadora atendiendo con la pantalla del mostrador" loading="lazy" class="aspect-[3/2] w-full rounded-[2rem] bg-tinta-2 object-cover ring-1 ring-white/10">
            </div>
            <div class="flex items-end gap-4" aria-hidden="true">
                <div class="flotar hidden w-48 shrink-0 rounded-[2rem] border-[7px] border-slate-800 bg-white p-3.5 text-tinta shadow-2xl sm:block">
                    <p class="text-xs text-stone-500">Tu web en el celular</p>
                    <p class="mt-2 font-bold">Reserva tu hora</p>
                    <div class="mt-2 flex flex-col gap-1.5 text-xs">
                        <span class="rounded-lg border border-stone-200 p-2">Sesión de kinesiología</span>
                        <span class="rounded-lg border border-stone-200 p-2">Miércoles 04/11</span>
                        <span class="rounded-lg bg-naranja p-2 text-center font-semibold text-white">16:00 · Reservar</span>
                    </div>
                </div>
                <div class="min-w-0 flex-1 rounded-3xl bg-white p-5 text-tinta shadow-2xl">
                    <p class="flex items-center gap-1.5 text-xs font-bold text-stone-500"><x-logo class="size-4" />Tu panel</p>
                    <div class="mt-3 grid grid-cols-3 gap-2">
                        <div class="rounded-xl bg-stone-100 p-3"><p class="text-[11px] text-stone-500">Hoy</p><p class="text-xl font-bold">14 citas</p></div>
                        <div class="rounded-xl bg-naranja-suave p-3"><p class="text-[11px] text-stone-500">Por confirmar</p><p class="text-xl font-bold text-naranja-oscuro">3</p></div>
                        <div class="rounded-xl bg-stone-100 p-3"><p class="text-[11px] text-stone-500">Cotizaciones</p><p class="text-xl font-bold">6</p></div>
                    </div>
                    <div class="mt-3 flex h-20 items-end gap-1.5 rounded-xl bg-stone-50 p-3">
                        @foreach ([40, 55, 35, 70, 60, 85, 95] as $alto)
                            <span class="flex-1 rounded-t bg-gradient-to-t from-naranja to-amber-400" style="height: {{ $alto }}%"></span>
                        @endforeach
                    </div>
                    <div class="mt-3 flex flex-col gap-1.5 text-sm">
                        <div class="flex justify-between rounded-lg border border-stone-200 px-3 py-2"><span>16:00 Camila R.</span><span class="font-semibold text-naranja-oscuro">Nueva desde la web</span></div>
                        <div class="flex justify-between rounded-lg border border-stone-200 px-3 py-2"><span>16:45 Jorge M.</span><span class="text-stone-500">Confirmada</span></div>
                        <div class="flex justify-between rounded-lg border border-stone-200 px-3 py-2"><span>17:30 Ana P.</span><span class="text-stone-500">Confirmada</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ CÓMO TRABAJAMOS ============ --}}
    <section class="mx-auto max-w-7xl px-4 py-24">
        <div class="text-center">
            <p class="{{ $etiqueta }}">Cómo trabajamos</p>
            <h2 class="{{ $titulo }} mt-4 text-4xl text-tinta sm:text-6xl">De la idea a tu web funcionando</h2>
        </div>
        <ol class="relative mt-14 grid gap-8 md:grid-cols-4 md:gap-6">
            <div class="absolute left-[12.5%] right-[12.5%] top-8 hidden border-t-2 border-dashed border-naranja/40 md:block" aria-hidden="true"></div>
            @foreach ($negocio['proceso'] as $i => $paso)
                <li class="revelar relative text-center">
                    <span class="relative mx-auto grid size-16 place-items-center rounded-full bg-naranja text-white shadow-xl shadow-naranja/30 ring-8 ring-white"><x-icono :nombre="$paso['icono']" class="size-7" /></span>
                    <p class="mt-4 text-xs font-bold uppercase tracking-widest text-naranja-oscuro">Paso {{ $i + 1 }}</p>
                    <h3 class="mt-1 font-titulo text-xl font-bold text-tinta">{{ $paso['titulo'] }}</h3>
                    <p class="mx-auto mt-2 max-w-xs text-stone-600">{{ $paso['texto'] }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- ============ PLANES ============ --}}
    <section id="planes" class="relative overflow-hidden bg-[#fbf8f4] py-24">
        <div class="fondo-puntos pointer-events-none absolute inset-0 [mask-image:linear-gradient(to_bottom,black,transparent)]"></div>
        <div class="relative mx-auto max-w-7xl px-4">
            <div class="text-center">
                <p class="{{ $etiqueta }}">Precios claros</p>
                <h2 class="{{ $titulo }} mt-4 text-4xl text-tinta sm:text-6xl">Planes</h2>
                <p class="mx-auto mt-3 max-w-2xl text-lg text-stone-600">Un valor inicial y una mensualidad con todo incluido. Empieza simple y crece cuando lo necesites.</p>
            </div>
            <div class="mt-14 grid items-center gap-5 lg:grid-cols-3">
                @foreach ($negocio['paquetes'] as $plan)
                    <div @class(['revelar relative flex flex-col rounded-[2rem] p-8', 'bg-tinta text-white shadow-2xl shadow-tinta/30 ring-4 ring-naranja lg:py-12' => $plan['destacado'], 'bg-white ring-1 ring-stone-200' => ! $plan['destacado']])>
                        @if ($plan['destacado'])<p class="absolute -top-4 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-full bg-naranja px-4 py-1.5 text-sm font-bold text-white shadow-lg">⭐ El más pedido</p>@endif
                        <h3 class="font-titulo text-2xl font-bold">{{ $plan['nombre'] }}</h3>
                        <p @class(['mt-1.5 text-[15px]', 'text-white/70' => $plan['destacado'], 'text-stone-600' => ! $plan['destacado']])>{{ $plan['para'] }}</p>
                        <p class="mt-6"><span @class(['text-sm', 'text-white/60' => $plan['destacado'], 'text-stone-500' => ! $plan['destacado']])>desde</span> <span @class([$titulo, 'text-[2.8rem]', 'text-orange-300' => $plan['destacado']])>{{ $clp($plan['desde']) }}</span></p>
                        <p @class(['text-sm', 'text-white/60' => $plan['destacado'], 'text-stone-500' => ! $plan['destacado']])>+ {{ $clp($plan['mensual']) }} al mes</p>
                        <ul class="mt-6 flex-1 space-y-2.5 text-[15px]">
                            @foreach ($plan['incluye'] as $item)
                                <li class="flex gap-2.5"><span class="mt-0.5 grid size-5 shrink-0 place-items-center rounded-full bg-naranja text-white"><x-icono nombre="check" class="size-3.5" /></span>{{ $item }}</li>
                            @endforeach
                        </ul>
                        <a href="#contacto" data-plan="{{ $plan['nombre'] }}" @class(['elegir-plan mt-8 rounded-full px-4 py-3.5 text-center font-semibold transition', 'bg-naranja text-white hover:bg-naranja-oscuro' => $plan['destacado'], 'bg-tinta text-white hover:bg-tinta-2' => ! $plan['destacado']])>Cotizar este plan</a>
                    </div>
                @endforeach
            </div>
            <div class="mt-8 rounded-[2rem] bg-white p-7 ring-1 ring-stone-200">
                <p class="font-bold text-tinta">La mensualidad incluye:</p>
                <ul class="mt-3 grid gap-x-6 gap-y-2 text-[15px] text-stone-700 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($negocio['mensualidad'] as $item)
                        <li class="flex gap-2"><x-icono nombre="check" class="mt-0.5 size-4 shrink-0 text-naranja" />{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            <p class="mt-5 text-center text-sm text-stone-500">Valores en pesos chilenos, más IVA. Contrato de mantención mínimo de 12 meses.</p>

            {{-- Garantías --}}
            <div class="mt-14 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($negocio['garantias'] as $g)
                    <div class="flex gap-4 rounded-3xl bg-white/70 p-5 ring-1 ring-stone-200">
                        <span class="grid size-12 shrink-0 place-items-center rounded-2xl bg-tinta text-white"><x-icono :nombre="$g['icono']" class="size-6" /></span>
                        <div><p class="font-bold text-tinta">{{ $g['titulo'] }}</p><p class="text-sm text-stone-600">{{ $g['texto'] }}</p></div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ DEMO ============ --}}
    <section class="mx-auto max-w-7xl px-4 py-20">
        <div class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-naranja via-naranja to-amber-500 p-8 text-white sm:p-14">
            <div class="fondo-puntos-claro pointer-events-none absolute inset-0"></div>
            <div class="pointer-events-none absolute -right-20 -top-20 size-96 rounded-full bg-white/20 blur-3xl"></div>
            <div class="relative flex flex-col items-start justify-between gap-8 md:flex-row md:items-center">
                <div class="max-w-2xl">
                    <p class="inline-flex items-center gap-2 rounded-full bg-white/20 px-3.5 py-1.5 text-sm font-semibold"><span class="size-2 animate-pulse rounded-full bg-white"></span>Demo en vivo</p>
                    <h2 class="{{ $titulo }} mt-4 text-4xl leading-[1.05] sm:text-6xl">Pruébalo antes de contratar</h2>
                    <p class="mt-4 text-lg text-white/90">Reserva una hora en un centro de salud de ejemplo, pide un presupuesto y mira cómo llega todo a su panel de gestión.</p>
                </div>
                <a href="{{ route('demo') }}" class="group inline-flex shrink-0 items-center gap-2 rounded-full bg-tinta px-8 py-5 text-lg font-semibold text-white shadow-2xl transition hover:-translate-y-0.5">Abrir el demo <x-icono nombre="flecha" class="size-5 transition group-hover:translate-x-1" /></a>
            </div>
        </div>
    </section>

    {{-- ============ PREGUNTAS FRECUENTES ============ --}}
    <section class="mx-auto grid max-w-7xl gap-10 px-4 pb-24 lg:grid-cols-[0.8fr_1.2fr]">
        <div>
            <p class="{{ $etiqueta }}">Dudas</p>
            <h2 class="{{ $titulo }} mt-4 text-4xl text-tinta sm:text-5xl">Preguntas frecuentes</h2>
            <p class="mt-3 text-lg text-stone-600">¿Tienes otra pregunta? Escríbenos por WhatsApp y te respondemos al tiro.</p>
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener" class="mt-6 inline-flex items-center gap-2 rounded-full bg-[#25D366] px-6 py-3 font-semibold text-white hover:brightness-95"><x-icono nombre="whatsapp" class="size-5" />Preguntar por WhatsApp</a>
        </div>
        <div class="space-y-3">
            @foreach ([
                ['¿Cuánto se demora?', 'Una web informativa toma entre 1 y 2 semanas. Una plataforma con gestión, entre 4 y 8 semanas según los módulos.'],
                ['¿Qué incluye la mensualidad?', 'Hosting, dominio, certificado de seguridad, respaldos, soporte y una bolsa de horas al mes para cambios y mejoras.'],
                ['¿Puedo empezar con la web y después sumar el sistema?', 'Sí. Todo se construye sobre la misma base, así que puedes subir de plan sin empezar de cero.'],
                ['¿Funciona con WhatsApp?', 'Sí. Podemos enviar confirmaciones, recordatorios y avisos automáticos por WhatsApp, y sumar un asistente que responde preguntas frecuentes.'],
                ['¿Los datos son míos?', 'Sí. Tus datos y los de tus clientes son tuyos, y si algún día te vas te los entregamos.'],
                ['¿Necesito saber de computación?', 'No. Te enseñamos a usar el panel y quedamos disponibles por WhatsApp para cualquier duda.'],
                ['¿Puedo pagar el valor inicial en partes?', 'Sí. Normalmente se paga 50% al empezar y 50% al lanzar, y podemos conversar otras opciones.'],
            ] as [$pregunta, $respuesta])
                <details class="group rounded-2xl bg-white p-5 ring-1 ring-stone-200 open:ring-naranja/40" @if ($loop->first) open @endif>
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-lg font-semibold text-tinta [&::-webkit-details-marker]:hidden">{{ $pregunta }}<span class="grid size-8 shrink-0 place-items-center rounded-full bg-naranja-suave text-xl text-naranja-oscuro transition group-open:rotate-45 group-open:bg-naranja group-open:text-white" aria-hidden="true">+</span></summary>
                    <p class="mt-3 leading-relaxed text-stone-600">{{ $respuesta }}</p>
                </details>
            @endforeach
        </div>
    </section>

    {{-- ============ CONTACTO ============ --}}
    <section id="contacto" class="relative overflow-hidden bg-tinta py-24">
        <div class="fondo-puntos-claro pointer-events-none absolute inset-0"></div>
        <div class="pointer-events-none absolute -bottom-40 -left-40 size-[32rem] rounded-full bg-naranja/30 blur-3xl"></div>
        <div class="relative mx-auto grid max-w-7xl gap-10 px-4 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
            <div class="text-white">
                <h2 class="{{ $titulo }} text-5xl leading-[1.02] sm:text-7xl">Conversemos de <span class="text-naranja">tu negocio</span></h2>
                <p class="mt-5 max-w-md text-lg text-white/70">Cuéntanos qué necesitas y te contactamos dentro de 24 horas hábiles con una propuesta. La primera reunión es gratis.</p>
                <ul class="mt-8 space-y-4">
                    <li><a href="{{ $whatsapp }}" target="_blank" rel="noopener" class="flex items-center gap-3 font-semibold hover:text-orange-300"><span class="grid size-12 place-items-center rounded-2xl bg-[#25D366]"><x-icono nombre="whatsapp" class="size-6" /></span>Escríbenos por WhatsApp</a></li>
                    <li><a href="mailto:{{ $negocio['email'] }}" class="flex items-center gap-3 hover:text-orange-300"><span class="grid size-12 place-items-center rounded-2xl bg-white/10"><x-icono nombre="mensaje" class="size-6" /></span>{{ $negocio['email'] }}</a></li>
                    <li class="flex items-center gap-3"><span class="grid size-12 place-items-center rounded-2xl bg-white/10"><x-logo class="size-7" invertido /></span>{{ $negocio['ciudad'] }}</li>
                </ul>
            </div>

            <form method="POST" action="{{ route('contacto') }}" class="space-y-4 rounded-[2rem] bg-white p-7 text-tinta shadow-2xl sm:p-10">
                @csrf
                @if (session('ok'))
                    <p class="rounded-xl bg-emerald-50 p-3 text-sm font-medium text-emerald-800">{{ session('ok') }}</p>
                @endif
                @if ($errors->any())
                    <div class="rounded-xl bg-red-50 p-3 text-sm text-red-700">@foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>
                @endif
                <p class="font-titulo text-2xl font-bold">Pide tu cotización gratis</p>
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm font-medium">Nombre *<input name="nombre" value="{{ old('nombre') }}" required class="{{ $campo }}"></label>
                    <label class="block text-sm font-medium">Nombre del negocio<input name="negocio" value="{{ old('negocio') }}" class="{{ $campo }}"></label>
                    <label class="block text-sm font-medium">Teléfono / WhatsApp *<input name="telefono" type="tel" value="{{ old('telefono') }}" required placeholder="+56 9 1234 5678" class="{{ $campo }}"></label>
                    <label class="block text-sm font-medium">Correo<input name="email" type="email" value="{{ old('email') }}" class="{{ $campo }}"></label>
                    <label class="block text-sm font-medium">Rubro
                        <select name="rubro" id="campo-rubro" class="{{ $campo }}">
                            <option value="">Selecciona</option>
                            @foreach ($rubros as $rubro)
                                <option @selected(old('rubro') === $rubro['nombre'])>{{ $rubro['nombre'] }}</option>
                            @endforeach
                            <option @selected(old('rubro') === 'Otro')>Otro</option>
                        </select>
                    </label>
                    <label class="block text-sm font-medium">Plan de interés
                        <select name="paquete" id="campo-paquete" class="{{ $campo }}">
                            <option value="">No sé todavía</option>
                            @foreach ($negocio['paquetes'] as $plan)
                                <option @selected(old('paquete') === $plan['nombre'])>{{ $plan['nombre'] }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <label class="block text-sm font-medium">¿Qué te gustaría resolver?<textarea name="mensaje" rows="3" class="{{ $campo }}">{{ old('mensaje') }}</textarea></label>
                <button class="group flex w-full items-center justify-center gap-2 rounded-full bg-naranja px-6 py-4 text-lg font-semibold text-white shadow-lg shadow-naranja/30 hover:bg-naranja-oscuro">Quiero mi cotización gratis <x-icono nombre="flecha" class="size-5 transition group-hover:translate-x-1" /></button>
                <p class="text-center text-xs text-stone-500">Sin compromiso. No compartimos tus datos.</p>
            </form>
        </div>
    </section>
</main>

<footer class="border-t border-white/10 bg-tinta text-white/70">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <p class="flex items-center gap-2.5 text-white"><x-logo class="size-8" invertido /><span class="{{ $titulo }} text-xl">{{ $negocio['nombre'] }}</span></p>
            <p class="mt-3 text-sm leading-relaxed">Páginas web y sistemas de gestión para pymes de {{ $negocio['ciudad'] }}.</p>
        </div>
        <div>
            <p class="font-semibold text-white">Qué hacemos</p>
            <ul class="mt-3 space-y-2 text-sm">
                @foreach (array_slice($negocio['servicios'], 0, 4) as $s)<li><a href="#servicios" class="hover:text-white">{{ $s['titulo'] }}</a></li>@endforeach
            </ul>
        </div>
        <div>
            <p class="font-semibold text-white">Rubros</p>
            <ul class="mt-3 grid grid-cols-1 gap-2 text-sm">
                @foreach ($portada->take(6) as $rubro)<li><a href="#rubros" class="hover:text-white">{{ $rubro['nombre'] }}</a></li>@endforeach
            </ul>
        </div>
        <div>
            <p class="font-semibold text-white">Contacto</p>
            <ul class="mt-3 space-y-2 text-sm">
                <li><a href="{{ $whatsapp }}" target="_blank" rel="noopener" class="hover:text-white">WhatsApp</a></li>
                <li><a href="mailto:{{ $negocio['email'] }}" class="hover:text-white">{{ $negocio['email'] }}</a></li>
                <li><a href="{{ route('demo') }}" class="hover:text-white">Ver demo</a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-7xl flex-wrap justify-between gap-2 px-4 py-5 text-xs">
            <span>© {{ date('Y') }} {{ $negocio['nombre'] }} · {{ $negocio['ciudad'] }}</span>
            <span>Fotografías: <a href="https://www.pexels.com" class="hover:text-white" rel="noopener">Pexels</a></span>
        </div>
    </div>
</footer>

<script>
    const sinMovimiento = matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Al elegir un plan, queda seleccionado en el formulario.
    document.querySelectorAll('.elegir-plan').forEach(boton => {
        boton.addEventListener('click', () => {
            document.getElementById('campo-paquete').value = boton.dataset.plan;
        });
    });

    // Slider de la portada: cambia foto, tarjetas y la palabra del título cada 6 segundos.
    (() => {
        const slider = document.querySelector('.slider');
        if (!slider) return;
        const slides = slider.querySelectorAll('.slide');
        const puntos = slider.querySelectorAll('.punto');
        const palabra = document.getElementById('palabra');
        const progreso = document.getElementById('progreso');
        const DURACION = 6000;
        let actual = 0, pausa = false, transcurrido = 0;
        const ir = (n) => {
            actual = (n + slides.length) % slides.length;
            transcurrido = 0;
            slides.forEach((s, i) => {
                const activo = i === actual;
                s.classList.toggle('opacity-0', !activo);
                s.classList.toggle('pointer-events-none', !activo);
                s.setAttribute('aria-hidden', activo ? 'false' : 'true');
            });
            puntos.forEach((p, i) => {
                const activo = i === actual;
                ['bg-tinta', 'text-white', 'ring-tinta'].forEach(c => p.classList.toggle(c, activo));
                ['bg-white', 'text-stone-600', 'ring-stone-200'].forEach(c => p.classList.toggle(c, !activo));
            });
            palabra.textContent = slides[actual].dataset.palabra;
            palabra.classList.remove('palabra-entra');
            void palabra.offsetWidth; // reinicia la animación
            palabra.classList.add('palabra-entra');
        };
        puntos.forEach(p => p.addEventListener('click', () => ir(+p.dataset.ir)));
        slider.addEventListener('mouseenter', () => pausa = true);
        slider.addEventListener('mouseleave', () => pausa = false);
        if (!sinMovimiento) {
            setInterval(() => {
                if (pausa) return;
                transcurrido += 100;
                if (progreso) progreso.style.width = (transcurrido / DURACION * 100) + '%';
                if (transcurrido >= DURACION) ir(actual + 1);
            }, 100);
        }
    })();

    // Pestañas de "Antes y después".
    const abrirCaso = (caso) => {
        document.querySelectorAll('.caso-tab').forEach(t => t.setAttribute('aria-selected', t.dataset.caso === caso ? 'true' : 'false'));
        document.querySelectorAll('.caso-panel').forEach(p => p.hidden = p.dataset.caso !== caso);
    };
    document.querySelectorAll('.caso-tab').forEach(tab => tab.addEventListener('click', () => abrirCaso(tab.dataset.caso)));
    // Al tocar un rubro de la grilla, se abre su "Antes y después".
    document.querySelectorAll('[data-abrir-caso]').forEach(a => a.addEventListener('click', () => {
        abrirCaso(a.dataset.abrirCaso);
        const rubro = a.querySelector('p')?.textContent.trim();
        const campo = document.getElementById('campo-rubro');
        if (campo && rubro) campo.value = rubro;
    }));

    // Animaciones al hacer scroll y chat de WhatsApp.
    const observador = new IntersectionObserver((entradas) => {
        entradas.forEach(e => {
            if (!e.isIntersecting) return;
            e.target.classList.add(e.target.id === 'chat' ? 'chat-visible' : 'visto');
            observador.unobserve(e.target);
        });
    }, { threshold: 0.15 });
    document.querySelectorAll('.revelar, #chat').forEach(el => observador.observe(el));
</script>
@endsection
