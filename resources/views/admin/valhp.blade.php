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
@if(auth()->user())
    @if(auth()->user()->role != "Patner")
    <div class="scan-member">
        <a href="/" class="btn btn-orange ">Tutup <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
        <div class="ag-center">
            <div class="smw-card scan-area " style="display: block;">
                <div class=" row">
                    <div id="reader" style="width: 100%; height: auto; position: relative; padding: 0px; border: 1px solid silver;">

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endif
<div class="jtiket">

    <div class="row lg-100">
        @foreach($layanan as $t)
        <div class="col-lg-6 col-md-6 col-12">
            <div class="mx-1 single-tiket">
                <div class="row">
                    <div class="col-9 mhs">
                        <span class="title">{{$t->layanan}}</span>
                        <div class="deskripsi">
                            <label>Deskripsi</label>
                            <span class="desc">
                                {{$t->deskripsi}}
                            </span>
                        </div>
                    </div>
                    <div class="col-3 p-0">
                        <div class="price">
                            <label>Mulai Dari</label>
                            @if($t->diskon > 0)
                            <s class="text-danger fm">{{rupiah($t->harga)}}</s class="text-danger"><br>
                            @endif
                            <span class="harga">{{rupiah($t->harga - $t->diskon)}}</span>
                            <label class="mt-1" style="color: #5860fcde;">{{$t->qtyoption}}x Cuci</label>
                        </div>
                    </div>
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
<div class="smw-card">
    <div class="smw-card-header"> <i class="fa fa-wpforms mr-1 i-orange" aria-hidden="true"></i>
        Tentang SMARTWAX
    </div>
    <div class="smw-card-body">
        <div class="deskrips">

            <!-- <div class="steam-app-title">
            <img src="{{url('logo.png')}}" alt="">
        </div> -->
            <span class="desc"><span class="i-orange">SMARTWAX</span> Menawarkan anda dengan teknologi termutakhir yang dipakai negara-negara maju seperti Jepang, Rusia, dan di sebagian negara Eropa. Touchless carwash (mencuci mobil tanpa sentuh). </span>
            <br>
            <label>Kelebihan:</label>
            <ol>
                <li><span class="desc">Mengurangi baret halus saat proses pencucian hingga 98 persen </span></li>
                <li><span class="desc">Menjaga kilau warna mobil dengan sabun mobil khusus PH balance </span></li>
                <li><span class="desc">Menggunakan salah satu crystal wax terbaik membuat warna cat mobil lebih awet, semakin berkilau, dengan membentuk lapisan tipis yang dapat melindungi cat mobil anda </span></li>
                <li><span class="desc">Terhindar dari kotoran dan debu, dengan proses wax pada saat akhir proses pencucian menjadikan mobil anda bersih lebih tahan lama dibandingkan dengan teknik mencuci biasa </span></li>
                <li><span class="desc">Cukup dengan mencuci mobil anda secara rutin, mobil anda akan selalu terlihat seperti baru </span></li>
            </ol>

            <span class="desc">Teknik Cuci mobil manual mempunyai banyak kekurangan seperti baret halus pada mobil, warna mobil yang tidak berkilau, mudah kusam, dan kurang menyeluruhnya dalam proses pencucian. </span>

        </div>
    </div>

</div>

<iframe id="myIframe" width="800" srcdoc="" height="600" style="display: none;" frameborder="0"></iframe>
@section("script")
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"> </script>
<script type="text/javascript">
    $('#memberid').on("keypress", function(e) {
        if (e.which == 13) {
            // doReq('memberorder/' + $(this).val(), null, function(res) {
            //     if (res.success) {
            //         Swal.fire({
            //             icon: 'success',
            //             title: res.msg,
            //             timer: 2000,
            //             button: false,
            //         }).then((result) => {
            //             const iframe = document.getElementById("myIframe"); // Dapatkan elemen iframe menggunakan DOM
            //             const kodeHTML = res.data;
            //             iframe.style = "display:block";

            //             iframe.srcdoc = kodeHTML; // Atur srcdoc dengan kode HTML yang diinginkan
            //             iframe.onload = function() {
            //                 iframe.contentWindow.print();
            //             };
            //             iframe.style = "display:none";
            //             $(".scan-area").hide();

            //         });
            //     } else {
            //         if (res.lanjut) {

            //             Swal.fire({
            //                 title: res.msg,
            //                 icon: 'info',
            //                 showDenyButton: true,
            //                 confirmButtonText: 'Ya Beli Lagi',
            //                 denyButtonText: `Beli Paket Lain`,
            //             }).then((result) => {
            //                 /* Read more about isConfirmed, isDenied below */
            //                 if (result.isConfirmed) {
            //                     doReq("belilagi/" + res.id, null, (r) => {
            //                         window.location.href = r
            //                     })
            //                 } else if (result.isDenied) {
            //                     // Swal.fire('Changes are not saved', '', 'info')
            //                     $(".scan-area").hide();
            //                 }
            //             })
            //         } else {
            //         }

            //     }

            // })
        }
    })



    $(document).ready(function() {
        $(".html5-qrcode-element").addClass("btn btn-orange");
        let = data = "yummy", count = 0;

        function onScanSuccess(decodedText, decodedResult) {
            let newcode = decodedText;
            if (newcode != data) {
                data=newcode;
                if (count == 0) {
                    count = 1
                    doReq('memberorder/' + decodedText, null, function(res) {

                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: res.msg,
                                timer: 2000,
                                button: false,
                            }).then((result) => {
                                // const iframe = document.getElementById("myIframe"); // Dapatkan elemen iframe menggunakan DOM
                                // const kodeHTML = res.data;
                                // iframe.style = "display:block";
                                // iframe.srcdoc = kodeHTML; // Atur srcdoc dengan kode HTML yang diinginkan
                                // iframe.onload = function() {
                                //     iframe.contentWindow.print();
                                // };
                                // iframe.style = "display:none";
                                // $(".scan-area").hide();
                                window.location.href = baseUri('langganan/'+res.data_id)

                                count = 0
                            });
                            // html5QrcodeScanner.pause();
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
                                    count = 0

                                })
                            } else {
                                Swal.fire({
                                    title: "Qr Tidak Valid atau Sudah Terpakai",
                                    icon: 'error',
                                    showDenyButton: true,
                                    button: true,
                                }).then((result) => {

                                    count = 0

                                })


                            }

                        }
                    })
                }
            }

        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // for example:
            // console.warn(`Code scan error = ${error}`);
        }
        // html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: {
                    width: 270,
                    height: 240,
                    responsive: false,

                }
            }
        );

        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        html5QrcodeScanner.pause();

    })
    $(document).on("click", ".scan-link", function() {
        if ($(this).hasClass("onshow")) {
            $(this).removeClass("onshow");
            $(".scan-area").hide();

        } else {
            $(this).addClass("onshow");
            $(".scan-area").show();
            $("#memberid").focus()
        }
    });
</script>
@endsection




@endsection