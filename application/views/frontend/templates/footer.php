<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>FORM REGISTRASI KARYAWAN &copy; SIPRAMA CAKRAWALA 2024</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script src="<?= base_url('assets/assets_registrasi/js/onkeyup_angka_huruf.js'); ?>" type="text/javascript"></script>
<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/assets_registrasi/vendor/jquery/jquery.min.js'); ?>"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/assets_registrasi/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

<!-- Template SB Admin -->
<script src="<?= base_url('assets/assets_registrasi/js/sb-admin-2.min.js'); ?>"></script>

<!-- On key up angka dan huruf -->
<!-- <script src="<?= base_url('assets/assets_registrasi/js/onkeyup_angka_huruf.js'); ?>" type="text/javascript"></script> -->

<!-- Date Picker -->
<script src="<?= base_url('assets/assets_registrasi/datepicker/gijgo.min.js'); ?>" type="text/javascript"></script>

<!-- Tombol Next di tab dokumen -->
<script type="text/javascript">
    document.getElementById("dokumen_next_button").onclick = function() {
        //konstruksi link tujuan
        var baseURL = "<?php echo base_url(); ?>";
        var pages = "<?php print($halaman); ?>";
        var nik = "<?php print($nik_url); ?>";
        var link_tujuan = "<?= base_url() ?>registrasi/addRegister/";
        var link_cancat = link_tujuan.concat("review", "/", nik);

        //cek apakah input mandatory sudah terisi?
        var ktp = "<?php print($register['ktp']); ?>";
        var kk = "<?php print($register['kk']); ?>";
        var ijazah = "<?php print($register['ijazah']); ?>";
        var cv = "<?php print($register['civi']); ?>";
        var pesan = "";
        //cek ktp
        if (ktp == "" || ktp == "0" || (!ktp.includes("/"))) {
            pesan = pesan.concat("Dokumen KTP masih kosong\n");
        }
        //cek kk
        if (kk == "" || kk == "0" || (!kk.includes("/"))) {
            pesan = pesan.concat("Dokumen KK masih kosong\n");
        }
        //cek ijazah
        if (ijazah == "" || ijazah == "0" || (!ijazah.includes("/"))) {
            pesan = pesan.concat("Dokumen Ijazah masih kosong\n");
        }
        //cek cv
        if (cv == "" || cv == "0" || (cv.includes("apps-cakrawala.com")) || (!cv.includes("/"))) {
            pesan = pesan.concat("Dokumen CV masih kosong\n");
        }

        //tampilkan alert kalau ada yg blm diisi
        if (pesan) {
            alert(pesan);
        } else {
            location.href = link_cancat;
        }
    };
</script>

<!-- Tombol Next di tab dokumen TKHL -->
<script type="text/javascript">
    document.getElementById("dokumen_next_button_tkhl").onclick = function() {
        //konstruksi link tujuan
        var baseURL = "<?php echo base_url(); ?>";
        var pages = "<?php print($halaman); ?>";
        var nik = "<?php print($nik_url); ?>";
        var link_tujuan = "<?= base_url() ?>registrasi_tkhl/addRegister/";
        var link_cancat = link_tujuan.concat("review", "/", nik);

        //cek apakah input mandatory sudah terisi?
        var ktp = "<?php print($register['ktp']); ?>";
        var kk = "<?php print($register['kk']); ?>";
        var ijazah = "<?php print($register['ijazah']); ?>";
        var cv = "<?php print($register['civi']); ?>";
        var pesan = "";
        //cek ktp
        if (ktp == "" || ktp == "0" || (!ktp.includes("/"))) {
            pesan = pesan.concat("Dokumen KTP masih kosong\n");
        }
        //cek kk
        if (kk == "" || kk == "0" || (!kk.includes("/"))) {
            pesan = pesan.concat("Dokumen KK masih kosong\n");
        }
        //cek ijazah
        if (ijazah == "" || ijazah == "0" || (!ijazah.includes("/"))) {
            pesan = pesan.concat("Dokumen Ijazah masih kosong\n");
        }
        //cek cv
        if (cv == "" || cv == "0" || (cv.includes("apps-cakrawala.com")) || (!cv.includes("/"))) {
            pesan = pesan.concat("Dokumen CV masih kosong\n");
        }

        //tampilkan alert kalau ada yg blm diisi
        if (pesan) {
            alert(pesan);
        } else {
            location.href = link_cancat;
        }
    };
</script>

<!-- Fungsi navigasi halaman -->
<script>
    function pindahHalaman(halaman, nik) {
        $.post("<?= base_url() ?>registrasi/addRegister/", {
            halaman: halaman,
            nik: nik
        });

    }
</script>

