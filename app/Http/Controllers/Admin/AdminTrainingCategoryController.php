<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Training;
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
     * @author Damien-Code
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request['descriptors'] = json_encode($request['descriptors']);
        $validatedRequest = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|gt:0',
            'descriptors' => 'required|json',
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
     * @author Damien-Code
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrainingCategory $trainingCategory)
    {
        $request['descriptors'] = json_encode($request['descriptors']);
        $validatedRequest = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|gt:0',
            'descriptors' => 'required|json',
        ]);
        $trainingCategory->update($validatedRequest);
        return redirect()->route('admin.training.index');
    }

    /**
     * @author Damien-Code
     * Deletes the trainings belonging to category
     * and deletes the categories
     */
    public function destroy(TrainingCategory $trainingCategory)
    {
        $trainingCategory->trainings()->delete();
        $trainingCategory->delete();
        return redirect()->route('admin.training.index');
    }
}
