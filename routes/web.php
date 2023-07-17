<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\FpGrowthController;
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
    return redirect('login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/login_sistem', [LoginController::class, 'loginUser']);

// Produk
Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/produk_create', [ProdukController::class, 'create']);
Route::get('/produk_edit/{id}', [ProdukController::class, 'edit']);
Route::get('/produk_delete/{id}', [ProdukController::class, 'delete']);
Route::post('/produk_store', [ProdukController::class, 'store']);
Route::post('/produk_update/{id}', [ProdukController::class, 'update']);

// Transaksi
Route::get('/transaksi', [TransaksiController::class, 'index']);
Route::get('/transaksi_create', [TransaksiController::class, 'create']);
Route::get('/transaksi_edit/{id}', [TransaksiController::class, 'edit']);
Route::get('/transaksi_delete/{id}', [TransaksiController::class, 'delete']);
Route::post('/transaksi_store', [TransaksiController::class, 'store']);
Route::post('/transaksi_update/{id}', [TransaksiController::class, 'update']);

//FpGrowth
Route::get('/fp-growth', [FpGrowthController::class, 'index']);