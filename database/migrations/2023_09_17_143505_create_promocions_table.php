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
        Schema::create('promocions', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_barra_producto');
            $table->foreign('codigo_barra_producto')->references('codigo_barra_producto')->on('producto')->onDelete('cascade');
            $table->date('fecha_inicio_oferta');
            $table->date('fecha_fin_oferta');
            $table->float('precio_oferta');
            $table->string('nombre_oferta');
            $table->integer('cantidad_producto');
            $table->float('monto_rebaja')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promocions');
    }
};
