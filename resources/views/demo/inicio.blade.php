@extends('demo.layout')

@php
    use App\Support\Formato;

    $clp = fn ($n) => Formato::clp($n);
    $demo = config('demo');
    $especialidades = $demo['especialidades'];
    // Especialidades a las que pertenece cada servicio, para el filtro de la lista de precios.
    $categorias = fn ($servicio) => collect($especialidades)->filter(fn ($e) => in_array($servicio->nombre, $e['servicios']))->keys()->join(' ');
    $iniciales = fn ($nombre) => collect(explode(' ', $nombre))->map(fn ($x) => mb_substr($x, 0, 1))->join('');
@endphp

@section('contenido')
{{-- Portada --}}
<section class="relative overflow-hidden bg-gradient-to-br from-marca-50 via-white to-amber-50">
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 py-14 lg:grid-cols-[1.05fr_1fr] lg:py-20">
        <div>
            <p class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1.5 text-sm font-medium text-marca-700 shadow-sm ring-1 ring-marca-100"><span class="size-2 rounded-full bg-emerald-500"></span>Horas disponibles esta semana</p>
            <h1 class="mt-5 text-4xl font-bold leading-[1.1] text-marca-900 md:text-[3.25rem]">Kinesiología, nutrición y psicología en el centro de Chillán</h1>
            <p class="mt-5 max-w-xl text-lg text-slate-600">Un equipo que trabaja coordinado para que te recuperes antes. Reserva en línea en menos de un minuto y recibe la confirmación por WhatsApp.</p>

            {{-- Reserva rápida --}}
            <form action="{{ route('demo.reservar') }}" method="GET" class="mt-8 flex max-w-xl flex-col gap-2 rounded-2xl bg-white p-2 shadow-lg ring-1 ring-slate-100 sm:flex-row">
                <label class="sr-only" for="servicio-rapido">Servicio</label>
                <select id="servicio-rapido" name="servicio" required class="flex-1 rounded-xl border-0 bg-slate-50 px-4 py-3 text-slate-700 focus:ring-2 focus:ring-marca-100">
                    <option value="">¿Qué necesitas?</option>
                    @foreach ($servicios as $s)
                        <option value="{{ $s->id }}">{{ $s->nombre }} · {{ $clp($s->precio) }}</option>
                    @endforeach
                </select>
                <button class="rounded-xl bg-marca-600 px-6 py-3 font-semibold text-white hover:bg-marca-700">Ver horas libres</button>
            </form>

            <div class="mt-6 flex items-center gap-4">
                <div class="flex -space-x-2">
                    @foreach ($profesionales as $p)
                        <span class="grid size-10 place-items-center rounded-full text-sm font-bold text-white ring-2 ring-white" style="background: {{ $p->color }}">{{ $iniciales($p->nombre) }}</span>
                    @endforeach
                </div>
                <p class="text-sm text-slate-600"><strong class="text-marca-900">4,9 ★</strong> de 320 reseñas en Google</p>
            </div>
        </div>

        <div class="relative">
            <img src="{{ Formato::foto(20860588, 1000) }}" alt="Kinesióloga ayudando a un paciente con ejercicios de pierna" class="aspect-[4/3] w-full rounded-3xl bg-marca-100 object-cover shadow-xl">
            <div class="absolute -left-3 top-6 hidden rounded-2xl bg-white p-4 shadow-lg ring-1 ring-slate-100 sm:block">
                <p class="text-xs text-slate-500">Próxima hora libre</p>
                <p class="font-bold text-marca-900">Hoy, 16:30</p>
                <p class="text-xs text-marca-700">Sesión de kinesiología</p>
            </div>
            <div class="absolute -bottom-5 right-4 flex items-center gap-3 rounded-2xl bg-white p-4 shadow-lg ring-1 ring-slate-100">
                <span class="grid size-10 place-items-center rounded-full bg-emerald-100 text-emerald-700"><x-icono nombre="check" class="size-5" /></span>
                <div><p class="font-bold text-marca-900">Reserva confirmada</p><p class="text-xs text-slate-500">Te avisamos por WhatsApp</p></div>
            </div>
        </div>
    </div>
