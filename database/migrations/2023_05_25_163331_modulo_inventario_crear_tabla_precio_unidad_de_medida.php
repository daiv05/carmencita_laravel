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
        Schema::create('preciounidaddemedida', function (Blueprint $table) {
            $table->increments('id_precio_unidad_de_medida');
            $table->string('codigo_barra_producto', 13);
            $table->unsignedInteger('id_unidad_de_medida');
            $table->integer('cantidad_producto');
            $table->decimal('precio_unidad_medida_producto');
            //$table->primary(['codigo_barra_producto', 'id_unidad_de_medida']);
            
            $table->foreign('codigo_barra_producto')->references('codigo_barra_producto')
            ->on('producto')
            ->onUpdate('cascade')
            ->onDelete('restrict');

            $table->foreign('id_unidad_de_medida')->references('id_unidad_de_medida')
            ->on('unidaddemedida')
            ->onUpdate('cascade')
            ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preciounidaddemedida');
    }
};
