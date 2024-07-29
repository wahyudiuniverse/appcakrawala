<?php
/* Employee Import view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php
if (in_array('514', $role_resources_ids)) {
?>


  <div class="card border-blue">
    <div class="card-header with-elements">
      <div class="col-md-6">
        <span class="card-header-title mr-2"><strong>E-SALTAB | </strong>FILTER FILE</span>
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
        <div class="col-md-6">
          <div class="form-group project-option">
            <label class="form-label">Project</label>
            <select class="form-control" data-live-search="true" name="project" id="project" data-plugin="xin_select" data-placeholder="Project" required>
              <option value="0">-ALL-</option>
              <?php foreach ($all_projects as $proj) { ?>
                <option value="<?php echo $proj->project_id; ?>"> <?php echo $proj->title; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-group periode-from">
                <!-- input periode -->
                <label class="form-label">Search Tanggal Penggajian from</label>
                <input type="text" class="form-control date" readonly name="search_periode_from" id="search_periode_from" placeholder="Periode From" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group periode-to">
                <!-- input periode -->
                <label class="form-label">Search Tanggal Penggajian to</label>
                <input type="text" class="form-control date" readonly name="search_periode_to" id="search_periode_to" placeholder="Periode To" required>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md mb-12">
          <div class="form-group">
            <!-- button submit -->
            <button name="search_batch" id="search_batch" class="btn btn-primary btn-block"><i class="fa fa-search"></i> SEARCH</button>
          </div>
        </div>
      </div>

      <?php echo form_close(); ?>

    </div>
  </div>


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
<div class="card <?php echo $get_animate; ?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>E-SALTAB | </strong>DATA LIST BATCH</div>
  <div class="card-body">
    <div class="box-datatable table-responsive" id="btn-place">
      <table class="display dataTable table table-striped table-bordered" id="saltab_table2" style="width:100%">
        <thead>
          <tr>
            <th>Aksi</th>
            <th>Tanggal Penggajian</th>
            <th>Periode Cutoff</th>
            <th>Project</th>
            <th>Sub Project</th>
            <th>Total MPP</th>
            <th>Finalize by</th>
            <th>Finalize on</th>
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
  // var kolom_saltab = JSON.parse('<?php //echo json_encode($tabel_saltab); ?>');
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';


  $(document).ready(function() {

    // var idsession = "<?php print($session['employee_id']); ?>";

    // baseURL variable
    var baseURL = "<?php echo base_url(); ?>";

    var project = document.getElementById("project").value;
    var search_periode_from = document.getElementById("search_periode_from").value;
    var search_periode_to = document.getElementById("search_periode_to").value;

    $('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
    $('[data-plugin="xin_select"]').select2({
      width: '100%'
    });

    saltab_table = $('#saltab_table2').DataTable({
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
          project: project,
          search_periode_from: search_periode_from,
          search_periode_to: search_periode_to,
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
          data: 'periode_salary',
          // "orderable": false,
          //searchable: true
        },
        {
          data: 'periode',
          "orderable": false,
          //searchable: true
        },
        {
          data: 'project_name',
          //"orderable": false
        },
        {
          data: 'sub_project_name',
          //"orderable": false,
        },
        {
          data: 'total_mpp',
          "orderable": false,
        },
        {
          data: 'upload_by',
          //"orderable": false,
        },
        {
          data: 'upload_on',
          //"orderable": false,
        },
      ]
    });

  });

  //-----delete addendum-----
  function deleteBatchSaltabRelease(id) {
    // alert("masuk fungsi delete saltab. id: " + id);
    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Importexcel/delete_batch_saltab_release/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id: id
      },
      success: function(response) {
        alert("Berhasil Delete Batch Saltab");
        saltab_table.ajax.reload(null, false);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert("Gagal Delete Batch Saltab. Status : " + xhr.status);
        alert("responseText :" + xhr.responseText);
      },
    });
    // alert("Beres Ajax. id: " + id);
  }

  //-----lihat addendum-----
  function lihatBatchSaltabRelease(id) {
    //alert("masuk fungsi lihat. id: " + id);
    window.open('<?= base_url() ?>admin/Importexcel/view_batch_saltab_release_download/' + id, "_self");
  }

  //-----download raw data saltab-----
  function downloadBatchSaltabRelease(id) {
    //alert("masuk fungsi download. id: " + id);downloadDetailSaltab
    // window.open('<?= base_url() ?>admin/addendum/edit/' + id, "_blank");
    window.open('<?= base_url() ?>admin/Importexcel/downloadDetailSaltabRelease/' + id, "_self");
  }

  //-----download salab BPJS-----
  function downloadBatchSaltabReleaseBPJS(id) {
    //alert("masuk fungsi download. id: " + id);downloadDetailSaltab
    // window.open('<?= base_url() ?>admin/addendum/edit/' + id, "_blank");
    window.open('<?= base_url() ?>admin/Importexcel/downloadDetailSaltabReleaseBPJS/' + id, "_self");
  }

  //-----download salab BPJS-----
  function downloadBatchSaltabReleasePayroll(id) {
    //alert("masuk fungsi download. id: " + id);downloadDetailSaltab
    // window.open('<?= base_url() ?>admin/addendum/edit/' + id, "_blank");
    window.open('<?= base_url() ?>admin/Importexcel/downloadDetailSaltabReleasePayroll/' + id, "_self");
  }

  // function cek_isi() {
  //   var isi = langopt.getValue();
  //   //alert("tes");
  //   alert("Isi pilihan: " + isi);
  // }
</script>

<!-- Tombol Search Batch Saltab -->
<script type="text/javascript">
  document.getElementById("search_batch").onclick = function(e) {
    saltab_table.destroy();
    // $('#saltab_table2').empty();

    e.preventDefault();

    // $('.icon-spinner3').hide();
    // $('.save').prop('disabled', false);
    // Ladda.stopAll();

    var project = document.getElementById("project").value;
    var search_periode_from = document.getElementById("search_periode_from").value;
    var search_periode_to = document.getElementById("search_periode_to").value;

    // alert(project);
    // alert(periode_salary);
    // alert(cutoff_from);
    // alert(cutoff_to);

    saltab_table = $('#saltab_table2').DataTable({
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
          project: project,
          search_periode_from: search_periode_from,
          search_periode_to: search_periode_to,
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
          data: 'periode_salary',
          "orderable": false,
          //searchable: true
        },
        {
          data: 'periode',
          "orderable": false,
          //searchable: true
        },
        {
          data: 'project_name',
          //"orderable": false
        },
        {
          data: 'sub_project_name',
          //"orderable": false,
        },
        {
          data: 'total_mpp',
          "orderable": false,
        },
        {
          data: 'upload_by',
          //"orderable": false,
        },
        {
          data: 'upload_on',
          //"orderable": false,
        },
      ]
    });

  };
</script>

<!-- Tombol Clear Filter Batch Saltab -->
<script type="text/javascript">
  document.getElementById("button_clear_search").onclick = function(e) {
    saltab_table.destroy();

    e.preventDefault();

    //reset parameter filter
    document.getElementById("search_periode_from").value = "";
    document.getElementById("search_periode_to").value = "";
    $("div.project-option select").val("0").change();

    var project = document.getElementById("project").value;
    var search_periode_from = document.getElementById("search_periode_from").value;
    var search_periode_to = document.getElementById("search_periode_to").value;

    // alert(project);
    // alert(periode_salary);
    // alert(cutoff_from);
    // alert(cutoff_to);

    saltab_table = $('#saltab_table2').DataTable({
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
          project: project,
          search_periode_from: search_periode_from,
          search_periode_to: search_periode_to,
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
          data: 'periode_salary',
          "orderable": false,
          //searchable: true
        },
        {
          data: 'periode',
          "orderable": false,
          //searchable: true
        },
        {
          data: 'project_name',
          //"orderable": false
        },
        {
          data: 'sub_project_name',
          //"orderable": false,
        },
        {
          data: 'total_mpp',
          "orderable": false,
        },
        {
          data: 'upload_by',
          //"orderable": false,
        },
        {
          data: 'upload_on',
          //"orderable": false,
        },
      ]
    });

  };
</script>