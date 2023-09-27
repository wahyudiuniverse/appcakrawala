<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>

<?php $count_appnae = $this->Xin_model->count_approve_nae_pkwt($session['employee_id']);?>
<?php $count_appnom = $this->Xin_model->count_approve_nom_pkwt($session['employee_id']);?>
<?php $count_apphrd = $this->Xin_model->count_approve_hrd_pkwt($session['employee_id']);?>
<?php $count_pkwtcancel = $this->Xin_model->count_approve_pkwt_cancel($session['employee_id']);?>
<?php $count_emp_request = $this->Xin_model->count_emp_request($session['employee_id']);?>


<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('377',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/reports/pkwt_expired');?>" data-link-data="<?php echo site_url('admin/reports/pkwt_expired/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon fa fa-database"></span>PKWT EXPIRED
      </a> </li>
    <?php } ?>  


    <?php if(in_array('505',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_pkwt_aphrd');?>" data-link-data="<?php echo site_url('admin/Employee_pkwt_aphrd/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span>HRD CHECKER
      <?php echo '('.$count_apphrd.')';?></a> </li>
    <?php } ?>
    
    <?php if(in_array('379',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/employee_pkwt_cancel');?>" data-link-data="<?php echo site_url('admin/Employee_pkwt_cancel/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span>DITOLAK <?php echo '('.$count_pkwtcancel.')';?>
      </a> </li>
    <?php } ?>

    <?php if(in_array('377',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/reports/pkwt_history');?>" data-link-data="<?php echo site_url('admin/reports/pkwt_history/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span>PKWT REPORT
      </a> </li>
    <?php } ?>
  </ul>
</div>

<hr class="border-light m-0 mb-3">
<?php $employee_id = $this->Xin_model->generate_random_employeeid();?>
<?php $employee_pincode = $this->Xin_model->generate_random_pincode();?>

<div class="card">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>REQUEST </strong>EMPLOYEE RESIGN</span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_request_employee_status');?></th>
            <th>NIP</th>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_employees_full_name');?></th>
            <th><?php echo $this->lang->line('left_projects');?></th>
            <th><?php echo $this->lang->line('left_designation');?></th>
            <th>Area/Penempatan</th>
            <th>Waktu Kontrak</th>
            <th>Tanggal Ditolak</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
