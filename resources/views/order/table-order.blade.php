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
        @foreach($tambahan as $layanan)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$layanan->layanan}}</td>
            <td>@if($layanan->type == 0 ) Layanan Utama @else Layanan Tambahan @endif</td>
            <td>{{rupiah($layanan->harga)}}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th colspan="2">Total</th>
            <th colspan="2">{{rupiah($tambahan->sum("harga"))}}</th>
        </tr>
    </tfoot>
</table>