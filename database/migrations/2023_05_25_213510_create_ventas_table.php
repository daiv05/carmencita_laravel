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
        Schema::create('venta', function (Blueprint $table) {
            $table->id('id_venta');
            $table->date('fecha_venta');
            $table->decimal('total_venta', 8, 4);
            $table->decimal('total_iva', 8, 4);
            $table->string('nombre_cliente_venta', 30)->nullable();
            $table->boolean('estado_venta')->default(true);
            $table->boolean('domicilio')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta');
    }
};
