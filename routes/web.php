<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CollaborationController;
use App\Http\Controllers\TaskController;


Route::get('/', function () {
    return view('welcome');
});


// Team Collaboration
Route::get(
    '/project/{projectId}/member',
    [CollaborationController::class, 'index']
);

Route::post(
    '/project/{projectId}/member',
    [CollaborationController::class, 'addMember']
);


// Task
Route::resource('tasks', TaskController::class);