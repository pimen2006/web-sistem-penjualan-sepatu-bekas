<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\LoginController as AdminLoginController;
use App\Http\Controllers\admin\ProfilController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\user\CartController;
use App\Http\Controllers\user\CategoryController;
use App\Http\Controllers\user\HomeController;
use App\Http\Controllers\user\ShopController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['prefix' => 'account'], function () {

    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', [LoginController::class, 'index'])->name('account.login');
        Route::get('register', [LoginController::class, 'register'])->name('account.register');
        Route::post('process-register', [LoginController::class, 'processRegister'])->name('account.processRegister');
        Route::post('authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('logout', [LoginController::class, 'logout'])->name('account.logout');

        Route::get('/profile', [HomeController::class, 'show'])->name('profile');
        Route::get('/profile/edit', [HomeController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [HomeController::class, 'updateProfile'])->name('profile.update');

        Route::get('home', [HomeController::class, 'index'])->name('home');

        Route::get('shop/category/{category_id}', [ShopController::class, 'index'])->name('shop.category');
        Route::get('shop/category/{category_id}/search', [ShopController::class, 'search'])->name('shop.search');

        Route::get('detail_product/{product_slug}', [ShopController::class, 'product_details'])->name('detail_product');

        Route::get('keranjang', [CartController::class, 'index'])->name('keranjang');
        Route::post('add-keranjang', [CartController::class, 'add_cart'])->name('add-keranjang');
        Route::put('/cart/decrease/{rowId}', [CartController::class, 'decrease_quantity'])->name('decrease_quantity-keranjang');
        Route::put('/cart/increase/{rowId}', [CartController::class, 'increase_quantity'])->name('increase_quantity-keranjang');
        Route::delete('remove-keranjang/{rowId}', [CartController::class, 'remove_item'])->name('remove-keranjang');

        Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('order', [CartController::class, 'place_an_order'])->name('order');
        // Tambahkan ini di file routes/web.php
        Route::get('address/edit', [CartController::class, 'editAddress'])->name('address.edit');
        Route::post('address/update', [CartController::class, 'updateAddress'])->name('address.update');

        Route::get('orders', [CartController::class, 'orders'])->name('orders');
        Route::get('/detail_order/{order}', [CartController::class, 'order_detail'])->name('detail_order');
        Route::put('order/cancel_order', [CartController::class, 'order_cancel'])->name('order.cancel');

        Route::get('pesanan', [HomeController::class, 'pesanan'])->name('pesanan');
    });
});

Route::group(['prefix' => 'admin'], function () {

    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/profile', [ProfilController::class, 'show'])->name('admin.profile');
        Route::get('/profile/edit', [ProfilController::class, 'edit'])->name('admin.profile.edit');
        Route::put('/profile', [ProfilController::class, 'updateProfile'])->name('admin.profile.update');

        Route::get('category', [DashboardController::class, 'category'])->name('admin.category');
        Route::get('category-add', [DashboardController::class, 'category_add'])->name('admin.category-add');
        Route::post('category-store', [DashboardController::class, 'category_store'])->name('admin.category-store');
        Route::get('category-edit/{id}', [DashboardController::class, 'category_edit'])->name('admin.category-edit');
        Route::put('category-update', [DashboardController::class, 'category_update'])->name('admin.category-update');
        Route::delete('category-delete/{id}', [DashboardController::class, 'category_delete'])->name('admin.category-delete');

        Route::get('products', [DashboardController::class, 'products'])->name('admin.products');
        Route::get('product-add', [DashboardController::class, 'product_add'])->name('admin.product-add');
        Route::post('product-store', [DashboardController::class, 'product_store'])->name('admin.product-store');
        Route::get('product-edit/{id}', [DashboardController::class, 'product_edit'])->name('admin.product-edit');
        Route::put('product-update', [DashboardController::class, 'product_update'])->name('admin.product-update');
        Route::delete('product-delete/{id}', [DashboardController::class, 'product_delete'])->name('admin.product-delete');

        Route::get('order', [DashboardController::class, 'order'])->name('admin.order');
        Route::put('order/update_status', [DashboardController::class, 'update_order_status'])->name('admin.order.update_status');
        Route::get('order_detail/{order_id}', [DashboardController::class, 'order_details'])->name('admin.order_detail');

        Route::get('customers', [DashboardController::class, 'customers'])->name('admin.customers');
        Route::patch('customers/{id}/update-role', [DashboardController::class, 'updateRole'])->name('admin.updateRole');
        Route::delete('/admin/customers/{id}', [DashboardController::class, 'deleteUser'])->name('admin.customer-delete');

        Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });
});
