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
        Schema::create('producto', function (Blueprint $table) {
            $table->string('codigo_barra_producto', 13)->primary();
            $table->string('nombre_producto', 50);
            $table->integer('cantidad_producto_disponible');
            $table->integer('cantidad_producto_fisico');
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
        Schema::dropIfExists('producto');
    }
};
