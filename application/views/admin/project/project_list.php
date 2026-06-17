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
  <?php if(in_array('44',$role_resources_ids)) {?>
  <div class="col-md-3">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_user_mobile');?></span>
    </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_usermobile', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/project/add_project', $attributes, $hidden);?>


        <div class="form-group">
          <label for="first_name">Nama Project/PT</label>
          <input type="text" class="form-control" placeholder="Nama Lengkap Klien/PT/Project" name="title"/>
        </div>

        <div class="form-group">
          <label for="first_name">Alias Project</label>
          <input type="text" class="form-control" placeholder="Nama Alias" name="alias"/>
        </div>

        <div class="form-group">
          <label for="first_name">Perusahaan/PT</label>
          <select class=" form-control" name="company_id" data-plugin="select_hrm" data-placeholder="--Pilih Perusahaan--">
            <option value=""></option>
            <?php foreach($get_all_companies as $emp) {?>
            <option value="<?php echo $emp->company_id?>"><?php echo $emp->name?></option>
            <?php } ?>
          </select>
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
    
</div>

      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> Projects</span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th width="10px"><?php echo $this->lang->line('xin_action');?></th>
                <th>ID</th>
                <th>Nama Project</th>
                <th>Alias</th>
                <th>Perusahaan/PT</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
