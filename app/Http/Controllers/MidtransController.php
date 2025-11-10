<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // PENTING: Import untuk debugging Webhook
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderShippingAddress;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Validation\ValidationException;

class MidtransController extends Controller
{
    /**
     * Menyimpan detail alamat ke session.
     */
    public function saveShippingAddress(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated.'], 401);
        }

        try {
            $validated = $request->validate([
                'recipient_name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'address_line' => 'required|string',
                'city' => 'required|string|max:255',
                'province' => 'required|string|max:255',
                'postal_code' => 'required|string|max:10',
            ]);

            // Simpan data alamat ke dalam Session
            $request->session()->put('shipping_data', $validated);

            return response()->json(['message' => 'Alamat Pengiriman berhasil disimpan.']);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validasi gagal: ' . json_encode($e->errors())], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menyimpan alamat. Pesan: ' . $e->getMessage()], 500);
        }
    }


    /**
     * Membuat transaksi Midtrans dan menyimpan data Order.
     */
    public function createTransaction(Request $request)
    {
        $user = auth()->user();
        $shippingData = $request->session()->get('shipping_data');

        if (!$user) {
            return response()->json(['error' => 'User not authenticated.'], 401);
        }

        if (!$shippingData) {
            return response()->json(['error' => 'Data alamat pengiriman belum disimpan. Harap simpan alamat terlebih dahulu.'], 400);
        }

        $request->validate([
            'shipping_method' => 'required|string|max:255',
            'shipping_fee_value' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:1',
        ]);

        $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();
        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Keranjang kosong. Tidak dapat melanjutkan checkout.'], 400);
        }

        $subtotalOrder = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shippingFee = (int) $request->shipping_fee_value;
        $taxRate = 0.11;
        $taxTotal = round($subtotalOrder * $taxRate);
        $grandTotal = $subtotalOrder + $shippingFee + $taxTotal;

        if ((int)$request->total != $grandTotal) {
            return response()->json(['error' => 'Gagal verifikasi total pembayaran. Hitungan tidak cocok.'], 400);
        }

        $orderCode = 'ORD-' . time() . '-' . rand(100, 999);
        $midtransItems = [];

        DB::beginTransaction();

        try {
            // 3. Simpan Data Pesanan (Order)
            $order = Order::create([
                'user_id' => $user->id,
                'code' => $orderCode,
                'status' => 'pending',
                'subtotal' => $subtotalOrder,
                'shipping_cost' => $shippingFee,
                'discount_total' => 0.00,
                'tax_total' => $taxTotal,
                'grand_total' => $grandTotal,
                'payment_method' => 'Midtrans',
                'payment_status' => 'unpaid',
                'placed_at' => now(),
            ]);

            // Simpan Order Items & Midtrans Items
            foreach ($cartItems as $item) {
                $itemSubtotal = $item->product->price * $item->quantity;
                $order->orderItems()->create([
                    'product_id' => $item->product_id,
                    'product_name_snapshot' => $item->product->name,
                    'price_snapshot' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $itemSubtotal,
                ]);
                $midtransItems[] = [
                    'id' => $item->product_id,
                    'price' => (int) $item->product->price,
                    'quantity' => (int) $item->quantity,
                    'name' => $item->product->name,
                ];
            }

            // Simpan Alamat Pengiriman
            $order->shippingAddress()->create([
                'recipient_name' => $shippingData['recipient_name'],
                'phone' => $shippingData['phone'],
                'address_line' => $shippingData['address_line'],
                'city' => $shippingData['city'],
                'province' => $shippingData['province'],
                'postal_code' => $shippingData['postal_code'],
                'country' => 'Indonesia',
            ]);

            $midtransItems[] = ['id' => 'SHIPPING', 'price' => $shippingFee, 'quantity' => 1, 'name' => 'Biaya Pengiriman'];
            $midtransItems[] = ['id' => 'TAX', 'price' => $taxTotal, 'quantity' => 1, 'name' => 'PPN 11%'];


            // 4. Konfigurasi Midtrans & Dapatkan Snap Token
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            $params = [
                'transaction_details' => ['order_id' => $orderCode, 'gross_amount' => (int) $grandTotal,],
                'customer_details' => [
                    'first_name' => $shippingData['recipient_name'],
                    'email' => $user->email,
                    'phone' => $shippingData['phone'],
                ],
                'item_details' => $midtransItems,
                'callbacks' => ['finish' => route('checkout.finish', ['order_code' => $orderCode]),]
            ];

            $snapToken = Snap::getSnapToken($params);

            DB::commit();

            // 5. Hapus Keranjang & Session
            CartItem::where('user_id', $user->id)->delete();
            $request->session()->forget('shipping_data');

            return response()->json(['snapToken' => $snapToken, 'order_code' => $orderCode]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Midtrans Transaction Creation Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString(), 'user_id' => $user->id ?? 'N/A']);
            return response()->json(['error' => 'Gagal memproses transaksi. Pesan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Midtrans Notification Handler (Webhook)
     * Mengupdate status pesanan berdasarkan notifikasi dari Midtrans.
     */
    public function notificationHandler(Request $request)
    {
        // PENTING: Log payload Midtrans untuk debugging
        Log::info('Midtrans Notification Received', ['payload' => $request->all()]);

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');

        try {
            $notif = new Notification();
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Parsing Error', ['message' => $e->getMessage()]);
            return response()->json(['message' => 'Invalid Midtrans Notification'], 400);
        }

        $transactionStatus = $notif->transaction_status;
        $orderId = $notif->order_id;
        $fraudStatus = $notif->fraud_status;

        $order = Order::where('code', $orderId)->first();

        if (!$order) {
            Log::warning("Order {$orderId} not found in DB.");
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($order->payment_status == 'paid' || $order->status == 'completed' || $order->status == 'canceled') {
            return response()->json(['message' => 'Order status already finalized'], 200);
        }

        // Mulai logika pembaruan status
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                // Kartu Kredit/Debit yang berhasil
                $order->payment_status = 'paid';
                $order->status = 'completed'; // Berubah menjadi COMPLETED
                $order->paid_at = now();
            }
        } elseif ($transactionStatus == 'settlement') {
            // Transfer Bank, E-Wallet, dll. yang berhasil
            $order->payment_status = 'paid';
            $order->status = 'completed'; // Berubah menjadi COMPLETED
            $order->paid_at = now();
        } elseif ($transactionStatus == 'pending') {
            $order->payment_status = 'unpaid';
            $order->status = 'pending';
        } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $order->payment_status = 'unpaid';
            $order->status = 'canceled';
            $order->canceled_at = now();
        }

        $order->payment_method = $notif->payment_type;
        $order->save();
        
        // Log sukses
        Log::info("Order {$orderId} status updated successfully. New status: {$order->status}, New payment_status: {$order->payment_status}");

        // PENTING: Balas dengan HTTP 200 OK agar Midtrans menganggap notifikasi berhasil diterima
        return response()->json(['message' => 'Notification processed successfully'], 200);
    }

    /**
     * Callback setelah user selesai di halaman Midtrans Snap.
     */
public function finishPayment(Request $request, $order_code)
    {
        $order = Order::where('code', $order_code)->first();

        if (!$order) {
            return redirect('/')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Jika pembayaran berhasil (status sudah di-update oleh Webhook)
        // if ($order->payment_status == 'paid') {
        //     // REDIRECT KE HALAMAN KERANJANG (cart.index)
        //     return redirect()->route('cart.index')->with('success', 'Pembayaran berhasil! Keranjang Anda telah dikosongkan.');
        // }

        // Jika pembayaran masih menunggu (pending)
        // REDIRECT KE HALAMAN KERANJANG (cart.index)
        return redirect()->route('cart.index')->with('info', 'Pembayaran sedang menunggu konfirmasi.');
    }
}