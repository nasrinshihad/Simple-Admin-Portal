<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth','admin')->group(function(){
    Route::get('admin/dashboard',[AdminController::class,'index'])->name('admin.dashboard');
    Route::get('admin/create/{type}', [AdminController::class, 'create'])->name('admin.create');
    Route::post('admin/store/{type}', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/customers', [AdminController::class, 'showList'])->name('admin.customers');
    Route::get('/admin/invoices', [AdminController::class, 'showList'])->name('admin.invoices');
    Route::get('/admin/data/{type}', [AdminController::class, 'dataIndex'])->name('admin.data.index');
    Route::get('/admin/{type}/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{type}/{id}/update', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{type}/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
