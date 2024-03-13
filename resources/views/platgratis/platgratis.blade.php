@extends('layouts.app')
@section('script')

@endsection
@section('title')
Plat Gratis
@endsection
@section('content')
@csrf

<div class="smw-card">
    <div class=" row">
        <div class="col-lg-12 col-md-12">
            <div class="smw-card-header"> <i class="fa fa-wpforms mr-1 i-orange" aria-hidden="true"></i>
                Plat Gratis
            </div>
            <div class="d-flex justify-content-end mt-2 mr-2">
                <input type="text" class="d-inline  search-value mr-1" placeholder="Type to search">
                <button class=" mr-1 btn-icon btn btn-light vr-search" data-val="" data-add="searchplatgratis"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
            <div class="col-sm-12 d-flex justify-content-center">
                @if(session('success'))
                <h3 class="text-dark">{{session('success')}}</h5>
                    @endif
            </div>
            <div class="smw-card-body  table-responsive">
            @if(auth()->user()->role =="Admin")
                <button class="btn btn-orange" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus" aria-hidden="true"></i> Tambah</button>
            @endif

                <div class="dataPlat mt-2">
                    {!! $platgratis !!}
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
        $("#editplat").val(ini.data("name"))
        $("#ind").val(ini.data("ind"))

    })
</script>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="addplatgratis">

        <div class="modal-dialog	modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="plat" style="font-size: 16px; " class=" col-form-label">Nomor PLAT:</label>
                        <input type="text" class="form-control msgplat" name="plat" id="plat">
                    </div>
                    @csrf
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">batal</button>
                    <button type="submit" class="btn btn-primary resetFalse" form="addplatgratis">save</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <form id="editplatgratis">

        <div class="modal-dialog	modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body edit-platgratis">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="plat" style="font-size: 16px; " class=" col-form-label">Nomor PLAT:</label>
                            <input type="text" class="form-control msgplat" name="plat" id="editplat">
                            <input type="hidden" class="form-control " name="uniq" id="ind">

                        </div>
                        @csrf
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">batal</button>
                    <button type="submit" class="btn btn-primary resetFalse" form="editplatgratis">save</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection