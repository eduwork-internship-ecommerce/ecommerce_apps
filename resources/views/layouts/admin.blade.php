<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    <div class="flex">
        <aside class="w-64 bg-gray-800 text-white min-h-screen flex flex-col">

            <div class="p-4 border-b border-gray-700">
                @auth
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-600">
                            <svg class="h-6 w-6 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993c-.046.216-.095.592-.224.966-.129.375-.328.621-.656.621H.877c-.328 0-.527-.246-.656-.621-.129-.374-.178-.75-.224-.966C-.177 19.866 0 16.5 0 12c0-4.5 2.177-7.866 5.897-8.993.42-.128.84-.256 1.26-.384C7.577 2.372 7.823 2.126 8.151 2.126h7.698c.328 0 .574.246.853.501.42.128.84.256 1.26.384C21.823 4.134 24 7.5 24 12c0 4.5-2.177 7.866-5.897 8.993zM12 4c-3.314 0-6 2.686-6 6s2.686 6 6 6 6-2.686 6-6-2.686-6-6-6z" />
                            </svg>
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
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

            <div class="p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button
                        type="submit"
                        class="w-full text-left py-2 px-4 text-sm font-medium rounded-md text-red-400 bg-gray-700 hover:bg-red-600 hover:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800 flex items-center justify-center space-x-2"
                        onclick="event.preventDefault(); confirmLogout();">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>

                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>
</body>


<!-- Main Content -->
<main class="flex-1 p-6">
    @yield('content')
</main>
</div>
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