</section>

{{-- Cifras --}}
<section class="border-y border-slate-100 bg-white">
    <div class="mx-auto grid max-w-6xl grid-cols-2 gap-6 px-4 py-8 md:grid-cols-4">
        @foreach ($demo['cifras'] as [$numero, $texto])
            <div class="text-center"><p class="text-3xl font-bold text-marca-700">{{ $numero }}</p><p class="text-sm text-slate-500">{{ $texto }}</p></div>
        @endforeach
    </div>
</section>

{{-- Especialidades --}}
<section id="especialidades" class="mx-auto max-w-6xl px-4 py-20">
    <p class="text-sm font-semibold uppercase tracking-wider text-marca-600">Especialidades</p>
    <div class="flex flex-wrap items-end justify-between gap-4">
        <h2 class="mt-2 text-3xl font-bold text-marca-900 md:text-4xl">Todo lo que necesitas en un solo lugar</h2>
        <p class="max-w-md text-slate-600">Tus profesionales comparten tu ficha y coordinan el tratamiento entre ellos.</p>
    </div>
    <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($especialidades as $slug => $e)
            <a href="{{ route('demo.especialidad', $slug) }}" class="group flex flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white transition hover:-translate-y-1 hover:shadow-xl">
                <img src="{{ Formato::foto($e['foto'], 600) }}" alt="{{ $e['nombre'] }}" loading="lazy" class="aspect-[4/3] w-full bg-marca-50 object-cover">
                <div class="flex flex-1 flex-col p-5">
                    <h3 class="text-lg font-bold text-marca-900">{{ $e['nombre'] }}</h3>
                    <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-600">{{ $e['resumen'] }}</p>
                    <p class="mt-4 text-sm font-semibold text-marca-700 group-hover:underline">Conocer más →</p>
                </div>
            </a>
        @endforeach
    </div>
</section>

{{-- Cómo reservar --}}
<section class="bg-marca-50 py-20">
    <div class="mx-auto max-w-6xl px-4">
        <h2 class="text-center text-3xl font-bold text-marca-900 md:text-4xl">Reserva en 3 pasos</h2>
        <div class="mt-12 grid gap-6 md:grid-cols-3">
            @foreach ($demo['pasos'] as $i => [$icono, $titulo, $texto])
                <div class="relative rounded-3xl bg-white p-7 shadow-sm">
                    <span class="absolute right-6 top-5 text-5xl font-bold text-marca-100">{{ $i + 1 }}</span>
                    <span class="grid size-12 place-items-center rounded-2xl bg-marca-600 text-white"><x-icono :nombre="$icono" class="size-6" /></span>
                    <h3 class="mt-5 text-lg font-bold text-marca-900">{{ $titulo }}</h3>
                    <p class="mt-2 text-slate-600">{{ $texto }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Servicios y precios con filtro --}}
<section id="servicios" class="mx-auto max-w-6xl px-4 py-20">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-marca-600">Servicios y precios</p>
            <h2 class="mt-2 text-3xl font-bold text-marca-900 md:text-4xl">Precios claros, sin sorpresas</h2>
        </div>
        <div class="flex flex-wrap gap-2" role="tablist">
            <button type="button" data-filtro="todos" class="filtro rounded-full border border-marca-600 bg-marca-600 px-4 py-2 text-sm font-semibold text-white">Todos</button>
            @foreach ($especialidades as $slug => $e)
                <button type="button" data-filtro="{{ $slug }}" class="filtro rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:border-marca-500">{{ $e['nombre'] }}</button>
            @endforeach
        </div>
    </div>
    <div class="mt-8 grid gap-4 md:grid-cols-2">
        @foreach ($servicios as $servicio)
            <div class="servicio flex items-center gap-4 rounded-2xl border border-slate-200 p-5 transition hover:border-marca-500" data-cat="{{ $categorias($servicio) }}">
                <div class="min-w-0 flex-1">
                    <h3 class="font-semibold text-marca-900">{{ $servicio->nombre }}</h3>
                    <p class="mt-1 text-sm text-slate-600">{{ $servicio->descripcion }}</p>
                    <p class="mt-2 text-xs text-slate-500">{{ $servicio->duracion_minutos }} minutos</p>
                </div>
                <div class="shrink-0 text-right">
                    <p class="text-xl font-bold text-marca-900">{{ $clp($servicio->precio) }}</p>
                    <a href="{{ route('demo.reservar', ['servicio' => $servicio->id]) }}" class="mt-2 inline-block rounded-full bg-marca-50 px-4 py-1.5 text-sm font-semibold text-marca-700 hover:bg-marca-100">Reservar</a>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- Packs --}}
