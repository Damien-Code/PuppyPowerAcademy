<?php

namespace Tests\Feature;

use App\Models\TrainingCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrainingControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @author florishafkenscheid
     * Test that users can view training categories
     */
    public function test_users_can_view_training_categories(): void
    {
        TrainingCategory::factory()->count(3)->create();

        $response = $this->get('/training');

        $response->assertStatus(200)
            ->assertInertia(fn ($page) =>
                $page->component('training/Index')
                    ->has('trainingCategories', 3)    
        );
    }
}
