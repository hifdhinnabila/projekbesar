<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\JsonController;

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

Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'postlogin']);

Route::middleware(['ceklogin'])->group(function () {
    // Rute CRUD
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('kategori', KategoriController::class);
    Route::resource('barang', BarangController::class);
    Route::resource('pembeli', PembeliController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('pembelian', PembelianController::class);
    Route::resource('penjualan', PenjualanController::class);

    // Rute API
    Route::get('/api/barang/{id}', [JsonController::class, 'getBarangById']);
    Route::get('/logout', [LoginController::class, 'logout']);

    // Cetak
    Route::get('/cetak/penjualan', [PenjualanController::class, 'cetak']);
    Route::get('/cetak/detailpenjualan/{id}', [PenjualanController::class, 'cetakdetail']);
});