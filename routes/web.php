<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductRequestController;
use App\Http\Controllers\DiscountController;


Route::get('/', function () {
    return view('index');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/users', [UserController::class, 'store']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/inventory', fn() => view('admin.inventory'))->name('admin.inventories');
    Route::get('/transaction', fn() => view('admin.transaction'))->name('admin.transaction');
    Route::get('/user', fn() => view('admin.user'))->name('admin.user');
    Route::get('/employee', fn() => view('admin.employee'))->name('admin.employee');
    Route::get('/supplier', fn() => view('admin.supplier'))->name('admin.supplier');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('admin.user');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.users_create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.users_edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Employees
    Route::get('/employees', [EmployeeController::class, 'index'])->name('admin.employee');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

    // Inventories
    Route::get('/inventories', [InventoryController::class, 'index'])->name('admin.inventory');
    Route::get('/inventories/create', [InventoryController::class, 'create'])->name('inventories.create');
    Route::post('/inventories', [InventoryController::class, 'store'])->name('inventories.store');
    Route::get('/inventories/{inventories}/edit', [InventoryController::class, 'edit'])->name('inventories.edit');
    Route::put('/inventories/{inventories}', [InventoryController::class, 'update'])->name('inventories.update');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Suppliers
    Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
    Route::get('suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    Route::get('/products/request', [ProductController::class, 'showRequestForm'])->name('products.request.form');
    Route::post('/products/request', [ProductController::class, 'requestProduct'])->name('products.request');
    Route::post('/products/receive/{id}', [InventoryController::class, 'receiveProduct'])->name('products.receive');

    Route::get('/requests', [ProductRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [ProductRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [ProductRequestController::class, 'store'])->name('requests.store');
    Route::post('/requests/{id}/receive', [ProductRequestController::class, 'receive'])->name('requests.receive');

    // Discount Management
    Route::get('/discounts', [DiscountController::class, 'index'])
        ->name('discounts.index');
    Route::get('/discounts/create', [DiscountController::class, 'create'])
        ->name('discounts.create');
    Route::post('/discounts', [DiscountController::class, 'store'])
        ->name('discounts.store');
    Route::get('/discounts/{discount}/edit', [DiscountController::class, 'edit'])
        ->name('discounts.edit');
    Route::put('/discounts/{discount}', [DiscountController::class, 'update'])
        ->name('discounts.update');
    Route::delete('/discounts/{discount}', [DiscountController::class, 'destroy'])
        ->name('discounts.destroy');
    
    // Discount Toggle Status
    Route::patch('/discounts/{discount}/toggle-status', [DiscountController::class, 'toggleStatus'])
        ->name('discounts.toggle-status');


});

// // Cashier Routes
Route::prefix('cashier')->middleware('cashier')->group(function () {
    // Order management routes
    // Route::get('/index', [OrderController::class, 'index'])->name('cashier.index');
    Route::get('/orders', [OrderController::class, 'index'])->name('cashier.orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('cashier.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('cashier.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('cashier.show');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('cashier.edit');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('cashier.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('cashier.destroy');

    // Cart (POS) routes handled by CartController
    Route::get('/pos', [CartController::class, 'showCart'])->name('cashier.pos.index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.addToCart');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.removeFromCart');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clearCart');
    Route::post('/cart/discount', [CartController::class, 'applyDiscount'])->name('cart.applyDiscount');
    Route::post('/cart/scan', [CartController::class, 'scanProductId'])->name('cart.scanProductId');
    Route::post('/orders/{order}/payment', [CartController::class, 'processPayment'])->name('cart.processPayment');

    Route::get('orders/{order}/payment', [OrderController::class, 'showPaymentForm'])->name('orders.payment');
    Route::post('orders/{order}/payment', [OrderController::class, 'processPayment'])->name('orders.process-payment');
    Route::get('orders/{order}/payment_details', [OrderController::class, 'showPayment'])->name('orders.payment_details');
    Route::post('orders/{order}/payment/show', [OrderController::class, 'processPayment'])->name('orders.show');

    // Discount Application
    Route::post('/apply-discount', [CartController::class, 'applyDiscount'])
        ->name('discounts.apply');
    Route::post('/remove-discount', [CartController::class, 'removeDiscount'])
        ->name('discounts.remove');
    
    // Get Active Discounts (AJAX)
    Route::get('/active-discounts', [CartController::class, 'getActiveDiscounts'])
        ->name('discounts.active');
});

// Route::prefix('cashier')->middleware('cashier')->group(function () {
//     Route::get('/home', fn() => view('cashier.index'))->name('cashier.home');
//     // More cashier routes here
// });