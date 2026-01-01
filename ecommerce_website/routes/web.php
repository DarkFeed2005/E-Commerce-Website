<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Vendor\ProductController as VendorProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('products', ProductController::class)->only(['index', 'show']);
Route::resource('categories', CategoryController::class)->only(['index', 'show']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/vendors', [VendorController::class, 'index'])->name('vendors.index');
        Route::post('/vendors/{vendor}/approve', [VendorController::class, 'approve'])->name('vendors.approve');
        Route::post('/vendors/{vendor}/suspend', [VendorController::class, 'suspend'])->name('vendors.suspend');
        Route::get('/vendors/{vendor}', [VendorController::class, 'show'])->name('vendors.show');
        Route::delete('/vendors/{vendor}', [VendorController::class, 'destroy'])->name('vendors.destroy');
    });
    
    Route::middleware('role:vendor')->prefix('vendor')->name('vendor.')->group(function () {
        Route::resource('products', VendorProductController::class);
    });
});

require __DIR__.'/auth.php';
