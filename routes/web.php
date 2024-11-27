<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetails;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [HomeController::class, 'index']);

// Frontend Routes
Route::get('/trang-chu', [HomeController::class, 'index']);
Route::get('/product', [HomeController::class, 'index1']);
Route::post('/tim-kiem', [HomeController::class, 'search']);

// Sản phẩm theo danh mục, thương hiệu
Route::get('/danh-muc-san-pham/{slug_category_product}', [CategoryProduct::class, 'show_category_home']);
Route::get('/thuong-hieu-san-pham/{brand_slug}', [BrandProduct::class, 'show_brand_home']);

// Chi tiết sản phẩm
Route::get('/chi-tiet-san-pham/{product_slug}', [ProductController::class, 'details_product']);

// Backend Routes
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/dashboard', [AdminController::class, 'show_drashboard']);
Route::get('/logout', [AdminController::class, 'logout']);
Route::post('/admin-dashboard', [AdminController::class, 'dashboard']);

// Category Product
Route::get('/add-category-product', [CategoryProduct::class, 'add_category_product']);
Route::get('/all-category-product', [CategoryProduct::class, 'all_category_product']);
Route::post('/save-category-product', [CategoryProduct::class, 'save_category_product']);
Route::get('/unactive-category-product/{category_product_id}', [CategoryProduct::class, 'unactive_category_product']);
Route::get('/active-category-product/{category_product_id}', [CategoryProduct::class, 'active_category_product']);
Route::get('/edit-category-product/{category_product_id}', [CategoryProduct::class, 'edit_category_product']);
Route::post('/update-category-product/{category_product_id}', [CategoryProduct::class, 'update_category_product']);
Route::get('/delete-category-product/{category_product_id}', [CategoryProduct::class, 'delete_category_product']);

// Brand Product
Route::get('/add-brand-product', [BrandProduct::class, 'add_brand_product']);
Route::get('/all-brand-product', [BrandProduct::class, 'all_brand_product']);
Route::post('/save-brand-product', [BrandProduct::class, 'save_brand_product']);
Route::get('/unactive-brand-product/{brand_product_id}', [BrandProduct::class, 'unactive_brand_product']);
Route::get('/active-brand-product/{brand_product_id}', [BrandProduct::class, 'active_brand_product']);
Route::get('/edit-brand-product/{brand_product_id}', [BrandProduct::class, 'edit_brand_product']);
Route::post('/update-brand-product/{brand_product_id}', [BrandProduct::class, 'update_brand_product']);
Route::get('/delete-brand-product/{brand_product_id}', [BrandProduct::class, 'delete_brand_product']);

// Product Routes
Route::get('/add-product', [ProductController::class, 'add_product']);
Route::post('/save-product', [ProductController::class, 'save_product']);
Route::get('/all-product', [ProductController::class, 'all_product']);
Route::get('/unactive-product/{product_id}', [ProductController::class, 'unactive_product']);
Route::get('/active-product/{product_id}', [ProductController::class, 'active_product']);
Route::get('/edit-product/{product_id}', [ProductController::class, 'edit_product']);
Route::post('/update-product/{product_id}', [ProductController::class, 'update_product']);
Route::get('/delete-product/{product_id}', [ProductController::class, 'delete_product']);

// Cart
Route::post('/save-cart', [CartController::class, 'save_cart']);
Route::get('/show-cart', [CartController::class, 'show_cart']);
Route::get('/delete-to-cart/{rowId}', [CartController::class, 'delete_to_cart']);
Route::post('/update-cart-quantity', [CartController::class, 'update_cart_quantity']);

// Checkout
Route::get('/login-checkout', [CheckoutController::class, 'login_checkout']);
Route::post('/add-customer', [CheckoutController::class, 'add_customer']);
Route::get('/checkout', [CheckoutController::class, 'checkout']);
Route::post('/login-customer', [CheckoutController::class, 'login_customer']);
Route::get('/logout-checkout', [CheckoutController::class, 'logout_checkout']);
Route::post('/save-checkout-customer', [CheckoutController::class, 'save_checkout_customer']);
Route::get('/payment', [CheckoutController::class, 'payment']);
Route::post('/order-place', [CheckoutController::class, 'order_place']);
//Route::get('/manage-order', [CheckoutController::class, 'manage_order']);
Route::get('/view-order/{orderId}', [CheckoutController::class, 'view_order']);
Route::post('/update-order/{order_id}', [CheckoutController::class, 'update_order']);
Route::get('/taikhoan', [CheckoutController::class, 'user_setting']);
Route::get('/view-order-user/{orderId}', [CheckoutController::class, 'view_order_user']);

// Other Routes
Route::get('/news', fn() => view('pages.news'));
Route::get('/contact', fn() => view('pages.contact'));

// User Settings
Route::get('/cap-nhat-user', [HomeController::class, 'get_customer']);
Route::post('/update-user', [HomeController::class, 'update_user']);
Route::get('/cap-nhat-pass', [HomeController::class, 'show_update_pass']);
Route::post('/update_pass_save', [HomeController::class, 'update_pass_saver']);
Route::get('/show-pass', [HomeController::class, 'show_pass']);
Route::post('/send-email-customer', [HomeController::class, 'sen_email_pass']);

// Order Statistics
Route::get('/found-order-day', [AdminController::class, 'show_order_day']);
Route::get('/found-order-month', [AdminController::class, 'show_order_month']);
Route::get('/found-order-week', [AdminController::class, 'show_order_week']);
Route::get('/multi-email', [AdminController::class, 'show_multi_email']);
Route::get('/send-mail', [AdminController::class, 'send_mail']);
