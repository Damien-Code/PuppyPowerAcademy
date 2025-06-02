<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Training;
use App\Models\TrainingCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order_Training>
 */
class Category_OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::inRandomOrder()->first(),
            'trainingcategory_id' => TrainingCategory::inRandomOrder()->first(),
        ];
    }
}
