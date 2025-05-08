<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Dog;
use App\Models\Daycare;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Daycare_Dog>
 */
class DaycareDogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dog_id' => Dog::inRandomOrder()->first(),
            'daycare_id' => Daycare::inRandomOrder()->first()
        ];
    }
}
