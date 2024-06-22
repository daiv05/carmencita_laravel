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
        Schema::table('planillas', function (Blueprint $table) {
            $table->double('monto_vacaciones')->nullable();
            $table->double('monto_aguinaldo')->nullable();
            $table->double('monto_bonos')->nullable();
            $table->double('monto_isss_patronal');
            $table->double('monto_afp_patronal');
            $table->double('monto_gravable_cotizable');
            $table->double('monto_pago_empleado');
            $table->double('monto_planilla_unica');
            $table->date('date_emision_boleta')->nullable();
            $table->boolean('pagada')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('planillas', function (Blueprint $table) {
            //
        });
    }
};
