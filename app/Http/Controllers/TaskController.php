<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function create() {

        return view('tasks.create');
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


        return redirect()->route('tasks.index');
    }

    public function showAllTasks(Request $request) {
        $filter = $request->input('filter');
        $search = $request->input('search');

        $tasks = Task::when($search, function ($query, $search) {
            return $query->where('judul', 'like', '%' . $search . '%');
        })
        ->when($filter == 'low', function ($query, $value) {
            return $query->where('prioritas', 'low');
        })
        ->when($filter == 'medium', function ($query, $value) {
            return $query->where('prioritas', 'medium');
        })
        ->when($filter == 'high', function ($query, $value) {
            return $query->where('prioritas', 'high');
        })->paginate(50)->withQueryString();

        return view('tasks.index', compact('tasks', 'filter', 'search'));
    }

    public function editTaks(Request $request, Task $task) {    
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required',
            'status' => 'required|string|max:50',
            'prioritas' => 'required|string|max:50',
            'deadline' => 'required|date',
        ]);

        $task->update($validated);

        return redirect()->back()->with('success', 'task berhasil di edit');
    }

    public function showUpdateForm(Task $task) {
        return view('tasks.update', compact('task'));
    }

    public function removeTask(Request $request) {
        $task = Task::where('id', $request->id)->findOrFail();

        $task->delete();

        return redirect()->back()->with('success', 'task berhasil dihapus');
    }



}
