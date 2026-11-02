@php $clp = fn ($n) => \App\Support\Formato::clp($n); @endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Cotización {{ $cotizacion->numero }}</title>
    <style>
        body { font-family: system-ui, sans-serif; color: #0f172a; max-width: 760px; margin: 2rem auto; padding: 0 1rem; font-size: 14px; }
        header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 3px solid #1f9a86; padding-bottom: 1rem; }
        h1 { margin: 0; color: #0b3a34; font-size: 22px; }
        .muted { color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-top: 1.5rem; }
        th { text-align: left; background: #eef8f6; padding: .5rem; }
        td { padding: .5rem; border-bottom: 1px solid #e2e8f0; }
        .num { text-align: right; }
        .totales td { border: none; padding: .25rem .5rem; }
        .total { font-size: 18px; font-weight: 700; color: #0b3a34; }
        .boton { position: fixed; top: 1rem; right: 1rem; background: #17806f; color: #fff; border: 0; padding: .6rem 1rem; border-radius: .5rem; cursor: pointer; font-weight: 600; }
        @media print { .boton { display: none; } body { margin: 0; } }
    </style>
</head>
<body>
    <button class="boton" onclick="window.print()">Imprimir / Guardar PDF</button>
    <header>
        <div>
            <h1>Centro Kine Ñuble</h1>
            <p class="muted">Av. Libertad 123, Chillán · contacto@centrokine.cl</p>
        </div>
        <div style="text-align:right">
            <p style="font-size:18px; font-weight:700; margin:0">Cotización {{ $cotizacion->numero }}</p>
            <p class="muted">Fecha: {{ $cotizacion->fecha->format('d/m/Y') }}<br>
            @if ($cotizacion->valida_hasta) Válida hasta: {{ $cotizacion->valida_hasta->format('d/m/Y') }} @endif</p>
        </div>
    </header>

    <p style="margin-top:1.5rem"><strong>Paciente:</strong> {{ $cotizacion->paciente->nombre }}
        @if ($cotizacion->paciente->rut) · RUT {{ $cotizacion->paciente->rut }} @endif<br>
        <span class="muted">{{ $cotizacion->paciente->telefono }} {{ $cotizacion->paciente->email ? '· '.$cotizacion->paciente->email : '' }}</span></p>

    <table>
        <thead><tr><th>Descripción</th><th class="num">Cantidad</th><th class="num">Precio unitario</th><th class="num">Subtotal</th></tr></thead>
        <tbody>
            @foreach ($cotizacion->items as $item)
                <tr>
                    <td>{{ $item->descripcion }}</td>
                    <td class="num">{{ $item->cantidad }}</td>
                    <td class="num">{{ $clp($item->precio_unitario) }}</td>
                    <td class="num">{{ $clp($item->cantidad * $item->precio_unitario) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="totales" style="width:auto; margin-left:auto">
        <tr><td>Subtotal</td><td class="num">{{ $clp($cotizacion->subtotal()) }}</td></tr>
        @if ($cotizacion->descuento_porcentaje)
            <tr><td>Descuento ({{ $cotizacion->descuento_porcentaje }}%)</td><td class="num">−{{ $clp($cotizacion->descuento()) }}</td></tr>
        @endif
        <tr><td class="total">Total</td><td class="num total">{{ $clp($cotizacion->total()) }}</td></tr>
    </table>
    @if ($cotizacion->observaciones)
        <p style="margin-top:2rem"><strong>Observaciones:</strong> {{ $cotizacion->observaciones }}</p>
    @endif
    <p class="muted" style="margin-top:3rem; font-size:12px">Prestaciones de salud exentas de IVA. Documento generado desde el demo de {{ config('negocio.nombre') }}.</p>
</body>
</html>
