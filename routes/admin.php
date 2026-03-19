<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use illuminate\Support\Facades\Route;

Route::get('/', function (){
    return view ('admin.dashboard');
})->name( 'dashboard');

//Gestión de roles
Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);