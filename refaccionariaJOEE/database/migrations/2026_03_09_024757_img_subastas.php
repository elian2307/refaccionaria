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
        Schema::create('img_subastas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subasta_id')->references('id')->on('subastas')->onDelete('cascade');
            $table->string('url')->default('default.png');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('img_subastas');
    }
};
