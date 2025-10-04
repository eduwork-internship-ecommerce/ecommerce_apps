<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key ke tabel users
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade'); 
            
            // Foreign Key ke tabel products
            $table->foreignId('product_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Kuantitas produk di keranjang
            $table->integer('quantity')->default(1);
            
            // Memastikan satu pengguna hanya bisa memiliki satu baris per produk
            $table->unique(['user_id', 'product_id']);
            
            $table->timestamps();
        });
    }

    /**
     * Kembalikan (roll back) migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};