@extends('layouts.app')

@php
    use App\Support\Formato;

    $rubros = config('negocio.rubros');
    $portada = collect($rubros)->where('portada', true)->take(6);
    $clp = fn ($n) => Formato::clp($n);
    $titulo = 'font-titulo font-extrabold tracking-tight';
    $campo = 'mt-1.5 w-full rounded-xl border border-stone-300 bg-white px-3.5 py-3 focus:border-tinta focus:outline-none focus:ring-2 focus:ring-naranja/30';
@endphp

@section('contenido')
{{-- Encabezado --}}
<header class="sticky top-0 z-40 border-b border-stone-200 bg-white/95 backdrop-blur">
    <nav class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-3">
        <a href="#" class="flex items-center gap-2.5">
            <x-logo class="size-9" />
            <span class="{{ $titulo }} text-xl">{{ config('negocio.nombre') }}</span>
        </a>
        <div class="hidden items-center gap-7 text-[15px] md:flex">
            <a href="#rubros" class="hover:text-naranja-oscuro">Rubros</a>
            <a href="#antes-despues" class="hover:text-naranja-oscuro">Antes y después</a>
            <a href="#planes" class="hover:text-naranja-oscuro">Planes</a>
            <a href="{{ route('demo') }}" class="hover:text-naranja-oscuro">Demo</a>
        </div>
        <a href="#contacto" class="rounded-full bg-tinta px-5 py-3 text-sm font-semibold text-white hover:bg-tinta-2">Conversemos</a>
    </nav>
</header>

