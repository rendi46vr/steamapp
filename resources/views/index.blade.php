@extends('layouts.app')

@section('style')

@endsection
@section('content')
<?php
function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
} ?>
<!-- <h1 class="f">Jenis Layanan</h1> -->

<div class="jtiket">
    <div class="row lg-100">

        @foreach($layanan as $t)
        <div class="col-lg-6 col-md-6 col-12">
            <div class="single-tiket">
                <div class="row">
                    <div class="col-9">
                        <span class="title">{{$t->layanan}}</span>
                    </div>
                    <div class="col-3 p-0">
                        <div class="price">
                            <label>Mulai Dari</label>
                            <span class="harga">{{rupiah($t->harga)}}</span>
                        </div>
                    </div>
                </div>
                <div class="deskripsi">
                    <label>Deskripsi</label>
                    <span class="desc">
                        {{$t->deskripsi}}
                    </span>
                </div>
                <div class="tiket-footer">
                    <span class="available"> @if($t->status >0) Available @else Unavailable @endif</span>
                    <div class="buy">
                        <a href="form-order" class="buy"><i class="fa fa-shopping-cart mr-1" aria-hidden="true"></i>Order</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


@endsection