<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');
Route::post('quotes/{quote}/favorite', [QuoteController::class, 'toggleFavorite'])->name('quotes.favorite');
Route::resource('quotes', QuoteController::class);
Route::resource('categories', CategoryController::class)->except('show');
