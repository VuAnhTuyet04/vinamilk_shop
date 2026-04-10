<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\OrderController; 
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;

// --- GIỮ NGUYÊN ĐOẠN ĐẦU ---
Route::get('/', [HomeController::class, 'index'])->name('client.home');
Route::get('/san-pham', [HomeController::class, 'allProducts'])->name('client.products');
Route::get('/san-pham/{slug}', [HomeController::class, 'productDetail'])->name('client.product_detail');
Route::get('/danh-muc/{slug}', [HomeController::class, 'category'])->name('client.category');
Route::get('/gioi-thieu', [HomeController::class, 'about'])->name('client.about');
Route::get('/search', function() { return view('client.index'); })->name('search');

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// --- GIỮ NGUYÊN ĐOẠN AUTH ---
Route::middleware(['auth'])->group(function () {
    Route::get('/gio-hang', [CartController::class, 'index'])->name('client.cart');
    Route::get('/add-to-cart/{id}', [CartController::class, 'add'])->name('client.add_cart');
    Route::get('/remove-cart/{id}', [CartController::class, 'remove'])->name('client.cart.remove');
    Route::post('/update-cart', [CartController::class, 'update'])->name('client.cart.update');
    Route::get('/thanh-toan', [CartController::class, 'showCheckout'])->name('client.checkout');
    Route::post('/dat-hang', [CartController::class, 'checkout'])->name('client.process_order');
    Route::get('/profile', [AuthController::class, 'profile'])->name('client.profile');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('client.profile.update');
    Route::post('/order/cancel/{id}', [CartController::class, 'cancelOrder'])->name('client.order.cancel');
});

// --- PHẦN ADMIN (ĐÃ SỬA LẠI ĐỂ CHẠY THỐNG KÊ) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // SỬA TẠI ĐÂY: Gọi DashboardController để hiện biểu đồ
    Route::get('/', [DashboardController::class, 'index'])->name('admin.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // QUẢN LÝ ĐƠN HÀNG
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::post('/orders/update-status/{id}', [OrderController::class, 'updateStatus'])->name('admin.orders.update');

    // Quản lý sản phẩm
    Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/update/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

    // Quản lý danh mục
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });
});
// --- CÁC ROUTE ADMIN (MIDDLEWARE AUTH & ADMIN) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // THÊM DÒNG NÀY: Đây là trang liệt kê danh sách sản phẩm
    Route::get('/products', [AdminController::class, 'index'])->name('admin.products.index');

    // Các route cũ của bạn giữ nguyên
    Route::get('/', [DashboardController::class, 'index'])->name('admin.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // ... các route orders, create, store giữ nguyên ...
});
// Trong web.php - Nhóm Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // THÊM DÒNG NÀY để có trang danh sách sản phẩm
    Route::get('/products', [AdminController::class, 'index'])->name('admin.products.index');

    // Dashboard và các route khác giữ nguyên
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // ...
});
use App\Http\Controllers\ChatController;

// Route dành cho Chat
Route::middleware(['auth'])->group(function () {
    // Lấy tin nhắn
    Route::get('/messages/{userId}', [ChatController::class, 'getMessages']);
    // Gửi tin nhắn
    Route::post('/messages', [ChatController::class, 'sendMessage']);
});
// Group các route cần đăng nhập và là admin
Route::middleware(['auth'])->group(function () {
    // Route cho trang giao diện chat Admin
    Route::get('/admin/chat', [ChatController::class, 'adminIndex'])->name('admin.chat');
    
    // API lấy danh sách user đã nhắn tin
    Route::get('/admin/get-chat-users', [ChatController::class, 'getChatUsers']);
    
    // API lấy tin nhắn và gửi tin nhắn (dùng chung cho cả khách và admin)
    Route::get('/messages/{userId}', [ChatController::class, 'getMessages']);
    Route::post('/messages', [ChatController::class, 'sendMessage']);
});
Route::get('/admin/unread-messages-count', [ChatController::class, 'getUnreadCount']);