<!-- blok klik kanan dan ctrl -->
<script>
    $("#nik_karyawan").bind("contextmenu", function(e) {
        e.preventDefault();
    });
    $("#nik_karyawan").on('keydown', function(event) {
        if (event.ctrlKey) {
            //alert('Entered ctrl')
            return false; //Prevent from ctrl+shift+i
        }
    });
    $("#perusahaan").bind("contextmenu", function(e) {
        e.preventDefault();
    });
    $("#project").bind("contextmenu", function(e) {
        e.preventDefault();
    });
    $("#sub_project").bind("contextmenu", function(e) {
        e.preventDefault();
    });
    $("#jabatan").bind("contextmenu", function(e) {
        e.preventDefault();
    });
    $("#tanggal_lahir").bind("contextmenu", function(e) {
        e.preventDefault();
    });
</script>

<!-- Tombol Edit Project dan Jabatan -->
<script type="text/javascript">
    document.getElementById("edit_project_dan_jabatan").onclick = function() {
        var baseURL = "<?php echo base_url(); ?>";
        var pages = "<?php print($halaman); ?>";
        pages.value = "perusahaan";
        var nik = "<?php print($nik_url); ?>";
        var link_tujuan = "<?= base_url() ?>registrasi/addRegister/";
        var link_cancat = link_tujuan.concat("perusahaan", "/", nik);
        location.href = link_cancat;
    };
</script>

<!-- Tombol Edit Project dan Jabatan TKHL-->
<script type="text/javascript">
    document.getElementById("edit_project_dan_jabatan").onclick = function() {
        var baseURL = "<?php echo base_url(); ?>";
        var pages = "<?php print($halaman); ?>";
        pages.value = "perusahaan";
        var nik = "<?php print($nik_url); ?>";
        var link_tujuan = "<?= base_url() ?>registrasi_tkhl/addRegister/";
        var link_cancat = link_tujuan.concat("perusahaan", "/", nik);
        location.href = link_cancat;
    };
</script>

<!-- Tombol Edit Data Diri -->
<script type="text/javascript">
    document.getElementById("edit_data_diri").onclick = function() {
        var baseURL = "<?php echo base_url(); ?>";
        var pages = "data_diri";
        var nik = "<?php print($nik_url); ?>";
        var link_tujuan = "<?= base_url() ?>registrasi/addRegister/";
        var link_cancat = link_tujuan.concat("data_diri", "/", nik);
        location.href = link_cancat;
    };
</script>

<!-- Tombol Edit Data Diri TKHL-->
<script type="text/javascript">
    document.getElementById("edit_data_diri").onclick = function() {
        var baseURL = "<?php echo base_url(); ?>";
        var pages = "data_diri";
        var nik = "<?php print($nik_url); ?>";
        var link_tujuan = "<?= base_url() ?>registrasi_tkhl/addRegister/";
        var link_cancat = link_tujuan.concat("data_diri", "/", nik);
        location.href = link_cancat;
    };
</script>

<!-- Tombol Kontak Darurat -->
<script type="text/javascript">
    document.getElementById("edit_kontak_darurat").onclick = function() {
        var baseURL = "<?php echo base_url(); ?>";
        var pages = "kontak_darurat";
        var nik = "<?php print($nik_url); ?>";
        var link_tujuan = "<?= base_url() ?>registrasi/addRegister/";
        var link_cancat = link_tujuan.concat("kontak_darurat", "/", nik);
        location.href = link_cancat;
    };
</script>

<!-- Tombol Kontak Darurat TKHL-->
<script type="text/javascript">
    document.getElementById("edit_kontak_darurat").onclick = function() {
        var baseURL = "<?php echo base_url(); ?>";
        var pages = "kontak_darurat";
        var nik = "<?php print($nik_url); ?>";
        var link_tujuan = "<?= base_url() ?>registrasi_tkhl/addRegister/";
        var link_cancat = link_tujuan.concat("kontak_darurat", "/", nik);
        location.href = link_cancat;
    };
</script>

<!-- Tombol Edit Dokumen -->
<script type="text/javascript">
    document.getElementById("edit_dokumen").onclick = function() {
        var baseURL = "<?php echo base_url(); ?>";
        var pages = "dokumen";
        var nik = "<?php print($nik_url); ?>";
        var link_tujuan = "<?= base_url() ?>registrasi/addRegister/";
        var link_cancat = link_tujuan.concat("dokumen", "/", nik);
        location.href = link_cancat;
    };
</script>

<!-- Tombol Edit Dokumen -->
<script type="text/javascript">
    document.getElementById("edit_dokumen").onclick = function() {
        var baseURL = "<?php echo base_url(); ?>";
        var pages = "dokumen";
        var nik = "<?php print($nik_url); ?>";
        var link_tujuan = "<?= base_url() ?>registrasi_tkhl/addRegister/";
        var link_cancat = link_tujuan.concat("dokumen", "/", nik);
        location.href = link_cancat;
    };
</script>

