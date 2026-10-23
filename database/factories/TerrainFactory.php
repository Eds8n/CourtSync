<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TerrainFactory extends Factory 
{
    public function definition(): array
    {
        return[
            'nom' => fake()->city() . ' Arena',
            'adresse' => fake()->address(),
            'type' => fake()->randomElement(['Interieur, Exterieur']),
        ];
    }

  public function ferme(): static
    {
        return $this->state(fn () => ['type' => 'Fermé temporairement']);
    }
}