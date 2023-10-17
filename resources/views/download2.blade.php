<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <!-- <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'> -->
    <style>
        .page-break {
            page-break-after: always;
        }

        body {
            font-family: Arial, sans-serif;
            width: 100%;
            height: 100%;
            margin: 0;
            margin-left: -10px;
            padding: 10px;
        }

        .header {
            text-align: center;
            font-size: 16px;
            line-height: 1.5px;
        }

        p.c {
            font-size: 12px;
            margin-bottom: 20px;
            line-height: 12px;
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
        }

        .img {
            text-align: center;
        }

        .info-table {
            font-size: 12px;
            margin-top: 10px;
        }

        .img img {
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            padding: 0 20px;
            text-align: center;
            margin-left: -20px;
            margin-right: -20px;
            /* Mengatur teks ke tengah secara horizontal */
        }

        .footer::before,
        .footer::after {
            content: "";
            display: table;
        }

        .footer::after {
            clear: both;
            /* Membersihkan elemen setelah elemen .footer */
        }

        .footer-left {
            float: left;
            /* Mengatur elemen kiri ke kiri */
        }

        .footer-right {
            float: right;
            /* Mengatur elemen kanan ke kanan */
        }
    </style>
</head>

<body>
    <?php

    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use Illuminate\Support\Facades\Storage;

    $i = 0;
    $count = $tikets->count();

    ?>
    @foreach($tikets as $tiket)
    <?php $i++; ?>
    <div class="tiket @if($i != $count)page-break @endif">
        <div class="header ">
            <h2>Steam App</h2>
            <p class="c">Alamat: Jl. Contoh No. 123, Kota Palembang Sumatra Selatan</p>
        </div>
        <div class="img">
            <img class="center" src="data:image/png;base64,' . {{ base64_encode(QrCode::size(150)->generate($tiket->id)); }} . '" />
        </div>

        <p class="c" style="margin-bottom: 0px;">{{$tjual->np}}</p>

        <p class="c" style="margin-bottom: 3px;"> {{$tjual->plat}}</p>
        @if($tiket->status == 1)
        <p class="c" style="font-weight: 600; margin-top: 1px;"> (Terpakai)</p>
        @endif
        <div class="footer">
            <div class="footer">
                <div class="footer-left">
                    <p><strong>Phone:</strong> <br> 987-654-3210</p>
                </div>
                <div class="footer-right">
                    <p><strong>Email :</strong> <br> customer@email.com</p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</body>

</html>