<!-- Tombol Selesai isi -->
<script>
    function myFunction() {
        // baseURL variable
        var baseURL = "<?php echo base_url(); ?>";
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

        var nik = "<?php print($cek_nik); ?>";

        //alert(nik);
        //alert(baseURL);

        // AJAX request
        $.ajax({
            url: '<?= base_url() ?>registrasi/isiDataFinish/',
            method: 'post',
            data: {
                [csrfName]: csrfHash,
                nik: nik
            },
            success: function(response) {
                //alert("masuk dengan nik".nik);
            }
        });

        //return false;

        //var nik = "<?php print($cek_nik); ?>";
        //var baseURL = "<?php echo base_url(); ?>";
        //var link_tujuan = "<?= base_url() ?>registrasi/isiDataFinish/";
        //var link_cancat = link_tujuan.concat(nik);
        //document.getElementById("finish").innerHTML = nik;
        //alert(baseURL);
        //alert(link_cancat);
        //alert(nik);
        //location.href = link_cancat;
    }
</script>

<!-- Tombol Selesai isi -->
<script>
    function myFunctionTKHL() {
        // baseURL variable
        var baseURL = "<?php echo base_url(); ?>";
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
            csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

        var nik = "<?php print($cek_nik); ?>";

        //alert(nik);
        //alert(baseURL);

        // AJAX request
        $.ajax({
            url: '<?= base_url() ?>registrasi/isiDataFinishTKHL/',
            method: 'post',
            data: {
                [csrfName]: csrfHash,
                nik: nik
            },
            success: function(response) {
                //alert("masuk dengan nik".nik);
            }
        });

        //return false;

        //var nik = "<?php print($cek_nik); ?>";
        //var baseURL = "<?php echo base_url(); ?>";
        //var link_tujuan = "<?= base_url() ?>registrasi/isiDataFinish/";
        //var link_cancat = link_tujuan.concat(nik);
        //document.getElementById("finish").innerHTML = nik;
        //alert(baseURL);
        //alert(link_cancat);
        //alert(nik);
        //location.href = link_cancat;
    }
</script>

<!-- Chained Dropdown (Project - Sub Project) & (Project - Jabatan) -->
<script type='text/javascript'>
    // baseURL variable
    var baseURL = "<?php echo base_url(); ?>";
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
        csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

    // alert(csrfName);
    // alert(csrfHash);

    $(document).ready(function() {

        $('.dropdown-dengan-search').select2({
            width: '100%'
        });

        // Project Change - Sub Project (on Change)
        $('#project').change(function() {
            var project = $(this).val();

            // AJAX request
            $.ajax({
                url: '<?= base_url() ?>registrasi/getSubByProject/',
                method: 'post',
                data: {
                    [csrfName]: csrfHash,
                    project: project
                },
                dataType: 'json',
                success: function(response) {
                    //csrfName = data.csrfName;
                    //csrfHash = data.csrfHash;

                    // Remove options 
                    $('#sub_project').find('option').not(':first').remove();

                    // Add options
                    $.each(response, function(index, data) {
                        $('#sub_project').append('<option value="' + data['secid'] + '">' + data['sub_project_name'] + '</option>');
                    }).show();
                }
            });
        });

        // Project Change - Jabatan
        $('#project').change(function() {
            var project = $(this).val();

            // AJAX request
            $.ajax({
                url: '<?= base_url() ?>registrasi/getJabatanByProject/',
                method: 'post',
                data: {
                    [csrfName]: csrfHash,
                    project: project
                },
                dataType: 'json',
                success: function(response) {

                    // Remove options
                    $('#jabatan').find('option').not(':first').remove();

                    // Add options
                    $.each(response, function(index, data) {
                        $('#jabatan').append('<option value="' + data['designation_id'] + '">' + data['designation_name'] + '</option>');
                    });
                }
            });
        });

    });
</script>

<!-- Save data ketika finish -->
<script type='text/javascript'>
    // baseURL variable
    var baseURL = "<?php echo base_url(); ?>";
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
        csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

    $(document).ready(function() {
        // Tombol finish
        $('#finish').onclick(function() {
            var nik = "<?php print($nik_karyawan); ?>";
            //

            // AJAX request
            $.ajax({
                url: '<?= base_url() ?>registrasi/isiDataFinish/'.nik,
                method: 'post',
                data: {
                    [csrfName]: csrfHash,
                    nik: nik
                },
                dataType: 'json',
                success: function(response) {
                    alert("masuk dengan nik".nik);
                }
            });
        });
    });
</script>

