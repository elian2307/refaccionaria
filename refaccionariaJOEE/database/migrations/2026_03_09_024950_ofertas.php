<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subasta_id')->references('id')->on('subastas')->onDelete('cascade');
            $table->foreignId('proveedor_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('precio_ofertado', 8, 2);
            $table->integer('dias_entrega')->unsigned();
            $table->enum('condicion_pieza', ['nueva', 'usada', 'reconstruida'])->default('nueva');
            $table->integer('meses_garantia')->unsigned()->default(0);
            $table->boolean('es_aceptada')->default(false);
            $table->timestamp('fecha_oferta')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ofertas');
    }
};
