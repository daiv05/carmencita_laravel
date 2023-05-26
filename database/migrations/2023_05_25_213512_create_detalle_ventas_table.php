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
            $table->id('id_venta');
            $table->string('codigo_barra_producto', 10);
            $table->decimal('subtotal_detalle_venta', 8, 2);

            $table->primary(['id_venta', 'codigo_barra_producto']);
            $table->foreign('id_venta')
                ->references('id_venta')
                ->on('Venta')
                ->onDelete('cascade');
            $table->foreign('codigo_barra_producto')
                ->references('codigo_barra_producto')
                ->on('Producto')
                ->onDelete('restrict');;
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
