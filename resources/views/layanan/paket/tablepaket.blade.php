<?php

use App\Tools\tools;

?>
<table class="table ftc table-responsive-w-100 table-bordered" id="dataCetak">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Paket</th>
            <th>Durasi</th>
            <th>Harga</th>
            <th>status aktif</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($paket as $t)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$t->nama_paket}}</td>
            <td>{{$t->durasi}}</td>
            <td>{{tools::rupiah($t->harga)}}</td>
            
            <td>
                <div class="custom-control custom-switch">
                    @if($t->status > 0)
                    <input class="custom-control-input" checked type="checkbox" id="{{$t->id}}"> <label class="custom-control-label text-success" for="{{$t->id}}">On</label>
                    @else
                    <input class="custom-control-input" type="checkbox" id="{{$t->id}}"> <label class="custom-control-label text-dark" for="{{$t->id}}">Off</label>
                    @endif
                </div>
            </td>
            <td>
                <a class=" pointer p-1 rounded bg-primary text-white d-inlline modalshow"  data-durasi="{{$t->durasi}}"  data-ind="{{$t->id}}" data-nama-paket="{{$t->nama_paket}}" data-qtyoption="{{$t->qtyoption}}" data-harga="{{$t->harga}}" data-diskon="{{$t->diskon}}" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                @if(auth()->user()->role =="Admin")
                <!-- <a class=" pointer p-1 rounded bg-danger text-white deldata " data-uniq="dellayanan/{{$t->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a> -->
                @endif
            </td>
        </tr>
        @endforeach
       
    </tbody>
</table>

{!!$pagination!!}