<?php

use App\Tools\tools;

?>
<table class="table ftc table-responsive-w-100 table-bordered" id="dataCetak">
    <thead>
        <tr>
            <th>No</th>
            <th>Layanan</th>
            <th>Harga</th>
            <th>Diskon</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($layanantambahan as $t)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$t->layanan}}</td>
            <td>{{tools::rupiah($t->harga)}}</td>
            <td>{{tools::rupiah($t->diskon)}}</td>
            <td>
                <div class="custom-control custom-switch">
                    @if($t->isaktif >0)
                    <input class="custom-control-input" checked type="checkbox" id="{{$t->id}}"> <label class="custom-control-label text-success" for="{{$t->id}}">On</label>
                    @else
                    <input class="custom-control-input" type="checkbox" id="{{$t->id}}"> <label class="custom-control-label text-dark" for="{{$t->id}}">Off</label>
                    @endif
                </div>
            </td>
            <td>
                <a class=" pointer p-1 rounded bg-primary text-white d-inlline modalshow" data-toggle="modal" data-target="#editModal" data-ind="{{$t->id}}" data-harga="{{$t->harga}}" data-diskon="{{$t->diskon}}" data-name="{{$t->layanan}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                @if(auth()->user()->role =="Admin")
                |
                <a class=" pointer p-1 rounded bg-danger text-white deldata " data-uniq="dellayanantambahan/{{$t->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{!!$pagination!!}