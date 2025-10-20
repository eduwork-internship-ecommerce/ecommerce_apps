@extends('layouts.mainLayout')

@section('title', 'Riwayat Pesanan')

@section('content')

{{-- MENGIMPORT HELPER FUNCTIONS & JAVASCRIPT DARI FILE PARTIAL BARU --}}
@include('userPage.history.partials._order_helpers')

<div class="max-w-6xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-2">Riwayat Pesanan Anda</h1>

    @if (empty($orders))
    <div class="text-center p-10 bg-white rounded-lg shadow-lg">
        <p class="text-xl text-gray-600">Anda belum memiliki riwayat pesanan.</p>
        <a href="/" class="mt-4 inline-block px-6 py-2 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition">Mulai Belanja</a>
    </div>
    @else
    {{-- Menggunakan Alpine.js untuk state modal --}}
    {{-- Pastikan Alpine.js sudah di-load di layout utama --}}
    <div x-data="{ showModal: false, selectedOrder: null, formatStatus: window.formatStatus, formatDate: window.formatDate }">

        {{-- Daftar Kartu Pesanan --}}
        <div class="space-y-6">
            @foreach ($orders as $order)
            @php
            // Ambil item pertama untuk ditampilkan di ringkasan card
            $firstItem = $order['order_items'][0] ?? null;
            // Cek apakah tombol bayar harus ditampilkan
            $showPaymentButton = ($order['status'] === 'pending' || $order['payment_status'] === 'unpaid');
            @endphp
            <div class="bg-white border border-gray-200 rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b pb-4 mb-4">
                    <div class="text-sm">
                        <p class="text-xs text-gray-500 font-medium">Order ID / Tanggal Pesan</p>
                        <p class="text-lg font-semibold text-gray-800">
                            {{ $order['code'] }}
                            <span class="text-sm font-normal text-gray-500 block md:inline"> ({{ formatDate($order['placed_at']) }})</span>
                        </p>
                    </div>
                    <div class="mt-2 md:mt-0">
                        <span class="px-3 py-1 text-sm font-medium rounded-full {{ getStatusClass($order['status']) }}">
                            {{ formatStatus($order['status']) }}
                        </span>
                    </div>
                </div>

                {{-- Ringkasan Pembayaran --}}
                <div class="grid grid-cols-2 gap-4 text-gray-600 mb-4">
                    <div>
                        <p class="text-sm">Subtotal Barang:</p>
                        <p class="font-bold text-lg text-yellow-700">Rp{{ number_format($order['subtotal'], 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm">Total Pembayaran (Grand Total):</p>
                        <p class="font-bold text-xl text-yellow-900">Rp{{ number_format($order['grand_total'], 0, ',', '.') }}</p>
                    </div>
                </div>

                {{-- Tombol Detail Transaksi --}}
                {{-- Tombol Aksi --}}
                <div class="flex justify-end space-x-3 pt-2 border-t">
                    @if ($showPaymentButton)
                    {{-- Tombol Lanjutkan Pembayaran (Hanya jika pending/unpaid) --}}
                    <a href="{{ route('payment.continue', $order->code) }}"
                        class="bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-green-700 transition duration-150 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Lanjutkan Pembayaran
                    </a>
                    @endif

                    {{-- Tombol Detail Transaksi --}}
                    <button
                        @click="showModal = true; selectedOrder = {{ json_encode($order) }}"
                        class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-yellow-600 transition duration-150 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                        Detail Transaksi
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Modal Popup Detail Transaksi --}}
        <div
            x-show="showModal"
            x-cloak
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="fixed inset-0 z-50 overflow-y-auto"
            style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 py-8">
                {{-- Overlay --}}
                <div x-show="showModal" @click="showModal = false" class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>

                {{-- Modal Content --}}
                <div
                    class="bg-white rounded-xl shadow-2xl w-full max-w-lg mx-auto z-50 transform transition-all overflow-hidden"
                    @click.away="showModal = false">
                    {{-- Header --}}
                    <div class="flex justify-between items-center p-5 border-b bg-yellow-100">
                        <h3 class="text-xl font-bold text-yellow-800">Detail Pesanan: <span x-text="selectedOrder ? selectedOrder.code : ''"></span></h3>
                        <button @click="showModal = false" class="text-gray-400 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Body --}}
                    <div x-show="selectedOrder" class="p-6 max-h-[70vh] overflow-y-auto">
                        {{-- Informasi Umum --}}
                        <h4 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">Status & Pembayaran</h4>
                        <div class="space-y-1 text-sm mb-6">
                            <p>
                                <span class="font-medium">Status Pesanan:</span>
                                <span class="font-bold text-gray-800" x-text="formatStatus(selectedOrder.status)"></span>
                            </p>
                            <p>
                                <span class="font-medium">Status Pembayaran:</span>
                                <span class="font-bold" :class="{'text-green-600': selectedOrder.payment_status == 'paid', 'text-red-600': selectedOrder.payment_status != 'paid'}" x-text="formatStatus(selectedOrder.payment_status)"></span>
                            </p>
                            <p><span class="font-medium">Metode Pembayaran:</span> <span x-text="selectedOrder.payment_method"></span></p>
                            <p><span class="font-medium">Tanggal Pesan:</span> <span x-text="formatDate(selectedOrder.placed_at)"></span></p>
                        </div>

                        {{-- Detail Produk --}}
                        <h4 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">Produk Dipesan (Order Items)</h4>
                        <ul class="space-y-3 mb-6">
                            {{-- Looping berdasarkan relasi 'order_items' --}}
                            <template x-for="item in selectedOrder.order_items" :key="item.product_name_snapshot">
                                <li class="flex justify-between items-start text-sm border-b pb-2">
                                    <div>
                                        {{-- Menggunakan product_name_snapshot dari order_items --}}
                                        <p class="font-medium" x-text="item.product_name_snapshot"></p>
                                        {{-- Menggunakan price_snapshot dan quantity dari order_items --}}
                                        <p class="text-xs text-gray-500">
                                            <span x-text="item.quantity"></span> x Rp<span x-text="new Intl.NumberFormat('id-ID').format(item.price_snapshot)"></span>
                                        </p>
                                    </div>
                                    {{-- Menggunakan subtotal dari order_items --}}
                                    <p class="font-semibold text-gray-800 text-right">Rp<span x-text="new Intl.NumberFormat('id-ID').format(item.subtotal)"></span></p>
                                </li>
                            </template>
                        </ul>

                        {{-- Rincian Pembayaran --}}
                        <h4 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">Rincian Biaya</h4>
                        <div class="space-y-1 text-sm">
                            <div class="flex justify-between">
                                <span>Subtotal Barang:</span>
                                <span class="font-medium">Rp<span x-text="new Intl.NumberFormat('id-ID').format(selectedOrder.subtotal)"></span></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Ongkos Kirim:</span>
                                <span class="font-medium">Rp<span x-text="new Intl.NumberFormat('id-ID').format(selectedOrder.shipping_cost)"></span></span>
                            </div>
                            <div class="flex justify-between text-red-600">
                                <span>Diskon:</span>
                                <span class="font-medium">- Rp<span x-text="new Intl.NumberFormat('id-ID').format(selectedOrder.discount_total)"></span></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Pajak (Tax Total):</span>
                                <span class="font-medium">Rp<span x-text="new Intl.NumberFormat('id-ID').format(selectedOrder.tax_total)"></span></span>
                            </div>
                            <div class="flex justify-between border-t mt-2 pt-2">
                                <span class="text-base font-bold text-yellow-900">Total Akhir (Grand Total):</span>
                                <span class="text-base font-bold text-yellow-900">Rp<span x-text="new Intl.NumberFormat('id-ID').format(selectedOrder.grand_total)"></span></span>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="p-4 border-t text-right">
                        <button @click="showModal = false" class="bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endif

</div>


@endsection