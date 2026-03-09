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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subasta_id')->references('id')->on('subastas');
            $table->foreignId('oferta_id')->references('id')->on('ofertas');
            $table->decimal('monto_total', 8, 2);
            $table->decimal('monto_comision', 8, 2)->comment('Comisión del 5% al 25% para la plataforma');
            $table->enum('estado_pago', ['pendiente', 'pagado', 'reembolsado'])->default('pendiente');
            $table->enum('estado_envio', ['pendiente', 'enviado', 'entregado'])->default('pendiente');
            $table->string('numero_rastreo')->nullable();
            $table->date('fecha_pedido')->default(DB::raw('CURRENT_DATE'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
