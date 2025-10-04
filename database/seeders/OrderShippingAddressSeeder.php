<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderShippingAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Hardcode data alamat pengiriman untuk Order ID 42, 43, dan 44
        $shippingAddresses = [
            // Order ID 42
            [
                'order_id' => 42,
                'recipient_name' => 'Budi Santoso',
                'phone' => '081234567890',
                'address_line' => 'Jl. Anggrek No. 15, RT 01/RW 03',
                'city' => 'Jakarta Timur',
                'province' => 'DKI Jakarta',
                'postal_code' => '13420',
                'country' => 'Indonesia',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Order ID 43
            [
                'order_id' => 43,
                'recipient_name' => 'Siti Aminah',
                'phone' => '085678901234',
                'address_line' => 'Perum. Harmoni Blok C-7',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
                'postal_code' => '40286',
                'country' => 'Indonesia',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            // Order ID 44
            [
                'order_id' => 44,
                'recipient_name' => 'Joko Susilo',
                'phone' => '087890123456',
                'address_line' => 'Komplek Ruko Mega Jaya No. 5',
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
                'postal_code' => '60111',
                'country' => 'Indonesia',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('order_shipping_addresses')->insert($shippingAddresses);
    }
}