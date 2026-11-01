<?php

// Datos de contacto de la página de venta. Se cambian en el archivo .env.
return [
    'nombre' => env('NEGOCIO_NOMBRE', 'Mostrador Digital'),
    'whatsapp' => env('NEGOCIO_WHATSAPP', '56900000000'), // formato internacional sin "+"
    'email' => env('NEGOCIO_EMAIL', 'contacto@mostradordigital.cl'),
    'ciudad' => env('NEGOCIO_CIUDAD', 'Chillán, Ñuble'),

    // Paquetes que aparecen en la página. Precios en CLP, sin IVA.
    'paquetes' => [
        [
            'nombre' => 'Web informativa',
            'para' => 'Para que te encuentren en Google y te escriban.',
            'desde' => 250000,
            'mensual' => 25000,
            'destacado' => false,
            'incluye' => [
                'Hasta 5 secciones adaptadas a celular',
                'Botón de WhatsApp y formulario de contacto',
                'Ubicación en Google Maps',
                'Dominio .cl y correo con tu nombre',
            ],
        ],
        [
            'nombre' => 'Web con reservas o pedidos',
            'para' => 'Para recibir horas, pedidos o cotizaciones en línea.',
            'desde' => 600000,
            'mensual' => 50000,
            'destacado' => true,
            'incluye' => [
                'Todo lo de la web informativa',
                'Agenda de horas o pedidos en línea',
                'Catálogo de productos o servicios',
                'Cotizador simple',
                'Panel para editar tus contenidos',
            ],
        ],
        [
            'nombre' => 'Plataforma con gestión',
            'para' => 'Para ordenar clientes, equipo y operación en un solo lugar.',
            'desde' => 1500000,
            'mensual' => 100000,
            'destacado' => false,
            'incluye' => [
                'Todo lo de la web con reservas',
                'Gestión de clientes y trabajadores',
                'Cotizaciones en PDF',
                'Calendario de eventos y turnos',
                'Reportes y módulos a tu medida',
            ],
        ],
    ],

    // Fotos reales de Pexels (licencia gratuita, uso comercial permitido, sin atribución obligatoria).
    // El número es el ID de la foto en pexels.com/photo/...-ID/. Para cambiar una foto, busca otra en Pexels y pega su ID.
    'foto_portada' => 6205523, // Empleada con tablet en el mostrador de un café

    // Rubros que aparecen como ejemplos.
    'rubros' => [
        ['nombre' => 'Salud', 'foto' => 20860595, 'detalle' => 'Kinesiología, psicología, nutrición y consultas: reserva de horas, fichas y recordatorios.', 'icono' => 'salud'],
        ['nombre' => 'Transporte de pasajeros', 'foto' => 5481705, 'detalle' => 'Buses y transfers: horarios, reserva de pasajes, conductores y flota.', 'icono' => 'bus'],
        ['nombre' => 'Servicios técnicos', 'foto' => 4116198, 'detalle' => 'Talleres y mantenciones: cotizaciones, órdenes de trabajo e historial.', 'icono' => 'herramienta'],
        ['nombre' => 'Estética y bienestar', 'foto' => 7755223, 'detalle' => 'Peluquerías, barberías y spa: agenda en línea y catálogo de servicios.', 'icono' => 'tijera'],
        ['nombre' => 'Panaderías y pastelerías', 'foto' => 36445004, 'detalle' => 'Catálogo, pedidos por encargo para eventos y despacho.', 'icono' => 'pan'],
        ['nombre' => 'Turismo y agro', 'foto' => 7212851, 'detalle' => 'Cabañas y productores de Ñuble: reservas, catálogo y cotización por volumen.', 'icono' => 'hoja'],
    ],
];
