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
        Schema::create('Domicilio', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_domicilio');
            $table->unsignedBigInteger('id_empleado');
            $table->timestamps();

            $table->foreign('id_empleado')->references('id_empleado')->on('Empleado')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Domicilio');
    }
};
