<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class BarangController extends Controller
{
    private static string $state;
    private static string $title;

    public function __construct()
    {
        self::$state = 'barang';
        self::$title = 'Kelola Barang';
    }

    public function index()
    {
        return view('barang', [
            'title' => self::$title,
            'state' => self::$state,
            'data' => Barang::all(),
        ]);
    }

    public function edit($kode)
    {
        Barang::where('kode_barang', '=', $kode)->update([
            'nama_barang' => $_POST['nama_barang' . $kode],
            'harga_barang' => $_POST['harga_barang' . $kode],
        ]);
        return redirect('barang');
    }

    public function stock($kode)
    {
        Barang::where('kode_barang', $kode)->update([
            'stock_barang' => $_POST['tambah' . $kode],
        ]);
        return redirect('barang');
    }

    public function tambah()
    {
        Barang::create([
            'kode_barang' => $_POST['kode_barang_baru'],
            'nama_barang' => $_POST['nama_barang_baru'],
            'harga_barang' => $_POST['harga_barang_baru'],
        ]);
        return redirect('barang');
    }

    public function hapus($kode)
    {
        Barang::where('kode_barang', $kode)->delete();
        return redirect('barang');
    }

}
