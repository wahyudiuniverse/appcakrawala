<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>

<!-- Filepond css -->
<link rel="stylesheet" href="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond/filepond.min.css" type="text/css" />
<!-- <link href="assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css" type="text/css" />


<!-- MODAL EXITCLEARANCE -->
<div class="modal fade" id="editRekeningModal" tabindex="-1" role="dialog" aria-labelledby="editRekeningModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editRekeningModalLabel">DIALOG PENGAJUAN PAKLARING</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-edit-rekening">
          <div class="container" id="container_modal_rekening">

            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>

                  <tr>
                    <td style='width:25%'><strong>NIP / Nama Lengkap <span class="icon-verify-bank"></span></strong></td>
                      
                    <td ><strong><span class="icon-verify-bank" id="fullname_modal" name="fullname_modal"></span></strong></td>
                    </td>
                  </tr>

                  <tr>
                    <td style='width:25%'><strong>KTP / Nama PT. <span class="icon-verify-bank"></span></strong></td>
                    <td ><strong><span class="icon-verify-bank" id="nikpt_modal" name="nikpt_modal"></span></strong></td>
                    </td>
                  </tr>

                  <tr>
                    <td style='width:25%'><strong>Project / Posisi <span class="icon-verify-bank"></span></strong></td>
                    <td ><strong><span class="icon-verify-bank" id="propos_modal" name="propos_modal"></span></strong></td>
                    </td>
                  </tr>

                  <tr>
                    <td style='width:25%'><strong>Periode Kontrak Terakhir <span class="icon-verify-bank"></span></strong></td>
                    <td ><strong><span class="icon-verify-bank" id="periode_modal" name="periode_modal"></span></strong></td>
                    </td>
                  </tr>

                  <tr>
                    <td style='width:25%'><strong>Tanggal Bergabung / Date of Join <span class="icon-verify-bank"></span></strong></td>
                    <td style='width:75%'>
                      
                      <input class="form-control date" readonly placeholder="Tanggal Bergabung" id="joindate_field" name="joindate_field" type="text" value="">
                      <span id='pesan_joindate'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Tanggal Berakhir / Date of Leave <span class="icon-verify-norek"></span></strong></td>
                    <td>
                      
                      <input class="form-control date" readonly placeholder="Tanggal Resign" id="leavedate_field" name="leavedate_field" type="text" value="">
                      <span id='pesan_leavedate'></span>
                    </td>
                  </tr>

                  <tr>
                    <td><strong>Status Berakhir <span class="icon-verify-norek"></span></strong></td>
                    <td>

                      <select name="status_resign_select" id="status_resign_select" class="form-control" data-plugin="xin_select" data-placeholder="Status Resign/Berakhir">
                        
                        <option value="2"> RESIGN</option>
                        <option value="4"> END CONTRACT</option>
                        <option value="3"> BLACKLIST</option>

                      </select>


                    </td>
                  </tr>

                  <tr id="input_exit_clearance">
                    <td style="width:25%">Dokumen Exit Clearance <font color="#FF0000">*</font>
                    </td>
                    <td style="width:75%">
                      <input type="file" class="filepond filepond-input-multiple" multiple id="file_exitclear" data-allow-reorder="true" data-max-file-size="5MB" data-max-files="1" accept="image/png, image/jpeg, application/pdf">
                      <span><small class="text-muted">File bertipe jpg, jpeg, png atau pdf. Ukuran maksimal 5 MB</small></span>
                      </br><span id='pesan_file_exitclear'></span>
                      <input hidden type="text" id="link_file_exitclear" value="0">
                      <input hidden type="text" id="status_file_exitclear" value="0">
                    </td>
                  </tr>

                  <tr id="input_surat_resign">
                    <td style="width:25%">Surat Pengunduran Diri <font color="#FF0000">*</font>
                    </td>
                    <td style="width:75%">
                      <input type="file" class="filepond filepond-input-multiple" multiple id="file_resign" data-allow-reorder="true" data-max-file-size="5MB" data-max-files="1" accept="image/png, image/jpeg, application/pdf">
                      <span><small class="text-muted">File bertipe jpg, jpeg, png atau pdf. Ukuran maksimal 5 MB</small></span>
                      </br><span id='pesan_file_resign'></span>
                      <input hidden type="text" id="link_file_resign" value="0">
                      <input hidden type="text" id="status_file_resign" value="0">
                    </td>
                  </tr>


                </tbody>
              </table>


                <input hidden type="text" id="field_employee_id" value="0">
                <input hidden type="text" id="field_fullname" value="0">
                <input hidden type="text" id="field_ktp" value="0">
                <input hidden type="text" id="field_jabatan" value="0">
                <input hidden type="text" id="field_project_id" value="0">
                <input hidden type="text" id="field_project_name" value="0">
                <input hidden type="text" id="field_company_id" value="0">
                <input hidden type="text" id="field_company_name" value="0">

            </div>
          </div>
        </div>

        <div class="info-modal-edit-rekening"></div>

      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Tutup</button>

              <button
                type="button"
                onclick="next_kontak_client()"
                class="btn btn-success btn-label float-right ms-auto">
                <i
                  class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>AJUKAN PAKLARING
              </button>

        <!-- <button id='button_save_rekening' name='button_save_rekening' type='submit' class='btn btn-primary'>AJUKAN PAKLARING</button> -->
      </div>

    </div>
  </div>
