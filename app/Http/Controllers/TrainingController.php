<?php

namespace App\Http\Controllers;

use App\Models\Dog_Training;
use App\Models\Training;
use App\Models\TrainingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\DogTraining; // Assuming you have a DogTraining model for the dog_trainings table

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $categories = TrainingCategory::whereHas('orders', function($query) use ($user) {
            $query->where('orders.user_id', $user->id);
        })
        ->with(['trainings' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])
        ->get();

        return Inertia::render('settings/Training', [
            'trainingCategories' => $categories
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

    /**
     * Set the specified video as watched for the user.
     */
    public function markWatched(Request $request, Training $training)
    {
        $user = $request->user(); // Or Auth::user()

        // Get IDs of dogs belonging to the authenticated user
        $dogIds = $user->dogs()->pluck('id');

        if ($dogIds->isEmpty()) {
            // Or handle as an error, or based on your application's logic
            return redirect()->back()->with('error', 'No dogs found for this user.');
        }

        // Find and update the DogTraining records for the user's dogs and the specified training
        // This will mark 'watched_at' for all of the user's dogs enrolled in this training.
        // If a user can only have one dog in a specific training, this will target that one.
        $updatedCount = Dog_Training::where('training_id', $training->id)
            ->whereIn('dog_id', $dogIds)
            ->update(['watched_at' => now()]);

        dd($updatedCount, $user, $dogIds);

        if ($updatedCount > 0) {
            // Optionally, add a success message
            return redirect()->back()->with('success', 'Training marked as watched!');
        } else {
            // No matching DogTraining record found, or it was already marked (if not re-setting)
            // You might want to inform the user or log this.
            return redirect()->back()->with('info', 'Training could not be marked as watched (no active enrollment found).');
        }
    }
}
