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
            <th>Watktu Order</th>
            <th>Quota</th>
            <th>Harga</th>
            <th>Status Tiket</th>
            <th>Action</th>
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
            <td>{{$t->payget->channel_description}}</td>
            <td>{{$t->created_at}}</td>
            <td>{{$t->quota()}}</td>
            <td>{{tools::rupiah($t->totalbayar)}}</td>

            <?php
            if (isset($t->payment)) {

                $fee = $t->payment->Fee;
            } else {
                $fee = 0; // Atau nilai default lainnya
            }
            ?>
                <td>
                    <div class=" p-1 rounded bg-primary text-white max-content ">Belum Terpakai</div>
                </td>
            <!-- <td>{{tools::rupiah($fee)}}</td> -->
            <td style="display: flex; white-space:nowrap">
                <div class="p-1 detail rounded bg-primary mr-2 text-white max-content pointer d-inline " data-add="detail/{{$t->id}}" data-plat="{{$t->plat}}" data-toggle="modal" data-target="#detail" title="Detail"><i class="fa fa-list-alt" aria-hidden="true"></i>detail</div> 
                 <a class=" p-1 rounded bg-success text-white max-content " href="{{url('download-tiket/'.$t->id)}}">Download Tiket</a>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

{!!$pagination!!}