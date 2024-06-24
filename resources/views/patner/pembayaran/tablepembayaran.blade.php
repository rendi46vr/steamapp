<?php

use App\Tools\tools;

?>
<table class="table ftc table-responsive-w-100 table-bordered" id="dataPatner">
    <thead>
        <tr>
            <th>No</th>
            <th>Noref</th>
            <th>tgl</th>
            <th>Jumlah</th>
            <th>status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($riwayat as $t)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$t->noref}}</td>
            <td>{{$t->tgl}}</td>
            <td>{{$t->jumlah()}}</td>
            <td>{!!$t->statusHtml()!!}</td>
            <td style="white-space: nowrap;">
                <a data-toggel="modal"  data-toggle="modal" data-target="#detailModal" class=" pointer p-1 rounded bg-info mr-2 text-white d-inlline" style="white-space: nowrap;" data-patner='{{$t->patner->nama_patner}}' data-noref='{{$t->noref}}' data-tgl='{{$t->tgl}}' data-bank='{{$t->bank}}' data-norek='{{$t->norek}}' data-atas-nama='{{$t->atas_nama}}' data-jumlah='{{$t->jumlah()}}' data-bukti='{{url("storage/".$t->bukti)}}' data-hutang='{{$t->hutang_saat_bayar()}}' data-status='{!!$t->statusHtml()!!}' title="detail"><i class="fa fa-eye" aria-hidden="true"></i> Lihat</a>
                @if($status == 0)
                    @if(auth()->user()->role == 'Patner')
                        <a data-ind="{{$t->id}}" class=" pointer p-1 rounded bg-danger text-white d-inlline batalkan" style="white-space: nowrap;" title="batal" > Batal?<i class="fa fa-times"></i></a>
                    @else
                        <a data-ind="{{$t->id}}" class=" pointer p-1 rounded bg-warning text-white d-inlline setujui" style="white-space: nowrap;" title="Setuju" ><i class="fa fa-check"></i> Setujui?</a>
                    @endif
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{!!$pagination!!}