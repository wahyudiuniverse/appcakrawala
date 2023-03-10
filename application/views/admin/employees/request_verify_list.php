<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $count_emp_request = $this->Xin_model->count_emp_request();?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('327',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_request/');?>" data-link-data="<?php echo site_url('admin/employee_request/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon fa fa-database"></span> Monitoring Request
      </a> </li>
    <?php } ?>  
    <?php if(in_array('374',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/employee_request_verify/');?>" data-link-data="<?php echo site_url('admin/employee_request_verify/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> Request <?php echo '('.$count_emp_request.')';?>
      </a> </li>
    <?php } ?>
    <?php if(in_array('375',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_request_approve/');?>" data-link-data="<?php echo site_url('admin/employee_request_approve/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> History Approval
      </a> </li>
    <?php } ?>
  </ul>
</div>

<hr class="border-light m-0 mb-3">
<?php $employee_id = $this->Xin_model->generate_random_employeeid();?>
<?php $employee_pincode = $this->Xin_model->generate_random_pincode();?>

<div class="card">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>List Request Employees</strong></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_request_employee_status');?></th>
            <th>NIK-KTP</th>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_employees_full_name');?></th>
            <th><?php echo $this->lang->line('left_projects');?></th>
            <th><?php echo $this->lang->line('left_sub_projects');?></th>
            <th><?php echo $this->lang->line('left_department');?></th>
            <th><?php echo $this->lang->line('left_designation');?></th>
            <th><?php echo $this->lang->line('xin_placement');?></th>
            <th><?php echo $this->lang->line('xin_employee_doj');?></th>
            <th><?php echo $this->lang->line('xin_e_details_contact');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
