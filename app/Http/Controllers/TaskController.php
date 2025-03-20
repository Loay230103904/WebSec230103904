<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Auth::user()->tasks ?? collect(); 
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Auth::user()->tasks()->create(['name' => $request->name]);

        return redirect()->route('tasks.index')->with('success', 'Task added successfully!');
    }

    public function update(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->update(['status' => !$task->status]);
        return redirect()->route('tasks.index')->with('success', 'Task status updated!');
    }
}

