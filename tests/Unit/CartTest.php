<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Http\Controllers\CartController;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Cart_Product;
use App\Models\Cart_Training;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @author MischaSasse
     * 
     * A test to check if products can be added to a users cart
     * then tests if items can be deleted from cart
     */
    public function test_user_can_add_product_to_cart_and_then_delete_from_cart()
    {
        $user = User::factory()->create(['role_id' => 2]);
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        
        $product = Product::factory()->create([
            'name' => 'test product',
            'description' => 'this is a test product',
            'price' => 5,
            'stock' => 10,
        ]);
        $cartData = [
            'cart_id' => $user->id,
            'product_id' => $product->id,
            'amount' => 5,
        ];
        $cartProduct = Cart_Product::factory()->create($cartData);
        //check if product in cart
        $this->assertDatabaseHas('cart_products', $cartData);

        //check if product removed from cart
        Cart_Product::where(['cart_id' => $user->id])->delete();
        Cart_Training::where(['cart_id'=> $user->id])->delete();

        $this->assertDatabaseMissing('cart_products', $cartData);
    }

    
}
