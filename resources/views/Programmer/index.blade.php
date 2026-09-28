<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-blue-100 text-blue-700 border border-blue-200">
                        💻 Programmer
                    </span>
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                        {{ __('Dashboard & Tugas Saya') }}
                    </h2>
                </div>
                <p class="text-sm text-gray-500 mt-1">Daftar tugas yang ditugaskan kepada Anda dan tugas umum yang siap dikerjakan</p>
            </div>

            <!-- Profile Info pill -->
            <div class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-lg border border-gray-200 text-xs text-gray-600">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Masuk sebagai: <strong>{{ Auth::user()->name }}</strong></span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Alert -->
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-lg leading-none">&times;</button>
                </div>
            @endif

            <!-- Stats Bar -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Tugas Terkait</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                    <span class="text-[11px] text-gray-400">Tugas tersedia & ditugaskan</span>
                </div>
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm border-l-4 border-l-blue-500">
                    <p class="text-xs font-medium text-blue-600 uppercase tracking-wider">Publish (Siap Ambil)</p>
                    <p class="text-2xl font-bold text-blue-700 mt-1">{{ $stats['publish'] }}</p>
                    <span class="text-[11px] text-gray-400">Bisa Anda kerjakan</span>
                </div>
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm border-l-4 border-l-amber-500">
                    <p class="text-xs font-medium text-amber-600 uppercase tracking-wider">Managed (Sedang Aktif)</p>
                    <p class="text-2xl font-bold text-amber-700 mt-1">{{ $stats['managed'] }}</p>
                    <span class="text-[11px] text-gray-400">Dalam pengerjaan Anda</span>
                </div>
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm border-l-4 border-l-emerald-500">
                    <p class="text-xs font-medium text-emerald-600 uppercase tracking-wider">Done (Selesai)</p>
                    <p class="text-2xl font-bold text-emerald-700 mt-1">{{ $stats['done'] }}</p>
                    <span class="text-[11px] text-gray-400">Telah terselesaikan</span>
                </div>
            </div>

            <!-- Filter Status Tab -->
            <div class="flex items-center justify-between bg-white p-2.5 rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-1">
                    <a href="{{ route('programmer.index') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold {{ !request('status') ? 'bg-indigo-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        Semua Tugas
                    </a>
                    <a href="{{ route('programmer.index', ['status' => 'publish']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold {{ request('status') === 'publish' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        Publish (Tersedia)
                    </a>
                    <a href="{{ route('programmer.index', ['status' => 'managed']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold {{ request('status') === 'managed' ? 'bg-amber-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        Managed (Dikerjakan)
                    </a>
                    <a href="{{ route('programmer.index', ['status' => 'done']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold {{ request('status') === 'done' ? 'bg-emerald-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        Done (Selesai)
                    </a>
                </div>
                <span class="text-xs text-gray-400 mr-2 hidden sm:inline">
                    {{ $tasks->count() }} tugas ditampilkan
                </span>
            </div>

            <!-- Task Grid for Programmer -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($tasks as $task)
                    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <!-- Header: Status Badge & Priority -->
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    @if($task->status === 'publish')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Publish
                                        </span>
                                    @elseif($task->status === 'managed')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Sedang Dikerjakan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai
                                        </span>
                                    @endif
                                </div>

                                <div>
                                    @if($task->priority === 'high')
                                        <span class="px-2 py-0.5 text-[11px] font-bold rounded bg-rose-100 text-rose-700">Tinggi</span>
                                    @elseif($task->priority === 'low')
                                        <span class="px-2 py-0.5 text-[11px] font-medium rounded bg-gray-100 text-gray-700">Rendah</span>
                                    @else
                                        <span class="px-2 py-0.5 text-[11px] font-medium rounded bg-amber-100 text-amber-700">Sedang</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Title -->
                            <h3 class="font-bold text-gray-900 text-base leading-snug">
                                {{ $task->title }}
                            </h3>

                            <!-- Description -->
                            @if($task->description)
                                <p class="text-xs text-gray-600 mt-2 line-clamp-3 leading-relaxed">
                                    {{ $task->description }}
                                </p>
                            @endif

                            <!-- Meta: Creator, Assignee, Deadline -->
                            <div class="mt-4 pt-3 border-t border-gray-100 space-y-1.5 text-xs text-gray-500">
                                @if($task->creator)
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-gray-400">Dibuat oleh:</span>
                                        <span class="font-medium text-gray-700">{{ $task->creator->name }}</span>
                                    </div>
                                @endif

                                <div class="flex items-center justify-between pt-1">
                                    <div>
                                        @if($task->assigned_to === Auth::id())
                                            <span class="inline-flex items-center gap-1 text-emerald-600 font-medium">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Tugas Anda
                                            </span>
                                        @else
                                            <span class="text-gray-400 italic">Terbuka / Belum diambil</span>
                                        @endif
                                    </div>

                                    @if($task->due_date)
                                        <div class="flex items-center gap-1 text-[11px] font-medium text-gray-500">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Tenggat: {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Programmer Action Buttons -->
                        <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-end gap-2">
                            @if($task->status === 'publish')
                                <form method="POST" action="{{ route('programmer.tasks.status', $task) }}" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="managed">
                                    <button type="submit" class="w-full py-2 px-3 text-xs font-semibold rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white flex items-center justify-center gap-1.5 transition shadow-sm shadow-indigo-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Ambil & Mulai Kerjakan (Managed)
                                    </button>
                                </form>
                            @elseif($task->status === 'managed')
                                <form method="POST" action="{{ route('programmer.tasks.status', $task) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="publish">
                                    <button type="submit" class="py-1.5 px-3 text-xs font-medium rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition">
                                        Kembalikan ke Publish
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('programmer.tasks.status', $task) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="done">
                                    <button type="submit" class="py-1.5 px-3 text-xs font-semibold rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white flex items-center gap-1 transition shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Tandai Selesai (Done)
                                    </button>
                                </form>
                            @elseif($task->status === 'done')
                                <form method="POST" action="{{ route('programmer.tasks.status', $task) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="managed">
                                    <button type="submit" class="py-1.5 px-3 text-xs font-medium rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 transition">
                                        Buka Kembali (Managed)
                                    </button>
                                </form>
                                <span class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Tuntas
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-12 rounded-2xl border border-dashed border-gray-200 text-center">
                        <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto text-xl mb-3">
                            📋
                        </div>
                        <h4 class="font-bold text-gray-800 text-base">Tidak Ada Tugas</h4>
                        <p class="text-xs text-gray-500 mt-1">Saat ini belum ada tugas yang sesuai dengan filter yang Anda pilih.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
