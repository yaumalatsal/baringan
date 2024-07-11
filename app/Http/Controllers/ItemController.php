<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Item;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;

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

    public function downloadQrCode(Request $request)
    {
        $url = $request->input('url');
    
        // Generate QR Code
        $qrCode = QrCode::format('png')->size(200)->generate($url);
    
        // Set headers for file download
        $headers = [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="qr_code.png"',
        ];
    
        // Generate response for download
        return Response::make($qrCode, 200, $headers);
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
        return redirect()->route('rooms.items', ['room' => $item->room_id])
            ->with('success', 'Item updated successfully.');
    }

    public function create(Room $room)
    {
        return view('items.create', compact('room'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'entry_date' => 'required|date',
            'last_checked_date' => 'required|date',
            'item_condition' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar
            'room_id' => 'required|exists:rooms,id', // Pastikan room_id valid
            'floor_id' => 'required|exists:floors,id', // Pastikan floor_id valid
        ]);
    
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
    
        return redirect()->route('rooms.items', ['room' => $item->room_id])
            ->with('success', 'Item created successfully.');
    }


    public function destroy(Item $item)
{
    $room_id = $item->room_id; // Simpan room_id sebelum menghapus item
    $item->delete();
    return redirect()->route('rooms.items', ['room' => $room_id])
        ->with('success', 'Item deleted successfully');
}


}
