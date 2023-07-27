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
        //
        Schema::create('cargo',function(Blueprint $table){
            $table->id('id_cargo');
            $table->string('nombre_cargo',50);
            $table->decimal('salario_cargo',10,2);
            $table->string('descripcion_cargo',100);
            $table->bigInteger('id_jornada_laboral_diaria')->unsigned();
            $table->foreign('id_jornada_laboral_diaria')->references('id_jornada_laboral_diaria')->on('jornadalaboraldiaria')
            ->onUpdate('cascade')
            ->onDelete('restrict');
            /*$table->foreignId('id_jornadad_laboral_diaria')
            ->constraint('JornadaLaboralDiaria')
            ->onUpdate('cascade')
            ->onDelete('restrict');*/
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('cargo');
    }
};
