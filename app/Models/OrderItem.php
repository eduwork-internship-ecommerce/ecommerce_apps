<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     * @var string
     */
    protected $table = 'order_items';

    /**
     * Atribut yang dapat diisi secara massal.
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name_snapshot',
        'price_snapshot',
        'quantity',
        'subtotal',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     * @var array<string, string>
     */
    protected $casts = [
        'price_snapshot' => 'float',
        'subtotal' => 'float',
        'quantity' => 'integer',
    ];

    // ------------------------------------------------------------------------
    // RELATIONS
    // ------------------------------------------------------------------------

    /**
     * Relasi Many-to-One inverse: Item pesanan dimiliki oleh sebuah pesanan (Order).
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    /**
     * Relasi Many-to-One: Item pesanan terhubung ke produk (untuk referensi cepat).
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}