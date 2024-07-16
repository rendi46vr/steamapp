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
            <div class="smw-card-body  table-responsive">
                <div class="dataPatner mt-2">
                    <input type="hidden" name="patner_id" id="patner_id" value="{{$patner->id}}">
                    @foreach($layanan as $l)
                    <div class="form-check form-check mb-3 ">
                        <input id="laynanpatner{{$l->id}}" class="form-check-input checkbox-lg" @if(in_array($l->id, $layananIds)) Checked  @endif type="checkbox" name="layanan_id" value="{{$l->id}}" />
                        <label for="laynanpatner{{$l->id}}" class="form-check-label b-600" style="margin-left:10px;">{{$l->layanan}}</label>
                    </div>
                    @endforeach
                    <div class="form-group mt-5">
                        <button type="button" class="btn btn-orange simpan">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            <i class="fa fa-save mr-1"></i> Simpan Layanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function refreshData(res) {
        $(res.parent).html(res.data);
    }

    function checkedData() {
        var checked = [];
        $("input[name='layanan_id']:checked").each(function() {
            checked.push($(this).val());
        });
        var button = $(".simpan");
        var spinner = button.find(".spinner-border");

        button.prop('disabled', true);
        spinner.removeClass('d-none');
        button.find("i").addClass('d-none');
        // c(checked);
        doReq('patner/layanan/{{$patner->id}}', {
            _token: "{{ csrf_token() }}",
            tambahan: checked,
            patner_id: $('#patner_id').val(),
        }, (res) => {
            // if (res.status) {
            //     $(".table-order").html(res.data);
            // }
            if(res.status){
                Swal.fire(
                        'Sukses!',
                        "Berhasil Disimpan",
                        'success'
                    )
            }
            button.prop('disabled', false);
            spinner.addClass('d-none');
            button.find("i").removeClass('d-none');
        })
        return checked;
    }
    $(".simpan").on("click", checkedData);
</script>

@endsection