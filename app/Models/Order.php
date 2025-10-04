<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     * Secara default Laravel akan menggunakan 'orders', jadi properti ini opsional.
     * @var string
     */
    protected $table = 'orders';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'code',
        'status',
        'subtotal',
        'shipping_cost',
        'discount_total',
        'tax_total',
        'grand_total',
        'payment_method',
        'payment_status',
        'note',
        'placed_at',
        'paid_at',
        'completed_at',
        'canceled_at',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     * DECIMAL (angka) harus di-cast ke float. TIMESTAMP (tanggal) harus di-cast ke datetime.
     * @var array<string, string>
     */
    protected $casts = [
        // Kolom DECIMAL
        'subtotal' => 'float',
        'shipping_cost' => 'float',
        'discount_total' => 'float',
        'tax_total' => 'float',
        'grand_total' => 'float',

        // Kolom TIMESTAMP
        'placed_at' => 'datetime',
        'paid_at' => 'datetime',
        'completed_at' => 'datetime',
        'canceled_at' => 'datetime',
    ];

    // ------------------------------------------------------------------------
    // RELATIONS
    // ------------------------------------------------------------------------

    /**
     * Relasi One-to-Many inverse: Sebuah order dimiliki oleh seorang user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Anda mungkin perlu menambahkan relasi ke OrderItem (jika ada) dan OrderAddress (jika terpisah)
}