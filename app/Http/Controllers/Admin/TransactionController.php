<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // Sesuaikan dengan nama model transaksi Anda

class TransactionController extends Controller
{
    /**
     * Menampilkan daftar transaksi dengan fitur filter dan pencarian.
     * * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function index(Request $request)
{
    // Mendapatkan query dasar dari model
    // UBAH: Gunakan with('items') untuk eagerly load order_items
    $query = Order::with('user', 'orderItems', 'shippingAddress'); 

    // 1. Filter Pencarian (Code atau User ID)
    // ... (Logika filter tetap sama)
    if ($search = $request->get('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('code', 'like', '%' . $search . '%')
              ->orWhere('user_id', $search);
        });
    }

    // 2. Filter Status Pembayaran
    if ($paymentStatus = $request->get('payment_status')) {
        $query->where('payment_status', $paymentStatus);
    }

    // 3. Filter Status Pesanan
    if ($status = $request->get('status')) {
        $query->where('status', $status);
    }

    // Ambil data transaksi dengan pagination, urutkan dari yang terbaru
    $transactions = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

    return view('admin.transactions.index', compact('transactions'));
}
    /**
     * Memperbarui status pembayaran dan status pesanan dari transaksi tertentu.
     * * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'payment_status' => 'required|in:unpaid,paid',
            'status' => 'required|in:pending,processing,completed,canceled',
        ]);

        // Cari Transaksi berdasarkan ID
        $transaction = Order::findOrFail($id);

        // Update status
        $transaction->payment_status = $request->payment_status;
        $transaction->status = $request->status;
        $transaction->save();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.transactions.index')
                         ->with('success', 'Status Transaksi ' . $transaction->code . ' berhasil diperbarui.');
    }
}