<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BoomLift>
 */
class BoomLiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true).' Boom Lift',
            'model' => fake()->bothify('BL-####'),
            'description' => fake()->paragraph(),
            'specifications' => [
                'max_height' => fake()->numberBetween(30, 150),
                'platform_capacity' => fake()->numberBetween(113, 454),
                'outreach' => fake()->numberBetween(20, 60),
                'weight' => fake()->numberBetween(2000, 9000).' Kg',
            ],
            'image' => null,
            'hourly_rate' => fake()->randomFloat(2, 50, 200),
            'daily_rate' => fake()->randomFloat(2, 300, 1000),
            'monthly_rate' => fake()->randomFloat(2, 5000, 20000),
            'is_available' => true,
        ];
    }
}
