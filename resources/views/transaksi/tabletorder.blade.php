<?php

use App\Tools\tools;

?>
<table class="table ftc table-responsive-w-100 table-bordered" id="dataCetak">
    <thead>
        <tr>
            <th>No</th>
            <th>Plat</th>
            <th>nomor</th>
            <!-- <th>Email</th> -->
            <th>Pembayaran</th>
            <th>Watktu Order</th>
            <!-- <th>Saldo Awal</th> -->
            <th>Saldo cuci</th>
            <th>Jumlah</th>

            <!-- <th>Biaya Admin</th> -->
            <th>Action</th>
            <!-- <th>Buat</th> -->
        </tr>
    </thead>
    <tbody>
        @foreach($transaksi as $t)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$t->plat}}</td>
            <td>
                {{$t->wa}}
            </td>
            <!-- <td>{{$t->email}}</td> -->
            <td>{{$t->payget->channel_description}}</td>
            <td>{{$t->created_at}}</td>
            <td>{{$t->qty}}</td>
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
                <div class="p-1 detail rounded bg-primary text-white max-content pointer d-inline " data-add="detail/{{$t->id}}" data-plat="{{$t->plat}}" data-toggle="modal" data-target="#detail" title="Detail"><i class="fa fa-list-alt" aria-hidden="true"></i></div> |
                @if($t->status =="berhasil")
                <div class=" p-1 rounded bg-success text-white max-content ">Sucess</div>
                @elseif($t->status == "pending")
                @if($t->metpem =="tunai")
                <div class="tunai tunai{{$t->id}} d-inline">
                    <div class=" p-1 confirm rounded bg-info text-white max-content pointer d-inline " data-add="confirm/{{$t->id}}" data-show=".tunai{{$t->id}}">Konfirmasi</div>
                </div>
                @else
                <div class=" p-1 rounded bg-warning text-white max-content ">Pending</div>
                @endif
                @elseif($t->status == "expired")
                <div class=" p-1 rounded bg-danger text-white max-content ">Expired</div>
                @endif
            </td>
            <!-- <td>
                @if($t->user_id == null)
                <div class=" p-1 rounded bg-secondary text-white max-content pointer createmember" data-add="addmember/{{$t->id}}" data-show=".dataTransaksi"><i class="fa fa-address-card" aria-hidden="true"></i> Buat Member</div>
                @endif
            </td> -->

        </tr>
        @endforeach
    </tbody>
</table>

{!!$pagination!!}