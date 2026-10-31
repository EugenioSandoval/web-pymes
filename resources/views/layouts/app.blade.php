<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', config('negocio.nombre').' | Páginas web y sistemas para pymes')</title>
    <meta name="description" content="Páginas web, reservas en línea y sistemas de gestión a medida para pymes de {{ config('negocio.ciudad') }}.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-800 antialiased">
    @yield('contenido')

    {{-- Botón flotante de WhatsApp --}}
    <a href="https://wa.me/{{ config('negocio.whatsapp') }}?text={{ urlencode('Hola, quiero información sobre una página web para mi negocio') }}"
       target="_blank" rel="noopener"
       class="fixed bottom-5 right-5 z-50 flex items-center gap-2 rounded-full bg-[#25D366] px-4 py-3 font-semibold text-white shadow-lg hover:brightness-95"
       aria-label="Escríbenos por WhatsApp">
        <x-icono nombre="whatsapp" class="size-6" />
        <span class="hidden sm:inline">Escríbenos</span>
    </a>
</body>
</html>
