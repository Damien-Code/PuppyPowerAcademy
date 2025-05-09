<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dog>
 */
class DogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName($gender = null),
            'race' => $this->faker->words(1, true),
            'user_id' => User::inRandomOrder()->first(),
            'age' => $this->faker->numberBetween(1, 12),
            'been_to_daycare' => $this->faker->boolean(0,5)
        ];
    }
}
