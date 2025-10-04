<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>@yield('title', 'Panel Admin')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">

        <aside id="sidebar"
            class="w-64 bg-[var(--deep-brown)] text-[var(--dark-gold)] min-h-screen flex-col 
                      hidden md:flex fixed md:static inset-y-0 left-0 z-50 
                      transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">

            {{-- ... Konten Sidebar Anda ... --}}

            <div class="p-4 border-b border-[var(--light-gold)]">
                @auth
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center justify-center h-20 w-20 rounded-full">
                            <img src="{{asset('images/honey-mart-logo.png')}}" alt="Logo">
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
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 hover:bg-gray-700 rounded">Dasbor</a>
                <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 hover:bg-gray-700 rounded">Produk</a>
                <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 hover:bg-gray-700 rounded">Pelanggan</a>
                <a href="#" class="block px-3 py-2 hover:bg-gray-700 rounded">Laporan</a>
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
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1">

            <header class="bg-[var(--deep-brown)]  shadow md:hidden sticky top-0 z-40">
                <div class="flex items-center justify-between p-4">
                    <span class="inline-flex items-center justify-center h-12 w-12 rounded-full">
                        <img src="{{asset('images/honey-mart-logo.png')}}" alt="Logo">
                    </span>
                    <h1 class="text-xl font-semibold">Panel Admin</h1>
                    <button id="sidebar-toggle" class="text-[var(--light-gold)] focus:outline-none">
                        <svg id="menu-icon" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                        <svg id="close-icon" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </header>

            <main class="p-6">
                @yield('content')
            </main>
        </div>

        <div id="sidebar-overlay"
            class="fixed inset-0 bg-black opacity-50 z-40 hidden md:hidden"
            onclick="toggleSidebar()">
        </div>

    </div>
</body>

<script>
    const sidebar = document.getElementById('sidebar');
    const toggleButton = document.getElementById('sidebar-toggle');
    const overlay = document.getElementById('sidebar-overlay');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    // Fungsi utama untuk membuka/menutup sidebar
    function toggleSidebar() {
        // Toggle class translate untuk menggerakkan sidebar
        sidebar.classList.toggle('-translate-x-full');
        sidebar.classList.toggle('hidden'); // Memastikan hidden hilang agar transisi berjalan
        sidebar.classList.toggle('flex');

        // Toggle overlay
        overlay.classList.toggle('hidden');

        // Toggle ikon (Hamburger <-> Close)
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    }

    // Event listener untuk tombol hamburger
    if (toggleButton) {
        toggleButton.addEventListener('click', toggleSidebar);
    }

    // Event listener untuk menutup sidebar saat item navigasi diklik di ponsel
    const navLinks = sidebar.querySelectorAll('nav a');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            // Pastikan hanya menutup di layar kecil
            if (window.innerWidth < 768) { // 768px adalah breakpoint default 'md' tailwind
                toggleSidebar();
            }
        });
    });

    // Fungsi konfirmasi logout
    function confirmLogout() {
        if (confirm('Apakah Anda yakin ingin keluar dari sesi ini?')) {
            document.getElementById('logout-form').submit();
        }
    }
</script>

</html>