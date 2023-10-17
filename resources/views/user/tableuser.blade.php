<div class="d-flex justify-content-center">
    <h3 class="showmassage">{{$msg}}</h3>
</div>
<table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Password</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $d)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$d->name}}</td>
            <td>{{$d->email}}</td>
            <td>{{$d->role}}</td>
            <td>
                <div class="pointer action p-1 rounded bg-info text-white " data-add="resetpass/{{$d->id}}" data-show=".showassage"><i class="fa fa-refresh" aria-hidden="true"></i>Reset</div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>