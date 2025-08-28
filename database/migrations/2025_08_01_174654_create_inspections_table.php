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


            $table->boolean('cuchara_checked')->default(false);
            $table->boolean('llantas_checked')->default(false);
            $table->boolean('articulacion_checked')->default(false);
            $table->boolean('cilindro_checked')->default(false);
            $table->boolean('botellones_checked')->default(false);
            $table->boolean('zbar_checked')->default(false);
            $table->boolean('dogbone_checked')->default(false);
            $table->boolean('brazo_checked')->default(false);
            $table->boolean('tablero_checked')->default(false);
            $table->boolean('extintores_checked')->default(false);
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
