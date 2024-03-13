<?php

use App\Tools\tools;

?>
<table class="table ftc table-responsive-w-100 table-bordered" id="dataCetak">
    <thead>
        <tr>
            <th>No</th>
            <th>Layanan</th>
            <th>Edit/Hapus</th>
        </tr>
    </thead>
    <tbody>
        @foreach($platgratis as $t)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$t->plat}}</td>
            <td>
                <a class=" pointer p-1 rounded bg-primary text-white d-inlline modalshow" data-name="{{$t->plat}}" data-ind="{{$t->id}}" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> |
                @if(auth()->user()->role =="Admin")
                <a class=" pointer p-1 rounded bg-danger text-white deldata " data-uniq="delplatgratis/{{$t->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{!!$pagination!!}