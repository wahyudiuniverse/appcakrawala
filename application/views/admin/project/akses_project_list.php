<?php
/*
* Designation View
*/
$session = $this->session->userdata('username');
?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>


<hr class="border-light m-0 mb-3">
<?php if(in_array('243',$role_resources_ids)) {?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_akses_project');?></span>
      
    </div>
      <div class="card-body">
      <?php $attributes = array('name' => 'add_designation', 'id' => 'xin-form', 'autocomplete' => 'off');?>
      <?php $hidden = array('user_id' => $session['user_id']);?>
      <?php echo form_open('admin/akses_project/add_akses_project', $attributes, $hidden);?>

        <div class="form-group">
          <label for="first_name"><?php echo $this->lang->line('dashboard_single_employee');?></label>
          <select class=" form-control" name="employees" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_single_employee');?>">
            <option value=""></option>
            <?php foreach($all_employees as $emp) {?>
            <option value="<?php echo $emp->employee_id?>"><?php echo '('.$emp->employee_id.') '. $emp->first_name.' '.$emp->last_name?></option>
            <?php } ?>
          </select>
        </div>



        <div class="form-group">
          <label for="first_name"><?php echo $this->lang->line('xin_project');?></label>
          <select class=" form-control" name="project" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_project');?>">
            <option value=""></option>
            <?php foreach($all_projects as $pro) {?>
            <option value="<?php echo $pro->project_id?>"><?php echo $pro->title ?></option>
            <?php } ?>
          </select>
        </div>

      
      <div class="form-actions box-footer">
        <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
      </div>
      <?php echo form_close(); ?> </div></div>
  </div>
  <?php $colmdval = 'col-md-8';?>
  <?php } else {?>
  <?php $colmdval = 'col-md-12';?>
  <?php } ?>
  <div class="<?php echo $colmdval;?>">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_akses_project');?></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th style="width:65px;"><?php echo $this->lang->line('xin_action');?></th>
                <th><?php echo $this->lang->line('dashboard_empid');?></th>
                <th><?php echo $this->lang->line('xin_employees_full_name');?></th>
                <th><?php echo $this->lang->line('left_designation');?></th>
                <th><?php echo $this->lang->line('left_projects');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
