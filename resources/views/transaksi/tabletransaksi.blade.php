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
            <th>Pembayaran</th>
            <!-- <th>Saldo Awal</th> -->
            <th>Saldo cuci</th>
            <th>Saldo terpakai</th>
            <!-- <th>Biaya Admin</th> -->
            <th>Status</th>
            <th>Action</th>
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
            <td>{{$t->payget->channel_description}}</td>
            <td>{{$t->qty}}</td>
            <td>{{$t->qtyterpakai}}</td>
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
                @if($t->user_id == null)
                <div class=" p-1 rounded bg-secondary text-white pointer createmember" data-add="addmember/{{$t->id}}" data-show=".dataTransaksi"><i class="fa fa-address-card" aria-hidden="true"></i> Buat Member</div>
                @endif
            </td>

        </tr>
        <tr>
            <td></td>
            <td colspan=""></td>

        </tr>
        @endforeach
    </tbody>
</table>

{!!$pagination!!}