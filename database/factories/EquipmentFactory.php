<?php

namespace Database\Factories;

use App\Models\EquipmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'equipment_type_id' => EquipmentType::factory(),
            'code' => $this->generateEquipmentCode(),
            'brand' => $this->faker->randomElement(['Caterpillar', 'Epiroc', 'Komatsu', 'Liebherr','Epiroc','Volvo']),
            'model' => $this->faker->randomElement(['Simba S7', 'XT200', 'JJ300', 'R9800', 'PC8000']),
            'year' => $this->faker->numberBetween(2015, 2025),
            'status' => $this->faker->randomElement(['active', 'maintenance', 'inactive']),
            'location' => $this->faker->randomElement(['Mina Norte', 'Mina Sur', 'Taller Central', 'Área de Mantenimiento']),

            // ⭐ Especificaciones técnicas
            'length' => $this->faker->randomFloat(2, 8.0, 15.0), // Entre 8.0 y 15.0 metros
            'width' => $this->faker->randomFloat(2, 2.5, 4.0),  // Entre 2.5 y 4.0 metros
            'height' => $this->faker->randomFloat(2, 3.0, 4.5), // Entre 3.0 y 4.5 metros
            'weight' => $this->faker->randomFloat(2, 25.0, 80.0), // Entre 25 y 80 toneladas
            'fuel_type' => $this->faker->randomElement(['diesel', 'electrico', 'hibrido']),

            // Capacidades
            'engine_power' => $this->faker->randomFloat(2, 200, 800), // HP
            'fuel_capacity' => $this->faker->randomFloat(2, 300, 1000), // Litros
            'bucket_capacity' => $this->faker->randomFloat(2, 2.0, 8.0), // m³
            'max_load' => $this->faker->randomFloat(2, 15.0, 50.0), // Toneladas

            'last_maintenance' => $this->faker->optional()->dateTimeBetween('-6 months', 'now'),
            'next_maintenance' => $this->faker->optional()->dateTimeBetween('now', '+3 months'),
        ];
    }

    private function generateEquipmentCode(): string
    {
        $prefixes = ['EXC', 'CAM', 'PER'];
        $prefix = $this->faker->randomElement($prefixes);
        $number = str_pad($this->faker->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT);

        return $prefix . '-' . $number;
    }

    /**
     * Estados específicos para diferentes tipos de equipos
     */
//    public function excavadora(): static
//    {
//        return $this->state(fn(array $attributes) => [
//            'length' => $this->faker->randomFloat(2, 10.0, 14.0),
//            'width' => $this->faker->randomFloat(2, 3.0, 4.0),
//            'height' => $this->faker->randomFloat(2, 3.5, 4.5),
//            'weight' => $this->faker->randomFloat(2, 40.0, 80.0),
//            'bucket_capacity' => $this->faker->randomFloat(2, 3.0, 8.0),
//            'fuel_type' => 'diesel',
//        ]);
//    }

    public function acarreo(): static
    {
        return $this->state(fn(array $attributes) => [
            'length' => $this->faker->randomFloat(2, 12.0, 16.0),
            'width' => $this->faker->randomFloat(2, 3.5, 4.5),
            'height' => $this->faker->randomFloat(2, 4.0, 5.0),
            'weight' => $this->faker->randomFloat(2, 60.0, 120.0),
            'max_load' => $this->faker->randomFloat(2, 30.0, 100.0),
            'fuel_type' => 'diesel',
            'bucket_capacity' => null, // Camiones no tienen cuchara
        ]);
    }

    public function perforadora(): static
    {
        return $this->state(fn(array $attributes) => [
            'length' => $this->faker->randomFloat(2, 8.0, 12.0),
            'width' => $this->faker->randomFloat(2, 2.5, 3.5),
            'height' => $this->faker->randomFloat(2, 3.0, 4.0),
            'weight' => $this->faker->randomFloat(2, 25.0, 50.0),
            'fuel_type' => $this->faker->randomElement(['diesel', 'electrico']),
            'bucket_capacity' => null, // Perforadoras no tienen cuchara
            'max_load' => null,
        ]);
    }
}
