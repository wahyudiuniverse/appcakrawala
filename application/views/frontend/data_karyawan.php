<!-- <pre>
    <?php //print_r($_SESSION); 
    ?>
</pre> -->

<!-- start page title -->
<!-- <div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Data Kandidat</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="kandidat">Kandidat</a></li>
                    <li class="breadcrumb-item active">Data Kandidat</li>
                </ol>
            </div>

        </div>
    </div>
</div> -->
<!-- end page title -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">List Data Karyawan</h5>
                    <button hidden id="button_download_data" class="btn btn-success btn-block">Download Data</button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="kandidat-datatables" class="display table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>AKSI</th>
                                <th>STATUS</th>
                                <th>NIP</th>
                                <th>NIK</th>
                                <th>NAMA LENGKAP</th>
                                <th>PROJECT</th>
                                <th>SUB PROJECT</th>
                                <th>JABATAN</th>
                                <th>PENEMPATAN</th>
                                <th>PERIODE KONTRAK</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><!--end row-->

<!-- Tombol Open Profile -->
<script type="text/javascript">
    function open_profile(nip) {
        alert("Under Construction.\nNIP Karyawan: " + nip);
        // window.open("<?= base_url() ?>profile/" + id_kandidat, "_blank");
    }
</script>

<script type='text/javascript'>
    var tabel_kandidat;
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
        csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    var identifier = '<?php echo $identifier; ?>';

    // execute kalau page sudah ke load 
    $(document).ready(function() {
        //inisialisasi select2 untuk searchable dropdown
        $('.dropdown-dengan-search').select2({
            width: '100%'
        });

        // alert(identifier);
        // alert(jabatan);
        // alert(region);
        // alert(rekruter);

        //populate data tabel
        if (identifier == "" || identifier == null) {

        } else {
            tabel_kandidat = $('#kandidat-datatables').DataTable({
                //"bDestroy": true,
                'processing': true,
                'serverSide': true,
                // 'stateSave': true,
                'bFilter': true,
                'serverMethod': 'post',
                // 'dom': 'lBfrtip',
                'dom': 'lfrtip',
                'buttons': ["copy", "csv", "excel", "print", "pdf"],
                'order': [
                    [4, 'asc']
                ],
                'ajax': {
                    'url': '<?= base_url() ?>Data_karyawan/list_employees',
                    data: {
                        [csrfName]: csrfHash,
                        identifier: identifier,
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert("Status :" + xhr.status);
                        alert("responseText :" + xhr.responseText);
                    },
                },
                'columns': [{
                        data: 'aksi',
                        "orderable": false
                    },
                    {
                        data: 'status_resign',
                        // "orderable": false,
                        //searchable: true
                    },
                    {
                        data: 'employee_id',
                        // "orderable": false,
                    },
                    {
                        data: 'ktp_no',
                        // "orderable": false,
                        //searchable: true
                    },
                    {
                        data: 'first_name',
                        // "orderable": false,
                        //searchable: true
                    },
                    {
                        data: 'project_id',
                        "orderable": false
                    },
                    {
                        data: 'sub_project_id',
                        "orderable": false
                    },
                    {
                        data: 'designation_id',
                        "orderable": false,
                    },
                    {
                        data: 'penempatan',
                        // "orderable": false,
                    },
                    {
                        data: 'periode_kontrak',
                        "orderable": false,
                    },
                ]
            });
            // }).on('search.dt', () => eventFired('Search'));
        }

    });
</script>

<script type="text/javascript">
    document.getElementById("button_download_data").onclick = function(e) {
        var project = document.getElementById("project_input").value;
        var jabatan = document.getElementById("jabatan_input").value;
        var region = document.getElementById("region_input").value;
        var rekruter = document.getElementById("rekruter_input").value;
        var range_tanggal = document.getElementById("range_tanggal").value;
        // var project = document.getElementById("aj_project").value;
        // var sub_project = document.getElementById("aj_sub_project").value;
        // var status = document.getElementById("status").value;

        // // ambil input search dari datatable
        // var filter = $('.dataTables_filter input').val(); //cara 1
        var searchVal = $('#kandidat-datatables_filter').find('input').val(); //cara 2

        if (searchVal == "") {
            searchVal = "-no_input-";
        }

        if (range_tanggal == "") {
            range_tanggal = "0";
        }

        // var text_pesan = "Project: " + project;
        // text_pesan = text_pesan + "\njabatan: " + jabatan;
        // text_pesan = text_pesan + "\nregion: " + region;
        // text_pesan = text_pesan + "\nrekruter: " + rekruter;
        // text_pesan = text_pesan + "\nrange_tanggal: " + range_tanggal;
        // text_pesan = text_pesan + "\nSearch: " + searchVal;
        // alert(text_pesan);
        window.open('<?php echo base_url(); ?>admin/kandidat/printExcel/' + project + '/' + jabatan + '/' + region + '/' + rekruter + '/' + range_tanggal + '/' + searchVal + '/', '_self');

    };
</script>

<script>
    // function initializeTables() {
    //     new DataTable("#kandidat-datatables", {
    //         dom: "lBfrtip",
    //         buttons: ["copy", "csv", "excel", "print", "pdf"],
    //     });
    // }

    // document.addEventListener("DOMContentLoaded", function() {
    //     initializeTables();
    // });
</script>