@extends('layouts.admin')

@section('title', 'Manage Product Categories')

@section('content')
<div class="mb-6 bg-white p-4 rounded-lg shadow">
    <form method="GET" action="{{ route('admin.categories.index') }}" class="flex flex-wrap items-end gap-4">

        {{-- Search --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Search</label>
            <input type="text" name="search" value="{{ request('search') }}"
                class="mt-1 w-64 px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500"
                placeholder="Search by name...">
        </div>

        {{-- Status Filter --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <select name="is_active"
                class="mt-1 w-48 px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Status</option>
                <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
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
            <a href="{{ route('admin.categories.index') }}"
               class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg shadow hover:bg-gray-400 transition">
               Reset
            </a>
        </div>
    </form>
</div>
<div class="flex justify-between mb-6 items-center">
    <h1 class="text-3xl font-bold text-gray-800">Product Categories</h1>
    <a href="{{ route('admin.categories.create') }}" 
       class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
        + Add Category
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
                <th class="px-6 py-3 border">Name</th>
                <th class="px-6 py-3 border">Slug</th>
                <th class="px-6 py-3 border">Status</th>
                <th class="px-6 py-3 border text-center">Action</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 divide-y">
            @forelse($categories as $category)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                <td class="px-6 py-4 font-medium">{{ $category->name }}</td>
                <td class="px-6 py-4">{{ $category->slug }}</td>
                <td class="px-6 py-4">
                    @if($category->is_active)
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-md">Active</span>
                    @else
                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-md">Inactive</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center space-x-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
                        Edit
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Yakin hapus kategori ini?')"
                                class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                    No categories found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $categories->links() }}
</div>
@endsection
