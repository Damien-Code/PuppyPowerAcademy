<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\TrainingCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render(
            'settings/admin/Training',
            [
//                'trainings' => Training::query()
//                ->with('trainingCategory')->get(),
                'trainings' => Training::with('trainingCategory')->get(),
                'trainingCategories' => TrainingCategory::with('trainings')->get(),
            ]
        );
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|string|max:255',
            'training_category_id' => 'required|int|exists:training_categories,id'
        ]);

        Training::create($validatedRequest);

        return redirect()->route('admin.training.index');
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
    public function update(Request $request, Training $training)
    {
        $validatedRequest = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|string|max:255',
            'training_category_id' => 'required|exists:training_categories,id'
        ]);


        $training->update($validatedRequest);

        return redirect()->route('admin.training.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
