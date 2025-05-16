<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('admin/tasks', TaskController::class);

    Route::post('admin/tasks/uploadAttachment', [TaskController::class, 'uploadAttachment'])->name('tasks.uploadAttachment');
    Route::post('admin/tasks/deleteTempAttachment', [TaskController::class, 'deleteTempAttachment'])->name('tasks.deleteTempAttachment');
    Route::post('admin/tasks/deleteAttachment', [TaskController::class, 'deleteAttachment'])->name('tasks.deleteAttachment');

    Route::get('admin/tasksArchive', [TaskController::class, 'tasks_archive'])->name('tasks.archive');
    Route::post('admin/tasks/{id}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
    Route::delete('admin/tasks/{id}/force-delete', [TaskController::class, 'forceDelete'])->name('tasks.forceDelete');

    Route::get('admin/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('admin/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('admin/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});