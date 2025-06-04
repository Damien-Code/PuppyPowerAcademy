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
     * @author Damien-Code and Floris Hafkenscheid
     * Get all trainings with relation to a trainingcategory
     * and get all trainingcategories with relation to a training.
     * Because a trainingCategory can have several trainings, where as training belongs to a trainingCategory.
     */
    public function index()
    {
        return Inertia::render(
            'settings/admin/Training',
            [
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
     * @author Damien-Code and Floris Hafkenscheid
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedRequest = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|string|max:255',
            'trainingcategory_id' => 'required|int|exists:trainingcategories,id'
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
     * @author Damien-Code and Floris Hafkenscheid
     * Update the specified resource in storage.
     */
    public function update(Request $request, Training $training)
    {
        $validatedRequest = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|string|max:255',
            'trainingcategory_id' => 'required|exists:trainingcategories,id'
        ]);

        $training->update($validatedRequest);

        return redirect()->route('admin.training.index');
    }

    /**
     * @author Damien-Code
     * Remove the specified resource from storage.
     */
    public function destroy(Training $training)
    {
        $training->delete();
        return redirect()->route('admin.training.index');
    }
}