</div>

<hr class="border-light m-0 mb-3">

<!-- SECTION FILTER -->
<div class="card border-blue">
  <div class="card-header with-elements">
    <div class="col-md-6">
      <span class="card-header-title mr-2"><strong>NON-AKTIF EMPLOYEES | </strong>FILTER</span>
    </div>

    <!-- <div class="col-md-6">
      <div class="pull-right">
        <span class="card-header-title mr-2">
          <button id="button_clear_search" class="btn btn-success" data-style="expand-right">Clear Filter</button>
        </span>
      </div>
    </div> -->
  </div>

  <div class="card-body border-bottom-blue ">

    <?php echo form_open_multipart('/admin/importexcel/import_saltab2/'); ?>

    <input type="hidden" id="nik" name="nik" value=<?php echo $session['employee_id']; ?>>

    <div class="form-row">
      <div class="col-md-3">
        <div class="form-group project-option">
          <label class="form-label">Project</label>
          <select class="form-control select_hrm" data-live-search="true" name="project_id" id="aj_project"  data-placeholder="Project" required>
            <option value="0">-ALL-</option>
            <?php foreach ($all_projects as $proj) { ?>
              <option value="<?php echo $proj->project_id; ?>"> <?php echo $proj->title; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="col-md-3" id="subproject_ajax" hidden>
        <label class="form-label">Sub Project</label>
        <select class="form-control select_hrm" data-live-search="true" name="sub_project_id" id="aj_sub_project"  data-placeholder="<?php echo $this->lang->line('left_projects'); ?>">
          <option value="0">--ALL--</option>
          <!-- <?php foreach ($all_projects as $proj) { ?>
            <option value="<?php echo $proj->project_id; ?>" <?php if ($project_karyawan == $proj->project_id) {
                                                                echo " selected";
                                                              } ?>> <?php echo $proj->title; ?></option>
          <?php } ?> -->
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">NIP / KTP / Nama Lengkap</label>
        <input class="form-control" placeholder="Cari NIP / KTP / NAMA LENGKAP" name="keyword" id="aj_keyword" type="text" value="">
                  

      </div>

      <div class="col-md-3">
        <div class="form-group">
          <!-- button submit -->
          <label class="form-label">&nbsp;</label>
          <button name="filter_employee" id="filter_employee" class="btn btn-primary btn-block"><i class="fa fa-search"></i> FILTER</button>
        </div>
      </div>
    </div>

    <?php echo form_close(); ?>

  </div>
</div>

<!-- SECTION DATA TABLES -->
<div class="row m-b-1 <?php echo $get_animate; ?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements">
        <div class="col-md-6">
          <span class="card-header-title mr-2"><strong>LIST EMPLOYEES</strong></span>
        </div>

        <div class="col-md-6">
          <div class="pull-right">
            <!-- <div class="card-header with-elements"> -->
            <span class="card-header-title mr-2">
              <button hidden id="button_download_data" class="btn btn-success" data-style="expand-right">Download Data</button>
            </span>
          </div>
        </div>
      </div>

      <div class="card-body">

        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="tabel_employees">
            <thead>
              <tr>
                <th>Aksi</th>
                <th>NIP - Status</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>Project</th>
                <th>Jabatan</th>
                <th>Area/Penempatan</th>
                <th>Tanggal Bergabung</th>
                <th>Tanggal Resign</th>
                <th>Status Pengajuan</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- filepond js -->
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond/filepond.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-file-rename/filepond-plugin-file-rename.js"></script>

<script type="text/javascript">
  //global variable
  var employee_table;
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
  var session_id = '<?php echo $session['employee_id']; ?>';

  var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
  var loading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
  loading_html_text = loading_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
  loading_html_text = loading_html_text + '<h2>LOADING...</h2>';
  loading_html_text = loading_html_text + '</div>';

  $(document).ready(function() {

    $('.select_hrm').select2({
                width: '100%',
                // dropdownParent: $("#container_modal_mulai_screening")
            });

    var project = document.getElementById("aj_project").value;
    var sub_project = document.getElementById("aj_sub_project").value;
    var status = document.getElementById("aj_keyword").value;
    var search_periode_from = "";
    var search_periode_to = "";

    employee_table = $('#tabel_employees').DataTable().on('search.dt', () => eventFired('Search'));

  });
</script>


<!-- Tombol Filter -->
<script type="text/javascript">

  //global variable
  var tabel_client;
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
  var session_id = '<?php echo $session['employee_id']; ?>';

  FilePond.registerPlugin(
    FilePondPluginFileEncode,
    FilePondPluginFileValidateType,
    FilePondPluginFileValidateSize,
    FilePondPluginFileRename,
    // FilePondPluginImageEdit,
    FilePondPluginImageExifOrientation,
    FilePondPluginImagePreview
  );

  //create object filepond untuk npwp
  var pond_exitclear = FilePond.create(document.querySelector('input[id="file_exitclear"]'), {
    labelIdle: 'Drag & Drop file NPWP atau klik <span class="filepond--label-action">Browse</span>',
    imagePreviewHeight: 170,
    maxFileSize: "5MB",
    acceptedFileTypes: ['image/png', 'image/jpeg', 'application/pdf'],
    imageCropAspectRatio: "1:1",
    imageResizeTargetWidth: 200,
    imageResizeTargetHeight: 200,
    fileRenameFunction: (file) => {
      return `exit${file.extension}`;
    }
  });

  //create object filepond untuk npwp
  var pond_resign = FilePond.create(document.querySelector('input[id="file_resign"]'), {
    labelIdle: 'Drag & Drop file NPWP atau klik <span class="filepond--label-action">Browse</span>',
    imagePreviewHeight: 170,
    maxFileSize: "5MB",
    acceptedFileTypes: ['image/png', 'image/jpeg', 'application/pdf'],
    imageCropAspectRatio: "1:1",
    imageResizeTargetWidth: 200,
    imageResizeTargetHeight: 200,
    fileRenameFunction: (file) => {
      return `resign${file.extension}`;
    }
  });

  document.getElementById("filter_employee").onclick = function(e) {
    employee_table.destroy();

    e.preventDefault();

    var project = document.getElementById("aj_project").value;
    var sub_project = document.getElementById("aj_sub_project").value;
    var status = document.getElementById("aj_keyword").value;

    var searchVal = $('#tabel_employees_filter').find('input').val();

    if ((searchVal == "") && (project == "0")) {
      $('#button_download_data').attr("hidden", true);

    } else {
      $('#button_download_data').attr("hidden", false);

      employee_table = $('#tabel_employees').DataTable({
        //"bDestroy": true,
        'processing': true,
        'serverSide': true,
        // 'stateSave': true,
        'bFilter': true,
        'serverMethod': 'post',
        //'dom': 'plBfrtip',
        'dom': 'lfrtip',
        //"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
        //'columnDefs': [{
        //  targets: 11,
        //  type: 'date-eu'
        //}],
        // 'order': [
        //   [4, 'asc']
        // ],
        'ajax': {
          'url': '<?= base_url() ?>admin/Employee_resign_new/list_employees',
          data: {
            [csrfName]: csrfHash,
            session_id: session_id,
            project: project,
            sub_project: sub_project,
            status: status,
            //base_url_catat: base_url_catat
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
            data: 'employee_id',
            "orderable": false,
            //searchable: true
          },
          {
            data: 'ktp_no',
            "orderable": false,
            //searchable: true
          },
          {
            data: 'first_name',
            "orderable": false,
            //searchable: true
          },
          {
            data: 'project',
            "orderable": false
          },
          {
            data: 'designation_name',
            "orderable": false,
          },
          {
            data: 'penempatan',
            "orderable": false,
          },
          {
            data: 'join',
            "orderable": false,
          },
          {
            data: 'leave',
            "orderable": false,
          },
          {
            data: 'status_sk',
            "orderable": false,
          },
        ]
      }).on('search.dt', () => eventFired('Search'));

      $('#tombol_filter').attr("disabled", false);
      $('#tombol_filter').removeAttr("data-loading");
    }

    // alert(project);
    // alert(sub_project);
    // alert(status);
  };
</script>


<!-- Tombol Open Form Pengajuan -->
<script type="text/javascript">
  function open_pengajuan(nip) {

    pond_exitclear.removeFile();
    pond_resign.removeFile();
    // alert(nip);
    // AJAX untuk ambil data buku tabungan employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employee_resign_new/get_data_employee/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: nip,
      },
      beforeSend: function() {
        $('#judul-modal-edit').html("File Exit Clearance");
        // $('#button_download_dokumen_conditional').html("");
        // $('.isi-modal').html(loading_html_text);
        // $('#button_save_pin').attr("hidden", true);
        $('#editRekeningModal').appendTo("body").modal('show');

        // $('#editRekeningModal').modal('show');
        // $('.info-modal-edit-rekening').attr("hidden", false);
        // $('.isi-modal-edit-rekening').attr("hidden", true);
        // $('.info-modal-edit-rekening').html(loading_html_text);
        // $('#button_save_rekening').attr("hidden", true);
      },
      success: function(response) {
        // alert("TES1");
        var res = jQuery.parseJSON(response);
        const uniqueTimestamp = Date.now();

        pond_exitclear.setOptions({
            server: {
              process: {
                url: 'https://karir.onecorp.co.id/upload/upload_dokumen_eksternal',
                // url: '<?= base_url() ?>admin/Employee_resign_new/list_employees',

                method: 'POST',
                ondata: (formData) => {
                  formData.append('id_client', res);
                  formData.append('nama_client', uniqueTimestamp);
                  formData.append('identifier', 'cis_exitclear');
                  formData.append([csrfName], csrfHash);
                  return formData;
                },
                // onload: (response) => response.key,
                onload: (res) => {
                  // select the right value in the response here and return
                  // return res;
                  var serverResponse = jQuery.parseJSON(res);
                  $('#link_file_exitclear').val(serverResponse['0']['link_file']);
                  // serverResponse = JSON.parse(res);
                  // console.log(serverResponse['0']['link_file']);
                  // alert(serverResponse['0']['link_file']);
                }
              },
            }
          });


        pond_resign.setOptions({
            server: {
              process: {
                url: 'https://karir.onecorp.co.id/upload/upload_dokumen_eksternal',
                // url: '<?= base_url() ?>admin/Employee_resign_new/list_employees',

                method: 'POST',
                ondata: (formData) => {
                  formData.append('id_client', res);
                  formData.append('nama_client', uniqueTimestamp);
                  formData.append('identifier', 'cis_resign');
                  formData.append([csrfName], csrfHash);
                  return formData;
                },
                // onload: (response) => response.key,
                onload: (res) => {
                  // select the right value in the response here and return
                  // return res;
                  var serverResponse = jQuery.parseJSON(res);
                  $('#link_file_resign').val(serverResponse['0']['link_file']);
                  // serverResponse = JSON.parse(res);
                  // console.log(serverResponse['0']['link_file']);
                  // alert(serverResponse['0']['link_file']);
                }
              },
            }
          });

        if (res['status'] == "200") {

          $('#fullname_modal').html(res['data']['employee_id'] + ' / ' +res['data']['first_name']);
          $('#nikpt_modal').html(res['data']['ktp_no'] + ' / ' +res['data']['company_name']);
          $('#propos_modal').html(res['data']['project_name'] + ' / ' +res['data']['designation_name']);
          $('#periode_modal').html(res['data']['periode']);
          $('#joindate_field').val(res['data']['join_date']);
          $('#leavedate_field').val(res['data']['leave_date']);

          $('#field_employee_id').val(res['data']['employee_id']);
          $('#field_fullname').val(res['data']['first_name']);
          $('#field_ktp').val(res['data']['ktp_no']);
          $('#field_jabatan').val(res['data']['designation_name']);
          $('#field_project_id').val(res['data']['project_id']);
          $('#field_project_name').val(res['data']['project_name']);
          $('#field_company_id').val(res['data']['company_id']);
          $('#field_company_name').val(res['data']['company_name']);

          $('#status_resign_select').val(res['data']['status_resign']).change();
          if(res['data']['status_resign']=="2"){
            $('#input_exit_clearance').attr("hidden", false);
            $('#input_surat_resign').attr("hidden", false);

          } else if (res['data']['status_resign']=="4"){
            $('#input_exit_clearance').attr("hidden", false);
            $('#input_surat_resign').attr("hidden", true);
          } else {

            $('#input_exit_clearance').attr("hidden", false);
            $('#input_surat_resign').attr("hidden", true);
          }


        } else {
          html_text = res['pesan'];
          // $('.isi-modal').html(html_text);
          // $('#button_save_pin').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        alert("error");
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.isi-modal').html(html_text); //coba pake iframe
        $('#button_save_pin').attr("hidden", true);
      }
    });

  }

  // function open_upload_buku_tabungan(nip) {
  //   $('#form_upload_buku_tabungan').attr("hidden", false);
  //   $('#button_open_upload_buku_tabungan').attr("hidden", true);
  // }