<script>
    //Jquery Upload File
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    //Datatables
    $(document).ready(function() {
        $('#table_id').DataTable();
    });

    //Date Picker
    $('#tanggal_lahir').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_mulai_kerja').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_akhir_kerja').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_lahir_istri_suami').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_lahir_anak1').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_lahir_anak2').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_lahir_anak3').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_absen').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_selesai').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_masuk_pkl').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_selesai_pkl').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_lahir_siswa').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_masuk_magang').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_selesai_magang').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_lahir_magang').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_penyerahan_laptop').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_akhir_pajak_motor').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_akhir_plat_motor').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_penyerahan_motor').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_akhir_pajak_mobil').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_akhir_plat_mobil').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_penyerahan_mobil').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_keluar_karyawan_keluar').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#mulai_tanggal').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#sampai_tanggal').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_mulai_laporan_absen').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_selesai_laporan_absen').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_mulai').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_selesai').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_lembur').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_lahir_history_keluarga').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_awal_kontrak').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_akhir_kontrak').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_mutasi').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_training_internal').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_awal_training_eksternal').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_akhir_training_eksternal').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_awal_pendidikan_non_formal').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_akhir_pendidikan_non_formal').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_awal').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_akhir').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_akhir_magang').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });

    $('#tanggal_cetak_surat').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });


    //Jquery Checkbox
    $('.form-check-input').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');

        $.ajax({
            url: "<?= base_url('master/changeaccess'); ?>",
            type: 'post',
            data: {
                menuId: menuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = "<?= base_url('master/roleaccess/'); ?>" + roleId;
            }
        });
    });
</script>


<!-- Chart Javascript -->
<script src="<?php echo base_url() . 'assets/assets_registrasi/chart/js/jquery.min.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/assets_registrasi/chart/js/raphael-min.js' ?>"></script>
<script src="<?php echo base_url() . 'assets/assets_registrasi/chart/js/morris.min.js' ?>"></script>

<!--Multipleselect-->
<script type="text/javascript" src="<?php echo base_url('assets/assets_registrasi/multipleselect/js/jquery-3.4.1.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/assets_registrasi/multipleselect/js/bootstrap.bundle.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/assets_registrasi/multipleselect/js/bootstrap-select.js'); ?>"></script>
<!--End Multipleselect-->

<!-- Datatables Javascript -->
<script type="text/javascript" src="<?= base_url('assets/assets_registrasi/datatables/javascript3.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/assets_registrasi/datatables/javascript4.js'); ?>"></script>
<!--End Datatables -->

<!-- Cari Data Karyawan pada form absensi berdasarkan NIk Karyawan -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#nik_karyawan').on('input', function() {

            var nik_karyawan = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('absensi/get_datakaryawan') ?>",
                dataType: "JSON",
                data: {
                    nik_karyawan: nik_karyawan
                },
                cache: false,
                success: function(data) {
                    $.each(data, function(nik_karyawan, nama_karyawan, nama_jabatan) {
                        $('[name="nama_karyawan"]').val(data.nama_karyawan);
                        $('[name="jabatan"]').val(data.jabatan);
                        $('[name="penempatan"]').val(data.penempatan);
                    });
                }
            });
            return false;
        });
    });
</script>

<!-- Cari Data Karyawan pada form inventaris berdasarkan NIk Karyawan -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#nik_karyawan').on('input', function() {

            var nik_karyawan = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('inventaris/get_datakaryawan') ?>",
                dataType: "JSON",
                data: {
                    nik_karyawan: nik_karyawan
                },
                cache: false,
                success: function(data) {
                    $.each(data, function(nik_karyawan, nama_karyawan, nama_jabatan) {
                        $('[name="nama_karyawan"]').val(data.nama_karyawan);
                        $('[name="jabatan"]').val(data.jabatan);
                        $('[name="penempatan"]').val(data.penempatan);
                    });
                }
            });
            return false;
        });
    });
</script>

<!-- Cari Data Karyawan pada form karyawan keluar berdasarkan NIk Karyawan -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#nik_karyawan').on('input', function() {

            var nik_karyawan = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('KaryawanKeluar/get_datakaryawan') ?>",
                dataType: "JSON",
                data: {
                    nik_karyawan: nik_karyawan
                },
                cache: false,
                success: function(data) {
                    $('[name="nama_karyawan"]').val(data.nama_karyawan);
                    $('[name="perusahaan_id"]').val(data.perusahaan);
                    $('[name="jabatan_id"]').val(data.jabatan);
                    $('[name="penempatan_id"]').val(data.penempatan);
                    $('[name="per"]').val(data.perusahaan_id);
                    $('[name="jab"]').val(data.jabatan_id);
                    $('[name="pen"]').val(data.penempatan_id);
                    $('[name="nomor_npwp"]').val(data.nomor_npwp);
                    $('[name="nomor_absen"]').val(data.nomor_absen);
                    $('[name="golongan_darah"]').val(data.golongan_darah);
                    $('[name="email_karyawan"]').val(data.email_karyawan);
                    $('[name="nomor_handphone"]').val(data.nomor_handphone);
                    $('[name="tempat_lahir"]').val(data.tempat_lahir);
                    $('[name="tanggal_lahir"]').val(data.tanggal_lahir);
                    $('[name="pendidikan_terakhir"]').val(data.pendidikan_terakhir);
                    $('[name="jenis_kelamin"]').val(data.jenis_kelamin);
                    $('[name="agama"]').val(data.agama);
                    $('[name="alamat"]').val(data.alamat);
                    $('[name="rt"]').val(data.rt);
                    $('[name="rw"]').val(data.rw);
                    $('[name="kelurahan"]').val(data.kelurahan);
                    $('[name="kecamatan"]').val(data.kecamatan);
                    $('[name="kota"]').val(data.kota);
                    $('[name="provinsi"]').val(data.provinsi);
                    $('[name="kode_pos"]').val(data.kode_pos);
                    $('[name="nomor_kartu_keluarga"]').val(data.nomor_kartu_keluarga);
                    $('[name="status_nikah"]').val(data.status_nikah);
                    $('[name="nama_ayah"]').val(data.nama_ayah);
                    $('[name="nama_ibu"]').val(data.nama_ibu);
                    $('[name="nomor_jkn"]').val(data.nomor_jkn);
                    $('[name="nomor_jht"]').val(data.nomor_jht);
                    $('[name="nomor_jp"]').val(data.nomor_jp);
                    $('[name="nomor_rekening"]').val(data.nomor_rekening);
                    $('[name="tanggal_mulai_kerja"]').val(data.tanggal_mulai_kerja);
                    $('[name="status_kerja"]').val(data.status_kerja);
                }
            });
            return false;
        });
    });
