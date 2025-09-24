<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'brand',
        'image_url',
    'price',
        'is_active',
    ];

    // relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
