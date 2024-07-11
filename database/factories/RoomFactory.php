<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = RoomFactory::class;

    public function definition()
    {
        return [
            'name' => 'Kamar ' . $this->faker->unique()->numberBetween(1, 4),
            'floor_id' => \App\Models\Floor::factory(),
        ];
    }
    
}
