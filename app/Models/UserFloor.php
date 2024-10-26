<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFloor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'floor_id'
    ];


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_floors');
    }
}
