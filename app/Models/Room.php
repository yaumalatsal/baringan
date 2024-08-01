<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'floor_id',
        'name',
        'status',
        'patient'
    ];  

    // Relationship to Floor
    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    // Relationship to Items
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
