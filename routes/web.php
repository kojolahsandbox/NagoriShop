<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Mail\RegisterMail;

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
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register'])->name('register');
//verfication
Route::get('/verify/{token}', [AuthController::class, 'verify'])->name('verify');


Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/{name}/{slug}', [LandingController::class, 'show'])->name('product.show');

Route::get('/search', [LandingController::class, 'search'])->name('product.search');

// Administrator only
Route::middleware(['auth', 'role:administrator'])->group(function () {
    Route::get('/admin', function () {
        return 'Admin Dashboard';
    });
});

// Seller only
Route::middleware(['auth', 'role:seller'])->group(function () {
    Route::get('/seller', function () {
        return 'Seller Dashboard';
    });
});

// Customer only
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer', function () {
        return 'customer profil';
    });

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile_update');

    Route::post('/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
});

// Multi-role access (admin or seller)
Route::middleware(['auth', 'role:administrator,seller'])->group(function () {
    Route::get('/reports', function () {
        return 'Reports for Admin or Seller';
    });
});




// 404
Route::fallback(function () {
    return view('404');
});

Route::get('/test-email', function () {
    $data = [
        'name' => 'Test User',
        'verification_code' => '12345',
    ];
    Mail::to('aqilrahman23@gmail.com')->send(new RegisterMail($data));

    return 'Email telah dikirim.';
});