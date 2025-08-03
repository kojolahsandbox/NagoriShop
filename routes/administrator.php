<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdministratorController;

Route::get('/administrator/login', [AuthController::class, 'AdministratorShowLoginForm'])->name('AdministratorLogin');
Route::post('/administrator/login', [AuthController::class, 'login']);

// Group dengan prefix 'admin' dan middleware 'auth' jika perlu
Route::middleware(['web', 'auth', 'role:administrator'])->prefix('administrator')->group(function () {
    Route::get('/', [AdministratorController::class, 'index'])->name('administrator');

    Route::get('/users', function () {
        return 'Manajemen Pengguna';
    })->name('admin.users');
});
