<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Menambahkan atau memperbarui item di keranjang pengguna.
     */
    public function index()
    {
        // 1. Ambil ID pengguna yang sedang login
        $userId = Auth::id();

        // 2. Ambil semua item keranjang milik pengguna tersebut.
        // Eager load relasi 'product' agar bisa mengakses detail produk (image, name, brand, price).
        $cartItems = CartItem::with('product')
            ->where('user_id', $userId)
            ->get();

        // 3. Hitung total sementara (subtotal)
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('userPage.cart.index', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = auth()->id();
        $productId = $request->product_id;
        $quantity = $request->quantity;

        // 1. Cek apakah item sudah ada di keranjang
        $cartItem = CartItem::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        // 2. Cek Stok Produk (Penting untuk E-Commerce)
        $product = Product::find($productId);
        if ($quantity > $product->stock) {
            return back()->with('error', 'Kuantitas melebihi stok yang tersedia.');
        }

        if ($cartItem) {
            // Item sudah ada, update kuantitas (misalnya, tambahkan)
            $cartItem->quantity += $quantity;
            // Cek ulang total kuantitas terhadap stok
            if ($cartItem->quantity > $product->stock) {
                $cartItem->quantity = $product->stock; // Batasi ke stok maksimum
            }
            $cartItem->save();
        } else {
            // Item belum ada, buat item baru
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function redirectToCheckoutForm()
    {
        // Cek apakah keranjang kosong
        $userId = auth()->id();
        if (CartItem::where('user_id', $userId)->doesntExist()) {
            return back()->with('error', 'Keranjang Anda kosong. Tidak dapat melanjutkan checkout.');
        }

        // Arahkan ke OrderController@create (tempat formulir checkout)
        return redirect()->route('order.create');
    }
    /**
     * Logika untuk memproses checkout dan membersihkan keranjang.
     */
    public function checkout(Request $request)
    {
        // PENTING: Logika checkout utama (membuat Order dan Order Items) diletakkan di sini.
        // Asumsikan proses pembuatan Order, Order Items, dan update Stok Produk SUDAH BERHASIL.

        $userId = auth()->id();

        DB::beginTransaction();

        try {
            // 1. Ambil semua item dari keranjang pengguna
            $cartItems = CartItem::where('user_id', $userId)->get();

            if ($cartItems->isEmpty()) {
                return back()->with('error', 'Keranjang Anda kosong!');
            }

            // 2. Pindahkan data dari $cartItems ke tabel Orders dan OrderItems
            // ... [Lakukan proses pembuatan Order $order dan Order Items di sini] ...

            // 3. Hapus Item dari Tabel Keranjang (Logika yang Diminta)
            CartItem::where('user_id', $userId)->delete();

            DB::commit();

            return redirect()->route('order.confirmation', ['order' => $order->id])
                ->with('success', 'Checkout berhasil! Pesanan Anda telah dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Biasanya, di sini akan ada penanganan stok, pembayaran, dll.
            return back()->with('error', 'Checkout gagal. Silakan coba lagi.');
        }
    }
    /**
     * Menghapus item dari keranjang belanja berdasarkan ID item.
     */
    public function destroy(string $id)
    {
        // 1. Cari CartItem berdasarkan ID yang diberikan
        $cartItem = CartItem::findOrFail($id);

        // 2. Pastikan item tersebut adalah milik pengguna yang sedang login
        // Ini adalah langkah keamanan yang sangat penting.
        if ($cartItem->user_id !== auth()->id()) {
            // Jika bukan miliknya, kembalikan dengan pesan error atau kirim 403 Forbidden
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus item ini.');
        }

        // 3. Hapus item
        $cartItem->delete();

        // 4. Redirect kembali ke halaman keranjang dengan pesan sukses
        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
