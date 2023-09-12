<?php

use App\Tools\tools;

?>
<table class="table ftc table-responsive-w-100 table-bordered" id="dataCetak">
    <thead>
        <tr>
            <th>No</th>
            <th>Layanan</th>
            <th>Deskripsi</th>
            <th>Qty</th>
            <th>harga</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($layanan as $t)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$t->layanan}}</td>
            <td>{{$t->deskripsi}}</td>
            <td>{{$t->qtyoption}}</td>
            <td>{{tools::rupiah($t->harga)}}</td>
            <td>
                <a class=" pointer p-1 rounded bg-primary text-white d-inlline "><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> |
                <a class=" pointer p-1 rounded bg-danger text-white deldata " data-uniq="dellayanan/{{$t->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{!!$pagination!!}