<?php

namespace Database\Factories;

use App\Models\Training;
use App\Models\TrainingCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart_Training>
 */
class Cart_TrainingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $user_id = 1;
        return [
            'cart_id' => $user_id++,
            'category_id' => TrainingCategory::inRandomOrder()->first(),
        ];
    }
}
