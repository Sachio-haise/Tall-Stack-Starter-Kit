<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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


Route::resource('roles', Admin\RolesController::class, ['parameters' => ['roles' => 'id'], 'except' => ['show']]);
    Route::controller(Admin\RolesController::class)->group(function () {
        Route::any('roles/search', 'search')->name('roles.search');
        Route::get('roles/{id}/restore', 'restore')->name('roles.restore');
});

Route::resource('items', Admin\ItemController::class, ['parameters' => ['items' => 'id'], 'except' => ['show']]);
Route::controller(Admin\ItemController::class)->group(function () {
    Route::any('items/search', 'search')->name('items.search');
    Route::get('items/{id}/restore', 'restore')->name('items.restore');
});
