<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_Product;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderHistoryController extends Controller
{
    /**
     * @author Damien-Code
     * @return \Inertia\Response
     * Query that returns all orders for the current user with a relation with the order_products model.
     * I first returned the order_products model, but I found out that returning the order model
     * was a better option.
     */
    public function index() : \Inertia\Response
    {
        $orders = Order::with('orderProducts')->where('user_id', auth()->id())->get();
        return Inertia::render('settings/OrderHistory',[
            'orders' => $orders,
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
