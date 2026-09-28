<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RoleManagerController extends Controller
{
    /**
     * Display Role Manager Dashboard and Task Board
     */
    public function index(Request $request): View
    {
        $programmers = User::whereRaw("LOWER(REPLACE(REPLACE(REPLACE(role, ' ', ''), '_', ''), '-', '')) = 'programmer'")
            ->orderBy('name')
            ->get();

        $tasksQuery = Task::with(['creator', 'assignee'])->latest();

        if ($request->filled('assigned_to')) {
            $tasksQuery->where('assigned_to', $request->assigned_to);
        }

        if ($request->filled('priority')) {
            $tasksQuery->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $tasksQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $allTasks = $tasksQuery->get();

        $publishTasks = $allTasks->where('status', 'publish');
        $managedTasks = $allTasks->where('status', 'managed');
        $doneTasks = $allTasks->where('status', 'done');

        $stats = [
            'total' => $allTasks->count(),
            'publish' => $publishTasks->count(),
            'managed' => $managedTasks->count(),
            'done' => $doneTasks->count(),
            'total_programmers' => $programmers->count(),
        ];

        return view('RoleManager.index', compact(
            'programmers',
            'publishTasks',
            'managedTasks',
            'doneTasks',
            'stats'
        ));
    }

    /**
     * Store a newly created task in storage.
     */
    public function storeTask(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:publish,managed,done',
            'priority' => 'required|in:low,medium,high',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        $validated['user_id'] = auth()->id();

        Task::create($validated);

        return redirect()->route('rolemanager.index')->with('success', 'Tugas / To-Do berhasil ditambahkan!');
    }

    /**
     * Update the specified task status or details.
     */
    public function updateTask(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:publish,managed,done',
            'priority' => 'required|in:low,medium,high',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        return redirect()->route('rolemanager.index')->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Quick status update (e.g. move between publish, managed, done).
     */
    public function updateStatus(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:publish,managed,done',
        ]);

        $task->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Status tugas berhasil dipindahkan!');
    }

    /**
     * Remove the specified task.
     */
    public function destroyTask(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('rolemanager.index')->with('success', 'Tugas berhasil dihapus!');
    }
}
