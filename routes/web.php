<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrCodeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/generate-qrcode', 'QrCodeController@generate');
Route::get('/generate-qrcode', [QrCodeController::class, 'generate']);