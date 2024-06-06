@extends('layouts.app')
@section('script')

@endsection
@section('title')
Layanan Utama
@endsection
@section('content')
@csrf

<div class="smw-card">
    <div class=" row">
        <div class="col-lg-12 col-md-12">
            <div class="smw-card-header"> <i class="fa fa-wpforms mr-1 i-orange" aria-hidden="true"></i>
                Layanan Utama
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
                    {!! $layanan !!}
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
        $("#namalayanan").val(ini.data("name"))
        $("#editharga").val(ini.data("harga"))
        $("#editdeskripsi").val(ini.data("deskripsi"))
        $("#editdiskon").val(ini.data("diskon"))
        $("#editqtyoption").val(ini.data("qtyoption"))
        $("#ind").val(ini.data("ind"))

    })
    $(document).ready(function() {
        $('#service-type').change(function() {
            c('adsfsaf');
            var selectedValue = $(this).val();
            var quantityInput = $('#quantity-input');
            var harga = $('#harga-input');

            if (selectedValue === '0') {
                quantityInput.show();
                harga.show();
            } else if (selectedValue === '1') {
                harga.hide();
                quantityInput.hide();
            } else {
                quantityInput.hide();
                harga.hide();
            }
        });
    });
</script>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="addlayanan">

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
                        <label for="recipient-name" style="font-size: 16px; " class=" col-form-label">Nama Layanan:</label>
                        <input type="text" class="form-control msglayanan" name="layanan" id="layanan">
                    </div>
                    @csrf
                    <div class="form-group vr-form">
                        <label for="message-text" style="font-size: 16px; " class=" col-form-label">Deskripsi</label>
                        <textarea type="text" class="form-control msgdeskripsi" name="deskripsi" id="deskripsi"> </textarea>
                    </div>

                    <div class="form-group vr-form">
                        <label for="message-text" style="font-size: 16px; " class=" col-form-label">Type Layanan</label>
                        <select name="type" id="service-type" class="form-control">
                            <option value="" selected disabled hidden>Pilih Type Quota</option>
                            <option value="0"> Quantity</option>
                            <option value="1"> Durasi Waktu</option>
                        </select>
                    </div>

                    <div id="quantity-input" class="form-group vr-form" style=" display: none;">
                        <label  for="message-text" style="font-size: 16px;" class=" col-form-label">Quantity</label>
                        <input type="number" class="form-control msgqtyoption" name="qtyoption" min="1" value="1" max="99" id="qtyoption">
                    </div>
                    <div id="duration-input" class="form-group vr-form" style="display: none;">
                        <label for="duration" style="font-size: 16px;" class="col-form-label">Durasi</label>
                        <select id="duration" name="durasi" class="form-control">
                            <option value="" selected disabled hidden>Pilih Durasi</option>
                            <!-- <option value="<?php echo date('Y-m-d', strtotime('+6 day')); ?>">1 Minggu</option>
                            <option value="<?php echo date('Y-m-d', strtotime('+13 day')); ?>">2 Minggu</option>
                            <option value="<?php echo date('Y-m-d', strtotime('+20 day')); ?>">3 Minggu</option>
                            <option value="<?php echo date('Y-m-d', strtotime('+29 day')); ?>">1 Bulan</option> -->
                             <option value="7">1 Minggu</option>
                            <option value="14">2 Minggu</option>
                            <option value="21">3 Minggu</option>
                            <option value="30">1 Bulan</option>
                        </select>
                    </div>


                    <div id="harga-input" class="form-group vr-form">
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
    <form id="editlayanan">

        <div class="modal-dialog	modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body edit-layanan">
                    <div class="modal-body">
                        <div class="form-group vr-form">
                            <label for="recipient-name" style="font-size: 16px; " class=" col-form-label">Nama Layanan:</label>
                            <input type="text" class="form-control msglayanan" name="layanan" id="namalayanan">
                            <input type="hidden" class="form-control " name="uniq" id="ind">
                        </div>
                        @csrf
                        <div class="form-group vr-form">
                            <label for="message-text" style="font-size: 16px; " class=" col-form-label">Deskriptsi</label>
                            <textarea type="text" class="form-control msgdeskripsi" name="deskripsi" id="editdeskripsi"> </textarea>
                        </div>
                        <div class="form-group vr-form">
                            <label for="message-text" style="font-size: 16px; " class=" col-form-label">Harga</label>
                            <input type="number" class="form-control msgharga" name="harga" id="editharga">
                        </div>
                        <div class="form-group vr-form">
                            <label for="message-text" style="font-size: 16px; " class=" col-form-label">Diskon</label>
                            <input type="number" class="form-control msgdiskon" name="diskon" id="editdiskon">
                        </div>
                        <div class="form-group vr-form">
                            <label for="message-text" style="font-size: 16px; " class=" col-form-label">Qty</label>
                            <input type="number" class="form-control msgqtyoption" name="qtyoption" min="1" value="1" max="99" id="editqtyoption">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">batal</button>
                    <button type="submit" class="btn btn-primary resetFalse" form="editlayanan">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>



@endsection