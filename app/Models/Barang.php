<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'harga_barang',
    ];

    protected $attributes = [
        'stock_barang' => 0
    ];
}
