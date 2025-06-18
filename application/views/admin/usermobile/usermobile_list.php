<?php
/* Departments view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>


<hr class="border-light m-0 mb-3">
<div class="row m-b-1 <?php echo $get_animate;?>">
  <?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
  <?php if(in_array('59',$role_resources_ids)) {?>
  <div class="col-md-3">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_user_mobile');?></span>
    </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_usermobile', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/usermobile/add_usermobile', $attributes, $hidden);?>


        <div class="form-group">
          <label for="first_name">NIP / Nama Lengkap</label>
          <select class=" form-control" name="employees" id="aj_emp" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_single_employee');?>">
            <option value=""></option>
            <?php foreach($all_employees as $emp) { ?>
            <option value="<?php echo $emp->employee_id?>"><?php echo '('.$emp->employee_id.') '. $emp->first_name;?></option>
            <?php } ?>
          </select>
        </div>
 

        <div id="info_emp_ajax">

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

<div class="row">
    <div class="col-md-12 <?php echo $get_animate;?>">
        <div class="ui-bordered px-4 pt-4 mb-4">
        <input type="hidden" id="user_id" value="0" />
        <?php $attributes = array('name' => 'employee_mobile', 'id' => 'employee_mobile', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
    <?php $hidden = array('euser_id' => $session['user_id']);?>
        <?php echo form_open('admin/customerservices/', $attributes, $hidden);?>
      <?php
        $data = array(
          'name'  => 'user_id',
          'id'    => 'user_id',
          'type'  => 'hidden',
          'value' => $session['user_id'],
          'class' => 'form-control');
            echo form_input($data);
      ?> 
      
      <div class="form-row">


        <div class="col-md mb-3">
          <label class="form-label">Cari NIP</label>

          <input class="form-control" type="number" name="aj_company" id="aj_company" data-placeholder="<?php echo $this->lang->line('dashboard_single_employee');?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
 
        </div>

    
        <div class="col-md mb-3" id="project_ajax">
          <label class="form-label">Project</label>
          <select class="form-control" name="project_id" id="aj_project" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_projects');?>">
            <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
            <?php 
              foreach ($all_projects as $projects) {
            ?>
                <option value="<?php echo $projects->project_id?>"><?php echo $projects->title?></option>
            <?php 
              } 
            ?>
          </select>
        </div>


        <div class="col-md mb-3">
          <div class="form-group" id="subproject_ajax">
            <label class="form-label"><?php echo $this->lang->line('left_sub_projects');?></label>
            <select disabled="disabled" class="form-control" name="subproject_id" id="aj_subproject" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_sub_projects');?>">
              <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
            </select>
          </div>   
        </div>

        <div class="col-md col-xl-2 mb-4">
          <label class="form-label d-none d-md-block">&nbsp;</label>
            <button type="submit" class="btn btn-secondary btn-block">SHOW</button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

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
