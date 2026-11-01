@php
    $alto = 56; // píxeles por hora
    $titulo = $dias->first()->translatedFormat('d M').' – '.$dias->last()->translatedFormat('d M Y');
@endphp
<x-filament-panels::page>
    <div class="flex flex-wrap items-center gap-2">
        <x-filament::button color="gray" size="sm" wire:click="anterior" icon="heroicon-m-chevron-left">Anterior</x-filament::button>
        <x-filament::button color="gray" size="sm" wire:click="hoy">Hoy</x-filament::button>
        <x-filament::button color="gray" size="sm" wire:click="siguiente" icon="heroicon-m-chevron-right" icon-position="after">Siguiente</x-filament::button>
        <span style="font-weight:600; margin-left:.5rem">{{ $titulo }}</span>
        <div style="margin-left:auto; display:flex; gap:.5rem; align-items:center">
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="profesional">
                    <option value="">Todos los profesionales</option>
                    @foreach ($profesionales as $p)
                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>
            <x-filament::button tag="a" :href="$urlNueva" icon="heroicon-m-plus">Nueva cita</x-filament::button>
        </div>
    </div>

    <div style="display:flex; flex-wrap:wrap; gap:1rem; font-size:.8rem">
        @foreach ($profesionales as $p)
            <span style="display:flex; align-items:center; gap:.35rem"><span style="width:.75rem; height:.75rem; border-radius:9999px; background:{{ $p->color }}"></span>{{ $p->nombre }}</span>
        @endforeach
    </div>

    <div style="overflow-x:auto" class="rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div style="display:grid; grid-template-columns: 3.5rem repeat({{ $dias->count() }}, minmax(11rem, 1fr)); min-width: 60rem">
            {{-- Encabezados --}}
            <div></div>
            @foreach ($dias as $dia)
                <div style="padding:.6rem; text-align:center; border-bottom:1px solid rgba(127,127,127,.2); {{ $dia->isToday() ? 'color: rgb(13 148 136); font-weight:700' : 'font-weight:600' }}">
                    {{ ucfirst($dia->translatedFormat('D d')) }}
                </div>
            @endforeach

            {{-- Columna de horas --}}
            <div style="position:relative; height:{{ ($horaFin - $horaInicio) * $alto }}px">
                @for ($h = $horaInicio; $h < $horaFin; $h++)
                    <div style="position:absolute; top:{{ ($h - $horaInicio) * $alto }}px; right:.4rem; font-size:.7rem; opacity:.6">{{ sprintf('%02d:00', $h) }}</div>
                @endfor
            </div>

            {{-- Días --}}
            @foreach ($dias as $dia)
                <div style="position:relative; height:{{ ($horaFin - $horaInicio) * $alto }}px; border-left:1px solid rgba(127,127,127,.2); {{ $dia->isToday() ? 'background: rgba(20,184,166,.05)' : '' }}">
                    @for ($h = $horaInicio; $h < $horaFin; $h++)
                        <div style="position:absolute; left:0; right:0; top:{{ ($h - $horaInicio) * $alto }}px; border-top:1px solid rgba(127,127,127,.12)"></div>
                    @endfor
                    @foreach ($citas->get($dia->toDateString(), []) as $cita)
                        @php
                            $top = (($cita->inicio->hour - $horaInicio) + $cita->inicio->minute / 60) * $alto;
                            $altura = max(22, $cita->inicio->diffInMinutes($cita->fin) / 60 * $alto - 2);
                            $carril = max(0, $carriles->search($cita->profesional_id));
                            $ancho = 100 / max(1, $carriles->count());
                            $compacta = $carriles->count() > 1;
                        @endphp
                        <a href="{{ $urlEditar($cita) }}"
                           title="{{ $cita->paciente->nombre }} · {{ $cita->servicio->nombre }} · {{ $cita->profesional->nombre }}"
                           style="position:absolute; left:calc({{ $carril * $ancho }}% + 2px); width:calc({{ $ancho }}% - 4px); top:{{ $top }}px; height:{{ $altura }}px; overflow:hidden; border-radius:.4rem; padding:.2rem .35rem; font-size:.7rem; line-height:1.15; color:#0f172a; background: {{ $cita->profesional->color }}26; border-left:3px solid {{ $cita->profesional->color }}; {{ $cita->estado === 'pendiente' ? 'outline:1px dashed '.$cita->profesional->color : '' }}">
                            @if ($compacta)
                                <strong>{{ $cita->inicio->format('H:i') }}</strong><br>{{ \Illuminate\Support\Str::before($cita->paciente->nombre, ' ') }}
                            @else
                                <strong>{{ $cita->inicio->format('H:i') }}</strong> {{ $cita->paciente->nombre }}<br>
                                <span style="opacity:.75">{{ $cita->servicio->nombre }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    <p style="font-size:.8rem; opacity:.7">Cada color es un profesional. Las citas con borde punteado están pendientes de confirmar. Pasa el mouse sobre una cita para ver el detalle o haz clic para editarla. Filtra por profesional para ver más información.</p>
</x-filament-panels::page>
