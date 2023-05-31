<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use function PHPUnit\Framework\isNull;

class TransaksiController extends Controller
{
    private static string $title = 'Halaman Transaksi';
    private static $array_nama_barang = [];

    public function __construct()
    {
        foreach (Barang::all() as $barang){
            array_push(self::$array_nama_barang, $barang['nama_barang']);
        }
    }

    public function index()
    {
        return view('transaksi', [
            'title' => self::$title,
        ]);
    }

    public function baru($tgl)
    {
        $new_data = collect([]);
        $array_nama_barang = self::$array_nama_barang;
        return view('belanja', [
            'title' => self::$title,
            'tgl' => $tgl,
            'url' => Crypt::encryptString(json_encode($new_data)),
            'data' => $new_data,
        ], compact('array_nama_barang'));
    }

//    public function current($tgl, $data)
//    {
//        $json_data = json_encode($data);
//        $array_nama_barang = self::$array_nama_barang;
//        return view('belanja', [
//            'title' => self::$title,
//            'tgl' => $tgl,
//            'url' => $json_data,
//            'data' => $data,
//        ], compact('array_nama_barang'));
//    }

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
            'tgl' => $tgl,
            'url' => Crypt::encryptString(json_encode($processed_data)),
            'data' => $processed_data,
        ], compact('array_nama_barang'));
    }

    public function bayar($tgl, $data)
    {
        if(($_POST['uang_bayar'])<$_POST['hargaTotal']){
            dd('kurang woi');
        }
            dd('kembalian : '.($_POST['uang_bayar']-$_POST['hargaTotal']));
    }
}
