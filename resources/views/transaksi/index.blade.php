<?php

    $serial = now()

?>
<style>
    p {
        font-family: itc-avant-garde-gothic-std-book, serif;
        font-size: 20px;
        color: #B2BEB5;
        margin-top: 15px;
    }
    p.text-center{
        margin-top: 50px;
    }
</style>


@extends('layouts.main')

@section('main')
    <p class="text-center"> HALAMAN TRANSAKSI</p>

<form action="/transaksi/belanja/baru/{{now()->format('YmdHis')}}" method="post">
    @csrf
    <input type="submit" value="Buat Transaksi Baru" style="margin-left: 45%;margin-top: 20px;background-color: #193333">
</form>

    <a href="/transaksi/riwayat" style="margin-left: 47%;margin-top: 20px">
        <button>
            Riwayat
        </button>
    </a>

    @if(1===2)
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-light" data-bs-toggle="modal"
                data-bs-target="#popUpAPA" style="transform: translate(80%, 0%); margin-bottom: 20px;">
            ====================Tulisan Tombol======================
        </button>

        <!-- Modal -->
        <div class="modal fade" id="popUpAPA" tabindex="-1"
             aria-labelledby="popupFormLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="popupFormLabel">
                            ===================Judul Modal===================</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAPA" method="post" action="">
                            @csrf
                            <div class="mb-3">
                                <label for="coba"
                                       class="form-label">cooba</label>
                                <input type="text" class="form-control"
                                       id="coba"
                                       name="coba"
                                       placeholder="xxx">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                        </button>
                        <button type="submit" form="formAPA"
                                class="btn btn-warning">Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
