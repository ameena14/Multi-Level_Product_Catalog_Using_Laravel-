<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;


Route::prefix('admin')->middleware('guest:admin')->group(function () {

    Route::get('register', [RegisteredUserController::class, 'create'])->name('admin.register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [LoginController::class, 'create'])->name('admin.login');
    Route::post('login', [LoginController::class, 'store']);

});

Route::prefix('admin')->middleware('auth:admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');


Route::post('departments', [AdminController::class, 'storeDepartment'])->name('admin.departments');
Route::get('departments', [AdminController::class, 'showDepartments'])->name('showDepartments');




Route::post('update-department', [AdminController::class, 'updateDepartment'])->name('updateDepartment');
Route::post('add-category', [AdminController::class, 'addCategory'])->name('addCategory');
Route::get('categories', [AdminController::class, 'showCategories'])->name('categories');

Route::delete('departments/{id}', [AdminController::class, 'deleteDepartment'])->name('deleteDepartment');
Route::post('add-product', [AdminController::class, 'addProduct'])->name('addProduct');




Route::prefix('admin')->group(function () {
    Route::get('categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{id}', [CategoryController::class, 'showCategories'])->name('categories.showCategories');
    Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
});



// Products Routes (with admin prefix)
Route::resource('products', ProductController::class)->names([
    'index' => 'admin.products.index',
    'create' => 'admin.products.create',
    'store' => 'admin.products.store',
    'show' => 'admin.products.show',
    'edit' => 'admin.products.edit',
    'update' => 'admin.products.update',
    'destroy' => 'admin.products.destroy',
    
]);





    Route::post('logout', [LoginController::class, 'destroy'])->name('admin.logout');

});