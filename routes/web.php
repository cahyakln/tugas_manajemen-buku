
<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Manajemen Buku
    Route::resource('books', BookController::class);

    // Manajemen Pengguna
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');

    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])
        ->name('users.updateRole');
});

require __DIR__.'/auth.php';
