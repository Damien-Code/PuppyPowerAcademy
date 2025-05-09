<?php

namespace Database\Factories;
use App\Models\Product;
use App\Models\Order_Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        // $order_products = Order_Product::inRandomOrder()->first() ?? Order_Product::factory()->create();
        //gotta think about how we will do total_price
        
//msNote: removed total_price for now, can be calculated but annoying to seed

        return [
            'user_id' => User::inRandomOrder()->first(),
            // 'total_price' => $product->price * 5,  //$order_products->amount,
            'country' => $this->faker->countryCode(),
            'city' => $this->faker->city(),
            'street' => $this->faker->streetName(),
            'house_number' => $this->faker->buildingNumber(),
            'postal_code' => $this->faker->postcode()
        ];
    }
}
