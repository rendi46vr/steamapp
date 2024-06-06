@push('script')
    <script>
        $(document).ready(function() {
            getData();

        });

        $(document).on("click",".lacak",function(){

            let travelID = $(this).data('travel_id');

            getTrackingData(travelID);

            $("#mLacak").modal('show');

        });



        // Function to update the data table
        function getData() {
            var url      = "{{ route('approval.historysppddeandra.datatable') }}";
            var dataParam = {
                param: 'param'
            };

            sendAjaxGet(url, dataParam,
            function(resp) {
                datatables(resp.data);
            },
            function(err) {});
        }


        $(document).on("click",".lacakstatus2",function(){
        let travelID = $(this).data('travel_id');
        getTrackingDatastatusdeandra(travelID);
        $("#mLacakstatus2").modal('show');
    });
    function getTrackingDatastatusdeandra(travelID) {
        ti.showLoading();
            var url      = "{{ route('travel.sppd.trackingDeandra') }}/"+travelID;
            var dataParam = {
                param: 'param'
            };

            sendAjaxGet(url, dataParam,
            function(resp) {
                let count = resp.tracking.length;
                let htmTracking;
                let data = resp.tracking;
                let deandra = resp.deandra;
                let currentPos;
                let firstDateFound;

                console.log(data);

                $("#tracking-layer2").html('');


                $("#travel-id2").val(deandra.travel_id);
                $("#sppd-number2").val(deandra.no_sppd);
                $("#sppd-number2").val(deandra.no_sppd);
                $("#lokasi2").val(deandra.lokasi_dari +' - '+ deandra.lokasi_tujuan);
                $("#fullname2").val(resp.fullname);
                $("#maksud2").val(deandra.maksud_tujuan);
                console.log(deandra.maksud_tujuan)

                for(c=0; c < count; c++) {
                    if(data[c].date != '') {

                       if(firstDateFound == 0) {
                        firstDateFound = c;
                       }

                       console.log('fdf:' + firstDateFound);
                    }else{
                        firstDateFound = 0;
                }
                }


                currentPos = firstDateFound - 1;

                for(i=0; i < count; i++) {

                    htmTracking =   ' <div class="row">';
                    htmTracking +=  '     <div class="col-md-3">';
                    htmTracking +=  '     <small style="display:block;">'+data[i].date+'</small>';
                    htmTracking +=  '     <small style="display:block;margin-top:-3px">By '+data[i].updater+'</small>';
                    htmTracking +=  '   </div>';
                    htmTracking +=  '   <div class="col-md-1">';


                   if((i == currentPos)) {

                        htmTracking +=   '    <i class="fas fa-dot-circle fa-xs" style="color:red"></i>';

                   } else if(data[i].date == ''){

                         htmTracking +=   '     <i class="fas fa-circle fa-xs"></i>';

                   } else {

                        htmTracking +=   '    <i class="fas fa-check-circle fa-xs" style="color:lightcoral"></i>';

                   }



                    if(i != count-1) {

                        if(i == currentPos) {
                            htmTracking +=   '    <div class="vl" style="margin-left:5px;border-left:2px solid red;height:15px"></div>';
                        }else if(data[i].date == ''){
                            htmTracking +=   '    <div class="vl" style="margin-left:5px;border-left:2px solid grey;height:15px"></div>';
                        }else if(data[i].date !== '') {
                            htmTracking +=   '    <div class="vl" style="margin-left:5px;border-left:2px solid lightcoral;height:15px"></div>';
                        }

                    }

                    htmTracking +=   '  </div>';
                    htmTracking +=   '  <div class="col-md-8">';
                    htmTracking +=   '     <strong><label style="font-size:12px;display:block;color:#848484;">'+data[i].status+'</label></strong>';
                    htmTracking +=   '     <label style="font-size:10px;display:block;margin-top:-10px;color:#848484">'+data[i].note+'</label>';
                    htmTracking +=   ' </div>';

                    $("#tracking-layer2").append(htmTracking);
                }
                ti.hideLoading();
            },
        function(err) {});
    }



        function datatables(data) {
            if ($.fn.DataTable.isDataTable("#mainTable")) {
                $("#mainTable").DataTable().destroy();
            }

            var table = $("#mainTable").DataTable({
                data        : data,
                destroy     : true,
                serverside  : true,
                processing  : true,
                scrollX     : true,
                fixedColumns: {
                    leftColumns: 4,
                },
                dom: "<'myfilter'f><'mylength'l>Btip",
                buttons: [{
                    className: "btn btn-primary",
                    text: 'Export',
                    extend: 'excelHtml5',
                    title: 'List of SPPD',
                    exportOptions: {
                        columns: [1, 3, 4, 5, 6, 7, 8, 9, 10]
                    }
                }],
                "columns": [
                    {"data": "no"},
                    {"data": "no"},
                    {"data": "no"},
                    {"data": "status"},
                    {"data": "tgl_submit"},
                    {"data": "tgl_berangkat"},
                    {"data": "tgl_kembali"},
                    {"data": "travel_id"},
                    {"data": "nomor_sppd"},
                    {"data": "pic_nama"},
                    {"data": "pic_nik"},
                    {"data": "travel_type"},
                    {"data": "lokasi"},
                    {"data": "dasar_perjalanan"},
                    {"data": "maksud_tujuan"},
                    {"data": "total_sppd"}
                ],
                rowCallback: function(nRow, aData, iDisplayIndex) {
                    var modifiedString = aData.sppdDoc.replace(/"/g, "'");

                    var editButton = '';

                    editButton += '<br><a href="#" class="mx-auto lacakstatus2" data-travel_id="'+aData.travel_id+'"><img src="{{ asset("icons/lacak.svg") }}">Lacak</a>';

                    var docButton = '<a href="{{ url("travel/sppd/pdf") }}/' + aData.travel_id + '" class="mx-auto" target="_blank"><img src="{{ asset("icons/document.svg") }}">  Lihat</a> <br>';
                    docButton += '<a href="' + aData.sppdDoc + '" class="icon-info-detail mr-3">';
                    docButton += '<img src="{{ asset("icons/attachment.svg") }}"> Attachment';
                    docButton += '</a>';

                    $('td:eq(0)', nRow).html(editButton);
                    $('td:eq(2)', nRow).html(docButton);
                }

            });

            $(document).on('click', '#btn-export', function() {
                $('.buttons-excel').click()
            });

            $('#searchTable').keyup(function(){
                table.search($(this).val()).draw() ;
            })
        }


    </script>
@endpush
