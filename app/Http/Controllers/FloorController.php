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

    public function rooms($floor)
{
    $floor = Floor::findOrFail($floor); // Cari lantai berdasarkan ID atau sesuaikan dengan parameter yang Anda gunakan
    $rooms = $floor->rooms; // Ambil daftar kamar dari lantai yang ditemukan
    return view('floors.rooms', compact('floor', 'rooms'));
}

}
