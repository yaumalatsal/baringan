<?php

namespace App\Http\Controllers;

use App\Models\Floor;
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
}
