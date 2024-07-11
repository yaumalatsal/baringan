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
        'code',
        'entry_date',
        'last_checked_date',
        'item_condition',
        'image'
 
    ];

    // Rest of your model code...
}
