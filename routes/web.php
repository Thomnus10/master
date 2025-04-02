<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/users', [UserController::class, 'store']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')->group(function () {
    Route::get('/home', function () {
        return view('admin.home');
    })->name('admin.home');

    Route::get('/inventory', function () {
        return view('admin.inventory');
    })->name('admin.inventory');

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/transaction', function () {
        return view('admin.transaction');
    })->name('admin.transaction');

    Route::get('/user', function () {
        return view('admin.user');
    })->name('admin.user');

    Route::get('/employee',function(){
        return view('admin.employee');
    })->name('admin.employee');

});

Route::prefix('cashier')->group(function () {
    Route::get('/home', function () {
        return view('cashier.home');
    })->name('cashier.home');
});

Route::prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.user');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.users_create'); // Fix path
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.users_edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
