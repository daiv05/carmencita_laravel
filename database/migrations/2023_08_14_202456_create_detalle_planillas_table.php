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
        Schema::create('detalle_planillas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('id_empleado');
            $table->unsignedBigInteger('id_planilla');
            $table->decimal('monto_isss',10,2);
            $table->decimal('monto_afp',10,2);
            $table->decimal('monto_pago',10,2);
            $table->decimal('base',10,2);
            $table->integer('dias_laborados');

            $table->foreign('id_empleado')->references('id_empleado')->on('empleado')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_planilla')->references('id')->on('planillas')->onDelete('restrict')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_planillas');
    }
};