</script>

<script>
  $('#status_resign_select').change(function() {
    var status_r = $(this).val();

    // alert("Jabatan: " + jabatan);

    if ((status_r == "2")) {
            $('#input_exit_clearance').attr("hidden", false);
            $('#input_surat_resign').attr("hidden", false);
    } else if ((status_r == "4")) {
            $('#input_exit_clearance').attr("hidden", false);
            $('#input_surat_resign').attr("hidden", true);
    } else {

            $('#input_exit_clearance').attr("hidden", false);
            $('#input_surat_resign').attr("hidden", true);
    }
  });
</script>


<!-- button next kontak client -->
<script>
  function next_kontak_client() {
    var employee_id = $("#field_employee_id").val();
    var employee_name = $("#field_fullname").val();
    var ktp = $("#field_ktp").val();
    var jabatan = $("#field_jabatan").val();
    var project_id = $("#field_project_id").val();
    var project_name = $("#field_project_name").val();
    var company_id = $("#field_company_id").val();
    var company_name = $("#field_company_name").val();
    var join_date = $("#joindate_field").val();
    var resign_date = $("#leavedate_field").val();
    var bpjs_join = $("#joindate_field").val();
    var bpjs_date = $("#leavedate_field").val();
    var resign_status = $("#status_resign_select").val();
    var exit_clearance = $("#link_file_exitclear").val();
    var resign_letter = $("#link_file_resign").val();


    var pesan_joindate ="";
    var pesan_leavedate ="";

    if (join_date == "") {
          pesan_joindate = "<small style='color:#FF0000;'>Tanggal Bergabung tidak boleh kosong..!</small>";
          $('#pesan_perusahaan_id_modal').focus();
    }
    if (resign_date == "") {
          pesan_leavedate = "<small style='color:#FF0000;'>Tanggal Resign tidak boleh kosong..!</small>";
          $('#pesan_leavedate').focus();
    }

    $('#pesan_joindate').html(pesan_joindate);
    $('#pesan_leavedate').html(pesan_leavedate);

    if(pesan_joindate!="" || pesan_leavedate!=""){

    } else {
    // AJAX untuk save data diri
      $.ajax({
        url: '<?= base_url() ?>admin/Employee_resign_new/save_pengajuan_skk/',
        method: 'post',
        data: {
          [csrfName]: csrfHash,
          employee_id: employee_id,
          employee_name: employee_name,
          jenis_dokumen: '0',
          nomor_dokumen: '0',
          ktp: ktp,
          posisi_jabatan: jabatan,
          project_id: project_id,
          project_name: project_name,
          company: company_id,
          company_name: company_name,
          join_date: join_date,
          resign_date: resign_date,
          bpjs_join: bpjs_join,
          bpjs_date: bpjs_date,
          resign_status: resign_status,
          exit_clearance: exit_clearance,
          resign_letter: resign_letter,

        },
        beforeSend: function() {},
        success: function() {

          employee_table.ajax.reload(null, true);
          // tabel_employees.ajax.reload(null, false);

          alert("Behasil simpan Pengajuan Paklaring");
          $('#editRekeningModal').modal('hide');
        },
        error: function(xhr, status, error) {
          alert("error save kontak client");
        }
      });
    }

  }
