<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     */
    protected $table = 'cart_items';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    // ------------------------------------------------------------------------
    // RELATIONS
    // ------------------------------------------------------------------------

    /**
     * Relasi Many-to-One inverse: Item keranjang dimiliki oleh seorang User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi Many-to-One inverse: Item keranjang merujuk ke sebuah Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}