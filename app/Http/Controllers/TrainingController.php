<?php

namespace App\Http\Controllers;

use App\Models\Cart_Training;
use App\Models\TrainingCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trainingCategories = TrainingCategory::all();

        return Inertia::render('training/Index', [
            'trainingCategories' => $trainingCategories,
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
        if($request->user() == null) // Early return
            return redirect()->route('login');

        $request->request->add(['cart_id' => $request->user()->id]);
        $request->request->add(['trainingcategory_id' => $request->category_id]);

        $validatedRequest = $request->validate([
            'cart_id'    => 'int|required|gt:0',
            'trainingcategory_id' => 'int|required|gt:0',
        ]);

        $trainingInCart = Cart_Training::
        where(['cart_id' => $validatedRequest['cart_id'],
               'trainingcategory_id' => $validatedRequest['trainingcategory_id']
              ])
        ->first();

        if($trainingInCart == null){
            Cart_Training::create($validatedRequest);
        }

        return redirect()->back();
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
