<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php $count_emp_request_cancel = $this->Xin_model->count_emp_request_cancel($session['employee_id']); ?>
<?php $count_emp_request_nae = $this->Xin_model->count_emp_request_nae($session['employee_id']); ?>
<?php $count_emp_request_nom = $this->Xin_model->count_emp_request_nom($session['employee_id']); ?>
<?php $count_emp_request_hrd = $this->Xin_model->count_emp_request_hrd($session['employee_id']); ?>
<?php $count_emp_request_tkhl = $this->Xin_model->count_emp_request_tkhl($session['employee_id']); ?>
<?php //$list_bank = $this->Xin_model->get_bank_code();
?>
<!-- $data['list_bank'] = $this->Xin_model->get_bank_code(); -->

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">

    <?php if (in_array('378', $role_resources_ids)) { ?>
      <li class="nav-item active"> <a href="<?php echo site_url('admin/employee_request_hrd/'); ?>" data-link-data="<?php echo site_url('admin/employee_request_hrd/'); ?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span>KARYAWAN BARU <?php echo '(' . $count_emp_request_hrd . ')'; ?>
        </a> </li>
    <?php } ?>

    <!-- <?php if (in_array('312', $role_resources_ids)) { ?>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_request_tkhl/'); ?>" data-link-data="<?php echo site_url('admin/employee_request_tkhl/'); ?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span>KARYAWAN TKHL <?php echo '(' . $count_emp_request_tkhl . ')'; ?>
        </a> </li>
    <?php } ?> -->

    <?php if (in_array('338', $role_resources_ids)) { ?>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/Employee_request_cancelled/'); ?>" data-link-data="<?php echo site_url('admin/Employee_request_cancelled/'); ?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span>DITOLAK <?php echo '(' . $count_emp_request_cancel . ')'; ?>
        </a> </li>
    <?php } ?>


  </ul>
</div>

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

        <div class="col-md mb-3">
          <label class="form-label">Golongan</label>
          <select class="form-control" name="golongan" id="golongan" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_projects'); ?>">
            <option value="0">--ALL--</option>
            <option value="1">PKWT</option>
            <option value="2">TKHL</option>
          </select>
        </div>

        <div class="col-md mb-3">
          <label class="form-label">Kategori</label>
          <select class="form-control" name="kategori" id="kategori" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_projects'); ?>">
            <option value="0">--ALL--</option>
            <option value="1">In House</option>
            <option value="2">Area</option>
            <option value="3">Ratecard</option>
            <option value="4">Project</option>
          </select>
        </div>

        <div class="col-md mb-3">
          <label class="form-label">Projects</label>
          <select class="form-control" name="project_id" id="aj_project" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_projects'); ?>">
            <option value="0">--ALL--</option>
            <?php foreach ($all_projects as $proj) { ?>
              <option value="<?php echo $proj->project_id; ?>" <?php if ($project_karyawan == $proj->project_id) {
                                                                  echo " selected";
                                                                } ?>> <?php echo $proj->title; ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="col-md mb-3" id="subproject_ajax" hidden>
          <label class="form-label">Sub Projects</label>
          <select class="form-control" name="sub_project_id" id="aj_subproject" data-plugin="xin_select" data-placeholder="Sub Project">
            <option value="0">--</option>
          </select>
        </div>

        <div class="col-md mb-3" id="areaemp_ajax" hidden>
          <label class="form-label">Area/Penempatan</label>
          <select class="form-control" name="area_emp" id="aj_area_emp" data-plugin="xin_select" data-placeholder="Area/Penempatan">
            <option value="0">--</option>
          </select>
        </div>

        <div class="col-md mb-3" hidden>
          <label class="form-label"><?php echo $this->lang->line('xin_select_date'); ?></label>
          <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date'); ?>" readonly id="start_date" name="start_date" id="aj_sdate" type="text" value="<?php echo date('Y-m-d'); ?>">
        </div>

        <div class="col-md mb-3" hidden>
          <label class="form-label"><?php echo $this->lang->line('xin_select_date'); ?></label>
          <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date'); ?>" readonly id="end_date" name="end_date" id="aj_edate" type="text" value="<?php echo date('Y-m-d'); ?>">
        </div>

        <div class="col-md mb-3" hidden>
          <label class="form-label">NIP/FULLNAME/KTP</label>
          <input class="form-control" placeholder="Cari: Nama Lengkap/NIP/KTP" name="searchkey" id="aj_searchkey" type="text" value="0">
        </div>

        <div class="col-md col-xl-2 mb-4">
          <label class="form-label d-none d-md-block">&nbsp;</label>
          <button type="submit" class="btn btn-secondary btn-block">FILTER</button>
        </div>


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
      <!-- <?php echo print_r($this->db->last_query()); ?> -->

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


<!-- <?php echo print_r($this->db->last_query()); ?> -->
<!-- <i class='ion ion-checkmark-circle-outline'></i> -->
<!-- <span class="ion-md-speedometer"></span> -->
<!-- <span class="icon-[ion--checkmark-circle-outline]"></span> -->
<!-- <span class="ion--checkmark-circle-outline"></span> -->

<div class="row m-b-1 <?php echo $get_animate; ?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all'); ?></strong> Request Karyawan Baru</span> </div>
      <div class="card-body">
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
      var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
        csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
      var project_id = document.getElementById("aj_project").value;
      var kategori = document.getElementById("kategori").value;
      var golongan = document.getElementById("golongan").value;
      var approve = document.getElementById("approve").value;
      var idsession = "<?php print($session['employee_id']); ?>";
      //alert(approve);
      $(document).ready(function() {
        //$.fn.dataTable.moment('YYYY-MM-DD HH:mm:ss');
        var table = $('#xin_table2').DataTable({
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

        // //search pkwt atau tkhl
        // $('#golongan').on('change', function() {
        //   var golongan_select = document.getElementById("golongan").value;
        //   var search_golongan = "@golo-" + golongan_select;
        //   alert(search_golongan);
        //   table.search(search_golongan).draw();
        // });
        // //search kategori
        // $('#kategori').on('change', function() {
        //   var kategori_select = document.getElementById("kategori").value;
        //   var search_kategori = "@kateg-" + kategori_select;
        //   alert(search_kategori);
        //   table.search(search_kategori).draw();
        // });
        // //serarch by project filter
        // $('#aj_project').on('change', function() {
        //   var project_id = document.getElementById("aj_project").value;
        //   var search_project = "@proj-" + project_id;
        //   alert(search_project);
        //   //table.search(this.value).draw();
        //   table.search(search_project).draw();
        //   //table.draw();
        // });

      });
    </script>

    <!-- <div class="card">
>>>>>>> 2d4f66631bc9c9b90ebea3165a7c99143d8f0ac9
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all'); ?></strong> <?php echo $this->lang->line('xin_companies'); ?></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th>No.</th>
                <th><?php echo $this->lang->line('xin_request_employee_status'); ?></th>
                <th>NIK-KTP</th>
                <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_employees_full_name'); ?></th>
                <th><?php echo $this->lang->line('left_projects'); ?></th>
                <th><?php echo $this->lang->line('left_sub_projects'); ?></th>
                <th><?php echo $this->lang->line('left_department'); ?></th>
                <th><?php echo $this->lang->line('left_designation'); ?></th>
                <th>Nomor HP</th>
                <th><?php echo $this->lang->line('xin_placement'); ?></th>
                <th><?php echo $this->lang->line('xin_employee_doj'); ?></th>
                <th> Tanggal Register</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>