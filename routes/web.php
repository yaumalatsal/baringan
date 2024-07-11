<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrCodeController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/generate-qrcode', 'QrCodeController@generate');
Route::get('/generate-qrcode', [QrCodeController::class, 'generate']);
use App\Http\Controllers\FloorController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ItemController;

Route::get('/floors', [FloorController::class, 'index']);
Route::get('/floors/{floor}/rooms', [RoomController::class, 'index']);


Route::get('/floors/{floor}/rooms', [FloorController::class, 'rooms'])->name('floor.rooms');


Route::get('/rooms/{room}/items', [ItemController::class, 'index']);
Route::get('/items/{item}', [ItemController::class, 'show']);
Route::resource('items', ItemController::class);

