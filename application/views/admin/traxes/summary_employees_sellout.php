<?php
/* Employee Import view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<!-- MODAL DETAIL RELEASE ESLIP -->
<div class="modal fade" id="detailReleaseEslipModal" tabindex="-1" role="dialog" aria-labelledby="detailReleaseEslipModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailReleaseEslipModalLabel">Detail Release e-Slip</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-detail-release-eslip">
          <div class="container" id="container_modal_detail_release_eslip">
            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <td style='width:25%'><strong>Tanggal Penggajian</strong></td>
                    <td style='width:75%'>
                      <span id="tanggal_penggajian_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Periode Cutoff</strong></td>
                    <td>
                      <span id="periode_cutoff_modal_detail"></span>
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
                    <td><strong>Total MPP</strong></td>
                    <td>
                      <span id="total_mpp_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Finalize By</strong></td>
                    <td>
                      <span id="finalize_by_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Tanggal Terbit e-Slip</strong></td>
                    <td>
                      <span id="tanggal_terbit_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Release e-Slip By</strong></td>
                    <td>
                      <span id="release_eslip_by_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Release e-Slip On</strong></td>
                    <td>
                      <span id="release_eslip_on_modal_detail"></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="info-modal-detail-release-eslip"></div>

      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <!-- <button id='button_release_eslip' name='button_release_eslip' type='button' class='btn btn-primary'>Release e-Slip</button> -->
      </div>
    </div>
  </div>
</div>

<?php
if (in_array('514', $role_resources_ids)) {
?>


  <div class="card border-blue">
    <div class="card-header with-elements">
      <div class="col-md-6">
        <span class="card-header-title mr-2"><strong>SUMMARY SELLOUT | </strong>FILTER TABLE</span>
      </div>

      <div class="col-md-6">
        <div class="pull-right">
          <!-- <div class="card-header with-elements"> -->
          <span class="card-header-title mr-2">
            <button id="button_clear_search" class="btn btn-success" data-style="expand-right">Clear Filter</button>
          </span>
        </div>
      </div>
    </div>

    <div class="card-body border-bottom-blue ">

      <?php echo form_open_multipart('/admin/importexcel/import_saltab2/'); ?>

      <input type="hidden" id="nik" name="nik" value=<?php echo $session['employee_id']; ?>>



      <div class="form-row">
        <div class="col-md mb-12">

          <div class="form-row">

      <div class="col-md-3">
        <div class="form-group option-filter">
          <label class="form-label">Periode</label>
          <select class="form-control select_hrm" data-live-search="true" name="aj_periode" id="aj_periode" data-placeholder="Periode Transaksi" required>
            <option value="0">-Pilih Periode-</option>
            <?php $now = new DateTime('now');
                for ($i = 0; $i < 3; $i++) {
                $date = $now->sub(new DateInterval('P' . $i . 'M'));
            ?>
            
              <option value="<?php echo $date->format('Y-m'); ?>"> <?php echo $date->format('F Y'); ?></option>
            
            <?php
              }
            ?>

          </select>
        </div>
      </div>


      <div class="col-md-3">
        <div class="form-group option-filter">
          <label class="form-label">Sub-Project</label>
          <select class="form-control select_hrm" data-live-search="true" name="aj_subperiode" id="aj_subperiode" data-placeholder="Sub Project Transaksi" required>
            <option value="0">-Pilih Periode-</option>

              <option value="PC MT"> PC MT</option>
              <option value="PC TT"> PC TT</option>
              <option value="PC MOBILE"> PC MOBILE</option>

          </select>
        </div>
      </div>


          </div>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md mb-12">
          <div class="form-group">
            <!-- button submit -->
            <button name="search_batch" id="search_batch" class="btn btn-primary btn-block"><i class="fa fa-search"></i> TAMPILKAN</button>
          </div>
        </div>
      </div>

      <?php echo form_close(); ?>

    </div>
  </div>


<?php
}
?>

<div class="card <?php echo $get_animate; ?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>TABEL SUMMARY | </strong>LIST EMPLOYEES</div>
  <div class="card-body">
    <div class="box-datatable table-responsive" id="btn-place">
      <table class="display dataTable table table-striped table-bordered" id="tabel_summary_sellout" style="width:100%">
        <thead>
          <tr>
            <th>Aksi</th>
            <th>NIP</th>
            <th>Nama Lengkap</th>
            <th>Project</th>
            <th>Sub Project</th>
            <th>Jabatan</th>
            <th>Penempatan</th>
            <th>Total Qty</th>
            <th>Total Penjualan</th>
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
  var saltab_table;
  var session_id = '<?php echo $session['employee_id']; ?>';
  
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

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

  $(document).ready(function() {

    // baseURL variable
    // var baseURL = "<?php echo base_url(); ?>";
    // var periode = document.getElementById("aj_periode").value;
    // var sub_project = document.getElementById("aj_subperiode").value;

    $('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
    $('[data-plugin="xin_select"]').select2({
      width: '100%'
    });


  });

</script>

<!-- Tombol Search Batch Saltab -->
<script type="text/javascript">
  document.getElementById("search_batch").onclick = function(e) {
    tabel_summary_sellout.destroy();

    e.preventDefault();

    var periode = document.getElementById("aj_periode").value;
    var sub_project = document.getElementById("aj_subperiode").value;

    // alert(project);
    // alert(periode_salary);
    // alert(cutoff_from);
    // alert(cutoff_to);

    tabel_summary_sellout = $('#tabel_summary_sellout').DataTable({
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
        [7, 'desc']
      ],
      'ajax': {
        'url': '<?= base_url() ?>admin/importexcel/list_batch_saltab_release_download',
        data: {
          [csrfName]: csrfHash,
          session_id: session_id,
          periode: periode,
          sub_project: sub_project,
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
          // "orderable": false,
          //searchable: true
        },
        {
          data: 'employee_name',
          "orderable": false,
          //searchable: true
        },
        {
          data: 'project_name',
          //"orderable": false
        },
        {
          data: 'jabatan',
          //"orderable": false,
        },
        {
          data: 'penempatan',
          // "orderable": false,
        },
        {
          data: 'total_qty',
          //"orderable": false,
        },
        {
          data: 'total_value',
          //"orderable": false,
        },
      ]
    });

  };
</script>
