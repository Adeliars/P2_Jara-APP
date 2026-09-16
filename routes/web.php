<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tasks/index', [TaskController::class, 'showAllTasks'])->name('showAllTasks');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('create-tasks');
Route::post('/tasks/create', [TaskController::class, 'store'])->name('createTasks');
Route::get('/tasks/update', [TaskController::class, 'showUpdateForm'])->name('task-update');
Route::put('/tasks/update', [TaskController::class, 'editTask'])->name('updateTask');
Route::delete('/tasks/delete', [TaskController::class, 'removeTask'])->name('deleteTask');
