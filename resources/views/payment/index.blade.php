@extends('layouts.clientmaster')

@section('css')
<link rel="stylesheet" type="text/css" href="https://sandbox.ipaymu.com/asset/css/payment.css">
@endsection
@section('title')
Pembayaran
@endsection
@section('content')
<div class="pace pace-inactive">
    <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
        <div class="pace-progress-inner"></div>
    </div>
    <div class="pace-activity"></div>
</div>
<div class="container">
    <div class="row mb-5">
        <div class="col-md-6 col-sm-12 col-12 d-block" style="padding: 30px 0 30px 10px;">
            <img src="https://sandbox.ipaymu.com/asset/images/logo-ipaymu.png" style="max-height: 65px;" alt="iPaymu Merchant">
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
                                Rp. 900.000
                            </span>
                        </h5>
                    </div>
                    <div id="cProduct" class="collapse show" data-parent="#product">
                        <div class="card-body" style="padding: 0;">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <h6>Processor Intel i-5 2400</h6>
                                    <small>1 x <sup>Rp. </sup> 900.000</small>
                                    <span style="float: right;"><sup>Rp. </sup> 900.000</span>
                                </li>
                                <li id="cFee" class="list-group-item text-muted" style="display:none;">
                                    <span id="fee-title"></span><br>
                                    <small id="fee-desc"></small>
                                    <span style="float: right;" id="fee-val"></span>
                                </li>
                                <li id="cDiscount" class="list-group-item text-muted" style="display:none;">
                                    <span id="discount-title" class="small"></span>
                                    <span style="float: right;" id="discount-val"></span>
                                </li>
                                <li id="cInsurance" class="list-group-item" style="display:none;">
                                    <span>Protection Fee</span>
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
                    <h3>Please Transfer</h3>
                </div>
            </div>
            <div class="accordion" id="accordion">
                <div class="card">
                    <div id="cBank" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body text-center">
                            <div class="text-center">
                                <img src="/asset/images/bri.png" style="max-width:120px; height:auto;" alt="iPaymu Payment Channel">
                                <hr>
                            </div>
                            <p>Please transfer to account below:</p>
                            <h2>Bank Rakyat Indonesia (002)</h2>
                            <h4 class="p-2 border-dashed mb-3 mt-3">
                                <span id="textcopyva">578893000183799</span>
                                <span class="ml-2 small text-muted" onclick="if (!window.__cfRLUnblockHandlers) return false; copyToClipboard('#textcopyva')" style="cursor:pointer;"><em class="fa fa-copy"></em></span>
                            </h4>
                            <h2>iPaymu rendi</h2>
                            <p class="mt-3 mb-1">Amount</p>
                            <h4>
                                Rp. 900.000
                                <span id="textcopy" style="display:none">900000</span>
                                <span class="ml-2 small text-muted" onclick="if (!window.__cfRLUnblockHandlers) return false; copyToClipboard('#textcopy')" style="cursor:pointer;"><em class="fa fa-copy"></em></span>
                            </h4>
                            <p class="mt-3 mb-1">Payment deadline</p>
                            <h2 id="expired_at">1h 51m 8s </h2>
                            <p class="mt-3 mb-1">Ref ID</p>
                            <h2>106245</h2>
                            <div class="alert alert-info mt-3 text-justify" role="alert" style="font-size:12px">
                                *Special information for customers who make payments through Bank BRI. "PT Bimasakti Multi Sinergi" will appear as Institution Name in your payment details. </div>
                            <div class="mt-4">
                                <a class="btn btn-primary btn-block" href="https://storage.googleapis.com/ipaymu-docs/cara-pembayaran/va-bri.pdf" target="_blank" rel="noopener">HOW TO PAY</a>
                                <a href="https://wa.me/6219230123?text=Anda+bertransaksi+di+%2Arendi%2A.+ID+Transaksi%3A+%2A106245%2A+%0A%0ASegera+lakukan+pembayaran+ke+Rekening+berikut%3A+%0ABank%3A+%2ABRI+%28002%29%2A+%0ANo+Virtual+Account%3A+%2A578893000183799%2A+%0AAtas+Nama%3A+%2AiPaymu+rendi%2A+%0AJml+Pembayaran%3A+%2ARp.+900.000%2A%0ABatas+pembayaran+sampai%3A+%2A16%2F08%2F2023+11%3A30%3A29+WIB%2A.%0ALink+informasi+transaksi%3A%0Ahttps%3A%2F%2Fsandbox.ipaymu.com%2Ftransactions%2Finfo%2F88973-106245%0A%0A%2APENTING%2A%3A%0A-+Lakukan+pembayaran+ke+%2ANO+PEMBAYARAN%2A+dan+%2ANOMINAL+YANG+SESUAI%2A.%0A-+%2ANO+PEMBAYARAN+HANYA+UNTUK+1+KALI+TRANSFER%2A%0A%0A%2ACari+income+baru+dengan+merekomendasikan+BALI+ke+social+media+Anda.%2A%0AKomisi+penjualan+langsung+tertransfer+otomatis%2C+mulai+disini%3A++https%3A%2F%2Fwww.hallobali.id" target="_blank" rel="noopener" class="btn btn-success btn-block text-white mt-2">
                                    <img src="https://sandbox.ipaymu.com/asset/images/whatsapp.png" style="width: 20px;margin-right: 5px;margin-top: -2px;" alt=""> <span style="font-size:14px;">SEND PAYMENT INFORMATION TO WHATSAPP</span>
                                </a>
                                <a href="http://localhost:8000/testreturn?return=true&amp;trx_id=106245&amp;status=pending&amp;tipe=nonmember&amp;via=va&amp;channel=bri&amp;va=578893000183799" class="btn btn-secondary btn-block text-white mt-2">
                                    BACK TO MERCHANT PAGE </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(document).ready(function() {

                    countDown();
                });
                // function redirectPage() {
                //     var counter = "";
                //     var span = document.getElementById("counts");
                //     span.innerHTML = "";

                //     setInterval(function() {
                //         counter--;
                //         if (counter > 0) {
                //             span.innerHTML = counter;
                //         } else if (counter == 0) {
                //             clearInterval(counter);
                //             window.location = "http://localhost:8000/testreturn?return=true&amp;trx_id=106245&amp;status=pending&amp;tipe=nonmember&amp;via=va&amp;channel=bri&amp;va=578893000183799";
                //         } else {
                //             clearInterval(counter);
                //         }
                //     }, 1000);
                // }
                function countDown() {
                    try {
                        setInterval(function() {
                            var countDownDate = new Date("2023-08-16 11:30:29").getTime();
                            // var countDownDate = new Date("2021-10-31 15:37:25").getTime();
                            // Get today's date and time
                            var now = new Date().getTime();
                            // Find the distance between now and the count down date
                            var distance = countDownDate - now;

                            // Time calculations for days, hours, minutes and seconds
                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));

                            var hours = Math.floor((distance % ((1000 * 60 * 60 * 24)) / (1000 * 60 * 60)) + (days * 24));

                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            if (hours < 0) {
                                hours = 0;
                            }

                            if (minutes < 0) {
                                minutes = 0;
                            }
                            if (seconds < 0) {
                                seconds = 0;
                            }
                            // Output the result in an element with id="demo"
                            document.getElementById("expired_at").innerHTML = parseInt(hours) + "h " +
                                parseInt(minutes) + "m " + parseInt(seconds) + "s ";

                            // If the count down is over, write some text
                            if (distance < 0) {
                                clearInterval(x);
                                document.getElementById("expired_at").innerHTML = "EXPIRED";
                            }
                        }, 1000);
                    } catch (err) {
                        // console.log(err)
                        document.getElementById("expired_at").innerHTML = "2023-08-16 11:30:29";
                    }
                }
            </script>
        </div>
    </div>
</div>
@endsection