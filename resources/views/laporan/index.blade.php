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
            <div class="d-flex col-12 justify-content-start mt-2 mr-2">
                <div class="form-group mr-1">
                    <input style="height: 38px; font-size: 1rem" type="date" value="2023-10-01" name="first" id="first" class="form-control">
                </div>
                <div class="form-group mr-1">
                    <input style="height: 38px; font-size: 1rem" type="date" name="end" value="{{date('Y-m-d')}}" id="end" class="form-control">
                </div>
                <div class="form-group">
                    <button class=" mr-1 btn-icon btn btn-orange vr-search" data-val="" data-add="laporan"><i class="fa fa-filter" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="col-sm-12 d-flex justify-content-center">
                @if(session('success'))
                <h3 class="text-dark">{{session('success')}}</h5>
                    @endif
            </div>
            <div class="smw-card-body  table-responsive">
                <div class="dataTransaksi mt-2">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Field </th>
                            <th>Data </th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                            <th>Data Per Tanggal</th>
                            <th>{{$transaksi->jenjangWaktu}}</th>
                        </tr>
                        <tr>
                            <th>Jumlah Kendaraan</th>
                            <td>{{$transaksi->jumlahKendaraan}} Mobil</td>
                        </tr>
                        <tr>
                            <th>Total Transaksi</th>
                            <td>{{$transaksi->totalTransaksi}}x Transaksi</td>
                        </tr>
                        <tr>
                            <th>Rata-rata Transaksi/Hari</th>
                            <td>{{$transaksi->rataRataTransaksiPerHari}}x </td>
                        </tr>
                        <tr>
                            <th>Rata-rata Nilai Transaksi</th>
                            <td>{{$transaksi->rataRataNilaiTransaksi}}</td>
                        </tr>
                        <tr>
                            <th>Rata-rata Pendapatan/Hari</th>
                            <td>{{$transaksi->rataRataPendapatanPerHari}}</td>
                        </tr>
                        <tr>
                            <th>Total Pendapatan</th>
                            <td>{{$transaksi->totalPendapatan}}</td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function refreshData(res) {
        $(res.parent).html(res.data);
    }
    // $("input[type=checkbox]").on("click", getChecked);
    $(document).on('click', "input[type=checkbox]", function() {
        let ini = $(this)
        doReq('lstatus/' + ini.attr("id"), null, function(res) {
            ini.parent().html(res);
        })
        // c($(this).attr("id"))
    })

    function searchData() {
        var data = {
            _token: tkn(),
            search: $(".search-value").val(),
        }
        return data;
    }
    function searchData() {
        var data = {
            _token: tkn(),
            first: $("#first").val(),
            end: $("#end").val(),
        }
        return data;
    }

</script>
@endsection
