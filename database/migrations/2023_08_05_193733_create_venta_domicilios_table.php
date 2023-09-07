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
        Schema::create('ventadomicilio', function (Blueprint $table) {
            $table->id('id_vd');
            $table->timestamps();
            $table->unsignedBigInteger('id_hr')->nullable();
            $table->unsignedBigInteger('id_venta');
            $table->boolean('esta_cancelada');
            $table->boolean('esta_emitida');

            //foraneas
            $table->foreign('id_hr')->references('id_hr')->on('hojaderuta')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_venta')->references('id_venta')->on('venta')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_domicilios');
    }
};
