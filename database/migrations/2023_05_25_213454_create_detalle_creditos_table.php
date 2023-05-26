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
            $table->string('codigo_barra_producto');
            $table->integer('id_creditofiscal');
            $table->integer('cantidad_producto_credito');
            $table->decimal('subtotal_detalle_credito', 8, 2);

            $table->foreign('codigo_barra_producto')->references('codigo_barra_producto')->on('Producto')
                ->onDelete('cascade')
                ->onUpate('cascade');
            $table->foreign('id_creditofiscal')
                ->references('id_creditofiscal')
                ->on('creditofiscal')
                ->onDelete('cascade')
                ->onUpate('cascade');
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
