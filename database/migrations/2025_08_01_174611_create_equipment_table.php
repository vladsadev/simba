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
            $table->enum('status', ['active', 'maintenance', 'inactive', 'retired'])
                ->default('active');
            $table->string('location', 150)->nullable();

            //  ESPECIFICACIONES TÉCNICAS (nuevos campos) Simba2
            $table->decimal('length', 5, 2)->nullable()->comment('Largo en metros'); // 12.5m
            $table->decimal('width', 5, 2)->nullable()->comment('Ancho en metros');  // 12.5m
            $table->decimal('height', 5, 2)->nullable()->comment('Alto en metros');  // 12.5m
            $table->decimal('weight', 8, 2)->nullable()->comment('Peso en toneladas'); // 45.0t

            // Combustible como ENUM (más controlado)
            $table->enum('fuel_type', ['diesel', 'gasolina', 'electrico', 'hibrido'])
                ->nullable()
                ->comment('Tipo de combustible');

            // Capacidades adicionales para equipos mineros
            $table->decimal('engine_power', 8, 2)->nullable()->comment('Potencia del motor en HP');
            $table->decimal('fuel_capacity', 8, 2)->nullable()->comment('Capacidad de combustible en litros');
            $table->decimal('bucket_capacity', 8, 2)->nullable()->comment('Capacidad de cuchara en m³');
            $table->decimal('max_load', 8, 2)->nullable()->comment('Carga máxima en toneladas');

            // Información operacional
            $table->date('last_maintenance')->nullable();
            $table->date('next_maintenance')->nullable();
            $table->text('notes')->nullable();

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
