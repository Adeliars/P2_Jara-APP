<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::middleware(['auth'])->group(function () {
    // Menampilkan daftar project
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    
    // Menyimpan project baru (SRS-007)
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    
    // Mengubah nama project
    Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
    
    // Menghapus project (SRS-008 - Kerangka dasar)
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    

});
Route::get('/', function () {
    return view('welcome');
});
