<?php

use App\Tools\tools;

?>
<table class="table ftc table-responsive-w-100 table-bordered" style="font-size: 14px;" id="dataCetak">
    <thead>
        <tr>
            <th>No</th>
            <th>Plat</th>
            <th>WA</th>
            <th>Transaksi</th>
            <th>Detail</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksi as $t)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$t->plat}}</td>
            <td>{{$t->wa}}</td>
            <td>{{$t->jumlahTransaksi}}x</td>
            <td>
                <a class="p-1  rounded bg-primary text-white max-content pointer d-inline " href="{{url('/laporan/plat/'.$t->plat)}}"  title="Detail"><i class="fa fa-list-alt" aria-hidden="true"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{!!$pagination!!}