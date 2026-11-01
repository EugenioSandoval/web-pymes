<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tablas del demo "Centro de Salud": trabajadores, servicios, clientes, agenda y cotizaciones.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // "admin" entra al panel /admin (contactos de la página de venta); "clinica" al panel del demo.
            $table->string('rol')->default('clinica')->after('email');
        });

        Schema::create('profesionales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('especialidad');
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->string('color', 7)->default('#1f9a86');
            $table->text('bio')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->unsignedSmallInteger('duracion_minutos')->default(45);
            $table->unsignedInteger('precio');
            $table->boolean('publico')->default(true);
            $table->timestamps();
        });

        Schema::create('profesional_servicio', function (Blueprint $table) {
            $table->foreignId('profesional_id')->constrained('profesionales')->cascadeOnDelete();
            $table->foreignId('servicio_id')->constrained('servicios')->cascadeOnDelete();
            $table->primary(['profesional_id', 'servicio_id']);
        });

        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('rut', 12)->nullable()->unique();
            $table->string('telefono');
            $table->string('email')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('prevision')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });

        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->cascadeOnDelete();
            $table->foreignId('profesional_id')->constrained('profesionales')->cascadeOnDelete();
            $table->foreignId('servicio_id')->constrained('servicios')->cascadeOnDelete();
            $table->dateTime('inicio');
            $table->dateTime('fin');
            $table->string('estado')->default('pendiente');
            $table->string('origen')->default('panel');
            $table->text('notas')->nullable();
            $table->timestamps();
            $table->index(['profesional_id', 'inicio']);
        });

        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->foreignId('paciente_id')->constrained('pacientes')->cascadeOnDelete();
            $table->date('fecha');
            $table->date('valida_hasta')->nullable();
            $table->string('estado')->default('borrador');
            $table->unsignedTinyInteger('descuento_porcentaje')->default(0);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });

        Schema::create('cotizacion_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_id')->constrained('cotizaciones')->cascadeOnDelete();
            $table->foreignId('servicio_id')->nullable()->constrained('servicios')->nullOnDelete();
            $table->string('descripcion');
            $table->unsignedSmallInteger('cantidad')->default(1);
            $table->unsignedInteger('precio_unitario');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizacion_items');
        Schema::dropIfExists('cotizaciones');
        Schema::dropIfExists('citas');
        Schema::dropIfExists('pacientes');
        Schema::dropIfExists('profesional_servicio');
        Schema::dropIfExists('servicios');
        Schema::dropIfExists('profesionales');
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn('rol'));
    }
};
