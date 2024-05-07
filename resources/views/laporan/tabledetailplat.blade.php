<?php

use App\Tools\tools;

?>
<table class="table ftc table-responsive-w-100 table-bordered" style="font-size: 14px;" id="dataCetak">
    <thead>
        <tr>
            <th>No</th>
            <th>Plat</th>
            <th>Waktu Order</th>
            <th>Jumlah</th>
            <th>Info order</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksi as $t)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$t->plat}}</td>
            <td>{{$t->created_at}}</td>
            <td>{{tools::frupiah($t->totalbayar)}}</td>
            <td>
                <div class="p-1 detail rounded bg-primary text-white max-content pointer d-inline " data-add="detail/{{$t->id}}" data-plat="{{$t->plat}}" data-toggle="modal" data-target="#detail" title="Detail"><i class="fa fa-list-alt" aria-hidden="true"></i></div>
            </td>
            
        </tr>
        @endforeach
    </tbody>
</table>

{!!$pagination!!}