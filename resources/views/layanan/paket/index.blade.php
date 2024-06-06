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
            <div class="d-flex justify-content-end mt-2 mr-2">
                <input type="text" class="d-inline  search-value mr-1" placeholder="Type to search">
                <button class=" mr-1 btn-icon btn btn-light vr-search" data-val="" data-add="searchlayanan"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
            <div class="col-sm-12 d-flex justify-content-center">
                @if(session('success'))
                <h3 class="text-dark">{{session('success')}}</h5>
                    @endif
            </div>
            <div class="smw-card-body  table-responsive">
                <button class="btn btn-orange" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus" aria-hidden="true"></i> Tambah</button>
                <div class="dataTiket mt-2">
                    {!! $paket !!}
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
        c($(this).attr("id"))
    })

    function searchData() {
        var data = {
            _token: tkn(),
            search: $(".search-value").val(),
        }
        return data;
    }
    $('input[name="qty"]').on('input', function() {
        var value = $(this).val();

        if (value > 2000) {
            $(this).val(2000); // Mengatur nilai menjadi 2000 jika melebihi batas
        }
    });
    $(document).on('change', '.jtiket', function() {
        if (this.value == 1) {
            $('.tgl').attr('disabled', '').val('')
        } else {
            $('.tgl').removeAttr('disabled')
        }
    })
    $(document).on("click", ".modalshow", function() {
        const ini = $(this)
        $("#nama_paketedit").val(ini.data("nama-paket"))
        $("#hargaedit").val(ini.data("harga"))
        $("#durasiedit").val(ini.data("durasi"))
        $("#editdiskon").val(ini.data("diskon"))
        $("#ind").val(ini.data("ind"))

    })
    $(document).ready(function() {
        $('#service-type').change(function() {
            c('adsfsaf');
            var selectedValue = $(this).val();
            var quantityInput = $('#quantity-input');
            var durationInput = $('#duration-input');

            if (selectedValue === '0') {
                quantityInput.show();
                durationInput.hide();
            } else if (selectedValue === '1') {
                quantityInput.hide();
                durationInput.show();
            } else {
                quantityInput.hide();
                durationInput.hide();
            }
        });
    });
</script>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="layanan/paket/addpaket">

        <div class="modal-dialog	modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group vr-form">
                        <input type="hidden" name='layanan_id' value="{{$layanan->id}}">
                        <label for="recipient-name" style="font-size: 16px; " class=" col-form-label">Nama Paket:</label>
                        <input type="text" class="form-control msgnama_paket" name="nama_paket" id="nama_paket">
                    </div>
                    @csrf
                    <div id="duration-input" class="form-group vr-form" >
                        <label for="duration" style="font-size: 16px;" class="col-form-label">Durasi (Hari)</label>
                        <input type="number" class="form-control msgdurasi" min="1" value="1" name="durasi" id="durasi" placeholder="contoh: 30 (30 Hari)">
                        
                    </div>

                    <div class="form-group vr-form">
                        <label for="message-text" style="font-size: 16px; " class=" col-form-label">Harga</label>
                        <input type="number" class="form-control msgharga" name="harga" id="harga">
                    </div>
                    <div class="form-group vr-form">
                        <label for="message-text" style="font-size: 16px; " class=" col-form-label">Diskon</label>
                        <input type="number" class="form-control msgdiskon" value="0" name="diskon" id="diskon">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">batal</button>
                    <button type="submit" class="btn btn-primary resetFalse" form="addlayanan">Tambah</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
<form id="layanan/paket/editpaket">

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group vr-form">
                <input type="hidden" name='layanan_id' value="{{$layanan->id}}">
                <input type="hidden" name='id' id='ind'>
                <label for="recipient-name" style="font-size: 16px; " class=" col-form-label">Nama Paket:</label>
                <input type="text" class="form-control msgnama_paket" name="nama_paket" id="nama_paketedit">
            </div>
            @csrf
            <div id="duration-input" class="form-group vr-form" >
                <label for="duration" style="font-size: 16px;" class="col-form-label">Durasi (Hari)</label>
                <input type="number" class="form-control msgdurasi" min="1" value="1" name="durasi" id="durasiedit" placeholder="contoh: 30 (30 Hari)">
            </div>

            <div class="form-group vr-form">
                <label for="message-text" style="font-size: 16px; " class=" col-form-label">Harga</label>
                <input type="number" class="form-control msgharga" name="harga" id="hargaedit">
            </div>
            <div class="form-group vr-form">
                <label for="message-text" style="font-size: 16px; " class=" col-form-label">Diskon</label>
                <input type="number" class="form-control msgdiskon" value="0" name="diskon" id="diskonedit">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">batal</button>
            <button type="submit" class="btn btn-primary resetFalse" form="layanan/paket/editpaket">Tambah</button>
        </div>
    </div>
</div>
</form>
</div>



@endsection