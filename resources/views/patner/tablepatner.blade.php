    <?php

    use App\Tools\tools;

    ?>
    <table class="table ftc table-responsive-w-100 table-bordered" id="dataPatner">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Patner</th>
                <th>No Whatsapp</th>
                <th>Email</th>
                <th>alamat</th>
                <th>Hutang</th>
                <th>status</th>
                <th>detail</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patner as $t)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$t->nama_patner}}</td>
                <td>{{$t->nowa}}</td>
                <td>{{$t->email}}</td>
                <td>{{$t->alamat}}</td>
                <td>{{$t->hutang()}}</td>
                <td>
                    <div class="custom-control custom-switch">
                        @if($t->status >0)
                        <input class="custom-control-input" checked type="checkbox" id="{{$t->id}}"> <label class="custom-control-label text-success" for="{{$t->id}}">On</label>
                        @else
                        <input class="custom-control-input" type="checkbox" id="{{$t->id}}"> <label class="custom-control-label text-dark" for="{{$t->id}}">Off</label>
                        @endif
                    </div>
                </td>
                <td>
                <a href="{{url('rinciantransaksi/'.$t->id)}}" class=" pointer p-1 rounded bg-info mr-2 text-white d-inlline" style="white-space: nowrap;"  title="detail"><i class="fa fa-eye" aria-hidden="true"></i> lihat transaksi</a> 

                    <a class=" pointer p-1 rounded bg-primary text-white d-inlline modalshow" data-name="{{$t->nama_patner}}" data-ind="{{$t->id}}" data-nowa="{{$t->nowa}}" data-email="{{$t->email}}" data-alamat="{{$t->alamat}}" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {!!$pagination!!}