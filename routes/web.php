<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GalleryController;

Route::get('/index', function () {
    return view('index');
});



Route::get('edit/{inventoryId}',[GalleryController::class, 'editView'])->name('edit');

Route::get('/show/{inventoryId}', function () {
    return view('show');
});
