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
<?php

use Illuminate\Http\Request;
use App\Tools\tools;
?>
<form id="order" novalidate>
    @csrf
    <input type="hidden" name="uniq" value="sdndnfmfqw ehieknklsaudv19823h">
    <div class="smw-card mb-0">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="smw-card-header"> <i class="fa fa-address-card i-orange" aria-hidden="true"></i>
                    Info Pelanggan
                </div>
                <input type="hidden", name="act" value="0" id="acttype">
                <div class="smw-card-body pt-2">
                    <?php
                    if (session()->has("user")) {

                    ?>
                    <div class="row">
                        <div class="form-group vr-form col-8">
                            <label for="">No. Plat Kendaraan</label>
                            <input type="hidden" name="type" value='{{$jasa->type}}'>
                            <input type="text" name="plat" id="" class="form-control msgplat" value="{{session('user')['plat']}}" placeholder="No PLAT" id="noplat" aria-describedby="helpId">
                        </div>
                        <div style="align-self: flex-end;">
                               <button class="btn btn-info cekplat">Cek</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="statuspaket"></label>
                        <a class="btn btn-success langganan" style="display: none;" href="" data-act="0">Pakai Langganan</a>
                        
                    </div>
                        <div class="form-group vr-form">
                            <label for="">Nomor Whatsapp</label>
                            <input type="number" name="wa" id="" class="form-control msgwa" placeholder="08............" value="{{session('user')['wa']}}" id="nowa"" aria-describedby=" helpId">
                        </div>

                        <!-- <div class="form-group vr-form">
                            <label for="">Email</label>
                            <input type="email" name="email" id="" class="form-control msgemail" placeholder="example@email.com" value="{{session('user')['email']}}" id="email"" aria-describedby=" helpId">
                        </div> -->

                    <?php } else { ?>
                        <div class="row">
                        <div class="form-group vr-form col-8">
                            <label for="">No. Plat Kendaraan</label>
                            <input type="hidden" name="type" value='{{$jasa->type}}'>
                            <input type="text" name="plat" id="" class="form-control msgplat" placeholder="No PLAT..." id="noplat" aria-describedby="helpId">
                        </div>
                        <div class="form-group col-4 d-flex align-item-end ">
                        <div style="align-self: flex-end;">
                               <button class="btn btn-info cekplat">Cek</button>
                            </div>
                        </div>
                    </div>
                        <div class="form-group">
                            <label class="statuspaket"></label>
                            @if(auth()->user())
                            <a class="btn btn-success langganan" style="display: none;" href="" data-act="0">Pakai Langganan</a>
                            @else
                            <a class="btn btn-primary langganan" style="display: none;" href="" data-act="0">Detail Langganan</a>
                            @endif
                        </div>
                        <div class="form-group vr-form">
                            <label for="">Nomor Whatsapp</label>
                            <input type="number" name="wa" id="" class="form-control msgwa" placeholder="08............" id="#layanan_tambahan"" aria-describedby=" helpId">
                        </div>
                        <!-- <div class="form-group vr-form">
                            <label for="">Email</label>
                            <input type="email" name="email" id="" class="form-control msgemail " placeholder="example@email.com" id="#layanan_tambahan"" aria-describedby=" helpId">
                        </div> -->
                    <?php } ?>
                    @if($jasa->formqty > 0)

                    <div class="form-group vr-form">
                        <label for="">Quantity</label>
                        <div class="qty">
                            <span class="pointer kurang">
                                <i class="fa fa-minus-circle " aria-hidden="true"></i>
                            </span>
                            <span class="quantity mr-2 ml-2">1</span>
                            <span class="pointer tambah">
                                <i class="fa fa-plus-circle i-orange" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="hidden" name="quantity" max="6" min="1" id="" value="1" class=" msgquantity " placeholder="" value="1" id="quantity"" aria-describedby=" helpId">
                    </div>
                    @endif
                    @if($jasa->type == 1)
                        <div id="duration-input " class="form-group vr-form">
                            <label for="duration" style="font-size: 16px;" class="col-form-label">Durasi Waktu</label>
                            <select id="duration" name="durasi" class="form-control msgduration py-0">
                                <option value="" selected disabled hidden>Pilih Waktu Langganan</option>
                                @foreach($jasa->paket as $paket)
                                <option value="{{$paket->id}}">{{$paket->nama_paket}} - {{tools::rupiah($paket->harga)}}</option>
                                @endforeach
                               
                            </select>
                        </div>
                    @endif
                </div>
                <div class="smw-card-header">
                    <i class="fa fa-list-alt i-orange" aria-hidden="true"></i>
                    Layanan Tambahan
                </div>
                <div class="row mt-2 mb-5 vr-form">
                    @foreach($lb as $l)
                    <div class="col-md-6 col-lg-6 col-12">
                        <div class="form-check form-check-inline mb-3">
                            <input id="addon{{$l->id}}" class="form-check-input checkbox-lg" type="checkbox" name="addon" value="{{$l->id}}" />
                            <label for="addon{{$l->id}}" class="form-check-label b-600">
                                {{$l->layanan}}
                                @if($l->diskon > 0 ) <font class="text-danger">Promo</font> <s>{{rupiah($l->harga)}} </s>
                                @endif
                                @if($l->harga - $l->diskon >0)
                                ( {{rupiah($l->harga - $l->diskon)}} )
                                @else
                                (<font class="text-danger">Free</font>)
                                @endif
                            </label>
                        </div>
                    </div>
                    @endforeach

                    <div class="msgaddon"></div>
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
                    Pilih Metode Pembayaran (Qris & Tunai)
                </div>
                <div class="row mt-2 mb-5 ">
                    @foreach($payment as $p)
                    <div class="col-md-5 col-lg-6 col-12">
                        <div class="form-check form-check-inline mb-3">
                            <input id="{{$p->channel_code}}" class="form-check-input" type="radio" name="metpem" value="{{$p->channel_code}}">
                            <label for="{{$p->channel_code}}" class="form-check-label"><img src="{{url($p->logo)}}" alt="ipaymu-bank-danamon" style="height:52px;"></label>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-md-5 col-lg-6 col-12">
                        <div class="form-check form-check-inline mb-3">
                            <input id="tunai" class="form-check-input" type="radio" name="metpem" value="tunai">
                            <label for="tunai" class="form-check-label btn-outline-info disabled rounded" style="font-size: 1.9rem;"><b> <i class="fa fa-money" aria-hidden="true"></i> Tunai</b></label>
                        </div>
                    </div>
                    <div class="msgmetpem"></div>
                </div>
                <div class="form-group m-0 d-flex justify-content-start">

                    <a class="btn btn-orange buy" href="{{url('/')}}" type="submit"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a>
                </div>

                <div class="form-group mt-3 d-flex justify-content-end">
                    <button class="btn btn-orange lanjut-order resetFalse loading" type="submit"> Lanjutkan Pembayaran <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">

            </div>

        </div>
    </div>