<main>
    {{-- Portada con fotos de rubros --}}
    <section id="rubros" class="mx-auto grid max-w-6xl items-center gap-12 px-4 pb-10 pt-12 lg:grid-cols-[1fr_1.1fr] lg:pt-16">
        <div class="flex flex-col gap-6">
            <p class="text-sm font-semibold uppercase tracking-widest text-naranja-oscuro">Páginas web y sistemas para negocios de Ñuble</p>
            <h1 class="{{ $titulo }} text-[2.6rem] leading-[1.02] sm:text-6xl">Atiende mejor.<br>Ordena todo.<br>Vende también en línea.</h1>
            <p class="max-w-xl text-lg leading-relaxed text-stone-600">Tu web para que te encuentren y reserven, y un panel simple para manejar clientes, equipo, cotizaciones y agenda. Hecho en {{ config('negocio.ciudad') }}, con soporte por WhatsApp.</p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('demo') }}" class="rounded-full bg-naranja px-6 py-3.5 font-semibold text-white hover:bg-naranja-oscuro">Ver un ejemplo funcionando</a>
                <a href="#contacto" class="rounded-full border-[1.5px] border-tinta px-6 py-3.5 font-semibold hover:bg-arena">Pedir cotización</a>
            </div>
            <ul class="flex flex-wrap gap-x-5 gap-y-2 text-sm text-stone-600">
                @foreach (['Primera reunión gratis', 'Listo en 2 a 8 semanas', 'Tus datos son tuyos'] as $item)
                    <li class="flex items-center gap-1.5"><x-icono nombre="check" class="size-4 text-naranja" />{{ $item }}</li>
                @endforeach
            </ul>
        </div>

        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
            @foreach ($portada as $rubro)
                <figure class="relative h-40 overflow-hidden rounded-2xl bg-arena sm:h-48">
                    <img src="{{ Formato::foto($rubro['foto'], 600) }}" alt="{{ $rubro['nombre'] }}" class="size-full object-cover" @if (! $loop->first) loading="lazy" @endif>
                    <figcaption class="absolute bottom-2.5 left-2.5 rounded-full bg-white px-3 py-1.5 text-[13px] font-semibold shadow-sm">{{ $rubro['corto'] }}</figcaption>
                </figure>
            @endforeach
        </div>
    </section>

    {{-- Todos los rubros --}}
    <section class="mx-auto max-w-6xl px-4 pb-16">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($rubros as $rubro)
                <div class="flex gap-3 rounded-2xl border border-stone-200 p-5">
                    <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-naranja-suave text-naranja-oscuro"><x-icono :nombre="$rubro['icono']" class="size-5" /></span>
                    <div>
                        <p class="font-semibold">{{ $rubro['nombre'] }}</p>
                        <p class="mt-1 text-sm leading-relaxed text-stone-600">{{ $rubro['detalle'] }}</p>
                    </div>
                </div>
            @endforeach
            <a href="#contacto" class="flex items-center justify-center rounded-2xl border border-dashed border-stone-300 p-5 text-center text-sm font-semibold text-stone-600 hover:border-tinta hover:text-tinta">¿Tu rubro no está?<br>Conversemos</a>
        </div>
    </section>

    {{-- Antes y después --}}
    <section id="antes-despues" class="bg-arena py-20">
        <div class="mx-auto flex max-w-6xl flex-col gap-8 px-4">
            <div class="max-w-3xl">
                <p class="text-sm font-semibold uppercase tracking-widest text-naranja-oscuro">Antes y después</p>
                <h2 class="{{ $titulo }} mt-2 text-4xl leading-tight sm:text-5xl">Del cuaderno y el teléfono a tener todo en un solo lugar</h2>
                <p class="mt-3 text-lg text-stone-600">Elige tu rubro y mira qué cambia en el día a día.</p>
            </div>

            <div class="flex flex-wrap gap-2" role="tablist" aria-label="Rubros">
                @foreach ($rubros as $i => $rubro)
                    <button type="button" role="tab" data-caso="{{ $i }}" aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
                        class="caso-tab rounded-full border-[1.5px] border-stone-300 bg-white px-5 py-3 text-[15px] font-semibold aria-selected:border-tinta aria-selected:bg-tinta aria-selected:text-white">
                        {{ $rubro['corto'] }}
                    </button>
                @endforeach
            </div>

            @foreach ($rubros as $i => $rubro)
                <div class="caso-panel grid gap-4 lg:grid-cols-2" data-caso="{{ $i }}" role="tabpanel" @if ($i !== 0) hidden @endif>
                    <div class="rounded-3xl border border-stone-200 bg-white p-7">
                        <p class="text-lg font-bold text-stone-500">Antes</p>
                        <ul class="mt-4 space-y-3.5">
                            @foreach ($rubro['antes'] as $item)
                                <li class="flex gap-3 leading-relaxed text-stone-700">
                                    <span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-stone-100 text-stone-500" aria-hidden="true">✕</span>{{ $item }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="rounded-3xl bg-tinta p-7 text-white">
                        <p class="text-lg font-bold text-orange-300">Con {{ config('negocio.nombre') }}</p>
                        <ul class="mt-4 space-y-3.5">
                            @foreach ($rubro['ahora'] as $item)
                                <li class="flex gap-3 leading-relaxed">
                                    <span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-naranja"><x-icono nombre="check" class="size-4" /></span>{{ $item }}
                                </li>
                            @endforeach
                        </ul>
                        <p class="{{ $titulo }} mt-6 border-t border-white/15 pt-5 text-xl">{{ $rubro['resultado'] }}</p>
                    </div>
                </div>
            @endforeach

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach (config('negocio.beneficios') as $b)
                    <div class="rounded-2xl bg-white p-6">
                        <p class="{{ $titulo }} text-2xl">{{ $b['titulo'] }}</p>
                        <p class="mt-1.5 text-[15px] leading-relaxed text-stone-600">{{ $b['texto'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Lo que ve tu cliente / lo que ves tú --}}
    <section class="bg-tinta text-white">
        <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 py-20 lg:grid-cols-2">
            <div class="flex flex-col gap-5">
                <h2 class="{{ $titulo }} text-4xl leading-tight sm:text-5xl">Lo que ve tu cliente.<br>Lo que ves tú.</h2>
                <p class="text-lg leading-relaxed text-slate-300">Tu cliente entra a tu web, elige el servicio y reserva o pide una cotización. Tú lo ves al instante en tu panel, desde el computador o el celular.</p>
                <img src="{{ Formato::foto(config('negocio.foto_portada'), 900) }}" alt="Trabajadora revisando pedidos en una tablet en el mostrador" loading="lazy" class="h-56 w-full rounded-2xl bg-tinta-2 object-cover">
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

    {{-- Planes --}}
    <section id="planes" class="mx-auto max-w-6xl px-4 py-20">
        <h2 class="{{ $titulo }} text-4xl sm:text-5xl">Planes</h2>
        <p class="mt-3 max-w-2xl text-lg text-stone-600">Un valor inicial y una mensualidad con hosting, soporte y horas de mejoras. Empieza simple y crece cuando lo necesites.</p>
        <div class="mt-10 grid gap-5 lg:grid-cols-3">
            @foreach (config('negocio.paquetes') as $plan)
                <div @class(['flex flex-col rounded-3xl p-7', 'border-2 border-tinta' => $plan['destacado'], 'border border-stone-200' => ! $plan['destacado']])>
                    @if ($plan['destacado'])<p class="mb-3 self-start rounded-full bg-naranja-suave px-3 py-1 text-xs font-semibold text-naranja-oscuro">Más pedido</p>@endif
                    <h3 class="text-xl font-bold">{{ $plan['nombre'] }}</h3>
                    <p class="mt-1.5 text-[15px] text-stone-600">{{ $plan['para'] }}</p>
                    <p class="mt-6"><span class="text-sm text-stone-500">desde</span> <span class="{{ $titulo }} text-4xl">{{ $clp($plan['desde']) }}</span></p>
                    <p class="text-sm text-stone-500">+ {{ $clp($plan['mensual']) }} al mes</p>
                    <ul class="mt-6 flex-1 space-y-2.5 text-[15px]">
                        @foreach ($plan['incluye'] as $item)
                            <li class="flex gap-2"><x-icono nombre="check" class="mt-0.5 size-4 shrink-0 text-naranja" />{{ $item }}</li>
                        @endforeach
                    </ul>
                    <a href="#contacto" data-plan="{{ $plan['nombre'] }}" @class(['elegir-plan mt-8 rounded-full px-4 py-3 text-center font-semibold', 'bg-tinta text-white hover:bg-tinta-2' => $plan['destacado'], 'border-[1.5px] border-tinta hover:bg-arena' => ! $plan['destacado']])>Cotizar este plan</a>
                </div>
            @endforeach
        </div>
        <p class="mt-6 text-sm text-stone-500">Valores en pesos chilenos, más IVA. Contrato de mantención mínimo de 12 meses.</p>
    </section>

    {{-- Demo --}}
    <section class="mx-auto max-w-6xl px-4 pb-20">
        <div class="flex flex-col items-start justify-between gap-6 rounded-[2rem] bg-naranja-suave p-8 sm:p-10 md:flex-row md:items-center">
            <div>
                <h2 class="{{ $titulo }} text-3xl sm:text-4xl">Pruébalo antes de contratar</h2>
                <p class="mt-2 text-lg text-stone-600">Reserva una hora en un centro de salud de ejemplo y mira cómo llega a su panel.</p>
            </div>
            <a href="{{ route('demo') }}" class="shrink-0 rounded-full bg-tinta px-6 py-3.5 font-semibold text-white hover:bg-tinta-2">Abrir el demo</a>
        </div>
    </section>

    {{-- Preguntas frecuentes --}}
    <section class="bg-arena py-20">
        <div class="mx-auto max-w-3xl px-4">
            <h2 class="{{ $titulo }} text-4xl">Preguntas frecuentes</h2>
            <div class="mt-8 space-y-3">
                @foreach ([
                    ['¿Cuánto se demora?', 'Una web informativa toma entre 1 y 2 semanas. Una plataforma con gestión, entre 4 y 8 semanas según los módulos.'],
                    ['¿Qué incluye la mensualidad?', 'Hosting, dominio, certificado de seguridad, respaldos, soporte y una bolsa de horas al mes para cambios y mejoras.'],
                    ['¿Puedo empezar con la web y después sumar el sistema?', 'Sí. Todo se construye sobre la misma base, así que puedes subir de plan sin empezar de cero.'],
                    ['¿Los datos son míos?', 'Sí. Tus datos y los de tus clientes son tuyos, y si algún día te vas te los entregamos.'],
                    ['¿Necesito saber de computación?', 'No. Te enseñamos a usar el panel y quedamos disponibles por WhatsApp para cualquier duda.'],
                ] as [$pregunta, $respuesta])
                    <details class="group rounded-2xl bg-white p-5">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold">{{ $pregunta }}<span class="text-xl text-naranja transition group-open:rotate-45" aria-hidden="true">+</span></summary>
                        <p class="mt-3 leading-relaxed text-stone-600">{{ $respuesta }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Contacto --}}
    <section id="contacto" class="mx-auto max-w-6xl px-4 py-20">
        <div class="grid gap-10 md:grid-cols-5">
            <div class="md:col-span-2">
                <h2 class="{{ $titulo }} text-4xl sm:text-5xl">Conversemos</h2>
                <p class="mt-3 text-lg text-stone-600">Déjanos tus datos y te contactamos dentro de 24 horas hábiles. O escríbenos directo.</p>
                <div class="mt-6 space-y-2.5">
                    <a href="https://wa.me/{{ config('negocio.whatsapp') }}?text={{ urlencode('Hola, quiero información para mi negocio') }}" target="_blank" rel="noopener" class="flex items-center gap-2 font-semibold hover:text-naranja-oscuro"><x-icono nombre="whatsapp" class="size-5" />WhatsApp</a>
                    <a href="mailto:{{ config('negocio.email') }}" class="block text-stone-600 hover:underline">{{ config('negocio.email') }}</a>
                    <p class="text-stone-600">{{ config('negocio.ciudad') }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('contacto') }}" class="space-y-4 md:col-span-3">
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
                            @foreach (config('negocio.paquetes') as $plan)
                                <option @selected(old('paquete') === $plan['nombre'])>{{ $plan['nombre'] }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <label class="block text-sm font-medium">¿Qué te gustaría resolver?<textarea name="mensaje" rows="4" class="{{ $campo }}">{{ old('mensaje') }}</textarea></label>
                <button class="w-full rounded-full bg-naranja px-6 py-3.5 font-semibold text-white hover:bg-naranja-oscuro">Enviar</button>
            </form>
        </div>
    </section>
</main>

<footer class="border-t border-stone-200 py-8">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-3 px-4 text-sm text-stone-500">
        <span class="flex items-center gap-2"><x-logo class="size-6" />© {{ date('Y') }} {{ config('negocio.nombre') }} · {{ config('negocio.ciudad') }}</span>
        <span class="text-xs">Fotografías: <a href="https://www.pexels.com" class="hover:underline" rel="noopener">Pexels</a></span>
    </div>
</footer>

<script>
    // Al elegir un plan, queda seleccionado en el formulario.
    document.querySelectorAll('.elegir-plan').forEach(boton => {
        boton.addEventListener('click', () => {
            document.getElementById('campo-paquete').value = boton.dataset.plan;
        });
    });

    // Pestañas de "Antes y después".
    document.querySelectorAll('.caso-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.caso-tab').forEach(t => t.setAttribute('aria-selected', t === tab ? 'true' : 'false'));
            document.querySelectorAll('.caso-panel').forEach(p => p.hidden = p.dataset.caso !== tab.dataset.caso);
        });
    });
</script>
@endsection
