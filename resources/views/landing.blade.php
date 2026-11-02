@extends('layouts.app')

@php
    use App\Support\Formato;

    $negocio = config('negocio');
    $rubros = $negocio['rubros'];
    $portada = collect($rubros)->where('portada', true)->take(6);
    $clp = fn ($n) => Formato::clp($n);
    $titulo = 'font-titulo font-extrabold tracking-tight';
    $etiqueta = 'text-sm font-semibold uppercase tracking-widest text-naranja-oscuro';
    $campo = 'mt-1.5 w-full rounded-xl border border-stone-300 bg-white px-3.5 py-3 focus:border-tinta focus:outline-none focus:ring-2 focus:ring-naranja/30';
    $whatsapp = 'https://wa.me/'.$negocio['whatsapp'].'?text='.urlencode('Hola, quiero información para mi negocio');
@endphp

@section('contenido')
{{-- Franja de oferta --}}
<div class="bg-naranja px-4 py-2 text-center text-sm font-medium text-white">
    Primera reunión y diagnóstico de tu negocio <strong>gratis</strong>. <a href="#contacto" class="underline underline-offset-2 hover:no-underline">Agenda la tuya →</a>
</div>

{{-- Encabezado --}}
<header class="sticky top-0 z-40 border-b border-white/10 bg-tinta/95 text-white backdrop-blur">
    <nav class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3">
        <a href="#" class="flex items-center gap-2.5">
            <x-logo class="size-9" invertido />
            <span class="{{ $titulo }} text-xl">{{ $negocio['nombre'] }}</span>
        </a>
        <div class="hidden items-center gap-7 text-[15px] text-white/80 lg:flex">
            <a href="#servicios" class="hover:text-white">Qué hacemos</a>
            <a href="#rubros" class="hover:text-white">Rubros</a>
            <a href="#antes-despues" class="hover:text-white">Antes y después</a>
            <a href="#planes" class="hover:text-white">Planes</a>
            <a href="{{ route('demo') }}" class="hover:text-white">Demo</a>
        </div>
        <a href="#contacto" class="rounded-full bg-naranja px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-naranja/30 hover:bg-naranja-oscuro">Cotiza gratis</a>
    </nav>
</header>

