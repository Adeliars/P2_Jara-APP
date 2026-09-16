<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function create() {
        return view('task.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'status' => 'required|string|max:50',
            'prioritas' => 'required|string|max:50',
            'deadline' => 'required|date',
        ]);


        Task::create($validated);

        return redirect()->route('task.index');
    }

    public function showAllTasks() {
        $tasks = Task::query();

        return view('task.index', compact('tasks'));
    }
}