</script>

<!-- Tombol Download Data -->
<script type="text/javascript">
  document.getElementById("button_download_data").onclick = function(e) {
    var project = document.getElementById("aj_project").value;
    var sub_project = document.getElementById("aj_sub_project").value;
    var status = document.getElementById("aj_keyword").value;

    // ambil input search dari datatable
    var filter = $('.dataTables_filter input').val(); //cara 1
    var searchVal = $('#tabel_employees_filter').find('input').val(); //cara 2

    if (searchVal == "") {
      searchVal = "-no_input-";
    }

    var text_pesan = "Project: " + project;
    text_pesan = text_pesan + "\nSub Project: " + sub_project;
    text_pesan = text_pesan + "\nStatus: " + status;
    text_pesan = text_pesan + "\nSearch: " + searchVal;
    // alert(text_pesan);

    window.open('<?php echo base_url(); ?>admin/reports/printExcel/' + project + '/' + sub_project + '/' + status + '/' + searchVal + '/' + session_id + '/', '_self');

  };

  //-----lihat employee-----
  function viewEmployee(id) {
    //alert("masuk fungsi lihat. id: " + id);
    window.open('<?= base_url() ?>admin/employees/emp_view/' + id, "_blank");
  }

  //-----lihat dokumen employee-----
  function viewDocumentEmployee(id) {
    //alert("masuk fungsi lihat. id: " + id);
    $('#dokumenModal').appendTo("body").modal('show');
    // $('#dokumenModal').modal('show');
    // window.open('<?= base_url() ?>admin/employees/emp_edit/' + id, "_blank");
  }

  // employee_table.on('search.dt', function() {
  //   alert("ada search");
  // });

  function eventFired(type) {
    var searchVal = $('#tabel_employees_filter').find('input').val();
    var project = document.getElementById("aj_project").value;
    var sub_project = document.getElementById("aj_sub_project").value;
    var status = document.getElementById("aj_keyword").value;
    // alert(searchVal.length);

    if ((searchVal.length <= 2) && (project == "0")) {
      $('#button_download_data').attr("hidden", true);
    } else {

      $('#button_download_data').attr("hidden", false);
    }
    // let n = document.querySelector('#demo_info');
    // n.innerHTML +=
    //   '<div>' + type + ' event - ' + new Date().getTime() + '</div>';
    // n.scrollTop = n.scrollHeight;

  }
