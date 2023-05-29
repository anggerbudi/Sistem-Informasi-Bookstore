@extends('layouts.main')

@section('body')

    <h1 class="text-center">Halaman Laporan Keuangan</h1>
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
                        <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                data-bs-target="#popupFormStok{{$laporan['id']}}">
                            Lihat Data
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="popupFormStok{{$laporan['id']}}" tabindex="-1"
                             aria-labelledby="popupFormLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="popupFormLabel{{$laporan['id']}}">
                                            Detail Laporan Bulan {{$laporan['bulan_laporan']}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formEditAkun{{$laporan['id']}}" method="post"
                                              action="/pegawai/edit/{{$laporan['id']}}">
                                            @csrf <!-- {{ csrf_field() }} -->
                                            <div class="mb-3">
                                                <label for="nama{{$laporan['id']}}" class="form-label">Nama</label>
                                                <input type="text" class="form-control"
                                                       id="nama{{$laporan['id']}}" name="nama{{$laporan['id']}}"
                                                       value="{{$laporan['nama']}}">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                        </button>
                                        <button type="submit" form="formEditAkun{{$laporan['id']}}"
                                                class="btn btn-primary">Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