<section class="mx-auto max-w-6xl px-4 pb-20">
    <div class="rounded-3xl bg-slate-900 p-8 text-white sm:p-12">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-acento">Packs y planes</p>
                <h2 class="mt-2 text-3xl font-bold">Ahorra con tu tratamiento completo</h2>
            </div>
            <p class="max-w-sm text-slate-300">Paga en cuotas con tarjeta de crédito. Las sesiones no vencen por 6 meses.</p>
        </div>
        <div class="mt-10 grid gap-5 md:grid-cols-3">
            @foreach ($demo['packs'] as $pack)
                <div @class(['flex flex-col rounded-2xl p-6', 'bg-white text-slate-800' => $pack['destacado'], 'bg-white/5 ring-1 ring-white/10' => ! $pack['destacado']])>
                    @if ($pack['destacado'])<p class="mb-3 self-start rounded-full bg-acento px-3 py-1 text-xs font-bold text-slate-900">El más elegido</p>@endif
                    <h3 @class(['text-lg font-bold', 'text-marca-900' => $pack['destacado']])>{{ $pack['nombre'] }}</h3>
                    <p @class(['mt-1 flex-1 text-sm', 'text-slate-600' => $pack['destacado'], 'text-slate-300' => ! $pack['destacado']])>{{ $pack['detalle'] }}</p>
                    <p class="mt-5"><span class="text-3xl font-bold">{{ $clp($pack['precio']) }}</span> <span class="text-sm line-through opacity-60">{{ $clp($pack['antes']) }}</span></p>
                    <p @class(['text-sm font-semibold', 'text-marca-700' => $pack['destacado'], 'text-acento' => ! $pack['destacado']])>Ahorras {{ $clp($pack['antes'] - $pack['precio']) }}</p>
                    <a href="{{ route('demo.presupuesto') }}" @class(['mt-5 rounded-full px-4 py-2.5 text-center text-sm font-semibold', 'bg-marca-600 text-white hover:bg-marca-700' => $pack['destacado'], 'bg-white/10 hover:bg-white/20' => ! $pack['destacado']])>Lo quiero</a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Equipo --}}
<section id="equipo" class="bg-slate-50 py-20">
    <div class="mx-auto max-w-6xl px-4">
        <p class="text-sm font-semibold uppercase tracking-wider text-marca-600">Nuestro equipo</p>
        <h2 class="mt-2 text-3xl font-bold text-marca-900 md:text-4xl">Profesionales que te conocen por tu nombre</h2>
        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($profesionales as $p)
                <div class="flex flex-col rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-100">
                    <div class="flex items-center gap-4">
                        <span class="grid size-16 shrink-0 place-items-center rounded-2xl text-xl font-bold text-white" style="background: {{ $p->color }}">{{ $iniciales($p->nombre) }}</span>
                        <div>
                            <h3 class="font-bold text-marca-900">{{ $p->nombre }}</h3>
                            <p class="text-sm font-medium" style="color: {{ $p->color }}">{{ $p->especialidad }}</p>
                        </div>
                    </div>
                    <p class="mt-4 flex-1 text-sm leading-relaxed text-slate-600">{{ $p->bio }}</p>
                    <div class="mt-4 flex flex-wrap gap-1.5">
                        @foreach ($p->servicios->take(3) as $s)
                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs text-slate-600">{{ $s->nombre }}</span>
                        @endforeach
                    </div>
                    <div class="mt-5 flex gap-2 text-sm font-semibold">
                        <a href="{{ route('demo.profesional', $p) }}" class="flex-1 rounded-full border border-slate-200 py-2 text-center text-marca-900 hover:border-marca-500">Ver perfil</a>
                        <a href="{{ route('demo.reservar', ['servicio' => $p->servicios->first()?->id, 'profesional' => $p->id]) }}" class="flex-1 rounded-full bg-marca-600 py-2 text-center text-white hover:bg-marca-700">Reservar</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Testimonios --}}
