@extends('layouts.mainLayout')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold mb-8">Keranjang Belanja Anda ({{ $cartItems->count() }} Item)</h1>

    @if ($cartItems->isEmpty())
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
        <p class="font-bold">Keranjang Kosong</p>
        <p>Anda belum menambahkan produk apapun ke keranjang. Mari mulai berbelanja!</p>
        <a href="{{ route('products.index') }}" class="text-yellow-800 underline mt-2 inline-block">Lihat Produk</a>
    </div>
    @else
    <div class="flex flex-col lg:flex-row gap-8">

        <div class="w-full lg:w-3/4">
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kuantitas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($cartItems as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16">
                                        <img class="h-16 w-16 rounded object-cover" src="{{ $item->product->image_url ?? 'default-image.png' }}" alt="{{ $item->product->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                        <div class="text-xs text-gray-500">Brand: {{ $item->product->brand ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                Rp {{ number_format($item->product->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="number"
                                    value="{{ $item->quantity }}"
                                    min="1"
                                    class="w-16 border rounded text-center text-sm"
                                    {{-- Tambahkan logic JS untuk update cart di sini --}}>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-xs">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="w-full lg:w-1/4">
            <div class="bg-white p-6 shadow-lg rounded-xl sticky top-4">
                <h2 class="text-xl font-bold mb-4 border-b pb-2">Ringkasan Pesanan</h2>

                <div class="flex justify-between text-gray-700 mb-2">
                    <span>Subtotal Item ({{ $cartItems->count() }}):</span>
                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>

                <div class="flex justify-between font-bold text-lg pt-3 border-t mt-4">
                    <span>Total:</span>
                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>

                <form action="{{ route('cart.checkout.redirect') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full mt-6 bg-[var(--dark-gold)] text-[var(--deep-brown)] py-3 rounded-lg hover:bg-[var(--light-gold)] transition font-semibold">
                        Lanjut ke Checkout 🚀
                    </button>
                </form>
            </div>
        </div>

    </div>
    @endif
</div>
@endsection