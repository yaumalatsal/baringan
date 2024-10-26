<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role !== 'ADMIN') {
            return redirect()->route('admin')->with('error', 'You do not have permission to do this action.');
        }
        $floors = Floor::all();
        $users = User::all();

        return view('admin.users.index', compact('floors', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->role !== 'ADMIN') {
            return redirect()->route('admin')->with('error', 'You do not have permission to do this action.');
        }
        $floors = Floor::all();
        return view('admin.users.create', compact('floors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
            'floors' => 'required|array', // Validate that floors are selected
            'floors.*' => 'exists:floors,id'
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Attach selected floors to user
        $user->floors()->sync($request->floors);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (Auth::user()->role !== 'ADMIN') {
            return redirect()->route('admin')->with('error', 'You do not have permission to do this action.');
        }
        $user = User::with('floors')->findOrFail($id);
        $floors = Floor::all();
        return view('admin.users.show', compact('user', 'floors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::user()->role !== 'ADMIN') {
            return redirect()->route('admin')->with('error', 'You do not have permission to do this action.');
        }
        $user = User::with('floors')->findOrFail($id);
        $floors = Floor::all();
        return view('admin.users.edit', compact('user', 'floors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string',
            'floors' => 'required|array', // Ensure floors are selected
            'floors.*' => 'exists:floors,id' // Ensure each selected floor ID exists in floors table
        ]);

        $user = User::findOrFail($id);
        if ($request->password) {
            $password = Hash::make($request->password);
        }else {
            $password = $user->password;
        }
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $password,
            'role' => $request->role,
        ]);

        // Sync selected floors with user
        $user->floors()->sync($request->floors);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->floors()->detach();
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
