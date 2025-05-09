<?php

namespace Database\Factories;

use App\Models\Dog;
use App\Models\Daycare;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Daycare_Dog>
 */
class Daycare_DogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dog_id' => Dog::inRandomOrder()->first(),
            'daycare_id' => Daycare::inRandomOrder()->first(),
        ];
    }
}
