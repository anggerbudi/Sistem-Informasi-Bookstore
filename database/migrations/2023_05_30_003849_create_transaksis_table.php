<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->string('nama_kasir');
            $table->json('daftar_barang');
            $table->json('daftar_harga');
            $table->json('daftar_jumlah');
            $table->double('total_harga');
            $table->double('bayar');
            $table->double('kembalian');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};

/*
App\Models\Transaksi::create([
    'id_transaksi' => ,
    'nama_kasir' => ,
    'daftar_barang' => ,
    'daftar_harga' => ,
    'daftar_jumlah' => ,
    'total_harga' => ,
    'bayar' => ,
    'kembalian' =>
])
*/
