<?php

use App\Models\EquipmentType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();

            // Relación con tipo de equipo
            $table->foreignIdFor(EquipmentType::class)
                ->constrained()
                ->onDelete('restrict');

            // Información básica
            $table->string('code', 20)->unique();
            $table->string('brand', 100);
            $table->string('model', 100);
            $table->year('year');

            // Estado y ubicación
            $table->enum('status', ['operativa', 'mantenimiento', 'inactiva'])
                ->default('operativa');
            $table->enum('location', ['Interior mina', 'Exterior mina', 'Área de Mantenimiento', 'Apartada de la Empresa'])
                ->nullable();


            $table->enum('fuel_type', ['diesel', 'gasolina', 'eléctrico'])
                ->nullable()
                ->comment('Tipo de combustible');
            $table->decimal('fuel_capacity', 8, 2)->nullable()->comment('Capacidad de combustible en litros');

            // Mantenimiento
            $table->date('last_maintenance')->nullable();
            $table->date('next_maintenance')->nullable();

            //Trabajo
            $table->decimal('engine_hours', 10, 1)->nullable();
            $table->decimal('percussion_hours', 10, 1)->nullable();
            $table->decimal('position_hours', 10, 1)->nullable();

            //Imagen del equipo
            $table->string('equipment_img')->nullable();

            //Manuales del equipo
            $table->string('manual_pdf')->nullable();


            $table->timestamps();

            // Índices para optimizar consultas
            $table->index(['status', 'equipment_type_id']);
            $table->index('location');
            $table->index('fuel_type'); // Para filtrar por tipo de combustible
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
