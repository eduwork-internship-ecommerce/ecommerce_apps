@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
<div class="mb-6 bg-white p-4 rounded-lg shadow">
    <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-wrap items-end gap-4">

        {{-- Search --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Search</label>
            <input type="text" name="search" value="{{ request('search') }}"
                class="mt-1 w-64 px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500"
                placeholder="Search by name...">
        </div>

        {{-- Category Filter --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Category</label>
            <select name="category_id"
                class="mt-1 w-48 px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Brand Filter --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Brand</label>
            <select name="brand"
                class="mt-1 w-48 px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Brands</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                        {{ $brand }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Submit Button --}}
        <div>
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                Filter
            </button>
        </div>

        {{-- Reset Filter --}}
        <div>
            <a href="{{ route('admin.products.index') }}"
               class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg shadow hover:bg-gray-400 transition">
               Reset
            </a>
        </div>
    </form>
</div>
<div class="flex justify-between mb-6 items-center">
    <h1 class="text-3xl font-bold text-gray-800">Products</h1>
    <a href="{{ route('admin.products.create') }}" 
       class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
        + Add Product
    </a>
</div>

@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
                <th class="px-6 py-3 border">#</th>
                <th class="px-6 py-3 border">Image</th>
                <th class="px-6 py-3 border">Name</th>
                <th class="px-6 py-3 border">Description</th>
                <th class="px-6 py-3 border">Brand</th>
                <th class="px-6 py-3 border">Price</th>
                <th class="px-6 py-3 border">Category ID</th>
                <th class="px-6 py-3 border text-center">Action</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 divide-y">
            @forelse($products as $product)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                <td class="px-6 py-4">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" 
                             alt="{{ $product->name }}" 
                             class="w-16 h-16 object-cover rounded-md border">
                    @else
                        <span class="text-gray-400 italic">No Image</span>
                    @endif
                </td>
                <td class="px-6 py-4 font-medium">{{ $product->name }}</td>
                <td class="px-6 py-4 font-medium">{{ $product->description }}</td>
                <td class="px-6 py-4 font-medium">{{ $product->brand }}</td>
                <td class="px-6 py-4">Rp {{ number_format($product->price,0,',','.') }}</td>
                <td class="px-6 py-4 font-medium">{{ $product->category_id }}</td>
                <td class="px-6 py-4 text-center space-x-2">
                    <a href="{{ route('admin.products.edit', $product) }}" 
                       class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
                        Edit
                    </a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Yakin hapus produk ini?')"
                                class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                    No products found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $products->links() }}
</div>
@endsection
