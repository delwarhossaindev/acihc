<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\System\DatabaseController;
use App\Http\Controllers\System\BatchController;

Route::get('database', [DatabaseController::class, 'index'])
    ->name('database.index')
    ->middleware('auth');

// Route::get('database', [BatchController::class, 'index'])
//     ->name('database.index')
//     ->middleware('auth');
