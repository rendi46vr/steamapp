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
                <div class="dataPatner mt-2">
                    {!! $patner !!}
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
        doReq('patner/lstatus/' + ini.attr("id"), null, function(res) {
            ini.parent().html(res);
        })
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
        $("#editnama_patner").val(ini.data("name"))
        $("#editnowa").val(ini.data("nowa"))
        $("#editalamat").val(ini.data("alamat"))
        $("#editemail").val(ini.data("email"))
        $("#id_target").val(ini.data("ind"))

    })
    $(document).ready(function() {
        $('#service-type').change(function() {
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

    $(".sendBill").on("click", function(){
       return confirm("Kirim Tagihan ke "+$(this).data("name")+"?","Tagihan Berhasil Dikirim","Tagihan Gagal Dikirim","kirimtagihan/"+$(this).data("ind")),(res)=>{

       };
    })

</script>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="patner/addpatner">

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
                        <label for="recipient-name" style="font-size: 16px; " class=" col-form-label">Nama Patner:</label>
                        <input type="text" class="form-control msgnama_patner" placeholder="Patner ... " name="nama_patner" id="nama_patner">
                    </div>
                    @csrf
                    <div class="form-group vr-form">
                        <label for="message-text" style="font-size: 16px; " class=" col-form-label">Nomor Whastapp</label>
                        <input type="number" placeholder="0812231..." class="form-control msgnowa" name="nowa" id="nowa"> </input>
                    </div>

                    <div id="quantity-input" class="form-group vr-form" >
                        <label  for="message-text" style="font-size: 16px;" class=" col-form-label">Email</label>
                        <input type="email" class="form-control msgemail" name="email" placeholder="example@gmail.com" min="1"  id="email">
                    </div>

                    <div id="harga-input" class="form-group vr-form">
                        <label for="message-text" style="font-size: 16px; " class=" col-form-label">Alamat</label>
                        <textarea type="text" placeholder="alamat..." class="form-control msgalamat" requried name="alamat" id="alamat"> </textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">batal</button>
                    <button type="submit" class="btn btn-primary resetFalse" form="patner/addpatner">Tambah</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <form id="patner/editpatner">

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
                        <label for="recipient-name" style="font-size: 16px; " class=" col-form-label">Nama Patner:</label>
                        <input type="text" class="form-control msgnama_patner" placeholder="Patner ... " name="nama_patner" id="editnama_patner">
                        <input type="hidden"  placeholder="Patner ... " name="uniq" id="id_target">
                    </div>
                    @csrf
                    <div class="form-group vr-form">
                        <label for="message-text" style="font-size: 16px; " class=" col-form-label">Nomor Whastapp</label>
                        <input type="number" placeholder="0812231..." class="form-control msgnowa" name="nowa" id="editnowa"> </input>
                    </div>

                    <div id="quantity-input" class="form-group vr-form" >
                        <label  for="message-text" style="font-size: 16px;" class=" col-form-label">Email</label>
                        <input type="email" class="form-control msgemail" name="email" placeholder="example@gmail.com" min="1"  id="editemail">
                    </div>

                    <div  class="form-group vr-form">
                        <label for="message-text" style="font-size: 16px; " class=" col-form-label">Alamat</label>
                        <textarea type="text" placeholder="alamat..." class="form-control msgalamat" requried name="alamat" id="editalamat"></textarea>
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