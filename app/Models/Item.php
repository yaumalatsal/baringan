<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'room_id',
        'floor_id',
        'name',
        'merk',
        'code',
        'entry_date',
        'last_checked_date',
        'condition',
        'clean_status',
        'image'
 
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function logs()
    {
        return $this->hasMany(ItemLog::class);
    }

    // Rest of your model code...
}