<main>
    {{-- Portada --}}
    <section class="relative overflow-hidden bg-tinta text-white">
        <div class="pointer-events-none absolute -right-40 -top-40 size-[36rem] rounded-full bg-naranja/25 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-52 -left-40 size-[30rem] rounded-full bg-sky-400/10 blur-3xl"></div>
        <div class="relative mx-auto grid max-w-6xl items-center gap-14 px-4 pb-24 pt-14 lg:grid-cols-[1fr_1.05fr] lg:pt-20">
            <div class="flex flex-col gap-6">
                <p class="inline-flex items-center gap-2 self-start rounded-full bg-white/10 px-3.5 py-1.5 text-sm text-white/90 ring-1 ring-white/15"><span class="size-2 rounded-full bg-emerald-400"></span>Páginas web y sistemas para pymes de Ñuble</p>
                <h1 class="{{ $titulo }} text-[2.7rem] leading-[1.02] sm:text-6xl lg:text-[4.2rem]">Tu negocio abierto <span class="text-naranja">las 24 horas</span>, y todo ordenado en un solo lugar.</h1>
                <p class="max-w-xl text-lg leading-relaxed text-white/75">Desde una web sencilla para mostrar tus productos o servicios, hasta una plataforma completa para vender, agendar, cotizar y controlar la gestión de tu empresa. Hecho en {{ $negocio['ciudad'] }}, con soporte por WhatsApp.</p>
                <div class="flex flex-wrap gap-3">
                    <a href="#contacto" class="rounded-full bg-naranja px-7 py-4 font-semibold text-white shadow-xl shadow-naranja/30 hover:bg-naranja-oscuro">Quiero mi web</a>
                    <a href="{{ route('demo') }}" class="rounded-full bg-white/10 px-7 py-4 font-semibold text-white ring-1 ring-white/25 hover:bg-white/20">Ver un ejemplo funcionando →</a>
                </div>
                <ul class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-white/75">
                    @foreach (['Reunión gratis', 'Listo en 2 a 8 semanas', 'Tus datos son tuyos'] as $item)
                        <li class="flex items-center gap-1.5"><x-icono nombre="check" class="size-4 text-naranja" />{{ $item }}</li>
                    @endforeach
                </ul>
            </div>

            {{-- Slider de rubros: foto del negocio + lo que el sistema le resuelve --}}
            <div class="slider relative" aria-roledescription="carrusel" aria-label="Ejemplos por rubro">
                <div class="relative aspect-[4/4.7] sm:aspect-[4/3.2]">
                    @foreach ($negocio['slider'] as $i => $slide)
                        <div class="slide absolute inset-0 transition-opacity duration-700 @if ($i !== 0) pointer-events-none opacity-0 @endif" data-slide="{{ $i }}" aria-hidden="{{ $i === 0 ? 'false' : 'true' }}">
                            <div class="absolute inset-0 overflow-hidden rounded-3xl bg-tinta-2 shadow-2xl shadow-black/40 ring-1 ring-white/10">
                                <img src="{{ Formato::foto($slide['foto'], 1000) }}" alt="{{ $slide['rubro'] }}" @if ($i !== 0) loading="lazy" @endif class="size-full object-cover" style="object-position: {{ $slide['posicion'] ?? 'center' }}">
                                <div @class(['absolute inset-0 to-transparent', 'bg-gradient-to-t from-tinta via-tinta/40' => empty($slide['texto_arriba']), 'bg-gradient-to-b from-tinta/90 via-tinta/30' => ! empty($slide['texto_arriba'])])></div>
                                <div @class(['absolute inset-x-0 p-5 sm:p-6', 'bottom-0' => empty($slide['texto_arriba']), 'top-0 pt-14 sm:pt-16' => ! empty($slide['texto_arriba'])])>
                                    <p class="flex items-center gap-2 text-sm font-semibold text-orange-300"><x-icono :nombre="$slide['icono']" class="size-4" />{{ $slide['rubro'] }}</p>
                                    <p class="mt-1 max-w-[18rem] text-lg font-semibold leading-snug sm:max-w-[55%] sm:text-xl">{{ $slide['frase'] }}</p>
                                </div>
                            </div>

                            {{-- Mini panel del sistema --}}
                            <div @class(['absolute -right-2 top-16 w-60 rounded-2xl bg-white p-3.5 text-tinta shadow-2xl sm:-right-8 sm:w-72 xl:-right-20 2xl:-right-48 min-[1900px]:-right-60', 'sm:top-auto sm:bottom-16' => empty($slide['panel_arriba']), 'sm:top-10' => ! empty($slide['panel_arriba'])]) aria-hidden="true">
                                <div class="flex items-center justify-between">
                                    <p class="flex items-center gap-1.5 text-xs font-bold"><x-logo class="size-4" />{{ $slide['panel'] }}</p>
                                    <span class="flex gap-1"><span class="size-2 rounded-full bg-red-300"></span><span class="size-2 rounded-full bg-amber-300"></span><span class="size-2 rounded-full bg-emerald-300"></span></span>
                                </div>
                                <div class="mt-2.5 space-y-1.5 text-[11px] sm:text-xs">
                                    @foreach ($slide['filas'] as [$texto, $estado])
                                        <div class="flex items-center justify-between gap-2 rounded-lg border border-stone-200 px-2.5 py-2">
                                            <span class="truncate">{{ $texto }}</span>
                                            <span @class(['shrink-0 font-semibold', 'text-naranja-oscuro' => in_array($estado, ['Nuevo', 'Nueva', 'Borrador', 'Presupuesto']), 'text-emerald-600' => ! in_array($estado, ['Nuevo', 'Nueva', 'Borrador', 'Presupuesto'])])>{{ $estado }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Aviso flotante --}}
                            <div class="absolute -top-4 left-4 flex items-center gap-2.5 rounded-2xl bg-white px-3.5 py-2.5 text-tinta shadow-xl sm:left-6" aria-hidden="true">
                                <span class="grid size-8 place-items-center rounded-full bg-emerald-100 text-emerald-600"><x-icono nombre="check" class="size-4" /></span>
                                <span class="text-xs"><strong class="block text-sm">{{ $slide['aviso'][0] }}</strong>{{ $slide['aviso'][1] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Controles --}}
                <div class="mt-5 flex flex-wrap items-center gap-2">
                    @foreach ($negocio['slider'] as $i => $slide)
                        <button type="button" data-ir="{{ $i }}" aria-label="Ver {{ $slide['rubro'] }}" @class(['punto flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold ring-1 transition', 'bg-naranja text-white ring-naranja' => $i === 0, 'text-white/70 ring-white/20 hover:text-white' => $i !== 0])>
                            <x-icono :nombre="$slide['icono']" class="size-3.5" /><span class="hidden sm:inline">{{ $slide['corto'] ?? \Illuminate\Support\Str::before($slide['rubro'], ' y ') }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Cinta de rubros --}}
        <div class="relative overflow-hidden border-t border-white/10 bg-tinta-2 py-4">
            <div class="cinta flex w-max gap-10 whitespace-nowrap text-white/70">
                @foreach ([1, 2] as $vuelta)
                    @foreach ($rubros as $rubro)
                        <span class="flex items-center gap-2.5 text-[15px] font-medium"><x-icono :nombre="$rubro['icono']" class="size-5 text-naranja" />{{ $rubro['nombre'] }}</span>
                    @endforeach
                @endforeach
            </div>
        </div>
    </section>

    {{-- Preguntas que hacen pensar al cliente --}}
    <section id="preguntas" class="mx-auto max-w-6xl px-4 py-20">
        <div class="max-w-3xl">
            <p class="{{ $etiqueta }}">¿Te pasa esto?</p>
            <h2 class="{{ $titulo }} mt-2 text-4xl leading-tight sm:text-5xl">Estamos en {{ now()->year }}. ¿Tu negocio ya está en internet?</h2>
            <p class="mt-3 text-lg text-stone-600">Si respondes “sí” a alguna de estas preguntas, podemos ayudarte.</p>
        </div>
        <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($negocio['preguntas'] as $item)
                <div class="group flex flex-col gap-3 rounded-3xl border border-stone-200 bg-white p-6 transition hover:-translate-y-1 hover:border-naranja/40 hover:shadow-xl hover:shadow-naranja/10">
                    <span class="grid size-11 place-items-center rounded-2xl bg-naranja-suave text-naranja-oscuro transition group-hover:bg-naranja group-hover:text-white"><x-icono :nombre="$item['icono']" class="size-5" /></span>
                    <p class="text-lg font-semibold leading-snug">{{ $item['pregunta'] }}</p>
                    <p class="text-stone-600"><span class="font-semibold text-naranja-oscuro">Solución:</span> {{ $item['respuesta'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Qué hacemos --}}
    <section id="servicios" class="bg-arena py-20">
        <div class="mx-auto max-w-6xl px-4">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <div class="max-w-2xl">
                    <p class="{{ $etiqueta }}">Qué hacemos</p>
                    <h2 class="{{ $titulo }} mt-2 text-4xl leading-tight sm:text-5xl">Todo lo que tu negocio necesita para vender y ordenarse</h2>
                </div>
                <p class="max-w-sm text-stone-600">Elige solo lo que te sirve. Cada parte se suma a las demás cuando creces.</p>
            </div>
            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($negocio['servicios'] as $s)
                    <div class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-stone-200/70">
                        <span class="grid size-12 place-items-center rounded-2xl bg-tinta text-white"><x-icono :nombre="$s['icono']" class="size-6" /></span>
                        <h3 class="mt-5 text-xl font-bold">{{ $s['titulo'] }}</h3>
                        <p class="mt-2 leading-relaxed text-stone-600">{{ $s['texto'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Rubros con fotos --}}
    <section id="rubros" class="mx-auto max-w-6xl px-4 py-20">
        <div class="max-w-2xl">
            <p class="{{ $etiqueta }}">Rubros</p>
            <h2 class="{{ $titulo }} mt-2 text-4xl leading-tight sm:text-5xl">Hecho a la medida de tu rubro</h2>
            <p class="mt-3 text-lg text-stone-600">No es una plantilla genérica: cada sistema se arma según cómo trabaja tu negocio.</p>
        </div>
        <div class="mt-10 grid grid-cols-2 gap-4 lg:grid-cols-3">
            @foreach ($portada as $rubro)
                <figure class="group relative h-56 overflow-hidden rounded-3xl bg-tinta sm:h-72">
                    <img src="{{ Formato::foto($rubro['foto'], 700) }}" alt="{{ $rubro['nombre'] }}" loading="lazy" class="size-full object-cover transition duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-tinta via-tinta/30 to-transparent"></div>
                    <figcaption class="absolute inset-x-0 bottom-0 p-4 text-white sm:p-5">
                        <span class="mb-2 grid size-9 place-items-center rounded-xl bg-naranja"><x-icono :nombre="$rubro['icono']" class="size-5" /></span>
                        <p class="text-lg font-bold leading-tight sm:text-xl">{{ $rubro['nombre'] }}</p>
                        <p class="mt-1 hidden text-sm text-white/80 sm:block">{{ $rubro['detalle'] }}</p>
                    </figcaption>
                </figure>
            @endforeach
        </div>
        <div class="mt-6 flex flex-wrap items-center gap-3 text-sm text-stone-600">
            <span>También trabajamos con:</span>
            @foreach (collect($rubros)->where('portada', false) as $rubro)
                <span class="rounded-full bg-arena px-3 py-1.5 font-medium text-tinta">{{ $rubro['nombre'] }}</span>
            @endforeach
            <a href="#contacto" class="font-semibold text-naranja-oscuro hover:underline">¿Tu rubro no está? Conversemos →</a>
        </div>
    </section>

    {{-- Antes y después --}}
    <section id="antes-despues" class="bg-arena py-20">
        <div class="mx-auto flex max-w-6xl flex-col gap-8 px-4">
            <div class="max-w-3xl">
                <p class="{{ $etiqueta }}">Antes y después</p>
                <h2 class="{{ $titulo }} mt-2 text-4xl leading-tight sm:text-5xl">Del cuaderno y el teléfono a tener todo en un solo lugar</h2>
                <p class="mt-3 text-lg text-stone-600">Elige tu rubro y mira qué cambia en el día a día.</p>
            </div>

            <div class="flex flex-wrap gap-2" role="tablist" aria-label="Rubros">
                @foreach ($rubros as $i => $rubro)
                    <button type="button" role="tab" data-caso="{{ $i }}" aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
                        class="caso-tab flex items-center gap-2 rounded-full border-[1.5px] border-stone-300 bg-white px-4 py-2.5 text-[15px] font-semibold aria-selected:border-tinta aria-selected:bg-tinta aria-selected:text-white">
                        <x-icono :nombre="$rubro['icono']" class="size-4" />{{ $rubro['corto'] }}
                    </button>
                @endforeach
            </div>

            @foreach ($rubros as $i => $rubro)
                <div class="caso-panel grid gap-4 lg:grid-cols-[1fr_1fr_0.8fr]" data-caso="{{ $i }}" role="tabpanel" @if ($i !== 0) hidden @endif>
                    <div class="rounded-3xl border border-stone-200 bg-white p-7">
                        <p class="text-lg font-bold text-stone-500">Antes</p>
                        <ul class="mt-4 space-y-3.5">
                            @foreach ($rubro['antes'] as $item)
                                <li class="flex gap-3 leading-relaxed text-stone-700"><span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-red-50 text-xs text-red-500" aria-hidden="true">✕</span>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="rounded-3xl bg-tinta p-7 text-white">
                        <p class="text-lg font-bold text-orange-300">Con {{ $negocio['nombre'] }}</p>
                        <ul class="mt-4 space-y-3.5">
                            @foreach ($rubro['ahora'] as $item)
                                <li class="flex gap-3 leading-relaxed"><span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-naranja"><x-icono nombre="check" class="size-4" /></span>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="relative min-h-64 overflow-hidden rounded-3xl bg-tinta-2">
                        <img src="{{ Formato::foto($rubro['foto'], 600) }}" alt="{{ $rubro['nombre'] }}" loading="lazy" class="absolute inset-0 size-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        <p class="absolute inset-x-0 bottom-0 p-6 text-lg font-semibold leading-snug text-white">{{ $rubro['resultado'] }}</p>
                    </div>
                </div>
            @endforeach

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($negocio['beneficios'] as $b)
                    <div class="rounded-2xl bg-white p-5">
                        <p class="font-bold">{{ $b['titulo'] }}</p>
                        <p class="mt-1 text-sm leading-relaxed text-stone-600">{{ $b['texto'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Lo que ve tu cliente / lo que ves tú --}}
    <section class="relative overflow-hidden bg-tinta text-white">
        <div class="pointer-events-none absolute -left-32 top-10 size-96 rounded-full bg-naranja/20 blur-3xl"></div>
        <div class="relative mx-auto grid max-w-6xl items-center gap-12 px-4 py-20 lg:grid-cols-2">
            <div class="flex flex-col gap-5">
                <h2 class="{{ $titulo }} text-4xl leading-tight sm:text-5xl">Lo que ve tu cliente.<br><span class="text-naranja">Lo que ves tú.</span></h2>
                <p class="text-lg leading-relaxed text-slate-300">Tu cliente entra a tu web, elige el servicio y reserva o pide una cotización. Tú lo ves al instante en tu panel, desde el computador o el celular.</p>
                <img src="{{ Formato::foto($negocio['foto_portada'], 900) }}" alt="Trabajadora atendiendo con la pantalla del mostrador" loading="lazy" class="aspect-[3/2] w-full rounded-3xl bg-tinta-2 object-cover">
            </div>
            <div class="flex items-end gap-4" aria-hidden="true">
                <div class="hidden w-44 shrink-0 rounded-[1.75rem] border-[6px] border-slate-800 bg-white p-3.5 text-tinta sm:block">
                    <p class="text-xs text-stone-500">Tu web en el celular</p>
                    <p class="mt-2 font-bold">Reserva tu hora</p>
                    <div class="mt-2 flex flex-col gap-1.5 text-xs">
                        <span class="rounded-lg border border-stone-200 p-2">Sesión de kinesiología</span>
                        <span class="rounded-lg border border-stone-200 p-2">Miércoles 04/11</span>
                        <span class="rounded-lg bg-naranja p-2 text-center font-semibold text-white">16:00 · Reservar</span>
                    </div>
                </div>
                <div class="min-w-0 flex-1 rounded-2xl bg-white p-5 text-tinta">
                    <p class="text-xs text-stone-500">Tu panel</p>
                    <div class="mt-3 grid grid-cols-3 gap-2">
                        <div class="rounded-xl bg-stone-100 p-3"><p class="text-[11px] text-stone-500">Hoy</p><p class="text-xl font-bold">14 citas</p></div>
                        <div class="rounded-xl bg-naranja-suave p-3"><p class="text-[11px] text-stone-500">Por confirmar</p><p class="text-xl font-bold text-naranja-oscuro">3</p></div>
                        <div class="rounded-xl bg-stone-100 p-3"><p class="text-[11px] text-stone-500">Cotizaciones</p><p class="text-xl font-bold">6</p></div>
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

    {{-- Cómo trabajamos --}}
    <section class="mx-auto max-w-6xl px-4 py-20">
        <div class="text-center">
            <p class="{{ $etiqueta }}">Cómo trabajamos</p>
            <h2 class="{{ $titulo }} mt-2 text-4xl sm:text-5xl">De la idea a tu web funcionando</h2>
        </div>
        <ol class="mt-12 grid gap-6 md:grid-cols-4">
            @foreach ($negocio['proceso'] as $i => $paso)
                <li class="relative rounded-3xl border border-stone-200 p-6">
                    <span class="{{ $titulo }} absolute right-5 top-4 text-5xl text-stone-100">{{ $i + 1 }}</span>
                    <span class="relative grid size-12 place-items-center rounded-2xl bg-naranja text-white"><x-icono :nombre="$paso['icono']" class="size-6" /></span>
                    <h3 class="mt-5 text-lg font-bold">{{ $paso['titulo'] }}</h3>
                    <p class="mt-2 text-stone-600">{{ $paso['texto'] }}</p>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- Planes --}}
    <section id="planes" class="bg-arena py-20">
        <div class="mx-auto max-w-6xl px-4">
            <div class="text-center">
                <p class="{{ $etiqueta }}">Precios</p>
                <h2 class="{{ $titulo }} mt-2 text-4xl sm:text-5xl">Planes</h2>
                <p class="mx-auto mt-3 max-w-2xl text-lg text-stone-600">Un valor inicial y una mensualidad con todo incluido. Empieza simple y crece cuando lo necesites.</p>
            </div>
            <div class="mt-12 grid items-center gap-5 lg:grid-cols-3">
                @foreach ($negocio['paquetes'] as $plan)
                    <div @class(['flex flex-col rounded-3xl p-8', 'bg-tinta text-white shadow-2xl shadow-tinta/30 lg:py-11' => $plan['destacado'], 'bg-white ring-1 ring-stone-200' => ! $plan['destacado']])>
                        @if ($plan['destacado'])<p class="mb-3 self-start rounded-full bg-naranja px-3 py-1 text-xs font-bold text-white">⭐ El más pedido</p>@endif
                        <h3 class="text-xl font-bold">{{ $plan['nombre'] }}</h3>
                        <p @class(['mt-1.5 text-[15px]', 'text-white/70' => $plan['destacado'], 'text-stone-600' => ! $plan['destacado']])>{{ $plan['para'] }}</p>
                        <p class="mt-6"><span @class(['text-sm', 'text-white/60' => $plan['destacado'], 'text-stone-500' => ! $plan['destacado']])>desde</span> <span class="{{ $titulo }} text-[2.6rem]">{{ $clp($plan['desde']) }}</span></p>
                        <p @class(['text-sm', 'text-white/60' => $plan['destacado'], 'text-stone-500' => ! $plan['destacado']])>+ {{ $clp($plan['mensual']) }} al mes</p>
                        <ul class="mt-6 flex-1 space-y-2.5 text-[15px]">
                            @foreach ($plan['incluye'] as $item)
                                <li class="flex gap-2"><x-icono nombre="check" class="mt-0.5 size-4 shrink-0 text-naranja" />{{ $item }}</li>
                            @endforeach
                        </ul>
                        <a href="#contacto" data-plan="{{ $plan['nombre'] }}" @class(['elegir-plan mt-8 rounded-full px-4 py-3.5 text-center font-semibold', 'bg-naranja text-white hover:bg-naranja-oscuro' => $plan['destacado'], 'border-[1.5px] border-tinta hover:bg-arena' => ! $plan['destacado']])>Cotizar este plan</a>
                    </div>
                @endforeach
            </div>
            <div class="mt-8 rounded-3xl bg-white p-7 ring-1 ring-stone-200">
                <p class="font-bold">La mensualidad incluye:</p>
                <ul class="mt-3 grid gap-x-6 gap-y-2 text-[15px] text-stone-700 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($negocio['mensualidad'] as $item)
                        <li class="flex gap-2"><x-icono nombre="check" class="mt-0.5 size-4 shrink-0 text-naranja" />{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
            <p class="mt-5 text-center text-sm text-stone-500">Valores en pesos chilenos, más IVA. Contrato de mantención mínimo de 12 meses.</p>
        </div>
    </section>

    {{-- Garantías --}}
    <section class="mx-auto max-w-6xl px-4 py-16">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($negocio['garantias'] as $g)
                <div class="flex gap-4">
                    <span class="grid size-12 shrink-0 place-items-center rounded-2xl bg-naranja-suave text-naranja-oscuro"><x-icono :nombre="$g['icono']" class="size-6" /></span>
                    <div><p class="font-bold">{{ $g['titulo'] }}</p><p class="text-sm text-stone-600">{{ $g['texto'] }}</p></div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Demo --}}
    <section class="mx-auto max-w-6xl px-4 pb-20">
        <div class="relative overflow-hidden rounded-[2rem] bg-naranja p-8 text-white sm:p-12">
            <div class="pointer-events-none absolute -right-20 -top-20 size-80 rounded-full bg-white/15 blur-2xl"></div>
            <div class="relative flex flex-col items-start justify-between gap-6 md:flex-row md:items-center">
                <div class="max-w-xl">
                    <p class="text-sm font-semibold uppercase tracking-widest text-white/80">Demo en vivo</p>
                    <h2 class="{{ $titulo }} mt-2 text-3xl sm:text-5xl">Pruébalo antes de contratar</h2>
                    <p class="mt-3 text-lg text-white/90">Reserva una hora en un centro de salud de ejemplo, pide un presupuesto y mira cómo llega todo a su panel de gestión.</p>
                </div>
                <a href="{{ route('demo') }}" class="shrink-0 rounded-full bg-white px-7 py-4 font-semibold text-tinta shadow-xl hover:bg-arena">Abrir el demo →</a>
            </div>
        </div>
    </section>

    {{-- Preguntas frecuentes --}}
    <section class="bg-arena py-20">
        <div class="mx-auto grid max-w-6xl gap-10 px-4 lg:grid-cols-[0.8fr_1.2fr]">
            <div>
                <p class="{{ $etiqueta }}">Dudas</p>
                <h2 class="{{ $titulo }} mt-2 text-4xl sm:text-5xl">Preguntas frecuentes</h2>
                <p class="mt-3 text-lg text-stone-600">¿Tienes otra pregunta? Escríbenos por WhatsApp y te respondemos al tiro.</p>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener" class="mt-6 inline-flex items-center gap-2 rounded-full bg-[#25D366] px-6 py-3 font-semibold text-white hover:brightness-95"><x-icono nombre="whatsapp" class="size-5" />Preguntar por WhatsApp</a>
            </div>
            <div class="space-y-3">
                @foreach ([
                    ['¿Cuánto se demora?', 'Una web informativa toma entre 1 y 2 semanas. Una plataforma con gestión, entre 4 y 8 semanas según los módulos.'],
                    ['¿Qué incluye la mensualidad?', 'Hosting, dominio, certificado de seguridad, respaldos, soporte y una bolsa de horas al mes para cambios y mejoras.'],
                    ['¿Puedo empezar con la web y después sumar el sistema?', 'Sí. Todo se construye sobre la misma base, así que puedes subir de plan sin empezar de cero.'],
                    ['¿Los datos son míos?', 'Sí. Tus datos y los de tus clientes son tuyos, y si algún día te vas te los entregamos.'],
                    ['¿Necesito saber de computación?', 'No. Te enseñamos a usar el panel y quedamos disponibles por WhatsApp para cualquier duda.'],
                    ['¿Puedo pagar el valor inicial en partes?', 'Sí. Normalmente se paga 50% al empezar y 50% al lanzar, y podemos conversar otras opciones.'],
                ] as [$pregunta, $respuesta])
                    <details class="group rounded-2xl bg-white p-5" @if ($loop->first) open @endif>
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold [&::-webkit-details-marker]:hidden">{{ $pregunta }}<span class="grid size-7 shrink-0 place-items-center rounded-full bg-naranja-suave text-lg text-naranja-oscuro transition group-open:rotate-45" aria-hidden="true">+</span></summary>
                        <p class="mt-3 leading-relaxed text-stone-600">{{ $respuesta }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Contacto --}}
    <section id="contacto" class="mx-auto max-w-6xl px-4 py-20">
        <div class="grid overflow-hidden rounded-[2rem] bg-tinta text-white shadow-2xl md:grid-cols-5">
            <div class="relative p-8 sm:p-10 md:col-span-2">
                <div class="pointer-events-none absolute -bottom-24 -left-24 size-72 rounded-full bg-naranja/30 blur-3xl"></div>
                <div class="relative">
                    <h2 class="{{ $titulo }} text-4xl sm:text-5xl">Conversemos</h2>
                    <p class="mt-3 text-lg text-white/75">Cuéntanos de tu negocio y te contactamos dentro de 24 horas hábiles con una propuesta.</p>
                    <ul class="mt-8 space-y-4">
                        <li><a href="{{ $whatsapp }}" target="_blank" rel="noopener" class="flex items-center gap-3 font-semibold hover:text-naranja"><span class="grid size-10 place-items-center rounded-xl bg-white/10"><x-icono nombre="whatsapp" class="size-5" /></span>Escríbenos por WhatsApp</a></li>
                        <li><a href="mailto:{{ $negocio['email'] }}" class="flex items-center gap-3 hover:text-naranja"><span class="grid size-10 place-items-center rounded-xl bg-white/10"><x-icono nombre="mensaje" class="size-5" /></span>{{ $negocio['email'] }}</a></li>
                        <li class="flex items-center gap-3"><span class="grid size-10 place-items-center rounded-xl bg-white/10"><x-logo class="size-5" invertido /></span>{{ $negocio['ciudad'] }}</li>
                    </ul>
                </div>
            </div>

            <form method="POST" action="{{ route('contacto') }}" class="space-y-4 bg-white p-8 text-tinta sm:p-10 md:col-span-3">
                @csrf
                @if (session('ok'))
                    <p class="rounded-xl bg-emerald-50 p-3 text-sm font-medium text-emerald-800">{{ session('ok') }}</p>
                @endif
                @if ($errors->any())
                    <div class="rounded-xl bg-red-50 p-3 text-sm text-red-700">@foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>
                @endif
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm font-medium">Nombre *<input name="nombre" value="{{ old('nombre') }}" required class="{{ $campo }}"></label>
                    <label class="block text-sm font-medium">Nombre del negocio<input name="negocio" value="{{ old('negocio') }}" class="{{ $campo }}"></label>
                    <label class="block text-sm font-medium">Teléfono / WhatsApp *<input name="telefono" type="tel" value="{{ old('telefono') }}" required placeholder="+56 9 1234 5678" class="{{ $campo }}"></label>
                    <label class="block text-sm font-medium">Correo<input name="email" type="email" value="{{ old('email') }}" class="{{ $campo }}"></label>
                    <label class="block text-sm font-medium">Rubro
                        <select name="rubro" class="{{ $campo }}">
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
                <label class="block text-sm font-medium">¿Qué te gustaría resolver?<textarea name="mensaje" rows="4" class="{{ $campo }}">{{ old('mensaje') }}</textarea></label>
                <button class="w-full rounded-full bg-naranja px-6 py-4 font-semibold text-white shadow-lg shadow-naranja/30 hover:bg-naranja-oscuro">Quiero mi cotización gratis</button>
                <p class="text-center text-xs text-stone-500">Sin compromiso. No compartimos tus datos.</p>
            </form>
        </div>
    </section>
