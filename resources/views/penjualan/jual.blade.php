@extends('layouts.app')
@section('script')
<script>
    function disableDates() {
        var inputDate = document.getElementById("inpdate");
        var disabledDates = ["2023-06-15", "2023-06-20", "2023-06-25"]; // Tanggal yang ingin dinonaktifkan

        inputDate.addEventListener("input", function() {
            var selectedDate = inputDate.value;
            if (disabledDates.includes(selectedDate)) {
                inputDate.value = ""; // Menghapus tanggal yang tidak diizinkan
                alert("Tanggal ini tidak tersedia untuk dipilih. Silakan pilih tanggal lain.");
            }
        });
    }
</script>
@endsection
@section('title')
Data Penjualan -
@endsection
@section('content')
@csrf

<div class="smw-card">
    <div class=" row">
        <div class="col-lg-12 col-md-12">
            <div class="smw-card-header"> <i class="fa fa-wpforms mr-1 i-orange" aria-hidden="true"></i>
                Data Penjualan
            </div>
            <div class="d-flex justify-content-end mt-2 mr-2">
                <input type="text" class="d-inline  search-value mr-1" placeholder="Type to search">
                <button class=" mr-1 btn-icon btn btn-light vr-search" data-val="" data-add="searchjual"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
            <div class="col-sm-12 d-flex justify-content-center">
                @if(session('success'))
                <h3 class="text-dark">{{session('success')}}</h5>
                    @endif
            </div>
            <div class="smw-card-body dataTiket table-responsive">
                {!! $tiket !!}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function refreshData(res) {
        $('.dataTiket').html(res);
    }

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
    $(document).on('click', '.cemail', function(event) {
        $('#name').val($(this).data('name'));
        $('#email').val($('.' + $(this).data('id')).text());
        $('#dataid').val($(this).data('id'));
    })
    $(document).on('click', '.save', function(e) {
        const id = $('#dataid').val();
        doReq('cemail/' + id, {
            "_token": "{{ csrf_token() }}",
            "email": $('#email').val()
        }, function(e) {
            e ? $('.' + id).text($('#email').val()) : '';
        })
    })
</script>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ganti Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class=" ">
                    <input type="hidden" id="dataid" value="">
                    <div class="form-group">
                        <label for="recipient-name" style="font-size: 16px; " class=" col-form-label">Pembeli:</label>
                        <input type="text" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label for="message-text" style="font-size: 16px; " class=" col-form-label">Email:</label>
                        <input type="text" class="form-control" id="email">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">batal</button>
                <button type="button" class="btn btn-primary save" data-dismiss="modal">save</button>
            </div>
        </div>
    </div>
</div>

@endsection