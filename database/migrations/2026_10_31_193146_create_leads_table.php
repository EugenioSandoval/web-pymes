<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('negocio')->nullable();
            $table->string('rubro')->nullable();
            $table->string('paquete')->nullable();
            $table->string('telefono');
            $table->string('email')->nullable();
            $table->text('mensaje')->nullable();
            $table->boolean('contactado')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
