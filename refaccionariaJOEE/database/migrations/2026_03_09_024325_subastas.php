<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subastas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('marca_vehiculo');
            $table->string('modelo_vehiculo');
            $table->string('anio_vehiculo');
            $table->string('nombre_refaccion');
            $table->string('descripcion_problema');
            $table->enum('urgencia', ['baja', 'media', 'alta'])->default('media');
            $table->enum('estado', ['abierta', 'cerrada', 'cancelada', 'finalizada'])->default('abierta');
            $table->date('fecha_expiracion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subastas');
    }
};
