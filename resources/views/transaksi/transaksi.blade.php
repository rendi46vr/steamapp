@extends('layouts.app')
@section('script')

@endsection
@section('title')
Data Transaksi
@endsection
@section('content')
@csrf

<div class="smw-card">
    <div class=" row">
        <div class="col-lg-12 col-md-12">
            <div class="smw-card-header"> <i class="fa fa-wpforms mr-1 i-orange" aria-hidden="true"></i>
                Data Transaksi
            </div>
            <div class="d-flex col-12 justify-content-end mt-2 mr-2">
                <div class="form-group">
                    <input style="height: 38px;" type="date" name="first" id="first" class="form-control">
                </div>
                <div class="form-group">
                    <input style="height: 38px;" type="date" name="end" id="end" class="form-control">
                </div>
                <div class="form-group">
                    <input style="height: 38px;" type="text" class="d-inline form-control  search-value mr-1" placeholder="Type to search">
                </div>
                <div class="form-group">
                    <button class=" mr-1 btn-icon btn btn-orange vr-search" data-val="" data-add="searchtransaksi"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="col-sm-12 d-flex justify-content-center">
                @if(session('success'))
                <h3 class="text-dark">{{session('success')}}</h5>
                    @endif
            </div>
            <div class="smw-card-body dataTiket table-responsive">
                {!! $transaksi !!}
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
            first: $("#first").val(),
            end: $("#end").val(),
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