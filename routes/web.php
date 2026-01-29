<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StartupsController;

Route::get('/startups', [StartupsController::class, 'index'])->name('index');
Route::get('/startups/novo', [StartupsController::class, 'create'])->name('create');
Route::post('/startups', [StartupsController::class, 'store'])->name('store');
Route::put('/startups/{id}', [StartupsController::class, 'update'])->name('update');
Route::delete('/startups/{id}', [StartupsController::class, 'destroy'])->name('destroy');