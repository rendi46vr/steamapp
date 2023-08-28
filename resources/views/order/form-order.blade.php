@extends('layouts.app')
@section("scripts")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endsection
@section('content')
<?php
function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
} ?>
<form id="order">
    @csrf
    <input type="hidden" name="uniq" value="sdndnfmfqw ehieknklsaudv19823h">
    <div class="smw-card">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="smw-card-header"> <i class="fa fa-wpforms mr-1 i-orange" aria-hidden="true"></i>
                    Info Pelanggan
                </div>
                <div class="smw-card-body pt-2">
                    <div class="form-group">
                        <label for="">Nama Lengkap</label>
                        <input type="text" name="name" id="" class="form-control msgname" placeholder="Nama Anda" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label for="">Nomor Whatsapp</label>
                        <input type="text" name="wa" id="" class="form-control msgwa" placeholder="+62 ......" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" id="" class="form-control msgemail" placeholder="example@email.com" aria-describedby="helpId">
                    </div>

                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="smw-card-header"> <i class="fa fa-wpforms mr-1 i-orange" aria-hidden="true"></i>
                    Info Kendaraan
                </div>
                <div class="smw-card-body pt-2">
                    <div class="form-group">
                        <label for="">Jenis Kendaraan</label>
                        <input type="text" name="jenis_kendaraan" id="" class="form-control msgjenis_kendaraan" placeholder="Nama Anda" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label for="">No. Plat Kendaraan</label>
                        <input type="text" name="plat" id="" class="form-control msgplat" placeholder="+62 ......" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label for="">Layanan tambahan</label>
                        <select name="layanan_tambahan" data-actions-box="true" class="form-control msglayanan selectpicker" multiple>
                            <option value="perawatan_interior">Perawatan Interior</option>
                            <option value="poles_ban">Poles Ban</option>
                            <option value="pembersihan_mesin">Pembersihan Mesin</option>
                            <option value="detailing_eksterior">Detailing Eksterior</option>
                            <option value="treatment_kaca">Treatment Kaca</option>
                            <option value="layanan_antirayap_karat">Layanan Antirayap & Karat</option>
                            <option value="layanan_antifogging">Layanan Antifogging</option>
                            <option value="layanan_pengharum_mobil">Layanan Pengharum Mobil</option>
                            <option value="layanan_khusus_interior">Layanan Khusus Interior</option>
                            <option value="layanan_penghilang_baret">Layanan Penghilang Baret</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <button class="btn btn-orange mb-4 resetFalse" type="submit">Proses</button>
            </div>

        </div>


    </div>

    </div>
</form>
<script type="text/javascript">
    function refreshData(res) {
        if (res.status) {
            window.location.href = res.href
        } else {
            c('something wrong there')
        }
    }
</script>
@endsection