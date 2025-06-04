<?php

namespace Tests\Unit;

use App\Models\Training;
use App\Models\TrainingCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @author florishafkenscheid
     * Test that a training can be created
     */
    public function test_can_create_a_training(): void
    {
        $category = TrainingCategory::factory()->create();

        $training = Training::create([
            'title' => 'Zonder lijn lopen',
            'description' => 'Leer je hond aan om bij je te blijven, ookal zit deze niet aan de lijn.',
            'link' => 'https://youtube.com/watch?v=example',
            'trainingcategory_id' => $category->id,
        ]);

        $this->assertInstanceOf(Training::class, $training);
        $this->assertEquals('Zonder lijn lopen', $training->title);
    }

    /**
     * @author florishafkenscheid
     * Test that trainings are soft deleted, instead of hard deleted
     */
    public function test_training_soft_deletes(): void
    {
        $category = TrainingCategory::factory()->create();
        $training = Training::factory()->create(['trainingcategory_id' => $category->id]);

        $training->delete();

        $this->assertSoftDeleted($training);
    }
}
