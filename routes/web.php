<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\TransaksiController;
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

Route::get('/', [DashboardController::class, 'index'])->name('login');

Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/transaksi/riwayat', [TransaksiController::class, 'daftar']);

    Route::resource('/transaksi', TransaksiController::class);
    Route::get('/transaksi/belanja/baru/{tanggal}', [TransaksiController::class, 'baru']);
    Route::post('/transaksi/belanja/tambah/{tanggal}/{url}', [TransaksiController::class, 'tambah']);
    Route::post('/transaksi/belanja/jumlah/{tanggal}/{url}/{kode}', [TransaksiController::class, 'editJumlah']);
    Route::post('/transaksi/belanja/hapus/{tanggal}/{url}/{kode}', [TransaksiController::class, 'hapus']);
    Route::post('/transaksi/belanja/bayar/{tanggal}/{url}', [TransaksiController::class, 'bayar']);

    Route::resource('barang', BarangController::class);
    Route::post('/barang/tambah', [BarangController::class, 'tambah']);
    Route::post('/barang/stock/{barang}', [BarangController::class, 'stock']);
    Route::post('/barang/edit/{barang}', [BarangController::class, 'edit']);
    Route::post('/barang/hapus/{barang}', [BarangController::class, 'hapus']);

    Route::resource('pegawai', PegawaiController::class);
    Route::post('/pegawai/tambah', [PegawaiController::class, 'tambah']);
    Route::post('/pegawai/hapus/{pegawai}', [PegawaiController::class, 'hapus']);
    Route::post('/pegawai/edit/{pegawai}', [PegawaiController::class, 'edit_profil']);

    Route::resource('keuangan', KeuanganController::class);
    Route::post('/keuangan/detail/{id}', [KeuanganController::class, 'detail']);
});

