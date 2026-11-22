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

    // Slider de la portada: cada rubro con su foto, la palabra que cambia en el título
    // ("Software para ___"), las funciones que aparecen como tarjetas flotantes y un mini panel.
    // 'filas' son [texto, estado]. 'foto' = ID de Pexels o ruta dentro de public/.
    'slider' => [
        [
            'rubro' => 'Salud y kinesiología', 'corto' => 'Salud', 'palabra' => 'centros de salud', 'icono' => 'salud', 'foto' => 20860624,
            'frase' => 'Pacientes que reservan solos y una agenda que se llena sin llamadas.',
            'funciones' => [['calendario', 'Reservas online'], ['documento', 'Ficha digital'], ['whatsapp', 'Recordatorios']],
            'panel' => 'Agenda de hoy',
            'filas' => [['09:00 Camila R. · Kinesiología', 'Confirmada'], ['10:00 Jorge M. · Evaluación', 'Confirmada'], ['16:00 Ana P. · Masaje', 'Nueva']],
            'aviso' => ['Nueva reserva', 'Desde la web · hace 1 min'],
        ],
        [
            'rubro' => 'Clínicas dentales', 'corto' => 'Dental', 'palabra' => 'clínicas dentales', 'icono' => 'diente', 'foto' => 4269490,
            'frase' => 'Fichas, presupuestos por etapas y control de abonos en un solo lugar.',
            'funciones' => [['calendario', 'Agenda por sillón'], ['documento', 'Presupuestos'], ['whatsapp', 'Confirmación por WhatsApp']],
            'panel' => 'Presupuestos',
            'filas' => [['Ortodoncia · 18 cuotas', 'Aceptado'], ['Implante pieza 36', 'Enviado'], ['Limpieza + blanqueamiento', 'Borrador']],
            'aviso' => ['Abono registrado', '$45.000 · Ortodoncia'],
        ],
        [
            'rubro' => 'Veterinarias', 'corto' => 'Veterinarias', 'palabra' => 'veterinarias', 'icono' => 'huella', 'foto' => 6235242,
            'frase' => 'Historia clínica de cada mascota, vacunas al día y avisos a sus dueños.',
            'funciones' => [['documento', 'Historia clínica'], ['calendario', 'Agenda de citas'], ['campana', 'Aviso de vacunas']],
            'panel' => 'Pacientes de hoy',
            'filas' => [['10:30 Luna · Control', 'Confirmada'], ['12:00 Rocky · Vacuna óctuple', 'Confirmada'], ['17:00 Michi · Peluquería', 'Nueva']],
            'aviso' => ['Recordatorio enviado', 'Vacuna antirrábica de Toby'],
        ],
        [
            'rubro' => 'Panaderías y pastelerías', 'corto' => 'Panaderías', 'palabra' => 'panaderías', 'icono' => 'pan', 'foto' => 7447275,
            'frase' => 'Encargos de tortas, berlines y kuchen ordenados por día de entrega.',
            'funciones' => [['carrito', 'Pedidos online'], ['calendario', 'Entregas por día'], ['grafico', 'Ventas por producto']],
            'panel' => 'Pedidos de hoy',
            'filas' => [['Torta selva negra · 20 personas', 'Para las 17:00'], ['24 berlines de crema', 'Listo'], ['Kuchen de nuez · retiro', 'Nuevo']],
            'aviso' => ['Nuevo encargo', 'Torta de cumpleaños · desde la web'],
        ],
        [
            'rubro' => 'Buses, taxibuses y minibuses', 'corto' => 'Buses', 'palabra' => 'buses y transfers', 'icono' => 'bus', 'foto' => 'img/slider/buses.jpg', 'posicion' => '15% center',
            'frase' => 'Cotizaciones de viajes, flota, conductores, pagos y programación diaria a tu medida.',
            'funciones' => [['documento', 'Cotizaciones'], ['bus', 'Flota y conductores'], ['calendario', 'Salidas del día']],
            'panel' => 'Salidas de hoy',
            'filas' => [['07:30 Chillán → Concepción', '38/44 asientos'], ['COT-0087 · Paseo a Termas', 'Aceptada'], ['18:00 Chillán → Talca', '12/44 asientos']],
            'aviso' => ['Cotización enviada', 'Por WhatsApp al cliente'],
        ],
        [
            'rubro' => 'Talleres mecánicos', 'corto' => 'Talleres', 'palabra' => 'talleres', 'icono' => 'herramienta', 'foto' => 6720502,
            'frase' => 'Órdenes de trabajo, presupuestos y aviso automático cuando el auto está listo.',
            'funciones' => [['documento', 'Órdenes de trabajo'], ['auto', 'Historial por patente'], ['whatsapp', 'Aviso de retiro']],
            'panel' => 'Órdenes de trabajo',
            'filas' => [['Toyota Yaris · cambio de frenos', 'En taller'], ['Kia Rio · mantención 30.000 km', 'Listo'], ['Hyundai Accent · diagnóstico', 'Presupuesto']],
            'aviso' => ['Cliente avisado', 'Su auto está listo para retiro'],
        ],
        [
            'rubro' => 'Lavado de autos', 'corto' => 'Lavado', 'palabra' => 'lavados de autos', 'icono' => 'gota', 'foto' => 6872591,
            'frase' => 'Horas por bloque, planes de lavado mensual y el auto listo sin esperar en fila.',
            'funciones' => [['calendario', 'Reserva por bloque'], ['tarjeta', 'Planes mensuales'], ['whatsapp', 'Aviso de auto listo']],
            'panel' => 'Lavados de hoy',
            'filas' => [['10:00 Lavado full · SUV', 'En proceso'], ['11:00 Encerado · Sedán', 'Confirmada'], ['12:30 Interior + motor', 'Nueva']],
            'aviso' => ['Auto listo', 'Aviso enviado a Pedro S.'],
        ],
        [
            'rubro' => 'Barberías y peluquerías', 'corto' => 'Barberías', 'palabra' => 'barberías', 'icono' => 'tijera', 'foto' => 7518731,
            'frase' => 'Cada barbero con su agenda, reservas en segundos y clientes que no fallan.',
            'funciones' => [['calendario', 'Agenda por barbero'], ['whatsapp', 'Recordatorio'], ['estrella', 'Clientes frecuentes']],
            'panel' => 'Agenda de la barbería',
            'filas' => [['11:00 Fade + barba · Matías', 'Confirmada'], ['11:45 Corte clásico · Diego', 'Confirmada'], ['12:30 Corte niño · Matías', 'Nueva']],
            'aviso' => ['Nueva reserva', 'Corte + barba · sábado 10:00'],
        ],
        [
            'rubro' => 'Estética y spa', 'corto' => 'Estética', 'palabra' => 'centros de estética', 'icono' => 'brillo', 'foto' => 8834029,
            'frase' => 'Reservas por sala, packs de sesiones y catálogo de servicios con precios.',
            'funciones' => [['calendario', 'Reservas por sala'], ['tarjeta', 'Packs de sesiones'], ['whatsapp', 'Recordatorios']],
            'panel' => 'Agenda del salón',
            'filas' => [['11:00 Limpieza facial · Sala 1', 'Confirmada'], ['12:30 Manicure · Sala 2', 'Confirmada'], ['15:00 Masaje · Sala 1', 'Nueva']],
            'aviso' => ['Recordatorio enviado', 'A 6 clientas de mañana'],
        ],
    ],

    // Cifras que aparecen bajo la portada (no son estadísticas: son lo que ofreces).
    'cifras' => [
        ['24/7', 'tu negocio recibiendo reservas y pedidos'],
        ['2 a 8', 'semanas desde la reunión hasta el lanzamiento'],
        ['1', 'panel para clientes, equipo, agenda y cotizaciones'],
        ['100%', 'de tus datos son tuyos, siempre'],
    ],

    // Conversación de ejemplo del asistente por WhatsApp.
    'chat' => [
        ['cliente', 'Hola! necesito hora para mi perrita mañana 🐶', '16:37'],
        ['negocio', '¡Hola! 👋 Mañana tengo disponible a las 10:00, 12:30 y 17:00. ¿Cuál prefieres?', '16:37'],
        ['cliente', 'A las 10 porfa', '16:38'],
        ['negocio', '✅ Listo: control para Luna, mañana 10:00 con la Dra. Pérez. Te recuerdo 2 horas antes.', '16:38'],
    ],

    // Lo que hacemos (tarjetas de servicios).
    'servicios' => [
        ['icono' => 'monitor', 'titulo' => 'Página web profesional', 'texto' => 'Rápida, adaptada a celular y lista para aparecer en Google.'],
        ['icono' => 'whatsapp', 'titulo' => 'WhatsApp automático', 'texto' => 'Confirmaciones, recordatorios y avisos que salen solos. Menos inasistencias.'],
        ['icono' => 'carrito', 'titulo' => 'Tienda y pedidos en línea', 'texto' => 'Catálogo con precios, carrito y pedidos que llegan ordenados.'],
        ['icono' => 'calendario', 'titulo' => 'Reservas y agenda', 'texto' => 'Tus clientes eligen día y hora; tú ves la agenda de todo el equipo.'],
        ['icono' => 'documento', 'titulo' => 'Cotizaciones en PDF', 'texto' => 'Crea, envía y sigue cotizaciones con tu logo en minutos.'],
        ['icono' => 'usuarios', 'titulo' => 'Clientes y trabajadores', 'texto' => 'Fichas, historial, turnos y permisos para cada persona.'],
        ['icono' => 'grafico', 'titulo' => 'Reportes del negocio', 'texto' => 'Ventas, reservas y pendientes del mes, sin planillas.'],
    ],

    // Pasos para trabajar juntos.
    'proceso' => [
        ['icono' => 'mensaje', 'titulo' => 'Conversamos', 'texto' => 'Reunión gratis para entender tu negocio y lo que necesitas.'],
        ['icono' => 'lapiz', 'titulo' => 'Diseñamos', 'texto' => 'Te mostramos cómo se verá antes de construir nada.'],
        ['icono' => 'rayo', 'titulo' => 'Construimos', 'texto' => 'Avances semanales que puedes revisar desde tu celular.'],
        ['icono' => 'cohete', 'titulo' => 'Lanzamos y te acompañamos', 'texto' => 'Te enseñamos a usarlo y seguimos mejorándolo cada mes.'],
    ],

    // Qué incluye la mensualidad.
    'mensualidad' => ['Hosting y dominio', 'Certificado de seguridad (candado)', 'Respaldos diarios', 'Soporte por WhatsApp', 'Horas de cambios y mejoras', 'Actualizaciones de seguridad'],

    // Garantías.
    'garantias' => [
        ['icono' => 'escudo', 'titulo' => 'Tus datos son tuyos', 'texto' => 'Si algún día te vas, te entregamos todo.'],
        ['icono' => 'mensaje', 'titulo' => 'Soporte cercano', 'texto' => 'Por WhatsApp, con alguien de la zona.'],
        ['icono' => 'documento', 'titulo' => 'Precio claro', 'texto' => 'Cotización por escrito, sin letra chica.'],
        ['icono' => 'lapiz', 'titulo' => 'Apruebas el diseño', 'texto' => 'No construimos hasta que te guste.'],
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

    // Rubros: los que tienen 'portada' => true aparecen en la grilla de rubros con foto.
    // 'claves' son las 3 funciones que se muestran como etiquetas en la tarjeta.
    // 'antes', 'ahora' y 'resultado' alimentan la sección "Antes y después".
    'rubros' => [
        [
            'nombre' => 'Salud y kinesiología', 'corto' => 'Salud', 'icono' => 'salud', 'portada' => true,
            'foto' => 4266943, // Profesional mostrando una tablet al paciente
            'detalle' => 'Kinesiología, psicología, nutrición y consultas: reserva de horas, fichas y recordatorios.',
            'claves' => ['Reservas online', 'Ficha digital', 'Agenda por profesional'],
            'antes' => ['Recepción todo el día al teléfono agendando horas', 'Pacientes que no llegan y dejan horas vacías', 'Fichas en papel o en Excel repartidas en varios computadores', 'Planes y presupuestos cotizados a mano'],
            'ahora' => ['Reservas desde la web las 24 horas', 'Recordatorio al paciente antes de su hora', 'La ficha de cada paciente en un solo lugar', 'Cotizaciones en PDF en un minuto'],
            'resultado' => 'Agenda más llena y recepción libre para atender.',
        ],
        [
            'nombre' => 'Clínicas dentales', 'corto' => 'Dental', 'icono' => 'diente', 'portada' => true,
            'foto' => 6627325,
            'detalle' => 'Agenda por sillón, presupuestos de tratamiento por etapas y control de abonos.',
            'claves' => ['Presupuesto por etapas', 'Control de abonos', 'Confirmación por WhatsApp'],
            'antes' => ['Presupuestos de tratamiento escritos a mano que el paciente pierde', 'Pacientes que no llegan y nadie confirmó la hora', 'Abonos y saldos anotados en un cuaderno', 'Controles de limpieza que nadie recuerda agendar'],
            'ahora' => ['Presupuesto en PDF por etapas, listo para enviar', 'Confirmación de la hora por WhatsApp el día antes', 'Abonos y saldos de cada paciente al día', 'Aviso automático del próximo control'],
            'resultado' => 'Menos inasistencias y más tratamientos aceptados.',
        ],
        [
            'nombre' => 'Veterinarias', 'corto' => 'Veterinarias', 'icono' => 'huella', 'portada' => true,
            'foto' => 7470754, // Veterinaria revisando a un perro
            'detalle' => 'Historia clínica por mascota, agenda de citas, vacunas y peluquería canina.',
            'claves' => ['Historia clínica', 'Calendario de vacunas', 'Recordatorios'],
            'antes' => ['Fichas de mascotas en papel que se pierden o no se entienden', 'Vacunas y desparasitaciones que el dueño olvida', 'Horas de consulta y peluquería mezcladas en un cuaderno', 'Dueños que llaman para saber si su mascota ya está lista'],
            'ahora' => ['Historia clínica de cada mascota con fotos y exámenes', 'Aviso automático de vacunas y controles al dueño', 'Agenda separada para consulta, cirugía y peluquería', 'Mensaje al dueño cuando su mascota está lista'],
            'resultado' => 'Mascotas con sus vacunas al día y dueños que vuelven.',
        ],
        [
            'nombre' => 'Panaderías y pastelerías', 'corto' => 'Panaderías', 'icono' => 'pan', 'portada' => true,
            'foto' => 36445004,
            'detalle' => 'Pedidos por encargo para cumpleaños y eventos, catálogo y despacho.',
            'claves' => ['Catálogo con precios', 'Encargos por fecha', 'Despacho'],
            'antes' => ['Encargos de tortas anotados en un cuaderno o en el WhatsApp personal', 'Pedidos olvidados o duplicados el día del evento', 'Clientes que llaman para preguntar si queda pan o a qué hora sale', 'Sin saber qué productos se venden más'],
            'ahora' => ['Catálogo en línea con pedidos y fecha de entrega', 'Lista de producción del día armada sola', 'Aviso al cliente cuando su pedido está listo', 'Ventas por producto a la vista en el panel'],
            'resultado' => 'Más encargos para eventos y ninguna torta olvidada.',
        ],
        [
            'nombre' => 'Buses, taxibuses y minibuses', 'corto' => 'Buses', 'icono' => 'bus', 'portada' => true,
            'foto' => 18470737, // Pasajeros subiendo a un bus en el terminal
            'detalle' => 'Pasajes, cotizaciones de viajes especiales, conductores y flota.',
            'claves' => ['Venta de pasajes', 'Cotizador de viajes', 'Flota y conductores'],
            'antes' => ['Pasajes vendidos solo en boletería o por teléfono', 'Cotizaciones de viajes especiales (paseos, empresas, matrimonios) hechas a mano y enviadas tarde', 'Asientos sobrevendidos o buses que salen con cupos vacíos', 'Turnos de conductores en planillas de papel', 'Pasajeros que no saben si quedan asientos'],
            'ahora' => ['Venta y reserva de pasajes en línea, con elección de asiento', 'Cotizaciones de viajes especiales generadas en minutos y enviadas al cliente por correo o WhatsApp', 'Cupos actualizados al instante', 'Turnos de conductores y estado de la flota en el panel', 'Confirmación automática al pasajero'],
            'resultado' => 'Buses más llenos, más viajes especiales cerrados y menos llamadas.',
        ],
        [
            'nombre' => 'Talleres y servicios técnicos', 'corto' => 'Talleres', 'icono' => 'herramienta', 'portada' => true,
            'foto' => 4116198,
            'detalle' => 'Cotizaciones, órdenes de trabajo e historial por cliente o patente.',
            'claves' => ['Órdenes de trabajo', 'Historial por patente', 'Aviso de retiro'],
            'antes' => ['Presupuestos a mano que se pierden', 'Clientes que llaman a preguntar si su auto está listo', 'Sin historial de lo que se le hizo a cada vehículo', 'Mantenciones que nadie le recuerda al cliente'],
            'ahora' => ['Cotización en PDF enviada por WhatsApp', 'Estado de cada orden: recibido, en reparación, listo', 'Historial por patente', 'Aviso automático de la próxima mantención'],
            'resultado' => 'Clientes que vuelven y menos tiempo al teléfono.',
        ],
        [
            'nombre' => 'Lavado de autos', 'corto' => 'Lavado', 'icono' => 'gota', 'portada' => true,
            'foto' => 5233271, // Auto cubierto de espuma
            'detalle' => 'Reserva por bloque horario, planes mensuales y aviso cuando el auto está listo.',
            'claves' => ['Reserva por bloque', 'Planes mensuales', 'Aviso de auto listo'],
            'antes' => ['Filas de autos esperando los sábados y clientes que se van', 'Días de semana con el local vacío', 'Pagos en efectivo sin registro de quién es cliente frecuente', 'Clientes que esperan en el local sin saber cuánto falta'],
            'ahora' => ['Reserva en línea por bloque y tipo de lavado', 'Promociones para llenar los días tranquilos', 'Planes de lavado mensual con cobro y registro', 'Aviso por WhatsApp cuando el auto está listo'],
            'resultado' => 'Agenda pareja toda la semana y clientes que vuelven cada mes.',
        ],
        [
            'nombre' => 'Barberías y peluquerías', 'corto' => 'Barberías', 'icono' => 'tijera', 'portada' => true,
            'foto' => 3105409, // Barbero cortando el pelo
            'detalle' => 'Agenda por barbero o estilista, reservas en segundos y clientes frecuentes.',
            'claves' => ['Agenda por barbero', 'Reserva en segundos', 'Clientes frecuentes'],
            'antes' => ['Horas pedidas por Instagram a cualquier hora del día', 'Clientes que no llegan y nadie lo anota', 'Cada barbero con su propia libreta', 'Sin saber cuánto produjo cada sillón en el mes'],
            'ahora' => ['Reserva en línea eligiendo barbero, servicio y hora', 'Recordatorio por WhatsApp un día antes', 'Agenda por barbero que todo el equipo puede ver', 'Comisiones y ventas por barbero calculadas solas'],
            'resultado' => 'Sillones ocupados y menos horas perdidas.',
        ],
        [
            'nombre' => 'Estética y spa', 'corto' => 'Estética', 'icono' => 'brillo', 'portada' => true,
            'foto' => 7755223,
            'detalle' => 'Centros de estética, manicure y spa: reservas por sala, packs y catálogo.',
            'claves' => ['Reservas por sala', 'Packs de sesiones', 'Catálogo con precios'],
            'antes' => ['Horas pedidas por mensaje y anotadas en papel', 'Packs de sesiones que nadie sabe cuántas quedan', 'Una agenda que solo ve una persona'],
            'ahora' => ['Reserva en línea con servicios y precios', 'Control de sesiones usadas y pendientes de cada pack', 'Agenda por profesional y sala que todo el equipo ve'],
            'resultado' => 'Menos horas perdidas y más packs vendidos.',
        ],
        [
            'nombre' => 'Cabañas y turismo rural', 'corto' => 'Turismo', 'icono' => 'hoja', 'portada' => false,
            'foto' => 7212851,
            'detalle' => 'Reservas con calendario de disponibilidad y abonos en línea.',
            'claves' => ['Calendario', 'Abonos', 'Promociones'],
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
