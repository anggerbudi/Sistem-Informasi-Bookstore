@extends('layouts.main')
<style>
    .container img {
        display: block;
        margin-left: auto;
        margin-right: auto;
        pointer-events: none;
    }

    #footer {
        left: 0px;
        height: 80px;
        position: absolute;
        overflow: hidden;
        background: #2f4f4f;
        margin-left: auto;
        margin-right: auto;

    }

    .contents {
        width: 100%;
        padding-top: 20px;
        font-size: 15px;
        white-space: nowrap;
        text-transform: uppercase;
        font-family: vogue, sans-serif;
        font-weight: 300;
        overflow: hidden;
        padding-left: 50%;
    }

    .footerstyle {
        display: inline-block;
        -webkit-animation: scrolling-left1 20s linear infinite;
        animation: scrolling-left1 7s linear infinite;
        margin-left: auto;
        margin-right: auto;
    }

    @keyframes scrolling-left1 {

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
            <img src="{{asset('images/svg/Dashboard.svg')}}" alt="dashboard image" width="500px">
        </div>
        <div id="footer">
            <p class="contents">
                <span class="footerstyle">WELCOME BACK {{Auth::user()->name}}</h5></span></p></div>
    @endauth
@endsection
