<x-app-layout>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Role Manager
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Kelola tugas tim pengembang
                </p>
            </div>

            <button
                type="button"
                onclick="openCreateModal()"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition"
            >
                + Tugas Baru
            </button>
        </div>
    </x-slot>


    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ====================================================== --}}
            {{-- ALERT SUCCESS --}}
            {{-- ====================================================== --}}
            @if(session('success'))
                <div class="mb-5 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif


            {{-- ====================================================== --}}
            {{-- ALERT ERROR --}}
            {{-- ====================================================== --}}
            @if($errors->any())
                <div class="mb-5 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {{-- ====================================================== --}}
            {{-- SUMMARY --}}
            {{-- ====================================================== --}}
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">

                <div class="bg-white border rounded-lg p-4">
                    <p class="text-xs text-gray-500">
                        Total
                    </p>

                    <p class="text-2xl font-semibold text-gray-800">
                        {{ $stats['total'] }}
                    </p>
                </div>


                <div class="bg-white border rounded-lg p-4">
                    <p class="text-xs text-gray-500">
                        Publish
                    </p>

                    <p class="text-2xl font-semibold text-blue-600">
                        {{ $stats['publish'] }}
                    </p>
                </div>


                <div class="bg-white border rounded-lg p-4">
                    <p class="text-xs text-gray-500">
                        Managed
                    </p>

                    <p class="text-2xl font-semibold text-amber-600">
                        {{ $stats['managed'] }}
                    </p>
                </div>


                <div class="bg-white border rounded-lg p-4">
                    <p class="text-xs text-gray-500">
                        Done
                    </p>

                    <p class="text-2xl font-semibold text-green-600">
                        {{ $stats['done'] }}
                    </p>
                </div>


                <div class="bg-white border rounded-lg p-4">
                    <p class="text-xs text-gray-500">
                        Programmer
                    </p>

                    <p class="text-2xl font-semibold text-purple-600">
                        {{ $stats['total_programmers'] }}
                    </p>
                </div>

            </div>


            {{-- ====================================================== --}}
            {{-- KANBAN --}}
            {{-- ====================================================== --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">


                {{-- ================================================== --}}
                {{-- PUBLISH --}}
                {{-- ================================================== --}}
                <div class="bg-gray-50 border rounded-xl overflow-hidden">

                    <div class="px-4 py-3 bg-white border-b flex items-center justify-between">

                        <div class="flex items-center gap-2">

                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>

                            <h3 class="text-sm font-semibold text-gray-800">
                                Publish
                            </h3>

                            <span
                                id="count-publish"
                                class="text-xs text-gray-500"
                            >
                                {{ $publishTasks->count() }}
                            </span>

                        </div>

                    </div>


                    <div
                        id="column-publish"
                        data-status="publish"
                        class="task-column min-h-[300px] p-4 space-y-3"
                    >

                        @forelse($publishTasks as $task)

                            @include('RoleManager._task_card', [
                                'task' => $task,
                                'column' => 'publish',
                                'programmerName' => optional(
                                    $programmers->firstWhere('id', $task->assigned_to)
                                )->name
                            ])

                        @empty

                            <div class="empty-state text-center text-xs text-gray-400 py-10">
                                Tidak ada tugas
                            </div>

                        @endforelse

                    </div>

                </div>


                {{-- ================================================== --}}
                {{-- MANAGED --}}
                {{-- ================================================== --}}
                <div class="bg-gray-50 border rounded-xl overflow-hidden">

                    <div class="px-4 py-3 bg-white border-b flex items-center justify-between">

                        <div class="flex items-center gap-2">

                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>

                            <h3 class="text-sm font-semibold text-gray-800">
                                Managed
                            </h3>

                            <span
                                id="count-managed"
                                class="text-xs text-gray-500"
                            >
                                {{ $managedTasks->count() }}
                            </span>

                        </div>

                    </div>


                    <div
                        id="column-managed"
                        data-status="managed"
                        class="task-column min-h-[300px] p-4 space-y-3"
                    >

                        @forelse($managedTasks as $task)

                            @include('RoleManager._task_card', [
                                'task' => $task,
                                'column' => 'managed',
                                'programmerName' => optional(
                                    $programmers->firstWhere('id', $task->assigned_to)
                                )->name
                            ])

                        @empty

                            <div class="empty-state text-center text-xs text-gray-400 py-10">
                                Tidak ada tugas
                            </div>

                        @endforelse

                    </div>

                </div>


                {{-- ================================================== --}}
                {{-- DONE --}}
                {{-- ================================================== --}}
                <div class="bg-gray-50 border rounded-xl overflow-hidden">

                    <div class="px-4 py-3 bg-white border-b flex items-center justify-between">

                        <div class="flex items-center gap-2">

                            <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>

                            <h3 class="text-sm font-semibold text-gray-800">
                                Done
                            </h3>

                            <span
                                id="count-done"
                                class="text-xs text-gray-500"
                            >
                                {{ $doneTasks->count() }}
                            </span>

                        </div>

                    </div>


                    <div
                        id="column-done"
                        data-status="done"
                        class="task-column min-h-[300px] p-4 space-y-3"
                    >

                        @forelse($doneTasks as $task)

                            @include('RoleManager._task_card', [
                                'task' => $task,
                                'column' => 'done',
                                'programmerName' => optional(
                                    $programmers->firstWhere('id', $task->assigned_to)
                                )->name
                            ])

                        @empty

                            <div class="empty-state text-center text-xs text-gray-400 py-10">
                                Tidak ada tugas
                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>
    </div>


    {{-- ====================================================== --}}
    {{-- MODAL CREATE TASK --}}
    {{-- ====================================================== --}}
    <div
        id="modalCreateTask"
        class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center p-4"
    >

        <div class="bg-white rounded-xl w-full max-w-lg shadow-xl">

            {{-- HEADER --}}
            <div class="flex items-center justify-between px-6 py-4 border-b">

                <h3 class="text-lg font-semibold text-gray-800">
                    Tugas Baru
                </h3>

                <button
                    type="button"
                    onclick="closeCreateModal()"
                    class="text-gray-400 hover:text-gray-700 text-xl"
                >
                    &times;
                </button>

            </div>


            {{-- FORM --}}
            <form
                method="POST"
                action="{{ route('rolemanager.tasks.store') }}"
                class="p-6 space-y-4"
            >

                @csrf


                {{-- TITLE --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Judul
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        required
                        placeholder="Contoh: Buat halaman login"
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >

                </div>


                {{-- DESCRIPTION --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Deskripsi
                    </label>

                    <textarea
                        name="description"
                        rows="3"
                        placeholder="Deskripsi tugas..."
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >{{ old('description') }}</textarea>

                </div>


                {{-- PRIORITY --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Prioritas
                    </label>

                    <select
                        name="priority"
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >

                        <option
                            value="low"
                            {{ old('priority') === 'low' ? 'selected' : '' }}
                        >
                            Low
                        </option>

                        <option
                            value="medium"
                            {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}
                        >
                            Medium
                        </option>

                        <option
                            value="high"
                            {{ old('priority') === 'high' ? 'selected' : '' }}
                        >
                            High
                        </option>

                    </select>

                </div>


                {{-- PROGRAMMER + DEADLINE --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Programmer
                        </label>

                        <select
                            name="assigned_to"
                            class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                            <option value="">
                                Belum ditugaskan
                            </option>

                            @foreach($programmers as $p)

                                <option
                                    value="{{ $p->id }}"
                                    {{ old('assigned_to') == $p->id ? 'selected' : '' }}
                                >
                                    {{ $p->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Deadline
                        </label>

                        <input
                            type="date"
                            name="due_date"
                            value="{{ old('due_date') }}"
                            class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >

                    </div>

                </div>


                {{-- BUTTON --}}
                <div class="flex justify-end gap-2 pt-4 border-t">

                    <button
                        type="button"
                        onclick="closeCreateModal()"
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm rounded-lg"
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg"
                    >
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- DRAG & DROP SCRIPT --}}
    {{-- ====================================================== --}}
    <script>

        /*
        |--------------------------------------------------------------------------
        | GLOBAL VARIABLES
        |--------------------------------------------------------------------------
        */

        let draggedTask = null;
        let originalColumn = null;


        /*
        |--------------------------------------------------------------------------
        | CREATE MODAL
        |--------------------------------------------------------------------------
        */

        function openCreateModal() {

            const modal = document.getElementById('modalCreateTask');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }


        function closeCreateModal() {

            const modal = document.getElementById('modalCreateTask');

            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }


        /*
        |--------------------------------------------------------------------------
        | DRAG START
        |--------------------------------------------------------------------------
        */

        function handleDragStart(event) {

            draggedTask = event.currentTarget;

            originalColumn =
                draggedTask.closest('.task-column');


            draggedTask.classList.add(
                'opacity-50',
                'scale-[0.98]'
            );


            event.dataTransfer.effectAllowed = 'move';


            event.dataTransfer.setData(
                'text/plain',
                draggedTask.dataset.taskId
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DRAG END
        |--------------------------------------------------------------------------
        */

        function handleDragEnd(event) {

            event.currentTarget.classList.remove(
                'opacity-50',
                'scale-[0.98]'
            );


            document.querySelectorAll('.task-column').forEach(
                column => {

                    column.classList.remove(
                        'ring-2',
                        'ring-indigo-300',
                        'bg-indigo-50'
                    );

                }
            );


            /*
            | Jangan hapus referensi terlalu cepat.
            | handleDrop sudah menyimpan referensi lokal.
            */

            draggedTask = null;
            originalColumn = null;
        }


        /*
        |--------------------------------------------------------------------------
        | DRAG OVER
        |--------------------------------------------------------------------------
        */

        function handleDragOver(event) {

            event.preventDefault();

            const column = event.currentTarget;


            column.classList.add(
                'ring-2',
                'ring-indigo-300',
                'bg-indigo-50'
            );


            event.dataTransfer.dropEffect = 'move';
        }


        /*
        |--------------------------------------------------------------------------
        | DRAG LEAVE
        |--------------------------------------------------------------------------
        */

        function handleDragLeave(event) {

            const column = event.currentTarget;

            column.classList.remove(
                'ring-2',
                'ring-indigo-300',
                'bg-indigo-50'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DROP
        |--------------------------------------------------------------------------
        */

        async function handleDrop(event) {

            event.preventDefault();


            const column = event.currentTarget;


            column.classList.remove(
                'ring-2',
                'ring-indigo-300',
                'bg-indigo-50'
            );


            /*
            |--------------------------------------------------------------------------
            | Simpan referensi task dan kolom ke variable lokal
            |--------------------------------------------------------------------------
            |
            | Ini penting karena handleDragEnd() bisa mengubah
            | draggedTask menjadi null.
            |
            */

            const taskElement = draggedTask;
            const oldColumn = originalColumn;


            if (!taskElement || !oldColumn) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Ambil task ID
            |--------------------------------------------------------------------------
            */

            const taskId =
                taskElement.dataset.taskId;


            /*
            |--------------------------------------------------------------------------
            | Ambil status baru
            |--------------------------------------------------------------------------
            */

            const newStatus =
                column.dataset.status;


            console.log('Drag & Drop:', {
                taskId: taskId,
                oldStatus: oldColumn.dataset.status,
                newStatus: newStatus
            });


            if (!taskId) {

                console.error(
                    'Task ID tidak ditemukan.',
                    taskElement
                );

                alert('ID task tidak ditemukan.');

                return;
            }


            if (!newStatus) {

                console.error(
                    'Status baru tidak ditemukan.'
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Jika masih di kolom yang sama
            |--------------------------------------------------------------------------
            */

            if (oldColumn === column) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Hapus empty state dari kolom tujuan
            |--------------------------------------------------------------------------
            */

            removeEmptyState(column);


            /*
            |--------------------------------------------------------------------------
            | Pindahkan task di UI
            |--------------------------------------------------------------------------
            */

            column.appendChild(taskElement);


            /*
            |--------------------------------------------------------------------------
            | Update empty state kolom lama
            |--------------------------------------------------------------------------
            */

            updateEmptyState(oldColumn);


            /*
            |--------------------------------------------------------------------------
            | KIRIM STATUS KE LARAVEL
            |--------------------------------------------------------------------------
            |
            | Jangan menggunakan:
            |
            | route('rolemanager.tasks.status')
            |
            | karena route membutuhkan {task}.
            |
            | Kita membuat URL menggunakan task ID yang diperoleh
            | dari JavaScript.
            |
            */

            const statusUrl =
                "{{ url('/role-manager/tasks') }}/"
                + encodeURIComponent(taskId)
                + "/status";


            console.log(
                'Sending PATCH request:',
                statusUrl
            );


            try {

                const response = await fetch(
                    statusUrl,
                    {
                        method: 'PATCH',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document
                                    .querySelector(
                                        'meta[name="csrf-token"]'
                                    )
                                    .getAttribute('content')
                        },

                        body: JSON.stringify({

                            /*
                            | Task ID dikirim juga sebagai body.
                            | Controller bisa menggunakan route parameter
                            | sebagai sumber utama.
                            */

                            task_id: taskId,

                            status: newStatus
                        })
                    }
                );


                /*
                |--------------------------------------------------------------------------
                | Ambil response
                |--------------------------------------------------------------------------
                */

                let data = {};

                try {

                    data = await response.json();

                } catch (jsonError) {

                    console.warn(
                        'Response bukan JSON.',
                        jsonError
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Request gagal
                |--------------------------------------------------------------------------
                */

                if (!response.ok || data.success === false) {

                    console.error(
                        'Update status gagal:',
                        data
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Rollback UI
                    |--------------------------------------------------------------------------
                    */

                    oldColumn.appendChild(
                        taskElement
                    );


                    updateEmptyState(column);

                    updateEmptyState(oldColumn);


                    alert(
                        data.message ||
                        'Gagal mengubah status tugas.'
                    );


                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Berhasil
                |--------------------------------------------------------------------------
                */

                console.log(
                    'Status berhasil diperbarui:',
                    data
                );


                /*
                |--------------------------------------------------------------------------
                | Update jumlah task
                |--------------------------------------------------------------------------
                */

                updateColumnCounts();

            } catch (error) {

                console.error(
                    'Error saat update status:',
                    error
                );


                /*
                |--------------------------------------------------------------------------
                | Rollback UI
                |--------------------------------------------------------------------------
                */

                oldColumn.appendChild(
                    taskElement
                );


                updateEmptyState(column);

                updateEmptyState(oldColumn);


                updateColumnCounts();


                alert(
                    'Terjadi kesalahan saat mengubah status tugas.'
                );
            }

        }


        /*
        |--------------------------------------------------------------------------
        | REMOVE EMPTY STATE
        |--------------------------------------------------------------------------
        */

        function removeEmptyState(column) {

            if (!column) {
                return;
            }


            const empty =
                column.querySelector('.empty-state');


            if (empty) {
                empty.remove();
            }
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE EMPTY STATE
        |--------------------------------------------------------------------------
        */

        function updateEmptyState(column) {

            if (!column) {
                return;
            }


            const tasks =
                column.querySelectorAll(
                    '.task-card'
                );


            const empty =
                column.querySelector(
                    '.empty-state'
                );


            /*
            |--------------------------------------------------------------------------
            | Tidak ada task
            |--------------------------------------------------------------------------
            */

            if (
                tasks.length === 0 &&
                !empty
            ) {

                const div =
                    document.createElement('div');


                div.className =
                    'empty-state text-center text-xs text-gray-400 py-10';


                div.innerText =
                    'Tidak ada tugas';


                column.appendChild(div);
            }


            /*
            |--------------------------------------------------------------------------
            | Ada task
            |--------------------------------------------------------------------------
            */

            if (
                tasks.length > 0 &&
                empty
            ) {

                empty.remove();
            }
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE COLUMN COUNTS
        |--------------------------------------------------------------------------
        */

        function updateColumnCounts() {

            const statuses = [
                'publish',
                'managed',
                'done'
            ];


            statuses.forEach(
                status => {

                    const column =
                        document.getElementById(
                            'column-' + status
                        );


                    if (!column) {
                        return;
                    }


                    const count =
                        column.querySelectorAll(
                            '.task-card'
                        ).length;


                    const countElement =
                        document.getElementById(
                            'count-' + status
                        );


                    if (countElement) {

                        countElement.innerText =
                            count;
                    }

                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | REGISTER EVENTS
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'DOMContentLoaded',
            function () {


                /*
                |--------------------------------------------------------------------------
                | TASK CARDS
                |--------------------------------------------------------------------------
                */

                const cards =
                    document.querySelectorAll(
                        '.task-card'
                    );


                cards.forEach(
                    card => {

                        card.addEventListener(
                            'dragstart',
                            handleDragStart
                        );


                        card.addEventListener(
                            'dragend',
                            handleDragEnd
                        );

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | COLUMNS
                |--------------------------------------------------------------------------
                */

                const columns =
                    document.querySelectorAll(
                        '.task-column'
                    );


                columns.forEach(
                    column => {

                        column.addEventListener(
                            'dragover',
                            handleDragOver
                        );


                        column.addEventListener(
                            'dragleave',
                            handleDragLeave
                        );


                        column.addEventListener(
                            'drop',
                            handleDrop
                        );

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | CLOSE MODAL WHEN CLICKING OUTSIDE
                |--------------------------------------------------------------------------
                */

                const modal =
                    document.getElementById(
                        'modalCreateTask'
                    );


                if (modal) {

                    modal.addEventListener(
                        'click',
                        function (event) {

                            if (
                                event.target === modal
                            ) {

                                closeCreateModal();
                            }

                        }
                    );

                }

            }
        );

    </script>

</x-app-layout>
