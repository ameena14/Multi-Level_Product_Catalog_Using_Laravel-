<?php


use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', [UserController::class, 'showDepartments'])->name('user.departments');
    Route::get('/departments/{id}', [UserController::class, 'showCategories'])->name('user.categories');
    Route::get('/categories/{id}', [UserController::class, 'showProducts'])->name('user.products');


});


require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';
