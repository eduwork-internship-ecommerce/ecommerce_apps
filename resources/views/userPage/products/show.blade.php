@extends('layouts.mainLayout')

@section('title', $product->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <div class="bg-white rounded-2xl shadow-md p-5">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-[400px] object-cover rounded-lg">
        </div>

        <div class="flex flex-col justify-center">
            <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
            <p class="text-gray-600 mb-4">{{ $product->description }}</p>
            <p class="text-2xl font-bold text-green-600 mb-6">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>

            <div class="flex space-x-4">
                <button id="addToCartButton" class="bg-green-600 text-white px-5 py-3 rounded-lg hover:bg-green-700 transition">
                    🛒 Tambah ke Keranjang
                </button>
                <a href="{{ route('products.index') }}" class="bg-gray-200 text-gray-700 px-5 py-3 rounded-lg hover:bg-gray-300 transition">
                    ← Kembali
                </a>
            </div>
            
            <p class="text-sm text-gray-500 mt-4">Stok tersedia: {{ $product->stock ?? 'Tidak Diketahui' }}</p>
        </div>
    </div>
</div>

<div id="quantityModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-6 shadow-xl w-full max-w-sm">
        <h2 class="text-xl font-semibold mb-4">Pilih Kuantitas</h2>
        
        <form id="addToCartForm" method="POST" action="{{ route('cart.store') }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah:</label>
                <input type="number" 
                       id="quantity" 
                       name="quantity" 
                       min="1" 
                       max="{{ $product->stock ?? 999 }}" 
                       value="1" 
                       required 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                @error('quantity')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" id="cancelButton" class="px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100 transition">
                    Cancel
                </button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    Masukkan Keranjang
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Logika JavaScript untuk mengontrol modal
    const modal = document.getElementById('quantityModal');
    const openButton = document.getElementById('addToCartButton');
    const cancelButton = document.getElementById('cancelButton');

    // Tampilkan modal
    openButton.addEventListener('click', () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });

    // Sembunyikan modal
    cancelButton.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });
</script>
@endsection