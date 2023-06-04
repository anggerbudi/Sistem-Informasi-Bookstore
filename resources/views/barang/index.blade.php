@extends('layouts.main')

<style>
    .text-center {
        font-family: itc-avant-garde-gothic-std-book, serif;
        font-size: 20px;
        color: #B2BEB5;
        margin-top: 15px;

    }

    tr.ini {
        background-color: #193333;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, .2);
    }

    p {
        font-family: itc-avant-garde-gothic-std-book, serif;
    }

    td {
        vertical-align: middle;
        border-left: 1px solid #000;
        border-right: 1px solid #000;
    }

    td:first-child {
        border-left: none;
    }

    td:last-child {
        border-right: none;
    }

    /*input[type="number"], button {*/
    /*    margin-bottom: 0px;*/
    /*    padding: 6px;*/
    /*    width: 100%;*/
    /*    box-sizing: border-box;*/
    /*}*/


</style>

@section('main')
    <p class="text-center"> HALAMAN KELOLA BARANG</p>
    <button type="button" class="btn btn-light" data-bs-toggle="modal"
            data-bs-target="#popUpTambahBarang">
        Tambah Barang
    </button>

    <!-- Modal -->
    <div class="modal fade" id="popUpTambahBarang" tabindex="-1"
         aria-labelledby="popupFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popupFormLabel">
                        Data Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahBarang" method="post"
                          action="/barang/tambah">
                        @csrf
                        <div class="mb-3">
                            <label for="kode_barang_baru"
                                   class="form-label">Kode</label>
                            <input type="text" class="form-control"
                                   id="kode_barang_baru"
                                   name="kode_barang_baru"
                                   placeholder="xxx">
                        </div>
                        <div class="mb-3">
                            <label for="nama_barang_baru"
                                   class="form-label">Nama</label>
                            <input type="text" class="form-control"
                                   id="nama_barang_baru"
                                   name="nama_barang_baru"
                                   placeholder="barang x">
                        </div>
                        <div class="mb-3">
                            <label for="harga_barang_baru" class="form-label">Harga</label>
                            <input type="text" class="form-control"
                                   id="harga_barang_baru"
                                   name="harga_barang_baru"
                                   placeholder="xxxxx">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                    </button>
                    <button type="submit" form="formTambahBarang"
                            class="btn btn-warning">Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
            <tr class="ini">
                <th>Kode</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stock</th>
                <th>Action</th>
                <style>
                    table {
                        width: 100px;
                        table-layout: fixed;
                    }
                </style>
            </tr>
            </thead>
            <tbody style="background-color: #214242">
            @foreach($data as $item)
                <tr><div></div>
                    <td><div style="margin-top: -2px">{{$item['kode_barang']}}</div></td>
                    <td><div style="margin-top: -2px">{{$item['nama_barang']}}</div></td>
                    <td><div style="margin-top: -2px">{{$item['harga_barang']}}</div></td>
                    <td>
                        <form id="myForm1{{$item['kode_barang']}}" method="post"
                              action="/barang/stock/{{$item['kode_barang']}}" class="m-auto">
                            @csrf
                            <div>
                                <label for="tambah{{$item['kode_barang']}}"></label>
                                <input type="number" class="form-control d-inline-block"
                                       id="tambah{{$item['kode_barang']}}"
                                       name="tambah{{$item['kode_barang']}}"
                                       value="{{$item['stock_barang']}}" style="width: 100px">
                                <input type="submit" value="Save" class="btn btn-dark" style="margin-top: -4px;">
                            </div>
                        </form>
                    </td>
                    <td>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                data-bs-target="#popupFormStok{{$item['kode_barang']}}" style="background-color:#212529;border-color:#212529">
                            <img src="{{asset('images/svg/pencil-square.svg')}}" alt="edit" width="20" >
                        </button>

                        <div class="modal fade" id="popupFormStok{{$item['kode_barang']}}" tabindex="-1"
                             aria-labelledby="popupFormLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="popupFormLabel{{$item['kode_barang']}}">
                                            Edit {{$item['nama_barang']}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="myForm2{{$item['kode_barang']}}" method="post"
                                              action="/barang/edit/{{$item['kode_barang']}}">
                                            @csrf <!-- {{ csrf_field() }} -->
                                            <div class="mb-3">
                                                <label for="nama_barang{{$item['kode_barang']}}"
                                                       class="form-label">Nama</label>
                                                <input type="text" class="form-control"
                                                       id="nama_barang{{$item['kode_barang']}}"
                                                       name="nama_barang{{$item['kode_barang']}}"
                                                       value="{{$item['nama_barang']}}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="harga_barang{{$item['kode_barang']}}" class="form-label">Harga</label>
                                                <input type="text" class="form-control"
                                                       id="harga_barang{{$item['kode_barang']}}"
                                                       name="harga_barang{{$item['kode_barang']}}"
                                                       value="{{$item['harga_barang']}}">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                        </button>
                                        <button type="submit" form="myForm2{{$item['kode_barang']}}"
                                                class="btn btn-primary">Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#popupFormHapus{{$item['kode_barang']}}">
                            <img src="{{asset('images/svg/trash3-fill.svg')}}" alt="delete" width="20">
                        </button>

                        <div class="modal fade" id="popupFormHapus{{$item['kode_barang']}}" tabindex="-1"
                             aria-labelledby="popupFormLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="popupFormLabel{{$item['kode_barang']}}">
                                            Hapus {{$item['nama_barang']}}?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formHapusBarang{{$item['kode_barang']}}" method="post"
                                              action="/barang/hapus/{{$item['kode_barang']}}">
                                            @csrf
                                            <div class="mb-3">
                                                Apakah anda yakin ingin hapus {{$item['nama_barang']}}
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal
                                        </button>
                                        <button type="submit" form="formHapusBarang{{$item['kode_barang']}}"
                                                class="btn btn-danger">Ya
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
            <tr class="ini">
                <th>Kode</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection
