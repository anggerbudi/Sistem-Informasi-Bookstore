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
    <script src="{{asset('bootstrap/js/popper.min.js')}}"></script>
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    @if(in_array($title, ['Kelola Barang', 'Kelola Pegawai', 'Laporan Keuangan', 'Halaman Transaksi', 'Transaksi']))
        <link rel="stylesheet" href="{{asset('dataTables/css/dataTables.bootstrap5.min.css')}}">
        <script defer src="{{asset('dataTables/js/jquery-3.5.1.js')}}"></script>
        <script defer src="{{asset('dataTables/js/jquery.dataTables.min.js')}}"></script>
        <script defer src="{{asset('dataTables/js/dataTables.bootstrap5.min.js')}}"></script>
        <script defer src="{{asset('dataTables/tabel.js')}}"></script>
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
