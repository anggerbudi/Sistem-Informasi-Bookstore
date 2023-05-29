@extends('layouts.main')

@section('main')

    @guest()
        <div class="p-5 mb-4 bg-body-tertiary rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Welcome to Our Bookstore</h1>
                <p class="col-md-8 fs-4">Discover a world of knowledge and adventure</p>
            </div>
        </div>
    @endguest

    @auth()
    <div class="text-center text-capitalize">
        <h1>
            <br>
            <br>
            <br>
            KERJA KERJA KERJA
            <br>
            <br>
            <br>
            Kerja Pangkal Kaya
        </h1>
    </div>
    @endauth

@endsection
