<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Farmer\FarmerController;
use App\Http\Controllers\Supplier\SupplierController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Cart Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
});

// Order Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // User Management Routes
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminController::class, 'users'])->name('index');
        Route::put('/{user}', [AdminController::class, 'updateUser'])->name('update');
        Route::delete('/{user}', [AdminController::class, 'destroyUser'])->name('destroy');
    });
    
    // Product Management Routes
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [AdminController::class, 'products'])->name('index');
        Route::post('/', [AdminController::class, 'storeProduct'])->name('store');
        Route::put('/{product}', [AdminController::class, 'updateProduct'])->name('update');
        Route::delete('/{product}', [AdminController::class, 'destroyProduct'])->name('destroy');
    });
    
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::put('/orders/{order}', [AdminController::class, 'updateOrder'])->name('orders.update');
    Route::get('/sales', [AdminController::class, 'sales'])->name('sales.index');
});

// Farmer Routes
Route::prefix('farmer')->middleware(['auth', 'farmer'])->group(function () {
    Route::get('/', [FarmerController::class, 'index'])->name('farmer.dashboard');
    Route::get('/browse', [FarmerController::class, 'browse'])->name('farmer.browse');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
});

// Supplier Routes
Route::prefix('supplier')->name('supplier.')->middleware(['auth', 'supplier'])->group(function () {
    Route::get('/', [SupplierController::class, 'index'])->name('dashboard');
    Route::get('/products', [SupplierController::class, 'products'])->name('products');
    Route::get('/products/create', [SupplierController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [SupplierController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [SupplierController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [SupplierController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [SupplierController::class, 'destroyProduct'])->name('products.destroy');
    Route::get('/orders', [SupplierController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [SupplierController::class, 'showOrder'])->name('orders.show');
});

Auth::routes();
