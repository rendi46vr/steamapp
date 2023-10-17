@extends('layouts.app')
@section('script')

@endsection
@section('title')
Layanan Tambahan
@endsection
@section('content')
@csrf

<div class="smw-card">
    <div class=" row">
        <div class="col-lg-12 col-md-12">
            <div class="smw-card-header"> <i class="fa fa-wpforms mr-1 i-orange" aria-hidden="true"></i>
                Layanan Tambahan
            </div>
            <div class="d-flex justify-content-end mt-2 mr-2">
                <input type="text" class="d-inline  search-value mr-1" placeholder="Type to search">
                <button class=" mr-1 btn-icon btn btn-light vr-search" data-val="" data-add="searchlayanantambahan"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
            <div class="col-sm-12 d-flex justify-content-center">
                @if(session('success'))
                <h3 class="text-dark">{{session('success')}}</h5>
                    @endif
            </div>
            <div class="smw-card-body  table-responsive">
                <button class="btn btn-orange" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus" aria-hidden="true"></i> Tambah</button>
                <div class="dataTiket mt-2">
                    {!! $layanantambahan !!}
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function refreshData(res) {
        $(res.parent).html(res.data);
    }
    $(document).on('click', "input[type=checkbox]", function() {
        let ini = $(this)
        doReq('lbstatus/' + ini.attr("id"), null, function(res) {
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
        $("#editname").val(ini.data("name"))
        $("#editharga").val(ini.data("harga"))
        $("#ind").val(ini.data("ind"))
        $("#editdiskon").val(ini.data("diskon"))

    })
</script>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="addlayanantambahan">

        <div class="modal-dialog	modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Layanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" style="font-size: 16px; " class=" col-form-label">Nama Layanan:</label>
                        <input type="text" class="form-control msglayanan" name="layanan" id="layanan">
                    </div>
                    @csrf
                    <div class="form-group">
                        <label for="message-text" style="font-size: 16px; " class=" col-form-label">Harga</label>
                        <input type="number" class="form-control msgharga" name="harga" id="harga">
                    </div>
                    <div class="form-group">
                        <label for="message-text" style="font-size: 16px; " class=" col-form-label">Diskon</label>
                        <input type="number" class="form-control msgdiskon" name="diskon" id="diskon">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">batal</button>
                    <button type="submit" class="btn btn-primary" form="addlayanantambahan">Tambah</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <form id="editlayanantambahan">
        <div class="modal-dialog	modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Layanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body edit-layanan">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" style="font-size: 16px; " class=" col-form-label">Nama Layanan:</label>
                            <input type="text" class="form-control msglayanan" name="layanan" id="editname">
                            <input type="hidden" class="form-control " name="uniq" id="ind">
                        </div>
                        @csrf
                        <div class="form-group">
                            <label for="message-text" style="font-size: 16px; " class=" col-form-label">Harga</label>
                            <input type="number" class="form-control msgharga" name="harga" id="editharga">
                        </div>
                        <div class="form-group">
                            <label for="message-text" style="font-size: 16px; " class=" col-form-label">Diskon</label>
                            <input type="number" class="form-control msgdiskon" name="diskon" id="editdiskon">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">batal</button>
                    <button type="submit" class="btn btn-primary resetFalse" form="editlayanantambahan">save</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection