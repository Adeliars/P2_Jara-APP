<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectMemberController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/members/add', [ProjectMemberController::class, 'create']);

Route::post('/members', [ProjectMemberController::class, 'store']);
