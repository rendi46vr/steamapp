@extends('template.main')

@section('content')
    <div id="app">
        <!-- Page Heading -->
        <div class="row mb-4">
            <div class="col-md-6 d-flex justify-content-start">
                <h3 class="page-title me-3">{{ $page_title }}</h3>
            </div>
            <div class="col-md-6 d-flex justify-content-end">

            </div>
        </div>

        <div class="p-2 my-4 bg-card-custom card mb-0">
            <div class="card-body bg-white rounded">
                <form method="GET" class="w-100">
                    <div class="form-search w-100 mb-4">
                        <input type="search" name="searchTable" id="searchTable" class="form-control" placeholder="Search" >
                        <i class="fas fa-search"></i>
                    </div>
                </form>

                <div class="table-responsive">
                    <table id="mainTable" class="table ti-table mb-0" cellspacing="0">
                        <thead>
                            <th style="min-width: 90px">Action</th>
                            <th>No</th>
                            <th style="min-width: 90px">View Document</th>
                            <th style="min-width: 90px">Status</th>
                            <th>Pengajuan</th>
                            <th>Berangkat</th>
                            <th>Kembali</th>
                            <th>Travel ID</th>
                            <th>Nomor SPPD</th>
                            <th>Nama</th>
                            <th>Nik</th>
                            <th>SPPD Type</th>
                            <th style="min-width: 150px">Lokasi</th>
                            <th>Dasar Perjalanan</th>
                            <th>Maksud / Tujuan / Tugas</th>
                            <th>Total SPPD</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="mLacakstatus2">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Lacak</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content">
                        <div class="form-group">
                            <small class="text-muted">Travel ID</small><br/>
                            <strong><input style="font-size:12px;display:block;border:none" id="travel-id2" readonly value="23110015678"></strong>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content">
                        <div class="form-group">
                            <small>Nomor SPPD</small> <br/>
                            <strong><input style="font-size:12px;display:block;border:none" id="sppd-number2" readonly value="23110015678"></strong>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:-30px">
                    <div class="col-md-12">
                        <hr/>
                    </div>
                </div>
                <div id="tracking-layer2"></div>
                <div class="row" style="margin-top:-10px">
                    <div class="col-md-12">
                        <hr/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 d-sm-flex align-items-center">
                        <label style="font-size:12px;">Nama</label>
                    </div>
                    <div class="col-8 d-sm-flex align-items-center">
                        <input class="form-control" style="font-size:12px;border:none;color:#222222" value="" id="fullname2">
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 d-sm-flex align-items-center">
                        <label style="font-size:12px;">Lokasi</label>
                    </div>
                    <div class="col-8 d-sm-flex align-items-center">
                        <input class="form-control" style="font-size:12px;border:none;color:#222222;width:500px" id="lokasi2">
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 d-sm-flex align-items-center">
                        <label style="font-size:12px;">Maksud - Tujuan</label>
                    </div>
                    <div class="col-8 d-sm-flex align-items-center">
                        <input class="form-control" style="font-size:12px;border:none;color:#222222" id="maksud2">
                    </div>
                </div>

            </div>

            <div class="modal-footer">
              <button  class="btn btn-sm btn-danger px-3" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
</div>



    <!-- Modal SPPD Deandra -->
