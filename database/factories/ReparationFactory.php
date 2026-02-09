<?php

namespace Database\Factories;

use App\Models\Reparation;
use App\Models\Vehicule;
use App\Models\Technicien;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reparation>
 */
class ReparationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vehicule_id' => Vehicule::factory(),
            'technicien_id' => fake()->boolean(70) ? Technicien::factory() : null,
            'date' => fake()->dateTimeBetween('-1 month')->format('Y-m-d'),
            'duree_main_oeuvre' => fake()->numberBetween(30, 480),
            'objet_reparation' => fake()->sentence(),
        ];
    }
}
