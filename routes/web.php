<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\SettingsController;

Route::middleware(['guest'])->group(function () {
    Route::redirect('/','login');
    Route::get('login', [LoginController::class,'index'])->name('login');
    Route::post('login', [LoginController::class,'login']);
});

Route::middleware(['auth'])->group(function () {
  Route::get('logout', [LoginController::class,'logout'])->name('logout');
});

Route::middleware(['auth'])->group(function () {

  Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

  Route::post('withdrawn/store',[DashboardController::class,'withdrawnStore'])->name('withdrawn.store');

  Route::get('profile',[ProfileController::class,'index'])->name('profile');
  Route::post('profile/{user}',[ProfileController::class,'update'])->name('profile.update');
  
  Route::get('role',[RoleController::class,'index'])->name('role');
  Route::get('role/create',[RoleController::class,'create'])->name('role.create');
  Route::post('role',[RoleController::class,'store'])->name('role.store');
  Route::get('role/{role}',[RoleController::class,'edit'])->name('role.edit');
  Route::patch('role/{role}',[RoleController::class,'update'])->name('role.update');
  Route::post('role/{role}/delete',[RoleController::class,'delete'])->name('role.delete');

  Route::get('permission',[PermissionController::class,'index'])->name('permission');
  Route::post('permission',[PermissionController::class,'store'])->name('permission.store');
  Route::get('permission/{permission}/edit',[PermissionController::class,'edit'])->name('permission.edit');
  Route::patch('permission/{permission}',[PermissionController::class,'update'])->name('permission.update');
  Route::post('permission/{permission}/delete',[PermissionController::class,'delete'])->name('permission.delete');

  Route::get('user',[UserController::class,'index'])->name('user');
  Route::post('user',[UserController::class,'store'])->name('user.store');
  Route::get('user/{user}/edit',[UserController::class,'edit'])->name('user.edit');
  Route::patch('user/{user}',[UserController::class,'update'])->name('user.update');
  Route::post('user/{user}/delete',[UserController::class,'delete'])->name('user.delete');
  Route::get('about',[UserController::class,'about'])->name('about');

  Route::get('/log',[ActivityLogController::class,'index'])->name('log');

  Route::get('/settings',[SettingsController::class,'index'])->name('settings');
  Route::patch('/settings',[SettingsController::class,'update'])->name('settings');
  Route::get('/cache',[SettingsController::class,'cache'])->name('cache');
  Route::get('/change/password',[SettingsController::class,'updatePasswordForm'])->name('update.password');
  Route::post('/change/password',[SettingsController::class,'updatePassword']);
});

// Route::fallback(function() { return view('errors.404'); });