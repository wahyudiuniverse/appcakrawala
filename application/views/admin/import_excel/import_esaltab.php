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
    <!-- <div class="card-header with-elements">
      <span class="card-header-title mr-2">
        <strong>E-SALTAB | </strong>IMPORT FILE
      </span>
    </div> -->

    <div class="card-header with-elements">
      <div class="col-md-6">
        <span class="card-header-title mr-2">
          <strong>E-SALTAB | </strong>IMPORT FILE
        </span>
      </div>

      <div class="col-md-6">
        <div class="pull-right">
          <!-- <div class="card-header with-elements"> -->
          <span class="card-header-title mr-2">
            <a href="<?php echo base_url(); ?>admin/importexcel/downloadTemplateSaltab" class="btn btn-primary">
              <i class="fa fa-download"></i>
              Download template saltab
            </a>
          </span>
          <!-- </div> -->
        </div>
      </div>
    </div>

    <?php echo form_open_multipart('/admin/importexcel/import_saltab2/');
    ?>

    <div class="card-body border-bottom-blue ">

      <input type="hidden" id="nik" name="nik" value=<?php echo $session['employee_id']; ?>>

      <div class="form-row">
        <div class="col-md-8">
          <div class="form-group">
            <fieldset class="form-group">
              <label for="file_excel">Upload File<font color="#FF0000">*</font></label>
              <input class="form-control" type="file" id="file_excel" name="file_excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
              <small>Please select .xlsx file (allowed file size max 5MB)</small>
            </fieldset>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <!-- input periode -->
            <label class="form-label">Tanggal Penggajian<font color="#FF0000">*</font></label>
            <input type="text" class="form-control date" readonly name="periode_salary" id="periode_salary" placeholder="Tanggal Penggajian" required>
          </div>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-4">
          <div class="form-group">
            <label class="form-label">Project<font color="#FF0000">*</font></label>
            <select class="form-control" data-live-search="true" name="project" id="project" data-plugin="xin_select" data-placeholder="Project" required>
              <option value="0">Pilih Project</option>
              <?php foreach ($all_projects as $proj) { ?>
                <option value="<?php echo $proj->project_id; ?>"> <?php echo $proj->title; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label class="form-label">Sub Project<font color="#FF0000">*</font></label>
            <select class="form-control" data-live-search="true" name="sub_project" id="sub_project" data-plugin="xin_select" data-placeholder="Sub-Project" required>
              <option value="0">--ALL--</option>
            </select>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-group">
                <!-- input periode -->
                <label class="form-label">Periode Cutoff from<font color="#FF0000">*</font></label>
                <input type="text" class="form-control date" readonly name="saltab_from" id="saltab_from" placeholder="Periode Saltab From" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <!-- input periode -->
                <label class="form-label">Periode Cutoff to<font color="#FF0000">*</font></label>
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
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-upload"></i> IMPORT</button>
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
<div class="card <?php echo $get_animate; ?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>LIST BATCH |</strong> History E-SALTAB (Belum Release)</span> </div>
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
          data: 'tanggal_penggajian',
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

  });

  //-----delete batch saltab-----
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

  //-----lihat batch saltab-----
  function lihatBatchSaltab(id) {
    //alert("masuk fungsi lihat. id: " + id);
    window.open('<?= base_url() ?>admin/Importexcel/view_batch_saltab_temporary/' + id, "_self");
  }

  //-----edit batch saltab-----
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