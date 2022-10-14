<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::fallback(function () {
    return '<h1 style="text-align: center; color: red;">Página não encontrada!</h1>';
});


require __DIR__.'/auth.php';


Route::get('/dashboard', [NoteController::class, 'read'])->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::post('create_note', [NoteController::class, 'create'])->name('create.note');
    Route::post('update_note', [NoteController::class, 'update'])->name('update.note');
    Route::post('delete_note', [NoteController::class, 'delete'])->name('delete.note');

    Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('change_name', [ProfileController::class, 'changeName'])->name('change.name');
    Route::post('change_password', [ProfileController::class, 'changePassword'])->name('change.password');
    Route::post('change_photo', [ProfileController::class, 'changePhoto'])->name('change.photo');
});
