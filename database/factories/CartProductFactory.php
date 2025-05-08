<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart_Product>
 */
class CartProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cart_id' => Cart::inRandomOrder()->first(),
            'product_id' => Product::inRandomOrder()->first(),
            'amount' => $this->faker->numberBetween(1,5),
        ];
    }
}
