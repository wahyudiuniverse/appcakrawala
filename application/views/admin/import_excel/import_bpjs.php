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
        <button id='button_release_bupot' name='button_release_bupot' type='button' class='btn btn-primary'>Release BUPOT</button>
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
if (in_array('1401', $role_resources_ids)) {
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
          <strong>IMPORT BPJS</strong>
        </span>
      </div>

      <div class="col-md-6">
        <div class="pull-right">
          <!-- <div class="card-header with-elements"> -->
          <span class="card-header-title mr-2">
            <a href="<?php echo base_url(); ?>admin/importexcel/downloadTemplateBPJS" class="btn btn-primary">
              <i class="fa fa-download"></i>
              Download template bpjs
            </a>
          </span>
          <!-- </div> -->
        </div>
      </div>
    </div>

    <?php
    $attributes = array('class' => 'myform', 'id' => 'myform');
    echo form_open_multipart('/admin/importexcel/import_excel_bpjs/', $attributes);
    ?>

    <div class="card-body border-bottom-blue ">

      <input type="hidden" id="upload_by" name="upload_by" value=<?php echo $session['employee_id']; ?>>

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

        <div class="col-md mb-3">
          <div class="form-group">
            <label for="button_submit">&nbsp;</label>
            <!-- button submit -->
            <button type="submit" id="button_submit" name="button_submit" class="btn btn-success btn-block"><i class="fa fa-upload"></i> IMPORT</button>
          </div>
        </div>
      </div>

    </div>
  </div>
  <?php echo form_close(); ?>

<?php
}
?>

<div class="card <?php echo $get_animate; ?> mt-2">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>BPJS |</strong> LIST BPJS KARYAWAN</span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive" id="btn-place">
      <table class="display dataTable table table-striped table-bordered" id="bpjs_table" style="width:100%">
        <thead>
          <tr>
            <th>Aksi</th>
            <th>NIP</th>
            <th>NIK KTP</th>
            <th>Nama</th>
            <th>Project</th>
            <th>Entitas (Sub Project)</th>
            <th>Nomor BPJS Kesehatan</th>
            <th>Nomor BPJS Ketenagakerjaan</th>
            <th>Created By</th>
            <th>Created On (Y-M-D)</th>
            <th>Modify By</th>
            <th>Modify On (Y-M-D)</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<script>
  //global variable
  var bpjs_table;

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
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';


  $(document).ready(function() {
    // baseURL variable
    var baseURL = "<?php echo base_url(); ?>";

    $('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
    $('[data-plugin="xin_select"]').select2({
      width: '100%'
    });

    bpjs_table = $('#bpjs_table').DataTable({
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
        [3, 'asc']
      ],
      'ajax': {
        'url': '<?= base_url() ?>admin/importexcel/list_bpjs',
        data: {
          [csrfName]: csrfHash,
          session_id: session_id,
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
          data: 'nip',
          // "orderable": false,
          //searchable: true
        },
        {
          data: 'nik',
          // "orderable": false,
          //searchable: true
        },
        {
          data: 'nama_lengkap',
          //"orderable": false
        },
        {
          data: 'project',
          //"orderable": false,
        },
        {
          data: 'sub_project',
          // "orderable": false,
        },
        {
          data: 'bpjs_kesehatan',
          //"orderable": false,
        },
        {
          data: 'bpjs_ketenagakerjaan',
          //"orderable": false,
        },
        {
          data: 'upload_by',
          //"orderable": false,
        },
        {
          data: 'upload_on',
          //"orderable": false,
        },
        {
          data: 'modify_by',
          //"orderable": false,
        },
        {
          data: 'modify_on',
          //"orderable": false,
        },
      ]
    });



  });

  //-----delete batch saltab-----
  function deleteBPJS(id) {
    // alert("masuk fungsi delete bpjs. id: " + id);
    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Importexcel/delete_bpjs/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id: id
      },
      success: function(response) {
        alert("Berhasil Delete Data BPJS");
        bpjs_table.ajax.reload(null, false);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert("Gagal Delete Data BPJS. Status : " + xhr.status);
        alert("responseText :" + xhr.responseText);
      },
    });
    // alert("Beres Ajax. id: " + id);
  }

  //-----edit data bpjs-----
  function editBPJS(id) {
    alert("masuk fungsi edit. id: " + id);
    // window.open('<?= base_url() ?>admin/Importexcel/view_batch_bupot/' + id, "_blank");
  }
</script>