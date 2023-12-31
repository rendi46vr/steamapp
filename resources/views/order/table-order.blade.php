<?php
function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
} ?>
<table class="table table-bordered table-striped">
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
            <td>{{$layanan->layanan}}</td>
            <td>@if($layanan->type == 0 ) Layanan Utama @endif</td>
            <td>{{rupiah($layanan->harga -  $layanan->diskon)}}</td>
        </tr>
        @foreach($tambahan as $l)
        <tr>
            <td>{{$loop->iteration+1}}</td>
            <td>{{$l->layanan}}</td>
            <td>Layanan Tambahan</td>
            <td>{{rupiah($l->harga - $l->diskon )}}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th colspan="2">Sub Total</th>
            <th colspan="2">{{rupiah($tambahan->sum("harga") - $tambahan->sum("diskon") + $layanan->harga - $layanan->diskon)}}</th>
        </tr>
    </tfoot>
</table>