<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Steam App</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="{{url('')}}/css/bootstrap.min.css"  crossorigin="anonymous">
    <link rel="stylesheet" href="{{url('css/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"  crossorigin="anonymous"></script>
    <script src="{{url('')}}/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{url('css/style.css')}}">
    <script src="{{url('/js/sweetalert.js')}}"></script>
    @yield('scripts')
    <style>
        .discount-info {
            position: absolute;
            right: 10px;
            padding: 0 3vw;
        }

        .discount-percent {
            font-size: 1.3vw;
            /* Menggunakan unit vw untuk responsif dengan lebar layar */
            font-weight: bold;
            color: #FF6A6A;
        }

        table {
            width: fit-content !important;
            ;
        }

        .discount-text {
            font-size: 1vw;
            /* Menggunakan unit vw untuk responsif dengan lebar layar */
            margin-left: 8px;
        }

        .discount-details {
            margin-top: 10px;
            text-align: center;
        }

        .discount-minimum {
            font-size: 14px;
            color: #333;
        }

        .discount-quantity {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        @media (max-width: 768px) {
            .discount-info {
                margin-top: -10px;
            }

            .discount-percent {
                font-size: 3vw;
            }

            .discount-text {
                font-size: 2vw;
            }

            .discount-minimum {
                font-size: 4vw;
            }

            .discount-quantity {
                font-size: 7vw;
            }
        }
    </style>
</head>

<body>
    <div class="background-radial">

        <div class=" pr-0">
            <div class="col-12" id="grad1"></div>
            <div class="col-12" id="grad2"></div>
            <div class="col-12" id="grad3"></div>
            <div class="col-12" id="grad4"></div>
        </div>
    </div>
    <nav class="navbar navbar-expand-md navbar-light" style="background-color: #ADD8E6;color:#fff;font-weight:600">
        @if(!Session()->has("navbarhide"))
        <div class="steam-app-title">
            <img src="{{url('logo.png')}}" alt="">
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav ml-auto">
            @if(!auth()->check() || auth()->user()->role != "Patner")
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ url('/') }}">Home</a>
                </li>
            @endif
                @if(auth()->user())
                    @if(auth()->user()->role != "Patner")
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle " style="color: #000;" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Master
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{url('layanan')}}">Layanan Utama</a>
                                <a class="dropdown-item" href="{{url('layanantambahan')}}">Layanan Tambahan</a>
                                <a class="dropdown-item" href="{{url('platgratis')}}">Daftar PLAT Gratis</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Tampil
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{url('torder')}}">Tampil Order</a>
                                <a class="dropdown-item" href="{{url('transaksi')}}">Tampil Transaksi</a>
                                <a class="dropdown-item" href="{{url('tgagal')}}">Transaski Gagal</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Laporan
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @if(auth()->user()->role == "Admin")
                                <a class="dropdown-item" href="{{url('/laporan')}}">Laporan Total</a>
                            @endif
                                <a class="dropdown-item" href="{{url('laporan/plat')}}">Laporan per Kendaraan</a>
                            </div>
                        </li>
                         <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               Partnership
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{url('patner')}}">Data Partnership</a>
                                <a class="dropdown-item" href="{{url('pembayaran/request')}}"> Request Pembayaran Partner</a>
                                <a class="dropdown-item" href="{{url('pembayaran')}}">Pembayaran Partnership</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Setting
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{url('dashboard')}}">Pengguna</a>
                                <a class="dropdown-item" href="{{url('seeting/wa')}}">Koneksi Whatsapp</a>
                            </div>
                        </li>
                        
                    @else
                    <!-- patner menu -->
                       <li class="nav-item">
                            <a class="nav-link text-dark" href="{{url('patnerorder')}}">Order</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Pembayaran & Hutang
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{url('pembayaran/request')}}">Request Pembayaran</a>
                                <a class="dropdown-item" href="{{url('pembayaran')}}">Riwayat Pembayaran Berhasil</a>
                                <a class="dropdown-item" href="{{url('rinciantransaksi')}}">Rincian Transaksi & hutang</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Tampil
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                                <a class="dropdown-item" href="{{url('patnertransaksi')}}">Tampil Transaksi</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Setting
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown3">
                                <a class="dropdown-item" href="{{url('mydashboard')}}">Profile & Password</a>
                            </div>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{url('logout')}}">Logout <i class="fa fa-sign-out" aria-hidden="true"></i></a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-light" href="{{url('/login')}}">Login</a>
                    </li>
                @endif
            </ul>
        </div>
        @endif
    </nav>




    <div class="content">

        @yield('content')
    </div>

    @if(!Request::is('publiccek'))
    <!-- <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> Hak cipta, Sekolah Maitreyawira Palembang.</p>
        </div>
    </footer> -->
    @endif

    <a href="{{url('navhide')}}" id="hidenav">
        @if(!Session()->has("navbarhide"))
        <i class="fa fa-eye-slash" aria-hidden="true"></i>
        @else
        <i class="fa fa-eye" aria-hidden="true"></i>
        @endif
    </a>
    <script src="{{url('')}}/js/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="{{url('')}}/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
    <script src="{{url('js/app.js')}}"></script>
    @yield('script')

</body>

</html> 