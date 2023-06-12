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
        Schema::create('Municipio', function (Blueprint $table) {
            $table->id('id_municipio');
            $table->string('nombre_municipio',50);
            $table->unsignedBigInteger('id_departamento');

            $table->foreign('id_departamento')
                ->references('id_departamento')
                ->on('Departamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Municipio');
    }
};
