<?php

namespace Tests\Feature;

use App\Filament\Clinica\Resources\Citas\Pages\CreateCita;
use App\Models\Cita;
use App\Models\Servicio;
use App\Models\User;
use Database\Seeders\DemoClinicaSeeder;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Tests\TestCase;

class DemoClinicaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DemoClinicaSeeder::class);
    }

    /** Primer día hábil desde mañana, para no depender del día en que se corren las pruebas. */
    private function proximoDiaHabil(): Carbon
    {
        $dia = today()->addDay();
        while ($dia->isWeekend()) {
            $dia->addDay();
        }

        return $dia;
    }

    public function test_paginas_publicas_del_demo_cargan(): void
    {
        $this->get('/demo')->assertOk()->assertSee('Centro Kine Ñuble');
        $this->get('/demo/reservar')->assertOk();
        $this->get('/demo/presupuesto')->assertOk();
        foreach (array_keys(config('demo.especialidades')) as $slug) {
            $this->get("/demo/especialidades/$slug")->assertOk();
        }
        $this->get('/demo/especialidades/no-existe')->assertNotFound();
        $this->get('/demo/equipo/'.\App\Models\Profesional::first()->id)->assertOk();
    }

    public function test_presupuesto_web_crea_cotizacion_en_borrador(): void
    {
        $servicio = Servicio::where('nombre', 'Sesión de kinesiología')->first();

        $this->post('/demo/presupuesto', [
            'nombre' => 'Pedro Web', 'telefono' => '+56 9 1111 2222',
            'servicios' => [$servicio->id => ['activo' => 1, 'cantidad' => 10]],
        ])->assertRedirect('/demo/presupuesto')->assertSessionHas('cotizacion');

        $cotizacion = \App\Models\Cotizacion::latest('id')->first();
        $this->assertSame('borrador', $cotizacion->estado);
        $this->assertSame('Pedro Web', $cotizacion->paciente->nombre);
        $this->assertSame(10 * $servicio->precio * 0.9, (float) $cotizacion->total());
    }

    public function test_reserva_web_crea_cita_pendiente_y_no_permite_doble_reserva(): void
    {
        $servicio = Servicio::where('nombre', 'Control nutricional')->first();
        $profesional = $servicio->profesionales()->first();
        $dia = $this->proximoDiaHabil();
        Cita::where('profesional_id', $profesional->id)->whereDate('inicio', $dia)->delete();
        $inicio = $dia->copy()->setTime(9, 0);

        $datos = [
            'servicio_id' => $servicio->id,
            'profesional_id' => $profesional->id,
            'inicio' => $inicio->format('Y-m-d H:i'),
            'nombre' => 'Paciente Web',
            'telefono' => '+56 9 1234 5678',
        ];

        $this->post('/demo/reservar', $datos)->assertRedirect();
        $this->assertDatabaseHas('citas', ['profesional_id' => $profesional->id, 'inicio' => $inicio, 'estado' => 'pendiente', 'origen' => 'web']);

        $this->post('/demo/reservar', ['nombre' => 'Otra persona', 'telefono' => '+56 9 9999 0000'] + $datos)
            ->assertSessionHasErrors('inicio');
        $this->assertSame(1, Cita::where('profesional_id', $profesional->id)->where('inicio', $inicio)->count());
    }

    public function test_el_panel_no_permite_dos_citas_del_mismo_profesional_a_la_misma_hora(): void
    {
        $this->actingAs(User::where('email', 'demo@centrokine.cl')->first());
        Filament::setCurrentPanel(Filament::getPanel('clinica'));

        $existente = Cita::activas()->where('inicio', '>', now())->first();

        Livewire::test(CreateCita::class)
            ->fillForm([
                'paciente_id' => $existente->paciente_id,
                'servicio_id' => $existente->servicio_id,
                'profesional_id' => $existente->profesional_id,
                'inicio' => $existente->inicio->format('Y-m-d H:i:s'),
                'estado' => 'confirmada',
            ])
            ->call('create')
            ->assertHasFormErrors(['inicio']);
    }

    public function test_la_cotizacion_imprimible_requiere_sesion(): void
    {
        $this->get('/demo/panel/cotizaciones/1/imprimir')->assertRedirect('/demo/panel/login');

        $this->actingAs(User::where('email', 'demo@centrokine.cl')->first())
            ->get('/demo/panel/cotizaciones/1/imprimir')
            ->assertOk()
            ->assertSee('COT-0001');
    }

    public function test_paginas_del_panel_cargan(): void
    {
        $this->actingAs(User::where('email', 'demo@centrokine.cl')->first());

        foreach (['', '/agenda', '/citas', '/citas/create', '/pacientes', '/cotizaciones', '/cotizaciones/create', '/profesionales', '/servicios'] as $ruta) {
            $this->get('/demo/panel'.$ruta)->assertOk();
        }
    }
}
