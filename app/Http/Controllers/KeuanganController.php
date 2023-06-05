<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Transaksi;

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
        $current_date = now();
        $current_month_data = $this->transaksi->whereMonth('created_at', $current_date->month)->get();
        $row = $this->keuangan->where('bulan_laporan', now()->format('F'));
        if ($row->first()->attributesToArray()['id_laporan'] != null) {
            $row->update([
                'isi_laporan' => json_encode($current_month_data),
            ]);
        } else {
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
            'title' => 'Detail Laporan',
            'state' => $this->state,
//            'data' => json_decode($this->keuangan->firstWhere('id_laporan', $id)->isi_laporan),
            'data' => $this->keuangan->firstWhere('id_laporan', $id),
        ]);
    }

}
