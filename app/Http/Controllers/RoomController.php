<?php


namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Floor;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Floor $floor)
    {
        $rooms = Room::where('floor_id', $floor->id)->get();
        return view('rooms.index', compact('rooms', 'floor'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'floor_id' => 'required',
            'name' => 'required',
        ]);

        Room::create($validatedData);

        return redirect()->route('rooms.index')
            ->with('success', 'Room created successfully.');
    }


    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $room->update($request->all());

        return redirect()->route('rooms.index')
                         ->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')
                         ->with('success', 'Room deleted successfully.');
    }
}

   


