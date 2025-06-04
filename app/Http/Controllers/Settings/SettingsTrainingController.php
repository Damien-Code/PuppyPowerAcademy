<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Dog_Training;
use App\Models\Training;
use App\Models\TrainingCategory;
use App\Models\UserTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SettingsTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \App\Models\User $user */ // So dogs() isn't undefined, don't delete :)
        $user = Auth::user();
        
        // Get watched training IDs for this user (both from user_trainings and dog_trainings)
        $watchedTrainingIds = collect();
        
        // User's direct training progress
        $userWatchedTrainings = UserTraining::where('user_id', $user->id)
            ->whereNotNull('watched_at')
            ->pluck('training_id');
        
        $watchedTrainingIds = $watchedTrainingIds->merge($userWatchedTrainings);
        
        // Dog training progress (if user has dogs)
        $dogIds = $user->dogs()->pluck('id');
        if (!$dogIds->isEmpty()) {
            $dogWatchedTrainings = Dog_Training::whereIn('dog_id', $dogIds)
                ->whereNotNull('watched_at')
                ->pluck('training_id');
            
            $watchedTrainingIds = $watchedTrainingIds->merge($dogWatchedTrainings);
        }
        
        $watchedTrainingIds = $watchedTrainingIds->unique();

        $categories = TrainingCategory::whereHas('orders', function($query) use ($user) {
            $query->where('orders.user_id', $user->id);
        })
        ->with(['trainings'])
        ->get();

        $categoriesWithProgress = $categories->map(function ($category) use ($watchedTrainingIds) {
            $totalTrainings = $category->trainings->count();
            $watchedTrainingsCount = 0;

            if ($totalTrainings > 0) {
                $watchedTrainingsCount = $category->trainings->filter(function ($training) use ($watchedTrainingIds) {
                    return $watchedTrainingIds->contains($training->id);
                })->count();
            }

            $progressPercentage = ($totalTrainings > 0) ? ($watchedTrainingsCount / $totalTrainings) * 100 : 0;

            $trainingsData = $category->trainings->map(function($training) use ($watchedTrainingIds) {
                return array_merge($training->toArray(), [
                    'watched_by_user' => $watchedTrainingIds->contains($training->id)
                ]);
            });

            return [
                'id' => $category->id,
                'name' => $category->name,
                'price' => $category->price,
                'trainings' => $trainingsData,
                'total_trainings' => $totalTrainings,
                'watched_trainings_count' => $watchedTrainingsCount,
                'progress_percentage' => round($progressPercentage),
            ];
        });

        return Inertia::render('settings/Training', [
            'trainingCategories' => $categoriesWithProgress,
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
        $user = $request->user();
        
        // Mark as watched for the user directly
        UserTraining::updateOrCreate(
            [
                'user_id' => $user->id,
                'training_id' => $training->id
            ],
            ['watched_at' => now()]
        );
        
        // Also mark for dogs if they exist (for backward compatibility)
        $dogIds = $user->dogs()->pluck('id');
        if (!$dogIds->isEmpty()) {
            foreach ($dogIds as $dogId) {
                Dog_Training::updateOrCreate(
                    [
                        'dog_id' => $dogId,
                        'training_id' => $training->id
                    ],
                    ['watched_at' => now()]
                );
            }
        }

        return redirect()->back();
    }
}