</main>

<footer class="bg-tinta text-white/70">
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-14 sm:grid-cols-2 lg:grid-cols-4">
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
            <ul class="mt-3 space-y-2 text-sm">
                @foreach ($portada->take(4) as $rubro)<li><a href="#rubros" class="hover:text-white">{{ $rubro['nombre'] }}</a></li>@endforeach
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
        <div class="mx-auto flex max-w-6xl flex-wrap justify-between gap-2 px-4 py-5 text-xs">
            <span>© {{ date('Y') }} {{ $negocio['nombre'] }} · {{ $negocio['ciudad'] }}</span>
            <span>Fotografías: <a href="https://www.pexels.com" class="hover:text-white" rel="noopener">Pexels</a></span>
        </div>
    </div>
</footer>

<script>
    // Al elegir un plan, queda seleccionado en el formulario.
    document.querySelectorAll('.elegir-plan').forEach(boton => {
        boton.addEventListener('click', () => {
            document.getElementById('campo-paquete').value = boton.dataset.plan;
        });
    });

    // Slider de rubros en la portada: cambia cada 5 segundos y se pausa con el mouse encima.
    (() => {
        const slider = document.querySelector('.slider');
        if (!slider) return;
        const slides = slider.querySelectorAll('.slide');
        const puntos = slider.querySelectorAll('.punto');
        let actual = 0, pausa = false;
        const ir = (n) => {
            actual = (n + slides.length) % slides.length;
            slides.forEach((s, i) => {
                const activo = i === actual;
                s.classList.toggle('opacity-0', !activo);
                s.classList.toggle('pointer-events-none', !activo);
                s.setAttribute('aria-hidden', activo ? 'false' : 'true');
            });
            puntos.forEach((p, i) => {
                const activo = i === actual;
                ['bg-naranja', 'text-white', 'ring-naranja'].forEach(c => p.classList.toggle(c, activo));
                ['text-white/70', 'ring-white/20'].forEach(c => p.classList.toggle(c, !activo));
            });
        };
        puntos.forEach(p => p.addEventListener('click', () => ir(+p.dataset.ir)));
        slider.addEventListener('mouseenter', () => pausa = true);
        slider.addEventListener('mouseleave', () => pausa = false);
        if (!matchMedia('(prefers-reduced-motion: reduce)').matches) {
            setInterval(() => { if (!pausa) ir(actual + 1); }, 5000);
        }
    })();

    // Pestañas de "Antes y después".
    document.querySelectorAll('.caso-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.caso-tab').forEach(t => t.setAttribute('aria-selected', t === tab ? 'true' : 'false'));
            document.querySelectorAll('.caso-panel').forEach(p => p.hidden = p.dataset.caso !== tab.dataset.caso);
        });
    });
</script>
@endsection
