<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EquipmentType>
 */
class EquipmentTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => '',
            'description' => ''
        ];
    }

    /**
     * Indicate that the equipment type is a Camión.
     */
//    public function camion(): static
//    {
//        return $this->state(fn (array $attributes) => [
//            'name' => 'Camión',
//            'description' => 'Vehículo de transporte pesado para el traslado de materiales extraídos.'
//        ]);
//    }

    /**
     * Indicate that the equipment type is a Perforadora.
     */
    public function perforadora(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Perforadora',
            'description' => 'Equipo especializado en perforación de barrenos para voladuras y exploración.'
        ]);
    }

    /**
     * Indicate that the equipment type is 'camion .
     */
    public function acarreo(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'De Acarreo',
            'description' => 'Equipo pesado utilizado para excavación y movimiento de tierra en operaciones mineras.'
        ]);
    }
}
