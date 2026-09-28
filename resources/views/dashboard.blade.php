<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard Utama') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-8">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl font-bold">
                        👋
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Halo, {{ Auth::user()->name }}!</h3>
                        <p class="text-sm text-gray-500 mt-1">Anda login sebagai: <span class="font-semibold text-indigo-600 uppercase">{{ Auth::user()->role }}</span></p>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                        $userRole = strtolower(trim(Auth::user()->role ?? ''));
                        $userRole = str_replace([' ', '_', '-'], '', $userRole);
                    @endphp

                    @if($userRole === 'rolemanager' || $userRole === 'role')
                        <a href="{{ route('rolemanager.index') }}" class="p-6 rounded-xl border border-purple-200 bg-purple-50/50 hover:bg-purple-50 transition group flex flex-col justify-between">
                            <div>
                                <span class="px-2.5 py-1 text-xs font-semibold rounded bg-purple-100 text-purple-700">Role Manager</span>
                                <h4 class="text-lg font-bold text-gray-900 mt-3 group-hover:text-purple-700 transition">Papan To-Do Tim (Publish, Managed, Done) &rarr;</h4>
                                <p class="text-xs text-gray-600 mt-1">Buat tugas, kelola alur kerja tim, dan distribusikan to-do ke programmer.</p>
                            </div>
                        </a>
                    @endif

                    @if($userRole === 'programmer')
                        <a href="{{ route('programmer.index') }}" class="p-6 rounded-xl border border-blue-200 bg-blue-50/50 hover:bg-blue-50 transition group flex flex-col justify-between">
                            <div>
                                <span class="px-2.5 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-700">Programmer</span>
                                <h4 class="text-lg font-bold text-gray-900 mt-3 group-hover:text-blue-700 transition">Dashboard Programmer & Tugas Saya &rarr;</h4>
                                <p class="text-xs text-gray-600 mt-1">Lihat tugas yang tersedia, kerjakan (Managed), dan tandai selesai (Done).</p>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
