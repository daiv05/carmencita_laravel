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
        Schema::create('Venta', function (Blueprint $table) {
            $table->id('id_venta');
            $table->date('fecha_venta');
            $table->decimal('total_venta', 8, 2);
            $table->decimal('total_iva', 8, 2);
            $table->string('nombre_cliente_venta', 30)->nullable();
            $table->boolean('estado_venta')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Venta');
    }
};
