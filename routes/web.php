<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductCardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\Admin\TransactionController;

// --------------------------------------------------------
// WEBHOOK/NOTIFICATION MIDTRANS - HARUS DI LUAR MIDDLEWARE APAPUN
// Midtrans harus bisa mengakses ini tanpa harus login.
Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler'])->name('midtrans.notification');
// --------------------------------------------------------

// route user
Route::get('/', [ProductCardController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/tentang-kami', function () {
    return view('userPage.about-us.index'); // Memuat file about-us.blade.php
})->name('about.us');

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
    Route::post('/cart/checkout-redirect', [CartController::class, 'redirectToCheckoutForm'])->name('cart.checkout.redirect');


    // Routes untuk Order (Halaman Checkout dan Proses Penyimpanan)
    Route::controller(OrderController::class)->prefix('checkout')->name('order.')->group(function () {
        Route::get('/', 'create')->name('create'); // Menampilkan Form Checkout
    });
    
    // --- PENAMBAHAN ROUTE BARU DI SINI ---
    Route::get('/order-history', [HistoryController::class, 'index'])->name('order.history');
    Route::get('/order-history/{order}', [HistoryController::class, 'show'])->name('order.detail'); // Route DETAIL PESANAN
    // --- AKHIR PENAMBAHAN ROUTE BARU ---
    
    // Rute untuk Lanjutkan Pembayaran (dari riwayat pesanan)
    Route::get('/payment/continue/{order_code}', [OrderController::class, 'continuePayment'])
        ->name('payment.continue');

    // Midtrans Rute untuk memproses pembayaran Midtrans dan menyimpan Order
    Route::post('/checkout/pay', [MidtransController::class, 'createTransaction'])->name('checkout.pay');
    // Rute untuk menyimpan alamat pengiriman
    Route::post('/checkout/save-address', [MidtransController::class, 'saveShippingAddress'])->name('checkout.save_address');

    // Rute finish/redirect (dipanggil setelah user selesai di halaman pembayaran Midtrans)
    Route::get('/checkout/finish/{order_code}', [MidtransController::class, 'finishPayment'])->name('checkout.finish');
});

// Route Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('/users', UserController::class);
    Route::resource('/products', AdminProductController::class)->except(['show']);
    Route::resource('/categories', AdminCategoryController::class);
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    Route::put('/transactions/{id}/update-status', [TransactionController::class, 'updateStatus'])->name('transactions.updateStatus');
});



require __DIR__ . '/auth.php';