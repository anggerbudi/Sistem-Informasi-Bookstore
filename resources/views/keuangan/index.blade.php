@extends('layouts.main')

<style>
    .text-center{
        font-family: itc-avant-garde-gothic-std-book, serif;
        font-size: 20px;
        color: #B2BEB5;
        margin-top: 15px;
        margin-bottom: 50px;
    }
    tr.ini{
        background-color: #193333;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, .2);
    }

</style>
@section('main')

    <h1 class="text-center">HALAMAN LAPORAN KEUANGAN</h1>
    <div class="container">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
            <tr class="ini">
                <th>ID Laporan</th>
                <th>Tahun Laporan</th>
                <th>Bulan Laporan</th>
                <th>Detail Laporan</th>
            </tr> <!-- Table Header -->
            </thead>
            <tbody style="background-color: #214242">
            @foreach($data as $laporan)
                <tr>
                    <td>{{$laporan['id_laporan']}}</td>
                    <td>{{$laporan['tahun_laporan']}}</td>
                    <td>{{$laporan['bulan_laporan']}}</td>
                    <td>
                        <form action="/keuangan/detail/{{$laporan['id_laporan']}}" method="post">
                            @csrf
                            <input type="submit" value="Lihat">
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr class="ini">
                <th>ID Laporan</th>
                <th>Tahun Laporan</th>
                <th>Bulan Laporan</th>
                <th>Detail Laporan</th>
            </tr> <!-- Table Footer -->
            </tfoot>
        </table>
    </div>

@endsection
