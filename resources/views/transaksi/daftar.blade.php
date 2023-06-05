@extends('layouts.main')
<style>
    p{
        font-family: itc-avant-garde-gothic-std-book, serif;
        font-size: 20px;
        color: #B2BEB5;
    }
    tr.ini {
        background-color: #193333;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, .2);
    }
    p.text-center{
        margin-top: 15px;
    }

</style>
@section('main')
    <p class="text-center"> RIWAYAT TRANSAKSI</p>

    <div class="container">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
            <tr class="ini">
                <th>ID Transaksi</th>
                <th>Nama Kasir</th>
                <th colspan="3">Daftar Barang</th>
                <th>Total Harga</th>
                <th>Uang Pembeli</th>
                <th>Uang Kembalian</th>
                <th>Tanggal Dibuat</th>
            </tr>
            </thead>
            <tbody style="background-color: #214242">
            @foreach($data as $detail)
                <tr>
                    <td style="vertical-align: middle">{{$detail->id_transaksi}}</td>
                    <td style="vertical-align: middle">{{$detail->nama_kasir}}</td>
                    <td style="vertical-align: middle">
                        <div style="padding: 5px">
                            @foreach(json_decode($detail->daftar_barang) as $barang)
                                {{$barang}}<br>
                            @endforeach
                        </div>
                    </td>
                    <td style="vertical-align: middle">
                        <div style="padding: 5px">
                            @foreach(json_decode($detail->daftar_harga) as $harga)
                                @money($harga)<br>
                            @endforeach
                        </div>
                    </td>
                    <td style="vertical-align: middle">
                        <div style="padding: 5px">
                            @foreach(json_decode($detail->daftar_jumlah) as $jumlah)
                                (×{{$jumlah}})<br>
                            @endforeach
                        </div>
                    </td>
                    <td style="vertical-align: middle">@money($detail->total_harga)</td>
                    <td style="vertical-align: middle">@money($detail->bayar)</td>
                    <td style="vertical-align: middle">@money($detail->kembalian)</td>
                    <td style="vertical-align: middle">
                        @tanggal($detail->created_at)
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr class="ini">
                <th>ID Transaksi</th>
                <th>Nama Kasir</th>
                <th colspan="3">Daftar Barang</th>
                <th>Total Harga</th>
                <th>Uang Pembeli</th>
                <th>Uang Kembalian</th>
                <th>Tanggal Dibuat</th>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection
