@extends('layouts.admin')

@section('title', 'Kelola Transaksi Pembayaran')

@section('content')
<div class="mb-6 bg-white p-4 rounded-lg shadow">
    {{-- Mengubah route filter ke route index transactions --}}
    <form method="GET" action="{{ route('admin.transactions.index') }}" class="flex flex-wrap items-end gap-4">

        {{-- Pencarian berdasarkan Code Pesanan atau User ID --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Cari Pesanan</label>
            <input type="text" name="search" value="{{ request('search') }}"
                class="mt-1 w-64 px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500"
                placeholder="Cari berdasarkan kode atau user ID...">
        </div>

        {{-- Filter Payment Status (unpaid, paid) --}}
        <div>
            <label class="block text-sm font-medium text-[var(--dark-brown)]">Status Pembayaran</label>
            <select name="payment_status"
                class="mt-1 w-48 px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 text-[var(--dark-brown)]">
                <option value="">Semua Status Pembayaran</option>
                <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Sudah Bayar</option>
                {{-- Tambahkan status pembayaran lain jika ada (misal: 'refund', 'failed') --}}
            </select>
        </div>

        {{-- Filter Status Pesanan (pending, processing, completed, canceled) --}}
        <div>
            <label class="block text-sm font-medium text-[var(--dark-brown)]">Status Pesanan</label>
            <select name="status"
                class="mt-1 w-48 px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 text-[var(--dark-brown)]">
                <option value="">Semua Status Pesanan</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>

        {{-- Tombol Filter --}}
        <div>
            <button type="submit"
                class="px-4 py-2 bg-[var(--dark-gold)] text-white rounded-lg shadow hover:bg-[var(--dark-brown)] transition">
                Cari
            </button>
        </div>

        {{-- Tombol Reset Filter (Diarahkan ke route transactions index) --}}
        <div>
            <button type="button"
                onclick="window.location.href = '{{ route('admin.transactions.index') }}';"
                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg shadow hover:bg-gray-400 transition">
                Reset
            </button>
        </div>
    </form>
</div>

<div class="flex justify-between mb-6 items-center">
    <h1 class="text-3xl font-bold text-[var(--deep-brown)]">Transaksi Pembayaran</h1>
</div>

@if(session('success'))
<div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg">
    {{ session('success') }}
</div>
@endif

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-100 text-[var(--dark-brown)] uppercase text-sm">
                <th class="px-6 py-3 border">#</th>
                <th class="px-6 py-3 border">Kode Pesanan</th>
                <th class="px-6 py-3 border">Pelanggan (ID)</th>
                <th class="px-6 py-3 border text-right">Grand Total</th>
                <th class="px-6 py-3 border text-center">Status Pembayaran</th>
                <th class="px-6 py-3 border text-center">Status Pesanan</th>
                <th class="px-6 py-3 border text-center">Tanggal Transaksi</th>
                <th class="px-6 py-3 border text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-[var(--dark-brown)] divide-y">
            {{-- Menggunakan $orders (asumsi data transaksi) --}}
            @forelse($transactions as $order)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">{{ $order->id }}</td>
                <td class="px-6 py-4 font-medium">{{ $order->code }}</td>
                <td class="px-6 py-4">{{ $order->user_id }}</td>
                <td class="px-6 py-4 text-right">
                    {{-- Format angka menjadi mata uang Rupiah --}}
                    Rp{{ number_format($order->grand_total, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4 text-center">
                    {{-- Tampilan Status Pembayaran --}}
                    @if($order->payment_status === 'paid')
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Sudah Bayar</span>
                    @elseif($order->payment_status === 'unpaid')
                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Belum Bayar</span>
                    @else
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">{{ Str::title($order->payment_status) }}</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    {{-- Tampilan Status Pesanan (Disesuaikan untuk Laravel 8) --}}
                    @if($order->status === 'completed')
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">Selesai</span>
                    @elseif($order->status === 'processing')
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-semibold">Diproses</span>
                    @elseif($order->status === 'canceled')
                    <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">Dibatalkan</span>
                    @else
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Pending</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    {{ $order->created_at->format('d/m/Y H:i') }}
                </td>
                <td class="px-6 py-4 text-center space-x-2">
                    {{-- Tombol untuk membuka modal update status --}}
                    <button type="button" class="px-3 py-1 bg-[var(--dark-gold)] text-white rounded-md hover:bg-yellow-600 transition text-sm" data-modal-target="updateStatusModal{{ $order->id }}" data-modal-toggle="updateStatusModal{{ $order->id }}">Update Status</button>
                    {{-- Tombol Detail (opsional) --}}
                    <button type="button" class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition text-sm"
        data-modal-target="detailModal{{ $order->id }}" data-modal-toggle="detailModal{{ $order->id }}">
    Detail
</button>
                </td>
{{-- MODAL DETAIL TRANSAKSI BARU --}}
            <div id="detailModal{{ $order->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-900 bg-opacity-50">
                <div class="relative w-full max-w-2xl max-h-full">
                    <div class="relative bg-white rounded-lg shadow">
                        <div class="flex items-start justify-between p-4 border-b rounded-t bg-gray-50">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Detail Transaksi: {{ $order->code }}
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="detailModal{{ $order->id }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </button>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            {{-- Ringkasan Transaksi --}}
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div><p class="text-gray-500">Kode Transaksi:</p><p class="font-medium">{{ $order->code }}</p></div>
                                <div><p class="text-gray-500">Grand Total:</p><p class="font-medium text-green-600">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</p></div>
                                <div><p class="text-gray-500">Status Bayar:</p><p class="font-medium">{{ Str::title($order->payment_status) }}</p></div>
                                <div><p class="text-gray-500">Status Pesanan:</p><p class="font-medium">{{ Str::title($order->status) }}</p></div>
                            </div>
                            
                            <h4 class="text-lg font-semibold border-b pb-2">Item Pembelian</h4>
                            
                            {{-- Daftar Item yang Dibeli (dari order_items) --}}
                            <div class="space-y-3 max-h-60 overflow-y-auto">
                                @forelse($order->orderItems as $item)
                                <div class="flex justify-between items-start border-b pb-2">
                                    <div class="text-sm">
                                        <p class="font-medium">{{ $item->product_name_snapshot }}</p>
                                        <p class="text-gray-500">{{ $item->quantity }} x Rp{{ number_format($item->price_snapshot, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right font-semibold text-sm">
                                        Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div>
                                </div>
                                @empty
                                <p class="text-gray-500 text-center">Tidak ada item yang terkait dengan transaksi ini.</p>
                                @endforelse
                            </div>

                        </div>
                        <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                            <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" data-modal-toggle="detailModal{{ $order->id }}">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            </tr>
            {{-- MODAL UPDATE STATUS PEMBAYARAN & PESANAN --}}
            <div id="updateStatusModal{{ $order->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-900 bg-opacity-50">
                <div class="relative w-full max-w-lg max-h-full">
                    <div class="relative bg-white rounded-lg shadow">
                        <div class="flex items-start justify-between p-4 border-b rounded-t bg-gray-50">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Kelola Transaksi: {{ $order->code }}
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="updateStatusModal{{ $order->id }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>

                        {{-- Form untuk Update Status --}}
                        {{-- Route PUT transactions.updateStatus --}}
                        <form action="{{ route('admin.transactions.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="p-6 space-y-6">

                                <div class="p-4 border rounded-lg bg-yellow-50/50 text-sm">
                                    <p class="font-bold text-lg mb-2">Detail Transaksi</p>
                                    <p>Kode: <span class="font-medium">{{ $order->code }}</span></p>
                                    <p>Total: <span class="font-medium text-lg text-green-700">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</span></p>
                                    <p>Metode: <span class="font-medium">{{ $order->payment_method ?? 'Transfer Bank' }}</span></p>
                                    <p class="mt-2">Status Pembayaran Saat Ini:
                                        <span class="font-bold {{ $order->payment_status == 'paid' ? 'text-green-600' : 'text-red-600' }}">{{ Str::title($order->payment_status) }}</span>
                                    </p>
                                    <p>Status Pesanan Saat Ini:
                                        <span class="font-bold text-blue-600">{{ Str::title($order->status) }}</span>
                                    </p>

                                    {{-- Tempat untuk menampilkan Bukti Pembayaran, jika tersedia --}}
                                    @if(isset($order->payment_proof) && $order->payment_proof)
                                    <p class="mt-4 font-bold">Bukti Pembayaran:</p>
                                    {{-- Ganti URL berikut dengan path ke gambar bukti bayar Anda. Pastikan 'storage:link' sudah dijalankan. --}}
                                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Pembayaran" class="mt-2 max-h-48 border rounded-lg object-contain cursor-pointer hover:shadow-lg">
                                    </a>
                                    @else
                                    <p class="mt-4 text-gray-500">Tidak ada bukti pembayaran diunggah.</p>
                                    @endif
                                </div>

                                {{-- Pilihan Update Payment Status --}}
                                <div>
                                    <label for="payment_status-{{ $order->id }}" class="block mb-2 text-sm font-medium text-gray-900">Ubah Status Pembayaran</label>
                                    <select id="payment_status-{{ $order->id }}" name="payment_status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        {{-- Nilai yang tersedia di ENUM: 'unpaid', 'paid' --}}
                                        <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Belum Bayar (unpaid)</option>
                                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Sudah Bayar (paid) - VERIFIKASI</option>
                                        {{-- Tambahkan status lain jika ada --}}
                                    </select>
                                </div>

                                {{-- Pilihan Update Order Status --}}
                                <div>
                                    <label for="order_status-{{ $order->id }}" class="block mb-2 text-sm font-medium text-gray-900">Ubah Status Pesanan</label>
                                    <select id="order_status-{{ $order->id }}" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        {{-- Nilai yang tersedia di ENUM: 'pending', 'processing', 'completed', 'canceled' --}}
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses (processing)</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai (completed)</option>
                                        <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Dibatalkan (canceled)</option>
                                    </select>
                                </div>

                            </div>
                            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                                <button type="submit" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Perubahan Status</button>
                                <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" data-modal-toggle="updateStatusModal{{ $order->id }}">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                    Tidak ada transaksi ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{-- Asumsi: $orders adalah data yang dipaginasi --}}
    {{ $transactions->links() }}
</div>

@endsection

{{-- PENTING: Sertakan Flowbite JS untuk fungsionalitas modal --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>