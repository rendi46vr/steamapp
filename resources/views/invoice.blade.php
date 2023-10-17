<?php

use App\Tools\tools;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            width: 55mm;
            height: 120mm;
            margin: 0;
            padding: 0px;
        }

        @media print {
            body {
                margin: 0 !important;
                padding: 0 !important;
            }
        }

        body::before {
            content: "";
            display: none;
        }

        body::after {
            content: "";
            display: none;
        }

        .header {
            text-align: center;
            font-size: 14px;
            line-height: 1.5px;
        }

        .header img {
            height: 20px;
            width: auto;
            text-align: center;
        }

        .header p {
            font-size: 10px;
            margin-bottom: 20px;
            line-height: 10px;
        }

        .address {
            margin-top: 20px;
            font-size: 10px;
        }

        .transaction-details {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 10px;
        }

        .item-table {
            width: 98%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .item-table th,
        .item-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }

        .subtotal {
            margin-top: 10px;
            text-align: right;
            font-size: 12px;
        }

        .footer {
            margin-top: 20px;
            font-size: 10px;
            display: flex;
            justify-content: space-between;
        }

        .info-table {
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{url('logo.png')}}" alt="">
        <p>Alamat: Jl. Angkatan 45, Lorok Pakjo, Kec. Ilir Bar. I, Kota Palembang, Sumatera Selatan 30137</p>
    </div>

    <table class="info-table">
        <tr>
            <td>No Invoice: </td>
            <td>{{$tjual->np}}</td>
        </tr>
        <tr>
            <td>No Plat:</td>
            <td> {{$tjual->plat}}</td>
        </tr>
    </table>
    <table class="info-table">
        <tr>
            <td>Sisa Saldo Cuci:</td>
            <td> {{$tjual->qty - $tjual->qtyterpakai}}x Cuci</td>
        </tr>
    </table>
    <table class="item-table">
        <thead>
            <tr>
                <th>Layanan</th>
                <th>Qty</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$tjual->layanan->layanan}}</td>
                <td>{{$tjual->qty}}x Cuci</td>
                <td>{{ tools::rupiah($tjual->dataorder->harga - $tjual->dataorder->diskon, false)}}</td>
            </tr>
            @foreach($addon as $ao)
            <tr>
                <td>{{$ao->layanantambahan->layanan}}</td>
                <td>-</td>
                <td>{{ tools::rupiah($ao->harga - $ao->diskon, false)}}</td>
            </tr>
            @endforeach

        </tbody>
    </table>
    <p class="subtotal"><strong>Total:</strong> {{tools::rupiah($tjual->totalbayar)}}</p>
    <table class="item-table">
        <thead>
            <tr>
                <th>Tanggal Pemakaian</th>
                <th> Cuci</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tjual1 as $t1)
            <tr>
                <td>{{ date('d, M Y', strtotime($t1->updated_at)) }}</td>
                <td>1x</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Phone:</strong> <br> {{$tjual->wa}}</p>
        <p><strong>Email :</strong> <br> {{$tjual->email}}</p>
    </div>

</body>

</html>