</script>


<!-- Cari Data Karyawan Keluar pada form tambah karyawan berdasarkan NIk Karyawan Keluar -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#nik_karyawan').on('input', function() {

            var nik_karyawan = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('karyawan/get_datakaryawankeluarkaryawan') ?>",
                dataType: "JSON",
                data: {
                    nik_karyawan: nik_karyawan
                },
                cache: false,
                success: function(data) {
                    $('[name="tanggal_mulai_kerja"]').val(data.tanggal_masuk_karyawan_keluar);
                    $('[name="status_kerja"]').val(data.status_kerja_karyawan_keluar);
                    $('[name="jabatan_id"]').val(data.jabatan_id);
                    $('[name="penempatan_id"]').val(data.penempatan_id);
                    $('[name="perusahaan_id"]').val(data.perusahaan_id);
                    $('[name="nama_karyawan"]').val(data.nama_karyawan_keluar);
                    $('[name="email_karyawan"]').val(data.email_karyawan_keluar);
                    $('[name="nomor_absen"]').val(data.nomor_absen_karyawan_keluar);
                    $('[name="nomor_npwp"]').val(data.nomor_npwp_karyawan_keluar);
                    $('[name="tempat_lahir"]').val(data.tempat_lahir_karyawan_keluar);
                    $('[name="tanggal_lahir"]').val(data.tanggal_lahir_karyawan_keluar);
                    $('[name="agama"]').val(data.agama_karyawan_keluar);
                    $('[name="jenis_kelamin"]').val(data.jenis_kelamin_karyawan_keluar);
                    $('[name="pendidikan_terakhir"]').val(data.pendidikan_terakhir_karyawan_keluar);
                    $('[name="nomor_handphone"]').val(data.nomor_handphone_karyawan_keluar);
                    $('[name="golongan_darah"]').val(data.golongan_darah_karyawan_keluar);
                    $('[name="alamat"]').val(data.alamat_karyawan_keluar);
                    $('[name="rt"]').val(data.rt_karyawan_keluar);
                    $('[name="rw"]').val(data.rw_karyawan_keluar);
                    $('[name="provinsi"]').val(data.provinsi_karyawan_keluar);
                    $('[name="kota"]').val(data.kota_karyawan_keluar);
                    $('[name="kecamatan"]').val(data.kecamatan_karyawan_keluar);
                    $('[name="kelurahan"]').val(data.kelurahan_karyawan_keluar);
                    $('[name="kode_pos"]').val(data.kode_pos_karyawan_keluar);
                    $('[name="nomor_rekening"]').val(data.nomor_rekening_karyawan_keluar);
                    $('[name="nomor_kartu_keluarga"]').val(data.nomor_kartu_keluarga_karyawan_keluar);
                    $('[name="status_nikah"]').val(data.status_nikah_karyawan_keluar);
                    $('[name="nama_ayah"]').val(data.nama_ayah_karyawan_keluar);
                    $('[name="nama_ibu"]').val(data.nama_ibu_karyawan_keluar);
                    $('[name="nomor_jht"]').val(data.nomor_jht_karyawan_keluar);
                    $('[name="nomor_jp"]').val(data.nomor_jp_karyawan_keluar);
                    $('[name="nomor_jkn"]').val(data.nomor_jkn_karyawan_keluar);
                }
            });
            return false;
        });
    });
</script>

