@extends('layouts.app')
@section("scripts")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{url('css/payment.css')}}">


@endsection
@section('title')
Form Order
@endsection

@section('content')

<form id="order">
    @csrf
    <input type="hidden" name="uniq" value="sdndnfmfqw ehieknklsaudv19823h">
    <div class="smw-card mb-0">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="smw-card-header"> <i class="fa fa-address-card i-orange" aria-hidden="true"></i>
                    Info Pelanggan
                </div>
                <div class="smw-card-body pt-2">
                    <div class="form-group">
                        <label for="">No. Plat Kendaraan</label>
                        <input type="text" name="plat" id="" class="form-control msgplat" placeholder="No PLAT" id="inputPlat" aria-describedby="helpId">
                    </div>

                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" id="" class="form-control msgemail" placeholder="example@email.com" id="#layanan_tambahan"" aria-describedby=" helpId">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="smw-card-header"> <i class="fa fa-wpforms mr-1 i-orange" aria-hidden="true"></i>
                    Layanan yang diambil
                </div>
                <div class="smw-card-body pt-2 table-order">
                    {!! $layanan !!}
                </div>
                <div class="smw-card-header"> <i class="fa fa-credit-card i-orange" aria-hidden="true"></i>
                    Pilih Metode Pembayaran (VA & Qris)
                </div>
                <div class="row mt-2 mb-5 ">
                    @foreach($payment as $p)
                    <div class="col-md-5 col-6 ">
                        <div class="form-check form-check-inline mb-3">
                            <input id="{{$p->channel_code}}" class="form-check-input" type="radio" name="metpem" value="{{$p->channel_code}}">
                            <label for="{{$p->channel_code}}" class="form-check-label"><img src="{{url($p->logo)}}" alt="ipaymu-bank-danamon" style="height:52px;"></label>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-md-5 col-6 ">
                        <div class="form-check form-check-inline mb-3">
                            <input id="tunai" class="form-check-input" type="radio" name="metpem" value="tunai">
                            <label for="tunai" class="form-check-label btn-outline-info disabled rounded" style="font-size: 1.9rem;"><b> <i class="fa fa-money" aria-hidden="true"></i> Tunai</b></label>
                        </div>
                    </div>
                    <div class="msgmetpem"></div>
                </div>

                <div class="form-group mt-3 d-flex justify-content-end">
                    <button class="btn btn-orange lanjut-order resetFalse" type="submit"> Lanjutkan Pembayaran <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">

            </div>

        </div>
    </div>
</form>
<script type="text/javascript">
    function refreshData(res) {
        if (res.success) {
            window.location.href = res.data;
        }
    }


    $(document).on("change", "#layanan_tambahan", function() {
        // doReq("tambahlayanan", {
        //     _token: "{{ csrf_token() }}",
        //     slug: $("#paket").val(),
        //     tambahan: $(this).val(),
        // }, (res) => {
        //     if (res.status) {
        //         $(".table-order").html(res.data);
        //     }
        // })
        console.log("asldjldjlk")

    });

    $(document).on("keypress", "#inputPlat", function() {
        // c("ok")
        console.log("asldjldjlk")
    })
</script>
@endsection