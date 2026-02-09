<?php

namespace Database\Factories;

use App\Models\Vehicule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicule>
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
            'immatriculation' => fake()->unique()->regexify('[A-Z]{2}-\d{3}-[A-Z]{2}'),
            'marque' => fake()->randomElement(['Peugeot', 'Renault', 'Toyota', 'Ford', 'BMW', 'Mercedes']),
            'modele' => fake()->word(),
            'couleur' => fake()->randomElement(['Bleu', 'Rouge', 'Noir', 'Blanc', 'Gris', 'Vert']),
            'annee' => fake()->year(),
            'kilometrage' => fake()->numberBetween(0, 300000),
            'carrosserie' => fake()->randomElement(['Berline', 'SUV', 'Monospace', 'Coupé']),
            'energie' => fake()->randomElement(['E', 'D', 'EL']),
            'boite' => fake()->randomElement(['M', 'A']),
            'nombre_portes' => fake()->numberBetween(2, 5),
            'nombre_places' => fake()->numberBetween(2, 9),
            'prix_journalier' => fake()->randomFloat(2, 50, 300),
        ];
    }
}
