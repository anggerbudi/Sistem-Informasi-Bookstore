@extends('layouts.main')
<style>
    .container img{
        display: block;
        margin-left: auto;
        margin-right: auto;
        pointer-events: none;
    }
</style>
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
        <div class="container">
            <img src="images/logo.png" alt="" >
        </div>
        <div class="footer"><h5 style="font-family:vogue, sans-serif;font-style:italic;font-stretch:100%;color:white;bottom:0px;position:absolute;left: 0; width: 100%; text-align: center;">WELCOME BACK {{Auth::user()->name}}</h5></div>
    @endauth

@endsection