</form>
<script type="text/javascript">
    $('#duration').on('change', function(e){
        doReq('addpaket/'+$(this).val(),null,(res)=>{
            $('.table-order').html(res);
        });     
    });

    function refreshData(res) {
        if (res.success) {
            window.location.href = res.data;
        }
    }

    function checkedData() {
        var checked = [];
        $("input[name='addon']:checked").each(function() {
            checked.push($(this).val());
        });
        doReq("tambahlayanan", {
            _token: "{{ csrf_token() }}",
            tambahan: checked,
            plat: $('.msgplat').val(),
        }, (res) => {
            c($('.msgplat').val())   
            if (res.status) {
                $(".table-order").html(res.data);
            }
        })
        return checked;
    }
    $("input[type=checkbox]").on("click", checkedData);
    $(document).on("change", "#layanan_tambahan", function() {
        console.log("asldjldjlk")
    });

    $(document).on("change", ".msgplat", function() {
        const ini = $(this).val();
        if (ini.length > 4) {
            cekDataPlat(ini);
        }
    })
    $(document).on("click", ".cekplat", function(e) {
        e.preventDefault()
        const button = $(this);
        let msgplat = $('.msgplat')
        let ini = $('.msgplat').val();
        if (ini.length > 4) {
            button.html("<span class='spinner-border spinner-border-sm' role='status'></span>Checking...")
            cekDataPlat(ini);
            msgplat.parent().find('help-block').text('')
            checkedData()
        }else{
            if (msgplat.parent().find('.help-block').length === 0) {
            var helpBlock = $('<div class="help-block  f12  text-danger with-errors"> Plat Harus diisi Minimal 4 Karakter </div>');
            msgplat.parent().append(helpBlock);
            } else {
                msgplat.parent().find('help-block').text('Plat Harus diisi  Minimal 4 Karakter');
            }
        }


    })
    function cekDataPlat(ini){
        const button = $('.cekplat')
        doReq('find/' + ini, null, function(res) {
            if (res.success) {
                $('.msgwa').val(res.wa)
                $('.msgemail').val(res.email)
                const msg =$('.statuspaket'),lgn = $('.langganan');
                let act =0;
                if(res.paket){
                    msg.html(res.message)
                    if(res.expire){
                        msg.removeClass('text-success').addClass('text-danger');
                   }else{
                        if(res.action){
                            msg.removeClass('text-danger').addClass('text-success');act =1;
                        }else{
                            msg.removeClass('text-danger').addClass('text-primary');act =0;
                        }
                        lgn.show().attr('href',res.slug);
                        $('#acttype').val(act);
                    }
                }else{
                    lgn.hide()
                }
            }
            button.html('Cek')
        })
    }
    window.addEventListener('popstate', function (event) {
        location.reload();
    });
    <?php if(auth()->user()) : ?>
        $(document).ready(function(){
            $(document).on('click','.langganan', function(e){
                e.preventDefault()
                c('helo')
                const lgn = $('#acttype').val();
                const target =$(this).attr('href');
                if(lgn ==1){
                    doReq(target, null , function(res){
                        if(res.status){
                            Swal.fire(
                                'Sukses!',
                                'Langganan Berhasil Terpakai',
                                'success'
                            ).then(() => {
                                window.location.href= baseUri(target)
                            });
                        }else{
                            Swal.fire(
                                'Gagal!',
                                'Langganan Tidak Valid atau Kadaluarsa',
                                'error'
                            ).then(()=>{
                                window.location.href= baseUri(target)

                            })
                        }
                    });
                }
            });
        });

    <?php endif ?>
</script>
@endsection