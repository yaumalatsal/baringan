<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Room $room)
{
    // Menggunakan eager loading untuk memuat relasi items
    $room = Room::with('items')->find($room->id);

    // Mengecek apakah room ditemukan
    if (!$room) {
        abort(404); // Jika room tidak ditemukan, tampilkan 404 error
    }

    // Mengambil semua items yang terkait dengan room
    $items = $room->items;

    return view('items.index', compact('items', 'room'));
}


    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $item->update($request->all());
        return redirect()->route('items.index');
    }

    public function create(Room $room)
    {
        return view('items.create', compact('room'));
    }
    

    public function store(Request $request)
    {
        Item::create($request->all());
        return redirect()->route('items.index');
    }
}
