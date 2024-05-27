<?php
/* Employee Import view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php
if (in_array('469', $role_resources_ids)) {
?>


  <div class="card border-blue">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>E-SALTAB | </strong>Search FILE</div>
    <div class="card-body border-bottom-blue ">

      <?php echo form_open_multipart('/admin/importexcel/import_saltab2/'); ?>

      <input type="hidden" id="nik" name="nik" value=<?php echo $session['employee_id']; ?>>

      <div class="form-row">
        <div class="col-md-8">
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

        <div class="col-md-4">
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-group">
                <!-- input periode -->
                <label class="form-label">Periode Saltab from<font color="#FF0000">*</font></label>
                <input type="text" class="form-control date" readonly name="saltab_from" id="saltab_from" placeholder="Periode Saltab From" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <!-- input periode -->
                <label class="form-label">Periode Saltab to<font color="#FF0000">*</font></label>
                <input type="text" class="form-control date" readonly name="saltab_to" id="saltab_to" placeholder="Periode Saltab To" required>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md mb-12">
          <div class="form-group">
            <!-- button submit -->
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> SEARCH</button>
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
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>E-SALTAB | </strong>Download FILE</div>
  <div class="card-body">
    <div class="box-datatable table-responsive" id="btn-place">
      <table class="display dataTable table table-striped table-bordered" id="saltab_table2" style="width:100%">
        <thead>
          <tr>
            <th>Aksi</th>
            <th>Periode Saltab</th>
            <th>Project</th>
            <th>Sub Project</th>
            <th>Total MPP</th>
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
  var saltab_table;
  //var myData = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Philadelphia', 'Phoenix', 'San Antonio', 'San Diego', 'Dallas', 'San Jose', 'Jacksonville', "Algiers", "Annaba", "Azazga", "Batna City", "Blida", "Bordj", "Bordj Bou Arreridj", "Bougara", "Cheraga", "Chlef", "Constantine", "Djelfa", "Draria", "El Tarf", "Hussein Dey", "Illizi", "Jijel", "Kouba", "Laghouat", "Oran", "Ouargla", "Oued Smar", "Relizane", "Rouiba", "Saida", "Souk Ahras", "Tamanghasset", "Tiaret", "Tissemsilt", "Tizi", "Tizi Ouzou", "Tlemcen"];
  var myData = JSON.parse('<?php echo json_encode($tabel_saltab); ?>');
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
        [6, 'desc']
      ],
      'ajax': {
        'url': '<?= base_url() ?>admin/importexcel/list_batch_saltab',
        data: {
          [csrfName]: csrfHash,
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
  function deleteBatchSaltab(id) {
    // alert("masuk fungsi delete saltab. id: " + id);
    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Importexcel/delete_batch_saltab/',
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
  function lihatBatchSaltab(id) {
    //alert("masuk fungsi lihat. id: " + id);
    window.open('<?= base_url() ?>admin/Importexcel/view_batch_saltab_temporary/' + id, "_self");
  }

  //-----edit addendum-----
  function downloadBatchSaltab(id) {
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