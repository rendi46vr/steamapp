@extends('layouts.app')
@section('script')

@endsection
@section('title')
{{$title}}
@endsection
@section('content')
@csrf


<div class="smw-card">
    <div class=" row">
        <div class="col-lg-12 col-md-12">
            <div class="smw-card-header"> <i class="fa fa-wpforms mr-1 i-orange" aria-hidden="true"></i>
                {{$title}}
            </div>
            <div class="col-sm-12 d-flex justify-content-center">
                @if(session('success'))
                <h3 class="text-dark">{{session('success')}}</h5>
                    @endif
            </div>
            <div class="smw-card-body  table-responsive">
                <div class="dataPembayaran mt-2">
                <table class="table  table-bordered">
                        <tr>
                            <th colspan="2" style="text-align: center;">{{$patner->nama_patner}}</th>
                        </tr>
                        <tr>
                            <th>Nomor Whastapp</th>
                            <td >{{$patner->nowa}}</td>
                        </tr>
                        <tr>
                            <th>Transaki</th>
                            <td>{{$total_order_berhasil}}x <a class="badge badge-info" href="{{url('patnertransaksi')}}">lihat </a></td>
                        </tr>
                        <tr>
                            <th>Total Nominal Transaksi</th>
                            <td>{{$total_nominal}}</td>
                        </tr>
                        <tr>
                            <th>Pembayaran</th>
                            <td>{{$total_pembayaran}}x <a class="badge badge-info" href="{{url('pembayaran')}}">lihat</a></td>
                        </tr>
                        <tr>
                            <th>Total Nominal Pembayaran</th>
                            <td>{{$total_nominal_bayar}}</td>
                        </tr>
                        <tr>
                            <th>Sisa Hutang</th>
                            <td>{{$sisa_hutang}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

