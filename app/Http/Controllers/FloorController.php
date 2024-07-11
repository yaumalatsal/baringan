<?php

namespace App\Http\Controllers;

use App\Models\Floor;

class FloorController extends Controller
{
    public function index()
    {
        $floors = Floor::all();
        return view('floors.index', compact('floors'));
    }

  
    public function rooms(Floor $floor)
    {
        // Ambil semua kamar yang terkait dengan lantai ini
        $rooms = $floor->rooms;

        return view('floors.rooms', compact('floor', 'rooms'));
    }


}
