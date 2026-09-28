<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProgrammerController extends Controller
{
    /**
     * Display Programmer Dashboard with tasks assigned to this programmer
     */
    public function index(Request $request): View
    {
        $user = auth()->user();

        // Tasks assigned to programmer or open publish tasks
        $tasksQuery = Task::with(['creator', 'assignee'])
            ->where(function ($query) use ($user) {
                $query->where('assigned_to', $user->id)
                      ->orWhereNull('assigned_to');
            })
            ->latest();

        if ($request->filled('status')) {
            $tasksQuery->where('status', $request->status);
        }

        $tasks = $tasksQuery->get();

        $publishCount = Task::where(function ($q) use ($user) {
            $q->where('assigned_to', $user->id)->orWhereNull('assigned_to');
        })->where('status', 'publish')->count();

        $managedCount = Task::where('assigned_to', $user->id)->where('status', 'managed')->count();
        $doneCount = Task::where('assigned_to', $user->id)->where('status', 'done')->count();

        $stats = [
            'total' => $tasks->count(),
            'publish' => $publishCount,
            'managed' => $managedCount,
            'done' => $doneCount,
        ];

        return view('Programmer.index', compact('tasks', 'stats'));
    }

    /**
     * Update task status by programmer (e.g. taking task into managed or completing to done)
     */
    public function updateStatus(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:publish,managed,done',
        ]);

        $user = auth()->user();

        // If programmer picks up a task, assign to them if unassigned
        $updateData = ['status' => $validated['status']];
        if (!$task->assigned_to && $validated['status'] === 'managed') {
            $updateData['assigned_to'] = $user->id;
        }

        $task->update($updateData);

        return redirect()->back()->with('success', 'Status tugas berhasil diperbarui!');
    }
}
