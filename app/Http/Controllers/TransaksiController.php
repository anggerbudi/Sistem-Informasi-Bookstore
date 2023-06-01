<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class TransaksiController extends Controller
{
    private static string $title = 'Halaman Transaksi';
    private static string $state;
    private static array $array_nama_barang = [];
    public function __construct()
    {
        self::$title = 'Transaksi';
        self::$state = 'transaksi';
        foreach (Barang::all() as $barang){
            array_push(self::$array_nama_barang, $barang['nama_barang']);
        }
    }

    public function index()
    {
        return view('transaksi', [
            'title' => self::$title,
            'state' => self::$state
        ]);
    }

    public function baru($tgl)
    {
        $new_data = collect();
        $array_nama_barang = self::$array_nama_barang;
        return view('belanja', [
            'title' => self::$title,
            'state' => self::$state,
            'tgl' => $tgl,
            'url' => Crypt::encryptString(json_encode($new_data)),
            'data' => $new_data,
        ], compact('array_nama_barang'));
    }

    public function tambah($tgl, $data)
    {
        $barang = Barang::where('nama_barang', $_POST['name_akun'])->first();
        $processed_data = collect(json_decode(Crypt::decryptString($data), true));
        if ($processed_data->where('nama_barang', $barang->nama_barang)->isEmpty()) {
            $array_barang = [
                'kode_barang' => $barang->kode_barang,
                'nama_barang' => $barang->nama_barang,
                'harga_barang' => $barang->harga_barang,
                'jumlah_barang' => 1,
                'total_harga' => $barang->harga_barang * 1,
            ];
        } else {
            $current_jumlah = $processed_data->where('nama_barang', $barang->nama_barang)->first();
            $new_jumlah = $current_jumlah['jumlah_barang'] + 1;
            $processed_data = $processed_data->reject(function ($item) use ($barang) {
                return $item['nama_barang'] === $barang->nama_barang;
            });
            $array_barang = [
                'kode_barang' => $barang->kode_barang,
                'nama_barang' => $barang->nama_barang,
                'harga_barang' => $barang->harga_barang,
                'jumlah_barang' => $new_jumlah,
                'total_harga' => $barang->harga_barang * $new_jumlah,
            ];
        }
        $processed_data->push($array_barang);
        $array_nama_barang = self::$array_nama_barang;

        return view('belanja', [
            'title' => self::$title,
            'state' => self::$state,
            'tgl' => $tgl,
            'url' => Crypt::encryptString(json_encode($processed_data)),
            'data' => $processed_data,
        ], compact('array_nama_barang'));
    }

    public function editJumlah($tgl, $data, $kode)
    {
        $processed_data = collect(json_decode(Crypt::decryptString($data), true));
        $barang = $processed_data->where('kode_barang', $kode)->first();
        $barang_temp = [
            'kode_barang' => $processed_data->where('kode_barang', $kode)->first()['kode_barang'],
            'nama_barang' => $processed_data->where('kode_barang', $kode)->first()['nama_barang'],
            'harga_barang' => $processed_data->where('kode_barang', $kode)->first()['harga_barang'],
            'jumlah_barang' => $_POST['edit_jumlah'.$kode],
            'total_harga' => $processed_data->where('kode_barang', $kode)->first()['harga_barang'] * $_POST['edit_jumlah'.$kode],
        ];

        $processed_data = $processed_data->reject(function ($item) use ($barang) {
            return $item['nama_barang'] === $barang['nama_barang'];
        });
        $processed_data->push($barang_temp);

        $array_nama_barang = self::$array_nama_barang;
        return view('belanja', [
            'title' => self::$title,
            'state' => self::$state,
            'tgl' => $tgl,
            'url' => Crypt::encryptString(json_encode($processed_data)),
            'data' => $processed_data,
        ], compact('array_nama_barang'));
    }

    public function hapus($tgl, $data, $kode)
    {
        $processed_data = collect(json_decode(Crypt::decryptString($data), true));
        $barang = $processed_data->where('kode_barang', $kode)->first();
        $processed_data = $processed_data->reject(function ($item) use ($barang) {
            return $item['nama_barang'] === $barang['nama_barang'];
        });

        $array_nama_barang = self::$array_nama_barang;
        return view('belanja', [
            'title' => self::$title,
            'state' => self::$state,
            'tgl' => $tgl,
            'url' => Crypt::encryptString(json_encode($processed_data)),
            'data' => $processed_data,
        ], compact('array_nama_barang'));
    }

    public function bayar(Request $request, $tgl, $data)
    {

        $processed_data = json_decode(Crypt::decryptString($data), true);
        $array_barang = [];
        $array_harga = [];
        $array_jumlah = [];
        foreach ($processed_data as $item) {
            array_push($array_barang, $item['nama_barang']);
            array_push($array_harga, $item['harga_barang']);
            array_push($array_jumlah, $item['jumlah_barang']);
        }
        foreach ($processed_data as $item) {
            $current = Barang::where('nama_barang', $item['nama_barang'])->first();
            $current->update([
                'stock_barang' => $current->stock_barang - $item['jumlah_barang'],
            ]);
        }
        Transaksi::create([
            'id_transaksi' => $tgl,
            'nama_kasir' => Auth::user()->name,
            'daftar_barang' => json_encode($array_barang),
            'daftar_harga' => json_encode($array_harga),
            'bayar' => $request['uang_pembayar'],
            'kembalian' => $request['total_harga'] - $request['uang_pembayar'],
        ]);
        return redirect('transaksi');
    }

    public function finalize($tgl, $data) {
        $processed_data = collect(json_decode(Crypt::decryptString($data), true));
    }
}
