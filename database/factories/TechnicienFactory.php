<?php

namespace Database\Factories;

use App\Models\Technicien;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Technicien>
 */
class TechnicienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->lastName(),
            'prenom' => fake()->firstName(),
            'specialite' => fake()->randomElement(['Moteur', 'Électrique', 'Carrosserie', 'Freinage', 'Suspension']),
            'telephone' => fake()->phoneNumber(),
        ];
    }
}
