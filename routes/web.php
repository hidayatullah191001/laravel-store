<?php

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

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductGalleryController as AdminProductGalleryController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardProductController;
use App\Http\Controllers\DashboardSettingController;
use App\Http\Controllers\DashboardTransactionController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\HomeController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/categories/{slug}', [CategoryController::class, 'detail'])->name('categories-details');

Route::get('/detail/{slug}', [DetailController::class, 'index'])->name('detail');
Route::post('/detail/{id}', [DetailController::class, 'add'])->name('detail-add');

Route::post('/checkout/callback', [CheckoutController::class, 'callback'])->name('midtrans-callback');

Route::get('/success', [CartController::class, 'success'])->name('success');
Route::get('/register/success', [RegisterController::class, 'success'])->name('register-success');

Auth::routes();


Route::middleware('auth')->group(function(){
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::delete('/cart/{id}', [CartController::class, 'delete'])->name('cart-delete');
    
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/products', [DashboardProductController::class, 'index'])->name('dashboard-products');
    Route::get('/dashboard/products/create', [DashboardProductController::class, 'create'])->name('dashboard-products-create');
    Route::get('/dashboard/products/{product}', [DashboardProductController::class, 'details'])->name('dashboard-products-details');
    Route::post('/dashboard/products/store', [DashboardProductController::class, 'store'])->name('dashboard-product-store');  
    Route::post('/dashboard/products/update/{product_gallery}', [DashboardProductController::class, 'update'])->name('dashboard-product-update');  
    Route::get('/dashboard/product/checkSlug', [DashboardProductController::class, 'checkSlug']);  

    Route::post('/dashboard/products/gallery/upload', [DashboardProductController::class, 'uploadGallery'])->name('dashboard-product-gallery-upload');  
    Route::get('/dashboard/products/gallery/delete/{id}', [DashboardProductController::class, 'deleteGallery'])->name('dashboard-product-gallery-delete');  

    Route::get('/dashboard/transactions', [DashboardTransactionController::class, 'index'])->name('dashboard-transactions');
    Route::get('/dashboard/transactions/{id}', [DashboardTransactionController::class, 'details'])->name('dashboard-transactions-details');
    Route::post('/dashboard/transactions/{id}', [DashboardTransactionController::class, 'update'])->name('dashboard-transactions-update');

    Route::get('/dashboard/settings', [DashboardSettingController::class, 'store'])->name('dashboard-settings-store');
    Route::get('/dashboard/account/store', [DashboardSettingController::class, 'account'])->name('dashboard-settings-account');
    Route::post('/dashboard/account/{redirect}', [DashboardSettingController::class, 'update'])->name('dashboard-settings-redirect');

});

// Route::middleware('admin')->group(function(){
//     Route::get('/', [AdminDashboardController::class, 'index'])->name('admin-dashboard');
//     Route::get('/admin/categories/checkSlug', [AdminCategoryController::class, 'checkSlug']);  
//     Route::get('/admin/products/checkSlug', [AdminProductController::class, 'checkSlug']);  
    
//     Route::resource('admin/category', AdminCategoryController::class);
//     Route::resource('admin/user', AdminUserController::class);
//     Route::resource('admin/product', AdminProductController::class);
//     Route::resource('admin/product-gallery', AdminProductGalleryController::class);
//     Route::resource('admin/transaction', AdminTransactionController::class);
    
// });

Route::prefix('admin')->middleware(['auth','admin'])->group(function(){
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin-dashboard');
    Route::get('categories/checkSlug', [AdminCategoryController::class, 'checkSlug']);  
    Route::get('products/checkSlug', [AdminProductController::class, 'checkSlug']);  
    
    Route::resource('category', AdminCategoryController::class);
    Route::resource('user', AdminUserController::class);
    Route::resource('product', AdminProductController::class);
    Route::resource('product-gallery', AdminProductGalleryController::class);
});



