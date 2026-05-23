<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            if (!Schema::hasColumn('pedidos', 'paypal_order_id')) {
                $table->string('paypal_order_id')->nullable()->after('fecha_pedido');
            }

            if (!Schema::hasColumn('pedidos', 'paypal_capture_id')) {
                $table->string('paypal_capture_id')->nullable()->after('paypal_order_id');
            }

            if (!Schema::hasColumn('pedidos', 'paypal_status')) {
                $table->string('paypal_status')->nullable()->after('paypal_capture_id');
            }

            if (!Schema::hasColumn('pedidos', 'paypal_payer_email')) {
                $table->string('paypal_payer_email')->nullable()->after('paypal_status');
            }

            if (!Schema::hasColumn('pedidos', 'fecha_pago')) {
                $table->timestamp('fecha_pago')->nullable()->after('paypal_payer_email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $columnas = [
                'paypal_order_id',
                'paypal_capture_id',
                'paypal_status',
                'paypal_payer_email',
                'fecha_pago',
            ];

            foreach ($columnas as $columna) {
                if (Schema::hasColumn('pedidos', $columna)) {
                    $table->dropColumn($columna);
                }
            }
        });
    }
};