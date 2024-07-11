<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ItemFactory::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'code' => $this->faker->unique()->word,
            'entry_date' => $this->faker->date,
            'last_checked_date' => $this->faker->date,
            'item_condition' => $this->faker->word,
            'room_id' => \App\Models\Room::factory(),
        ];
    }
}
