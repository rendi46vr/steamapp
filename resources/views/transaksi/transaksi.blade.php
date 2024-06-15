@extends('layouts.app')
@section('script')

@endsection
@section('title')
Data Transaksi
@endsection
@section('content')
@csrf

<div class="smw-card">
    <div class=" row">
        <div class="col-lg-12 col-md-12">
            <div class="smw-card-header"> <i class="fa fa-wpforms mr-1 i-orange" aria-hidden="true"></i>
               Data Transaksi
            </div>
            <div class="d-flex col-12 justify-content-end mt-2 mr-2">
                <div class="form-group mr-1">
                    <select name="sip" style="height: 38px; font-size: 1rem" class="form-control" id="sip">
                        <option value="">Semua Sip</option>
                        <option value="0">Siang</option>
                        <option value="1">Malam</option>
                        <option value="3">Middle</option>
                    </select>
                </div>
                <div class="form-group mr-1">
                    <input style="height: 38px; font-size: 1rem" type="date" name="first" id="first" class="form-control">
                </div>
                <div class="form-group mr-1">
                    <input style="height: 38px; font-size: 1rem" type="date" name="end" id="end" class="form-control">
                </div>
                <div class="form-group mr-1">
                    <input style="height: 38px; font-size: 1rem" type="text" class="d-inline form-control  search-value mr-1" placeholder="Type to search">
                </div>
                <div class="form-group">
                    <button class=" mr-1 btn-icon btn btn-orange vr-search" data-val="" data-add="searchtransaksi"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="col-sm-12 d-flex justify-content-center">
                @if(session('success'))
                <h3 class="text-dark">{{session('success')}}</h5>
                    @endif
            </div>
            <div class="smw-card-body dataTransaksi table-responsive">
                {!! $transaksi !!}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body detail-body table-responsive">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-orange">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function refreshData(res) {
        $('.dataTransaksi').html(res);
    }

    function searchData() {
        var data = {
            _token: tkn(),
            search: $(".search-value").val(),
            first: $("#first").val(),
            end: $("#end").val(),
            sip: $("#sip").val(),
        }
        return data;
    }
    
    $(document).on('click', '.createmember', function() {
        doReq($(this).data("add"), null, (res) => {
            if (res.status) {
                refreshData(res.data)
                Swal.fire({
                    icon: 'success',
                    title: 'Pendaftaran Member Berhasil',
                    timer: 2000,
                    buttons: false,
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: res.msg,
                    timer: 2000,
                    button: false,
                })
            }
        })
    })
    $(document).on('click', '.detail', function() {
        $('.modal-title').text($(this).data("plat"))
        doReq($(this).data("add"), null, (res) => {
            if (res.success) {
                $('.detail-body').html(res.data)
            }
        })
    })
    $(document).on('click', '.kirimnota', function() {
        doReq($(this).data("add"), null, (res) => {
            if(res.success){
                Swal.fire('Sukses!',res.message,'success')
            }else{
                Swal.fire('Sukses!',res.message,'success')
            }
        })
    })
    

 
</script>


@endsection