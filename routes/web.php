<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductDummyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\OrderController;

// route user
Route::get('/', [ProductDummyController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Routes Alamat
    Route::post('/profile/address', [ProfileController::class, 'storeAddress'])->name('profile.address.store');
    Route::delete('/profile/address/{address}', [ProfileController::class, 'destroyAddress'])->name('profile.address.destroy');

    // CRUD untuk Keranjang
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
    // Proses Checkout
    // Mengganti CartController@checkout menjadi CartController@redirectToCheckoutForm
    Route::post('/cart/checkout-redirect', [CartController::class, 'redirectToCheckoutForm'])->name('cart.checkout.redirect');

    // Routes untuk Order (Halaman Checkout dan Proses Penyimpanan)
    Route::controller(OrderController::class)->prefix('checkout')->name('order.')->group(function () {
        Route::get('/', 'create')->name('create'); // Menampilkan Form Checkout
    });
});

// Route Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('/products', AdminProductController::class);
});



require __DIR__ . '/auth.php';
