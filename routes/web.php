<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenitipanController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', function () {
    return view('landing');
})->name('penitipan.landing');

// Form page
Route::get('/penitipan/form', [PenitipanController::class, 'showForm'])->name('penitipan.form');

// Store penitipan
Route::post('/penitipan', [PenitipanController::class, 'storePenitipan'])->name('penitipan.store');

// Success receipt
Route::get('/penitipan/sukses/{kode}', [PenitipanController::class, 'success'])->name('penitipan.sukses');


/*
|--------------------------------------------------------------------------
| Admin Login (tanpa middleware)
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');


/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::get('/penitipan', [AdminController::class, 'listPenitipan'])
        ->name('admin.penitipan.index');

    // CRUD routes for penitipan
    Route::get('/penitipan/{id}', [AdminController::class, 'detail'])
        ->name('admin.penitipan.detail');

    Route::get('/penitipan/{id}/edit', [AdminController::class, 'edit'])
        ->name('admin.penitipan.edit');

    Route::put('/penitipan/{id}', [AdminController::class, 'update'])
        ->name('admin.penitipan.update');

    Route::delete('/penitipan/{id}', [AdminController::class, 'destroy'])
        ->name('admin.penitipan.destroy');

    Route::post('/penitipan/{id}/ambil', [AdminController::class, 'verifikasiPengambilan'])
        ->name('admin.penitipan.ambil');

    Route::get('/statistik', [AdminController::class, 'statistik'])
        ->name('admin.statistik');
});