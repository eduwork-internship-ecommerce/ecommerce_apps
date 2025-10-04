<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderShippingAddress extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     * Asumsi nama tabel adalah 'order_shipping_addresses' atau sejenisnya.
     * Jika nama tabel Anda berbeda, ganti nilai ini.
     * @var string
     */
    protected $table = 'order_shipping_addresses';

    /**
     * Atribut yang dapat diisi secara massal.
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'recipient_name',
        'phone',
        'address_line',
        'city',
        'province',
        'postal_code',
        'country',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     * @var array<string, string>
     */
    protected $casts = [
        //
    ];

    // ------------------------------------------------------------------------
    // RELATIONS
    // ------------------------------------------------------------------------

    /**
     * Relasi Many-to-One inverse: Alamat pengiriman dimiliki oleh sebuah pesanan (Order).
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}