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
        Schema::create('DetalleVenta', function (Blueprint $table) {
            $table->id('id_detalle_venta');
            $table->unsignedBigInteger('id_venta');
            $table->string('codigo_barra_producto', 10);
            $table->integer('cantidad_producto');
            $table->decimal('subtotal_detalle_venta', 8, 2);

            $table->foreign('id_venta')
                ->references('id_venta')
                ->on('Venta');
            $table->foreign('codigo_barra_producto')
                ->references('codigo_barra_producto')
                ->on('Producto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DetalleVenta');
    }
};
