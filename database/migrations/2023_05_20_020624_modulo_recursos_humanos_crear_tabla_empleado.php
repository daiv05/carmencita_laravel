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
        Schema::create('empleado', function (Blueprint $table) {
            $table->id('id_empleado');
            $table->BigInteger('id_nacionalidad')->unsigned();
            $table->unsignedBigInteger('id_estado_familiar');
            $table->unsignedBigInteger('id_sexo');
            $table->unsignedBigInteger('id_cargo');

            $table->string('primer_nombre',32);
            $table->string('segundo_nombre',32)->nullable();
            $table->string('primer_apellido',32);
            $table->string('segundo_apellido',32)->nullable();
            $table->string('dui_empleado',9)->unique();
            $table->date('fecha_nacimiento');
            $table->string('telefono',12);
            $table->string('residencia');
            $table->string('domicilio');
            $table->string('profesion_oficio',64);
            $table->boolean('esta_activo');
            $table->timestamps();

            //llaves foraneas
            $table->foreign('id_nacionalidad')->references('id_nacionalidad')->on('nacionalidad')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_estado_familiar')->references('id_estado_familiar')->on('estadofamiliar')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_sexo')->references('id_sexo')->on('sexo')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('id_cargo')->references('id_cargo')->on('cargo')->onDelete('restrict')->onUpdate('restrict');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleado');
    }
};
