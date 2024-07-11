<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Room;

class RoomController extends Controller
{
    public function index(Floor $floor)
    {
        $rooms = $floor->rooms;
        return view('rooms.index', compact('rooms', 'floor'));
    }
}

