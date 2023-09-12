<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <!-- <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'> -->
    <link rel="stylesheet" href="{{
                public_path('font-awesome-4.7.0/css/font-awesome.min.css')
            }}" />
    <style>
        .page-break {
            page-break-after: always;
        }

        a body {
            font-size: 6mm;
            font-weight: 400;
            line-height: 10mm;
        }

        .content {
            margin-top: 4mm;
        }

        table {
            margin-top: 4mm;
        }

        h2 {
            text-align: center;
        }

        .title {
            font-size: 10mm;
            font-weight: bold;
            text-align: center;
            color: coral;
        }

        .main {
            margin: 4mm;
        }


        .layanan {
            width: 100%;
            border-collapse: collapse;
            margin: auto;
            font-family: Arial, sans-serif;
        }

        .layanan th,
        .layanan td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: center;
        }

        .layanan th {
            background-color: #f2f2f2;
            /* font-weight: bold; */
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="top">
            <div class="title"><b>SteamApp</b></div>
        </div>
        <table class="user">
            <tr>
                <td>Nama </td>
                <td>: </td>
                <td>{{$tjual->name}}</td>
                <td></td>
                <td>Tanggal :</td>
            </tr>
            <tr>
                <td>Email </td>
                <td>: </td>
                <td>{{$tjual->email}}</td>
            </tr>
            <tr>
                <td>No Whatsapp </td>
                <td>: </td>
                <td>{{$tjual->wa}}</td>
            </tr>
        </table>
        <div class="main">
            <table class="layanan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Layanan</th>
                        <th>Type</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Paket A</td>
                        <td>Basic</td>
                        <td>Rp 100.000</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Paket B</td>
                        <td>Premium</td>
                        <td>Rp 200.000</td>
                    </tr>
                    <!-- Tambahkan baris-baris data lainnya sesuai kebutuhan -->
                </tbody>

            </table>
        </div>



    </div>

</body>

</html>