<!-- Cari Data Karyawan pada form magang berdasarkan NIk Karyawan -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#nik_magang').on('input', function() {

            var nik_magang = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('magang/get_datakaryawan') ?>",
                dataType: "JSON",
                data: {
                    nik_magang: nik_magang
                },
                cache: false,
                success: function(data) {
                    $('[name="nama_magang"]').val(data.nama_karyawan_keluar);
                    $('[name="tempat_lahir_magang"]').val(data.tempat_lahir_karyawan_keluar);
                    $('[name="tanggal_lahir_magang"]').val(data.tanggal_lahir_karyawan_keluar);
                    $('[name="agama_magang"]').val(data.agama_karyawan_keluar);
                    $('[name="jenis_kelamin_magang"]').val(data.jenis_kelamin_karyawan_keluar);
                    $('[name="nomor_handphone_magang"]').val(data.nomor_handphone_karyawan_keluar);
                    $('[name="pendidikan_terakhir_magang"]').val(data.pendidikan_terakhir_karyawan_keluar);
                    $('[name="alamat_magang"]').val(data.alamat_karyawan_keluar);
                    $('[name="rt_magang"]').val(data.rt_karyawan_keluar);
                    $('[name="rw_magang"]').val(data.rw_karyawan_keluar);
                    $('[name="kelurahan_magang"]').val(data.kelurahan_karyawan_keluar);
                    $('[name="kecamatan_magang"]').val(data.kecamatan_karyawan_keluar);
                    $('[name="kota_magang"]').val(data.kota_karyawan_keluar);
                    $('[name="provinsi_magang"]').val(data.provinsi_karyawan_keluar);
                    $('[name="kode_pos_magang"]').val(data.kode_pos_karyawan_keluar);
                }
            });
            return false;
        });
    });
</script>

<!-- Cari Data Karyawan pada form cetak surat pengalaman kerja berdasarkan NIk Karyawan -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#nik_karyawan_keluar').on('input', function() {

            var nik_karyawan_keluar = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('surat/get_datakaryawankeluar') ?>",
                dataType: "JSON",
                data: {
                    nik_karyawan_keluar: nik_karyawan_keluar
                },
                cache: false,
                success: function(data) {
                    $('[name="nama_karyawan_keluar"]').val(data.nama_karyawan_keluar);
                    $('[name="jabatan_id"]').val(data.jabatan_id);
                    $('[name="penempatan_id"]').val(data.penempatan_id);
                    $('[name="tanggal_masuk_karyawan_keluar"]').val(data.tanggal_masuk_karyawan_keluar);
                    $('[name="tanggal_keluar_karyawan_keluar"]').val(data.tanggal_keluar_karyawan_keluar);
                }
            });
            return false;
        });
    });
</script>

<!-- Cari Data Karyawan pada form cetak surat keterangan aktif kerja, pkwt, pkwtt, dan penilaian karyawan, berdasarkan NIk Karyawan -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#nik_karyawan').on('input', function() {

            var nik_karyawan = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('surat/get_datakaryawan') ?>",
                dataType: "JSON",
                data: {
                    nik_karyawan: nik_karyawan
                },
                cache: false,
                success: function(data) {
                    $('[name="nama_karyawan"]').val(data.nama_karyawan);
                    $('[name="jabatan"]').val(data.jabatan);
                    $('[name="penempatan"]').val(data.penempatan);
                    $('[name="tanggal_mulai_kerja"]').val(data.tanggal_mulai_kerja);
                    $('[name="tanggal_akhir_kerja"]').val(data.tanggal_akhir_kerja);
                }
            });
            return false;
        });
    });
</script>

<!-- Cari Data Karyawan pada form cetak surat inventaris laptop, berdasarkan NIk Karyawan -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#nik_karyawan').on('input', function() {

            var nik_karyawan = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('surat/get_datainventarislaptop') ?>",
                dataType: "JSON",
                data: {
                    nik_karyawan: nik_karyawan
                },
                cache: false,
                success: function(data) {
                    $('[name="nama_karyawan"]').val(data.nama_karyawan);
                    $('[name="jabatan"]').val(data.jabatan);
                    $('[name="penempatan"]').val(data.penempatan);
                    $('[name="merk_laptop"]').val(data.merk_laptop);
                    $('[name="type_laptop"]').val(data.type_laptop);
                }
            });
            return false;
        });
    });
</script>

<!-- Cari Data Karyawan pada form cetak surat inventaris motor, berdasarkan NIk Karyawan -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#nik_karyawan').on('input', function() {

            var nik_karyawan = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('surat/get_datainventarismotor') ?>",
                dataType: "JSON",
                data: {
                    nik_karyawan: nik_karyawan
                },
                cache: false,
                success: function(data) {
                    $('[name="nama_karyawan"]').val(data.nama_karyawan);
                    $('[name="jabatan"]').val(data.jabatan);
                    $('[name="penempatan"]').val(data.penempatan);
                    $('[name="merk_motor"]').val(data.merk_motor);
                    $('[name="type_motor"]').val(data.type_motor);
                }
            });
            return false;
        });
    });
</script>

