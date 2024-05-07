@extends('layouts.app')

@section('title')
Layanan
@endsection
@section('style')
@endsection
@section('content')
<div class="smw-card">
    <div class=" row">
        <div class="col-lg-12 col-md-12">
            <div class="smw-card-header"> <i class="fa fa-wpforms mr-1 i-orange" aria-hidden="true"></i>
                Riwayat {{$bg}}
            </div>
            <div class="d-flex justify-content-end mt-2 mr-2">
            <div class="form-group mr-1">
                    <input style="height: 38px; font-size: 1rem" type="date" name="end" value="{{date('Y-m-d')}}" id="end" class="form-control">
            </div>
                <button class=" mr-1 btn-icon btn btn-light vr-search" data-val="" data-add="searchperplat"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
            <div class="col-sm-12 d-flex justify-content-center">
                @if(session('success'))
                <h3 class="text-dark">{{session('success')}}</h5>
                    @endif
            </div>
            <div class="smw-card-body  table-responsive">
                <div class="dataTransaksi mt-2">
                    {!! $transaksi !!}
                </div>
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
        $(res.parent).html(res.data);
    }

    function searchData() {
        var data = {
            _token: tkn(),
            search: $(".search-value").val(),
        }
        return data;
    }
    $(document).on('click', '.detail', function() {
        $('.modal-title').text($(this).data("plat"))
        doReq($(this).data("add"), null, (res) => {
            if (res.success) {
                $('.detail-body').html(res.data)
            }
        })
    })
</script>
@endsection
