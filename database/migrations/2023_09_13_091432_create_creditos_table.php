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
        Schema::create('creditos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_credito');
            $table->date('fecha_limite_pago');
            $table->float('monto_credito');
            $table->string('detalle_credito');
            $table->unsignedBigInteger('id_proveedor');
            $table->float('pendiente');
            $table->foreign('id_proveedor')->references('id')->on('proveedors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creditos');
    }
};