<!-- Cari Data Karyawan pada form cetak surat inventaris mobil, berdasarkan NIk Karyawan -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#nik_karyawan').on('input', function() {

            var nik_karyawan = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('surat/get_datainventarismobil') ?>",
                dataType: "JSON",
                data: {
                    nik_karyawan: nik_karyawan
                },
                cache: false,
                success: function(data) {
                    $('[name="nama_karyawan"]').val(data.nama_karyawan);
                    $('[name="jabatan"]').val(data.jabatan);
                    $('[name="penempatan"]').val(data.penempatan);
                    $('[name="merk_mobil"]').val(data.merk_mobil);
                    $('[name="type_mobil"]').val(data.type_mobil);
                }
            });
            return false;
        });
    });
</script>

<!-- Cari Data Karyawan pada form cetak laporan absensi karyawan -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#nik_karyawan').on('input', function() {

            var nik_karyawan = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('laporan/get_datakaryawan') ?>",
                dataType: "JSON",
                data: {
                    nik_karyawan: nik_karyawan
                },
                cache: false,
                success: function(data) {
                    $('[name="nama_karyawan"]').val(data.nama_karyawan);
                    $('[name="jabatan"]').val(data.jabatan);
                    $('[name="penempatan"]').val(data.penempatan);
                    $('[name="tanggal_mulai_kerja"]').val(data.tanggal_mulai_kerja);
                    $('[name="tanggal_akhir_kerja"]').val(data.tanggal_akhir_kerja);
                }
            });
            return false;
        });
    });
</script>

<!-- Cari Data Karyawan pada form cetak slip gaji -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#nik_karyawan').on('input', function() {

            var nik_karyawan = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('gaji/get_gajikaryawan') ?>",
                dataType: "JSON",
                data: {
                    nik_karyawan: nik_karyawan
                },
                cache: false,
                success: function(data) {
                    $('[name="nama_karyawan"]').val(data.nama_karyawan);
                    $('[name="jumlah_upah"]').val(data.jumlah_upah);
                    $('[name="potongan_jkn"]').val(data.potongan_jkn);
                    $('[name="potongan_jht"]').val(data.potongan_jht);
                    $('[name="potongan_jp"]').val(data.potongan_jp);
                    $('[name="total_gaji"]').val(data.total_gaji);
                }
            });
            return false;
        });
    });
</script>

<!-- Cari Data Karyawan pada form history keluarga -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#nik_karyawan').on('input', function() {

            var nik_karyawan = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('history/get_datakaryawan') ?>",
                dataType: "JSON",
                data: {
                    nik_karyawan: nik_karyawan
                },
                cache: false,
                success: function(data) {
                    $('[name="nama_karyawan"]').val(data.nama_karyawan);
                    $('[name="jabatan"]').val(data.jabatan);
                    $('[name="penempatan"]').val(data.penempatan);
                }
            });
            return false;
        });
    });
</script>

