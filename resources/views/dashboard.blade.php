@extends('layouts.app')
@section('title')
Settings - SmartWax
@endsection
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
@section('content')
@if(auth()->user()->role =="Admin")
<div class="smw-card">
    <div class=" row">
        <div class="col-lg-5 col-md-5">
            <div class="smw-card-header"> <i class="fa fa-wpforms mr-1 i-orange" aria-hidden="true"></i>
                Tambah Pengguna
            </div>
            <div class="msg1" style="display:none;">
            </div>
            <div class="smw-card-body ">

                <form action="" id="adduser">
                    @csrf
                    <div id="errorContainer" style="display: none;">
                        <ul id="errorList"></ul>
                    </div>
                    <div class="form-group vr-form row">
                        <div class="col">
                            <label style="font-size: 16px;" for="name">Nama:</label>
                            <input type="text" class="form-control msgname" id="name" name="name">
                        </div>
                        <div class="col">
                            <label style="font-size: 16px;" for="email">Email:</label>
                            <input type="email" class="form-control msgemail" id="email" name="email">
                        </div>
                    </div>

                    <div class="form-group vr-form">
                        <label style="font-size: 16px;" for="role">Role:</label>
                        <select class="form-control msgrole" id="role" name="role">
                            <option value="Admin">Admin</option>
                            <option value="Staff">Staff</option>
                        </select>
                        <div class="help-block  f12  text-danger with-errors jtt"></div>
                    </div>
                    <div class="form-group vr-form">
                        <button class="btn btn-orange resetFalse" name="submit" type="submit">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-7 col-md-7">
            <div class="smw-card-header"> <i class="fa fa-wpforms mr-1 i-orange" aria-hidden="true"></i>
                Data Pengguna
            </div>
            <div class="smw-card-body data-user table-responsive">
                {!! $users !!}
            </div>
        </div>

    </div>

</div>
@endif
<div class="smw-card">
    <div class="col-lg-6 col-md-6">
        <div class="smw-card-header"> <i class="fa fa-wpforms mr-1 i-orange" aria-hidden="true"></i>
            Ubah Password
        </div>
        <div class="smw-card-body">
            <div class="msg" style="display:none;">
            </div>
            <form action="" id="cpass">
                @csrf
                <div id="errorContainer" style="display: none;">
                    <ul id="errorList"></ul>
                </div>
                <div class="form-group vr-form">
                    <label style="font-size: 16px;" for="passwordlama">Password:</label>
                    <input type="password" class="form-control msgpasswordlama" id="passwordlama" name="passwordlama">

                </div>
                <div class="form-group vr-form row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <label style="font-size: 16px;" for="passbaru">Password Baru:</label>
                        <input type="password" class="form-control msgpassbaru" id="passbaru" name="passbaru">
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <label style="font-size: 16px;" for="cpassbaru">Konfirmasi Password Baru:</label>
                        <input type="password" class="form-control msgcpassbaru" id="cpassbaru" name="cpassbaru">
                    </div>
                </div>
                <div class="form-group vr-form">
                    <button class="btn btn-orange resetFalse" name="submit" type="submit">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    function refreshData(res) {
        const fs = $('.msg');
        if (res.status) {
            if (res.parent == ".data-user") {
                $(res.parent).html(res.data)
            } else {
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: res.data,
                        timer: 2000,
                        buttons: false,
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: res.data,
                        timer: 2000,
                        buttons: false,
                    })
                }
            }
        }
    }
</script>
@endsection