@extends('layouts.admin')

@section('title', 'Dasbor Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Dasbor Admin</h1>

    <div class="grid sm: lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                    <div class="bg-blue-100 text-blue-600 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div class="ml-4 flex-grow text-center">
                    <p class="text-sm uppercase tracking-wider">Jumlah Produk</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($data['productCount']) }}</p>
                </div>
            </div>
            <p class="text-sm text-green-500 mt-4 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
                <span>{{ $data['newProducts'] }} produk baru</span>
            </p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                    <div class="bg-green-100 text-green-600 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                    </svg>
                </div>
                <div class="ml-4 flex-grow text-center">
                    <p class="text-sm uppercase tracking-wider">Jumlah Kategori</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($data['categoryCount']) }}</p>
                </div>
            </div>
             <p class="text-sm text-gray-400 mt-4 flex items-center justify-center">
                <span>Stabil bulan ini</span>
            </p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                    <div class="bg-yellow-100 text-yellow-600 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
                <div class="ml-4 flex-grow text-center">
                    <p class="text-sm uppercase tracking-wider">Total Stok Produk</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($data['totalStock']) }}</p>
                </div>
            </div>
            <p class="text-sm text-red-500 mt-4 flex items-center justify-center">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                <span>{{ $data['lowStockProducts'] }} produk stok menipis</span>
            </p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                    <div class="bg-purple-100 text-purple-600 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-4 flex-grow text-center">
                    <p class="text-sm uppercase tracking-wider">Total Transaksi</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($data['transactionCount']) }}</p>
                </div>
            </div>
            <p class="text-sm text-green-500 mt-4 flex items-center justify-center">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
                <span>+{{ number_format($data['monthlyTransactions']) }} bulan ini</span>
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-2">Produk</h2>
            <p>Kelola semua produk di sini.</p>
            <a href="{{ route('admin.products.index') }}" 
               class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
               Kelola Produk
            </a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-2">Pelanggan</h2>
            <p>Lihat dan kelola data pelanggan.</p>
            <a href="#" 
               class="inline-block mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
               Kelola Pelanggan
            </a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-2">Laporan</h2>
            <p>Lihat laporan penjualan & aktivitas.</p>
            <a href="#" 
               class="inline-block mt-4 px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
               Lihat Laporan
            </a>
        </div>
    </div>
</div>
@endsection