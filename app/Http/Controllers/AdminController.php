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
}
