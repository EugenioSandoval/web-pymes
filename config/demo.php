<?php

// Contenido de la web pública del demo "Centro Kine Ñuble" (centro de salud ficticio).
// Los servicios, profesionales y horas vienen de la base de datos; aquí está el resto de los textos.
// 'foto' es el ID de una foto de Pexels o una ruta dentro de public/.
return [
    'centro' => [
        'nombre' => 'Centro Kine Ñuble',
        'direccion' => 'Av. Libertad 123, Chillán',
        'telefono' => '+56 9 0000 0000',
        'email' => 'contacto@centrokine.cl',
        'horario' => [
            ['Lunes a viernes', '09:00 a 18:30'],
            ['Sábado', '09:00 a 13:00 (solo kinesiología)'],
            ['Domingo y festivos', 'Cerrado'],
        ],
    ],

    'cifras' => [
        ['+2.000', 'pacientes atendidos'],
        ['4,9 ★', '320 reseñas en Google'],
        ['8 años', 'cuidando a Ñuble'],
        ['24/7', 'reservas en línea'],
    ],

    // Cada especialidad agrupa servicios por su nombre exacto en la base de datos.
    'especialidades' => [
        'kinesiologia' => [
            'nombre' => 'Kinesiología',
            'foto' => 20860622,
            'resumen' => 'Dolor de espalda, cuello, rodilla u hombro. Te evaluamos y armamos un plan para que vuelvas a moverte sin dolor.',
            'detalle' => 'Tratamos lesiones musculares, articulares y de columna con ejercicio terapéutico, terapia manual y fisioterapia. Cada paciente parte con una evaluación y recibe un plan con objetivos medibles y ejercicios para la casa.',
            'trata' => ['Lumbago y dolor cervical', 'Tendinitis y esguinces', 'Rehabilitación post operatoria', 'Hombro doloroso', 'Artrosis de rodilla y cadera', 'Vértigo y problemas de equilibrio'],
            'servicios' => ['Evaluación kinesiológica', 'Sesión de kinesiología', 'Masaje descontracturante'],
        ],
        'deportiva' => [
            'nombre' => 'Rehabilitación deportiva',
            'foto' => 20860621,
            'resumen' => 'Vuelve a tu deporte más rápido y con menos riesgo de recaer. Trabajamos con clubes de toda la región.',
            'detalle' => 'Programas de recuperación por etapas, desde el control del dolor hasta el retorno a la cancha, con pruebas de fuerza y equilibrio para decidir cuándo estás listo.',
            'trata' => ['Desgarros y contracturas', 'Lesiones de ligamentos', 'Pubalgia', 'Prevención de lesiones', 'Vendaje neuromuscular', 'Retorno deportivo'],
            'servicios' => ['Evaluación kinesiológica', 'Rehabilitación deportiva'],
        ],
        'nutricion' => [
            'nombre' => 'Nutrición',
            'foto' => 15319021,
            'resumen' => 'Pautas reales para tu día a día, sin dietas imposibles. Medimos tu composición corporal en cada control.',
            'detalle' => 'Atención para bajar o subir de peso, rendimiento deportivo, diabetes, colesterol y alimentación familiar. Recibes una pauta personalizada y seguimiento por WhatsApp entre controles.',
            'trata' => ['Baja de peso', 'Nutrición deportiva', 'Diabetes y resistencia a la insulina', 'Colesterol alto', 'Alimentación vegetariana', 'Nutrición infantil'],
            'servicios' => ['Consulta nutricional', 'Control nutricional'],
        ],
        'psicologia' => [
            'nombre' => 'Psicología',
            'foto' => 23496505,
            'resumen' => 'Un espacio para hablar con calma. Atención para adolescentes y adultos, presencial u online.',
            'detalle' => 'Psicoterapia con enfoque cognitivo-conductual para ansiedad, estrés, ánimo bajo, duelos y dificultades de pareja. La primera sesión sirve para conocerse y definir juntos los objetivos.',
            'trata' => ['Ansiedad y estrés', 'Ánimo bajo', 'Duelo', 'Autoestima', 'Terapia de pareja', 'Orientación a padres'],
            'servicios' => ['Sesión de psicología'],
        ],
    ],

    'pasos' => [
        ['calendario', 'Elige servicio y horario', 'Ve las horas libres de cada profesional en tiempo real.'],
        ['celular', 'Recibe la confirmación', 'Te escribimos por WhatsApp y te recordamos un día antes.'],
        ['check', 'Llega y atiéndete', 'Tu profesional ya tiene tu ficha y tu motivo de consulta.'],
    ],

    'packs' => [
        ['nombre' => 'Pack 5 sesiones de kinesiología', 'precio' => 90000, 'antes' => 100000, 'detalle' => 'Ideal para lesiones leves o mantenimiento.', 'destacado' => false],
        ['nombre' => 'Pack 10 sesiones de kinesiología', 'precio' => 170000, 'antes' => 200000, 'detalle' => 'El plan más usado para lesiones y post operatorios.', 'destacado' => true],
        ['nombre' => 'Plan nutrición 3 meses', 'precio' => 75000, 'antes' => 84000, 'detalle' => 'Consulta inicial, 3 controles y seguimiento por WhatsApp.', 'destacado' => false],
    ],

    'convenios' => [
        ['Fonasa', 'Bono PAD y libre elección para kinesiología.'],
        ['Isapres', 'Emitimos boleta para reembolso en todas las isapres.'],
        ['Seguros complementarios', 'Te entregamos los documentos para reembolsar.'],
        ['Convenios con empresas', 'Descuentos para trabajadores de empresas de la zona.'],
    ],

    'testimonios' => [
        ['Carolina V.', 'Kinesiología', 'Llegué con un lumbago que no me dejaba trabajar. En seis sesiones estaba bien y me enseñaron ejercicios para que no vuelva.'],
        ['Rodrigo S.', 'Rehabilitación deportiva', 'Me operé de ligamentos y volví a jugar fútbol en el plazo que me dijeron. Muy ordenados con el plan.'],
        ['Marcela P.', 'Nutrición', 'Por fin una pauta que puedo cumplir con mi familia. Reservar por la web es rapidísimo.'],
    ],

    'consejos' => [
        ['foto' => 30483062, 'categoria' => 'Kinesiología', 'titulo' => '5 ejercicios para cuidar tu espalda si trabajas sentado', 'minutos' => 4],
        ['foto' => 15319040, 'categoria' => 'Nutrición', 'titulo' => 'Cómo armar colaciones saludables para toda la semana', 'minutos' => 5],
        ['foto' => 3958426, 'categoria' => 'Psicología', 'titulo' => 'Señales de que el estrés te está pasando la cuenta', 'minutos' => 3],
    ],

    'preguntas' => [
        ['¿Necesito orden médica para kinesiología?', 'Para atenderte como particular no. Para usar Fonasa o reembolsar en tu isapre sí, tráela a tu primera sesión.'],
        ['¿Puedo cambiar o anular mi hora?', 'Sí, avísanos por WhatsApp hasta 24 horas antes y la cambiamos sin costo.'],
        ['¿Qué llevo a la primera sesión?', 'Ropa cómoda, tu orden médica si la tienes y exámenes o imágenes recientes.'],
        ['¿Cómo pago?', 'Efectivo, débito, crédito o transferencia. También puedes pagar packs en cuotas.'],
        ['¿Atienden a domicilio?', 'Sí, kinesiología a domicilio dentro de Chillán y Chillán Viejo, con recargo de traslado.'],
    ],

    'galeria' => [29807423, 20860596, 5793917, 4506073],
];
