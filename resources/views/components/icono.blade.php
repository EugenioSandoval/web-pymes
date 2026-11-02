@props(['nombre'])
@php
$rutas = [
    'whatsapp' => '<path fill="currentColor" stroke="none" d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2Zm5.3 14.2c-.2.6-1.3 1.2-1.8 1.2-.5.1-1 .2-3.3-.7-2.8-1.1-4.5-3.9-4.7-4.1-.1-.2-1.1-1.5-1.1-2.9s.7-2 1-2.3c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5l.9 2c.1.2.1.3 0 .5l-.3.5-.4.4c-.1.1-.3.3-.1.6.2.3.8 1.3 1.7 2.1 1.2 1 2.1 1.3 2.4 1.5.3.1.5.1.6-.1l.9-1c.2-.3.4-.2.6-.1l1.9.9c.3.1.5.2.5.3.1.2.1.7-.1 1.2Z"/>',
    'check' => '<path d="m5 12 5 5 9-10"/>',
    'salud' => '<path d="M12 21s-7-4.4-9-9.5C1.6 7.8 4 4 7.5 4c2 0 3.5 1.2 4.5 2.6C13 5.2 14.5 4 16.5 4 20 4 22.4 7.8 21 11.5 19 16.6 12 21 12 21Z"/><path d="M12 9v6M9 12h6"/>',
    'bus' => '<rect x="4" y="3" width="16" height="14" rx="2"/><path d="M4 11h16M8 21v-4M16 21v-4"/><circle cx="8" cy="14" r=".5"/><circle cx="16" cy="14" r=".5"/>',
    'herramienta' => '<path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 0 0 5.4-5.4l-2.5 2.5-2.4-.6-.6-2.4Z"/>',
    'tijera' => '<circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><path d="M8.1 8.1 20 20M8.1 15.9 20 4"/>',
    'pan' => '<path d="M4 11a8 5 0 0 1 16 0v1a2 2 0 0 1-2 2v5H6v-5a2 2 0 0 1-2-2Z"/><path d="M9 9v3M12 8v4M15 9v3"/>',
    'hoja' => '<path d="M5 19c0-9 6-14 15-14 0 9-5 15-14 15"/><path d="M5 19 13 11"/>',
    'diente' => '<path d="M7 3c-2.5 0-4 2-4 4.5 0 3 1.5 4.5 2 7 .4 2.2.8 6.5 2.5 6.5 1.6 0 1.8-4.5 2.5-6 .3-.7.7-1 2-1s1.7.3 2 1c.7 1.5.9 6 2.5 6 1.7 0 2.1-4.3 2.5-6.5.5-2.5 2-4 2-7C21 5 19.5 3 17 3c-2 0-3 1-5 1S9 3 7 3Z"/>',
    'calendario' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>',
    'usuarios' => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0"/><path d="M16 4.5a3.5 3.5 0 0 1 0 7M18 14a6 6 0 0 1 3.5 6"/>',
    'documento' => '<path d="M6 2h9l5 5v15H6Z"/><path d="M14 2v6h6M9 13h6M9 17h6"/>',
    'celular' => '<rect x="7" y="2" width="10" height="20" rx="2"/><path d="M11 18h2"/>',
    'monitor' => '<rect x="2" y="4" width="20" height="13" rx="2"/><path d="M8 21h8M12 17v4"/>',
    'carrito' => '<circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/><path d="M2 3h3l2.7 12.4a1 1 0 0 0 1 .8h9.6a1 1 0 0 0 1-.8L21 7H6"/>',
    'grafico' => '<path d="M3 3v18h18"/><path d="M7 15l4-4 3 3 6-7"/>',
    'escudo' => '<path d="M12 2 4 5v6c0 5 3.5 9.5 8 11 4.5-1.5 8-6 8-11V5Z"/><path d="m9 12 2 2 4-4"/>',
    'rayo' => '<path d="M13 2 4 14h7l-1 8 9-12h-7Z"/>',
    'mensaje' => '<path d="M4 4h16v12H8l-4 4Z"/><path d="M8 9h8M8 12h5"/>',
    'cohete' => '<path d="M5 15c-1.5 1.5-2 5-2 5s3.5-.5 5-2"/><path d="M9 15 6 12c1-4 4-9 12-10 0 8-5 11-9 13Z"/><circle cx="14.5" cy="8.5" r="1.5"/><path d="M6 12H3l3-4h4M12 18v3l4-3v-4"/>',
    'lapiz' => '<path d="M4 20h4L19 9l-4-4L4 16Z"/><path d="m13 7 4 4"/>',
];
@endphp
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" {{ $attributes }}>{!! $rutas[$nombre] ?? '' !!}</svg>
