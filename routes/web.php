<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController; // ✅ Import SupplierController
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ExpensesController;


// Public routes
Route::get('/', function () {
    return view('index');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/users', [UserController::class, 'store']);

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/inventory', function () {
        return view('admin.inventory');
    })->name('admin.inventory');

    Route::get('/transaction', function () {
        return view('admin.transaction');
    })->name('admin.transaction');

    Route::get('/employee', function () {
        return view('admin.employee');
    })->name('admin.employee');

    Route::get('/purchase', function () {
        return view('admin.purchase');
    })->name('admin.purchase');

    Route::get('/expenses', function () {
        return view('admin.expenses');
    })->name('admin.expenses');

    Route::get('/products', [ProductController::class, 'index'])->name('admin.products');

    // ✅ Use resource route for suppliers
    Route::resource('suppliers', SupplierController::class)->names([
        'index' => 'admin.suppliers',
        'create' => 'admin.suppliers.create',
        'store' => 'admin.suppliers.store',
        'edit' => 'admin.suppliers.edit',
        'update' => 'admin.suppliers.update',
        'destroy' => 'admin.suppliers.destroy',
    ]);

    // User CRUD
    Route::get('/users', [UserController::class, 'index'])->name('admin.user');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.users_create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.users_edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Purchase Routes (fixed)
    Route::get('/purchase', [PurchaseController::class, 'index'])->name('admin.purchase');
    Route::get('/purchase/create', [PurchaseController::class, 'create'])->name('admin.purchase.create');
    Route::post('/purchase', [PurchaseController::class, 'store'])->name('admin.purchase.store');
    Route::get('/purchase/{purchase}/edit', [PurchaseController::class, 'edit'])->name('admin.purchase.edit');
    Route::put('/purchase/{purchase}', [PurchaseController::class, 'update'])->name('admin.purchase.update');
    Route::delete('/purchase/{purchase}', [PurchaseController::class, 'destroy'])->name('admin.purchase.destroy');
});

    Route::prefix('admin')->group(function () {
    Route::get('/expenses', [ExpensesController::class, 'index'])->name('admin.expenses');
    Route::get('/expenses/create', [ExpensesController::class, 'create'])->name('admin.expenses.create');
    Route::post('/expenses', [ExpensesController::class, 'store'])->name('admin.expenses.store');
    Route::get('/expenses/{expense}/edit', [ExpensesController::class, 'edit'])->name('admin.expenses.edit');
    Route::put('/expenses/{expense}', [ExpensesController::class, 'update'])->name('admin.expenses.update');
    Route::delete('/expenses/{expense}', [ExpensesController::class, 'destroy'])->name('admin.expenses.destroy');
});
// Cashier Routes
Route::prefix('cashier')->group(function () {
    Route::get('/home', function () {
        return view('cashier.home');
    })->name('cashier.home');
});