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
        Schema::create("lotes", function(Blueprint $table){
            $table->id("id_lote");
            $table->integer("cantidad_total_unidades");
            $table->integer("cantidad");
            $table->date("fecha_ingreso");
            $table->date("fecha_vencimiento");
            $table->decimal("precio_unitario",10,2);
            $table->decimal("costo_total",10,2);
            $table->string("codigo_barra_producto");
            $table->foreign("codigo_barra_producto")
            ->references("codigo_barra_producto")
            ->on("producto")
            ->onDelete("restrict")
            ->onUpdate("cascade");
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
