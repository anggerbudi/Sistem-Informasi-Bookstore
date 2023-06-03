<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Transaksi;
use function PHPUnit\Framework\isEmpty;

class KeuanganController extends Controller
{
    private string $title;
    private string $state;
    private Keuangan $keuangan;
    private Transaksi $transaksi;

    public function __construct(Keuangan $keuangan, Transaksi $transaksi)
    {
        $this->title = 'Laporan Keuangan';
        $this->state = 'keuangan';
        $this->keuangan = $keuangan;
        $this->transaksi = $transaksi;
    }

    public function index()
    {
        $current_date = now()->format('Y-m-d');
        $current_month_data = $this->transaksi->whereDate('created_at', $current_date)->get();
        $row = $this->keuangan->whereDate('created_at', $current_date)->get();

        if ($row->isNotEmpty()) {
            $this->keuangan->whereDate('created_at', $current_date)->update([
                'isi_laporan' => json_encode($current_month_data),
            ]);
        } else {
//            dd('baru');
            $this->keuangan->create([
                'id_laporan' => now()->format('Ym'),
                'tahun_laporan' => now()->format('Y'),
                'bulan_laporan' => now()->format('F'),
                'isi_laporan' => json_encode($current_month_data),
            ]);
        }

        return view('keuangan.index', [
            'title' => $this->title,
            'state' => $this->state,
            'data' => $this->keuangan->all(),
        ]);

    }

    public function detail($id)
    {
        return view('keuangan.detail', [
           'title' => $this->title,
            'state' => $this->state,
            'data' => $this->keuangan->firstWhere('id_laporan', $id),
        ]);
    }

    public function show($id)
    {

    }

}
