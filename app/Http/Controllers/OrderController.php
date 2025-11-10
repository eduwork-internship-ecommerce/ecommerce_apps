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
     * Nomor WhatsApp tujuan untuk konfirmasi/pemesanan.
     * Ganti dengan nomor WhatsApp admin yang benar.
     * @var string
     */
    protected $adminPhoneNumber = '6289513822017'; // Nomor tujuan WhatsApp (WA Admin/CS)

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
     * Mengarahkan pengguna ke link WhatsApp setelah checkout berhasil dibuat.
     * Ini digunakan setelah pesanan *baru* dibuat dan pengguna dialihkan ke sini.
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

        // 3. Panggil fungsi helper untuk membangun pesan dan melakukan redirect
        return $this->buildWhatsappRedirect($order, 'memesan produk');
    }


    /**
     * Mengarahkan pengguna ke link WhatsApp untuk melanjutkan/mengkonfirmasi pembayaran
     * pesanan yang sudah ada (digunakan oleh tombol "Konfirmasi Pesanan" di riwayat).
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
        // Logika ini penting untuk mencegah konfirmasi berulang pada pesanan yang sudah selesai/dibayar.
        if ($order->status === 'completed' || $order->payment_status === 'paid') {
            return redirect()->route('history.index')->with('warning', 'Pesanan ini sudah dibayar atau diproses lebih lanjut.');
        }

        // 3. Panggil fungsi helper untuk membangun pesan konfirmasi pembayaran
        return $this->buildWhatsappRedirect($order, 'melanjutkan pembayaran');
    }

    /**
     * Helper function untuk membangun pesan WhatsApp dan melakukan redirect.
     * * @param Order $order Objek Order yang akan dikirim
     * @param string $context Konteks pesan (misalnya: 'memesan produk', 'melanjutkan pembayaran')
     * @return RedirectResponse
     */
    protected function buildWhatsappRedirect(Order $order, string $context): RedirectResponse
    {
        // Inisialisasi pesan
        $orderMessage = "";

        // 1. Header Pesan berdasarkan konteks

        $orderMessage .= "Halo Admin, saya telah *berhasil melakukan pembayaran* untuk pesanan ini.\n\n"
            . "Mohon bantuannya untuk dilakukan *verifikasi dan proses lebih lanjut*.\n\n"
            . "Berikut adalah detail pesanan yang saya bayar:\n\n";



        // 2. Detail Pesanan (Ringkasan Penting)
        $orderMessage .= "*Kode Pesanan:* " . $order->code . "\n";
        $orderMessage .= "*Total Pembayaran:* Rp " . number_format($order->grand_total, 0, ',', '.') . "\n";
        $orderMessage .= "Rincian Produk:\n";

        // 3. Loop Order Items
        foreach ($order->orderItems as $item) {
            $productName = $item->product_name_snapshot ?? 'Produk Tidak Diketahui';
            $itemTotal = $item->subtotal;
            $orderMessage .= "• " . $productName . " x " . $item->quantity . " = Rp " . number_format($itemTotal, 0, ',', '.') . "\n";
        }

        // 4. Detail Biaya Lain
        $orderMessage .= "\n----------------------------------\n";
        $orderMessage .= "Subtotal Barang: Rp " . number_format($order->subtotal, 0, ',', '.') . "\n";
        $orderMessage .= "Biaya Pengiriman: Rp " . number_format($order->shipping_cost, 0, ',', '.') . "\n";

        $discountTotal = $order->discount_total ?? 0;
        if ($discountTotal > 0) {
            $orderMessage .= "Diskon: - Rp " . number_format($discountTotal, 0, ',', '.') . "\n";
        }

        $taxAmount = $order->tax_total ?? 0;
        if ($taxAmount > 0) {
            $orderMessage .= "Pajak: Rp " . number_format($taxAmount, 0, ',', '.') . "\n";
        }


        $orderMessage .= "\nTerima kasih atas bantuannya.";



        // 6. Redirect ke WhatsApp
        $encodedMessage = urlencode($orderMessage);
        $whatsappUrl = "https://wa.me/{$this->adminPhoneNumber}?text={$encodedMessage}";

        return redirect()->away($whatsappUrl);
    }
}
