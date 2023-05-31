

@extends('layouts.main')



@section('main')

{{--    {{dd($data)}}--}}

    <h1 class="text-center"> Halaman Pembayaran {{$tgl}}</h1>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-light" data-bs-toggle="modal"
            data-bs-target="#popUpScanBarang" style="transform: translate(80%, 0%); margin-bottom: 20px;">
        Tambah Barang
    </button>

    <!-- Modal -->
    <div class="modal fade" id="popUpScanBarang" tabindex="-1"
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
                    <form id="formScanBarang" method="post"
                          action="/transaksi/belanja/{{$tgl}}/{{$url}}">
                        @csrf <!-- {{ csrf_field() }} -->
                        <div class="mb-3">
                            <label for="name_akun"
                                   class="form-label">Nama</label>
                            <input type="text" class="form-control"
                                   id="name_akun"
                                   name="name_akun"
                                   placeholder="xxx">
                            <ul id="suggestions" class=""></ul>
                            <style>
                                li:hover {
                                    background-color: gray;
                                }
                            </style>
                        </div>
                    </form>
                    <script>
                        const name_akun = document.getElementById('name_akun');
                        const suggestionList = document.getElementById('suggestions');
                        const suggestions = @json(   $array_nama_barang);
                        console.log(suggestions);
                        // Event listener for input changes in the search bar
                        name_akun.addEventListener('input', () => {
                            const searchText = name_akun.value.toLowerCase();
                            let matchingSuggestions = [];

                            if (searchText.length >= 1) {
                                // Filter suggestions based on search text
                                matchingSuggestions = suggestions.filter(suggestion =>
                                    suggestion.toLowerCase().startsWith(searchText)
                                );
                            }

                            // Display the filtered suggestions
                            displaySuggestions(matchingSuggestions);
                        });

                        // Function to display suggestions in the suggestion list
                        function displaySuggestions(matchingSuggestions) {
                            suggestionList.innerHTML = '';

                            // Create and append list items for each suggestion
                            matchingSuggestions.forEach(suggestion => {
                                const li = document.createElement('li');
                                li.textContent = suggestion;

                                // Event listener for suggestion click
                                li.addEventListener('click', () => {
                                    performAction(suggestion);
                                    suggestionList.innerHTML = '';
                                });

                                suggestionList.appendChild(li);
                            });
                        }

                        // Function to perform the desired action with the selected suggestion
                        function performAction(suggestion) {
                            // Perform your desired action here
                            document.getElementById('name_akun').value = suggestion;
                            document.getElementById('formScanBarang').submit();
                            // You can replace the above line with your custom action, such as redirecting to a page or executing a function.
                        }

                    </script>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                    </button>
                    <button type="submit" form="formScanBarang"
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
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Harga Total</th>
                <th>Hapus</th>
            </tr> <!-- Table Header -->
            </thead>
            <tbody>
            @foreach($data as $kasir)
                <tr>
                    <td>{{$kasir['kode_barang']}}</td>
                    <td>{{$kasir['nama_barang']}}</td>
                    <td>{{$kasir['harga_barang']}}</td>
                    <td width="25%">
                        <form action="/transaksi/editJumlah/{{$tgl}}/{{$url}}/{{$kasir['kode_barang']}}" method="post">
                            @csrf
                            <input type="number" class="form-control" name="edit_jumlah{{$kasir['kode_barang']}}" id="edit_jumlah{{$kasir['kode_barang']}}" value="{{$kasir['jumlah_barang']}}"style="width: 100px; display: inline-block">
                            <input for="edit_jumlah{{$kasir['kode_barang']}}" type="submit" value="Edit" class="form-control" style="width: 50px; display: inline-block">
                        </form>
                    </td>
                    <td>{{$kasir['total_harga']}}</td>
                    <td>
                        <form action="/transaksi/hapus/{{$tgl}}/{{$url}}/{{$kasir['kode_barang']}}" method="post">
                            @csrf
                            <input type="submit" value="Hapus" class="btn btn-danger">
                        </form>
                    </td>
{{--                    <td>--}}
{{--                        <!-- Button trigger modal -->--}}
{{--                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"--}}
{{--                                data-bs-target="#popupFormHapusAkun{{$kasir['id']}}">--}}
{{--                            Hapus Akun--}}
{{--                        </button>--}}

{{--                        <!-- Modal -->--}}
{{--                        <div class="modal fade" id="popupFormHapusAkun{{$kasir['id']}}" tabindex="-1"--}}
{{--                             aria-labelledby="popupFormLabel" aria-hidden="true">--}}
{{--                            <div class="modal-dialog">--}}
{{--                                <div class="modal-content">--}}
{{--                                    <div class="modal-header">--}}
{{--                                        <h5 class="modal-title" id="popupFormLabel{{$kasir['id']}}">--}}
{{--                                            Hapus {{$kasir['nama_barang']}}?</h5>--}}
{{--                                        <button type="button" class="btn-close" data-bs-dismiss="modal"--}}
{{--                                                aria-label="Close"></button>--}}
{{--                                    </div>--}}
{{--                                    <div class="modal-body">--}}
{{--                                        <form id="formHapusAkun{{$kasir['id']}}" method="post"--}}
{{--                                              action="/pegawai/hapus{{$kasir['id']}}">--}}
{{--                                            @csrf <!-- {{ csrf_field() }} -->--}}
{{--                                            <div class="mb-3">--}}
{{--                                                Apakah anda yakin ingin hapus Akun {{$kasir['name']}}--}}
{{--                                            </div>--}}
{{--                                        </form>--}}
{{--                                    </div>--}}
{{--                                    <div class="modal-footer">--}}
{{--                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal--}}
{{--                                        </button>--}}
{{--                                        <button type="submit" form="formHapusAkun{{$kasir['id']}}"--}}
{{--                                                class="btn btn-danger">Ya--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </td>--}}
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Hapus</th>
            </tr> <!-- Table Footer -->
            </tfoot>
        </table>
    </div>
<p style="position: fixed;bottom: 91px;right: 200px;">Total Harga : <?php $total = 0;foreach ($data as $barang){ $total += $barang['total_harga'];} echo $total;?></p>

<!-- Button trigger modal -->
<button type="button" class="btn btn-light" data-bs-toggle="modal"
        data-bs-target="#popUpBayar" style="position: fixed;bottom: 100px;right: 100px;">
    Bayar Cok
</button>

<!-- Modal -->
<div class="modal fade" id="popUpBayar" tabindex="-1"
     aria-labelledby="popupFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popupFormLabel{{--{{$item['id']}}--}}">
                    Masukkan Nominal Uang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formBayar" method="post" action="/transaksi/bayar/{{$tgl}}/{{$url}}">
                    @csrf <!-- {{ csrf_field() }} -->
                    <div class="mb-3">
                        <label for="hargaTotal">Total Harga : </label>
                        <input type="number" name="hargaTotal" id="hargaTotal" class="form-control" readonly value="<?php $total = 0;foreach ($data as $barang){ $total += $barang['total_harga'];} echo $total;?>">

                        <hr>
                        <label for="uang_bayar"
                               class="form-label">Nominal</label>
                        <input type="number" class="form-control"
                               id="uang_bayar"
                               name="uang_bayar"
                               placeholder="xxx">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                </button>
                <button type="submit" form="formBayar"
                        class="btn btn-warning">Submit
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
