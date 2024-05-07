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
                Laporan Transaksi
            </div>
            <div class="d-flex justify-content-end mt-2 mr-2">
                <input type="text" class="d-inline  search-value mr-1" placeholder='Cari bg...' >
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
</script>
@endsection
