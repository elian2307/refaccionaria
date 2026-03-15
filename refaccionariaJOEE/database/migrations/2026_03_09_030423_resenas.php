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
        Schema::create('resenas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->references('id')->on('pedidos');
            $table->foreignId('autor_id')->references('id')->on('users');
            $table->foreignId('receptor_id')->references('id')->on('users');
            $table->integer('calificacion')->comment('Calificación del 1 al 5');
            $table->text('comentario')->nullable();
            $table->timestamp('fecha_resena')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resenas');
    }
};
