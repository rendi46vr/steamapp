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
                <div class="form-group">
                    <input style="height: 38px; font-size: 1rem" type="date" name="first" id="first" class="form-control">
                </div>
                <div class="form-group">
                    <input style="height: 38px; font-size: 1rem" type="date" name="end" id="end" class="form-control">
                </div>
                <div class="form-group">
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
</script>


@endsection