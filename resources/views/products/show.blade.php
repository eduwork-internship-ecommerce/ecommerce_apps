@extends('layouts.mainLayout')

@section('title', $product->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Gambar Produk -->
        <div class="bg-white rounded-2xl shadow-md p-5">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-[400px] object-cover rounded-lg">
        </div>

        <!-- Detail Produk -->
        <div class="flex flex-col justify-center">
            <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
            <p class="text-gray-600 mb-4">{{ $product->description }}</p>
            <p class="text-2xl font-bold text-green-600 mb-6">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>

            <div class="flex space-x-4">
                <button class="bg-green-600 text-white px-5 py-3 rounded-lg hover:bg-green-700 transition">
                    🛒 Tambah ke Keranjang
                </button>
                <a href="{{ route('products.index') }}" class="bg-gray-200 text-gray-700 px-5 py-3 rounded-lg hover:bg-gray-300 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
