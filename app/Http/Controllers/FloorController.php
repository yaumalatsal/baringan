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

<<<<<<< HEAD
    public function rooms($floor)
    {
        $floor = Floor::findOrFail($floor); // Cari lantai berdasarkan ID atau sesuaikan dengan parameter yang Anda gunakan
        $rooms = $floor->rooms; // Ambil daftar kamar dari lantai yang ditemukan
        return view('floors.rooms', compact('floor', 'rooms'));
    }
=======
  
    public function rooms(Floor $floor)
    {
        // Ambil semua kamar yang terkait dengan lantai ini
        $rooms = $floor->rooms;

        return view('floors.rooms', compact('floor', 'rooms'));
    }

>>>>>>> a13eef80b12baf1da42362ae6076b9c4384a8a3f

}
