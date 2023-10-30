<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if(User::first()) {
            return [
                'name' => $this->faker->word,
                'start_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
                'end_date' => $this->faker->dateTimeBetween('now', '+1 year'),
                'value' => $this->faker->randomFloat(2, 100, 10000),
                'status' => $this->faker->randomElement(['Active', 'Inactive']),
                'creator_id' => User::all()->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    }
}
