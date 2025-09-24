@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card Products -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-2">Products</h2>
            <p>Kelola semua produk di sini.</p>
            <a href="{{ route('admin.products.index') }}" 
               class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
               Manage Products
            </a>
        </div>

        <!-- Card Users -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-2">Users</h2>
            <p>Lihat dan kelola data pengguna.</p>
            <a href="#" 
               class="inline-block mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
               Manage Users
            </a>
        </div>

        <!-- Card Reports -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-2">Reports</h2>
            <p>Lihat laporan penjualan & aktivitas.</p>
            <a href="#" 
               class="inline-block mt-4 px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
               View Reports
            </a>
        </div>
    </div>
</div>
@endsection
