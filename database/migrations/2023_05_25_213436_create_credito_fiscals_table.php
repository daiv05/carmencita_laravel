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
        Schema::create('creditofiscal', function (Blueprint $table) {
            $table->id('id_creditofiscal');
            $table->bigInteger('id_cliente')->unsigned();
            $table->date('fecha_credito');
            $table->decimal('total_credito', 8, 4);
            $table->decimal('total_iva_credito', 8, 4);
            $table->boolean('estado_credito')->default(true);
            $table->boolean('domicilio')->default(false);

            $table->foreign('id_cliente')
                ->references('id_cliente')
                ->on('cliente')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creditofiscal');
    }
    
};
