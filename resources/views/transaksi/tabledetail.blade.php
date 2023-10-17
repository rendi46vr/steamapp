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
            <td>{{$tjual->dataorder->name}}</td>
            <td> Layanan Utama </td>
            <td>{{rupiah($tjual->dataorder->harga -  $tjual->dataorder->diskon)}}</td>
        </tr>
        @foreach($tjual->addon as $l)
        <tr>
            <td>{{$loop->iteration+1}}</td>
            <td>{{$l->layanantambahan->layanan}}</td>
            <td>Layanan Tambahan</td>
            <td>{{rupiah($l->harga - $l->diskon )}}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th colspan="2">Sub Total</th>
            <th colspan="2">{{rupiah($tjual->addon->sum("harga") - $tjual->addon->sum("diskon") + $tjual->dataorder->harga - $tjual->dataorder->diskon)}}</th>
        </tr>
    </tfoot>
</table>