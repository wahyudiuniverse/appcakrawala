<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php $count_emp_request_cancel = "-"; ?>
<?php $count_emp_request_nae = $this->Xin_model->count_emp_request_nae($session['employee_id']); ?>
<?php $count_emp_request_nom = $this->Xin_model->count_emp_request_nom($session['employee_id']); ?>
<?php $count_emp_request_hrd = $this->Xin_model->count_emp_request_hrd($session['employee_id']); ?>
<?php $count_emp_request_tkhl = $this->Xin_model->count_emp_request_tkhl($session['employee_id']); ?>
<?php //$list_bank = $this->Xin_model->get_bank_code();
?>
<!-- $data['list_bank'] = $this->Xin_model->get_bank_code(); -->

<hr class="border-light m-0 mb-3">
<?php $employee_id = $this->Xin_model->generate_random_employeeid(); ?>
<?php $employee_pincode = $this->Xin_model->generate_random_pincode(); ?>



<!-- <div class="row">
  <div class="col-md-12 <?php echo $get_animate; ?>">
    <div class="ui-bordered px-4 pt-4 mb-4">
      <input type="hidden" id="user_id" value="0" />
      <?php $attributes = array('name' => 'emp_pkwt_request', 'id' => 'emp_pkwt_request', 'autocomplete' => 'off', 'class' => 'add form-hrm'); ?>
      <?php $hidden = array('euser_id' => $session['user_id']); ?>
      <?php echo form_open('admin/employee_request_hrd/', $attributes, $hidden); ?>
      <?php
      $data = array(
        'name'        => 'user_id',
        'id'          => 'user_id',
        'value'       => $session['user_id'],
        'type'        => 'hidden',
        'class'       => 'form-control',
      );

      echo form_input($data);
      ?>
      <div class="form-row">



      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div> -->

