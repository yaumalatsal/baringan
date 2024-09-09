<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Item;
use App\Models\ItemLog;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // $rooms = $lantai->rooms->sortBy('name');
        // $rooms = DB::table('rooms')
        // ->select('*')
        // ->where('floor_id',$id)
        // ->orderBy(DB::raw('LENGTH(name), name'))
        // ->get();
        $rooms = $lantai->rooms->sortBy(function($room) {
            // Inisialisasi default untuk number dan suffix
            $number = 0;
            $suffix = '';
        
            // Ekstrak angka dari nama kamar
            if (preg_match('/\d+/', $room->name, $matches)) {
                $number = (int)$matches[0];
                // Ekstrak bagian string setelah angka untuk sorting lebih lanjut jika ada
                $suffix = trim(str_replace($matches[0], '', $room->name));
            }
        
            // Menggabungkan angka dan suffix untuk sorting
            return [$number, $suffix];
        });
        $rooms = $rooms->values();

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

        $item = Item::with('room.floor', 'logs')->find($id);

        return view('admin.items.detail', compact('floors', 'item'));
    }

    public function createItem(Request $request)
    {
        $floors = Floor::all();
        $room_id = $request->query('room_id');
        $room = Room::find($room_id);
        $rooms = Room::where('floor_id', $room->floor_id)->get();


        return view('admin.items.create', compact('floors', 'room_id', 'room', 'rooms'));
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
            'merk' => 'required|string|max:250',
            // 'entry_date' => 'required|date',
            // 'last_checked_date' => 'required|date',
            'condition' => 'required|string|max:255',
            'clean_status' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:100000', // Validasi untuk gambar
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
            'merk' => 'required|string|max:250',
            // 'entry_date' => 'required|date',
            // 'last_checked_date' => 'required|date',
            'condition' => 'required|string|max:255',
            'clean_status' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:204800',
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

        ItemLog::create([
            'item_id' => $item->id,
            'room_id' => $item->room_id,
            'name' => $item->name,
            'code' => $item->code,
            'merk' => $item->merk,
            // 'entry_date' => $item->entry_date,
            // 'last_checked_date' => $item->last_checked_date,
            'condition' => $item->condition,
            'clean_status' => $item->clean_status,
        ]);

        // Redirect with success message
        return redirect()->route('admin.rooms', $item->room_id)
            ->with('success', 'Item updated successfully.');

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


    // floor
    public function createFloor(Request $request)
    {
        $floors = Floor::all();

        return view('admin.floors.create', compact('floors'));
    }

    public function storeFloor(Request $request)
    {
        $floors = Floor::all();
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        Floor::create($validatedData);

        return redirect()->route('admin')
            ->with('success', 'Item deleted successfully.');
    }

    public function editFloor($id)
    {
        $floors = Floor::all();
        $floor = Floor::find($id);

        return view('admin.floors.edit', compact('floors', 'floor'));
    }

    public function updateFloor(Request $request, $id)
    {
        $floor = Floor::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $floor->update($validatedData);

        return redirect()->route('admin')
            ->with('success', 'Floor updated successfully.');
    }

    public function destroyFloor($id)
    {
        $floor = Floor::findOrFail($id);

        // Loop through each room of the floor
        foreach ($floor->rooms as $room) {
            // Loop through each item of the room
            foreach ($room->items as $item) {
                // Delete the item's image if it exists
                if ($item->image) {
                    Storage::delete('public/images/' . $item->image);
                }
                // Delete the item
                $item->delete();
            }
            // Delete the room
            $room->delete();
        }

        // Finally, delete the floor
        $floor->delete();

        return redirect()->route('admin')
            ->with('success', 'Floor and related rooms and items deleted successfully.');
    }


    // room
    public function createRoom(Request $request)
    {
        $floors = Floor::all();
        $floor_id = $request->query('floor_id');

        return view('admin.rooms.create', compact('floors', 'floor_id'));
    }

    public function storeRoom(Request $request)
    {
        $floors = Floor::all();
        $validatedData = $request->validate([
            'floor_id' => 'required',
            'name' => 'required',
            'status' => 'required',
            'patient' => 'required',
        ]);

        Room::create($validatedData);

        return redirect()->route('admin.floors', ['id' => $request->floor_id])
            ->with('success', 'Room Created successfully.');
    }

    public function editRoom($id)
    {
        $floors = Floor::all();
        $room = Room::find($id);

        return view('admin.rooms.edit', compact('floors', 'room'));
    }

    public function updateRoom(Request $request, $id)
    {
        $floors = Floor::all();
        $validatedData = $request->validate([
            'floor_id' => 'required',
            'name' => 'required',
            'status' => 'required',
            'patient' => 'required',
        ]);
        $room = Room::findOrFail($id);
        $room->update($validatedData);

        return redirect()->route('admin.floors', ['id' => $room->floor_id])
            ->with('success', 'Room Updated successfully.');
    }

    public function destroyRoom($id)
    {
        $room = Room::findOrFail($id);
        $floor_id = $room->floor_id;

        // Loop through each item of the room
        foreach ($room->items as $item) {
            // Delete the item's image if it exists
            if ($item->image) {
                Storage::delete('public/images/' . $item->image);
            }
            // Delete the item
            $item->delete();
        }

        // Finally, delete the room
        $room->delete();

        return redirect()->route('admin.floors', ['id' => $room->floor_id])
            ->with('success', 'Room and related items deleted successfully.');
    }

}
