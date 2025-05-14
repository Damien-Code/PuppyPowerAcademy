<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get products
        $products = Product::join("cart_products", function($join){
        	$join->on("products.id", "=", "cart_products.product_id");
        })->join("carts", function($join){
        	$join->on("carts.user_id", "=", "cart_products.cart_id");
        })->where(['user_id'=>Auth::user()->id])->get();
        
        //get trainings
        $trainings = Training::join("cart_trainings", function($join){
        	$join->on("trainings.id", "=", "cart_trainings.training_id");
        })->join("carts", function($join){
        	$join->on("carts.user_id", "=", "cart_trainings.cart_id");
        })->where(['user_id'=>Auth::user()->id])->get();
        
        return Inertia::render('webshop/Cart',[
        'products' => $products,
        'trainings' => $trainings

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
        //
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
    public function destroy(string $id)
    {
        //
    }
}
