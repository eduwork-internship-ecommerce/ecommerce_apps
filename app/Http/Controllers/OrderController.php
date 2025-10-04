<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Menampilkan formulir checkout (alamat pengiriman, metode pengiriman, ringkasan).
     */
    public function create()
    {
        $userId = Auth::id();

        // 1. Ambil item keranjang dan hitung subtotal
        $cartItems = CartItem::with('product')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // 2. Ambil data alamat pengguna yang sudah tersimpan (jika ada)
        // Asumsikan Anda memiliki relasi atau tabel alamat terpisah (UserAddress)
        // $userAddresses = Auth::user()->addresses; 

        // 3. Data Kurir/Layanan (Contoh Sederhana)
        $shippingMethods = [
            ['name' => 'Reguler', 'fee' => 15000, 'days' => '3-5 hari'],
            ['name' => 'Ekspres', 'fee' => 30000, 'days' => '1-2 hari'],
        ];

        return view('userPage.checkout.create', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shippingMethods' => $shippingMethods,
            // 'userAddresses' => $userAddresses,
        ]);
    }

}