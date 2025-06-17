<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/about-us', [HomeController::class, 'about'])->name('home.about');
Route::get('/category/{cat}', [HomeController::class, 'category'])->name('home.category');
Route::get('/product/{product}', [HomeController::class, 'product'])->name('home.product');
Route::get('/favorite/{product}', [HomeController::class, 'favorite'])->name('home.favorite');
Route::post('/search', [HomeController::class, 'searchProduct'])->name('home.search');

Route::group(['prefix' => 'account'], function() {

    Route::get('/login', [AccountController::class, 'login'])->name('account.login');
    Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
    Route::get('/verify-account/{email}', [AccountController::class, 'verify'])->name('account.verify');
    Route::post('/login', [AccountController::class, 'check_login']);

    Route::get('/register', [AccountController::class, 'register'])->name('account.register');
    Route::get('/favorite', [AccountController::class, 'favorite'])->name('account.favorite');
    Route::post('/register', [AccountController::class, 'check_register']);

    Route::group(['middleware' => 'customer'], function() {
        Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::post('/profile', [AccountController::class, 'check_profile']);

        Route::get('/change-password', [AccountController::class, 'change_password'])->name('account.change_password');
        Route::post('/change-password', [AccountController::class, 'check_change_password']);
    });
    
    Route::get('/forgot-password', [AccountController::class, 'forgot_password'])->name('account.forgot_password');
    Route::post('/forgot-password', [AccountController::class, 'check_forgot_password']);

    Route::get('/reset-password/{token}', [AccountController::class, 'reset_password'])->name('account.reset_password');
    Route::post('/reset-password/{token}', [AccountController::class, 'check_reset_password']);
}); 

Route::group(['prefix' => 'cart', 'middleware' => 'customer'], function() {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/delete/{product}', [CartController::class, 'delete'])->name('cart.delete');
    Route::get('/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/add-product-detail/{product}', [CartController::class, 'addToCard'])->name('api.cart.add');
    Route::post('/update-quantity/{product}', [CartController::class, 'updateQuantity'])->name('api.cart.updateQuantity');
}); 

Route::group(['prefix' => 'order', 'middleware' => 'customer'], function() {
    Route::get('/checkout', [CheckoutController::class, 'checkoutResult'])->name('order.checkout');
    Route::post('/checkout-product', [CheckoutController::class, 'checkout'])->name('order.checkout.post');
    Route::get('/history', [CheckoutController::class, 'history'])->name('order.history');
    Route::get('/detail/{order}', [CheckoutController::class, 'detail'])->name('order.detail');
    Route::post('/checkout', [CheckoutController::class, 'post_checkout'])->name('order.postCheckout');
    Route::get('/verify/{token}', [CheckoutController::class, 'verify'])->name('order.verify');
    Route::post('/payment/online', [CheckoutController::class, 'createPayment'])->name('order.payment.online');
    Route::delete('/cancel/{order}', [OrderController::class, 'cancel'])->name('order.cancel');

}); 

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'check_login']);

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/chart-order', [AdminController::class, 'getChartOrder'])->name('admin.chartOrder');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/detail/{order}', [OrderController::class, 'show'])->name('order.show');
    Route::get('/order/update-status/{order}', [OrderController::class, 'update'])->name('order.update');

    Route::group(['prefix' => 'user'], function() {
        Route::get('/getListUser', [UserController::class, 'getListUser'])->name('user.getListUser');
    });

    Route::group(['prefix' => 'coupon'], function() {
        Route::get('/getListcoupon', [CouponController::class, 'getListCoupon'])->name('coupon.getListCoupon');
    });

    Route::group(['prefix' => 'order'], function() {
        Route::get('/get-list-order', [OrderController::class, 'getListOrder'])->name('order.getListOrder');
    });

    Route::resources([
        'user' => UserController::class,
        'category' => CategoryController::class,
        'product' => ProductController::class,
        'coupon' => CouponController::class,
    ]);
    
    route::get('product-delete-image/{image}', [ProductController::class, 'destroyImage'])->name('product.destroyImage');
});



