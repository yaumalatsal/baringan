<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Item;
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

    public function items($id)
    {
        $floors = Floor::all();

        $item = Item::find($id);

        return view('admin.items', compact('floors', 'item'));
    }

    public function editItem($id)
    {
        $floors = Floor::all();

        $item = Item::find($id);
        if (!$item) {
            abort(404); // Jika room tidak ditemukan, tampilkan 404 error
        }

        return view('admin.items.edit', compact('floors', 'item'));
    }

    public function updateItem(Request $request, $id)
    {
        $floors = Floor::all();

        $item = Item::find($id);
        if (!$item) {
            abort(404); // Jika room tidak ditemukan, tampilkan 404 error
        }
        $item->update($request->all());

        return view('admin.items.edit', compact('floors', 'item'));
    }
}
