<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index()
    {
        $current_date = now()->format('Y-m-d');
        $current_month_data = Transaksi::whereDate('created_at', $current_date)->get();
        $row = Keuangan::whereDate('created_at', $current_date)->get();

        if ($row) {
            Keuangan::whereDate('created_at', $current_date)->update([
                'isi_laporan' => json_encode($current_month_data),
            ]);
        } else {
            $new_row = new Keuangan();
            $new_row->create([
                'id_laporan' => now()->format('Ymd'),
                'tahun_laporan' =>now()->format('Y'),
                'bulan_laporan' => now()->format('F'),
                'isi_laporan' => json_encode($current_month_data),
            ]);
        }
        return view('keuangan', [
            'title' => 'Laporan Keuangan',
            'data' => Keuangan::all(),
        ]);

    }
}
