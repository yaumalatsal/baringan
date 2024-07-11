<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
