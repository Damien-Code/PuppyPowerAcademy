<?php

namespace App\Http\Controllers;

use App\Models\Cart;
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
        
    return Inertia::render('webshop/Index',[
        'products' => Product::all()
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
        $request->request->add(['user_id' => $request->user()->id]);
        
        $validatedRequest = $request->validate([
            'user_id'    => 'int|required|gt:0',
            'product_id' => 'int|required|gt:0',
            'amount'     => 'int|required|gt:0',
        ]);

        $itemInCart = Cart::
        where(['user_id' => $validatedRequest['user_id'],
               'product_id' => $validatedRequest['product_id']
              ])
        ->first();

        //check if $itemInCart is already in cart, if so update, else create
        if($itemInCart == null){
            //create 
            Cart::create($validatedRequest);
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
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return Inertia::render('webshop/Show', [
            'product' => $product,
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
