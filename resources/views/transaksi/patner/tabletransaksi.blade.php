<?php

use App\Tools\tools;

?>
<table class="table ftc table-responsive-w-100 table-bordered" id="dataCetak">
    <thead>
        <tr>
            <th>No</th>
            <th>Plat</th>
            <th>No Whatsapp</th>
            <th>Pembayaran</th>
            <th>Waktu Order</th>
            <th>Quota</th>
            <th>Quota cuci</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Detail</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksi as $t)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$t->plat}}</td>
            <td>{{$t->wa}}</td>
            <td>{{$t->payget->channel_description}}</td>
            <td>{{$t->created_at}}</td>
            <td>{{$t->quota()}}</td>
            <td>{{$t->sisaSaldo()}}</td>
            <td>{{tools::rupiah($t->totalbayar)}}</td>

            <!-- <td>{{ tools::rupiah($t->totalbayar)}}</td> -->
            <?php
            if (isset($t->payment)) {

                $fee = $t->payment->Fee;
            } else {
                $fee = 0; // Atau nilai default lainnya
            }
            ?>
            <!-- <td>{{tools::rupiah($fee)}}</td> -->
            <td>
                @if($t->status =="berhasil")
                <div class=" p-1 rounded bg-success text-white ">Sucess</div>
                @elseif($t->status == "pending")
                @if($t->metpem =="tunai")
                <div class="tunai">
                    <div class=" p-1 action rounded bg-info text-white pointer" data-add="confirm/{{$t->id}}" data-show=".tunai">Konfirmasi</div>
                </div>
                @else
                <div class=" p-1 rounded bg-warning text-white ">Pending</div>
                @endif
                @elseif($t->status == "expired")
                <div class=" p-1 rounded bg-danger text-white ">Expired</div>
                @endif
            </td>
            <td>
                <div class="p-1 detail rounded bg-primary text-white max-content pointer d-inline " data-add="detail/{{$t->id}}" data-plat="{{$t->plat}}" data-toggle="modal" data-target="#detail" title="Detail"><i class="fa fa-list-alt" aria-hidden="true"></i></div>
            </td>
        </tr>
        @endforeach
        <tr>
            <th rowspan="2"></th>
            <th colspan="5" rowspan="2" style="vertical-align: middle;">Total</th>
            
            <th colspan="2" style="text-align: right;">{{tools::rupiah($hutang)}}</th>
        </tr>
    </tbody>
</table>

{!!$pagination!!}