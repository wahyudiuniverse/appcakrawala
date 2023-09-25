<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>

<?php $count_cancel = $this->Xin_model->count_resign_cancel();?>
<?php $count_appnae = $this->Xin_model->count_approve_nae();?>
<?php $count_appnom = $this->Xin_model->count_approve_nom();?>
<?php $count_apphrd = $this->Xin_model->count_approve_hrd();?>
<?php $count_emp_request = $this->Xin_model->count_emp_resign();?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('491',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_resign/');?>" data-link-data="<?php echo site_url('admin/employee_resign/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon fa fa-database"></span> Ajukan Paklaring
      </a> </li>
    <?php } ?> 

    <?php if(in_array('506',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/Employee_resign_cancelled/');?>" data-link-data="<?php echo site_url('admin/Employee_resign_apnae/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> Paklaring Ditolak <?php echo '('.$count_cancel.')';?>
      </a> </li>
    <?php } ?>
    
    <?php if(in_array('492',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_resign_apnae/');?>" data-link-data="<?php echo site_url('admin/Employee_resign_apnae/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> Approve NAE <?php echo '('.$count_appnae.')';?>
      </a> </li>
    <?php } ?>

    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_resign_apnom/');?>" data-link-data="<?php echo site_url('admin/Employee_resign_apnom/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> Approve NOM/SM <?php echo '('.$count_appnom.')';?>
      </a> </li>
 

    <?php if(in_array('494',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_resign_aphrd/');?>" data-link-data="<?php echo site_url('admin/Employee_resign_aphrd/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> Approve HRD
      <?php echo '('.$count_apphrd.')';?></a> </li>
    <?php } ?>
    
    <?php if(in_array('491',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_resign_history/');?>" data-link-data="<?php echo site_url('admin/Employee_resign_history/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> History Resign
      </a> </li>
    <?php } ?>

  </ul>
</div>

<hr class="border-light m-0 mb-3">
<?php $employee_id = $this->Xin_model->generate_random_employeeid();?>
<?php $employee_pincode = $this->Xin_model->generate_random_pincode();?>

<div class="card">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>DAFTAR </strong>PAKLARING DITOLAK</span> </div>
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
            <th>Tanggal Resign</th>
            <th><?php echo $this->lang->line('xin_placement');?></th>
            <th>No KTP</th>
            <th>Status Revisi</th>
            <th>Dokumen</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
