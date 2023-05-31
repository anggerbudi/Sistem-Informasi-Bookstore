<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    //
    public function index()
    {
        return view('barang', [
            'title' => 'Kelola Barang',
            'data' => Barang::all(),
        ]);
    }

    public function edit($kode)
    {
        Barang::where('kode_barang', '=', $kode)->update([
            'nama_barang' => $_POST['nama_barang'.$kode],
            'harga_barang' => $_POST['harga_barang'.$kode],
        ]);
        return redirect('barang');
    }

    public function stock($kode)
    {
        Barang::where('kode_barang', $kode)->update([
            'stock_barang' => $_POST['tambah'.$kode],
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

    public function ambil()
    {
        $data = Barang::all(); // Replace "YourModel" with the actual model name

        return response()->json($data);
    }
}
