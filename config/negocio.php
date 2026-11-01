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

    // Preguntas de la sección "¿Tu negocio ya está en internet?". Edítalas aquí.
    'preguntas' => [
        ['icono' => 'celular', 'pregunta' => '¿Todavía no tienes tu tienda en línea?', 'respuesta' => 'Vende las 24 horas, aunque tu local esté cerrado.'],
        ['icono' => 'hoja', 'pregunta' => '¿Te buscan en Google y no encuentran tus productos ni servicios?', 'respuesta' => 'Muéstralos con fotos, precios y un botón directo a tu WhatsApp.'],
        ['icono' => 'documento', 'pregunta' => '¿Las cotizaciones te llegan por todos lados y algunas se pierden?', 'respuesta' => 'Tus clientes cotizan en tu web y tú las respondes desde un solo panel.'],
        ['icono' => 'check', 'pregunta' => '¿Anotas los pedidos en un cuaderno o en el chat?', 'respuesta' => 'Recibe, ordena y sigue cada pedido hasta la entrega.'],
        ['icono' => 'calendario', 'pregunta' => '¿Tus clientes tienen que llamarte para pedir una hora?', 'respuesta' => 'Que reserven en línea y reciban su confirmación al instante.'],
        ['icono' => 'usuarios', 'pregunta' => '¿No sabes cuánto vendiste este mes sin sacar la calculadora?', 'respuesta' => 'Mira ventas, clientes y pendientes en reportes simples.'],
    ],

    // Fotos de los rubros. Cada "foto" puede ser:
    //  - un número: el ID de una foto de Pexels (pexels.com/photo/...-ID/), gratis para uso comercial, o
    //  - una ruta dentro de public/, por ejemplo 'img/rubros/panaderia.jpg', para usar tus propias imágenes.
    'foto_portada' => 4473496, // Cajera usando la pantalla del mostrador (foto horizontal)

    // Rubros: los que tienen 'portada' => true aparecen con foto al lado del título (máximo 6).
    // 'antes', 'ahora' y 'resultado' alimentan la sección "Antes y después".
    'rubros' => [
        [
            'nombre' => 'Panaderías y pastelerías', 'corto' => 'Panaderías', 'icono' => 'pan', 'portada' => true,
            'foto' => 36445004,
            'detalle' => 'Pedidos por encargo para cumpleaños y eventos, catálogo y despacho.',
            'antes' => ['Encargos de tortas anotados en un cuaderno o en el WhatsApp personal', 'Pedidos olvidados o duplicados el día del evento', 'Clientes que llaman para preguntar si queda pan o a qué hora sale', 'Sin saber qué productos se venden más'],
            'ahora' => ['Catálogo en línea con pedidos y fecha de entrega', 'Lista de producción del día armada sola', 'Aviso al cliente cuando su pedido está listo', 'Ventas por producto a la vista en el panel'],
            'resultado' => 'Más encargos para eventos y ninguna torta olvidada.',
        ],
        [
            'nombre' => 'Salud y kinesiología', 'corto' => 'Salud', 'icono' => 'salud', 'portada' => true,
            'foto' => 4266943, // Profesional mostrando una tablet al paciente
            'detalle' => 'Kinesiología, psicología, nutrición y consultas: reserva de horas, fichas y recordatorios.',
            'antes' => ['Recepción todo el día al teléfono agendando horas', 'Pacientes que no llegan y dejan horas vacías', 'Fichas en papel o en Excel repartidas en varios computadores', 'Planes y presupuestos cotizados a mano'],
            'ahora' => ['Reservas desde la web las 24 horas', 'Recordatorio al paciente antes de su hora', 'La ficha de cada paciente en un solo lugar', 'Cotizaciones en PDF en un minuto'],
            'resultado' => 'Agenda más llena y recepción libre para atender.',
        ],
        [
            'nombre' => 'Clínicas dentales', 'corto' => 'Dental', 'icono' => 'diente', 'portada' => true,
            'foto' => 6627325,
            'detalle' => 'Agenda por sillón, presupuestos de tratamiento por etapas y control de abonos.',
            'antes' => ['Presupuestos de tratamiento escritos a mano que el paciente pierde', 'Tratamientos largos sin seguimiento de cuántas sesiones faltan', 'Abonos y saldos anotados en un cuaderno', 'Controles de limpieza que nadie recuerda agendar'],
            'ahora' => ['Presupuesto en PDF por etapas, listo para enviar', 'Plan de tratamiento con sesiones hechas y pendientes', 'Abonos y saldos de cada paciente al día', 'Aviso automático del próximo control'],
            'resultado' => 'Más tratamientos aceptados y pacientes que vuelven a su control.',
        ],
        [
            'nombre' => 'Buses y transfers', 'corto' => 'Buses', 'icono' => 'bus', 'portada' => true,
            'foto' => 18470737, // Pasajeros subiendo a un bus en el terminal
            'detalle' => 'Venta y reserva de pasajes, cotizaciones de viajes especiales enviadas al cliente, conductores y flota.',
            'antes' => ['Pasajes vendidos solo en boletería o por teléfono', 'Cotizaciones de viajes especiales (paseos, empresas, matrimonios) hechas a mano y enviadas tarde', 'Asientos sobrevendidos o buses que salen con cupos vacíos', 'Turnos de conductores en planillas de papel', 'Pasajeros que no saben si quedan asientos'],
            'ahora' => ['Venta y reserva de pasajes en línea, con elección de asiento', 'Cotizaciones de viajes especiales generadas en minutos y enviadas al cliente por correo o WhatsApp', 'Cupos actualizados al instante', 'Turnos de conductores y estado de la flota en el panel', 'Confirmación automática al pasajero'],
            'resultado' => 'Buses más llenos, más viajes especiales cerrados y menos llamadas.',
        ],
        [
            'nombre' => 'Talleres y servicios técnicos', 'corto' => 'Talleres', 'icono' => 'herramienta', 'portada' => true,
            'foto' => 4116198,
            'detalle' => 'Cotizaciones, órdenes de trabajo e historial por cliente o patente.',
            'antes' => ['Presupuestos a mano que se pierden', 'Clientes que llaman a preguntar si su auto está listo', 'Sin historial de lo que se le hizo a cada vehículo', 'Mantenciones que nadie le recuerda al cliente'],
            'ahora' => ['Cotización en PDF enviada por WhatsApp', 'Estado de cada orden: recibido, en reparación, listo', 'Historial por patente', 'Aviso automático de la próxima mantención'],
            'resultado' => 'Clientes que vuelven y menos tiempo al teléfono.',
        ],
        [
            'nombre' => 'Estética y bienestar', 'corto' => 'Estética', 'icono' => 'tijera', 'portada' => true,
            'foto' => 7755223,
            'detalle' => 'Peluquerías, barberías y spa: agenda en línea y catálogo de servicios.',
            'antes' => ['Horas pedidas por Instagram a cualquier hora del día', 'Clientas y clientes que no llegan y nadie lo anota', 'Una agenda en papel que solo ve una persona'],
            'ahora' => ['Reserva en línea con servicios y precios', 'Recordatorio un día antes', 'Agenda por profesional que todo el equipo puede ver'],
            'resultado' => 'Menos horas perdidas y más tiempo para atender.',
        ],
        [
            'nombre' => 'Cabañas y turismo rural', 'corto' => 'Turismo', 'icono' => 'hoja', 'portada' => false,
            'foto' => 7212851,
            'detalle' => 'Reservas con calendario de disponibilidad y abonos en línea.',
            'antes' => ['Reservas por teléfono y transferencias que hay que revisar una por una', 'Fechas cruzadas entre dos personas que reservan lo mismo', 'Temporada baja sin forma de ofrecer promociones'],
            'ahora' => ['Calendario de disponibilidad en la web', 'Reserva con abono y confirmación automática', 'Lista de clientes para avisar promociones'],
            'resultado' => 'Menos reservas cruzadas y más ocupación en temporada baja.',
        ],
    ],

    // Beneficios generales que aparecen bajo "Antes y después".
    'beneficios' => [
        ['titulo' => 'Vende más', 'texto' => 'Te encuentran en Google y te compran o reservan a cualquier hora, no solo cuando contestas.'],
        ['titulo' => 'Organízate mejor', 'texto' => 'Clientes, equipo, agenda y cotizaciones en un solo lugar, desde el celular.'],
        ['titulo' => 'No pierdas clientes', 'texto' => 'Recordatorios y seguimiento para que nadie quede sin respuesta.'],
        ['titulo' => 'Gana tiempo', 'texto' => 'Menos llamadas, menos cuadernos y menos planillas que cuadrar.'],
    ],
];
