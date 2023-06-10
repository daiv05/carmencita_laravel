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
        Schema::create('Producto', function (Blueprint $table) {
<<<<<<< HEAD
            $table->string('codigo_barra_producto', 13)->primary();
=======
            $table->string('codigo_barra_producto', 15)->primary();
>>>>>>> f8f1208bfb4227ce4d2d3418cd60031cfd28efa6
            $table->string('nombre_producto', 50);
            $table->integer('cantidad_producto_disponible');
            $table->decimal('precio_unitario');
            $table->boolean('esta_disponible');
            $table->string('foto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Producto');
    }
};
