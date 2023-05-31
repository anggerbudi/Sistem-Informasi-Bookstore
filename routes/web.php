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

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/transaksi', [TransaksiController::class, 'index'])->middleware('auth');
Route::post('/transaksi/belanja/{tgl}', [TransaksiController::class, 'baru'])->middleware('auth');
Route::post('/transaksi/belanja/{tgl}/{url}', [TransaksiController::class, 'tambah'])->middleware('auth');
Route::post('/transaksi/editJumlah/{tgl}/{url}/{kode}', [TransaksiController::class, 'editJumlah'])->middleware('auth');
Route::post('/transaksi/hapus/{tgl}/{url}/{kode}', [TransaksiController::class, 'hapus'])->middleware('auth');
Route::post('/transaksi/bayar/{tgl}/{url}', [TransaksiController::class, 'bayar'])->middleware('auth');

Route::get('/barang', [BarangController::class, 'index'])->middleware('auth');
Route::post('/barang/stock{kode_barang}', [BarangController::class, 'stock'])->middleware('auth');
Route::post('/barang/edit{kode_barang}', [BarangController::class, 'edit'])->middleware('auth');
Route::post('/barang/hapus{kode_barang}', [BarangController::class, 'hapus'])->middleware('auth');
Route::post('/barang/tambah', [BarangController::class, 'tambah'])->middleware('auth');

Route::get('/pegawai', [PegawaiController::class, 'index'])->middleware('auth');
Route::post('/pegawai/tambah', [PegawaiController::class, 'tambah'])->middleware('auth');
Route::post('/pegawai/hapus{id}', [PegawaiController::class, 'hapus'])->middleware('auth');
Route::post('/pegawai/edit{id}', [PegawaiController::class, 'edit_profil'])->middleware('auth');

Route::get('/keuangan', [KeuanganController::class, 'index'])->middleware('auth');
Route::get('/ambil', [BarangController::class, 'ambil'])->middleware('auth');;
