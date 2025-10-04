<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data produk yang dipetakan dengan ID untuk simulasi
        $products = [
            1 => ['name' => 'Madu Hutan Asli 250ml', 'price' => 65000.00],
            2 => ['name' => 'Madu Kelengkeng 500ml', 'price' => 65000.00],
            3 => ['name' => 'Madu Multiflora 1L', 'price' => 65000.00],
        ];
        $productKeys = array_keys($products);
        $basePrice = 65000.00;

        // Data Subtotal dari 3 Order terakhir (ID: 42, 43, 44)
        $orderData = [
            42 => 195000.00, // Subtotal Order ID 42 (3 unit)
            43 => 130000.00, // Subtotal Order ID 43 (2 unit)
            44 => 390000.00, // Subtotal Order ID 44 (6 unit)
        ];
        
        $now = Carbon::now();
        $items = [];

        foreach ($orderData as $orderId => $totalSubtotal) {
            $totalQuantity = round($totalSubtotal / $basePrice);

            // Jika total kuantitas kecil (<=4) atau ganjil, jadikan 1 item
            // Jika total kuantitas besar dan genap (>=6), pecah menjadi 2 item
            if ($totalQuantity <= 4) {
                // Kasus 1: Hanya 1 jenis item
                $randomProductKey = $productKeys[array_rand($productKeys)];
                $product = $products[$randomProductKey];

                $items[] = [
                    'order_id' => $orderId,
                    'product_id' => $randomProductKey,
                    'product_name_snapshot' => $product['name'],
                    'price_snapshot' => $product['price'],
                    'quantity' => $totalQuantity,
                    'subtotal' => round($totalSubtotal, 2),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            } else {
                // Kasus 2: 2 jenis item (untuk kuantitas 6)
                $qty1 = floor($totalQuantity / 2); // 3
                $qty2 = $totalQuantity - $qty1;    // 3
                
                // Item 1
                $productKey1 = 1; // Madu Hutan
                $product1 = $products[$productKey1];
                $items[] = [
                    'order_id' => $orderId,
                    'product_id' => $productKey1,
                    'product_name_snapshot' => $product1['name'],
                    'price_snapshot' => $product1['price'],
                    'quantity' => $qty1,
                    'subtotal' => round($product1['price'] * $qty1, 2),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                // Item 2 (Pakai produk 3: Madu Multiflora)
                $productKey2 = 3; 
                $product2 = $products[$productKey2];
                $items[] = [
                    'order_id' => $orderId,
                    'product_id' => $productKey2,
                    'product_name_snapshot' => $product2['name'],
                    'price_snapshot' => $product2['price'],
                    'quantity' => $qty2,
                    'subtotal' => round($product2['price'] * $qty2, 2),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Memasukkan array data ke dalam tabel order_items
        DB::table('order_items')->insert($items);
    }
}