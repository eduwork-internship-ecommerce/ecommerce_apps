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
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white min-h-screen">
            <div class="p-6 text-2xl font-bold">Admin Panel</div>
            <nav class="space-y-2 p-4">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 hover:bg-gray-700 rounded">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="block px-3 py-2 hover:bg-gray-700 rounded">Products</a>

                <a href="#" class="block px-3 py-2 hover:bg-gray-700 rounded">Users</a>
                <a href="#" class="block px-3 py-2 hover:bg-gray-700 rounded">Reports</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
