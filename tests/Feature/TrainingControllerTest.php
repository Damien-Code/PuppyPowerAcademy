<?php

namespace Tests\Feature;

use App\Models\TrainingCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    /**
     * @author florishafkenscheid
     * Test that training categories are returned with correct structure
     */
    public function test_training_displays_categories_with_correct_structure(): void
    {
        TrainingCategory::factory()->create([
            'name' => 'Test Category',
            'price' => 49.99
        ]);
        
        $response = $this->get('/training');

        $response->assertStatus(200)
            ->assertInertia(fn ($page) =>
                $page->component('training/Index')
                    ->has('trainingCategories', 1)
                    ->has('trainingCategories.0.id')
                    ->has('trainingCategories.0.name')
                    ->has('trainingCategories.0.price')
                    ->has('trainingCategories.0.descriptors')
                    ->where('trainingCategories.0.name', 'Test Category')
                    ->where('trainingCategories.0.price', 49.99)
        );
    }
}
