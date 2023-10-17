<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            width: 80mm;
            height: 120mm;
            margin: 0;
            padding: 10px;
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
            font-size: 16px;
            line-height: 1.5px;
        }

        .header p {
            font-size: 12px;
            margin-bottom: 20px;
            line-height: 12px;
        }

        .address {
            margin-top: 20px;
            font-size: 12px;
        }

        .transaction-details {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 12px;
        }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .item-table th,
        .item-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        .subtotal {
            margin-top: 10px;
            text-align: right;
            font-size: 14px;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            display: flex;
            justify-content: space-between;
        }

        .info-table {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Steam App</h2>
        <p>Alamat: Jl. Contoh No. 123, Kota Contoh</p>
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
                <td>{{$tjual->totalbayar}}</td>
            </tr>

        </tbody>
    </table>
    <p class="subtotal"><strong>Total:</strong> {{$tjual->totalbayar}}</p>
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
                <td>{{ date('d, M Y', strtotime($t1->created_at)) }}</td>
                <td>1x</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Phone:</strong> <br> 987-654-3210</p>
        <p><strong>Email :</strong> <br> customer@email.com</p>
    </div>

</body>

</html>