<section class="mx-auto max-w-6xl px-4 py-20">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <h2 class="text-3xl font-bold text-marca-900 md:text-4xl">Lo que dicen nuestros pacientes</h2>
        <p class="text-slate-600"><span class="text-acento">★★★★★</span> 4,9 de 5 en Google</p>
    </div>
    <div class="mt-10 grid gap-5 md:grid-cols-3">
        @foreach ($demo['testimonios'] as [$nombre, $area, $texto])
            <figure class="flex flex-col rounded-3xl border border-slate-200 p-7">
                <p class="text-acento">★★★★★</p>
                <blockquote class="mt-3 flex-1 leading-relaxed text-slate-700">“{{ $texto }}”</blockquote>
                <figcaption class="mt-5 flex items-center gap-3">
                    <span class="grid size-10 place-items-center rounded-full bg-marca-100 font-bold text-marca-700">{{ mb_substr($nombre, 0, 1) }}</span>
                    <span><span class="block font-semibold text-marca-900">{{ $nombre }}</span><span class="text-sm text-slate-500">{{ $area }}</span></span>
                </figcaption>
            </figure>
        @endforeach
    </div>
</section>

{{-- Instalaciones --}}
<section class="mx-auto max-w-6xl px-4 pb-20">
    <h2 class="text-3xl font-bold text-marca-900 md:text-4xl">Nuestras instalaciones</h2>
    <p class="mt-2 max-w-2xl text-slate-600">Boxes amplios, gimnasio de rehabilitación y equipamiento moderno, a pasos de la Plaza de Armas.</p>
    <div class="mt-8 grid grid-cols-2 gap-3 md:h-[460px] md:grid-cols-4 md:grid-rows-2">
        @foreach ($demo['galeria'] as $foto)
            <img src="{{ Formato::foto($foto, 700) }}" alt="Instalaciones del centro" loading="lazy" @class(['size-full min-h-0 rounded-2xl bg-marca-50 object-cover aspect-[4/3] md:aspect-auto', 'col-span-2 md:row-span-2' => $loop->first, 'md:col-span-2' => $loop->last])>
        @endforeach
    </div>
</section>

{{-- Convenios --}}
<section id="convenios" class="bg-marca-50 py-20">
    <div class="mx-auto grid max-w-6xl gap-10 px-4 lg:grid-cols-[1fr_1.4fr]">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-marca-600">Convenios y previsión</p>
            <h2 class="mt-2 text-3xl font-bold text-marca-900 md:text-4xl">Atendemos Fonasa, isapres y particular</h2>
            <p class="mt-4 text-slate-600">Te ayudamos con los papeles para que uses tu previsión o recuperes parte de lo que pagas.</p>
            <a href="{{ route('demo.presupuesto') }}" class="mt-6 inline-block rounded-full bg-marca-600 px-6 py-3 font-semibold text-white hover:bg-marca-700">Calcular mi presupuesto</a>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            @foreach ($demo['convenios'] as [$nombre, $texto])
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <p class="flex items-center gap-2 font-bold text-marca-900"><x-icono nombre="check" class="size-5 text-marca-600" />{{ $nombre }}</p>
                    <p class="mt-2 text-sm text-slate-600">{{ $texto }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Consejos --}}
