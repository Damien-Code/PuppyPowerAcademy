<?php

namespace Tests\Feature\Integration;

use App\Models\Dog;
use App\Models\Training;
use App\Models\Dog_Training;
use App\Models\TrainingCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DogTrainingTest extends TestCase
{
    use RefreshDatabase;

    /** 
     * @author florishafkenscheid
     * Test to see if a training can be marked as watched
     */
    public function test_can_mark_training_as_watched()
    {
        $user = User::factory()->create();
        $dog = Dog::factory()->create(['user_id' => $user->id]);
        $category = TrainingCategory::factory()->create();
        $training = Training::factory()->create(['trainingcategory_id' => $category->id]);

        $dogTraining = Dog_Training::create([
            'dog_id' => $dog->id,
            'training_id' => $training->id,
            'watched_at' => now(),
        ]);

        $this->assertNotNull($dogTraining->watched_at);
        $this->assertDatabaseHas('dog_trainings', [
            'dog_id' => $dog->id,
            'training_id' => $training->id,
        ]);
    }

    /** 
     * @author florishafkenscheid
     * Test to see if a link can be established, and then edited
     */
    public function test_can_update_or_create_dog_training_record()
    {
        $user = User::factory()->create();
        $dog = Dog::factory()->create(['user_id' => $user->id]);
        $category = TrainingCategory::factory()->create();
        $training = Training::factory()->create(['trainingcategory_id' => $category->id]);

        // Create
        $dogTraining = Dog_Training::updateOrCreate(
            ['dog_id' => $dog->id, 'training_id' => $training->id],
            ['watched_at' => now()]
        );

        $this->assertNotNull($dogTraining->watched_at);

        // Then edit
        $newWatchedAt = now()->addHour();
        $updatedDogTraining = Dog_Training::updateOrCreate(
            ['dog_id' => $dog->id, 'training_id' => $training->id],
            ['watched_at' => $newWatchedAt]
        );

        $this->assertEquals($dogTraining->id, $updatedDogTraining->id);
        $this->assertEquals($newWatchedAt->format('Y-m-d H:i:s'), $updatedDogTraining->watched_at->format('Y-m-d H:i:s'));
    }
}
