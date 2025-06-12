<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Cart_Product;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WebshopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all products with relation to media
    return Inertia::render('webshop/Index',[
        'products' => Product::with('media')->get()
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
        if($request->user() == null){return redirect()->route('login');}

        $request->request->add(['cart_id' => $request->user()->id]);

        $validatedRequest = $request->validate([
            'cart_id'    => 'int|required|gt:0',
            'product_id' => 'int|required|gt:0',
            'amount'     => 'int|required|gt:0',
        ]);

        $itemInCart = Cart_Product::
        where(['cart_id' => $validatedRequest['cart_id'],
               'product_id' => $validatedRequest['product_id']
              ])
        ->first();
        // dd($itemInCart);
        //check if $itemInCart is already in cart, if so update, else create
        if($itemInCart == null){

            Cart_Product::create($validatedRequest);

        }
        else{
            //update
            $currentAmount = $itemInCart->amount;
            $selectedAmount = $validatedRequest['amount'];
            $newAmount = $currentAmount + $selectedAmount;
            $itemInCart->update(['amount' => $newAmount]);
            }
        return redirect()->route('webshop.index');
    }

    /**
     * @author Mischa Sasse and Damien-Code
     */
    public function show(Product $product)
    {
        return Inertia::render('webshop/Show', [
            // return the product with relation to media to also return the belonging image
            'product' => Product::with('media')->find($product->id),
        ]);
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
