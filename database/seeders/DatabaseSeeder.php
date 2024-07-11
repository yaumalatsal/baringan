<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
{
    \App\Models\Floor::factory(3)->create()->each(function ($floor) {
        \App\Models\Room::factory(4)->create(['floor_id' => $floor->id])->each(function ($room) {
            \App\Models\Item::factory(4)->create(['room_id' => $room->id]);
        });
    });
}

}
