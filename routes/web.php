<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CollaborationController;

Route::get('/', function () {
    return view('welcome');
});


// Halaman form tambah anggota
Route::get(
    '/project/{projectId}/member',
    [CollaborationController::class, 'index']
);


// Proses tambah anggota
Route::post(
    '/project/{projectId}/member',
    [CollaborationController::class, 'addMember']
);