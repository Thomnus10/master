<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/users', [UserController::class, 'store']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')->group(function () {

    Route::get('/inventory', function () {
        return view('admin.inventory');
    })->name('admin.inventories');

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

//admin/users
Route::prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.user');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.users_create'); // Fix path
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.users_edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

//admin/employees
Route::prefix('admin')->group(function () {
    // Employee Routes
    Route::get('/employees', [EmployeeController::class, 'index'])->name('admin.employee');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
});

//admin/employees
// Route::prefix('admin')->name('admin.')->group(function () {
//     // Employee Routes
//     Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.employee_index');
//     Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.employee_create');
//     Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
//     Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.employee_edit');
//     Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
//     Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
// });

//admin/inventories
Route::prefix('admin')->group(function () {
    // Inventories Routes
    Route::get('/inventories', [InventoryController::class, 'index'])->name('admin.inventory');
    Route::get('/inventories/create', [InventoryController::class, 'create'])->name('inventories.create');
    Route::post('/inventories', [InventoryController::class, 'store'])->name('inventories.store');
    Route::get('/inventories/{inventories}/edit', [InventoryController::class, 'edit'])->name('inventories.edit');
    Route::put('/inventories/{inventories}', [InventoryController::class, 'update'])->name('inventories.update');
});

//products
Route::prefix('admin')->group(function () {
    // Product Routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

//categories
use App\Http\Controllers\CategoryController;

Route::prefix('admin')->group(function () {
    // Categories Routes
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});
