<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Item;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        $room = Room::with('items')->find($id);

        // Mengecek apakah room ditemukan
        // if (!$rooms) {
        //     abort(404); // Jika room tidak ditemukan, tampilkan 404 error
        // }

        // Mengambil semua items yang terkait dengan room
        $items = $room->items;

        return view('admin.room', compact('floors', 'items', 'room'));
    }

    public function items($id)
    {
        $floors = Floor::all();

        $item = Item::with('room.floor')->find($id);

        return view('admin.items.detail', compact('floors', 'item'));
    }

    public function createItem(Room $room)
    {
        $floors = Floor::all();

        return view('admin.items.create', compact('floors'));
    }

    public function getRoomsByFloor($floorId)
    {
        $rooms = Room::where('floor_id', $floorId)->get();
        return response()->json($rooms);
    }

    public function storeItem(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'entry_date' => 'required|date',
            'last_checked_date' => 'required|date',
            'condition' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar
            'room_id' => 'required|exists:rooms,id', // Pastikan room_id valid
            // 'floor_id' => 'required|exists:floors,id', // Pastikan floor_id valid
        ]);

        Log::info($request->all());


        // Proses menyimpan gambar
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName); // Simpan gambar di storage/images

            // Buat record item dengan menyertakan nama gambar
            $item = Item::create(array_merge($validatedData, ['image' => $imageName]));
        } else {
            // Jika tidak ada gambar diunggah
            $item = Item::create($validatedData);
        }
        Log::info($item);
        return redirect()->route('admin.rooms', $item->room_id)
            ->with('success', 'Item created successfully.');
    }

    // edit
    public function editItem($id)
    {
        $floors = Floor::all();

        $item = Item::find($id);
        if (!$item) {
            abort(404); // Jika room tidak ditemukan, tampilkan 404 error
        }
        $rooms = Room::where('floor_id', $item->room->floor_id)->get();

        return view('admin.items.edit', compact('item', 'floors', 'rooms'));
    }

    public function updateItem(Request $request, $id)
    {
        $floors = Floor::all();

        $item = Item::find($id);
        $item = Item::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'entry_date' => 'required|date',
            'last_checked_date' => 'required|date',
            'condition' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'room_id' => 'required|exists:rooms,id',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($item->image) {
                Storage::delete('public/images/' . $item->image);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);

            $item->update(array_merge($validatedData, ['image' => $imageName]));
        } else {
            $item->update($validatedData);
        }

        // Redirect with success message
        return redirect()->route('admin.rooms', $item->room_id)
            ->with('success', 'Item updated successfully.');

        return view('admin.items.edit', compact('floors', 'item'));
    }
    public function destroyItem($id)
    {
        $item = Item::find($id);

        // Delete the associated image file
        if ($item->image && Storage::disk('public')->exists('images/' . $item->image)) {
            Storage::disk('public')->delete('images/' . $item->image);
        }

        $room_id = $item->room_id;
        $item->delete();

        return redirect()->route('admin.rooms', ['id' => $room_id])
            ->with('success', 'Item deleted successfully.');
    }
}
