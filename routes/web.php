<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TerrainController;

Route::resource('terrains', TerrainController::class);

Route::get('/', function () {
    return view('welcome');
});
