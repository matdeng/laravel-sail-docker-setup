<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md">
            <div class="p-4 text-lg font-bold border-b">Dashboard</div>
            <nav class="p-4 space-y-2">
                <a href="/dashboard" class="block px-3 py-2 rounded hover:bg-gray-200">Home Test CI</a>
                <a href="/checklist" class="block px-3 py-2 rounded hover:bg-gray-200">Checklist</a>
                <a href="/admin/users" class="block px-3 py-2 rounded hover:bg-gray-200">Users</a>
                <a href="/settings" class="block px-3 py-2 rounded hover:bg-gray-200">Settings</a>
                <!-- Add more links -->
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @include('layouts.navigation') {{-- Keep this if you want the top nav too --}}
            @yield('content')
        </main>
    </div>
</body>

</html>