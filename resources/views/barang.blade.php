@extends('layouts.main')

@section('main')
    <h1 class="text-center"> Halaman Kelola Barang</h1>
    <!-- Button trigger modal -->
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
                    <h5 class="modal-title" id="popupFormLabel{{--{{$item['kode_barang']}}--}}">
                        Data Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahBarang" method="post"
                          action="/barang/tambah">
                        @csrf <!-- {{ csrf_field() }} -->
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
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stock</th>
                <td>Edit Stock</td>
                <th>Edit</th>
                <th>Hapus</th>
            </tr> <!-- Table Header -->
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{$item['kode_barang']}}</td>
                    <td>{{$item['nama_barang']}}</td>
                    <td>{{$item['harga_barang']}}</td>
                    <td> {{$item['stock_barang']}}</td>
                    <td>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                data-bs-target="#{{$item['kode_barang']}}">
                            Edit Stock
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="{{$item['kode_barang']}}" tabindex="-1"
                             aria-labelledby="popupFormLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="popupFormLabel">Edit
                                            Stok {{$item['nama_barang']}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="myForm1{{$item['kode_barang']}}" method="post"
                                              action="/barang/stock{{$item['kode_barang']}}">
                                            @csrf <!-- {{ csrf_field() }} -->
                                            <div class="mb-3">
                                                <label for="tambah{{$item['kode_barang']}}"
                                                       class="form-label">Stock</label>
                                                <input type="text" class="form-control"
                                                       id="tambah{{$item['kode_barang']}}"
                                                       name="tambah{{$item['kode_barang']}}"
                                                       value="{{$item['stock_barang']}}">
                                                <input type="button" class="mt-2" style="width: 2rem" id="plus"
                                                       name="plus" value="+"
                                                       onclick="increment({{$item['kode_barang']}})">
                                                <input type="button" class="mt-2" style="width: 2rem" id="minus"
                                                       name="minus" value="-"
                                                       onclick="decrement({{$item['kode_barang']}})">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                        </button>
                                        <button type="submit" form="myForm1{{$item['kode_barang']}}"
                                                class="btn btn-primary">Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td> <!-- Tambah Stok Popup -->
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                data-bs-target="#popupFormStok{{$item['kode_barang']}}">
                            Edit Barang
                        </button>

                        <!-- Modal -->
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
                                              action="/barang/edit{{$item['kode_barang']}}">
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

                    </td> <!-- Edit Barang Popup -->
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#popupFormHapus{{$item['kode_barang']}}">
                            Hapus Barang
                        </button>

                        <!-- Modal -->
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
                                              action="/barang/hapus{{$item['kode_barang']}}">
                                            @csrf <!-- {{ csrf_field() }} -->
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
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Harga</th>
                <th colspan="2">Stock</th>
                <th>Edit</th>
                <th>Hapus</th>
            </tr> <!-- Table Footer -->
            </tfoot>
        </table>
    </div>

    <script>
        function increment(kode) {
            var id = 'tambah'.concat(kode);
            var textField = document.getElementById(id);
            var currentValue = parseInt(textField.value);
            textField.value = currentValue + 1;
        }

        function decrement(kode) {
            var id = 'tambah'.concat(kode);
            var textField = document.getElementById(id);
            var currentValue = parseInt(textField.value);
            textField.value = currentValue - 1;
        }
    </script> <!-- JS for Stok -->
@endsection
