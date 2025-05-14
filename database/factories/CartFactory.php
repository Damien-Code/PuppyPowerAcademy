<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart_Product>
 */
class CartFactory extends Factory
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
            'user_id' => $user_id++,
            'product_id' => Product::inRandomOrder()->first(),
            'amount' => $this->faker->numberBetween(1,5),
        ];
    }
}
