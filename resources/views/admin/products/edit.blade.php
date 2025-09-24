@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Product</h1>

@if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg">
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" 
      class="space-y-5 bg-white p-6 rounded-lg shadow-lg">
    @csrf
    @method('PUT')

    <!-- Name -->
    <div>
        <label class="block font-semibold text-gray-700">Name</label>
        <input type="text" name="name" value="{{ old('name', $product->name) }}"
               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2" required>
    </div>

    <!-- Brand -->
    <div>
        <label class="block font-semibold text-gray-700">Brand</label>
        <input type="text" name="brand" value="{{ old('brand', $product->brand) }}"
               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
    </div>

    <!-- Category -->
    <div>
        <label class="block font-semibold text-gray-700">Category</label>
        <select name="category_id" 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" 
                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Price -->
    <div>
        <label class="block font-semibold text-gray-700">Price</label>
        <input type="number" name="price" value="{{ old('price', $product->price) }}"
               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2" required>
    </div>

    <!-- Stock -->
    <div>
        <label class="block font-semibold text-gray-700">Stock</label>
        <input type="number" name="stock" value="{{ old('stock', $product->stock ?? '') }}"
               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
    </div>

    <!-- Description -->
    <div>
        <label class="block font-semibold text-gray-700">Description</label>
        <textarea name="description" rows="4"
                  class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">{{ old('description', $product->description) }}</textarea>
    </div>

    <!-- Image -->
    <div>
        <label class="block font-semibold text-gray-700">Product Image</label>
        @if($product->image_url)
            <div class="mb-3">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                     class="w-32 h-32 object-cover rounded-md border">
            </div>
        @endif
        <input type="file" name="image"
               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
        <p class="text-sm text-gray-500 mt-1">Upload file baru jika ingin mengganti gambar.</p>
    </div>

    <!-- Submit -->
    <div class="flex justify-end">
        <a href="{{ route('admin.products.index') }}" 
           class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600 mr-2">
            Cancel
        </a>
        <button type="submit" 
                class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
            Update
        </button>
    </div>
</form>
@endsection
