<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;

Route::get('/administrator/login', [AuthController::class, 'AdministratorShowLoginForm'])->name('AdministratorLogin');
Route::post('/administrator/login', [AuthController::class, 'login']);

// Group dengan prefix 'admin' dan middleware 'auth' jika perlu
Route::middleware(['web', 'auth', 'role:administrator'])->prefix('administrator')->group(function () {
    Route::get('/', [AdministratorController::class, 'index'])->name('administrator');

    Route::get('/users', function () {
        return 'Manajemen Pengguna';
    })->name('admin.users');

    Route::resource('products', ProductController::class);

    Route::resource('customers', CustomerController::class)->only([
        'index',
        'destroy'
    ])->names([
                'index' => 'customers.index',
                'destroy' => 'customers.destroy',
            ]);

    Route::resource('orders', OrderController::class)->names([
        'index' => 'orders.index',
        'show' => 'orders.show',
        'update' => 'orders.update',
    ]);
});
