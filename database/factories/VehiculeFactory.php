<?php

namespace Database\Factories;

use App\Models\Vehicule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicule>
 */
class VehiculeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'matricule' => $this->faker->unique()->bothify('####-???-##'),
            'type_voiture' => $this->faker->randomElement(['SUV', 'Berline', 'Camionnette', 'Citadine', 'Utilitaire']),
            'disponibilite' => $this->faker->boolean(80),
        ];
    }
}
