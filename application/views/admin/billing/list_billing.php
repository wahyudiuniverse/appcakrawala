<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>



<hr class="border-light m-0 mb-3">

<!-- SECTION FILTER -->
<div class="card border-blue">
  <div class="card-header with-elements">
    <div class="col-md-6">
      <span class="card-header-title mr-2"><strong>MANAGE REPORT | </strong>FILTER</span>
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

    <input type="hidden" id="nik" name="nik" value=<?php echo $session['employee_id']; ?>>



    <div class="form-row">
      <div class="col-md-3">
        <div class="form-group project-option">
          <label class="form-label">PERIODE</label>
          <select class="form-control select_hrm" data-live-search="true" name="periode_bill" id="aj_periode" data-plugin="select_hrm" data-placeholder="Periode" required>
            <option value="0">-ALL-</option>
            <?php foreach ($periode_billing as $bill) { ?>
              <option value="<?php echo $bill->periode; ?>"> <?php echo $bill->periode; ?></option>

            <?php } ?>

          </select>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group project-option">
          <label class="form-label">AREA MANAGER</label>
          <select class="form-control select_hrm" data-live-search="true" name="am_bill" id="aj_am" data-plugin="select_hrm" data-placeholder="Area Manager" required>
            <option value="0">-ALL-</option>
            <?php foreach ($am_billing as $bill) { ?>
              <option value="<?php echo $bill->nama_am; ?>"> <?php echo $bill->nama_am; ?></option>

            <?php } ?>

          </select>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group project-option">
          <label class="form-label">REGION/AREA</label>
          <select class="form-control select_hrm" data-live-search="true" name="region_bill" id="aj_region" data-plugin="select_hrm" data-placeholder="Region" required>
            <option value="0">-ALL-</option>
            <?php foreach ($region_billing as $bill) { ?>
              <option value="<?php echo $bill->billing_area; ?>"> <?php echo $bill->billing_area; ?></option>

            <?php } ?>

          </select>
        </div>
      </div>


      <div class="col-md-3">
        <div class="form-group">
          <!-- button submit -->
          <label class="form-label">&nbsp;</label>
          <button type="button" name="filter_employee" id="filter_employee" class="btn btn-primary btn-block"><i class="fa fa-search"></i> FILTER</button>
        </div>
      </div>


      <div class="col-md-3">
        <div class="form-check-inline" id="button_download_data">
          <input class="form-check-input align-middle" type="checkbox" role="switch" id="opsi_download_image">
          <label class="form-check-label" for="opsi_download_image">GROUP BY PROJECT</label>
        </div>

      </div>
    </div>


  </div>
</div>

<!-- SECTION DATA TABLES -->
<div class="row m-b-1 <?php echo $get_animate; ?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements">
        <div class="col-md-6">
          <span class="card-header-title mr-2"><strong>TABEL SUMMARY BILLING</strong></span>
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
                <th>Periode</th>
                <th>NIP</th>
                <th>Area Manager</th>
                <th>Billing Area</th>
                <th>Project ID</th>
                <th>Project Name</th>
                <th>Total MPP</th>
                <th>Total Billing</th>
                <th>Fee (%)</th>
                <th>Fee (Rp.)</th>
                <th>Total</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>



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


    // $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    // $('[data-plugin="select_hrm"]').select2({
    //   width: '100%'
    // });


    var periode = "";
    var am = "";
    var region = "";
    // var edate = "";

    employee_table = $('#tabel_employees').DataTable();

  });
</script>


<!-- Tombol Filter -->
<script type="text/javascript">
  document.getElementById("filter_employee").onclick = function(e) {
    employee_table.destroy();

    // e.preventDefault();

    var periode = document.getElementById("aj_periode").value;
    var am = document.getElementById("aj_am").value;
    var region = document.getElementById("aj_region").value;
    // var searchVal = $('#tabel_employees_filter').find('input').val();
    var searchVal = "";


    alert(periode);
    alert(am);
    alert(region);
    alert(searchVal);
    // alert(searchVal);

    if ((searchVal == "")) {
      $('#button_download_data').attr("hidden", false);

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
          'url': '<?= base_url() ?>admin/Billing/list_billing',
          data: {
            [csrfName]: csrfHash,
            session_id: session_id,
            periode: periode,
            am: am,
            region: region,
            //base_url_catat: base_url_catat
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert("Status :" + xhr.status);
            alert("responseText :" + xhr.responseText);
          },
        },
        'columns': [{
            data: 'periode',
            "orderable": false
          },
          {
            data: 'nip_am',
            "orderable": false,
          },
          {
            data: 'nama_am',
            "orderable": false,
          },
          {
            data: 'billing_area',
            "orderable": false
          },
          {
            data: 'project_id',
            "orderable": false,
          },
          {
            data: 'project_name',
            "orderable": false,
          },
          {
            data: 'total_mpp',
            "orderable": false,
          },
          {
            data: 'total_billing',
            "orderable": false,
          },
          {
            data: 'fee_percen',
            "orderable": false,
          },
          {
            data: 'fee_value',
            "orderable": false,
          },
          {
            data: 'total',
            "orderable": false,
          },
        ],
      });

      $('#tombol_filter').attr("disabled", false);
      $('#tombol_filter').removeAttr("data-loading");
    }

    // alert(project);
    // alert(sub_project);
    // alert(status);
  };
</script>


<script type="text/javascript">
  // document.getElementById("button_download_data").onclick = function(e) {
  //   var project = document.getElementById("aj_project").value;
  //   var sub_project = document.getElementById("aj_sub_project").value;
  //   // var sub_project = sub_project.replace(" ","");

  //   var sdate       =  $('#aj_sdate').val();
  //   var edate       = $('#aj_edate').val();

  //   // ambil input search dari datatable
  //   var filter = $('.dataTables_filter input').val(); //cara 1
  //   var searchVal = $('#tabel_employees_filter').find('input').val(); //cara 2

  //   if (searchVal == "") {
  //     searchVal = "-no_input-";
  //   }

  //   var text_pesan = "Project: " + project;
  //   text_pesan = text_pesan + "\nSub Project: " + sub_project;
  //   text_pesan = text_pesan + "\nSdate: " + sdate;
  //   text_pesan = text_pesan + "\nEdate: " + edate;
  //   text_pesan = text_pesan + "\nSearch: " + searchVal;
  //   // alert(sub_project);

  //   window.open('<?php echo base_url(); ?>admin/Employee_history_join/printExcel/' + project + '/' + sub_project + '/' + sdate + '/' + edate + '/' + searchVal + '/' + session_id + '/', '_self');

  // };

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