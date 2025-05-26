<?php

namespace Database\Factories;

use App\Models\TrainingCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Training>
 */
class TrainingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(2, true),
            'description' => $this->faker->paragraph(),
            'link' => "https://www.youtube.com/watch?v=7Lf0jEgz9BA",
            'training_category_id' => TrainingCategory::inRandomOrder()->first(),
        ];
    }
}
