<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\ProjectMemberController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [DashboardController::class, 'index']);


Route::get('/index', [TaskController::class, 'showAllTasks']);
Route::get('/create', [TaskController::class, 'create']);
Route::post('/create', [TaskController::class, 'store']);

Route::get('/members/add', [ProjectMemberController::class, 'create']);

Route::post('/members', [ProjectMemberController::class, 'store']);


