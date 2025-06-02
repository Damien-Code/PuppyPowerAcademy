<?php

namespace Tests\Unit;

use App\Models\Training;
use App\Models\TrainingCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TrainingCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @author florishafkenscheid
     * Test that the relation between trainingcategory and training is one to many
     */
    public function test_has_many_trainings(): void
    {
        $category = TrainingCategory::factory()->create();
        $training1 = Training::factory()->create(['trainingcategory_id' => $category->id]);
        $training2 = Training::factory()->create(['trainingcategory_id' => $category->id]);
        
        $this->assertCount(2, $category->trainings);
        $this->assertTrue($category->trainings->contains($training1));
        $this->assertTrue($category->trainings->contains($training2));
    }

    /**
     * @author florishafkenscheid
     * Test that the descriptors of a training category are stored as JSON, but cast to array when used
     */
    public function test_casts_descriptors_to_array(): void
    {
        $descriptors = ['basic training', 'blaa', 'blabla'];
        $category = TrainingCategory::factory()->create([
            'descriptors' => $descriptors,
        ]);

        // Get the raw descriptors value directly from the database
        $rawDescriptors = DB::table('trainingcategories')
            ->where('id', $category->id)
            ->value('descriptors');
            
        $this->assertJson($rawDescriptors);
        $this->assertIsArray($category->descriptors);
        $this->assertEquals($descriptors, $category->descriptors);
    }
}
