<?php

use App\Tools\tools;

?>
<table class="table ftc table-responsive-w-100 table-bordered" id="dataCetak">
    <thead>
        <tr>
            <th>No</th>
            <th>Plat</th>
            <th>No Wa</th>
            <th>Email</th>
            <th>Tanggal</th>
            <th>Metode Pembayaran</th>
            <th>Jumlah</th>
            <th>Biaya Admin</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksi as $t)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$t->plat}}</td>
            <td>{{$t->wa}}</td>
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
            <td>{{tools::rupiah($fee)}}</td>
            <td>
                @if($t->status =="berhasil")
                <div class=" p-1 rounded bg-success text-white ">Sucess</div>
                @elseif($t->status == "pending")
                @if($t->metpem =="tunai")
                <div class="tunai">
                    <div class=" p-1 action rounded bg-info text-white " data-add="confirm/{{$t->id}}" data-show=".tunai">Konfirmasi</div>
                </div>
                @else
                <div class=" p-1 rounded bg-warning text-white ">Pending</div>
                @endif
                @elseif($t->status == "expired")
                <div class=" p-1 rounded bg-danger text-white ">Expired</div>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{!!$pagination!!}