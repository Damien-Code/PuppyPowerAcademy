<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $orders = Order_Product::with('product', 'order')->get();
//        dd($orders);
        return Inertia::render('settings/OrderHistory',[
            'order_products' => Order_Product::with('product', 'order')->get()
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
