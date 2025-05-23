<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingCategory;
use Illuminate\Http\Request;

class AdminTrainingCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validatedRequest = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|gt:0',
            'training_id' => 'nullable',
        ]);
        TrainingCategory::create($validatedRequest);
        return redirect()->route('admin.training.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TrainingCategory $trainingCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingCategory $trainingCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrainingCategory $trainingCategory)
    {
        $validatedRequest = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|gt:0',
            'training_id' => 'nullable',
        ]);
        $trainingCategory->update($validatedRequest);
        return redirect()->route('admin.training.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingCategory $trainingCategory)
    {
        //
    }
}
