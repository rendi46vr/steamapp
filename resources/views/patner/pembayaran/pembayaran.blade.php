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
            @if(auth()->user()->role == 'Patner') 
                <div class="alert alert-info pb-0 mt-2 mb-1" role="alert">
                    <p> NOTE : Input pembayaran dapat dilakukan ketika Hutang lebih dari 0 Rupiah. Total Hutang Anda saat ini {{$user->hutang()}}</p>
                </div>

            @endif
            <div class="smw-card-body  table-responsive">
                @if(auth()->user()->role == 'Patner') 
                <button class="btn btn-orange" @if($user->hutang > 0) data-toggle="modal" data-target="#exampleModal" @else disabled @endif><i class="fa fa-plus" aria-hidden="true"></i> Input Pembayaran</button>
                @endif
            
                <div class="dataPembayaran mt-2">
                    {!! $riwayat!!}
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
</script>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="pembayaran/request">
        <div class="modal-dialog	modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pembayaran </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  
                    @csrf
                    @if(@auth()->user()->role == 'Patner')
                    <table class="table table-striped">
                        <tr>
                            <th>Nama</th>
                            <td>{{$user->nama_patner}}</td>
                        </tr>
                        <tr>
                            <th>Total Hutang</th>
                            <td>{{$user->hutang()}}</td>
                        </tr>
                    </table>
                    @endif
                    @if(auth()->user()->role == 'Patner')
                    <input type="hidden" name="patner_id" value="{{$user->id}}">
                    @endif
                    <div id="quantity-input" class="form-group vr-form" >
                        <label  for="message-text" style="font-size: 16px;" class=" col-form-label">Bank</label>
                        <input type="text" class="form-control msgbank" name="bank" placeholder=" Mandiri..."  id="bank">
                    </div>
                    <div id="quantity-input" class="form-group vr-form" >
                        <label  for="message-text" style="font-size: 16px;" class=" col-form-label">No. Rekening</label>
                        <input type="text" class="form-control msgnorek" name="norek" placeholder="contoh : 1981 8129 1231 123" min="1"  id="norek">
                    </div>
                    <div id="quantity-input" class="form-group vr-form" >
                        <label  for="message-text" style="font-size: 16px;" class=" col-form-label">Atas Nama</label>
                        <input type="text" class="form-control msgatas_nama" name="atas_nama" placeholder="A/n ..." id="norek">
                    </div>
                    <div id="quantity-input" class="form-group vr-form" >
                        <label  for="message-text" style="font-size: 16px;" class=" col-form-label">Masukan Nominal Bayar</label>
                        <input type="number" class="form-control msgjumlah" name="jumlah" placeholder="contoh : 3000...." id="jumlah">
                    </div>

                    <div id="harga-input" class="form-group vr-form">
                        <label for="message-text" style="font-size: 16px; " class=" col-form-label">Upload Bukti Bayar</label>
                        <input type="file" class="form-control msgbukti" name="bukti"  id="bukti">
                    </div>
                    <div id="harga-input" class="form-group vr-form">
                        <label for="message-text" style="font-size: 16px; " class=" col-form-label">Keterangan lainnya</label>
                        <textarea type="text" placeholder="..." class="form-control msgket" requried name="ket" id="ket"> </textarea>
                    </div>
                    <div class="alert alert-info" role="alert">
                        <p> NOTE : Pastikan data yang anda masukan benar dan lengkap. Setelah Submit data bukti akan dicek terlebih dahulu untuk keaslian pembayaran</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">batal</button>
                    <button type="submit" class="btn btn-primary resetFalse withfile" form="pembayaran/request">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="pembayaran/request">
        <div class="modal-dialog	modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail  </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th colspan="2" id="patnerModal" style="text-align: center;"></th>
                        </tr>
                        <tr>
                            <th>Nomor Referensi</th>
                            <td id="norefModal"></td>
                        </tr>
                        <tr>
                            <th>Bank</th>
                            <td id="bankModal"></td>
                        </tr>
                        <tr>
                            <th>Nomor Rekening</th>
                            <td id="norekModal"></td>
                        </tr>
                        <tr>
                            <th>Atas Nama</th>
                            <td id="atas_namaModal"></td>
                        </tr>
                        <tr>
                            <th>Nominal Bayar</th>
                            <td id="jumlahModal"></td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <td id="tglModal"></td>
                        </tr>
                        <tr>
                            <th>Bukti Bayar</th>
                            <td id="buktiModal"></td>
                        </tr>
                        <tr>
                            <th>Jumlah Hutang Saat Bayar</th>
                            <td id="hutangModal"></td>
                        </tr>
                        <tr>
                            <th>status</th>
                            <td id="statusModal"></td>
                        </tr>

                    </table>
            </div>
        </div>
</div>

<script type="text/javascript">
    function refreshData(res) {
        $(res.parent).html(res.data);
    }
    // $("input[type=checkbox]").on("click", getChecked);
    @if(auth()->user()->role == 'Patner')
        $(document).on('click', ".batalkan", function() {
            let ini = $(this)
            Swal.fire({
                title: 'Batalkan Pengajuan?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Batal!',
                cancelButtonText: 'Tidak!'
            }).then((result) => {
                if (result.isConfirmed) {
                    doReq('pembayaran/batal/' + ini.data("ind"), null, function(res) {
                    if(res.success) {
                        $(res.parent).html(res.data);
                    }
                })
                }
            })
            
        })
    @else
    $(document).on('click', ".setujui", function() {
            let ini = $(this)
            Swal.fire({
                title: 'Setujui Pembayaran?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Tidak!'
            }).then((result) => {
                let status = -1
                if (result.isConfirmed) {
                    status = 1;
                }
                doReq('pembayaran/setuju/' + ini.data("ind"), {_token:tkn(),'status': status}, function(res) {
                    if(res.success) {
                        $(res.parent).html(res.data);
                    }
                })
            })
            
        })
    @endif

    function searchData() {
        var data = {
            _token: tkn(),
            search: $(".search-value").val(),
        }
        return data;
    }

    //modal detail
    $(document).on('click', 'a[data-toggle="modal"]', function() {
        var noref = $(this).data('noref');
        var tgl = $(this).data('tgl');
        var bank = $(this).data('bank');
        var norek = $(this).data('norek');
        var atasNama = $(this).data('atas-nama');
        var jumlah = $(this).data('jumlah');
        var bukti = $(this).data('bukti');
        var hutang = $(this).data('hutang');
        var status = $(this).data('status');
        var patner = $(this).data('patner');

        $('#norefModal').text(noref);
        $('#tglModal').text(tgl);
        $('#bankModal').text(bank);
        $('#norekModal').text(norek);
        $('#atas_namaModal').text(atasNama);
        $('#jumlahModal').text(jumlah);
        $('#hutangModal').text(hutang);
        $('#patnerModal').text(patner);
        $('#buktiModal').html('<a href="' + bukti + '" target="_blank">Lihat Bukti</a>');
        $('#statusModal').html(status);
    });

</script>
@endsection

