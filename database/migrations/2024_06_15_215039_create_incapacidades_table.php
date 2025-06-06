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
        Schema::create('incapacidades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_empleado');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->date('fecha_solicitud');
            $table->string('comprobante')->nullable();
            $table->text('detalle')->nullable();
            $table->unsignedBigInteger('id_estado');
            $table->timestamps();

            $table->foreign('id_empleado')->references('id_empleado')->on('empleado')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_estado')->references('id')->on('estados')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incapacidades');
    }
};
