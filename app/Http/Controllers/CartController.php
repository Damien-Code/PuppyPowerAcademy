<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Cart_Product;
use App\Models\Cart_Training;
use App\Models\Product;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productTaxPercentage  = 18;
        $trainingTaxPercentage = 18;
        // get products
        // $products = Product::join("cart_products", function($join){
        // 	$join->on("products.id", "=", "cart_products.product_id");
        // })->join("carts", function($join){
        // 	$join->on("carts.user_id", "=", "cart_products.cart_id");
        // })->where(['user_id'=>Auth::user()->id])->get();

        
        $products = DB::table("products")
        ->join("cart_products", function($join){
        	$join->on(['products.id' => 'cart_products.product_id']);
        })
        ->join("carts", function($join){
        	$join->on(['carts.user_id' => 'cart_products.cart_id']);
        })
        ->select("products.*", "cart_products.amount as amount")
        ->where(['user_id'=>Auth::user()->id])
        ->get();
        
        $subtotal = 0;
        $taxProduct = 0;
        $taxTraining = 0;

        foreach($products as $product){
            $subtotal += ($product->price * $product->amount);
            $taxProduct += ($product->price * $product->amount * ($productTaxPercentage/100));
        }
        //get trainings
        $trainings = Training::join("cart_trainings", function($join){
        	$join->on("trainings.id", "=", "cart_trainings.training_id");
        })->join("carts", function($join){
        	$join->on("carts.user_id", "=", "cart_trainings.cart_id");
        })->where(['user_id'=>Auth::user()->id])->get();
        
        foreach($trainings as $training){
            $subtotal += ($training->price);
            $taxTraining += ($training->price * ($trainingTaxPercentage/100));
        }

        return Inertia::render('webshop/Cart',[
        'products' => $products,
        'trainings' => $trainings,
        'subtotalPrice' => $subtotal,
        'taxProduct' => $taxProduct,
        'taxTraining' => $taxTraining
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //store in orders
        
        dd($request->products, $request->trainings, $request->totalPrice);
        //remove products/trainings from cart
        $this->removeItemsFromCart();


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $this->removeItemsFromCart();
        return redirect()->route('webshop.index');
    }

    private function removeItemsFromCart()
    {
        Cart_Product::where(['cart_id' => Auth::user()->id])->delete();
        Cart_Training::where(['cart_id'=> Auth::user()->id])->delete();
    }
}