<!-- Chart -->
<script>
    //DONUT CHART

    $cobadata = 120;

    var donut = new Morris.Donut({
        element: 'penempatan-chart',
        resize: true,
        colors: ["#FFD700", "#00FF00", "#FF00FF", "#FF0000", "#6F00FF", "#00BFFF", "#696969", "#00FF00", "#00BFFF", "#696969", "#7CFC00", "#F08080", "#20B2AA", "#00a65a", "#8b0bf4", "#3c8dbc", "#f56954", "#00a65a", "#8b0bf4", "#3c8dbc", "#f56954", "#00a65a", "#8b0bf4", "#3c8dbc", "#f56954"],
        data: [{
                label: "HRD - GA",
                value: "<?= $jumlahkaryawanhrdga ?>",
            },
            {
                label: "IT",
                value: "<?= $jumlahkaryawanit ?>",
            },
            {
                label: "Document Control",
                value: "<?= $jumlahkaryawandocumentcontrol ?>",
            },
            {
                label: "Purchasing",
                value: "<?= $jumlahkaryawanpurchasing ?>",
            },
            {
                label: "Accounting",
                value: "<?= $jumlahkaryawanaccounting ?>",
            },
            {
                label: "Marketing",
                value: "<?= $jumlahkaryawanmarketing ?>",
            },
            {
                label: "Engineering",
                value: "<?= $jumlahkaryawanengineering ?>",
            },
            {
                label: "Quality",
                value: "<?= $jumlahkaryawanquality ?>",
            },
            {
                label: "PPC",
                value: "<?= $jumlahkaryawanppc ?>",
            },
            {
                label: "IC",
                value: "<?= $jumlahkaryawanic ?>",
            },
            {
                label: "Produksi",
                value: "<?= $jumlahkaryawanproduksi ?>",
            },
            {
                label: "Delivery",
                value: "<?= $jumlahkaryawandelivery ?>",
            },
            {
                label: "Delivery Produksi",
                value: "<?= $jumlahkaryawandeliveryproduksi ?>",
            },
            {
                label: "Raw Material",
                value: "<?= $jumlahkaryawangudangrawmaterial ?>",
            },
            {
                label: "Finish Goods",
                value: "<?= $jumlahkaryawangudangfinishgoods ?>",
            },
            {
                label: "Blok BL",
                value: "<?= $jumlahkaryawanblokbl ?>",
            },
            {
                label: "Blok E",
                value: "<?= $jumlahkaryawanbloke ?>",
            },
            {
                label: "Security",
                value: "<?= $jumlahkaryawansecurity ?>",
            },
            {
                label: "Daihatsu Cibinong",
                value: "<?= $jumlahkaryawandaihatsucibinong ?>",
            },
            {
                label: "Daihatsu Sunter",
                value: "<?= $jumlahkaryawandaihatsusunter ?>",
            },
            {
                label: "Daihatsu Cibitung",
                value: "<?= $jumlahkaryawandaihatsucibitung ?>",
            },
            {
                label: "Daihatsu Karawang Timur",
                value: "<?= $jumlahkaryawandaihatsukarawangtimur ?>",
            },
            {
                label: "Isuzu P UNGU",
                value: "<?= $jumlahkaryawanisuzupungu ?>",
            },
            {
                label: "Toyota Sunterlake",
                value: "<?= $jumlahkaryawantoyotasunterlake ?>",
            }
        ],
        hideHover: 'auto'
    });

    var donut = new Morris.Donut({
        element: 'perusahaan-chart',
        resize: true,
        colors: ["#3c8dbc", "#f56954"],
        data: [{
                label: "Prima Komponen",
                value: "<?= $jumlahkaryawanprima ?>",
            },
            {
                label: "Petra Ariesca",
                value: "<?= $jumlahkaryawanpetra ?>"
            }

        ],
        hideHover: 'auto'
    });

    var donut = new Morris.Donut({
        element: 'jeniskelamin-chart',
        resize: true,
        colors: ["#DC143C", "#D2691E"],
        data: [{
                label: "Wanita",
                value: "<?= $jumlahkaryawanwanita ?>",
            },
            {
                label: "Pria",
                value: "<?= $jumlahkaryawanpria ?>"
            }

        ],
        hideHover: 'auto'
    });

    var donut = new Morris.Donut({
        element: 'agama-chart',
        resize: true,
        colors: ["#006400", "#BDB76B"],
        data: [{
                label: "Muslim",
                value: "<?= $jumlahkaryawanislam ?>",
            },
            {
                label: "Non Muslim",
                value: "<?= $jumlahkaryawannonislam ?>"
            }
        ],
        hideHover: 'auto'
    });

    var donut = new Morris.Donut({
        element: 'statuskerja-chart',
        resize: true,
        colors: ["#8B008B", "#E9967A", "#DC143C"],
        data: [{
                label: "PKWT",
                value: "<?= $jumlahkaryawankontrak ?>",
            },
            {
                label: "PKWTT",
                value: "<?= $jumlahkaryawantetap ?>"
            },
            {
                label: "Outsourcing",
                value: "<?= $jumlahkaryawanoutsourcing ?>"
            }
        ],
        hideHover: 'auto'
    });

    var donut = new Morris.Donut({
        element: 'statusmenikah-chart',
        resize: true,
        colors: ["#FF00FF", "#00BFFF", "#8B008B", "#E9967A"],
        data: [{
                label: "Single",
                value: "<?= $jumlahkaryawansingle ?>",
            },
            {
                label: "Menikah",
                value: "<?= $jumlahkaryawanmenikah ?>"
            },
            {
                label: "Duda",
                value: "<?= $jumlahkaryawanduda ?>"
            },
            {
                label: "Janda",
                value: "<?= $jumlahkaryawanjanda ?>"
            }
        ],
        hideHover: 'auto'
    });




    //DONUT CHART
</script>


<script type="text/javascript">
    $(document).ready(function() {
        $('.bootstrap-select').selectpicker();

        //GET UPDATE
        $('.update-record').on('click', function() {
            var package_id = $(this).data('package_id');
            var package_name = $(this).data('package_name');
            $(".strings").val('');
            $('#UpdateModal').modal('show');
            $('[name="edit_id"]').val(package_id);
            $('[name="package_edit"]').val(package_name);
            //AJAX REQUEST TO GET SELECTED PRODUCT
            $.ajax({
                url: "<?php echo site_url('lembur/get_product_by_package'); ?>",
                method: "POST",
                data: {
                    package_id: package_id
                },
                cache: false,
                success: function(data) {
                    var item = data;
                    var val1 = item.replace("[", "");
                    var val2 = val1.replace("]", "");
                    var values = val2;
                    $.each(values.split(","), function(i, e) {
                        $(".strings option[value='" + e + "']").prop("selected", true).trigger('change');
                        $(".strings").selectpicker('refresh');

                    });
                }

            });
            return false;
        });

        //GET CONFIRM DELETE
        $('.delete-record').on('click', function() {
            var package_id = $(this).data('package_id');
            $('#DeleteModal').modal('show');
            $('[name="delete_id"]').val(package_id);
        });

    });
</script>

</body>

</html>