<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrCodeController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route::get('/admin', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::get('/', function () {
        return redirect()->route('admin');
    });


    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::get('/admin/floors/{id}', [AdminController::class, 'floors'])->name('admin.floors');
    Route::get('/admin/rooms/{id}', [AdminController::class, 'rooms'])->name('admin.rooms');
    
    Route::get('/admin/items', [AdminController::class, 'createItem'])->name('admin.items.create');
    Route::post('/admin/items', [AdminController::class, 'storeItem'])->name('admin.items.store');
    Route::get('/admin/items/{id}/edit', [AdminController::class, 'editItem'])->name('admin.items.edit');
    Route::put('/admin/items/{id}', [AdminController::class, 'updateItem'])->name('admin.items.update');
    Route::delete('/admin/items/{id}', [AdminController::class, 'destroyItem'])->name('admin.items.delete');
    
    // floor
    Route::get('/admin/floors', [AdminController::class, 'createFloor'])->name('admin.floors.create');
    Route::post('/admin/floors', [AdminController::class, 'storeFloor'])->name('admin.floors.store');
    Route::get('/admin/floors/{id}/edit', [AdminController::class, 'editFloor'])->name('admin.floors.edit');
    Route::put('/admin/floors/{id}', [AdminController::class, 'updateFloor'])->name('admin.floors.update');
    Route::delete('/admin/floors/{id}', [AdminController::class, 'destroyFloor'])->name('admin.floors.delete');
    
    // room
    Route::get('/admin/rooms', [AdminController::class, 'createRoom'])->name('admin.rooms.create');
    Route::post('/admin/rooms', [AdminController::class, 'storeRoom'])->name('admin.rooms.store');
    Route::get('/admin/rooms/{id}/edit', [AdminController::class, 'editRoom'])->name('admin.rooms.edit');
    Route::put('/admin/rooms/{id}', [AdminController::class, 'updateRoom'])->name('admin.rooms.update');
    Route::delete('/admin/rooms/{id}', [AdminController::class, 'destroyRoom'])->name('admin.rooms.delete');
});
Route::get('/admin/items/{id}', [AdminController::class, 'items'])->name('admin.items');
Route::get('/floors/{floor}', [AdminController::class, 'getRoomsByFloor']);

Route::get('/generate-qrcode', 'QrCodeController@generate');
Route::get('/generate-qrcode', [QrCodeController::class, 'generate']);

use App\Http\Controllers\FloorController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ItemController;

Route::get('/floors', [FloorController::class, 'index']);
Route::get('/floors/{floor}/rooms', [RoomController::class, 'index']);


Route::get('/floors/{floor}/rooms', [FloorController::class, 'rooms'])->name('floor.rooms');

Route::get('/rooms/{room}/items', [ItemController::class, 'index']);
Route::get('/rooms/{room}/items', [ItemController::class, 'index'])->name('rooms.items');

Route::get('/items/{item}', [ItemController::class, 'show']);
Route::resource('items', ItemController::class);


Route::get('/rooms/{room}/items/create', 'App\Http\Controllers\ItemController@create')->name('items.create');


Route::get('/items/{item}/edit', 'App\Http\Controllers\ItemController@edit')->name('items.edit');
Route::put('/items/{item}', 'App\Http\Controllers\ItemController@update')->name('items.update');

// routes/web.php
Route::post('/download-qrcode', 'App\Http\Controllers\ItemController@downloadQrCode')->name('download.qrcode');

Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');

// routes/web.php

use App\Http\Controllers\RoomsController;

Route::get('/floors/{floor}/rooms', [RoomController::class, 'index'])->name('floors.rooms.index');
Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
