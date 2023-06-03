<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $fillable = [
        'id_laporan',
        'tahun_laporan',
        'bulan_laporan',
        'isi_laporan',
    ];

    protected $attributes = [
        'tahun_laporan' => ''
    ];
}
