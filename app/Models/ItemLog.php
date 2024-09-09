<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'room_id',
        'name',
        'code',
        'merk',
        'entry_date',
        'last_checked_date',
        'condition',
        'clean_status',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
