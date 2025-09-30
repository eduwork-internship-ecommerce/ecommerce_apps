@extends('layouts.mainLayout')

@section('title', 'Halaman Checkout')

@section('content')
<div class="container mx-auto p-4 md:p-8">

    {{-- Pesan Error/Sukses --}}
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Gagal!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <h1 class="text-3xl font-bold mb-6 text-gray-800 border-b pb-2">Konfirmasi Checkout</h1>

    <form id="checkoutForm" method="POST" action="#" class="flex flex-col lg:flex-row gap-8">
        @csrf

        {{-- Kolom Kiri: Input Data --}}
        <div class="lg:w-2/3 space-y-8">
            {{-- Bagian 1: Alamat Pengiriman --}}
            <div class="bg-white p-6 shadow-md rounded-lg border">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">1. Detail Pengiriman 🚚</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="recipient_name" class="block text-sm font-medium text-gray-700">Nama Penerima</label>
                        <input type="text" id="recipient_name" name="recipient_name" value="{{ old('recipient_name') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        @error('recipient_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <div class="mt-4">
                    <label for="address_line" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                    <textarea id="address_line" name="address_line" rows="3" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">{{ old('address_line') }}</textarea>
                    @error('address_line') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                        <input type="text" id="city" name="city" value="{{ old('city') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700">Provinsi</label>
                        <input type="text" id="province" name="province" value="{{ old('province') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        @error('province') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                        <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                        @error('postal_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <div class="mt-4">
                    <label for="note" class="block text-sm font-medium text-gray-700">Catatan Tambahan (Opsional)</label>
                    <textarea id="note" name="note" rows="2" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">{{ old('note') }}</textarea>
                </div>
            </div>

            {{-- Bagian 2: Metode Pengiriman --}}
            <div class="bg-white p-6 shadow-md rounded-lg border">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">2. Pilih Kurir & Layanan 📦</h2>
                <div class="space-y-3">
                    @foreach($shippingMethods as $method)
                        <label class="flex items-center space-x-3 cursor-pointer p-3 border rounded-md hover:bg-gray-50">
                            <input type="radio" name="shipping_method" value="{{ $method['name'] }}" data-fee="{{ $method['fee'] }}" required 
                                class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 shipping-option"
                                {{ old('shipping_method') == $method['name'] ? 'checked' : '' }}>
                            <span class="text-gray-900 font-medium">{{ $method['name'] }}</span>
                            <span class="text-sm text-gray-600">- Estimasi {{ $method['days'] }}</span>
                            <span class="ml-auto font-semibold text-right">Rp {{ number_format($method['fee']) }}</span>
                        </label>
                    @endforeach
                    @error('shipping_method') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Bagian 3: Metode Pembayaran --}}
            <div class="bg-white p-6 shadow-md rounded-lg border">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">3. Pilih Metode Pembayaran 💳</h2>
                <div class="space-y-3">
                    @php
                        $paymentOptions = ['Transfer Bank', 'Kartu Kredit', 'E-Wallet'];
                    @endphp

                    @foreach($paymentOptions as $option)
                        <label class="flex items-center space-x-3 cursor-pointer p-3 border rounded-md hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="{{ $option }}" required 
                                class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                {{ old('payment_method') == $option ? 'checked' : '' }}>
                            <span class="text-gray-900 font-medium">{{ $option }}</span>
                        </label>
                    @endforeach
                    @error('payment_method') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Ringkasan Pesanan --}}
        <div class="lg:w-1/3">
            <div class="bg-white p-6 shadow-xl rounded-lg sticky top-4 border-2 border-indigo-200">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Ringkasan Pembayaran</h2>

                {{-- Daftar Item --}}
                <ul class="divide-y divide-gray-200 mb-4">
                    @foreach($cartItems as $item)
                        <li class="py-2 flex justify-between text-sm">
                            <span class="text-gray-700">{{ $item->product->name }} (x{{ $item->quantity }})</span>
                            <span class="font-medium">Rp {{ number_format($item->product->price * $item->quantity) }}</span>
                        </li>
                    @endforeach
                </ul>

                {{-- Detail Biaya --}}
                <div class="border-t pt-4 space-y-2 text-gray-600">
                    <div class="flex justify-between">
                        <span>Subtotal Produk:</span>
                        <span class="font-medium">Rp {{ number_format($subtotal) }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span>Biaya Pengiriman:</span>
                        <span id="shippingFeeDisplay" class="font-medium text-red-600">Rp 0</span>
                    </div>

                    @php
                        // Asumsi PPN 11% untuk contoh (dihitung dari subtotal)
                        $taxRate = 0.11;
                        $taxTotal = $subtotal * $taxRate;
                    @endphp
                    <div class="flex justify-between">
                        <span>PPN ({{ $taxRate * 100 }}%):</span>
                        <span class="font-medium">Rp {{ number_format($taxTotal) }}</span>
                    </div>
                </div>

                {{-- Total Akhir --}}
                <div class="border-t border-indigo-300 mt-4 pt-4 flex justify-between items-center text-lg font-bold">
                    <span>Total Bayar:</span>
                    <span id="grandTotalDisplay" class="text-indigo-600">Rp {{ number_format($subtotal + $taxTotal) }}</span>
                </div>

                <button type="submit" class="mt-6 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition duration-200">
                    Selesaikan Pembayaran
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const subtotal = {{ $subtotal }};
        const taxTotal = {{ $taxTotal }}; // PPN 11%

        const shippingOptions = document.querySelectorAll('.shipping-option');
        const shippingFeeDisplay = document.getElementById('shippingFeeDisplay');
        const grandTotalDisplay = document.getElementById('grandTotalDisplay');

        function formatRupiah(number) {
            return 'Rp ' + number.toLocaleString('id-ID');
        }

        function calculateGrandTotal() {
            let selectedFee = 0;
            let selectedOption = document.querySelector('.shipping-option:checked');

            if (selectedOption) {
                selectedFee = parseInt(selectedOption.dataset.fee);
            }
            
            const grandTotal = subtotal + taxTotal + selectedFee;

            shippingFeeDisplay.textContent = formatRupiah(selectedFee);
            grandTotalDisplay.textContent = formatRupiah(grandTotal);
        }

        // Jalankan kalkulasi saat halaman dimuat (untuk input yang sudah ter-check oleh old())
        calculateGrandTotal();

        // Tambahkan event listener untuk setiap pilihan pengiriman
        shippingOptions.forEach(option => {
            option.addEventListener('change', calculateGrandTotal);
        });
    });
</script>
@endsection