<?php
/* Date Wise Attendance Report > EMployees view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $system = $this->Xin_model->read_setting_info(1);?>


<?php $count_appnae = $this->Xin_model->count_approve_nae_pkwt($session['employee_id']);?>
<?php $count_appnom = $this->Xin_model->count_approve_nom_pkwt($session['employee_id']);?>
<?php $count_apphrd = $this->Xin_model->count_approve_hrd_pkwt($session['employee_id']);?>
<?php $count_pkwtcancel = $this->Xin_model->count_approve_pkwt_cancel($session['employee_id']);?>
<?php $count_emp_request = $this->Xin_model->count_emp_request($session['employee_id']);?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('377',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/reports/pkwt_expired/');?>" data-link-data="<?php echo site_url('admin/reports/pkwt_expired/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon fa fa-database"></span>PKWT EXPIRED
      </a> </li>
    <?php } ?>

    <?php if(in_array('505',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_pkwt_aphrd');?>" data-link-data="<?php echo site_url('admin/Employee_pkwt_aphrd/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> HRD CHECKER
      <?php echo '('.$count_apphrd.')';?></a> </li>
    <?php } ?>
    
    <?php if(in_array('379',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_pkwt_cancel');?>" data-link-data="<?php echo site_url('admin/Employee_pkwt_cancel/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span>DITOLAK <?php echo '('.$count_pkwtcancel.')';?>
      </a> </li>
    <?php } ?>

    <?php if(in_array('377',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/reports/pkwt_history');?>" data-link-data="<?php echo site_url('admin/reports/pkwt_history');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span>PKWT REPORT
      </a> </li>
    <?php } ?>
  </ul>
</div>

<div class="row">
    <div class="col-md-12 <?php echo $get_animate;?>">
        <div class="ui-bordered px-4 pt-4 mb-4">
        <input type="hidden" id="user_id" value="0" />
        <?php $attributes = array('name' => 'attendance_datewise_report', 'id' => 'attendance_datewise_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
		<?php $hidden = array('euser_id' => $session['user_id']);?>
        <?php echo form_open('admin/reports/pkwt_expired_list', $attributes, $hidden);?>
        <?php
            $data = array(
              'name'        => 'user_id',
              'id'          => 'user_id',
              'value'       => $session['user_id'],
              'type'   		  => 'hidden',
              'class'       => 'form-control',
            );
            
            echo form_input($data);
            ?>
          <div class="form-row">


            <div class="col-md mb-3">

            <label class="form-label">Projects <?php echo $session['employee_id'];?></label>
              <select class="form-control" name="project_id" id="aj_project" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_projects');?>">
                  <option value="0">--ALL--</option>
                <?php foreach($all_projects as $proj) {?>
                  <option value="<?php echo $proj->project_id;?>"> <?php echo $proj->title;?></option>
                <?php } ?>
              </select>
            </div>


          <div class="col-md mb-3" id="subproject_ajax" hidden>
            <label class="form-label">Sub Projects</label>
            <select class="form-control" name="sub_project_id" id="aj_subproject"  data-plugin="select_hrm" data-placeholder="Sub Project">
              <option value="0">--</option>
            </select>
          </div>

          <div class="col-md mb-3" id="areaemp_ajax" hidden>
            <label class="form-label">Area/Penempatan</label>
            <select class="form-control" name="area_emp" id="aj_area_emp"  data-plugin="select_hrm" data-placeholder="Area/Penempatan">
              <option value="0">--</option>
            </select>
          </div>

          <div class="col-md mb-3" hidden>
              <label class="form-label"><?php echo $this->lang->line('xin_select_date');?></label>
              <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="start_date" name="start_date" id="aj_sdate" type="text" value="<?php echo date('Y-m-d');?>">
          </div>
            
            <div class="col-md mb-3" hidden>
              <label class="form-label"><?php echo $this->lang->line('xin_select_date');?></label>
              <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="end_date" name="end_date" id="aj_edate" type="text" value="<?php echo date('Y-m-d');?>">
            </div>

          <div class="col-md mb-3">
              <label class="form-label">NIP/FULLNAME/KTP</label>
              <input class="form-control" placeholder="Cari: Nama Lengkap/NIP/KTP" name="searchkey" id="aj_searchkey" type="text" value="0">
          </div>


            <div class="col-md col-xl-2 mb-4">
              <label class="form-label d-none d-md-block">&nbsp;</label>
              <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('xin_get');?></button>
            </div>


          </div>
          <?php echo form_close(); ?>
        </div>
    </div>
</div>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_hr_reports_attendance_employee');?></strong></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th colspan="7"><?php echo $this->lang->line('xin_hr_info');?></th>
              </tr>
              <tr>
                <th>STATUS PKWT.</th>
                <th>NIP</th>
                <th>Nama Lengkap</th>
                <th>Project</th>
                <th>Posisi/Jabatan</th>
                <th>Area/Penempatan</th>
                <th>Kontrak Terakhir</th>

              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
