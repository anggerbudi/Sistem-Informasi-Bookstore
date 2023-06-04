@extends('layouts.main')

<style>

</style>
@section('main')

    <h1 class="text-center">HALAMAN LAPORAN KEUANGAN</h1>
    <div class="container">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
            <tr>
                <th>ID Laporan</th>
                <th>Tahun Laporan</th>
                <th>Bulan Laporan</th>
                <th>Detail Laporan</th>
            </tr> <!-- Table Header -->
            </thead>
            <tbody>
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
            <tr>
                <th>ID Laporan</th>
                <th>Tahun Laporan</th>
                <th>Bulan Laporan</th>
                <th>Detail Laporan</th>
            </tr> <!-- Table Footer -->
            </tfoot>
        </table>
    </div>

@endsection
