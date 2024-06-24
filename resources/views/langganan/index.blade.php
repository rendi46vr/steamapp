<?php

function rupiah($angka, $true = true)
{
    if ($true) {

        $hasil_rupiah = "Rp. " . number_format(round($angka), 0, ',', '.');
    } else {
        $hasil_rupiah = number_format(round($angka), 0, ',', '.');
    }
    return $hasil_rupiah;
}
if ($pay->metpem == "tunai" || $pay->metpem == "hutang") {
    $total = $pay->totalbayar;
} else {
    $total = $pay->payment->Total;
} ?>
“
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/asset/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/asset/images/favicon.ico" type="image/x-icon">
    <title>Halaman Pembayaran</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="{{url('css/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://sandbox.ipaymu.com/asset/css/payment.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous" type="text/javascript"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> -->

    <style>
        .box-voucher {
            padding: 20px;
            border: solid 1px #f7f7f7;
        }

        .btn-flat {
            border-radius: 0px !important;
        }

        .form-check-label {
            font-size: 11px !important;
        }

        .pointer {
            cursor: pointer;
        }
    </style>
</head>

<body class="">
    <!-- <div class="pace pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity"></div>
    </div> -->
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-6 col-sm-12 col-12 d-block" style="padding: 30px 0 30px 10px;">
                <img src="{{url('/logo.png')}}" style="max-height: 65px;" alt="iPaymu Merchant">
                <!-- <h3> SteamApp</h3> -->
                <div class="d-block d-lg-none d-md-none mt-2 ml-1">
                    <h6 class="">SmartWax</h6>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-8 d-none d-lg-block d-md-block">
                <h4 class="pay-to">
                    SmartWax
                </h4>
            </div>
            <div class="col-md-6">
                <div id="product">
                    <div class="card" style="border:none;">
                        <div class="card-header">
                        <h3>Detail Paket
                            </h3>
                            <h5 class="mb-0">
                                <span class="total-text">TOTAL</span>
                                <span class="total-amount badge badge-pill">
                                    {{ rupiah( $total)}}
                                </span>
                            </h5>
                        </div>
                        <div id="cProduct" class="collapse show" data-parent="#product">
                            <div class="card-body" style="padding: 0;">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <h6>{{$pay->dataorder->name}}</h6>
                                        @if($pay->dataorder->diskon > 0)
                                        <small> <sup>Rp. </sup> <s> {{ rupiah($pay->dataorder->harga, false)}} </s></small>
                                        @else
                                        <small> <sup>Rp. </sup> {{ rupiah($pay->dataorder->harga, false)}}</small>
                                        @endif
                                        <span style="float: right;"><sup>Rp. </sup> {{rupiah($pay->dataorder->harga - $pay->dataorder->diskon, false)}}</span>
                                    </li>
                                    @foreach($addon as $lb)
                                    <li class="list-group-item">
                                        <small>{{$lb->layanantambahan->layanan}}</small>
                                        <span style="float: right;"><sup>Rp. </sup> {{rupiah($lb->harga - $lb->diskon , false)}}</span>
                                    </li>
                                    @endforeach
                                    <li class="list-group-item">
                                        <small>Quota</small>
                                        <span style="float: right;"><sup>{{$pay->quota()}} </sup></span>
                                    </li>
                                    <li class="list-group-item">
                                        <small>Sisa Quota</small>
                                        <span style="float: right;"><sup>{{$pay->sisaSaldo()}} </sup></span>
                                    </li>
                                    <li id="cInsurance" class="list-group-item" style="display:none;">
                                        <span>Biaya Admin</span>
                                        <span style="float: right;" id="insurance-amount"></span>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="padding-bottom:80px;">
                <div class="card">
                    <div class="card-header dividen">
                        <h3>Riwayat Pemakaian <b>{{$pay->plat}}</b></h3>
                    </div>
                </div>
                <div class="accordion" id="accordion">
                    <div class="card">
                        <div id="cBank" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body text-center">
                               <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Pakai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tbody>
                                            @foreach($pemakaian as $pm)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$pm->created_at}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </tbody>
                                </table>
                                <div class="flex">
                                    @if(session('success'))
                                    <button class="btn btn-orange">Behasil Menggunakan Langganan</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <iframe id="myIframe" width="800" srcdoc="" height="600" style="display: none;" frameborder="0"></iframe>
    <script src="{{url('js/app.js')}}"></script>

    <script type="text/javascript">

    </script>
</body>

</html>