</script>

<!-- Project - Sub Project -->
<script>
  // Project Vacant Change - Jabatan vacant
    $('#aj_project').change(function() {
        var project = $(this).val();

        // alert("Project: " + project);

        // AJAX request Jabatan
        $.ajax({
            url: '<?= base_url() ?>admin/Employee_resign_new/get_subprojects/',
            method: 'post',
            data: {
                [csrfName]: csrfHash,
                project: project,
            },
            // dataType: 'json',
            success: function(response) {
                var res = jQuery.parseJSON(response);

                // Remove options
                $('#aj_sub_project').find('option').not(':first').remove();

                // Add options
                $.each(res, function(index, data) {
                    $('#aj_sub_project').append('<option value="' + data['project_id'] + '" style="text-wrap: wrap;">' + data['sub_project_name'] + '</option>');
                });

                // alert("Company name: " + res["company"]["company_name"]);
            }
        });
    });

</script>


<style type="text/css">
  
  input[type=file]::file-selector-button {
  margin-right: 20px;
  border: none;
  background: #26ae61;
  padding: 10px 20px;
  border-radius: 2px;
  color: #fff;
  cursor: pointer;
  transition: background .2s ease-in-out;
}

input[type=file]::file-selector-button:hover {
  background: #20c997;
}
</style>


