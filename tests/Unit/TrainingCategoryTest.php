<?php

namespace Tests\Unit;

use App\Models\Training;
use App\Models\TrainingCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

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
     * 
     */
    public function test_casts_descriptors_to_array(): void
    {

    }
}