<?php echo form_open_multipart('/admin/employee_request_hrd/');
?>
<div class="card border-blue">
  <h5 class="card-header text-black bg-gradient-blue">Filter</h5>
  <div class="card-body border-bottom-blue ">
    <div class="form-row">
      <div class="col-md mb-3">
        <label class="form-label">Kesiapan Data</label>
        <select class="form-control" data-live-search="true" name="approve" id="approve" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_projects'); ?>">
          <option value="0">--ALL--</option>
          <option value="1" <?php if ($approve_karyawan == "1") {
                              echo " selected";
                            } ?>>Siap approve</option>
          <option value="2" <?php if ($approve_karyawan == "2") {
                              echo " selected";
                            } ?>>Belum siap approve</option>
        </select>
      </div>

      <div class="col-md mb-3">
        <label class="form-label">Jenis Dokumen</label>
        <select class="form-control" data-live-search="true" name="golongan" id="golongan" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_projects'); ?>">
          <option value="0">--ALL--</option>
          <option value="1" <?php if ($golongan_karyawan == "1") {
                              echo " selected";
                            } ?>>PKWT</option>
          <option value="2" <?php if ($golongan_karyawan == "2") {
                              echo " selected";
                            } ?>>TKHL</option>
        </select>
      </div>

      <div class="col-md mb-3">
        <label class="form-label">Kategori</label>
        <select class="form-control" data-live-search="true" name="kategori" id="kategori" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_projects'); ?>">
          <option value="0">--ALL--</option>
          <option value="1" <?php if ($kategori_karyawan == "1") {
                              echo " selected";
                            } ?>>In House</option>
          <option value="2" <?php if ($kategori_karyawan == "2") {
                              echo " selected";
                            } ?>>Area</option>
          <option value="3" <?php if ($kategori_karyawan == "3") {
                              echo " selected";
                            } ?>>Ratecard</option>
          <option value="4" <?php if ($kategori_karyawan == "4") {
                              echo " selected";
                            } ?>>Project</option>
        </select>
      </div>
      <!-- <?php //echo print_r($this->db->last_query()); ?> -->

      <div class="col-md mb-3">
        <label class="form-label">Projects</label>
        <select class="form-control" data-live-search="true" name="project_id" id="aj_project" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_projects'); ?>">
          <option value="0">--ALL--</option>
          <?php foreach ($all_projects as $proj) { ?>
            <option value="<?php echo $proj->project_id; ?>" <?php if ($project_karyawan == $proj->project_id) {
                                                                echo " selected";
                                                              } ?>> <?php echo $proj->title; ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="col-md mb-3">
        <!-- button submit -->
        <label class="form-label">&nbsp;</label>
        <button type="submit" class="btn btn-primary  btn-block">FILTER</button>
      </div>

    </div>
  </div>
</div>
<?php echo form_close(); ?>


<!-- <?php //echo print_r($this->db->last_query()); ?> -->

<div class="row m-b-1 <?php echo $get_animate; ?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all'); ?></strong> Request Karyawan Baru</span><button id="button_download" class="btn btn-primary ladda-button" data-style="expand-right">Download Excel</button> </div>
      <div class=" card-body">
        <div class="box-datatable table-responsive" id="btn-place">
          <table class="display dataTable table table-striped table-bordered" id="xin_table2" style="width:100%">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_request_employee_status'); ?></th>
                <th>Jenis Dokumen</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Project</th>
                <th>Sub Project</th>
                <th>Jabatan</th>
                <th>Penempatan</th>
                <th>Gaji Pokok</th>
                <th>Periode</th>
                <th>Kategori Karyawan</th>
                <th>Tanggal Register</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>

    <?php
    //echo $this->db->last_query();
    ?>

    <!-- Script data table xin_table2 -->
    <script type="text/javascript">
      var table;
      $(document).ready(function() {
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
          csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        var project_id = document.getElementById("aj_project").value;
        var kategori = document.getElementById("kategori").value;
        var golongan = document.getElementById("golongan").value;
        var approve = document.getElementById("approve").value;
        var idsession = "<?php print($session['employee_id']); ?>";
        //alert(approve);

        //$.fn.dataTable.moment('YYYY-MM-DD HH:mm:ss');
        table = $('#xin_table2').DataTable({
          'processing': true,
          'serverSide': true,
          'stateSave': true,
          'bFilter': true,
          'serverMethod': 'post',
          'dom': 'pPlBfrtip',
          //'columnDefs': [{
          //  targets: 11,
          //  type: 'date-eu'
          //}],
          'order': [
            [11, 'desc']
          ],
          'ajax': {
            'url': '<?= base_url() ?>admin/employee_request_hrd/request_list_hrd2',
            data: {
              [csrfName]: csrfHash,
              project_id: project_id,
              kategori: kategori,
              golongan: golongan,
              approve: approve,
              idsession: idsession
            },
          },
          'columns': [{
              data: 'aksi',
              "orderable": false
            },
            {
              data: 'golongan_karyawan',
              "orderable": false,
              //searchable: true
            },
            {
              data: 'nik_ktp',
              //"orderable": false
            },
            {
              data: 'fullname',
              //"orderable": false,
            },
            {
              data: 'project',
              //"orderable": false
            },
            {
              data: 'sub_project',
              //"orderable": false,
            },
            {
              data: 'posisi',
              //"orderable": false
            },
            {
              data: 'penempatan',
              //"orderable": false,
            },
            {
              data: 'gaji_pokok',
              //"orderable": false,
            },
            {
              data: 'periode',
              "orderable": false
            },
            {
              data: 'kategori',
              "orderable": false
            },
            {
              data: 'request_empon',
              //type: 'date-eu'
              //"orderable": false
            },
          ]
        });
        //end


      });

      function printExcel() {
        var project_id = document.getElementById("aj_project").value;
        var kategori = document.getElementById("kategori").value;
        var golongan = document.getElementById("golongan").value;
        var approve = document.getElementById("approve").value;
        var idsession = "<?php print($session['employee_id']); ?>";
        var filter = $('.dataTables_filter input').val() //ambil filter search dari datatables

        //alert($('.dataTables_filter input').val());
        if (filter == "") {
          filter = "-no_input-";
        }

        window.open('<?php echo base_url(); ?>admin/employee_request_hrd/printExcel/' + project_id + '/' + kategori + '/' + golongan + '/' + approve + '/' + idsession + '/' + filter + '/', '_blank');
      };

      document.querySelector('#button_download').addEventListener('click', function() {
        printExcel();
      });
    </script>
