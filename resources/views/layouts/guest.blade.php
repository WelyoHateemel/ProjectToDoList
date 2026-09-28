<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'RoleWelyo') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50 min-h-screen">
        <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-indigo-50 via-white to-purple-50">
            <!-- Brand -->
            <div class="text-center mb-6">
                <a href="/" class="inline-flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-indigo-200">
                        RW
                    </div>
                    <span class="text-2xl font-black tracking-tight text-gray-800">Role<span class="text-indigo-600">Welyo</span></span>
                </a>
            </div>

            <!-- Card -->
            <div class="w-full sm:max-w-md bg-white border border-gray-100 shadow-xl shadow-indigo-100/50 rounded-2xl p-8">
                {{ $slot }}
            </div>

            <p class="mt-8 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} RoleWelyo. Sistem Manajemen Peran & To-Do List Kolaboratif.
            </p>
        </div>
    </body>
</html>
