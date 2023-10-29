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
        Schema::create('creditofiscaldomicilio', function (Blueprint $table) {
            $table->id('id_cfd');
            $table->timestamps();
            $table->unsignedBigInteger('id_hr')->nullable();
            $table->unsignedBigInteger('id_creditofiscal');
            $table->boolean('esta_cancelado');
            $table->boolean('esta_emitido');

            //foraneas
            $table->foreign('id_creditofiscal')->references('id_creditofiscal')->on('creditofiscal')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_hr')->references('id_hr')->on('hojaderuta')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credito_fiscal_domicilios');
    }

    
};
