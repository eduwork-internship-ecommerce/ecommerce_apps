<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Menambahkan kolom 'stock' setelah 'is_active'
            $table->integer('stock')
                  ->default(0)
                  ->after('is_active'); 
        });
    }

    /**
     * Kembalikan (roll back) migrasi.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Menghapus kolom 'stock'
            $table->dropColumn('stock');
        });
    }
};