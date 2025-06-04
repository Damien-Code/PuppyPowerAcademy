<?php

namespace Tests\Feature;

use App\Models\Training;
use App\Models\TrainingCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTrainingControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $superuser;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->superuser = User::factory()->create(['role_id' => 1]);
        $this->user = User::factory()->create(['role_id' => 2]);
    }

    /**
     * @author florishafkenscheid
     * Test that admins can view the admin training route
     */
    public function test_admin_can_view_training(): void
    {
        $category = TrainingCategory::factory()->create();
        $training = Training::factory()->create(['trainingcategory_id' => $category->id]);

        $response = $this->actingAs($this->superuser)->get(route('admin.training.index'));
        
        $response->assertStatus(200)
            ->assertInertia(fn ($page) =>
                $page->component('settings/admin/Training')
                ->has('trainings', 1)
                ->has('trainingCategories', 1)    
        );
    }

    /**
     * @author florishafkenscheid
     * Test that non admins can't view the admin training route
     */
    public function test_guest_cannot_view_training(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.training.index'));
        $response->assertStatus(403);
    }

    /**
     * @author florishafkenscheid
     * Test that admins can create a new training
     */
    public function test_admin_can_create_training(): void
    {
        $category = TrainingCategory::factory()->create();

        $trainingData = [
            'title' => 'Nieuwe Training',
            'description' => 'Lorem ipsum, whatever blabbkfbkjehgjwk',
            'link' => 'https://youtube.com/watch?v=example',
            'trainingcategory_id' => $category->id,
        ];

        $response = $this->actingAs($this->superuser)->post(route('admin.training.store'), $trainingData);

        $response->assertRedirect(route('admin.training.index'));
        $this->assertDatabaseHas('trainings', $trainingData);
    }

    /**
     * @author florishafkenscheid
     * Test that admins can update trainings
     */
    public function test_admin_can_update_training(): void
    {
        $category = TrainingCategory::factory()->create();
        $training = Training::factory()->create(['trainingcategory_id' => $category->id]);

        $updateData = [
            'title' => 'Geüpdatet Training',
            'description' => 'blaaaaaaaaa, lorem ipsum dolor sit amet.....!!',
            'link' => 'https://youtube.com/example',
            'trainingcategory_id' => 1,
        ];

        $response = $this->actingAs($this->superuser)->patch(route('admin.training.update', $training), $updateData);

        $response->assertRedirect(route('admin.training.index'));
        $this->assertDatabaseHas('trainings', array_merge(['id' => $training->id], $updateData));
    }

    /**
     * @author florishafkenscheid
     * Test that admins can delete trainings
     */
    public function test_admin_can_delete_training(): void
    {
        $category = TrainingCategory::factory()->create();
        $training = Training::factory()->create(['trainingcategory_id' => $category->id]);

        $response = $this->actingAs($this->superuser)->delete(route('admin.training.destroy', $training));
        
        $response->assertRedirect(route('admin.training.index'));
        $this->assertSoftDeleted($training);
    }

    /**
     * @author florishafkenscheid
     * Test that a training can't be created with invalid/missing data
     */
    public function test_training_creation_requires_valid_data(): void
    {
        $response = $this->actingAs($this->superuser)->post(route('admin.training.store'), []);

        $response->assertSessionHasErrors(['title', 'description', 'link', 'trainingcategory_id']);
    }

    /**
     * @author florishafkenscheid
     * Test that a training can't be created without an existing category
     */
    public function test_training_creation_requires_existing_category(): void
    {
        $response = $this->actingAs($this->superuser)->post(route('admin.training.store'), [
            'title' => 'Test',
            'description' => 'lorem ipsum',
            'link' => 'https://youtube.com/watch?v=example',
            'trainingcategory_id' => 999, // Doesn't exist
        ]);

        $response->assertSessionHasErrors(['trainingcategory_id']);
    }
}
