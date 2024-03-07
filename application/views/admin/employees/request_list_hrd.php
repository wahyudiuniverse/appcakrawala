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

    <?php if (in_array('312', $role_resources_ids)) { ?>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_request_tkhl/'); ?>" data-link-data="<?php echo site_url('admin/employee_request_tkhl/'); ?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span>KARYAWAN TKHL <?php echo '(' . $count_emp_request_tkhl . ')'; ?>
        </a> </li>
    <?php } ?>

    <?php if (in_array('338', $role_resources_ids)) { ?>
      <li class="nav-item clickable"> <a href="<?php echo site_url('admin/Employee_request_cancelled/'); ?>" data-link-data="<?php echo site_url('admin/Employee_request_cancelled/'); ?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span>DITOLAK <?php echo '(' . $count_emp_request_cancel . ')'; ?>
        </a> </li>
    <?php } ?>


  </ul>
</div>

<hr class="border-light m-0 mb-3">
<?php $employee_id = $this->Xin_model->generate_random_employeeid(); ?>
<?php $employee_pincode = $this->Xin_model->generate_random_pincode(); ?>



<div class="row">
  <div class="col-md-12 <?php echo $get_animate; ?>">
    <div class="ui-bordered px-4 pt-4 mb-4">
      <input type="hidden" id="user_id" value="0" />
      <?php $attributes = array('name' => 'emp_pkwt_request', 'id' => 'emp_pkwt_request', 'autocomplete' => 'off', 'class' => 'add form-hrm'); ?>
      <?php $hidden = array('euser_id' => $session['user_id']); ?>
      <?php echo form_open('admin/employee_request_hrd/request_list_hrd', $attributes, $hidden); ?>
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

          <label class="form-label">Projects</label>
          <select class="form-control" name="project_id" id="aj_project" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_projects'); ?>">
            <option value="0">--ALL--</option>
            <?php foreach ($all_projects as $proj) { ?>
              <option value="<?php echo $proj->project_id; ?>"> <?php echo $proj->title; ?></option>
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

        <div class="col-md mb-3">
          <label class="form-label">NIP/FULLNAME/KTP</label>
          <input class="form-control" placeholder="Cari: Nama Lengkap/NIP/KTP" name="searchkey" id="aj_searchkey" type="text" value="0">
        </div>

        <div class="col-md col-xl-2 mb-4">
          <label class="form-label d-none d-md-block">&nbsp;</label>
          <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('xin_get'); ?></button>
        </div>


      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<div class="row m-b-1 <?php echo $get_animate; ?>">
  <div class="col-md-12">


    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all'); ?></strong> <?php echo $this->lang->line('xin_companies'); ?></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="display dataTable table table-striped table-bordered" id="xin_table2">
            <thead>
              <tr>
                <th>Gol. Karyawan</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Project</th>
                <th>Sub Project</th>
                <th>Jabatan</th>
                <th>Penempatan</th>
                <th>Gaji Pokok</th>
                <th>Periode</th>
                <th>Tanggal Register</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>

    <!-- Script xin_table2 -->
    <script type="text/javascript">
      var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
        csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
      $(document).ready(function() {
        $('#xin_table2').DataTable({
          'processing': true,
          'serverSide': true,
          'serverMethod': 'post',
          'ajax': {
            'url': '<?= base_url() ?>admin/employee_request_hrd/request_list_hrd2',
            data: {
              [csrfName]: csrfHash
            },
          },
          'columns': [{
              data: 'nik_ktp'
            },
            {
              data: 'golongan_karyawan'
            },
            {
              data: 'fullname'
            },
            {
              data: 'project'
            },
            {
              data: 'sub_project'
            },
            {
              data: 'jabatan'
            },
            {
              data: 'penempatan'
            },
            {
              data: 'gaji_pokok'
            },
            {
              data: 'periode'
            },
            {
              data: 'tanggal_register'
            },
          ]
        });
      });
    </script>


    <div class="card">


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