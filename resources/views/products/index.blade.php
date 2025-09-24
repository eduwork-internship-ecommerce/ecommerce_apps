@extends('layouts.mainLayout')

@section('title', 'Daftar Produk')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-center mb-10">🍯 Daftar Produk</h1>

    <!-- 🔍 Search & Filter -->
    <form method="GET" action="{{ route('products.index') }}" class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Search -->
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari produk..." 
               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500">

        <!-- Brand -->
        <select name="brand" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
            <option value="">Pilih Brand</option>
            @foreach($brands as $brand)
                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                    {{ $brand }}
                </option>
            @endforeach
        </select>

        <!-- Category -->
        <select name="category" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
            <option value="">Pilih Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <!-- Button -->
        <button type="submit" 
                class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
            Filter
        </button>
    </form>

    <!-- Produk -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @forelse($products as $product)
            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition p-4 flex flex-col">
                <div class="w-full h-48 overflow-hidden rounded-lg mb-4">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                         class="w-full h-full object-cover hover:scale-105 transition">
                </div>
                <h5 class="text-lg font-semibold mb-2">{{ $product->name }}</h5>
                <p class="text-green-600 font-bold mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="text-gray-500 text-sm mb-4 flex-grow">{{ Str::limit($product->description, 60) }}</p>
                <a href="{{ route('products.show', $product->slug) }}"
                   class="mt-auto bg-yellow-500 text-white text-center py-2 px-4 rounded-lg hover:bg-yellow-600 transition">
                    Lihat Detail
                </a>
            </div>
        @empty
            <p class="col-span-4 text-center text-gray-500">Produk tidak ditemukan.</p>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $products->links() }}
    </div>
</div>
@endsection
