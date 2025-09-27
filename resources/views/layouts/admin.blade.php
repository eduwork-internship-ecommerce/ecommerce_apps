<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>@yield('title', 'Admin Panel')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    <div class="flex">
        <aside class="w-64 bg-[var(--deep-brown)] text-[var(--dark-gold)] min-h-screen flex flex-col">

            {{-- ... Konten Sidebar Anda ... --}}

            <div class="p-4 border-b border-[var(--light-gold)]">
                @auth
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center justify-center h-20 w-20 rounded-full">
                            <img src="{{asset('images/honey-mart-logo.png')}}" alt="">
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-[var(--dark-gold)] truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-[gray-400] truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                @endauth
            </div>

            <nav class="space-y-2 p-4 flex-1">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 hover:bg-gray-700 rounded">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 hover:bg-gray-700 rounded">Products</a>
                <a href="#" class="block px-3 py-2 hover:bg-gray-700 rounded">Users</a>
                <a href="#" class="block px-3 py-2 hover:bg-gray-700 rounded">Reports</a>
            </nav>

            <div class="p-4 border-t border-[var(--light-gold)]">
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button
                        type="submit"
                        class="w-full text-left py-2 px-4 text-sm font-medium rounded-md text-red-800 bg-[var(--dark-gold)] hover:bg-red-600 hover:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800 flex items-center justify-center space-x-2"
                        onclick="event.preventDefault(); confirmLogout();">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>

                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>
</body>

<script>
    function confirmLogout() {
        // Tampilkan pesan konfirmasi
        if (confirm('Apakah Anda yakin ingin keluar dari sesi ini?')) {
            // Jika pengguna menekan OK, kirimkan form logout
            document.getElementById('logout-form').submit();
        }
        // Jika pengguna menekan Cancel, aksi submit dihentikan oleh event.preventDefault() di tombol
    }
</script>
</body>

</html>