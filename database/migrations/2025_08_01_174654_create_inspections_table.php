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
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->datetime('inspection_date');
            $table->string('status')->default('completada');
            $table->text('observations')->nullable();




            // SECCIÓN 1: REVISIÓN ANTES DE ARRANCAR EL MOTOR
            $table->boolean('nivel_combustible_checked')->default(false);
            $table->boolean('nivel_aceite_motor_checked')->default(false);
            $table->boolean('nivel_refrigerante_checked')->default(false);
            $table->boolean('nivel_aceite_hidraulico_checked')->default(false);
            $table->boolean('purgar_agua_filtro_checked')->default(false);
            $table->boolean('polvo_valvula_vacio_checked')->default(false);
            $table->boolean('correas_alternador_checked')->default(false);

            // SECCIÓN 2: REVISIÓN DESPUÉS DE ARRANCAR EL MOTOR
            $table->boolean('presencia_fugas_checked')->default(false);
            $table->boolean('switch_parqueo_checked')->default(false);
            $table->boolean('freno_servicio_checked')->default(false);
            $table->boolean('pedales_freno_checked')->default(false);
            $table->boolean('bocina_claxon_checked')->default(false);
            $table->boolean('luces_delanteras_checked')->default(false);
            $table->boolean('paradas_emergencia_checked')->default(false);
            $table->boolean('carrete_manguera_checked')->default(false);

            // SECCIÓN 3: INSPECCIÓN GENERAL
            $table->boolean('cable_alimentacion_checked')->default(false);
            $table->boolean('carrete_posicionamiento_checked')->default(false);
            $table->boolean('valvula_antiparalelismo_checked')->default(false);
            $table->boolean('protectores_cilindro_checked')->default(false);
            $table->boolean('mangueras_hidraulicas_checked')->default(false);
            $table->boolean('viga_avance_checked')->default(false);
            $table->boolean('cilindro_avance_checked')->default(false);

            // SECCIÓN 4: TEMA NO NEGOCIABLES
            $table->boolean('freno_servicio_negociable_checked')->default(false);
            $table->boolean('freno_parqueo_checked')->default(false);
            $table->boolean('controles_perforacion_checked')->default(false);
            $table->boolean('bloqueo_energizacion_checked')->default(false);
            $table->boolean('paradas_emergencia_final_checked')->default(false);


            $table->boolean('epp_complete')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