<section class="mx-auto max-w-6xl px-4 py-20">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-marca-600">Consejos de salud</p>
            <h2 class="mt-2 text-3xl font-bold text-marca-900 md:text-4xl">Del blog del centro</h2>
        </div>
    </div>
    <div class="mt-10 grid gap-5 md:grid-cols-3">
        @foreach ($demo['consejos'] as $c)
            <article class="overflow-hidden rounded-3xl border border-slate-200">
                <img src="{{ Formato::foto($c['foto'], 600) }}" alt="" loading="lazy" class="aspect-[16/10] w-full bg-marca-50 object-cover">
                <div class="p-6">
                    <p class="text-xs font-semibold uppercase tracking-wide text-marca-600">{{ $c['categoria'] }} · {{ $c['minutos'] }} min de lectura</p>
                    <h3 class="mt-2 text-lg font-bold leading-snug text-marca-900">{{ $c['titulo'] }}</h3>
                </div>
            </article>
        @endforeach
    </div>
</section>

{{-- Preguntas frecuentes y ubicación --}}
<section class="mx-auto grid max-w-6xl gap-10 px-4 lg:grid-cols-2">
    <div>
        <h2 class="text-3xl font-bold text-marca-900">Preguntas frecuentes</h2>
        <div class="mt-6 divide-y divide-slate-200 border-y border-slate-200">
            @foreach ($demo['preguntas'] as [$pregunta, $respuesta])
                <details class="group py-4" @if ($loop->first) open @endif>
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-marca-900 [&::-webkit-details-marker]:hidden">{{ $pregunta }}<span class="text-xl text-marca-600 transition group-open:rotate-45">+</span></summary>
                    <p class="mt-2 text-slate-600">{{ $respuesta }}</p>
                </details>
            @endforeach
        </div>
    </div>
    <div class="rounded-3xl bg-slate-50 p-7">
        <h2 class="text-3xl font-bold text-marca-900">Cómo llegar</h2>
        {{-- Mapa ilustrativo (en un sitio real va el mapa de Google) --}}
        <div class="relative mt-6 h-56 overflow-hidden rounded-2xl bg-[#e8efe9]" aria-hidden="true">
            <div class="absolute inset-0 bg-[linear-gradient(90deg,transparent_47%,#fff_47%,#fff_53%,transparent_53%),linear-gradient(0deg,transparent_47%,#fff_47%,#fff_53%,transparent_53%)] bg-[length:90px_90px]"></div>
            <div class="absolute left-[30%] top-[20%] h-20 w-28 rounded-lg bg-[#cfe3d3]"></div>
            <span class="absolute left-1/2 top-1/2 grid size-12 -translate-x-1/2 -translate-y-full place-items-center rounded-full rounded-bl-none bg-marca-600 text-white shadow-lg"><x-icono nombre="salud" class="size-5" /></span>
        </div>
        <ul class="mt-6 space-y-3 text-slate-700">
            <li><strong class="text-marca-900">Dirección:</strong> {{ $demo['centro']['direccion'] }}</li>
            <li><strong class="text-marca-900">Estacionamiento:</strong> convenio con el estacionamiento de la esquina.</li>
            <li><strong class="text-marca-900">Accesibilidad:</strong> acceso para sillas de ruedas y ascensor.</li>
        </ul>
    </div>
</section>

<script>
    // Filtro de servicios por especialidad
    document.querySelectorAll('.filtro').forEach((boton) => {
        boton.addEventListener('click', () => {
            const filtro = boton.dataset.filtro;
            document.querySelectorAll('.filtro').forEach((b) => {
                const activo = b === boton;
                b.classList.toggle('bg-marca-600', activo);
                b.classList.toggle('text-white', activo);
                b.classList.toggle('border-marca-600', activo);
                b.classList.toggle('text-slate-700', !activo);
                b.classList.toggle('border-slate-200', !activo);
            });
            document.querySelectorAll('.servicio').forEach((s) => {
                s.hidden = filtro !== 'todos' && !s.dataset.cat.split(' ').includes(filtro);
            });
        });
    });
</script>
@endsection
