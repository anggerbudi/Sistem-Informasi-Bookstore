@extends('layouts.main')

@php
    $hargaTotal = 0;
    if (isset($url)) {
        $currentData = json_decode(Crypt::decryptString($url));
        foreach ($currentData as $harga) {
            $hargaTotal += $harga->harga_barang * $harga->jumlah_barang;
        }
    }
    $uangBayar = intval(request('uang_bayar'));
@endphp
<style>
    h1.text-center {
        margin-top: 50px;
        font-family: itc-avant-garde-gothic-std-book, serif;
        font-size: 20px;
        color: #B2BEB5;
    }

    h1 {

        font-family: itc-avant-garde-gothic-std-book, serif;
        font-size: 20px;
        color: #B2BEB5;
    }

    tr.ini {
        background-color: #193333;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, .2);
    }

</style>
@section('main')
    <h1 class="text-center"> TRANSAKSI - {{$tgl}}</h1>
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
                    <h5 class="modal-title" id="popupFormLabel">
                        Data Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formScanBarang" method="post" action="/transaksi/belanja/tambah/{{$tgl}}/{{$url}}">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_barang_input" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama_barang_input" name="nama_barang_input"
                                   placeholder="xxx">
                            <ul id="suggestions" class=""></ul>
                            <style>
                                li:hover {
                                    background-color: gray;
                                }
                            </style>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="formScanBarang" id="buttonFormScan" class="btn btn-warning" disabled>
                        Submit
                    </button>
                </div>

                <script>
                    const nama_barang_input = document.getElementById('nama_barang_input');
                    const suggestionList = document.getElementById('suggestions');
                    const suggestions = @json($array_nama_barang);
                    const submitButton = document.getElementById('buttonFormScan');

                    // Event listener for input changes in the search bar
                    nama_barang_input.addEventListener('input', () => {
                        const searchText = nama_barang_input.value.toLowerCase();

                        // Check if the input matches exactly one of the suggestions
                        const exactMatch = suggestions.some(suggestion =>
                            suggestion.toLowerCase() === searchText
                        );

                        // Enable or disable the submit button based on exact match
                        submitButton.disabled = !exactMatch;

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
                                submitButton.disabled = false; // Enable the submit button
                            });

                            suggestionList.appendChild(li);
                        });
                    }

                    // Function to perform the desired action with the selected suggestion
                    function performAction(suggestion) {
                        // Perform your desired action here
                        document.getElementById('nama_barang_input').value = suggestion;
                        document.getElementById('formScanBarang').submit();
                    }
                </script>
                <script>
                    const nama_barang_input = document.getElementById('nama_barang_input');
                    const suggestionList = document.getElementById('suggestions');
                    const suggestions = @json($array_nama_barang);

                    // Event listener for input changes in the search bar
                    nama_barang_input.addEventListener('input', () => {
                        const searchText = nama_barang_input.value.toLowerCase();
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
                        document.getElementById('nama_barang_input').value = suggestion;
                        document.getElementById('formScanBarang').submit();
                        // You can replace the above line with your custom action, such as redirecting to a page or executing a function.
                    }

                </script>
            </div>
        </div>
    </div>
    <div class="container">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
            <tr class="ini">
                <th>ID</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Harga Total</th>
                <th>Hapus</th>
            </tr> <!-- Table Header -->
            </thead>
            <tbody style="background-color: #214242">
            @foreach($data as $item)
                <tr>
                    <td>{{$item['kode_barang']}}</td>
                    <td>{{$item['nama_barang']}}</td>
                    <td>{{$item['harga_barang']}}</td>
                    <td>
                        <form action="/transaksi/belanja/jumlah/{{$tgl}}/{{$url}}/{{$item['kode_barang']}}"
                              method="post">
                            @csrf
                            <label for="edit_jumlah{{$item['kode_barang']}}"></label>
                            <input type="number" class="form-control" name="edit_jumlah{{$item['kode_barang']}}"
                                   id="edit_jumlah{{$item['kode_barang']}}" value="{{$item['jumlah_barang']}}"
                                   style="width: 100px; display: inline-block" min="0" max="{{$item['stock_barang']}}"
                                   onkeydown="return event.keyCode !== 189"
                                   oninput="updateQuantity(this, {{$item['stock_barang']}})">
                            <input type="submit" value="Edit" class="form-control"
                                   style="width: 50px; display: inline-block">
                        </form>

                        <script>
                            function updateQuantity(input, maxStock) {
                                var quantity = parseInt(input.value);

                                if (isNaN(quantity) || quantity < 0) {
                                    input.value = 0;
                                } else if (quantity > maxStock) {
                                    input.value = maxStock;
                                }
                            }
                        </script>
                    </td>
                    <td>{{$item['total_harga']}}</td>
                    <td>
                        <form action="/transaksi/belanja/hapus/{{$tgl}}/{{$url}}/{{$item['kode_barang']}}"
                              method="post">
                            @csrf
                            <input type="submit" value="Hapus" class="btn btn-danger">
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr class="ini">
                <th>ID</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Hapus</th>
            </tr> <!-- Table Footer -->
            </tfoot>
        </table>
    </div>
    <p style="position: fixed;bottom: 91px;right: 200px;">Total Harga : {{$hargaTotal}}</p>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-light" data-bs-toggle="modal"
            data-bs-target="#popUpBayar" style="position: fixed;bottom: 100px;right: 100px;">
        Bayar
    </button>

    <!-- Modal -->
    <div class="modal fade" id="popUpBayar" tabindex="-1"
         aria-labelledby="popupFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popupFormLabel">
                        Masukkan Nominal Uang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formBayar" method="post" action="/transaksi/belanja/bayar/{{$tgl}}/{{$url}}">
                        @csrf
                        <div class="mb-3">
                            <label for="hargaTotal">Total Harga : </label>
                            <input type="number" name="hargaTotal" id="hargaTotal" class="form-control" readonly
                                   value="{{$hargaTotal}}">
                            <hr>
                            <label for="uang_bayar" class="form-label">Nominal</label>
                            <input type="number" class="form-control" id="uang_bayar" name="uang_bayar"
                                   placeholder="xxx">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="bayarButton" class="btn btn-warning" data-bs-toggle="modal" disabled>
                        Masukkan Nominal
                    </button>
                </div>

                <script>
                    const uangBayarInput = document.getElementById('uang_bayar');
                    const bayarButton = document.getElementById('bayarButton');

                    uangBayarInput.addEventListener('input', () => {
                        const nominal = uangBayarInput.value;
                        const hargaTotal = parseInt(document.getElementById('hargaTotal').value);
                        if (hargaTotal === 0) {
                            bayarButton.disabled = true;
                        } else if (nominal === '' || parseInt(nominal) < hargaTotal) {
                            bayarButton.disabled = true;
                            bayarButton.textContent = 'Uang Kurang';
                        } else {
                            bayarButton.disabled = false;
                            bayarButton.textContent = 'Bayar';
                        }
                    });

                    bayarButton.addEventListener('click', () => {
                        if (!bayarButton.disabled) {
                            var uang1 = document.getElementById('uang_bayar').value;
                            var uang = parseInt(document.getElementById('uang_bayar').value);
                            var total = parseInt(document.getElementById('hargaTotal').value);
                            var kembalian = uang - total;
                            // Perform further actions (e.g., validation, processing, etc.)
                            // Example: Display form values in an alert
                            if (uang < total || uang1 === "") {
                                var myModalKurang = new bootstrap.Modal(document.getElementById('popUpKurang'));
                                myModalKurang.show();
                            } else {
                                var myModalBayar = new bootstrap.Modal(document.getElementById('popUpKonfirmasi'));
                                document.getElementById('uang_pembayar').value = uang;
                                document.getElementById('total_harga').value = total;
                                document.getElementById('kembalian').value = kembalian;
                                myModalBayar.show();
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
    <script>
        var button = document.getElementById("myButton");

        button.addEventListener("click", function () {
            var uang1 = document.getElementById('uang_bayar').value;
            var uang = parseInt(document.getElementById('uang_bayar').value);
            var total = parseInt(document.getElementById('hargaTotal').value);
            var kembalian = uang - total;
            // Perform further actions (e.g., validation, processing, etc.)
            // Example: Display form values in an alert
            if (uang < total || uang1 === "") {
                var myModalKurang = new bootstrap.Modal(document.getElementById('popUpKurang'));
                myModalKurang.show();
            } else {
                var myModalBayar = new bootstrap.Modal(document.getElementById('popUpKonfirmasi'));
                document.getElementById('uang_pembayar').value = uang;
                document.getElementById('total_harga').value = total;
                document.getElementById('kembalian').value = kembalian;
                myModalBayar.show();
            }
        });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="popUpKonfirmasi" tabindex="-1"
         aria-labelledby="popupFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popupFormLabel">
                        Konfirmasi Bayar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formKonfirmasi" method="post" action="/transaksi/belanja/bayar/{{$tgl}}/{{$url}}">
                        @csrf
                        <label for="uang_pembayar">Uang Pembeli : </label>
                        <br>
                        <input type="text" readonly name="uang_pembayar" id="uang_pembayar">
                        <br>
                        <br>
                        <label for="total_harga">Total Belanja : </label>
                        <br>
                        <input type="text" readonly name="total_harga" id="total_harga">
                        <br>
                        <br>
                        <label for="kembalian">Kembalian : </label>
                        <br>
                        <input type="text" readonly name="kembalian" id="kembalian">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                    </button>
                    <button type="submit" form="formKonfirmasi"
                            class="btn btn-warning">Bayar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="popUpKurang" tabindex="-1"
         aria-labelledby="popupFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popupFormLabel">
                        Konfirmasi Kurang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    UANG KURANG
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection



