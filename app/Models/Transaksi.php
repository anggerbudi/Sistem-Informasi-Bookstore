<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'id_transaksi',
        'nama_kasir',
        'daftar_barang',
        'daftar_harga',
        'total_harga',
    ];

    protected $casts = [
        'daftar_barang' => 'array',
        'daftar_harga' => 'array',
    ];
}
