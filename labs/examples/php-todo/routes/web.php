<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;

/**
 * Login Routes
 */

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');

/**
 * Other Routes
 */

Route::get('/trash', [ItemController::class, 'trash'])->name('trash')->middleware('auth');
Route::get('/trash/empty', [ItemController::class, 'empty'])->middleware('auth');

/**
 * Item Routes
 */

Route::group(['middleware' => 'auth'], function()
{
    Route::get('/', [ItemController::class, 'index']);
    Route::get('/item', [ItemController::class, 'index'])->name('index');
    Route::get('/item/create', [ItemController::class, 'create']);
    Route::post('/item', [ItemController::class, 'store']);
    Route::get('/item/{item}', [ItemController::class, 'read']);
    Route::get('/item/{item}/edit', [ItemController::class, 'edit'])->name('item.edit');
    Route::put('/item/{item}/restore', [ItemController::class, 'restore'])->name('item.restore');
    Route::put('/item/{item}', [ItemController::class, 'update']);
    Route::delete('/item/{item}', [ItemController::class, 'delete'])->name('item.delete');
});