<div class="modal fade" tabindex="-1" role="dialog" id="mLacak2">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Travel Request(SPPD) - Approval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small class="text-muted">Travel ID</small><br />
                            <strong><input style="font-size:12px;display:block;border:none" id="travel-id" readonly value="23110015678"></strong>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small>Nomor SPPD</small> <br />
                            <strong><input style="font-size:12px;display:block;border:none" id="sppd-number" readonly value="23110015678"></strong>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small class="text-muted">Tgl. SPPD</small><br />
                            <strong><input style="font-size:12px;display:block;border:none" id="tgl-sppd" readonly value="23110015678"></strong>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small>PIC</small> <br />
                            <strong><input style="font-size:12px;display:block;border:none" id="pic" readonly value="23110015678"></strong>
                        </div>
                    </div>
                </div>


                <div class="row" style="margin-top:-10px">
                    <div class="col-md-12">
                        <hr />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small class="text-muted">Lokasi Dari</small><br />
                            <strong><input style="font-size:12px;display:block;border:none" id="lokasi-dari" readonly value="23110015678"></strong>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small>Lokasi Tujuan</small> <br />
                            <strong><input style="font-size:12px;display:block;border:none" id="lokasi-tujuan" readonly value="23110015678"></strong>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small class="text-muted">Tgl. Berangkat</small><br />
                            <strong><input style="font-size:12px;display:block;border:none" id="tgl-berangkat" readonly value="23110015678"></strong>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small>Tgl. Kembali</small> <br />
                            <strong><input style="font-size:12px;display:block;border:none" id="tgl-kembali" readonly value="23110015678"></strong>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small class="text-muted">Dasar Perjalanan</small><br />
                            <strong><input style="font-size:12px;display:block;border:none" id="dasar-perjalanan" readonly value="23110015678"></strong>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small>Maksud Tujuan</small> <br />
                            <strong><input style="font-size:12px;display:block;border:none" id="maksud-tujuan" readonly value="23110015678"></strong>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small class="text-muted">Durasi(hari)</small><br />
                            <strong><input style="font-size:12px;display:block;border:none" id="durasi" readonly value="23110015678"></strong>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content">
                        {{-- <div class="form-group">
                            <small>Dokumen Pendukung</small> <br/>
                            <strong><input style="font-size:12px;display:block;border:none" id="dokumen-pendukung" readonly value="23110015678"></strong>
                        </div> --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small class="text-muted">Tipe Perjalanan</small><br />
                            <strong><input style="font-size:12px;display:block;border:none" id="tipe-perjalanan" readonly value="23110015678"></strong>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small>Beban Anggaran</small> <br />
                            <strong><input style="font-size:12px;display:block;border:none" id="beban-anggaran" readonly value="23110015678"></strong>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small class="text-muted">Jenis Lumpsum</small><br />
                            <strong><input style="font-size:12px;display:block;border:none" id="jenis-lumpsum" readonly value="23110015678"></strong>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small>Pemeriksa 1</small> <br />
                            <strong><input style="font-size:12px;display:block;border:none" id="pemeriksa-1" readonly value="23110015678"></strong>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small class="text-muted">Pemeriksa 2</small><br />
                            <strong><input style="font-size:12px;display:block;border:none" id="pemeriksa-2" readonly value="23110015678"></strong>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small>Pemegang Budget</small> <br />
                            <strong><input style="font-size:12px;display:block;border:none" id="pemegang-budget" readonly value="23110015678"></strong>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small class="text-muted">Tipe SPPD</small><br />
                            <strong><input style="font-size:12px;display:block;border:none" id="tipe-sppd" readonly value="23110015678"></strong>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content">
                        <div class="form-group">
                            <small>IO Number</small> <br />
                            <strong><input style="font-size:12px;display:block;border:none" id="io-number" readonly value="23110015678"></strong>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:-10px">
                    <div class="col-md-12">
                        <hr />
                    </div>
                </div>
                <div class="row" style="margin-top:-10px">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table ti-table mb-0" cellspacing="0">
                                <thead>
                                    <th>Tarif Uang Harian</th>
                                    <th>Jumlah Hari</th>
                                    <th>Total Uang Harian</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="tarif-harian"></td>
                                        <td id="jumlah-hari"></td>
                                        <td id="total-harian"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <br>

                <div class="row" style="margin-top:-10px">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table ti-table mb-0" cellspacing="0">
                                <thead>
                                    <th>No</th>
                                    <th>Jenis Angkutan/ Hotel</th>
                                    <th>Tarif</th>
                                    <th>Qty</th>
                                    <th>Jumlah</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Total Uang Akomodasi</td>
                                        <td id="akomodasi-tarif"></td>
                                        <td id="akomodasi-qty"></td>
                                        <td id="akomodasi-jumlah"></td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Total Uang Harian</td>
                                        <td id="harian-tarif"></td>
                                        <td id="harian-qty"></td>
                                        <td id="harian-jumlah"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="3" style="color:red">Grand Total</td>
                                        <td style="color:red" id="grand-total"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:-10px">
                    <div class="col-md-12">
                        <hr />
                    </div>
                </div>
                <form id="titleForm2" method="post">
                    <label style="font-size:12px;color:red">Catatan Approval</label>
                    <textarea name="catatan" id="catatan" class="form-control" cols="30" rows="5"></textarea>
                    <small>*catatan approval (boleh dikosongkan)</small>

                    <input hidden name="travel_status_id" style="font-size:12px;color:#222222;width:500px" id="travel_status_id">
                    <input hidden name="pemegang_budget" style="font-size:12px;color:#222222;width:500px" id="pemegang_budget">
                    <input hidden name="pemeriksa1" style="font-size:12px;color:#222222;width:500px" id="pemeriksa1">
                    <input hidden name="pemeriksa2" style="font-size:12px;color:#222222;width:500px" id="pemeriksa2">
                    <input hidden name="jml_approval" style="font-size:12px;color:#222222;width:500px" id="jml_approval">
                    <input hidden name="travel_management_travel_id" style="font-size:12px;color:#222222;width:500px" id="travel_management_travel_id"><br>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-sm btn-danger px-3 tolakk">Reject</button>
                <button class="btn btn-sm btn-danger px-3 terimaa">Approve</button>
            </div>
        </div>
    </div>
</div>
@endsection
@include('approval.historysppddeandra.script')
