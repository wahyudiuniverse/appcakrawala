<?php
/* Departments view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>


<hr class="border-light m-0 mb-3">
<div class="row m-b-1 <?php echo $get_animate;?>">
  <?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
  <?php if(in_array('64',$role_resources_ids)) {?>
  <div class="col-md-3">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_user_mobile');?></span>
    </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_usermobile', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/usermobile/add_usermobile', $attributes, $hidden);?>


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
          <label for="first_name"><?php echo $this->lang->line('xin_user_mobile_type');?></label>
          <select class=" form-control" name="usertype" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_user_mobile_type');?>">
            <option value=""></option>
            <?php foreach($all_usermobile_type as $emp) {?>
            <option value="<?php echo $emp->secid?>"><?php echo $emp->user_type_name?></option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group">
          <label for="first_name"><?php echo $this->lang->line('xin_project');?></label>
          <select class=" form-control" name="project" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_project');?>">
            <option value=""></option>
            <?php foreach($all_project as $emp) {?>
            <option value="<?php echo $emp->project_id?>"><?php echo $emp->title?></option>
            <?php } ?>
          </select>
        </div>


        <div class="form-group">
          <label for="first_name"><?php echo $this->lang->line('xin_user_area');?></label>
          <select class=" form-control" name="area" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_user_area');?>">
            <option value=""></option>
            <?php foreach($all_area as $emp) {?>
            <option value="<?php echo $emp->id?>"><?php echo ucwords(strtolower($emp->name))?></option>
            <?php } ?>
          </select>
        </div>


        <div class="form-group">
          <label for="first_name"><?php echo $this->lang->line('xin_user_area_extra1');?></label>
          <select class=" form-control" name="area2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_user_area_extra1');?>">
            <option value=""></option>
            <?php foreach($all_area as $emp) {?>
            <option value="<?php echo $emp->id?>"><?php echo ucwords(strtolower($emp->name))?></option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group">
          <label for="first_name"><?php echo $this->lang->line('xin_user_area_extra2');?></label>
          <select class=" form-control" name="area3" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_user_area_extra2');?>">
            <option value=""></option>
            <?php foreach($all_area as $emp) {?>
            <option value="<?php echo $emp->id?>"><?php echo ucwords(strtolower($emp->name))?></option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group">
          <label for="first_name"><?php echo $this->lang->line('xin_deviceid');?></label>
          <input type="text" class="form-control" placeholder="Device ID" name="device_id"/>
        </div>


        <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>



  <?php $colmdval = 'col-md-9';?>
  <?php } else {?>
  <?php $colmdval = 'col-md-9';?>
  <?php } ?>
  <div class="<?php echo $colmdval;?>">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_user_mobile');?></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th width="10px"><?php echo $this->lang->line('xin_action');?></th>
                <th><?php echo $this->lang->line('xin_nik');?></th>
                <th><?php echo $this->lang->line('dashboard_fullname');?></th>
                <th><?php echo $this->lang->line('xin_posisi');?></th>
                <th><?php echo $this->lang->line('xin_project');?></th>
                <th><?php echo $this->lang->line('xin_user_area');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
