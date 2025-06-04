<?php

namespace Tests\Feature;

use App\Models\Category_Order;
use App\Models\User;
use App\Models\Dog;
use App\Models\Training;
use App\Models\TrainingCategory;
use App\Models\UserTraining;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainingProgressTest extends TestCase
{
    use RefreshDatabase;

    /** 
     * @author florishafkenscheid
     * Test that a user can mark training as watched
     */
    public function test_user_can_mark_training_as_watched()
    {
        $user = User::factory()->create();
        $category = TrainingCategory::factory()->create();
        $training = Training::factory()->create(['trainingcategory_id' => $category->id]);

        $response = $this->actingAs($user)
            ->post(route('settings.training.markWatched', $training));

        $response->assertRedirect();
        $this->assertDatabaseHas('user_trainings', [
            'user_id' => $user->id,
            'training_id' => $training->id,
        ]);
    }

    /** 
     * @author florishafkenscheid
     * Test that the progress of a category is calculated properly
     */
    public function test_progress_is_calculated_correctly()
    {
        $user = User::factory()->create();
        $category = TrainingCategory::factory()->create(['name' => 'Test Category']);
        
        // Create an order so the user has access to this category
        $order = Order::factory()->create([
            'user_id' => $user->id,
        ]);

        Category_Order::create([
            'trainingcategory_id' => $category->id,
            'order_id' => $order->id,
        ]);
        
        // Create 4 trainings in the category
        $trainings = Training::factory()->count(4)->create(['trainingcategory_id' => $category->id]);
        
        // Mark 2 as watched using UserTraining instead of Dog_Training
        UserTraining::create(['user_id' => $user->id, 'training_id' => $trainings[0]->id, 'watched_at' => now()]);
        UserTraining::create(['user_id' => $user->id, 'training_id' => $trainings[1]->id, 'watched_at' => now()]);

        $response = $this->actingAs($user)->get('/settings/training');
        
        // Test that progress calculation shows 50% (2 out of 4)
        $response->assertStatus(200)
                ->assertInertia(fn ($page) => $page
                    ->component('settings/Training')
                    ->has('trainingCategories', 1)
                    ->has('trainingCategories.0.id')
                    ->has('trainingCategories.0.name')
                    ->has('trainingCategories.0.trainings', 4)
                    ->has('trainingCategories.0.progress_percentage')
                    ->where('trainingCategories.0.name', 'Test Category')
                    ->where('trainingCategories.0.total_trainings', 4)
                    ->where('trainingCategories.0.watched_trainings_count', 2)
                    ->where('trainingCategories.0.progress_percentage', 50)
                );
    }
}
