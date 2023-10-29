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
        Schema::create('hojaderuta', function (Blueprint $table) {
            $table->id('id_hr');
            $table->timestamps();
            $table->unsignedBigInteger('id_empleado');
            $table->date('fecha_entrega');
            $table->decimal('total',8,2);
            $table->boolean('esta_entregado')->default(false);

            //foraneas
            $table->foreign('id_empleado')->references('id_empleado')->on('empleado')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoja_de_rutas');
    }
};
