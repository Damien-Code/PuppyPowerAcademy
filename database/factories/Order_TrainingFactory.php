<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Training;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order_Training>
 */
class Order_TrainingFactory extends Factory
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
            'training_id' => Training::inRandomOrder()->first(),
        ];
    }
}
