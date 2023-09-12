<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            width: 60mm;
            height: 100mm;
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

        /* Gaya untuk header */
        .header {
            text-align: center;
            font-size: 16px;
            line-height: 1.5px;
            /* Ukuran font header */
        }

        .header p {
            font-size: 12px;
            margin-bottom: 20px;
            line-height: 12px;
        }

        /* Gaya untuk alamat */
        .address {
            margin-top: 20px;
            font-size: 12px;
            /* Ukuran font alamat */
        }

        /* Gaya untuk detail transaksi */
        .transaction-details {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 14px;
            /* Ukuran font detail transaksi */
        }

        /* Gaya untuk tabel item transaksi */
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
            font-size: 14px;
            /* Ukuran font untuk item transaksi */
        }

        /* Gaya untuk subtotal */
        .subtotal {
            margin-top: 10px;
            text-align: right;
            font-size: 14px;
            /* Ukuran font subtotal */
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            /* Ukuran font footer */
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
            <td>INV09123123</td>
        </tr>
        <tr>
            <td>No Plat:</td>
            <td> {{$tjual->plat}}</td>
        </tr>
    </table>

    <table class="item-table">
        <thead>
            <tr>
                <th>Layanan</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Steam Game A</td>
                <td>{{$tjual->totalbayar}}</td>
            </tr>
        </tbody>
    </table>
    <p class="subtotal"><strong>Total:</strong> {{$tjual->totalbayar}}</p>
    <table class="item-table">
        <thead>tjual
            <tr>
                <th>Info Lainya</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Phone:</strong> <br> 987-654-3210</p>
        <p><strong>Email :</strong> <br> customer@email.com</p>
    </div>

</body>

</html>