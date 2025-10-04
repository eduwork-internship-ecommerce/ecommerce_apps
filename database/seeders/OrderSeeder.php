<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use \Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Harga dasar dan tarif yang digunakan untuk perhitungan
        $basePrice = 65000.00;
        $taxRate = 0.10; // 10% PPN
        $user_id = 5;
        
        $now = Carbon::now();

        // --- Hardcode 3 Rows ---
        
        // Order 1: Completed, 3 unit, Tanpa Diskon
        $qty1 = 3;
        $subtotal1 = $basePrice * $qty1; // 195,000.00
        $shipping1 = 15000.00;
        $discount1 = 0.00;
        $tax1 = ($subtotal1 - $discount1) * $taxRate; // 19,500.00
        $grandTotal1 = $subtotal1 - $discount1 + $shipping1 + $tax1; // 229,500.00

        // Order 2: Pending, 2 unit, Tanpa Diskon
        $qty2 = 2;
        $subtotal2 = $basePrice * $qty2; // 130,000.00
        $shipping2 = 10000.00;
        $discount2 = 0.00;
        $tax2 = ($subtotal2 - $discount2) * $taxRate; // 13,000.00
        $grandTotal2 = $subtotal2 - $discount2 + $shipping2 + $tax2; // 153,000.00

        // Order 3: Processing, 6 unit, Dengan Diskon 10%
        $qty3 = 6;
        $subtotal3 = $basePrice * $qty3; // 390,000.00
        $shipping3 = 5000.00;
        $discount3 = $subtotal3 * 0.10; // 39,000.00
        $tax3 = ($subtotal3 - $discount3) * $taxRate; // 35,100.00
        $grandTotal3 = $subtotal3 - $discount3 + $shipping3 + $tax3; // 391,100.00
        
        $orders = [
            // Row 1: COMPLETED (3 x 65,000)
            [
                'user_id' => $user_id,
                'code' => 'ORD-MDH-25A1',
                'status' => 'completed',
                'subtotal' => $subtotal1,
                'shipping_cost' => $shipping1,
                'discount_total' => $discount1,
                'tax_total' => $tax1,
                'grand_total' => $grandTotal1,
                'payment_method' => 'E-Wallet',
                'payment_status' => 'paid',
                'note' => null,
                'placed_at' => $now->copy()->subDays(7),
                'paid_at' => $now->copy()->subDays(6),
                'completed_at' => $now->copy()->subDays(1),
                'created_at' => $now->copy()->subDays(7),
                'updated_at' => $now->copy()->subDays(1),
            ],
            // Row 2: PENDING (2 x 65,000)
            [
                'user_id' => $user_id,
                'code' => 'ORD-MDH-25B2',
                'status' => 'pending',
                'subtotal' => $subtotal2,
                'shipping_cost' => $shipping2,
                'discount_total' => $discount2,
                'tax_total' => $tax2,
                'grand_total' => $grandTotal2,
                'payment_method' => 'Bank Transfer',
                'payment_status' => 'unpaid',
                'note' => 'Menunggu transfer pembayaran.',
                'placed_at' => $now->copy()->subDays(3),
                'paid_at' => null,
                'completed_at' => null,
                'created_at' => $now->copy()->subDays(3),
                'updated_at' => $now->copy()->subDays(3),
            ],
            // Row 3: PROCESSING (6 x 65,000) - Ada Diskon
            [
                'user_id' => $user_id,
                'code' => 'ORD-MIX-25C3',
                'status' => 'processing',
                'subtotal' => $subtotal3,
                'shipping_cost' => $shipping3,
                'discount_total' => $discount3,
                'tax_total' => $tax3,
                'grand_total' => $grandTotal3,
                'payment_method' => 'Credit Card',
                'payment_status' => 'paid',
                'note' => 'Pelanggan VIP',
                'placed_at' => $now->copy()->subDays(1),
                'paid_at' => $now->copy()->subHours(12),
                'completed_at' => null,
                'created_at' => $now->copy()->subDays(1),
                'updated_at' => $now->copy()->subDays(1),
            ],
        ];

        // Masukkan data ke dalam tabel
        DB::table('orders')->insert($orders);
    }
}