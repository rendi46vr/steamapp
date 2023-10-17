<?php

use App\Tools\tools;

?>
<table class="table ftc table-responsive-w-100 table-bordered" id="dataCetak">
    <thead>
        <tr>
            <th>No</th>
            <th>Plat</th>
            <th>Pelanggan</th>
            <th>Email</th>
            <th>Tanggal Order</th>
            <th>Pembayaran</th>
            <th>jumlah</th>
            <th>Status</th>
            <th>Detail</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksi as $t)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$t->plat}}</td>
            <td>
                @if($t->user_id != null)
                <div class=" p-1 rounded bg-info text-white "> Member</div>
                @else
                <div class=" p-1 rounded bg-secondary text-white ">Non Member</div>
                @endif
            </td>
            <td>{{$t->email}}</td>
            <td>{{$t->tgl}}</td>
            <td>{{$t->payget->channel_description}}</td>
            <td>{{ tools::rupiah($t->totalbayar)}}</td>
            <?php
            if (isset($t->payment)) {

                $fee = $t->payment->Fee;
            } else {
                $fee = 0; // Atau nilai default lainnya
            }
            ?>
            <!-- <td>{{tools::rupiah($fee)}}</td> -->
            <td>
                <div class=" p-1 rounded bg-danger text-white ">Expired</div>
            </td>
            <td>
                <div class="p-1 detail rounded bg-primary text-white max-content pointer d-inline " data-add="detail/{{$t->id}}" data-plat="{{$t->plat}}" data-toggle="modal" data-target="#detail" title="Detail"><i class="fa fa-list-alt" aria-hidden="true"></i></div>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

{!!$pagination!!}