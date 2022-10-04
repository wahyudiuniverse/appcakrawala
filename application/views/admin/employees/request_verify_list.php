<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('337',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_request/');?>" data-link-data="<?php echo site_url('admin/employee_request/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon fa fa-database"></span> Request <?php echo '(10)';?>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('374',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/employee_request_verify/');?>" data-link-data="<?php echo site_url('admin/employee_request_verify/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> Verify <?php echo '(8)';?>
      </a> </li>
    <?php } ?>
    <?php if(in_array('375',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_request_approve/');?>" data-link-data="<?php echo site_url('admin/employee_request_approve/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> Approve <?php echo '(3)';?>
      </a> </li>
    <?php } ?>
  </ul>
</div>

<hr class="border-light m-0 mb-3">
<?php $employee_id = $this->Xin_model->generate_random_employeeid();?>
<?php $employee_pincode = $this->Xin_model->generate_random_pincode();?>

<?php if(in_array('337',$role_resources_ids)) {?>

<div class="card mb-4">
  <!-- <div id="accordion"> -->
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_employee');?></span>
      <div class="card-header-elements ml-md-auto"> </div>
    </div>
    <div id="add_form" class="add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_employee', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/employees/request_add_employee', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="row">
                  <input name="employee_id" type="hidden" value="<?php echo $employee_id;?>">
                  <input name="company_id" type="hidden" value="<?php echo $employee_id;?>">

                <!--NAMA LENGKAP-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="fullname"><?php echo $this->lang->line('xin_employees_full_name');?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employees_full_name');?>" name="fullname" type="text" value="">
                  </div>
                </div>

                <!--LOKASI OFFICE-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="office_lokasi"><?php echo $this->lang->line('xin_e_details_office_location');?><i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="office_lokasi" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_e_details_office_location');?>">
                      <option value="1">IN-HOUSE</option>
                      <option value="2">PROJECT</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">

                <!--NO KP-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_ktp" class="control-label">Nomor KTP<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="Nomor KTP" name="nomor_ktp" type="text" value="">
                  </div>
                </div>

                <!--NO HP-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_hp" class="control-label">Nomor HP/Whatsapp<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="+62" name="nomor_hp" type="text" value="">
                  </div>
                </div>

                <!--TANGGAL JOIN-->
                <div class="col-md-4">
                  <div class="form-group">
                  <label for="date_of_join"><?php echo $this->lang->line('xin_employee_doj');?><i class="hrpremium-asterisk">*</i></label>
                  <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('xin_employee_doj');?>" name="date_of_join" type="text" value="">
                  </div>
                </div>

              </div>
            </div>

            <div class="col-md-6">
              <div class="row">
                <!--PROJECT-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="projects"><?php echo $this->lang->line('left_projects');?><i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" id="aj_project" name="project_id" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_projects');?>">

                      <option value=""><?php echo $this->lang->line('xin_choose_department');?></option>
                      <?php
                        foreach ($all_projects as $project) {
                      ?>
                        <option value="<?php echo $project->project_id?>"><?php echo $project->title;?></option>
                      <?php 
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <!--SUB PROJECT-->
                <div class="col-md-6" id="project_sub_project">
                    
                    <label for="sub_project"><?php echo $this->lang->line('left_sub_projects');?></label>
                    
                    <select disabled="disabled" name="sub_project" id="project_sub_project" class="form-control" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_sub_projects');?>">
                      <option value=""><?php echo $this->lang->line('left_sub_projects');?></option>
                    </select>
                </div>
              </div>

              <div class="row">

                <!--DEPARTEMENT-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="department_id"><?php echo $this->lang->line('left_department');?><i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="department_id" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_department');?>">

                      <option value=""><?php echo $this->lang->line('xin_choose_department');?></option>
                      <?php
                        foreach ($all_departments as $dept) {
                      ?>
                        <option value="<?php echo $dept->department_id?>"><?php echo $dept->department_name;?></option>
                      <?php 
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <!--POSISI/JABATAN-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="posisi"><?php echo $this->lang->line('left_designation');?><i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="posisi" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_designation');?>">

                      <option value="">Pilih Posisi/Jabatan</option>
                      <?php
                        foreach ($all_designations as $design) {
                      ?>
                        <option value="<?php echo $design->designation_id?>"><?php echo $design->designation_name;?></option>
                      <?php 
                      }
                      ?>
                    </select>
                  </div>
                </div>

              </div>

            <!-- end row -->
            </div>
          </div>

        </div>

        <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> 
        </div>
        <?php echo form_close(); ?> 
      </div>
    </div>

</div>

<?php } ?>
<div class="card">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_companies');?></span> </div>
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
            <th><?php echo $this->lang->line('xin_employee_doj');?></th>
            <th><?php echo $this->lang->line('xin_e_details_contact');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
