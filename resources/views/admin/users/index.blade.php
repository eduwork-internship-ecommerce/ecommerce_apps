@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="mb-6 bg-white p-4 rounded-lg shadow">
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-end gap-4">

        {{-- Search --}}
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}"
                class="mt-1 w-64 px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500"
                placeholder="Search by name or email...">
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
            <a href="{{ route('admin.users.index') }}"
               class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg shadow hover:bg-gray-400 transition">
               Reset
            </a>
        </div>
    </form>
</div>
<div class="flex justify-between mb-6 items-center">
    <h1 class="text-3xl font-bold text-gray-800">Users</h1>
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
                <th class="px-6 py-3 border">Email</th>
                <th class="px-6 py-3 border">Phone</th>
                <th class="px-6 py-3 border">Default Address</th>
                <th class="px-6 py-3 border text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 divide-y">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                <td class="px-6 py-4 font-medium">{{ $user->name }}</td>
                <td class="px-6 py-4">{{ $user->email }}</td>
                <td class="px-6 py-4">{{ $user->defaultAddress->phone ?? 'N/A' }}</td>
                <td class="px-6 py-4">
                    @if($user->defaultAddress)
                        {{ $user->defaultAddress->address_line }}, {{ $user->defaultAddress->city }}, {{ $user->defaultAddress->province }}
                    @else
                        <span class="text-gray-400 italic">No default address</span>
                    @endif
                </td>
                   <td class="px-6 py-4 text-center space-x-2">
                    <a href="#" 
                       class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
                        Edit
                    </a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Yakin hapus User ini?')"
                                class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                    No users found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $users->links() }}
</div>
@endsection
