<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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
    return view('auth.login');
});

Route::get('/penjualan', [App\Http\Controllers\PenjualanController::class, 'index'])->name('penjualan.index');
Route::post('/penjualan', [App\Http\Controllers\PenjualanController::class, 'store'])->name('penjualan.store');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');

// Route::get('/forecasting', [App\Http\Controllers\ForecastController::class, 'forecast'])->name('forecasting');


Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
//     Route::get('/stok', [App\Http\Controllers\ProfileController::class, 'index'])->name('stok');


// Route::group(['middleware' => ['admin', 'pimpinan']], function () {
//     Route::get('/users', 'UserController@index');
//     Route::get('/penjualan', 'PenjualanController@index');
// });

// Route::group(['middleware' => ['auth', 'admin']], function () {
//     // Rute untuk admin
//     // Route::get('/users', 'UserController@index');
//     Route::get('/users', [UserController::class, 'index'])->name('users.index');
//     // Tambahkan rute-rute lain untuk admin di sini
//     Route::get('/products', [ProductController::class, 'index'])->name('products.index');
// });

// Route::group(['middleware' => ['auth', 'pimpinan']], function () {
//     // Rute untuk pimpinan
//     Route::get('/users', [UserController::class, 'index'])->name('users.index');
//     // Tambahkan rute-rute lain untuk pimpinan di sini
//     Route::get('/products', [ProductController::class, 'index'])->name('products.index');
// });




Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');



Route::get('/forecasting', [InventoryController::class, 'forecast'])->name('forecasting');