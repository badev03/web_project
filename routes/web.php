<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ShopController;
use App\Http\Controllers\Admin\AuthenController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Admin\CategoriesController;

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

Auth::routes();

route::prefix('admin')->group(function () {
    Route::get('/get-attribute-values/{attributeId}', [ProductController::class, 'getAttributeValues'])->name('getAttributeValues');
    Route::get('/get-sub-categories/{categoryId}', [ProductController::class, 'getSubCategories'])->name('getSubCategories');
    Route::PUT('/update-status-product/{productId}', [ProductController::class, 'updateStatus'])->name('updateStatusProduct');
    Route::PUT('/update-status-user/{userId}', [UserController::class, 'updateStatus'])->name('updateStatusUser');

    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoriesController::class);
    Route::get('/login', [AuthenController::class, 'login'])->name('admin.login');
    Route::post('/login', [AuthenController::class, 'postLogin'])->name('admin.postLogin');
    Route::resource('brands', BrandController::class);
    Route::resource('attributes', AttributeController::class);
    Route::get('/delete-attribute-value/{id}', [AttributeController::class, 'deleteAttributeValue'])->name('deleteAttributeValue');

    Route::get('/orders',[OrderController::class, 'index'])->name('order.index');
    Route::get('/get-data-order',[OrderController::class, 'getData'])->name('order.getData');
    Route::get('/order-detail/{id}',[OrderController::class, 'orderDetail'])->name('order.orderDetail');
    route::get('/create-product-basic', [ProductController::class, 'createProductbasic'])->name('createProductbasic');
});

Route::get('/shop.html', [ShopController::class, 'index'])->name('shop');
Route::get('/', [HomeController::class, 'index'])->name('homes');

Route::get('/product-detail/{slug}', [App\Http\Controllers\Client\ProductController::class, 'productDetail'])->name('productDetail');


Route::get('/cart', [App\Http\Controllers\Client\ProductController::class, 'cart'])->name('cart');
Route::post('/add-to-cart/{id}', [App\Http\Controllers\Client\ProductController::class, 'addToCart'])->name('addToCart');
Route::get('/show-cart', [App\Http\Controllers\Client\ProductController::class, 'showCart'])->name('cart.show');
Route::post('/update-cart/{id}', [App\Http\Controllers\Client\ProductController::class, 'updateCart'])->name('updateCart');
Route::delete('/remove-cart', [App\Http\Controllers\Client\ProductController::class, 'remove'])->name('removeCart');
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'checkoutStore'])->name('checkoutStore');
Route::get('/vn-payments', [CheckoutController::class, 'vnpayReturn'])->name('vnpay.Return');
Route::post('/vn-payments', [CheckoutController::class, 'Vnpay'])->name('vnpay');




Route::get('/provinces',[CheckoutController::class, 'getProvinces'])->name('getProvinces');
Route::get('/districts/{provinceId}',[CheckoutController::class, 'getDistricts'])->name('getDistricts');
Route::get('/wards/{districtId}',[CheckoutController::class, 'getWards'])->name('getWards');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
