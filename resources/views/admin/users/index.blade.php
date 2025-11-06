@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="mb-6 bg-white p-4 rounded-lg shadow">
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-end gap-4">

        {{-- Pencarian --}}
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700">Pencarian</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}"
                class="mt-1 w-64 px-3 py-2 border rounded-lg"
                placeholder="Cari berdasarkan nama atau email...">
        </div>

        {{-- Submit Button --}}
        <div>
            <button type="submit"
                class="px-4 py-2 bg-[var(--dark-gold)] text-white rounded-lg shadow hover:bg-[var(--dark-brown)] transition">
                Cari
            </button>
        </div>

        {{-- Tombol Reset Filter --}}
        <div>
            <button type="button"
                onclick="window.location.href = '{{ route('admin.users.index') }}';"
                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg shadow hover:bg-gray-400 transition">
                Reset
            </button>

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
                <th class="px-6 py-3 border">Nama</th>
                <th class="px-6 py-3 border">Email</th>
                <th class="px-6 py-3 border">Telepon</th>
                <th class="px-6 py-3 border">Alamat Utama</th>
                <th class="px-6 py-3 border text-center">Aksi</th>
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
                    <button type="button" class="px-3 py-1 bg-[var(--dark-gold)] text-white rounded-md hover:bg-yellow-600 transition" data-modal-toggle="editUserModal{{ $user->id }}">
                        Edit
                    </button>
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

            <div id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-900 bg-opacity-50">
                <div class="relative w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow">
                        <div class="flex items-start justify-between p-4 border-b rounded-t">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Edit User
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="editUserModal{{ $user->id }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                        <form action="{{ route('admin.users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="p-6 space-y-6">
                                <div>
                                    <label for="name{{ $user->id }}" class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                                    <input type="text" name="name" id="name{{ $user->id }}" value="{{ $user->name }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                </div>
                                <div>
                                    <label for="email{{ $user->id }}" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                                    <input type="email" name="email" id="email{{ $user->id }}" value="{{ $user->email }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                </div>
                                <div>
                                    <label for="phone{{ $user->id }}" class="block mb-2 text-sm font-medium text-gray-900">Telepon</label>
                                    <input type="text" name="phone" id="phone{{ $user->id }}" value="{{ $user->defaultAddress->phone ?? '' }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>
                                <div>
                                    <label for="address{{ $user->id }}" class="block mb-2 text-sm font-medium text-gray-900">Alamat Utama</label>
                                    <input type="text" name="address" id="address{{ $user->id }}" value="{{ $user->defaultAddress->address_line ?? '' }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>
                            </div>
                            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                                <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" data-modal-toggle="editUserModal{{ $user->id }}">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>