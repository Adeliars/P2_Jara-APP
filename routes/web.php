<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', [TaskController::class, 'showAllTasks']);
Route::get('/create', [TaskController::class, 'create']);
Route::post('/create', [TaskController::class, 'store']);
