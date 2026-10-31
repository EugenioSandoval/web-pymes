<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\Cotizacion;
use App\Models\Paciente;
use App\Models\Profesional;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Datos ficticios del demo "Centro Kine Ñuble".
 * No usa Faker para que funcione también en el hosting (sin dependencias de desarrollo).
 */
class DemoClinicaSeeder extends Seeder
{
    public function run(): void
    {
        mt_srand(2026);

        User::updateOrCreate(
            ['email' => 'demo@centrokine.cl'],
            ['name' => 'Recepción Demo', 'rol' => 'clinica', 'password' => 'demo1234'],
        );

        $servicios = collect([
            ['Evaluación kinesiológica', 'Evaluación inicial, diagnóstico funcional y plan de tratamiento.', 45, 25000],
            ['Sesión de kinesiología', 'Tratamiento de lesiones musculares, articulares y de columna.', 45, 20000],
            ['Rehabilitación deportiva', 'Recuperación de lesiones y vuelta segura a tu deporte.', 60, 28000],
            ['Masaje descontracturante', 'Alivio de tensión muscular de espalda, cuello y hombros.', 45, 22000],
            ['Consulta nutricional', 'Evaluación, medición de composición corporal y pauta alimentaria.', 45, 30000],
            ['Control nutricional', 'Seguimiento de tu plan y ajustes de la pauta.', 30, 18000],
            ['Sesión de psicología', 'Atención para adultos y adolescentes.', 60, 35000],
        ])->mapWithKeys(fn ($s) => [$s[0] => Servicio::create([
            'nombre' => $s[0], 'descripcion' => $s[1], 'duracion_minutos' => $s[2], 'precio' => $s[3],
        ])]);

        $profesionales = collect([
            ['Daniela Fuentes', 'Kinesióloga', '#0d9488', 'Especialista en columna y rehabilitación musculoesquelética. 8 años de experiencia.', ['Evaluación kinesiológica', 'Sesión de kinesiología', 'Masaje descontracturante']],
            ['Matías Contreras', 'Kinesiólogo deportivo', '#2563eb', 'Trabaja con clubes deportivos de Ñuble en prevención y recuperación de lesiones.', ['Evaluación kinesiológica', 'Sesión de kinesiología', 'Rehabilitación deportiva']],
            ['Javiera Muñoz', 'Nutricionista', '#d97706', 'Nutrición clínica y deportiva, con enfoque en hábitos sostenibles.', ['Consulta nutricional', 'Control nutricional']],
            ['Ignacio Rojas', 'Psicólogo', '#9333ea', 'Psicoterapia para adultos y adolescentes, enfoque cognitivo-conductual.', ['Sesión de psicología']],
        ])->map(function ($p) use ($servicios) {
            $profesional = Profesional::create([
                'nombre' => $p[0], 'especialidad' => $p[1], 'color' => $p[2], 'bio' => $p[3],
                'email' => strtolower(explode(' ', $p[0])[0]).'@centrokine.cl',
                'telefono' => '+56 9 '.mt_rand(5000, 9999).' '.mt_rand(1000, 9999),
            ]);
            $profesional->servicios()->attach($servicios->only($p[4])->pluck('id'));

            return $profesional;
        });

        $nombres = ['Camila', 'Jorge', 'Ana', 'Felipe', 'Valentina', 'Sebastián', 'Catalina', 'Diego', 'Fernanda', 'Tomás', 'Constanza', 'Nicolás', 'Francisca', 'Benjamín', 'Antonia', 'Cristóbal', 'Paula', 'Rodrigo', 'Macarena', 'Gonzalo'];
        $apellidos = ['González', 'Muñoz', 'Rojas', 'Díaz', 'Pérez', 'Soto', 'Contreras', 'Silva', 'Martínez', 'Sepúlveda', 'Morales', 'Rodríguez', 'López', 'Fuentes', 'Hernández', 'Torres', 'Araya', 'Flores', 'Espinoza', 'Valenzuela'];
        $previsiones = ['Fonasa', 'Fonasa', 'Fonasa', 'Isapre', 'Isapre', 'Particular'];

        $pacientes = collect(range(1, 45))->map(function ($i) use ($nombres, $apellidos, $previsiones) {
            $nombre = $nombres[array_rand($nombres)].' '.$apellidos[array_rand($apellidos)].' '.$apellidos[array_rand($apellidos)];

            return Paciente::create([
                'nombre' => $nombre,
                'rut' => self::rut(mt_rand(8_000_000, 24_000_000)),
                'telefono' => '+56 9 '.mt_rand(5000, 9999).' '.mt_rand(1000, 9999),
                'email' => self::correo($nombre),
                'fecha_nacimiento' => Carbon::create(mt_rand(1955, 2010), mt_rand(1, 12), mt_rand(1, 28)),
                'prevision' => $previsiones[array_rand($previsiones)],
            ]);
        });

        // Citas desde dos semanas atrás hasta dos semanas adelante, de lunes a viernes.
        $desde = now()->startOfWeek()->subWeeks(2);
        $hasta = now()->startOfWeek()->addWeeks(2)->endOfWeek();
        for ($dia = $desde->copy(); $dia->lte($hasta); $dia->addDay()) {
            if ($dia->isWeekend()) {
                continue;
            }
            foreach ($profesionales as $profesional) {
                $libre = $dia->copy()->setTime(9, 0);
                $serviciosProfesional = $profesional->servicios;
                while ($libre->hour < 18) {
                    $libre->addMinutes([0, 15, 30, 45, 60, 90][mt_rand(0, 5)]);
                    if ($libre->hour >= 18 || $libre->hour === 13) {
                        $libre->addMinutes(60);

                        continue;
                    }
                    $servicio = $serviciosProfesional->random();
                    $inicio = $libre->copy();
                    $pasada = $inicio->isPast();
                    $estado = $pasada
                        ? (mt_rand(1, 10) === 1 ? 'cancelada' : 'atendida')
                        : (mt_rand(1, 5) === 1 ? 'pendiente' : 'confirmada');

                    $cita = Cita::create([
                        'paciente_id' => $pacientes->random()->id,
                        'profesional_id' => $profesional->id,
                        'servicio_id' => $servicio->id,
                        'inicio' => $inicio,
                        'estado' => $estado,
                        'origen' => mt_rand(1, 5) === 1 ? 'web' : 'panel',
                    ]);
                    // La reserva se hizo algunos días antes de la cita.
                    $reservada = $inicio->copy()->subDays(mt_rand(1, 10))->setTime(mt_rand(8, 21), mt_rand(0, 59));
                    $cita->timestamps = false;
                    $cita->forceFill(['created_at' => $reservada->min(now()), 'updated_at' => $reservada->min(now())])->saveQuietly();
                    $libre->addMinutes((int) (ceil($servicio->duracion_minutos / 15) * 15));
                }
            }
        }

        // Cotizaciones de ejemplo.
        $planes = [
            ['Plan rehabilitación rodilla', [['Evaluación kinesiológica', 1], ['Sesión de kinesiología', 10]], 10, 'aceptada'],
            ['Plan deportivo', [['Evaluación kinesiológica', 1], ['Rehabilitación deportiva', 8]], 5, 'enviada'],
            ['Plan nutrición 3 meses', [['Consulta nutricional', 1], ['Control nutricional', 5]], 0, 'enviada'],
            ['Plan columna', [['Sesión de kinesiología', 6], ['Masaje descontracturante', 4]], 10, 'borrador'],
            ['Psicoterapia', [['Sesión de psicología', 8]], 0, 'rechazada'],
            ['Convenio empresa', [['Masaje descontracturante', 20]], 15, 'enviada'],
        ];
        foreach ($planes as $i => [$titulo, $lineas, $descuento, $estado]) {
            $fecha = today()->subDays(25 - $i * 4);
            $cotizacion = Cotizacion::create([
                'paciente_id' => $pacientes->random()->id,
                'fecha' => $fecha,
                'valida_hasta' => $fecha->copy()->addDays(30),
                'estado' => $estado,
                'descuento_porcentaje' => $descuento,
                'observaciones' => $titulo.'. Sesiones a coordinar según disponibilidad.',
            ]);
            foreach ($lineas as [$nombreServicio, $cantidad]) {
                $servicio = $servicios[$nombreServicio];
                $cotizacion->items()->create([
                    'servicio_id' => $servicio->id,
                    'descripcion' => $servicio->nombre,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $servicio->precio,
                ]);
            }
        }
    }

    /** RUT chileno con dígito verificador válido, ej: 12.345.678-5 */
    public static function rut(int $numero): string
    {
        $suma = 0;
        $factor = 2;
        foreach (array_reverse(str_split((string) $numero)) as $d) {
            $suma += $d * $factor;
            $factor = $factor === 7 ? 2 : $factor + 1;
        }
        $dv = 11 - ($suma % 11);
        $dv = $dv === 11 ? '0' : ($dv === 10 ? 'K' : (string) $dv);

        return number_format($numero, 0, ',', '.').'-'.$dv;
    }

    private static function correo(string $nombre): string
    {
        $limpio = strtolower(strtr($nombre, ['á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ñ' => 'n', 'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u', 'Ñ' => 'n']));
        $partes = explode(' ', $limpio);

        return $partes[0].'.'.$partes[1].mt_rand(1, 99).'@correo.cl';
    }
}
