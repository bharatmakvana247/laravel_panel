<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ForgotPasswordController;
use App\Http\Controllers\Backend\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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

Route::get('/clear-cache', static function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('view:cache');
    Artisan::call('clear-compiled');
    Artisan::call('optimize:clear');
    return response()->json([
        'message' => 'All cache removed successfully.'
    ]);
});

Route::get('/', [AuthController::class, 'welcome'])->name('welcome');
Route::get('/admin', [AuthController::class, 'index'])->name('admin.login');
Route::post('/login', [AuthController::class, 'customLogin'])->name('admin.login.store');
Route::get('/register', [AuthController::class, 'register'])->name('admin.register');
Route::post('/customRegister', [AuthController::class, 'customRegister'])->name('admin.customRegister');

// ---------------------------- Google Socialite Login ---------------------------------------

Route::get('admin/authorized/google', [AuthController::class, 'redirectToGoogle'])->name('authorized.google');
Route::get('admin/authorized/google/callback', [AuthController::class, 'handleGoogleCallback']);

// ---------------------------- Facebook Socialite Login ---------------------------------------

Route::get('admin/authorized/facebook', [AuthController::class, 'facebookRedirect'])->name('authorized.facebook');
Route::get('admin/authorized/facebook/callback', [AuthController::class, 'loginWithFacebook']);

// ---------------------------- Instagram Socialite Login ---------------------------------------

Route::get('admin/authorized/instagram', [AuthController::class, 'instagramRedirect'])->name('authorized.instagram');

Route::get('admin/authorized/instagram/callback', [AuthController::class, 'loginWithInstagram']);

// ---------------------------- Password Reset ---------------------------------------

Route::get('admin/forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('admin/forget-password/store', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('admin/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('admin/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::group(['prefix' => 'admin', 'middleware' => 'isAdmin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    // ---------------------------DashboardController----------------------------------------------------

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [DashboardController::class, 'logout'])->name('logout');

    // ---------------------------ProductController----------------------------------------------------

    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

    // ---------------------------CategoryController----------------------------------------------------

    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::get('/category/show', [CategoryController::class, 'show'])->name('category.show');
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');

    // ---------------------------BrandController----------------------------------------------------

    Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
    Route::get('/brand/create', [BrandController::class, 'create'])->name('brand.create');
    Route::post('/brand/store', [BrandController::class, 'store'])->name('brand.store');
    Route::get('/brand/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
    Route::post('/brand/update/{id}', [BrandController::class, 'update'])->name('brand.update');
    Route::get('/brand/delete/{id}', [BrandController::class, 'delete'])->name('brand.delete');
});