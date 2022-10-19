<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\{
    NoteController,
    ProfileController,
};



Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::fallback(function () {
    return '<h1 style="text-align: center; color: red;">Página não encontrada!</h1>';
});


require __DIR__.'/auth.php';




Route::middleware(['auth'])->group(function () {
    // User
    Route::middleware(['user'])->group(function () {
        Route::get('/read_note', [NoteController::class, 'read'])->name('user.dashboard');
        Route::post('create_note', [NoteController::class, 'create'])->name('create.note');
        Route::post('update_note', [NoteController::class, 'update'])->name('update.note');
        Route::post('delete_note', [NoteController::class, 'delete'])->name('delete.note');

        Route::post('store_file_note', [NoteController::class, 'storeFile'])->name('storeFile.note');
        Route::post('delete_file_note', [NoteController::class, 'deleteFile'])->name('deleteFile.note');

        Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
        Route::post('change_name', [ProfileController::class, 'changeName'])->name('change.name');
        Route::post('change_password', [ProfileController::class, 'changePassword'])->name('change.password');
        Route::post('change_photo', [ProfileController::class, 'changePhoto'])->name('change.photo');
    });


    // Admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/disable_user', [AdminController::class, 'disableUser'])->name('disable.user');
        Route::post('/active_user', [AdminController::class, 'activeUser'])->name('active.user');
    });
});
