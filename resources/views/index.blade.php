@extends('layouts.app')

@section('title')
Layanan
@endsection
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

<div class="scan-member">
    <a class="btn btn-orange scan-link">Via Scan Tiket <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
    <div class="ag-center">
        <div class="smw-card scan-area " style="display: none;">
            <div class=" row">
                <div class="msg1" style="display:none;">
                </div>
                <div class="smw-card-body">
                    <h2 class="smid">
                        Scan Tiket Anda
                    </h2>
                    <!-- <div class="time">00:00 AM</div>
                    <div class="hint">Scan QR Code untuk verifikasi</div> -->
                    <!-- Ubah input menjadi readonly untuk kode tiket -->
                    <input type="text" class="form-control member-code" value="" id="memberid">

                </div>
            </div>
        </div>
    </div>
</div>
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
                            <label class="mt-1" style="color: #5860fcde;">{{$t->qtyoption}}x cuci</label>
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
                    <!-- <span class="available"> @if($t->status >0) Available @else Unavailable @endif</span> -->
                    <div class="buy">
                        <a href="form-order/{{$t->slug}}" class="buy"><i class="fa fa-shopping-cart mr-1" aria-hidden="true"></i>Order</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<iframe id="myIframe" width="800" srcdoc="" height="600" style="display: none;" frameborder="0"></iframe>


<script type="text/javascript">
    $('#memberid').on("keypress", function(e) {
        if (e.which == 13) {
            doReq('memberorder/' + $(this).val(), null, function(res) {
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: res.msg,
                        timer: 2000,
                        button: false,
                    }).then((result) => {
                        const iframe = document.getElementById("myIframe"); // Dapatkan elemen iframe menggunakan DOM
                        const kodeHTML = res.data;
                        iframe.style = "display:block";

                        iframe.srcdoc = kodeHTML; // Atur srcdoc dengan kode HTML yang diinginkan
                        iframe.onload = function() {
                            iframe.contentWindow.print();
                        };
                        iframe.style = "display:none";
                        $(".scan-area").hide();

                    });
                } else {
                    if (res.lanjut) {

                        Swal.fire({
                            title: res.msg,
                            icon: 'info',
                            showDenyButton: true,
                            confirmButtonText: 'Ya Beli Lagi',
                            denyButtonText: `Beli Paket Lain`,
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                doReq("belilagi/" + res.id, null, (r) => {
                                    window.location.href = r
                                })
                            } else if (result.isDenied) {
                                // Swal.fire('Changes are not saved', '', 'info')
                                $(".scan-area").hide();
                            }
                        })
                    } else {

                    }

                }

            })
        }
    })
</script>


@endsection