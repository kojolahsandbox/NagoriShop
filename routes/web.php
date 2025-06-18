<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingController;

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

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/{name}/{slug}', [LandingController::class, 'show'])->name('product.show');

Route::get('/{search}/', [LandingController::class, 'search'])->name('product.search');

// 404
Route::fallback(function () {
    return view('404');
});