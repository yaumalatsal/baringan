<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Room;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $floors = Floor::all();
        return view('admin.index', compact('floors'));
    }

    public function floors($id)
    {
        // Ambil semua kamar yang terkait dengan lantai ini
        $floors = Floor::all();

        $lantai = Floor::find($id);
        $rooms = $lantai->rooms;

        return view('admin.floor', compact('floors', 'rooms', 'lantai'));
    }

    public function rooms($id)
    {
        $floors = Floor::all();
        
        // Menggunakan eager loading untuk memuat relasi items
        $rooms = Room::with('items')->find($id);

        // Mengecek apakah room ditemukan
        // if (!$rooms) {
        //     abort(404); // Jika room tidak ditemukan, tampilkan 404 error
        // }

        // Mengambil semua items yang terkait dengan room
        $items = $rooms->items;

        return view('admin.room', compact('floors', 'items', 'rooms'));
    }
}
