@extends('layouts.main')

@section('main')

    <h1 class="text-center"> Halaman Kelola Pegawai</h1>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-light" data-bs-toggle="modal"
            data-bs-target="#popUpTambahAkun">
        Tambah Akun
    </button>

    <!-- Modal -->
    <div class="modal fade" id="popUpTambahAkun" tabindex="-1"
         aria-labelledby="popupFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popupFormLabel{{--{{$item['id']}}--}}">
                        Data Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahAkun" method="post"
                          action="/pegawai/tambah">
                        @csrf <!-- {{ csrf_field() }} -->
                        <div class="mb-3">
                            <label for="name_akun"
                                   class="form-label">Nama</label>
                            <input type="text" class="form-control"
                                   id="name_akun"
                                   name="name_akun"
                                   placeholder="xxx">
                        </div>
                        <div class="mb-3">
                            <label for="email_akun"
                                   class="form-label">Email</label>
                            <input type="text" class="form-control"
                                   id="email_akun"
                                   name="email_akun"
                                   placeholder="email@blablabla.bla">
                        </div>
                        <div class="mb-3">
                            <label for="password_akun" class="form-label">Password</label>
                            <input type="password" class="form-control"
                                   id="password_akun"
                                   name="password_akun"
                                   placeholder="xxxxx">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                    </button>
                    <button type="submit" form="formTambahAkun"
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
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Edit</th>
                <th>Hapus</th>
            </tr> <!-- Table Header -->
            </thead>
            <tbody>
            @foreach($data as $kasir)
                <tr>
                    <td>{{$kasir['id']}}</td>
                    <td>{{$kasir['name']}}</td>
                    <td>{{$kasir['email']}}</td>
                    <td>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                data-bs-target="#popupFormStok{{$kasir['id']}}">
                            Edit Akun
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="popupFormStok{{$kasir['id']}}" tabindex="-1"
                             aria-labelledby="popupFormLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="popupFormLabel{{$kasir['id']}}">
                                            Edit {{$kasir['nama']}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formEditAkun{{$kasir['id']}}" method="post"
                                              action="/pegawai/edit/{{$kasir['id']}}">
                                            @csrf <!-- {{ csrf_field() }} -->
                                            <div class="mb-3">
                                                <label for="nama{{$kasir['id']}}" class="form-label">Nama</label>
                                                <input type="text" class="form-control"
                                                       id="nama{{$kasir['id']}}" name="nama{{$kasir['id']}}"
                                                       value="{{$kasir['nama']}}">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                        </button>
                                        <button type="submit" form="formEditAkun{{$kasir['id']}}"
                                                class="btn btn-primary">Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#popupFormHapusAkun{{$kasir['id']}}">
                            Hapus Akun
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="popupFormHapusAkun{{$kasir['id']}}" tabindex="-1"
                             aria-labelledby="popupFormLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="popupFormLabel{{$kasir['id']}}">
                                            Hapus {{$kasir['nama_barang']}}?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formHapusAkun{{$kasir['id']}}" method="post"
                                              action="/pegawai/hapus{{$kasir['id']}}">
                                            @csrf <!-- {{ csrf_field() }} -->
                                            <div class="mb-3">
                                                Apakah anda yakin ingin hapus Akun {{$kasir['name']}}
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal
                                        </button>
                                        <button type="submit" form="formHapusAkun{{$kasir['id']}}"
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
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Edit</th>
                <th>Hapus</th>
            </tr> <!-- Table Footer -->
            </tfoot>
        </table>
    </div>

@endsection

