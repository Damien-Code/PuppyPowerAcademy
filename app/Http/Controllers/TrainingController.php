<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\Order;
use App\Models\Order_Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get all order IDs belonging to the authenticated user
        $userOrderIds = Order::where('user_id', $user->id)
            ->pluck('id');
            
        // Get all training IDs from orders that belong to the user
        $trainingIds = Order_Training::whereIn('order_id', $userOrderIds)
            ->pluck('training_id')
            ->unique();
            
        // Get the complete training details
        $trainings = Training::whereIn('id', $trainingIds)
            ->get();
            
        return Inertia::render('settings/Training', [
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
