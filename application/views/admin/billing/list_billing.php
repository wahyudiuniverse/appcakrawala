<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>


<!-- MODAL EDIT REKENING BANK -->
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
            <?php $attributes = array('name' => 'rekening_form', 'id' => 'rekening_form', 'autocomplete' => 'off', 'class' => 'm-b-1'); ?>
            <?php echo form_open_multipart('admin/profile/uploadaddendum/', $attributes); ?>
            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <td style='width:25%'><strong>Tanggal Bergabung / Date of Join <span class="icon-verify-bank"></span></strong></td>
                    <td style='width:75%'>
                      
                      <input class="form-control date" readonly placeholder="Tanggal Resign" name="date_of_leave" type="text" value="">

                      <span id='pesan_nama_bank'></span>
                      <input hidden name="nama_bank" id="nama_bank" placeholder="Nomor Rekening Bank" type="text" value="">
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Tanggal Berakhir / Date of Leave <span class="icon-verify-norek"></span></strong></td>
                    <td>
                      
                      <input class="form-control date" readonly placeholder="Tanggal Resign" name="date_of_leave" type="text" value="">
                      <span id='pesan_nomor_rekening'></span>
                    </td>
                  </tr>

                  <tr>
                    <td><strong>Upload Exitclearance</strong></td>
                    <td>
                      <div id="file_buku_tabungan_kosong" class="mb-2">BELUM ADA DATA. SILAHKAN UPLOAD DOKUMEN EXITCLEARANCE</div>
                      
                      <div id="form_upload_buku_tabungan" class="form-group">
                        <fieldset class="form-group">
                          <input type="file" class="form-control-file" id="buku_rekening" name="buku_rekening" accept="application/pdf, image/png, image/jpg, image/jpeg">
                          <small>Jenis File: JPG, JPEG, PNG, PDF | Size MAX 5 MB</small>
                        </fieldset>
                      </div>
                      <!-- <input class="form-control" type="file" id="buku_rekening" name="buku_rekening" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"> -->
                      <span id='pesan_buku_rekening'></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="info-modal-edit-rekening"></div>

      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <button id='button_save_rekening' name='button_save_rekening' type='submit' class='btn btn-primary'>Save Rekening</button>
      </div>

      <?php echo form_close(); ?>
    </div>
  </div>
</div>



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
          <button name="filter_employee" id="filter_employee" class="btn btn-primary btn-block"><i class="fa fa-search"></i> FILTER</button>
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

    employee_table = $('#tabel_employees').DataTable().on('search.dt', () => eventFired('Search'));

  });
</script>


<!-- Tombol Filter -->
<script type="text/javascript">
  document.getElementById("filter_employee").onclick = function(e) {
    employee_table.destroy();

    e.preventDefault();

    var periode     = document.getElementById("aj_periode").value;
    var am          = document.getElementById("aj_am").value;
    var region      = document.getElementById("aj_region").value;


    var searchVal = $('#tabel_employees_filter').find('input').val();

    // alert(project);
    // alert(sub_project);
    // alert(sdate);
    // alert(edate);
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


<!-- <script type="text/javascript">
  document.getElementById("button_download_data").onclick = function(e) {
    var project = document.getElementById("aj_project").value;
    var sub_project = document.getElementById("aj_sub_project").value;
    // var sub_project = sub_project.replace(" ","");
    
    var sdate       =  $('#aj_sdate').val();
    var edate       = $('#aj_edate').val();

    // ambil input search dari datatable
    var filter = $('.dataTables_filter input').val(); //cara 1
    var searchVal = $('#tabel_employees_filter').find('input').val(); //cara 2

    if (searchVal == "") {
      searchVal = "-no_input-";
    }

    var text_pesan = "Project: " + project;
    text_pesan = text_pesan + "\nSub Project: " + sub_project;
    text_pesan = text_pesan + "\nSdate: " + sdate;
    text_pesan = text_pesan + "\nEdate: " + edate;
    text_pesan = text_pesan + "\nSearch: " + searchVal;
    // alert(sub_project);

    window.open('<?php echo base_url(); ?>admin/Employee_history_join/printExcel/' + project + '/' + sub_project + '/' + sdate + '/' + edate + '/' + searchVal + '/' + session_id + '/', '_self');

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
    var sdate       = $("#aj_sdate").val();
    var edate       = $("#aj_edate").val();
    // alert(searchVal.length);

    if ((searchVal.length <= 2)) {
      $('#button_download_data').attr("hidden", false);
    } else {

      $('#button_download_data').attr("hidden", false);
    }
    // let n = document.querySelector('#demo_info');
    // n.innerHTML +=
    //   '<div>' + type + ' event - ' + new Date().getTime() + '</div>';
    // n.scrollTop = n.scrollHeight;

  }
</script> -->

<!-- <script>
  // Project Vacant Change - Jabatan vacant
    $('#aj_project').change(function() {
        var project = $(this).val();

        // alert("Project: " + project);

        // AJAX request Jabatan
        $.ajax({
            url: '<?= base_url() ?>admin/Traxes_report_cio/get_subprojects2/',
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
                    $('#aj_sub_project').append('<option value="' + data['sub_project_name'] + '" style="text-wrap: wrap;">' + data['sub_project_name'] + '</option>');
                });

                // alert("Company name: " + res["company"]["company_name"]);
            }
        });
    });

</script> -->

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
