<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

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

    /**
     * Mengambil data pesanan terakhir yang sudah tersimpan di database, 
     * lalu mengarahkan ke link WhatsApp untuk pembayaran.
     */
    public function processCheckout(): RedirectResponse
    {
        $user = Auth::user();

        // 1. Ambil pesanan terakhir (yang baru saja dibuat) beserta order item-nya.
        $order = Order::where('user_id', $user->id)
            ->with('orderItems')
            ->latest() // Ambil yang paling baru
            ->first();

        // 2. Cek jika pesanan tidak ditemukan atau kosong
        if (!$order || $order->orderItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Pesanan belum ditemukan atau item pesanan kosong.');
        }

        // 3. Bangun pesan WhatsApp menggunakan data dari Order dan OrderItem yang sudah tersimpan
        $orderMessage = "Halo, saya ingin memesan produk dari K-Pop Mart.\n\n"
            . "Kode Pesanan: " . $order->code . "\n"
            . "Rincian Pesanan:\n";

        // Loop melalui Order Items yang sudah tersimpan
        foreach ($order->orderItems as $item) {
            // Menggunakan snapshot data dari order item
            $productName = $item->product_name_snapshot ?? 'Produk Tidak Diketahui';
            $itemTotal = $item->subtotal;

            // Tambahkan detail produk ke pesan WhatsApp
            $orderMessage .= "• " . $productName . " x " . $item->quantity . " = Rp " . number_format($itemTotal, 0, ',', '.') . "\n";
        }

        // 4. Lanjutkan dengan pembuatan pesan WhatsApp menggunakan data Order (menggunakan kolom DB: subtotal, shipping_cost, tax_total, grand_total)
        $orderMessage .= "\n----------------------------------\n"
            . "Subtotal: Rp " . number_format($order->subtotal, 0, ',', '.') . "\n"
            . "Biaya Pengiriman: Rp " . number_format($order->shipping_cost, 0, ',', '.') . "\n";

        $discountTotal = $order->discount_total ?? 0;
        if ($discountTotal > 0) {
            $orderMessage .= "Diskon: - Rp " . number_format($discountTotal, 0, ',', '.') . "\n";
        }

        $taxAmount = $order->tax_total ?? 0;
        if ($taxAmount > 0) {
            // Anggap tax rate tidak perlu ditampilkan jika sudah ada nilai tax_total
            $orderMessage .= "Pajak: Rp " . number_format($taxAmount, 0, ',', '.') . "\n";
        }

        $finalTotal = $order->grand_total; // Ambil total akhir dari kolom grand_total

        $orderMessage .= "Total Pembayaran: Rp " . number_format($finalTotal, 0, ',', '.') . "\n\n"
            . "Mohon info ketersediaan stok dan detail pembayaran. Terima kasih.";

        $encodedMessage = urlencode($orderMessage);
        $phoneNumber = '6289513822017'; // Nomor tujuan
        $whatsappUrl = "https://wa.me/{$phoneNumber}?text={$encodedMessage}";

        return redirect()->away($whatsappUrl);
    }


    /**
     * Mengarahkan pengguna ke link WhatsApp untuk melanjutkan pembayaran
     * pesanan yang sudah ada (digunakan oleh tombol "Lanjutkan Pembayaran").
     *
     * @param string $order_code Kode pesanan (misalnya ORD-1700...)
     * @return RedirectResponse
     */
    public function continuePayment(string $order_code): RedirectResponse
    {
        // 1. Cari pesanan berdasarkan kode pesanan dan pastikan milik user yang login
        $order = Order::where('code', $order_code)
            ->where('user_id', Auth::id())
            ->with('orderItems')
            ->first();

        if (!$order) {
            return redirect()->route('history.index')->with('error', 'Pesanan tidak ditemukan atau Anda tidak memiliki akses.');
        }

        // 2. Pastikan status pesanan masih 'pending' atau 'unpaid'
        if ($order->status !== 'pending' && $order->payment_status !== 'unpaid') {
            return redirect()->route('history.index')->with('warning', 'Pesanan ini sudah dibayar atau diproses lebih lanjut.');
        }

        // 3. Bangun ulang pesan WhatsApp berdasarkan data pesanan yang sudah ada
        $orderMessage = "Halo, saya ingin melanjutkan pembayaran untuk pesanan saya.\n\n"
            . "Kode Pesanan: " . $order->code . "\n"
            . "Rincian Pesanan:\n";

        // Loop melalui Order Items yang sudah tersimpan
        foreach ($order->orderItems as $item) {
            $productName = $item->product_name_snapshot ?? 'Produk Tidak Diketahui';
            $itemTotal = $item->subtotal;
            $orderMessage .= "• " . $productName . " x " . $item->quantity . " = Rp " . number_format($itemTotal, 0, ',', '.') . "\n";
        }

        // Rincian total (Menggunakan nama kolom: subtotal, shipping_cost, tax_total, grand_total)
        $orderMessage .= "\n----------------------------------\n"
            . "Subtotal: Rp " . number_format($order->subtotal, 0, ',', '.') . "\n"
            . "Biaya Pengiriman: Rp " . number_format($order->shipping_cost, 0, ',', '.') . "\n";

        // Diskon (jika ada)
        $discountTotal = $order->discount_total ?? 0;
        if ($discountTotal > 0) {
            $orderMessage .= "Diskon: - Rp " . number_format($discountTotal, 0, ',', '.') . "\n";
        }

        // Pajak
        if ($order->tax_total > 0) {
            $orderMessage .= "Pajak: Rp " . number_format($order->tax_total, 0, ',', '.') . "\n";
        }

        $orderMessage .= "Total Pembayaran: Rp " . number_format($order->grand_total, 0, ',', '.') . "\n\n"
            . "Mohon konfirmasi detail pembayaran. Terima kasih.";

        // 4. Redirect ke WhatsApp
        $encodedMessage = urlencode($orderMessage);
        $phoneNumber = '6289513800000'; // Nomor tujuan WhatsApp
        $whatsappUrl = "https://wa.me/{$phoneNumber}?text={$encodedMessage}";

        return redirect()->away($whatsappUrl);
    }
}
