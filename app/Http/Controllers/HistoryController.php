<?php

namespace App\Http\Controllers;

use App\Models\Order; // PENTING: Import model Order
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Menampilkan daftar riwayat pesanan (Index).
     * Sesuai dengan route name 'order.history'
     */
    public function index(Request $request)
    {
        // Mengambil pesanan milik user yang sedang login
        $orders = Order::where('user_id', auth()->id())
                        // Memuat order items untuk tampilan ringkasan
                        ->with('orderItems.product')
                        // Mengurutkan dari yang terbaru
                        ->orderBy('placed_at', 'desc') 
                        // Menggunakan pagination agar tidak terlalu membebani halaman
                        ->paginate(10);

        return view('userPage.history.index', compact('orders'));
    }

    /**
     * Menampilkan detail satu pesanan (Show).
     * Sesuai dengan route name 'order.detail'
     * Laravel secara otomatis menemukan Order berdasarkan {order} menggunakan Route Model Binding
     */
    public function show(Order $order)
    {
        // Guard: Pastikan pesanan adalah milik user yang sedang login
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak. Pesanan ini bukan milik Anda.');
        }

        // Memuat semua relasi yang diperlukan untuk halaman detail
        $order->load('orderItems.product', 'shippingAddress'); 

        // Mengirim data order ke view
        return view('userPage.history.detail', compact('order'));
    }
}