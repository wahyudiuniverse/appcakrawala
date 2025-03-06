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

<!-- MODAL RELEASE BUPOT -->
<div class="modal fade" id="releaseBupotModal" tabindex="-1" role="dialog" aria-labelledby="releaseBupotModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="releaseBupotModalLabel">Release BUPOT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-release-bupot">
          <div class="container" id="container_modal_release_bupot">
            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <td style='width:25%'><strong>Periode BUPOT</strong></td>
                    <td style='width:75%'>
                      <span id="periode_bupot_modal"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Project</strong></td>
                    <td>
                      <span id="project_modal"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Sub Project</strong></td>
                    <td>
                      <span id="sub_project_modal"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Jumlah Data</strong></td>
                    <td>
                      <span id="jumlah_data_modal"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Upload By</strong></td>
                    <td>
                      <span id="created_by_modal"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Upload On</strong></td>
                    <td>
                      <span id="created_on_modal"></span>
                      <input hidden type='text' class='form-control' name='id_batch_bupot' id='id_batch_bupot' placeholder='id batch bupot' value=''>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="info-modal-release-bupot"></div>

      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <button onclick="button_release_bupot()" id='button_release_bupot' name='button_release_bupot' type='button' class='btn btn-primary'>Release BUPOT</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL DETAIL RELEASE BUPOT -->
<div class="modal fade" id="detailReleaseBupotModal" tabindex="-1" role="dialog" aria-labelledby="detailReleaseBupotModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailReleaseBupotModalLabel">Detail Release e-Slip</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-detail-release-bupot">
          <div class="container" id="container_modal_detail_release_bupot">
            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <td style='width:25%'><strong>Periode BUPOT</strong></td>
                    <td style='width:75%'>
                      <span id="periode_bupot_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Project</strong></td>
                    <td>
                      <span id="project_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Sub Project</strong></td>
                    <td>
                      <span id="sub_project_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Jumlah Data</strong></td>
                    <td>
                      <span id="jumlah_data_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Upload By</strong></td>
                    <td>
                      <span id="created_by_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Upload On</strong></td>
                    <td>
                      <span id="created_on_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Tanggal Release BUPOT</strong></td>
                    <td>
                      <span id="release_on_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Release BUPOT By</strong></td>
                    <td>
                      <span id="release_by_modal_detail"></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="info-modal-detail-release-bupot"></div>

      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <!-- <button id='button_release_eslip' name='button_release_eslip' type='button' class='btn btn-primary'>Release e-Slip</button> -->
      </div>
    </div>
  </div>
</div>

