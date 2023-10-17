@extends('layouts.app')
@section('title')
Form Order
@endsection

@section('content')
<div class="ag-center">

    <div class="smw-card ">
        <div class=" row">
            <div class="msg1" style="display:none;">
            </div>
            <div class="smw-card-body">
                <h2 class="smid">
                    Scan Member ID Anda
                </h2>
                <!-- <div class="time">00:00 AM</div>
            <div class="hint">Scan QR Code untuk verifikasi</div> -->
                <!-- Ubah input menjadi readonly untuk kode tiket -->
                <input type="text" class="form-control member-code" value="" id="memberid">

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById('memberid').focus();
</script>
@endsection