<!-- Event filepond-->
<script>
  document.addEventListener('FilePond:processfiles', (e) => {
    // alert("selesai upload file");
    // $('#button_next_dokumen_client').attr("hidden", false);
    // console.log('FilePond ready for use', e.detail);

    // // get create method reference
    // const { create } = e.detail;FilePond:processfilestart
  });

  document.addEventListener('FilePond:processfile', (e) => {
    // alert("selesai upload file");
    // $('#button_next_dokumen_client').attr("hidden", false);
    // console.log('FilePond ready for use', e.detail);

    // // get create method reference
    // const { create } = e.detail;FilePond:processfilestart
  });

  document.addEventListener('FilePond:error', (e) => {
    // alert("selesai upload file");
    // $('#button_next_dokumen_client').attr("hidden", false);
    // console.log('FilePond ready for use', e.detail);

    // // get create method reference
    // const { create } = e.detail;FilePond:processfilestart
  });

  document.addEventListener('FilePond:processfileabort', (e) => {
    // alert("selesai upload file");
    // $('#button_next_dokumen_client').attr("hidden", false);
    // console.log('FilePond ready for use', e.detail);

    // // get create method reference
    // const { create } = e.detail;FilePond:processfilestart
  });

  document.addEventListener('FilePond:processfilestart', (e) => {
    // alert("mulai upload file");
    // $('#button_next_dokumen_client').attr("hidden", true);
    // console.log('FilePond ready for use', e.detail);

    // // get create method reference
    // const { create } = e.detail;FilePond:addfilestart
  });

  document.addEventListener('FilePond:addfilestart', (e) => {
    // alert("mulai add file");
    // $('#button_next_dokumen_client').attr("hidden", true);
    // console.log('FilePond ready for use', e.detail);

    // // get create method reference
    // const { create } = e.detail;FilePond:addfilestart 
  });

  pond_exitclear.on('processfiles', (error, file) => {
    $('#status_file_exitclear').val("1");
  }); 


  pond_exitclear.on('removefile', (error, file) => {
    // alert("remove file " + file['name']); ->
    $('#status_file_exitclear').val("0");
  });

  pond_resign.on('processfiles', (error, file) => {
    $('#status_file_resign').val("1");
  }); 


  pond_resign.on('removefile', (error, file) => {
    // alert("remove file " + file['name']); ->
    $('#status_file_resign').val("0");
  });
</script>