<?php
if (in_array('1301', $role_resources_ids)) {
?>

  <div class="card border-blue">
    <!-- <div class="card-header with-elements">
      <span class="card-header-title mr-2">
        <strong>E-SALTAB | </strong>IMPORT FILE
      </span>
    </div> -->

    <!-- <pre>
      <?php //print_r($session); ?>
    </pre> -->

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

<script>
  //global variable
  var ms1;
  var langopt;
  var bupot_table;

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

    $('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
    $('[data-plugin="xin_select"]').select2({
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
          data: 'release_bupot',
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

  //-----delete batch bupot-----
  function deleteBatchBupot(id) {
    // alert("masuk fungsi delete bupot. id: " + id);
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

  //-----lihat batch bupot-----
  function lihatBatchBupot(id) {
    //alert("masuk fungsi lihat. id: " + id);
    window.open('<?= base_url() ?>admin/Importexcel/view_batch_bupot/' + id, "_blank");
  }

  //-----edit batch bupot-----
  function downloadBatchBupot(id) {
    // alert("masuk fungsi download. id: " + id);
    window.open('<?= base_url() ?>admin/Importexcel/downloadDetailBupot/' + id, "_self");
  }
</script>

<script>
  //----- release BUPOT -----
  function releaseBupot(id_batch) {
    //inisialisasi pesan
    $('#pesan_tanggal_terbit_eslip_modal').html("");
    $('#tanggal_terbit_eslip_modal').val("");

    // AJAX untuk ambil data employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Importexcel/get_data_batch_bupot/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_batch: id_batch,
      },
      beforeSend: function() {
        $('.info-modal-release-bupot').attr("hidden", false);
        $('.isi-modal-release-bupot').attr("hidden", true);
        $('.info-modal-release-bupot').html(loading_html_text);
        $('#button_release_bupot').attr("hidden", true);
        $('#releaseBupotModal').modal('show');
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          //   $('#tanggal_penggajian_modal').val(res['data']['bank_name']).change();
          $('#periode_bupot_modal').html(res['data']['periode_bupot']);
          $('#project_modal').html(res['data']['project_name']);
          $('#sub_project_modal').html(res['data']['sub_project_name']);
          $("#jumlah_data_modal").html(res['data']['jumlah_data']);
          $('#created_by_modal').html(res['data']['created_by']);
          $('#created_on_modal').html(res['data']['created_on']);
          $('#id_batch_bupot').val(id_batch);
          // $('#pesan_tanggal_terbit_eslip_modal').html("<small style='color:#FF0000;'>Jika tanggal terbit tidak diisi, akan diisi dengan tanggal penggajian secara otomatis</small>");

          $('.isi-modal-release-bupot').attr("hidden", false);
          $('.info-modal-release-bupot').attr("hidden", true);
          $('#button_release_bupot').attr("hidden", false);
        } else {
          html_text = res['pesan'];
          $('.info-modal-release-bupot').html(html_text);
          $('.isi-modal-release-bupot').attr("hidden", true);
          $('.info-modal-release-bupot').attr("hidden", false);
          $('#button_release_bupot').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-release-bupot').html(html_text); //coba pake iframe
        $('.isi-modal-release-bupot').attr("hidden", true);
        $('.info-modal-release-bupot').attr("hidden", false);
        $('#button_release_bupot').attr("hidden", true);
      }
    });
  }

  //action button release BUPOT
  function button_release_bupot() {
    //-------ambil isi variabel-------
    var id_batch = $("#id_batch_bupot").val();
    var release_by_id = '<?php echo $session['employee_id']; ?>';

    //-------testing-------
    // alert(tanggal_terbit);
    // alert(id_saltab);

    // AJAX untuk save data employee
    $.ajax({
      url: '<?= base_url() ?>admin/Importexcel/release_batch_bupot/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_batch: id_batch,
        release_by_id: release_by_id,
      },
      beforeSend: function() {
        $('.info-modal-release-bupot').attr("hidden", false);
        $('.isi-modal-release-bupot').attr("hidden", true);
        $('.info-modal-release-bupot').html(loading_html_text);
        $('#button_release_bupot').attr("hidden", true);
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        //tampilkan pesan sukses
        $('.info-modal-release-bupot').attr("hidden", false);
        $('.isi-modal-release-bupot').attr("hidden", true);
        $('.info-modal-release-bupot').html(success_html_text);
        $('#button_release_bupot').attr("hidden", true);
        bupot_table.ajax.reload(null, false);
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-release-bupot').html(html_text); //coba pake iframe
        $('.isi-modal-release-bupot').attr("hidden", true);
        $('.info-modal-release-bupot').attr("hidden", false);
        $('#button_release_bupot').attr("hidden", true);
      }
    });

  };

  //----- show modal Release BUPOT -----
  function detailReleaseBupot(id_batch) {
    // AJAX untuk ambil data detail eslip
    $.ajax({
      url: '<?= base_url() ?>admin/Importexcel/get_data_batch_bupot/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_batch: id_batch,
      },
      beforeSend: function() {
        $('.info-modal-detail-release-bupot').attr("hidden", false);
        $('.isi-modal-detail-release-bupot').attr("hidden", true);
        $('.info-modal-detail-release-bupot').html(loading_html_text);
        $('#detailReleaseBupotModal').modal('show');
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          $("#periode_bupot_modal_detail").html(res['data']['periode_bupot']);
          $('#project_modal_detail').html(res['data']['project_name']);
          $('#sub_project_modal_detail').html(res['data']['sub_project_name']);
          $("#jumlah_data_modal_detail").html(res['data']['jumlah_data']);
          $('#created_by_modal_detail').html(res['data']['created_by']);
          $('#created_on_modal_detail').html(res['data']['created_on']);
          $('#release_on_modal_detail').html(res['data']['release_on']);
          $('#release_by_modal_detail').html(res['data']['release_by']);

          $('.isi-modal-detail-release-bupot').attr("hidden", false);
          $('.info-modal-detail-release-bupot').attr("hidden", true);
        } else {
          html_text = res['pesan'];
          $('.info-modal-detail-release-bupot').html(html_text);
          $('.isi-modal-detail-release-bupot').attr("hidden", true);
          $('.info-modal-detail-release-bupot').attr("hidden", false);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-detail-release-bupot').html(html_text); //coba pake iframe
        $('.isi-modal-detail-release-bupot').attr("hidden", true);
        $('.info-modal-detail-release-bupot').attr("hidden", false);
      }
    });
  }
</script>