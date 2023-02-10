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
  <?php if(in_array('130',$role_resources_ids)) {?>
  <div class="col-md-4">
    

<div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_sub_project_add');?></strong>  </span>
    </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_subproject', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/project/add_subproject', $attributes, $hidden);?>


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
          <label for="subproject"><?php echo $this->lang->line('xin_sub_project_name');?></label>
          <input type="text" class="form-control" placeholder="Nama Sub Project" name="subproject"/>
        </div>


        <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
        <?php echo form_close(); ?> </div>
    </div>


  </div>



  <?php $colmdval = 'col-md-7';?>
  <?php } else { ?>
  <?php $colmdval = 'col-md-7';?>
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
                <th><?php echo $this->lang->line('xin_sub_project_id');?></th>
                <th><?php echo $this->lang->line('xin_sub_project_name');?></th>
                <th>Nama Project</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
