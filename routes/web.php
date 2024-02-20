<?php

use App\Http\Controllers\MollieController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Comment out or remove the Voyager routes
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/home', [ProductController::class, 'index']);  
Route::get('/shopping-cart', [ProductController::class, 'productCart'])->name('shopping.cart');
Route::get('/product/{id}', [ProductController::class, 'addProducttoCart'])->name('addproduct.to.cart');
Route::patch('/update-shopping-cart', [ProductController::class, 'updateCart'])->name('update.shopping.cart');
Route::delete('/delete-cart-product', [ProductController::class, 'deleteProduct'])->name('delete.cart.product');
Route::get('/checkout',[ProductController::class, 'checkout'])->name('checkout');

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::post('mollie', [MollieController::class, 'mollie'])->name('mollie');
Route::get('success', [MollieController::class, 'success'])->name('success');
Route::get('cancel', [MollieController::class, 'cancel'])->name('cancel');
