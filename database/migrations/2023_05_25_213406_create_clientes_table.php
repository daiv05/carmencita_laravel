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
        Schema::create('cliente', function (Blueprint $table) {
            $table->id('id_cliente');
            $table->string('distintivo_cliente',50)->unique();
            $table->string('nombre_cliente',50);
            $table->string('direccion_cliente',50);
            $table->string('dui_cliente',10)->nullable();;
            $table->string('nit_cliente',20)->nullable();;
            $table->string('nrc_cliente',20);
            $table->boolean('estado_cliente')->default(true);
            $table->unsignedBigInteger('id_municipio');

            $table->foreign('id_municipio')
                ->references('id_municipio')
                ->on('municipio')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
};
