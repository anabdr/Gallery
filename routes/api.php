<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GalleryController;



Route::post('/gallery',[GalleryController::class,'store']);

Route::get('index/{posicion}',[GalleryController::class ,'index']);

Route::get('search/{inventoryId]',[GalleryController::class,'search']);

Route::put('edit',[GalleryController::class, 'edit']);


