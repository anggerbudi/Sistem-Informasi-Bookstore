<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.cdnfonts.com/css/vogue" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/itc-avant-garde-gothic-std-book" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
          integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script src="{{asset('bootstrap/js/popper.min.js')}}"></script>
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    @if(in_array($title, ['Kelola Barang', 'Kelola Pegawai', 'Laporan Keuangan', 'Halaman Transaksi', 'Transaksi', 'Riwayat Transaksi']))
        <link rel="stylesheet" href="{{asset('dataTables/css/dataTables.bootstrap5.min.css')}}">
        <script defer src="{{asset('dataTables/js/jquery-3.5.1.js')}}"></script>
        <script defer src="{{asset('dataTables/js/jquery.dataTables.min.js')}}"></script>
        <script defer src="{{asset('dataTables/js/dataTables.bootstrap5.min.js')}}"></script>
        <script defer src="{{asset('dataTables/tabel.js')}}"></script>

    @endif
    @if($title == 'Detail Laporan')
        <link rel="stylesheet" href="{{asset('dataTables/css/dataTables.bootstrap5.min.css')}}">
        <script defer src="{{asset('dataTables/js/jquery-3.5.1.js')}}"></script>
        <script defer src="{{asset('dataTables/js/jquery.dataTables.min.js')}}"></script>
        <script defer src="{{asset('dataTables/js/dataTables.bootstrap5.min.js')}}"></script>
        <script defer src="https://cdn.datatables.net/plug-ins/1.10.25/sorting/numeric-comma.js"></script>
        <script defer src="{{asset('dataTables/transaksi_tabel.js')}}"></script>
    @endif
    <title>{{$title}}</title>
    <style>
        body {
            background-color: #2f4f4f;
        }
    </style>

</head>
<body>
<header>
    @include('partials.navbar')
</header>
<main style="padding-top: 4rem" class="ms-3 me-3">
    @yield('main')
</main>
</body>
</html>
