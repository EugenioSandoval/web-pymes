<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaginaVentaTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_pagina_de_venta_carga(): void
    {
        $this->get('/')->assertOk()->assertSee('Planes');
    }

    public function test_el_formulario_guarda_el_contacto(): void
    {
        $this->post('/contacto', ['nombre' => 'Ana', 'telefono' => '+56911112222', 'paquete' => 'Web informativa'])
            ->assertRedirect();

        $this->assertDatabaseHas('leads', ['nombre' => 'Ana', 'paquete' => 'Web informativa']);
    }

    public function test_el_formulario_exige_nombre_y_telefono(): void
    {
        $this->post('/contacto', [])->assertSessionHasErrors(['nombre', 'telefono']);
        $this->assertSame(0, Lead::count());
    }

    public function test_solo_el_admin_entra_al_panel_de_contactos(): void
    {
        $demo = User::factory()->create(['rol' => 'clinica']);
        $admin = User::factory()->create(['rol' => 'admin']);

        $this->actingAs($demo)->get('/admin')->assertForbidden();
        $this->actingAs($admin)->get('/admin')->assertOk();
    }
}
