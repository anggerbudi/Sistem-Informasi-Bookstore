<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use LaravelIdea\Helper\App\Models\_IH_Barang_C;

class TransaksiController extends Controller
{
    private static string $title = 'Halaman Transaksi';
    private static string $state;
    private static array $array_nama_barang = [];
    private static array|_IH_Barang_C|Collection $database_data;

    public function __construct()
    {
        self::$title = 'Transaksi';
        self::$state = 'transaksi';
        self::$array_nama_barang = Barang::pluck('nama_barang')->all();
        self::$database_data = Barang::all();
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
        return view('belanja', [
            'title' => self::$title,
            'state' => self::$state,
            'tgl' => $tgl,
            'url' => Crypt::encryptString(json_encode($new_data)),
            'data' => $new_data,
            'array_nama_barang' => self::$array_nama_barang,
        ]);
    }

    public function tambah($tgl, $data)
    {
        $barang = self::$database_data->firstWhere('nama_barang', $_POST['nama_barang_input']);
        $processed_data = collect(json_decode(Crypt::decryptString($data), true));

        if ($barang !== null) {
            if ($processed_data->where('nama_barang', $barang->nama_barang)->isEmpty()) {
                $array_barang = [
                    'kode_barang' => $barang->kode_barang,
                    'nama_barang' => $barang->nama_barang,
                    'harga_barang' => $barang->harga_barang,
                    'jumlah_barang' => 1,
                    'total_harga' => $barang->harga_barang * 1,
                ];
            } else {
                $current_jumlah = $processed_data->firstWhere('nama_barang', $barang->nama_barang);
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

        } else {
            Session::flash('message', 'Pop-up message goes here');
        }
        return view('belanja', [
            'title' => self::$title,
            'state' => self::$state,
            'tgl' => $tgl,
            'url' => Crypt::encryptString(json_encode($processed_data)),
            'data' => $processed_data,
            'array_nama_barang' => self::$array_nama_barang,
        ]);
    }

    public function editJumlah($tgl, $data, $kode)
    {
        $processed_data = collect(json_decode(Crypt::decryptString($data), true));
        $barang = $processed_data->firstWhere('kode_barang', $kode);
        $barang_temp = [
            'kode_barang' => $barang['kode_barang'],
            'nama_barang' => $barang['nama_barang'],
            'harga_barang' => $barang['harga_barang'],
            'jumlah_barang' => $_POST['edit_jumlah' . $kode],
            'total_harga' => $barang['harga_barang'] * $_POST['edit_jumlah' . $kode],
        ];

        $processed_data = $processed_data->reject(function ($item) use ($barang) {
            return $item['nama_barang'] === $barang['nama_barang'];
        });
        $processed_data->push($barang_temp);

        return view('belanja', [
            'title' => self::$title,
            'state' => self::$state,
            'tgl' => $tgl,
            'url' => Crypt::encryptString(json_encode($processed_data)),
            'data' => $processed_data,
            'array_nama_barang' => self::$array_nama_barang,
        ]);
    }

    public function hapus($tgl, $data, $kode)
    {
        $processed_data = collect(json_decode(Crypt::decryptString($data), true));
        $processed_data = $processed_data->reject(function ($item) use ($kode) {
            return $item['kode_barang'] === $kode;
        });

        return view('belanja', [
            'title' => self::$title,
            'state' => self::$state,
            'tgl' => $tgl,
            'url' => Crypt::encryptString(json_encode($processed_data)),
            'data' => $processed_data,
            'array_nama_barang' => self::$array_nama_barang,
        ]);
    }


//    public function bayar(Request $request, $tgl, $data)
//    {
//        $processed_data = json_decode(Crypt::decryptString($data), true);
//
//        $array_barang = array_column($processed_data, 'nama_barang');
//        $array_harga = array_column($processed_data, 'harga_barang');
//        $array_jumlah = array_column($processed_data, 'jumlah_barang');
//
//        foreach ($processed_data as $item) {
//            $new_stock = Barang::where('nama_barang', $item['nama_barang'])->first()->stock_barang - $item['jumlah_barang'];
//            Barang::where('nama_barang', $item['nama_barang'])->update([
//                'stock_barang' => $new_stock,
//            ]);
//        }
//        Transaksi::create([
//            'id_transaksi' => $tgl,
//            'nama_kasir' => Auth::user()->name,
//            'daftar_barang' => json_encode($array_barang),
//            'daftar_harga' => json_encode($array_harga),
//            'daftar_jumlah' => json_encode($array_jumlah),
//            'total_harga' => $request['total_harga'],
//            'bayar' => $request['uang_pembayar'],
//            'kembalian' => $request['uang_pembayar'] - $request['total_harga'],
//        ]);
//        return redirect('transaksi');
//    }


    public function bayar(Request $request, $tgl, $data)
    {
        $processed_data = json_decode(Crypt::decryptString($data), true);

        $array_nama = array_column($processed_data, 'nama_barang');
        $array_harga = array_column($processed_data, 'harga_barang');
        $array_jumlah = array_column($processed_data, 'jumlah_barang');

        $barangStocks = DB::table('barangs')
            ->whereIn('nama_barang', $array_nama)
            ->pluck('stock_barang', 'nama_barang');

        foreach ($processed_data as $item) {
            $new_stock = $barangStocks[$item['nama_barang']] - $item['jumlah_barang'];

            DB::table('barangs')
                ->where('nama_barang', $item['nama_barang'])
                ->update([
                    'stock_barang' => $new_stock,
                ]);
        }

        Transaksi::create([
            'id_transaksi' => $tgl,
            'nama_kasir' => Auth::user()->name,
            'daftar_barang' => json_encode($array_nama),
            'daftar_harga' => json_encode($array_harga),
            'daftar_jumlah' => json_encode($array_jumlah),
            'total_harga' => $request['total_harga'],
            'bayar' => $request['uang_pembayar'],
            'kembalian' => $request['uang_pembayar'] - $request['total_harga'],
        ]);

        return redirect('transaksi');
    }


}
