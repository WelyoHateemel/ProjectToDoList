<x-app-layout>
    <div
        x-data="programmerBoard()"
        class="min-h-screen bg-gray-100"
    >
        <div class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">
                        Programmer
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Kelola tugas tim pengembangan
                    </p>
                </div>

                <button
                    type="button"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg"
                >
                    + Tugas Baru
                </button>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-6">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

                <div class="bg-white border rounded-lg p-4">
                    <p class="text-sm text-gray-500">Total</p>
                    <p
                        class="text-2xl font-semibold text-gray-900 mt-1"
                        x-text="tasks.length"
                    ></p>
                </div>

                <div class="bg-white border rounded-lg p-4">
                    <p class="text-sm text-gray-500">Publish</p>
                    <p
                        class="text-2xl font-semibold text-blue-600 mt-1"
                        x-text="countStatus('publish')"
                    ></p>
                </div>

                <div class="bg-white border rounded-lg p-4">
                    <p class="text-sm text-gray-500">Managed</p>
                    <p
                        class="text-2xl font-semibold text-orange-500 mt-1"
                        x-text="countStatus('managed')"
                    ></p>
                </div>

                <div class="bg-white border rounded-lg p-4">
                    <p class="text-sm text-gray-500">Done</p>
                    <p
                        class="text-2xl font-semibold text-green-600 mt-1"
                        x-text="countStatus('done')"
                    ></p>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                <template x-for="column in columns" :key="column.id">
                    <div
                        class="bg-gray-50 border rounded-xl min-h-[500px]"
                        @dragover.prevent
                        @drop.prevent="dropTask(column.id)"
                    >

                        <div class="px-4 py-3 bg-white border-b rounded-t-xl">
                            <div class="flex items-center gap-2">

                                <span
                                    class="w-3 h-3 rounded-full"
                                    :class="{
                                        'bg-blue-500': column.id === 'publish',
                                        'bg-orange-500': column.id === 'managed',
                                        'bg-green-500': column.id === 'done'
                                    }"
                                ></span>

                                <span
                                    class="font-semibold text-gray-900"
                                    x-text="column.name"
                                ></span>

                                <span
                                    class="text-sm text-gray-500"
                                    x-text="countStatus(column.id)"
                                ></span>

                            </div>
                        </div>

                        <div class="p-4 space-y-3">

                            <template
                                x-for="task in tasks.filter(item => item.status === column.id)"
                                :key="task.id"
                            >

                                <div
                                    draggable="true"
                                    @dragstart="dragTask(task.id)"
                                    class="bg-white border rounded-lg p-4 shadow-sm cursor-grab active:cursor-grabbing hover:shadow-md transition"
                                >

                                    <div class="flex items-start justify-between gap-3">

                                        <h3
                                            class="font-semibold text-gray-900 text-sm"
                                            x-text="task.title"
                                        ></h3>

                                        <span
                                            class="px-2 py-1 text-xs rounded-full whitespace-nowrap"
                                            :class="{
                                                'bg-green-100 text-green-700': task.priority === 'Low',
                                                'bg-yellow-100 text-yellow-700': task.priority === 'Medium',
                                                'bg-red-100 text-red-700': task.priority === 'High'
                                            }"
                                            x-text="task.priority"
                                        ></span>

                                    </div>

                                    <p
                                        class="text-sm text-gray-500 mt-2 leading-5"
                                        x-text="task.description"
                                    ></p>

                                    <div class="border-t mt-4 pt-3 flex items-center justify-between">

                                        <span
                                            class="text-xs text-gray-500"
                                            x-text="task.user"
                                        ></span>

                                        <span
                                            class="text-xs text-gray-500"
                                            x-text="task.date"
                                        ></span>

                                    </div>

                                </div>

                            </template>

                            <div
                                x-show="countStatus(column.id) === 0"
                                class="flex items-center justify-center h-32 text-sm text-gray-400"
                            >
                                Tidak ada tugas
                            </div>

                        </div>
                    </div>
                </template>

            </div>
        </div>
    </div>

    <script>
        function programmerBoard() {
            return {
                draggedTaskId: null,

                columns: [
                    {
                        id: 'publish',
                        name: 'Publish'
                    },
                    {
                        id: 'managed',
                        name: 'Managed'
                    },
                    {
                        id: 'done',
                        name: 'Done'
                    }
                ],

                tasks: [
                    {
                        id: 1,
                        title: 'Testing Keamanan Route Middleware',
                        description: 'Uji otorisasi role programmer dan role manager agar tidak bisa saling akses route terlarang.',
                        priority: 'Low',
                        user: 'Welyo Developer',
                        date: '06 Oct 2026',
                        status: 'publish'
                    },
                    {
                        id: 2,
                        title: 'Perbaiki Sistem Register & Validasi Role',
                        description: 'Memastikan setiap pengguna baru memiliki role Programmer atau Role Manager dengan validasi ketat.',
                        priority: 'High',
                        user: 'El Programmer',
                        date: '03 Oct 2026',
                        status: 'done'
                    },
                    {
                        id: 3,
                        title: 'Integrasi Dashboard Role Manager & Programmer',
                        description: 'Membuat antarmuka to-do kanban terpisah yang interaktif untuk publish, managed, dan done.',
                        priority: 'High',
                        user: 'El Programmer',
                        date: '05 Oct 2026',
                        status: 'done'
                    },
                    {
                        id: 4,
                        title: 'Perbaiki Bug Login User',
                        description: 'Memperbaiki masalah login yang gagal saat menggunakan akun yang sudah terdaftar.',
                        priority: 'Low',
                        user: 'Welyo Developer',
                        date: '01 Oct 2026',
                        status: 'managed'
                    }
                ],

                dragTask(id) {
                    this.draggedTaskId = id
                },

                dropTask(status) {
                    const task = this.tasks.find(
                        item => item.id === this.draggedTaskId
                    )

                    if (task) {
                        task.status = status
                    }

                    this.draggedTaskId = null
                },

                countStatus(status) {
                    return this.tasks.filter(
                        task => task.status === status
                    ).length
                }
            }
        }
    </script>
</x-app-layout>
