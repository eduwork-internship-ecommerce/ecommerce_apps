<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class MidtransController extends Controller
{
   public function createTransaction(Request $request)
{
    try {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . time(),
                'gross_amount' => (int) $request->total, // pastikan integer
            ],
            'customer_details' => [
                'first_name' => $request->recipient_name ?? 'Guest',
                'email' => $request->email ?? 'example@mail.com',
                'phone' => $request->phone ?? '000',
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return response()->json(['snapToken' => $snapToken]);
    } catch (\Exception $e) {
        // tampilkan error jelas di console
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
