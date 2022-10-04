<?php
/* Employees view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php


// PKWT START

$pkwtinfo = $this->Pkwt_model->get_single_pkwt_by_userid($user_info[0]->employee_id);

if(!is_null($pkwtinfo)){
  $pkwtid = $pkwtinfo[0]->contract_id;
  $nomorsurat = $pkwtinfo[0]->no_surat;
  $approve_pkwt = $pkwtinfo[0]->status_approve;

  $pkwt_file = $this->Pkwt_model->get_pkwt_file($pkwtinfo[0]->contract_id);
  if(!is_null($pkwt_file)){
    $file_name = $pkwt_file[0]->document_file;
    $uploaded = 1;
  } else {
    $file_name = '';
    $uploaded = 0;
  }

} else {
  $pkwtid = '0';
}

// PKWT END

// reports to 
$reports_to = get_reports_team_data($session['user_id']); ?>


<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('422',$role_resources_ids) && $user_info[0]->user_role_id==1) {?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employees/staff_dashboard/');?>" data-link-data="<?php echo site_url('admin/employees/staff_dashboard/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-done-icon ion ion-md-speedometer"></span> <span class="sw-icon ion ion-md-speedometer"></span> <?php echo $this->lang->line('hr_staff_dashboard_title');?>
      <div class="text-muted small"><?php echo $this->lang->line('hr_staff_dashboard_title');?></div>
      </a> </li>
      <?php } ?>
    <?php if(in_array('13',$role_resources_ids) || $reports_to>0) {?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/employees/');?>" data-link-data="<?php echo site_url('admin/employees/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-done-icon fas fa-user-friends"></span> <span class="sw-icon fas fa-user-friends"></span> <?php echo $this->lang->line('dashboard_employees');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> <?php echo $this->lang->line('dashboard_employees');?></div>
      </a> </li>
    <?php } ?>
    <?php if($user_info[0]->user_role_id==1) {?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/roles/');?>" class="mb-3 nav-link hrpremium-link" data-link-data="<?php echo site_url('admin/roles/');?>"> <span class="sw-icon ion ion-md-unlock"></span> <?php echo $this->lang->line('xin_role_urole');?>
      <div class="text-muted small"><?php echo $this->lang->line('left_set_roles');?></div>
      </a> </li>
     <?php } ?>
    <?php if(in_array('7',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/timesheet/office_shift/');?>" data-link-data="<?php echo site_url('admin/timesheet/office_shift/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-md-clock"></span> <?php echo $this->lang->line('left_office_shifts');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_create');?> <?php echo $this->lang->line('left_office_shifts');?></div>
      </a> </li>
    <?php } ?>
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php $employee_id = $this->Xin_model->generate_random_employeeid();?>
<?php $employee_pincode = $this->Xin_model->generate_random_pincode();?>

<?php 
if($user_info[0]->user_role_id==1 || 
  $user_info[0]->user_role_id==2 || 
  $user_info[0]->user_role_id==3){ ?>
    
<div id="filter_hrpremium" class="collapse add-formd <?php echo $get_animate;?>" data-parent="#accordion" style="">
  <div class="ui-bordered px-4 pt-4 mb-4 mt-3">
    <?php $attributes = array('name' => 'ihr_report', 'id' => 'ihr_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
    <?php $hidden = array('user_id' => $session['user_id']);?>
    <?php echo form_open('admin/employees/employees_list', $attributes, $hidden);?>
    <?php
            $data = array(
              'type'        => 'hidden',
              'name'        => 'date_format',
              'id'          => 'date_format',
              'value'       => $this->Xin_model->set_date_format(date('Y-m-d')),
              'class'       => 'form-control',
            );
            echo form_input($data);
            ?>
    <div class="form-row">
      <div class="col-md mb-3">
        <label class="form-label"><?php echo $this->lang->line('left_company');?></label>
        <select class="form-control" name="company_id" id="filter_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
          <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
          <?php foreach($get_all_companies as $company) {?>
          <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md mb-3" id="location_ajaxflt">
        <label class="form-label"><?php echo $this->lang->line('left_location');?></label>
        <select name="location_id" id="filter_location" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
          <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
        </select>
      </div>
      <div class="col-md mb-3" id="department_ajaxflt">
        <label class="form-label"><?php echo $this->lang->line('left_department');?></label>
        <select class="form-control" id="filter_department" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_department');?>" >
          <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
        </select>
      </div>
      <div class="col-md mb-3" id="designation_ajaxflt">
        <label class="form-label"><?php echo $this->lang->line('xin_designation');?></label>
        <select class="form-control" name="designation_id" data-plugin="select_hrm"  id="filter_designation" data-placeholder="<?php echo $this->lang->line('xin_designation');?>">
          <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
        </select>
      </div>
      <div class="col-md col-xl-2 mb-4">
        <label class="form-label d-none d-md-block">&nbsp;</label>
        <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => 'btn btn-secondary btn-block', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_get'))); ?> </div>
    </div>
    <?php echo form_close(); ?> </div>
</div>
<?php } ?>
<div class="row mt-3">

<!-- PKWT STATUS -->

  <?php 
  if($pkwtid=='0'){
  ?>


  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_pkwt');?></div>
            <div class="text-large">Tidak Ditemukan..!</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
  } else {
  ?>


  <div class="col-sm-6 col-xl-3">
  <a href="<?php echo site_url('admin/pkwt/view/'.$pkwtid.'/'.$user_info[0]->employee_id);?>" target="_blank">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_pkwt');?></div>
            <div class="text-large"><?php echo $this->lang->line('xin_download');?>
          <i class="fa fa-check-circle" aria-hidden="true" style="color:#03b403"></i></div>
          
            <div class="text-muted small"><?php echo $nomorsurat;?></div>
          </div>

        </div>

      </div>
    </div>
    </a>
  </div>


  <div class="col-sm-6 col-xl-3">
  <a href="<?php echo site_url('admin/mypkwt/uploadpkwt/'.$pkwtid.'/'.$user_info[0]->employee_id);?>">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_pkwt');?></div>
            <div class="text-large"><?php echo $this->lang->line('xin_upload');?>
            <?php if($uploaded == 1){
            ?>

            <i class="fa fa-check-circle" aria-hidden="true" style="color:#03b403"></i>
            <?php
            } else {
            ?>

            <?php
            }
            ?>
            </div>
            <div class="text-muted small"><?php echo $nomorsurat;?></div>
          </div>

        </div>

      </div>
    </div>
    </a>
  </div>


  <div class="col-sm-6 col-xl-3">
  <a href="<?php echo site_url('#');?>" target="_blank">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_pkwt');?></div>
            <div class="text-large"><?php echo $this->lang->line('xin_pkwt_terima');?>


            <?php if($approve_pkwt == 1){
            ?>

            <i class="fa fa-check-circle" aria-hidden="true" style="color:#03b403"></i>
            <?php
            } else {
            ?>

            <?php
            }
            ?>


            </div>
          
            <div class="text-muted small"><?php echo $nomorsurat;?></div>
          </div>

        </div>

      </div>
    </div>
    </a>
  </div>

  
  <?php
  }
  ?>
</div>


