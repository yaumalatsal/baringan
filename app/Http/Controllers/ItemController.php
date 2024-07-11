<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Item;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
    ];

    // Generate response for download
    return response($qrCode, 200, $headers)->download('qr_code.png');
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
        $item = Item::create($request->all());
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
