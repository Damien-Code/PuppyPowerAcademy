<?php

namespace Database\Factories;

use App\Models\Dog;
use App\Models\Training;
use App\Models\TrainingCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dog_Training>
 */
class Dog_TrainingFactory extends Factory
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
            'training_id' => Training::inRandomOrder()->first(),
        ];
    }
}
