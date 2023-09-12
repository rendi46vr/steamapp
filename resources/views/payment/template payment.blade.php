<!-- <!doctype html>
<html lang="id">

<head>
    <link rel="dns-prefetch" href="//sandbox.ipaymu.com">
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//code.jquery.com">
    <link rel="dns-prefetch" href="//www.google.com">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="9Swzw0946LE74oLOPsGRhnbX8Zc9GSsefvMYMwrB">
    <link rel="shortcut icon" href="/asset/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/asset/images/favicon.ico" type="image/x-icon">
    <title>rendi - iPaymu Payment Page</title>
    <meta name="description" content="iPaymu Payment Page - rendi">
    <meta name="keywords" content="iPaymu Payment Page, rendi" />
    <meta property="og:locale" content="id_ID" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="asdadasd | Rp. 50.000" />
    <meta property="og:description" content />
    <meta property="og:url" content="https://sandbox.ipaymu.com/payment/f70a9e56-809f-4b10-898c-83f1f129fb05" />
    <meta property="og:secure_url" content="https://sandbox.ipaymu.com/payment/f70a9e56-809f-4b10-898c-83f1f129fb05" />
    <meta property="og:site_name" content="rendi" />
    <meta property="og:image" content="https://sandbox.ipaymu.com/asset/images/logo-ipaymu.png" />
    <meta property="og:image:secure_url" content="https://sandbox.ipaymu.com/asset/images/logo-ipaymu.png" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://sandbox.ipaymu.com/asset/css/payment.css">
    <link rel="stylesheet" type="text/css" href="https://sandbox.ipaymu.com/asset/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous" type="d2351b055cc568ce84713f36-text/javascript"></script>
    <style>
        .dividen,
        .footer {
            background: !important;
        }

        .badge-primary {
            color: !important;
        }

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
    <script src="https://www.google.com/recaptcha/api.js" async defer type="d2351b055cc568ce84713f36-text/javascript"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger text-center">
                    <small>Mode Sandbox/Development. Mohon untuk tidak melakukan pembayaran pada mode ini.<br><a href="https://sandbox.ipaymu.com/send-notify" target="_blank" rel="noopener">Klik disini</a> untuk melakukan simulasi pembayaran.</small>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-6 col-sm-12 col-12 d-block" style="padding: 30px 0 30px 10px;">
                <img src="https://sandbox.ipaymu.com/asset/images/logo-ipaymu.png" style="max-height: 65px;" alt="iPaymu Merchant">
                <div class="d-block d-lg-none d-md-none mt-2 ml-1">
                    <h6 class>rendi</h6>
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
                                    Rp. 50.000
                                </span>
                            </h5>
                        </div>
                        <div id="cProduct" class="collapse show" data-parent="#product">
                            <div class="card-body" style="padding: 0;">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <h6>asdadasd</h6>
                                        <small>1 x <sup>Rp. </sup> 50.000</small>
                                        <span style="float: right;"><sup>Rp. </sup> 50.000</span>
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
                                        <span>Biaya Proteksi</span>
                                        <span style="float: right;" id="insurance-amount"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="box-voucher mt-3" style="margin-bottom:50px;">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" value="1" id="insuranceCheck" style="width:15px; height:15px;" onchange="if (!window.__cfRLUnblockHandlers) return false; insuranceActivate()" data-cf-modified-d2351b055cc568ce84713f36->
                                <label class="form-check-label ml-2">
                                    <h6 class="m-0 p-0">+ Rp. 2.500 (Coming Soon)</h6>
                                    <p class="text-justify p-0 m-0" style="font-size:14px;"><strong>Takut produk yang Anda beli tidak sampai?</strong> <em data-feather="info" style="padding-top:10px; cursor: pointer;" onclick="if (!window.__cfRLUnblockHandlers) return false; showModalInsuranceInfo()" data-cf-modified-d2351b055cc568ce84713f36-></em></p>
                                    <p class="text-justify m-0 p-0" style="fomt-size:12px;">Proses klaim mudah, berlaku 12 bulan.<br>*Sertifikat Asuransi akan dikirim ke email, pastikan Anda memasukkan email yang benar dan valid</p>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="padding-bottom:80px;">
                <div class="card" style="border-color:;">
                    <div class="card-header dividen">
                        <h3>Metode Pembayaran</h3>
                    </div>
                </div>
                <div class="accordion" id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingVa" data-toggle="collapse" data-target="#cVa">
                            <h5 class="mb-0">
                                Virtual Account (VA)
                            </h5>
                            <img src="/asset/images/bank.png" alt="iPaymu Payment Channel">
                        </div>
                        <div id="cVa" class="collapse" aria-labelledby="headingVa" data-parent="#accordion">
                            <div class="card-body">
                                <form method="POST" action="/payment/nonmember" enctype="multipart/form-data" id="form">
                                    <input type="hidden" name="_token" value="9Swzw0946LE74oLOPsGRhnbX8Zc9GSsefvMYMwrB">
                                    <input type="hidden" name="cart_id" value="f70a9e56-809f-4b10-898c-83f1f129fb05">
                                    <input type="hidden" name="voucher_val">
                                    <input type="hidden" name="insurance_status" value="0" class="insurance-input">
                                    <p>Anda dapat melakukan pembayaran ke Virtual Account melalui ATM, Mobile Banking atau Internet Banking.</p>
                                    <label>Pembayaran melalui: </label>
                                    <div class="row">
                                        <div class="col-md-4 col-6">
                                            <div class="form-check form-check-inline mb-3">
                                                <input id="artagraha" class="form-check-input" type="radio" name="type" value="5">
                                                <label for="artagraha" class="form-check-label"><img src="/asset/images/arthagraha.png" style="height: 28px;" alt="iPaymu Payment Channel"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-check form-check-inline mb-3">
                                                <input id="bcava" class="form-check-input" type="radio" name="type" value="6">
                                                <label for="bcava" class="form-check-label"><img src="/asset/images/bca.png" width="80px" alt="iPaymu Payment Channel"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-check form-check-inline mb-3">
                                                <input id="bni" class="form-check-input" type="radio" name="type" value="2">
                                                <label for="bni" class="form-check-label"><img src="/asset/images/bni.png" style="height: 24px;" alt="iPaymu Payment Channel"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-check form-check-inline mb-3">
                                                <input id="briva" class="form-check-input" type="radio" name="type" value="10" checked>
                                                <label for="briva" class="form-check-label"><img src="https://sandbox.ipaymu.com/asset/images/bri.png" alt="ipaymu-bank-bri" style="height: 27px; margin-top:-1px;"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-check form-check-inline mb-3">
                                                <input id="niaga" class="form-check-input" type="radio" name="type" value="1">
                                                <label for="niaga" class="form-check-label"><img src="/asset/images/niaga.png" style="width:100px; height:28px;" alt="iPaymu Payment Channel"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-check form-check-inline mb-3">
                                                <input id="mandiri" class="form-check-input" type="radio" name="type" value="3">
                                                <label for="mandiri" class="form-check-label"><img src="/asset/images/mandiri.png" style="height: 28px; margin-top:-5px;" alt="iPaymu Payment Channel"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-check form-check-inline mb-3">
                                                <input id="bmiva" class="form-check-input" type="radio" name="type" value="9" checked>
                                                <label for="bmiva" class="form-check-label"><img src="https://sandbox.ipaymu.com/asset/images/bmi.png" alt="ipaymu-bank-muamalat" style="height:26px;"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-check form-check-inline mb-3">
                                                <input id="bsi" class="form-check-input" type="radio" name="type" value="12">
                                                <label for="bsi" class="form-check-label"><img src="https://sandbox.ipaymu.com/asset/images/bsi.png" style="height:26px;" alt="iPaymu Payment Channel"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-check form-check-inline mb-3">
                                                <input id="permatava" class="form-check-input" type="radio" name="type" value="13">
                                                <label for="permatava" class="form-check-label"><img src="https://sandbox.ipaymu.com/asset/images/permata.png" alt="ipaymu-bank-permata" style="height:26px;"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-check form-check-inline mb-3">
                                                <input id="danamonva" class="form-check-input" type="radio" name="type" value="14">
                                                <label for="danamonva" class="form-check-label"><img src="https://sandbox.ipaymu.com/asset/images/danamon.png" alt="ipaymu-bank-danamon" style="height:26px;"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" name="name" autocomplete="off" class="form-control " value="testing" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">No. HP/Telepon</label>
                                        <input type="number" name="phone" autocomplete="off" class="form-control " value="08121238091231" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Email</label>
                                        <input type="email" name="email" autocomplete="off" class="form-control " value="rendi46vr@gmail.com" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="alert alert-info">
                                            <div class="tnc">
                                                <div style="font-size:12px;">
                                                    <ol class="text-justify pl-3 pr-3 pb-0 mb-0">
                                                        <li>Setiap Anda melakukan transaksi maka Anda melakukannya dengan resiko sendiri dan dengan mendaftar dan atau bertransaksi dengan website/penjual/merchant yang telah terintegrasi dengan layanan iPaymu.com.</li>
                                                        <li>Anda setuju secara PENUH untuk melepaskan iPaymu beserta seluruh afiliasi, pejabat, karyawan dan pemilik atas kerugian APAPUN yang mungkin timbul dikarenakan bertransaksi pada website atau bisnis tersebut di atas.</li>
                                                        <li>Anda bersedia untuk mengganti kerugian kami dan setuju tidak akan mengatasnamakan iPaymu atau mewakili Anda dalam setiap tindakan, dalam kapasitas apapun terhadap setiap jenis website atau bisnis tersebut.</li>
                                                        <li>Jika Anda terlibat perselisihan dengan salah satu jenis usaha tersebut Anda setuju bahwa ini HANYA antara ANDA dengan BISNIS TERSEBUT</li>
                                                        <li>Dengan bertransaksi melalui iPaymu, Anda setuju sepenuhnya dan bersedia untuk semua syarat dan ketentuan ini.</li>
                                                        <li>Anda bersedia menggunakan email untuk mendaftar akun iPaymu.</li>
                                                    </ol>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" name="check_register_ipaymu" type="checkbox" value="1" id="checkVa" required>
                                                    <label class="text-justfy" for="checkVa" style="display: inline; vertical-align:text-top;">Saya setuju dengan syarat & ketentuan diatas</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p><span>*Setor tunai sangat TIDAK DISARANKAN</span></p>
                                    <button type="submit" class="btn btn-success btn-block">BAYAR SEKARANG</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo" data-toggle="collapse" data-target="#cQris">
                            <h5 class="mb-0">
                                QRIS </h5>
                            <img src="https://sandbox.ipaymu.com/asset/images/qris_default.png" style="height:28px;" alt="ipaymu qris, bayar dengan ovo dana grab bca, bayar dengan qr, bayar dengan qris">
                        </div>
                        <div id="cQris" class="collapse " aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                <form method="POST" action="https://sandbox.ipaymu.com/payment/qris" enctype="multipart/form-data" id="qris">
                                    <input type="hidden" name="_token" value="9Swzw0946LE74oLOPsGRhnbX8Zc9GSsefvMYMwrB">
                                    <input type="hidden" name="cart_id" value="f70a9e56-809f-4b10-898c-83f1f129fb05">
                                    <input type="hidden" name="type" value="2">
                                    <input type="hidden" name="voucher_val">
                                    <input type="hidden" name="insurance_status" value="0" class="insurance-input">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" name="name" value="testing" autocomplete="off" class="form-control " required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">No. HP/Telepon</label>
                                        <input type="number" name="phone" autocomplete="off" class="form-control " value="08121238091231" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Email</label>
                                        <input type="email" name="email" autocomplete="off" class="form-control " value="rendi46vr@gmail.com" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="alert alert-info">
                                            <div class="tnc">
                                                <div style="font-size:12px;">
                                                    <ol class="text-justify pl-3 pr-3 pb-0 mb-0">
                                                        <li>Setiap Anda melakukan transaksi maka Anda melakukannya dengan resiko sendiri dan dengan mendaftar dan atau bertransaksi dengan website/penjual/merchant yang telah terintegrasi dengan layanan iPaymu.com.</li>
                                                        <li>Anda setuju secara PENUH untuk melepaskan iPaymu beserta seluruh afiliasi, pejabat, karyawan dan pemilik atas kerugian APAPUN yang mungkin timbul dikarenakan bertransaksi pada website atau bisnis tersebut di atas.</li>
                                                        <li>Anda bersedia untuk mengganti kerugian kami dan setuju tidak akan mengatasnamakan iPaymu atau mewakili Anda dalam setiap tindakan, dalam kapasitas apapun terhadap setiap jenis website atau bisnis tersebut.</li>
                                                        <li>Jika Anda terlibat perselisihan dengan salah satu jenis usaha tersebut Anda setuju bahwa ini HANYA antara ANDA dengan BISNIS TERSEBUT</li>
                                                        <li>Dengan bertransaksi melalui iPaymu, Anda setuju sepenuhnya dan bersedia untuk semua syarat dan ketentuan ini.</li>
                                                        <li>Anda bersedia menggunakan email untuk mendaftar akun iPaymu.</li>
                                                    </ol>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" name="check_register_ipaymu" type="checkbox" value="1" id="checkQris" required>
                                                    <label class="text-justfy" for="checkQris" style="display: inline; vertical-align:text-top;">Saya setuju dengan syarat & ketentuan diatas</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block">BAYAR SEKARANG</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#cDebitOnline">
                            <h5 class="mb-0">
                                Debit Online GPN </h5>
                            <img src="https://sandbox.ipaymu.com/asset/images/gpn.png" style="max-width:25px; height:auto;" alt="debit online via iPaymu">
                        </div>
                        <div id="cDebitOnline" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <form method="POST" action="/payment/debitonline" enctype="multipart/form-data" id="form">
                                    <input type="hidden" name="_token" value="9Swzw0946LE74oLOPsGRhnbX8Zc9GSsefvMYMwrB">
                                    <input type="hidden" name="cart_id" value="f70a9e56-809f-4b10-898c-83f1f129fb05">
                                    <input type="hidden" name="voucher_val">
                                    <input type="hidden" name="insurance_status" value="0" class="insurance-input">
                                    <p class="p-0 mb-0">Anda dapat melakukan pembayaran dengan kartu Debit Anda.</p>
                                    <div class="text-left mb-3">
                                        <img src="https://sandbox.ipaymu.com/asset/images/bni.png" style="height:28px;" alt="debit online via iPaymu">
                                        <img src="https://sandbox.ipaymu.com/asset/images/btn.png" style="height:30px;" class="mt-2" alt="debit online via iPaymu">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" name="name" autocomplete="off" class="form-control " value="testing" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">No. HP/Telepon</label>
                                        <input type="number" name="phone" autocomplete="off" class="form-control " value="08121238091231" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Email</label>
                                        <input type="email" name="email" autocomplete="off" class="form-control " value="rendi46vr@gmail.com" required>
                                    </div>
                                    <p><span>*Anda akan di arahkan ke halaman pembayaran khusus Debit Online</span></p>
                                    <div class="form-group">
                                        <div class="alert alert-info">
                                            <div class="tnc">
                                                <div style="font-size:12px;">
                                                    <ol class="text-justify pl-3 pr-3 pb-0 mb-0">
                                                        <li>Setiap Anda melakukan transaksi maka Anda melakukannya dengan resiko sendiri dan dengan mendaftar dan atau bertransaksi dengan website/penjual/merchant yang telah terintegrasi dengan layanan iPaymu.com.</li>
                                                        <li>Anda setuju secara PENUH untuk melepaskan iPaymu beserta seluruh afiliasi, pejabat, karyawan dan pemilik atas kerugian APAPUN yang mungkin timbul dikarenakan bertransaksi pada website atau bisnis tersebut di atas.</li>
                                                        <li>Anda bersedia untuk mengganti kerugian kami dan setuju tidak akan mengatasnamakan iPaymu atau mewakili Anda dalam setiap tindakan, dalam kapasitas apapun terhadap setiap jenis website atau bisnis tersebut.</li>
                                                        <li>Jika Anda terlibat perselisihan dengan salah satu jenis usaha tersebut Anda setuju bahwa ini HANYA antara ANDA dengan BISNIS TERSEBUT</li>
                                                        <li>Dengan bertransaksi melalui iPaymu, Anda setuju sepenuhnya dan bersedia untuk semua syarat dan ketentuan ini.</li>
                                                        <li>Anda bersedia menggunakan email untuk mendaftar akun iPaymu.</li>
                                                    </ol>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" name="check_register_ipaymu" type="checkbox" value="1" id="checkDo" required>
                                                    <label class="text-justfy" for="checkDo" style="display: inline; vertical-align:text-top;">Saya setuju dengan syarat & ketentuan diatas</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block">BAYAR SEKARANG</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#cDirectDebit">
                            <h5 class="mb-0">
                                Direct Debit (Coming Soon)
                            </h5>
                        </div>
                        <div id="cDirectDebit" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <form method="POST" action="https://sandbox.ipaymu.com/payment/ac-direct-debit" enctype="multipart/form-data" id="form">
                                    <input type="hidden" name="_token" value="9Swzw0946LE74oLOPsGRhnbX8Zc9GSsefvMYMwrB">
                                    <input type="hidden" name="cart_id" value="f70a9e56-809f-4b10-898c-83f1f129fb05">
                                    <input type="hidden" name="voucher_val">
                                    <input type="hidden" name="insurance_status" value="0" class="insurance-input">
                                    <p class="p-0 mb-0">Anda dapat melakukan pembayaran dengan kartu Debit Anda.</p>
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" name="name" autocomplete="off" class="form-control " value="testing" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">No. HP/Telepon</label>
                                        <input type="number" name="phone" autocomplete="off" class="form-control " value="08121238091231" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Email</label>
                                        <input type="email" name="email" autocomplete="off" class="form-control " value="rendi46vr@gmail.com" required>
                                    </div>
                                    <p><span>*Anda akan di arahkan ke halaman pembayaran khusus Debit Online</span></p>
                                    <div class="form-group">
                                        <div class="alert alert-info">
                                            <div class="tnc">
                                                <div style="font-size:12px;">
                                                    <ol class="text-justify pl-3 pr-3 pb-0 mb-0">
                                                        <li>Setiap Anda melakukan transaksi maka Anda melakukannya dengan resiko sendiri dan dengan mendaftar dan atau bertransaksi dengan website/penjual/merchant yang telah terintegrasi dengan layanan iPaymu.com.</li>
                                                        <li>Anda setuju secara PENUH untuk melepaskan iPaymu beserta seluruh afiliasi, pejabat, karyawan dan pemilik atas kerugian APAPUN yang mungkin timbul dikarenakan bertransaksi pada website atau bisnis tersebut di atas.</li>
                                                        <li>Anda bersedia untuk mengganti kerugian kami dan setuju tidak akan mengatasnamakan iPaymu atau mewakili Anda dalam setiap tindakan, dalam kapasitas apapun terhadap setiap jenis website atau bisnis tersebut.</li>
                                                        <li>Jika Anda terlibat perselisihan dengan salah satu jenis usaha tersebut Anda setuju bahwa ini HANYA antara ANDA dengan BISNIS TERSEBUT</li>
                                                        <li>Dengan bertransaksi melalui iPaymu, Anda setuju sepenuhnya dan bersedia untuk semua syarat dan ketentuan ini.</li>
                                                        <li>Anda bersedia menggunakan email untuk mendaftar akun iPaymu.</li>
                                                    </ol>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" name="check_register_ipaymu" type="checkbox" value="1" id="checkDo" required>
                                                    <label class="text-justfy" for="checkDo" style="display: inline; vertical-align:text-top;">Saya setuju dengan syarat & ketentuan diatas</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block">BAYAR SEKARANG</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#cStore">
                            <h5 class="mb-0">
                                Convenience Store </h5>
                            <img src="/asset/images/cstore.png" alt="indomaret payment via iPaymu">
                        </div>
                        <div id="cStore" class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <form method="POST" action="https://sandbox.ipaymu.com/payment/cstore" enctype="multipart/form-data" id="cstore">
                                    <input type="hidden" name="_token" value="9Swzw0946LE74oLOPsGRhnbX8Zc9GSsefvMYMwrB">
                                    <input type="hidden" name="cart_id" value="f70a9e56-809f-4b10-898c-83f1f129fb05">
                                    <input type="hidden" name="voucher_val">
                                    <input type="hidden" name="insurance_status" value="0" class="insurance-input">
                                    <p>Anda dapat melakukan pembayaran Alfamart atau Indomaret terdekat di kota Anda.</p>
                                    <div class="form-group mb-4">
                                        <label>Pembayaran melalui</label>
                                        <div class="form-check form-check-inline">
                                            <input id="alfamart" class="form-check-input" type="radio" name="channel" value="ALFAMART" checked>
                                            <label for="alfamart" class="form-check-label"><img src="/asset/images/alfamart.png" width="80px" alt="Alfamart via iPaymu"></label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input id="indomaret" class="form-check-input" type="radio" name="channel" value="INDOMARET">
                                            <label for="indomaret" class="form-check-label"><img src="/asset/images/indomaret.png" width="80px" alt="Indomaret via iPaymu"></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" name="name" value="testing" autocomplete="off" class="form-control " required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">No. HP/Telepon</label>
                                        <input type="number" name="phone" autocomplete="off" class="form-control " value="08121238091231" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Email</label>
                                        <input type="email" name="email" autocomplete="off" class="form-control " value="rendi46vr@gmail.com" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="alert alert-info">
                                            <div class="tnc">
                                                <div style="font-size:12px;">
                                                    <ol class="text-justify pl-3 pr-3 pb-0 mb-0">
                                                        <li>Setiap Anda melakukan transaksi maka Anda melakukannya dengan resiko sendiri dan dengan mendaftar dan atau bertransaksi dengan website/penjual/merchant yang telah terintegrasi dengan layanan iPaymu.com.</li>
                                                        <li>Anda setuju secara PENUH untuk melepaskan iPaymu beserta seluruh afiliasi, pejabat, karyawan dan pemilik atas kerugian APAPUN yang mungkin timbul dikarenakan bertransaksi pada website atau bisnis tersebut di atas.</li>
                                                        <li>Anda bersedia untuk mengganti kerugian kami dan setuju tidak akan mengatasnamakan iPaymu atau mewakili Anda dalam setiap tindakan, dalam kapasitas apapun terhadap setiap jenis website atau bisnis tersebut.</li>
                                                        <li>Jika Anda terlibat perselisihan dengan salah satu jenis usaha tersebut Anda setuju bahwa ini HANYA antara ANDA dengan BISNIS TERSEBUT</li>
                                                        <li>Dengan bertransaksi melalui iPaymu, Anda setuju sepenuhnya dan bersedia untuk semua syarat dan ketentuan ini.</li>
                                                        <li>Anda bersedia menggunakan email untuk mendaftar akun iPaymu.</li>
                                                    </ol>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" name="check_register_ipaymu" type="checkbox" value="1" id="checkCstore" required>
                                                    <label class="text-justfy" for="checkCstore" style="display: inline; vertical-align:text-top;">Saya setuju dengan syarat & ketentuan diatas</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block">BAYAR SEKARANG</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo" data-toggle="collapse" data-target="#cAkuLaku">
                            <h5 class="mb-0">
                                Cicilan </h5>
                            <img src="/asset/images/akulaku.png" alt="Akulaku on iPaymu">
                        </div>
                        <div id="cAkuLaku" class="collapse " aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                <form method="POST" action="https://sandbox.ipaymu.com/payment/akulaku" enctype="multipart/form-data" id="cstore">
                                    <input type="hidden" name="_token" value="9Swzw0946LE74oLOPsGRhnbX8Zc9GSsefvMYMwrB">
                                    <input type="hidden" name="voucher_val">
                                    <input type="hidden" name="cart_id" value="f70a9e56-809f-4b10-898c-83f1f129fb05">
                                    <input type="hidden" name="insurance_status" value="0" class="insurance-input">
                                    <p>Anda dapat melakukan pembayaran dengan Akulaku Pay<br><br><span>*Anda akan di arahkan ke halaman pembayaran khusus Akulaku Pay</span></p>
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" name="name" value="testing" autocomplete="off" class="form-control " required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">No. HP/Telepon</label>
                                        <input type="number" name="phone" autocomplete="off" class="form-control " value="08121238091231" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Email (opsional)</label>
                                        <input type="email" name="email" autocomplete="off" class="form-control " value="rendi46vr@gmail.com">
                                    </div>
                                    <div class="form-group">
                                        <div class="alert alert-info">
                                            <div class="tnc">
                                                <div style="font-size:12px;">
                                                    <ol class="text-justify pl-3 pr-3 pb-0 mb-0">
                                                        <li>Setiap Anda melakukan transaksi maka Anda melakukannya dengan resiko sendiri dan dengan mendaftar dan atau bertransaksi dengan website/penjual/merchant yang telah terintegrasi dengan layanan iPaymu.com.</li>
                                                        <li>Anda setuju secara PENUH untuk melepaskan iPaymu beserta seluruh afiliasi, pejabat, karyawan dan pemilik atas kerugian APAPUN yang mungkin timbul dikarenakan bertransaksi pada website atau bisnis tersebut di atas.</li>
                                                        <li>Anda bersedia untuk mengganti kerugian kami dan setuju tidak akan mengatasnamakan iPaymu atau mewakili Anda dalam setiap tindakan, dalam kapasitas apapun terhadap setiap jenis website atau bisnis tersebut.</li>
                                                        <li>Jika Anda terlibat perselisihan dengan salah satu jenis usaha tersebut Anda setuju bahwa ini HANYA antara ANDA dengan BISNIS TERSEBUT</li>
                                                        <li>Dengan bertransaksi melalui iPaymu, Anda setuju sepenuhnya dan bersedia untuk semua syarat dan ketentuan ini.</li>
                                                        <li>Anda bersedia menggunakan email untuk mendaftar akun iPaymu.</li>
                                                    </ol>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" name="check_register_ipaymu" type="checkbox" value="1" id="checkAkulaku" required>
                                                    <label class="text-justfy" for="checkAkulaku" style="display: inline; vertical-align:text-top;">Saya setuju dengan syarat & ketentuan diatas</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block">BAYAR SEKARANG</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-header dividen">
                        <h3>Metode Pembayaran Cross Border</h3>
                    </div>
                </div>
                <div class="accordion" id="accordion2">
                    <div class="card">
                        <div class="card-header" id="headingTwo" data-toggle="collapse" data-target="#cCreditCardCrossBorder">
                            <h5 class="mb-0">
                                Kartu Kredit </h5>
                            <img src="/asset/images/logo_cc.png" alt="credit card payment with iPaymu">
                        </div>
                        <div id="cCreditCardCrossBorder" class="collapse " aria-labelledby="headingTwo" data-parent="#accordion2">
                            <div class="card-body">
                                <form method="POST" action="/payment/creditcard" enctype="multipart/form-data" id="form-cc">
                                    <input type="hidden" name="_token" value="9Swzw0946LE74oLOPsGRhnbX8Zc9GSsefvMYMwrB">
                                    <p>Anda dapat melakukan pembayaran dengan kartu kredit berlogo VISA dan MASTER CARD.<br><br><span>*Anda akan di arahkan ke halaman pembayaran khusus Kartu Kredit</span></p>
                                    <input type="hidden" name="cart_id" value="f70a9e56-809f-4b10-898c-83f1f129fb05">
                                    <input type="hidden" name="insurance_status" value="0" class="insurance-input">
                                    <input type="hidden" name="voucher_val">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" name="name" value="testing" autocomplete="off" class="form-control " required>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">No. HP/Telepon</label>
                                        <input type="number" name="phone" autocomplete="off" class="form-control " value="08121238091231" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" autocomplete="off" class="form-control " value="rendi46vr@gmail.com">
                                    </div>
                                    <div class="form-group">
                                        <div class="alert alert-info">
                                            <div class="tnc">
                                                <div style="font-size:12px;">
                                                    <ol class="text-justify pl-3 pr-3 pb-0 mb-0">
                                                        <li>Setiap Anda melakukan transaksi maka Anda melakukannya dengan resiko sendiri dan dengan mendaftar dan atau bertransaksi dengan website/penjual/merchant yang telah terintegrasi dengan layanan iPaymu.com.</li>
                                                        <li>Anda setuju secara PENUH untuk melepaskan iPaymu beserta seluruh afiliasi, pejabat, karyawan dan pemilik atas kerugian APAPUN yang mungkin timbul dikarenakan bertransaksi pada website atau bisnis tersebut di atas.</li>
                                                        <li>Anda bersedia untuk mengganti kerugian kami dan setuju tidak akan mengatasnamakan iPaymu atau mewakili Anda dalam setiap tindakan, dalam kapasitas apapun terhadap setiap jenis website atau bisnis tersebut.</li>
                                                        <li>Jika Anda terlibat perselisihan dengan salah satu jenis usaha tersebut Anda setuju bahwa ini HANYA antara ANDA dengan BISNIS TERSEBUT</li>
                                                        <li>Dengan bertransaksi melalui iPaymu, Anda setuju sepenuhnya dan bersedia untuk semua syarat dan ketentuan ini.</li>
                                                        <li>Anda bersedia menggunakan email untuk mendaftar akun iPaymu.</li>
                                                    </ol>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" name="check_register_ipaymu" type="checkbox" value="1" id="checkCc" required>
                                                    <label class="text-justfy" for="checkCc" style="display: inline; vertical-align:text-top;">Saya setuju dengan syarat & ketentuan diatas</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block">BAYAR SEKARANG</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="cAlert" class="mt-2 box-voucher">
                    <div style="font-size:10px;" class="mb-3 text-justify">
                        <span class="text-danger">* </span>Lakukan transaksi tanpa ragu, pilih jenis pembayaran yang Anda inginkan. Demi keamanan transaksi, Anda dapat mengubah transaksi ini menjadi Transaksi Escrow dengan cara klik tombol "Transaksi Escrow" pada email konfirmasi pembayaran.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="container">
            <div class="row-logo">
                <img src="/asset/images/logo-white.png" class="footer-logo" alt="iPaymu Logo White">
                <p class="footer-copyright d-lg-inline-block d-md-inline-block d-none">©<script type="d2351b055cc568ce84713f36-text/javascript">
                        document.write(new Date().getFullYear())
                    </script> iPaymu.com - PT. Inti Prima Mandiri Utama</p>
                <p class="footer-copyright d-lg-none d-md-none d-sm-none d-inline-block" style="font-size:12px;">©<script type="d2351b055cc568ce84713f36-text/javascript">
                        document.write(new Date().getFullYear())
                    </script> iPaymu.com</p>
            </div>
            <div class="language float-right">
                <a href="/payment/id/f70a9e56-809f-4b10-898c-83f1f129fb05">Indonesia</a> | <a href="/payment/en/f70a9e56-809f-4b10-898c-83f1f129fb05">English</a>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalVoucher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Viralmu Voucher</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="voucherError" style="display: none;" class="alert alert-danger small mb-2">
                        <span id="voucherErrorText"></span>
                    </div>
                    <div class="form-group box-voucher mt-2">
                        <input type="text" name="voucher_code" autocomplete="off" class="form-control  input-sm" value style="text-align:center; font-size:16px;" placeholder="Masukan Kode Voucher" autofocus>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-success btn-flat btn-block" onclick="if (!window.__cfRLUnblockHandlers) return false; voucherCheck()" id="btnVoucherCheck" data-cf-modified-d2351b055cc568ce84713f36->Gunakan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalInsuranceInfo" tabindex="-1" role="dialog" aria-labelledby="insuranceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="margin-top: 0; margin-bottom: 0; height: 100vh; display: flex; flex-direction: column; justify-content: center;">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="insuranceModalLabel">Informasi Asuransi <em data-feather="info" style="padding-top:10px;"></em></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Keuntungan menggunakan Asuransi:</p>
                    <ol class="m-0 text-justify pl-4 pr-3 pt-0" style="font-size:14px;">
                        <li>Transaksi akan diasuransikan senilai transaksi Anda
                            <br>(Maksimal nilai transaksi yang bisa diasuransikan adalah Rp.10.000.000)
                        </li>
                        <li>Proses klaim transaksi mudah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

</body>

</html> -->