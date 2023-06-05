<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class BarangController extends Controller
{
    private string $state;
    private string $title;
    private Barang $barang;

    public function __construct(Barang $barang)
    {
        $this->title = 'Kelola Barang';
        $this->state = 'barang';
        $this->barang = $barang;
    }

    public function index()
    {
        return view('barang.index', [
            'title' => $this->title,
            'state' => $this->state,
            'data' => $this->barang->all(),
        ]);
    }

    public function edit($kode)
    {
        $this->barang->where('kode_barang', $kode)->update([
            'nama_barang' => $_POST['nama_barang' . $kode],
            'harga_barang' => $_POST['harga_barang' . $kode],
        ]);
        return redirect('barang');
    }

    public function stock($kode)
    {
        $this->barang->where('kode_barang', $kode)->update([
            'stock_barang' => $_POST['tambah' . $kode],
        ]);
        return redirect('barang');
    }

    public function tambah()
    {
        $this->barang->create([
            'kode_barang' => $_POST['kode_barang_baru'],
            'nama_barang' => $_POST['nama_barang_baru'],
            'harga_barang' => $_POST['harga_barang_baru'],
        ]);
        return redirect('barang');
    }

    public function hapus($kode)
    {
        $this->barang->where('kode_barang', $kode)->delete();
        return redirect('barang');
    }

}
