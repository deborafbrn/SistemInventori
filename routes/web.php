<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\Auth\LoginController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/login_sistem', [LoginController::class, 'loginUser']);

// Produk
Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/produk_delete', [ProdukController::class, 'delete']);
Route::post('/produk_store', [ProdukController::class, 'store']);
Route::post('/produk_update', [ProdukController::class, 'update']);

// Transaksi
Route::get('/transaksi', [TransaksiController::class, 'index']);
Route::get('/transaksi_delete', [TransaksiController::class, 'delete']);
Route::post('/transaksi_store', [TransaksiController::class, 'store']);
Route::post('/transaksi_update', [TransaksiController::class, 'update']);