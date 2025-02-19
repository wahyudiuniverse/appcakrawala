<!-- Filepond css -->
<link rel="stylesheet" href="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond/filepond.min.css" type="text/css" />
<!-- <link href="assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css" type="text/css" />

<?php
/* Employee Import view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<!-- Modal -->
<div class="modal fade" id="requestOpenModal" tabindex="-1" role="dialog" aria-labelledby="requestOpenModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title" id="requestOpenModalLabel">
          <div class="judul-modal">
            <img src='<?php echo base_url('/assets/icon/warning.png'); ?>' width='30'>
            <font color="#FFFFFF"> Import Periode Saltab Dikunci </font>
            <!-- <img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'> -->
          </div>
        </h5>
        <button type="button" name="button_close2" id="button_close2" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">
            <font color="#FFFFFF"> x </font>
          </span>
        </button>
      </div>
      <div class="modal-body">
        <div class="pesan-modal"></div>
        <div class="pesan-request-modal"></div>
      </div>
      <div class="modal-footer">
        <button type="button" name="button_request" id="button_request" class="btn btn-primary"> Request Open </button>
        <button type="button" name="button_close" id="button_close" class="btn btn-secondary" data-dismiss="modal"> Close </button>
      </div>
    </div>
  </div>
</div>

<?php
if (in_array('511', $role_resources_ids)) {
?>

  <div class="card border-blue">
    <!-- <div class="card-header with-elements">
      <span class="card-header-title mr-2">
        <strong>E-SALTAB | </strong>IMPORT FILE
      </span>
    </div> -->

    <div class="card-header with-elements">
      <div class="col-md-6">
        <span class="card-header-title mr-2">
          <strong>BUPOT | </strong>IMPORT BATCH
        </span>
      </div>

      <div class="col-md-6">
        <div class="pull-right">
          <!-- <div class="card-header with-elements"> -->
          <span class="card-header-title mr-2">
            <a href="<?php echo base_url(); ?>admin/importexcel/downloadTemplateBupot" class="btn btn-primary">
              <i class="fa fa-download"></i>
              Download template bupot
            </a>
          </span>
          <!-- </div> -->
        </div>
      </div>
    </div>

    <?php
    $attributes = array('class' => 'myform', 'id' => 'myform');
    echo form_open_multipart('/admin/importexcel/import_excel_bupot/', $attributes);
    ?>

    <div class="card-body border-bottom-blue ">

      <input type="hidden" id="nik" name="nik" value=<?php echo $session['employee_id']; ?>>

      <div class="form-row">
        <div class="col-md-8">
          <div class="form-group">
            <fieldset class="form-group">
              <label for="file_excel">Upload File Excel<font color="#FF0000">*</font></label>
              <input class="form-control" type="file" id="file_excel" name="file_excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
              <small>Please select .xlsx file (allowed file size max 5MB)</small>
            </fieldset>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label class="form-label">Periode Bupot (Tahun)<font color="#FF0000">*</font></label>
            <input class="form-control" name="periode_bupot" id="periode_bupot" type="number" required></input>
          </div>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="form-label">Project<font color="#FF0000">*</font></label>
            <select class="form-control" data-live-search="true" name="project" id="project" data-plugin="xin_select" data-placeholder="Project" required>
              <option value="">Pilih Project</option>
              <?php foreach ($all_projects as $proj) { ?>
                <option value="<?php echo $proj->project_id; ?>"> <?php echo $proj->title; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label class="form-label">Sub Project<font color="#FF0000">*</font></label>
            <select class="form-control" data-live-search="true" name="sub_project" id="sub_project" data-plugin="xin_select" data-placeholder="Sub-Project" required>
              <option value="0">--ALL--</option>
            </select>
          </div>
        </div>

        <!-- <div class="col-md-12">
          <div class="form-group">
            <label class="form-label">File PDF BUPOT (Maksimum 10 file)<font color="#FF0000">*</font></label>
            <input type="file" class="filepond filepond-input-multiple" multiple id="file_bupot" data-allow-reorder="true" data-max-file-size="64MB" data-max-files="10" accept="application/zip, application/x-zip-compressed, multipart/x-zip, application/pdf, application/vnd.rar, application/x-rar-compressed">
            <small class="text-muted">File bertipe pdf, zip atau rar. Ukuran maksimal 64 MB</small>
          </div>
        </div> -->
      </div>

      <div class="form-row">
        <div class="col-md mb-12">
          <div class="form-group">
            <!-- button submit -->
            <button type="submit" id="button_submit" name="button_submit" class="btn btn-primary btn-block"><i class="fa fa-upload"></i> IMPORT</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php echo form_close(); ?>

<?php
}
?>

<!-- <div id="ms1" class="form-control"></div> -->
<!-- <div id="langOpt" class="form-control"></div> -->

<!-- <?php
      // echo '<pre>';
      // print_r($tabel_saltab);
      // echo '</pre>';
      ?> -->
<div class="card <?php echo $get_animate; ?> mt-2">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>BUPOT |</strong> LIST BATCH</span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive" id="btn-place">
      <table class="display dataTable table table-striped table-bordered" id="bupot_table" style="width:100%">
        <thead>
          <tr>
            <th>Aksi</th>
            <th>Periode Bupot</th>
            <th>Project</th>
            <th>Sub Project</th>
            <th>Jumlah Data</th>
            <th>Status Release</th>
            <th>Upload by</th>
            <th>Upload on</th>
          </tr>
        </thead>
      </table>
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

<script>
  //global variable
  var ms1;
  var langopt;
  var bupot_table;

  FilePond.registerPlugin(
    FilePondPluginFileEncode,
    FilePondPluginFileValidateType,
    FilePondPluginFileValidateSize,
    FilePondPluginFileRename,
    // FilePondPluginImageEdit,
    FilePondPluginImageExifOrientation,
    FilePondPluginImagePreview
  );

  //create object filepond untuk file bupot
  var pond_bupot = FilePond.create(document.querySelector('input[id="file_bupot"]'), {
    labelIdle: 'Drag & Drop file BUPOT atau klik <span class="filepond--label-action">Browse</span>',
    labelFileTypeNotAllowed: 'Format tidak sesuai',
    // allowMultiple: 1,
    // maxParallelUploads: 10,
    fileValidateTypeLabelExpectedTypes: 'Format hanya pdf, zip atau rar',
    imagePreviewHeight: 170,
    maxFileSize: "64MB",
    // acceptedFileTypes: ['*'],
    imageCropAspectRatio: "1:1",
    imageResizeTargetWidth: 200,
    imageResizeTargetHeight: 200,
    // fileRenameFunction: (file) => {
    //   return `bupot${file.extension}`;
    // }
  });

  var session_id = '<?php echo $session['employee_id']; ?>';
  //var myData = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Philadelphia', 'Phoenix', 'San Antonio', 'San Diego', 'Dallas', 'San Jose', 'Jacksonville', "Algiers", "Annaba", "Azazga", "Batna City", "Blida", "Bordj", "Bordj Bou Arreridj", "Bougara", "Cheraga", "Chlef", "Constantine", "Djelfa", "Draria", "El Tarf", "Hussein Dey", "Illizi", "Jijel", "Kouba", "Laghouat", "Oran", "Ouargla", "Oued Smar", "Relizane", "Rouiba", "Saida", "Souk Ahras", "Tamanghasset", "Tiaret", "Tissemsilt", "Tizi", "Tizi Ouzou", "Tlemcen"];
  // var myData = JSON.parse('<?php //echo json_encode($tabel_saltab); 
                              ?>');
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';


  $(document).ready(function() {

    // var idsession = "<?php print($session['employee_id']); ?>";

    // baseURL variable
    var baseURL = "<?php echo base_url(); ?>";

    //append id_client ke objek filepond npwp
    pond_bupot.setOptions({
      server: {
        process: {
          url: 'https://karir.onecorp.co.id/upload/upload_dokumen_eksternal',
          // url: 'http://localhost/appjoborder/upload/upload_dokumen_eksternal',
          method: 'POST',
          ondata: (formData) => {
            formData.append('identifier', "bupot");
            // formData.append([csrfName], csrfHash);
            return formData;
          }
        },
      }
    });


    $('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
    $('[data-plugin="xin_select"]').select2({
      width: '100%'
    });

    //$('#langOpt').multiselect();
    // $('select[multiple]').multiselect();
    // $('select[multiple].active.3col').multiselect({
    //   columns: 3,
    //   placeholder: 'Select States',
    //   search: true,
    //   searchOptions: {
    //     'default': 'Search States'
    //   },
    //   selectAll: true
    // });

    // ms1 = $('#ms1').magicSuggest({
    //   allowFreeEntries: false,
    //   data: [{
    //     id: '1',
    //     name: 'New York'
    //   }, {
    //     id: '2',
    //     name: 'Los Angeles'
    //   }, {
    //     id: '3',
    //     name: 'Chicago'
    //   }, {
    //     id: '4',
    //     name: 'Houston'
    //   }, {
    //     id: '5',
    //     name: 'Philadelphia'
    //   }]
    // });

    // langopt = $('#langOpt').magicSuggest({
    //   allowFreeEntries: false,
    //   autoSelect: true,
    //   selectFirst: true,
    //   data: myData,
    //   displayField: 'alias',
    //   valueField: 'nama_tabel',
    //   allowDuplicates: false,
    //   maxSelection: 90
    // });

    // //ambil variabel multi-select
    // $(function() {
    //   $('#fruit').change(function(e) {
    //     var selected = $(e.target).val();
    //     $("#tes_label").text(selected);
    //     //alert(selected);
    //   });
    // });

    // $(ms1).on('selectionchange', function(e, m) {
    //   //alert("values: " + JSON.stringify(this.getValue()));
    //   alert(JSON.stringify(this.getValue()));
    // });

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
          $(response).each(function(index, data) {
            $('#sub_project').append('<option value="' + data['secid'] + '">' + data['sub_project_name'] + '</option>');
          }).show();
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert("Status :" + xhr.status);
          alert("responseText :" + xhr.responseText);
        },
      });
    });

    bupot_table = $('#bupot_table').DataTable({
      //"bDestroy": true,
      'processing': true,
      'serverSide': true,
      //'stateSave': true,
      'bFilter': true,
      'serverMethod': 'post',
      //'dom': 'plBfrtip',
      'dom': 'lBfrtip',
      // "buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
      //'columnDefs': [{
      //  targets: 11,
      //  type: 'date-eu'
      //}],
      'order': [
        [7, 'desc']
      ],
      'ajax': {
        'url': '<?= base_url() ?>admin/importexcel/list_batch_bupot',
        data: {
          [csrfName]: csrfHash,
          session_id: session_id,
          // nip: nip,
          // contract_id: contract_id,
          //idsession: idsession,
          // emp_id: emp_id
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
          data: 'periode_bupot',
          // "orderable": false,
          //searchable: true
        },
        {
          data: 'project_name',
          // "orderable": false,
          //searchable: true
        },
        {
          data: 'sub_project_name',
          //"orderable": false
        },
        {
          data: 'jumlah_data',
          //"orderable": false,
        },
        {
          data: 'status_release',
          "orderable": false,
        },
        {
          data: 'created_by',
          //"orderable": false,
        },
        {
          data: 'created_on',
          //"orderable": false,
        },
      ]
    });



  });

  //-----delete batch saltab-----
  function deleteBatchBupot(id) {
    // alert("masuk fungsi delete saltab. id: " + id);
    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Importexcel/delete_batch_bupot/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id: id
      },
      success: function(response) {
        alert("Berhasil Delete Batch BUPOT");
        bupot_table.ajax.reload(null, false);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert("Gagal Delete Batch BUPOT. Status : " + xhr.status);
        alert("responseText :" + xhr.responseText);
      },
    });
    // alert("Beres Ajax. id: " + id);
  }

  //-----lihat batch saltab-----
  function lihatBatchBupot(id) {
    //alert("masuk fungsi lihat. id: " + id);
    window.open('<?= base_url() ?>admin/Importexcel/view_batch_bupot/' + id, "_blank");
  }

  //-----edit batch saltab-----
  function downloadBatchBupot(id) {
    //alert("masuk fungsi download. id: " + id);downloadDetailSaltab
    // window.open('<?= base_url() ?>admin/addendum/edit/' + id, "_blank");
    window.open('<?= base_url() ?>admin/Importexcel/downloadDetailSaltab/' + id, "_self");
  }

  // function cek_isi() {
  //   var isi = langopt.getValue();
  //   //alert("tes");
  //   alert("Isi pilihan: " + isi);
  // }
</script>

<!-- <script>
  $('form#myform').on('submit', function(e) {
    const hari_ini = new Date().toJSON().slice(0, 10);
    // const hari_ini = new Date();
    const jam_sekaran = new Date().getHours();
    const tgl_gajian = document.getElementById("periode_salary").value;

    if (tgl_gajian == hari_ini) {
      e.preventDefault();
      alert("tanggal sama");
    } else {
      alert("tanggal beda");
    }
  });
</script> -->


<!-- Cek tanggal upload -->
<script>
  // const btn = document.getElementById("button_submit");

  // btn.onclick = (e) => {
  //   var hari_ini = new Date().toJSON().slice(0, 10);
  //   var hari_ini2 = new Date();
  //   var jam_sekarang = new Date().getHours();
  //   var waktu_sekarang = new Date().getHours() + ":" + new Date().getMinutes() + ":" + new Date().getSeconds();

  //   var project_id = document.getElementById("project").value;
  //   var project_name = $('#project').find(":selected").text();
  //   var sub_project_id = document.getElementById("sub_project").value;
  //   var sub_project_name = $('#sub_project').find(":selected").text();
  //   var periode_bupot = document.getElementById("periode_bupot").value;

  //   var file_data = $('#file_excel').prop('files')[0];
  //   var fileName = file_data.name;
  //   var fileSize = file_data.size;
  //   var status = "";

  //   // var form = $('.myform');

  //   var kondisi = "";
  //   var html_text = '<div class="container"><div class="row"><table class="table table-striped col-md-12"><thead class="thead-dark"><tr><th class="col-4">ATRIBUT</th><th class="col-8">VALUE</th></thead></tr>';
  //   html_text = html_text + "<tr><td>" + "Project" + "</td><td><input type='text' class='form-control' readonly placeholder='Project' value='" + project_name + "'></td></tr>";
  //   html_text = html_text + "<tr><td>" + "Sub Project" + "</td><td><input type='text' class='form-control' readonly placeholder='Sub Project' value='" + sub_project_name + "'></td></tr>";
  //   html_text = html_text + "<tr><td>" + "Tanggal Penggajian" + "</td><td><input id='tanggal_penggajian_modal' name='tanggal_penggajian_modal' type='text' class='form-control' readonly placeholder='Tanggal Penggajian' value='" + tgl_gajian + "'></td></tr>";
  //   html_text = html_text + "<tr><td>" + "Periode Saltab From" + "</td><td><input id='saltab_from_modal' name='saltab_from_modal' type='text' class='form-control' readonly placeholder='Periode Saltab From' value='" + periode_saltab_from + "'></td></tr>";
  //   html_text = html_text + "<tr><td>" + "Periode Saltab To" + "</td><td><input id='saltab_to_modal' name='saltab_to_modal' type='text' class='form-control' readonly placeholder='Periode Saltab To' value='" + periode_saltab_to + "'></td></tr>";
  //   html_text = html_text + "<tr><td>" + "Alasan pengajuan buka kunci" + "</td><td><textarea id='note_open' name='note_open' class='form-control' rows='4'></textarea></td></tr>";
  //   html_text = html_text + "</div></div>";

  //   pesan_request = "";

  //   // alert(project_name + " - " + sub_project_name);
  //   // alert(jam_sekarang);

  //   if (fileName == "" || project_id == "" || sub_project_id == "" || tgl_gajian == "" || periode_saltab_from == "" || periode_saltab_to == "") {
  //     //do nothing. Jalankan proses validasi form. Munculkan pesan untuk isi field kosong
  //   } else {
  //     //cek boleh import?
  //     if (tgl_gajian <= hari_ini) {
  //       // alert("tanggal sama");
  //       e.preventDefault(); //stop post value

  //       // AJAX request
  //       $.ajax({
  //         url: '<?= base_url() ?>admin/Importexcel/cek_request_open_import/',
  //         method: 'post',
  //         data: {
  //           [csrfName]: csrfHash,
  //           tgl_gajian: tgl_gajian,
  //           project_id: project_id,
  //           project_name: project_name,
  //           sub_project_name: sub_project_name,
  //           sub_project_id: sub_project_id,
  //           periode_saltab_from: periode_saltab_from,
  //           periode_saltab_to: periode_saltab_to,
  //           jam_sekarang: jam_sekarang
  //         },
  //         success: function(response) {
  //           var res = jQuery.parseJSON(response);

  //           if (res['status'] == "101" || res['status'] == "103" || res['status'] == "105") {
  //             $('#myform').submit();
  //           } else if (res['status'] == "104") {
  //             kondisi = res['pesan'] + "<br><small>Waktu server: " + hari_ini2 + "</small><br><br>";
  //             pesan_request = "Sudah pernah ada request open import untuk saltab ini.<br>";
  //             pesan_request = pesan_request + "Nama Project: " + res['data']['project_name'] + "<br>";
  //             pesan_request = pesan_request + "Nama Sub Project: " + res['data']['sub_project_name'] + "<br>";
  //             pesan_request = pesan_request + "Tanggal Penggajian: " + res['data']['tanggal_gajian'] + "<br>";
  //             pesan_request = pesan_request + "Periode Saltab: " + res['data']['periode_saltab_from'] + " sampai " + res['data']['periode_saltab_to'] + "<br>";
  //             pesan_request = pesan_request + "Alasan Pengajuan Buka Kunci: " + res['data']['note'] + "<br>";
  //             pesan_request = pesan_request + "Request Oleh: " + res['data']['request_by_name'] + "<br>";
  //             pesan_request = pesan_request + "Waktu Request: " + res['data']['request_on'] + "<br>";
  //             $('.pesan-modal').html(kondisi + html_text);
  //             $('.pesan-request-modal').html(pesan_request);
  //             $('#button_request').attr("hidden", true);
  //             $('#note_open').attr("readonly", true);
  //             $('#requestOpenModal').appendTo("body").modal('show');
  //           } else {
  //             kondisi = res['pesan'] + "<br><small>Waktu server: " + hari_ini2 + "</small><br><br>";
  //             $('.pesan-modal').html(kondisi + html_text);
  //             $('#requestOpenModal').appendTo("body").modal('show');
  //           }
  //         },
  //         error: function(xhr, status, error) {
  //           // var res = jQuery.parseJSON(response);
  //           kondisi = "Gagal ajax. Hari ini sudah lewat dari jam 12.<br>Waktu server: " + hari_ini2 + "<br><br>";
  //           $('.pesan-modal').html(kondisi + html_text);
  //           $('.pesan-request-modal').html(pesan_request);
  //           $('#requestOpenModal').appendTo("body").modal('show');
  //         }
  //       });
  //     }
  //   }

  // };
</script>

<!-- Tombol Request Open Import -->
<script type="text/javascript">
  document.getElementById("button_request").onclick = function(e) {
    e.preventDefault();

    var employee_id = '<?php echo $session['employee_id']; ?>';
    var user_name = "<?php print($user_info['0']->first_name); ?>";

    var note_open = $("#note_open").val();
    var hari_ini = new Date().toJSON().slice(0, 10);
    var hari_ini2 = new Date();
    var jam_sekarang = new Date().getHours();
    var waktu_sekarang = new Date().getHours() + ":" + new Date().getMinutes() + ":" + new Date().getSeconds();
    var tgl_request = hari_ini + " " + waktu_sekarang;

    var tgl_gajian = document.getElementById("periode_salary").value;
    var project_id = document.getElementById("project").value;
    var sub_project_id = document.getElementById("sub_project").value;
    var periode_saltab_from = document.getElementById("saltab_from").value;
    var periode_saltab_to = document.getElementById("saltab_to").value;

    // alert(csrfName);
    // alert(csrfHash);

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Importexcel/request_open_import/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        employee_id: employee_id,
        request_by_name: user_name,
        tgl_request: tgl_request,
        tgl_gajian: tgl_gajian,
        project_id: project_id,
        sub_project_id: sub_project_id,
        periode_saltab_from: periode_saltab_from,
        periode_saltab_to: periode_saltab_to,
        note_open: note_open,
      },
      success: function(response) {

        alert("Berhasil melakukan request");
        $('#button_submit').attr("disabled", false);
        $('#button_submit').removeAttr("data-loading");
        $('#requestOpenModal').appendTo("body").modal('hide');
      },
      error: function(xhr, status, error) {
        // var res = jQuery.parseJSON(response);
        html_text = "Gagal melakukan request.\n";
        html_text = html_text + "Error :\n";
        html_text = html_text + xhr.responseText;
        alert(html_text);
      }
    });

  };
</script>

<!-- Tombol Request Open Import -->
<script type="text/javascript">
  document.getElementById("button_close").onclick = function(e) {
    $('.pesan-modal').html("");
    $('.pesan-request-modal').html("");
    $('#button_submit').attr("disabled", false);
    $('#button_request').attr("hidden", false);
    $('#note_open').attr("readonly", false);
    $('#button_submit').removeAttr("data-loading");
  };
</script>

<!-- Tombol Request Open Import -->
<script type="text/javascript">
  document.getElementById("button_close2").onclick = function(e) {
    $('.pesan-modal').html("");
    $('.pesan-request-modal').html("");
    $('#button_submit').attr("disabled", false);
    $('#button_request').attr("hidden", false);
    $('#note_open').attr("readonly", false);
    $('#button_submit').removeAttr("data-loading");
  };
</script>