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
if ($pay->metpem == "tunai") {
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

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
    </style>
</head>

<body class="">
    <div class="pace pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity"></div>
    </div>
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-6 col-sm-12 col-12 d-block" style="padding: 30px 0 30px 10px;">
                <!-- <img src="http://localhost:8000/assets/images/logo.png" style="max-height: 65px;" alt="iPaymu Merchant"> -->
                <h3> SteamApp</h3>
                <div class="d-block d-lg-none d-md-none mt-2 ml-1">
                    <h6 class="">rendi</h6>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-8 d-none d-lg-block d-md-block">
                <h4 class="pay-to">
                    rendi
                </h4>
            </div>
            <div class="col-md-6">
                <div id="product">
                    <div class="card" style="border:none;">
                        <div class="card-header">
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
                                    @foreach ($pay->dataorder as $item)
                                    <li class="list-group-item">
                                        <h6>{{$item->name}}</h6>
                                        <small> <sup>Rp. </sup> {{ rupiah($item->harga, false)}}</small>
                                        <span style="float: right;"><sup>Rp. </sup> {{rupiah($item->harga, false)}}</span>
                                    </li>
                                    @endforeach
                                    <li id="cFee" class="list-group-item text-muted" style="display:block;">
                                        <span id="fee-title">Biaya Layanan</span><br>
                                        <small id="fee-desc">Admin</small>
                                        @if($pay->metpem == "tunai")
                                        <span style="float: right;" id="fee-val"><sup>Rp. </sup>0</span>
                                        @else
                                        <span style="float: right;" id="fee-val"><sup>Rp. </sup>{{ rupiah($pay->payment->Fee, false)}}</span>
                                        @endif
                                    </li>
                                    <li id="cDiscount" class="list-group-item text-muted" style="display:block;">
                                        <span id="discount-title" class="small">Discount</span>
                                        <span style="float: right;" id="discount-val"></span>
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
                        <h3>Pembayaran</h3>
                    </div>
                </div>
                <div class="accordion" id="accordion">
                    <div class="card">
                        <div id="cBank" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body text-center">
                                <div class="text-center">
                                    @if($pay->metpem == "tunai")
                                    <label for="tunai" class="form-check-label btn-outline-info disabled rounded" style="font-size: 31px !important;"><b> <i class="fa fa-money" aria-hidden="true"></i> Tunai</b></label>
                                    @else
                                    <img src="{{url($pay->payget->logo)}}" style="max-width:120px; height:auto;" alt="iPaymu Payment Channel">
                                    @endif
                                    <hr>
                                </div>
                                <p>@if($pay->payget->code == "va") Mohon Transfer Pada Akun Va dibawah ini: @elseif($pay->payget->code == "cstore")Mohon Melakukan Pembayaran di {{$pay->payget->channel_description}} @elseif($pay->payget->code == "qris") Mohon Melakukan Pembayaran pada Qrcode berikut @else Mohon Lakukan Pembayaran @endif</p>
                                <h2>{{ $pay->payget->channel_description }} </h2>
                                <h4 class="p-2 border-dashed mb-3 mt-3" style="max-width: 300px;  margin :auto;">
                                    @if($pay->metpem == "tunai")
                                    <span id="textcopyva">{{$pay->np}}</span>
                                    <span class="ml-2 small text-muted" onclick="if (!window.__cfRLUnblockHandlers) return false; copyToClipboard('#textcopyva')" style="cursor:pointer;"><em class="fa fa-copy"></em></span>
                                    @else
                                    @if($pay->metpem == "qris")
                                    <?php $html = file_get_contents($pay->payment->QrImage); ?>
                                    {!! $html !!}
                                    @else
                                    <span id="textcopyva">{{$pay->payment->PaymentNo}}</span>
                                    <span class="ml-2 small text-muted" onclick="if (!window.__cfRLUnblockHandlers) return false; copyToClipboard('#textcopyva')" style="cursor:pointer;"><em class="fa fa-copy"></em></span>
                                    @endif
                                    @endif
                                </h4>
                                <h2>Pembayaran {{$pay->name }}</h2>
                                <p class="mt-3 mb-1">jumlah</p>

                                <h4>
                                    {{rupiah($total)}}
                                    <span id="textcopy" style="display:none"> {{$total}}</span>
                                    <span class="ml-2 small text-muted" onclick="if (!window.__cfRLUnblockHandlers) return false; copyToClipboard('#textcopy')" style="cursor:pointer;"><em class="fa fa-copy"></em></span>
                                </h4>
                                @if($pay->metpem == "tunai")
                                @if($pay->status === "pending")
                                <h2 id="expired_at">Pembayaran pending</h2>
                                <p class="mt-3 mb-1 info">Menunggu Konfirmasi Pembayaran</p>
                                @elseif($pay->status == "berhasil")
                                <h2 id="expired_at">Pembayaran Berhasil<i class='fa fa-check-circle text-success' aria-hidden='true'></i></h2>
                                @endif

                                @else
                                <?php if ($pay->status == "pending") { ?>
                                    <p class="mt-3 mb-1">Tegat Waktu Pembayaran</p>
                                    <h2 id="expired_at"></h2>
                                <?php } elseif ($pay->status == "expired") { ?>
                                    <p class="mt-3 mb-1 info">Waktu Pembayaran Habis</p>
                                    <h2 id="expired_at">Transaksi gagal</h2>
                                <?php } else { ?>
                                    <p class="mt-3 mb-1 info">Status Transaksi</p>
                                    <h2 id="expired_at">Pembayaran Berhasil <i class='fa fa-check-circle text-success' aria-hidden='true'></i></h2>

                                <?php } ?>
                                @endif
                                <p class="mt-3 mb-1">Nomor Ref</p>
                                <h2>{{$pay->np}}</h2>
                                <div class="alert alert-info mt-3 text-justify" role="alert" style="font-size:12px">
                                    Note : Mohon Melakukan Pembayaran Segera sebelum waktu habis </div>
                                <div class="mt-4">
                                    @if($pay->metpem != "tunai")
                                    <a class="btn btn-primary btn-block" href="{{$pay->payget->payment_instructions_doc}}" target="_blank" rel="noopener">Cara Bayar</a>
                                    @endif
                                    <a href="{{url('/')}}" class="btn btn-secondary btn-block text-white mt-2">
                                        Pesan Ulang </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <iframe id="myIframe" width="800" srcdoc="" height="600" style="display: block;" frameborder="0"></iframe>
    <script src="{{url('js/app.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".border-dashed img")
                .css("max-width", "280px");
        });
        $(document).ready(function() {


            function updateCountdown(targetTime) {
                const targetDate = new Date(targetTime);
                const currentDate = new Date();

                if (targetDate <= currentDate) {
                    return "Pembayaran Gagal!, Waktu habis!";
                }

                const timeDifference = targetDate - currentDate;
                const seconds = Math.floor(timeDifference / 1000);

                const days = Math.floor(seconds / (24 * 3600));
                const remainingSeconds = seconds % (24 * 3600);
                const hours = Math.floor(remainingSeconds / 3600);
                const remainingSecondsAfterHours = remainingSeconds % 3600;
                const minutes = Math.floor(remainingSecondsAfterHours / 60);
                const remainingSecondsAfterMinutes = remainingSecondsAfterHours % 60;
                <?php if ($pay->metpem != "tunai") { ?>
                    const countdownString = `${days} hari, ${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${remainingSecondsAfterMinutes.toString().padStart(2, '0')}`;
                    return countdownString;
                <?php } ?>
            }

            const targetTime = "{{@$pay->payment->Expired}}";
            const expiredAtElement = document.querySelector('#expired_at');

            function updateTimer() {
                const countdownResult = updateCountdown(targetTime);
                expiredAtElement.textContent = countdownResult;
            }
            <?php
            # code...
            if ($pay->status == "pending") {
            ?>

                updateTimer(); // Initial update
                const timing = setInterval(updateTimer, 1000);
                // Update every second
                const cek = setInterval(cektransaksi, 2000);


            <?php }
            ?>
            window.jsPDF = window.jspdf.jsPDF;

            function cektransaksi() {
                console.log("ok");
                // var doc = new jspdf();

                doReq("cekTransaksi/" + "{{$pay->id}}", null, (res) => {
                    if (res.success) {
                        clearInterval(cek);
                        clearInterval(timing);
                        $("#expired_at").html("Pembayaran Berhasil <i class='fa fa-check-circle text-success' aria-hidden='true'></i>");
                        $(".info").text("");
                        Swal.fire({
                            icon: 'success',
                            title: 'Pemayaran Berhasil',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // var pdfWindow = window.open("");
                                // console.log(res.data)
                                // pdfWindow.document.open();
                                // pdfWindow.document.write(res.data);
                                // pdfWindow.document.close();
                                // pdfWindow.onload = function() {
                                //     setTimeout(function() {
                                //         pdfWindow.print();
                                //     }, 1000);
                                // };
                                const iframe = document.getElementById("myIframe"); // Dapatkan elemen iframe menggunakan DOM
                                const kodeHTML = res.data;
                                iframe.srcdoc = kodeHTML; // Atur srcdoc dengan kode HTML yang diinginkan

                                // Mencetak isi iframe setelah konten dimuat sepenuhnya
                                iframe.onload = function() {
                                    iframe.contentWindow.print();
                                };
                                // cetakIframe()
                            }
                        });
                    }
                });

            }

        });

        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).html()).select();
            document.execCommand("copy");
            $temp.remove();
            alert('Teks berhasil di Copy');
        }

        function formatRupiah(angka, prefix) {
            if (angka > 999) {
                var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
            } else {
                return prefix + " " + angka;
            }

        }

        function isiIframe() {
            const iframe = document.getElementById("myIframe");
            const kodeHTML = "<h2>Kode HTML Disisipkan</h2><p>Ini adalah kode HTML yang disisipkan langsung dalam halaman utama.</p>";
            iframe.srcdoc = kodeHTML;
        }

        // Fungsi untuk mencetak iframe
        function cetakIframe() {
            const iframe = document.getElementById("myIframe");
            iframe.style.display = "block"; // Menampilkan iframe sementara
            iframe.contentWindow.print(); // Mencetak
            iframe.css("display", "none")
        }
    </script>
</body>

</html>