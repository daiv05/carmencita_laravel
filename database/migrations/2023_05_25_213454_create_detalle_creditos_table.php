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
        Schema::create('DetalleCredito', function (Blueprint $table) {
            $table->id('id_detalle_credito');
            $table->string('codigo_barra_producto',15);
            $table->unsignedBigInteger('id_creditofiscal');
            $table->integer('cantidad_producto_credito');
            $table->decimal('subtotal_detalle_credito', 8, 2);

            $table->foreign('codigo_barra_producto')
                ->references('codigo_barra_producto')
                ->on('Producto');
            $table->foreign('id_creditofiscal')
                ->references('id_creditofiscal')
                ->on('CreditoFiscal')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DetalleCredito');
    }
};
