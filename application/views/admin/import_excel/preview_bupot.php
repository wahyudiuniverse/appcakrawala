<!-- Filepond css -->
<link rel="stylesheet" href="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond/filepond.min.css" type="text/css" />
<!-- <link href="assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css" type="text/css" />


<?php
/* Bupot view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<!-- Modal -->
<div class="modal fade" id="viewDetailModal" tabindex="-1" role="dialog" aria-labelledby="viewDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewDetailModalLabel">
          <div class="judul-modal">
            Detail data
          </div>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"> x </span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal">
          ...
        </div>
        <div class="info-modal">
          ...
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Close </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Error -->
<div class="modal fade" id="modal-error" tabindex="-1" role="dialog" aria-labelledby="modal-errorLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-errorLabel">
          <div class="judul-modal-error">
            Pesan Error
          </div>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"> x </span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-error">
          ...
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Close </button>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <!-- Section Data PKWT -->
  <div class="card-header with-elements">
    <div class="col-md-6">
      <span class="card-header-title mr-2"><strong>DATA BATCH </strong> | BUPOT</span>
    </div>
    <div class="col-md-6">
      <div class="pull-right">
        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewDetailModal">
          Launch demo modal
        </button> -->
        <!-- <span class="card-header-title mr-2">
          <button id="button_save_attribut" class="btn btn-primary ladda-button" data-style="expand-right">Save Atribut Batch</button>
        </span> -->
      </div>
    </div>
  </div>

  <div class="card-body">

    <div class="form-body">
      <div class="form-row">
        <div class="col-md-4">
          <div class="form-group">
            <label class="form-label">Project</label>
            <input readonly class="form-control" placeholder="Project" name="project" id="project" type="text" value="<?php echo $batch_bupot['project_name']; ?>">
          </div>
        </div>

        <div class="col-md-8">
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Sub Project</label>
                <input readonly class="form-control" placeholder="Sub Project" name="sub_project" id="sub_project" type="text" value="<?php echo $batch_bupot['sub_project_name']; ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Periode Bupot</label>
                <input type="text" class="form-control" readonly name="periode_bupot" id="periode_bupot" placeholder="Periode Saltab To" value="<?php echo $batch_bupot['periode_bupot']; ?>">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label class="form-label">Upload File PDF BUPOT (Maksimum 10 file)<font color="#FF0000">*</font></label>
            <input type="file" class="filepond filepond-input-multiple" multiple id="file_bupot" data-allow-reorder="true" data-max-file-size="64MB" data-max-files="10" accept="application/zip, application/x-zip-compressed, multipart/x-zip, application/pdf, application/vnd.rar, application/x-rar-compressed">
            <small class="text-muted">File bertipe pdf, zip atau rar. Ukuran maksimal 64 MB</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="card mt-2">

  <div class="card-header with-elements">
    <div class="col-md-6">
      <span class="card-header-title mr-2"><strong>LIST ALL</strong> | Detail BUPOT</span>
    </div>
  </div>
  <div class=" card-body">
    <div class="box-datatable table-responsive" id="btn-place">
      <table class="display dataTable table table-striped table-bordered" id="detail_bupot" style="width:100%">
        <thead>
          <tr>
            <th>Aksi</th>
            <th>NIK</th>
            <th>No. BUPOT</th>
            <th>Nama</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<!-- </div> -->

<!-- filepond js -->
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond/filepond.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-file-rename/filepond-plugin-file-rename.js"></script>

<script>
  var detail_bupot;

  var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
  var loading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
  loading_html_text = loading_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
  loading_html_text = loading_html_text + '<h2>LOADING...</h2>';
  loading_html_text = loading_html_text + '</div>';

  var uploading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
  var uploading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
  uploading_html_text = uploading_html_text + '<img src="' + uploading_image + '" alt="" width="100px">';
  uploading_html_text = uploading_html_text + '<h2>PROCESSING...</h2>';
  uploading_html_text = uploading_html_text + '</div>';

  var success_image = "<?php echo base_url('assets/icon/ceklis_hijau.png'); ?>";
  var success_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
  success_html_text = success_html_text + '<img src="' + success_image + '" alt="" width="100px">';
  success_html_text = success_html_text + '<h2 style="color: #00FFA3;">BERHASIL UPDATE DATA</h2>';
  success_html_text = success_html_text + '</div>';

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

  var id_batch = '<?php echo $id_batch; ?>';
  if ((id_batch == null) || (id_batch == "")) {
    id_batch = 0;
  }

  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

  var nama_project_only = '<?php echo $nama_project_only; ?>';
  var periode_bupot = '<?php echo $batch_bupot['periode_bupot']; ?>';

  $(document).ready(function() {
    //alert(id_batch);
    $('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
    $('[data-plugin="xin_select"]').select2({
      width: '100%'
    });

    //append id_client ke objek filepond npwp
    pond_bupot.setOptions({
      server: {
        process: {
          url: 'https://karir.onecorp.co.id/upload/upload_dokumen_eksternal',
          // url: 'http://localhost/appjoborder/upload/upload_dokumen_eksternal',
          method: 'POST',
          ondata: (formData) => {
            formData.append('identifier', "bupot");
            formData.append('project_name', nama_project_only);
            formData.append('periode_bupot', periode_bupot);
            // formData.append([csrfName], csrfHash);
            return formData;
          }
        },
      }
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
          $(response).each(function(index, data) {
            $('#sub_project').append('<option value="' + data['secid'] + '">' + data['sub_project_name'] + '</option>');
          }).show();
        },
        error: function(xhr, ajaxOptions, thrownError) {
          var error_text = "Error Load Data Sub Project. Status : " + xhr.status;
          $('.judul-modal-error').html("ERROR ! ");
          $('.isi-modal-error').html(xhr.responseText);
          $('#modal-error').modal('show');
        },
      });
    });

    detail_bupot = $('#detail_bupot').DataTable({
      //"bDestroy": true,
      'processing': true,
      'serverSide': true,
      //'stateSave': true,
      'bFilter': true,
      'serverMethod': 'post',
      //'dom': 'plBfrtip',
      'dom': 'lBfrtip',
      "buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
      //'columnDefs': [{
      //  targets: 11,
      //  type: 'date-eu'
      //}],
      'order': [
        [3, 'asc']
      ],
      'ajax': {
        'url': '<?= base_url() ?>admin/importexcel/list_detail_bupot',
        data: {
          [csrfName]: csrfHash,
          id_batch: id_batch,
          // nip: nip,
          // contract_id: contract_id,
          //idsession: idsession,
          // emp_id: emp_id
          //base_url_catat: base_url_catat
        },
        error: function(xhr, ajaxOptions, thrownError) {
          var error_text = "Error Load Data Table. Status : " + xhr.status;
          $('.judul-modal-error').html("ERROR ! ");
          $('.isi-modal-error').html(xhr.responseText);
          $('#modal-error').modal('show');
        },
      },
      'columns': [{
          data: 'aksi',
          "orderable": false
        },
        {
          data: 'nik',
          //"orderable": false,
          //searchable: true
        },
        {
          data: 'no_bukti_potong',
          //"orderable": false,
          //searchable: true
        },
        {
          data: 'nama_penerima_penghasilan',
          //"orderable": false
        },
      ]
    });

  });

  //-----delete detail bupot-----
  function deleteDetailBupot(id) {
    // alert("masuk fungsi delete detail saltab. id: " + id);
    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Importexcel/delete_detail_bupot/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id: id
      },
      success: function(response) {
        alert("Berhasil Delete Data");
        detail_bupot.ajax.reload(null, false);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        var error_text = "Gagal Delete Data Saltab. Status : " + xhr.status;
        alert(error_text);
        // $('.judul-modal-error').html("ERROR ! ");
        // $('.isi-modal-error').html(xhr.responseText);
        // $('#modal-error').modal('show');
      },
    });
    // alert("Beres Ajax. id: " + id);
  }

  //-----lihat detail bupot-----
  function lihatDetailBupot(id) {
    var html_text = '<table class="table table-striped col-md-12"><thead class="thead-dark"><tr><th class="col-md-4">ATRIBUT</th><th class="col-md-8">VALUE</th></thead></tr>';
    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/importexcel/get_detail_bupot/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id: id,
      },
      dataType: 'json',
      beforeSend: function() {
        $('.info-modal').attr("hidden", false);
        $('.isi-modal').attr("hidden", true);
        $('.info-modal').html(loading_html_text);
        $('#viewDetailModal').modal('show');
      },
      success: function(response) {
        // var response2 = JSON.parse(response);
        // Add options
        $(response).each(function(index, data) {
          html_text = html_text + "<tr><td>" + data[0] + "</td><td>" + data[1] + "</td></tr>";
          // html_text = html_text + data;
        });
        // html_text = html_text + response;

        html_text = html_text + "</table>";
        // alert(html_text);
        $('.isi-modal').html(html_text);

        $('.isi-modal').attr("hidden", false);
        $('.info-modal').attr("hidden", true);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal').html(html_text); //coba pake iframe
        $('.isi-modal').attr("hidden", true);
        $('.info-modal').attr("hidden", false);
      },
    });

    // alert("masuk fungsi lihat. id: " + id);
    // var html_text = 'This is the dummy data added using jQuery. Id: ' + id;

    // window.open('<?= base_url() ?>admin/Importexcel/view_batch_saltab_temporary/' + id, "_self");
  }
</script>