<div
    class="task-card bg-white border rounded-lg p-4 shadow-sm cursor-grab active:cursor-grabbing hover:shadow-md transition"
    draggable="true"
    data-task-id="{{ $task->id }}"
>
    <div class="flex items-start justify-between gap-3">

        <div class="min-w-0">
            <h4 class="text-sm font-semibold text-gray-800">
                {{ $task->title }}
            </h4>

            @if($task->description)
                <p class="mt-1 text-xs text-gray-500">
                    {{ $task->description }}
                </p>
            @endif
        </div>

        <span
            class="shrink-0 text-xs px-2 py-1 rounded-full
            @if($task->priority === 'high')
                bg-red-100 text-red-700
            @elseif($task->priority === 'medium')
                bg-yellow-100 text-yellow-700
            @else
                bg-green-100 text-green-700
            @endif"
        >
            {{ ucfirst($task->priority) }}
        </span>

    </div>

    <div class="mt-3 pt-3 border-t flex items-center justify-between">

        <div class="text-xs text-gray-500">
            @if($programmerName)
                 {{ $programmerName }}
            @else
                Belum ditugaskan
            @endif
        </div>

        @if($task->due_date)
            <div class="text-xs text-gray-500">
                 {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
            </div>
        @endif

    </div>
</div>
