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
// reports to 
$reports_to = get_reports_team_data($session['user_id']); ?>

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
<?php if(in_array('201',$role_resources_ids)) {?>
<div class="card mb-4">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_employee');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_employee', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/employees/add_employee', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-6">
              <div class="row">

<!--
                //EMPLOYEE ID
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="employee_id"><?php /* echo $this->lang->line('dashboard_employee_id') */;?><i class="hrpremium-asterisk">*#</i></label>
-->
                    <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_employee_id');?>" name="employee_id" type="hidden" value="<?php echo $employee_id;?>">
<!--                    
                  </div>
                </div>
-->

<!--USERNAME-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="username"><?php echo $this->lang->line('dashboard_employee_id');?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_employee_id');?>" name="username" type="text" value="">
                  </div>
                </div>

<!--DOJ-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="date_of_joining" class="control-label"><?php echo $this->lang->line('xin_employee_doj');?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('xin_employee_doj');?>" name="date_of_joining" type="text" value="<?php echo date('Y-m-d');?>">
                  </div>
                </div>

              </div>


              <div class="row">

<!--PASSWORD-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="xin_employee_password"><?php echo $this->lang->line('xin_employee_password');?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_password');?>" name="password" type="text" value="">
                  </div>
                </div>
<!--CONFIRM-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="confirm_password" class="control-label"><?php echo $this->lang->line('xin_employee_cpassword');?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_cpassword');?>" name="confirm_password" type="text" value="">
                  </div>
                </div>
              </div>

              <div class="row">

<!--EMAIL-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email" class="control-label"><?php echo $this->lang->line('dashboard_email');?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_email');?>" name="email" type="text" value="">
                  </div>
                </div>

<!--CONTACT-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="contact_no" class="control-label"><?php echo $this->lang->line('xin_contact_number');?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_no" type="text" value="">
                  </div>
                </div>

              </div>

              <div class="row">

<!--GENDER-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="gender" class="control-label"><?php echo $this->lang->line('xin_employee_gender');?></label>
                    <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_gender');?>">
                      <option value="Male"><?php echo $this->lang->line('xin_gender_male');?></option>
                      <option value="Female"><?php echo $this->lang->line('xin_gender_female');?></option>
                    </select>
                  </div>
                </div>
<!--HBD-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="date_of_birth"><?php echo $this->lang->line('xin_employee_dob');?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('xin_employee_dob');?>" name="date_of_birth" type="text" value="">
                  </div>
                </div>

              </div>

            </div>

            <div class="col-md-6">
              <div class="row">

<!--FISTNAME-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="first_name"><?php echo $this->lang->line('xin_employee_first_name');?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_first_name');?>" name="first_name" type="text" value="">
                  </div>
                </div>

<!--LASTNAME-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="last_name" class="control-label"><?php echo $this->lang->line('xin_employee_last_name');?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_last_name');?>" name="last_name" type="text" value="">
                  </div>
                </div>

              </div>

<!--COMPANY ID-->
              <div class="row">
                <?php if($user_info[0]->user_role_id==1){ ?>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="first_name"><?php echo $this->lang->line('left_company');?><i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="company_id" id="aj_company_emp" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                      <option value=""><?php echo $this->lang->line('left_company');?></option>
                      <?php foreach($get_all_companies as $company) {?>
                      <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <?php } else {?>
                <?php $ecompany_id = $user_info[0]->company_id;?>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="first_name"><?php echo $this->lang->line('left_company');?><i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="company_id" id="aj_company_emp" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                      <option value=""><?php echo $this->lang->line('left_company');?></option>
                      <?php foreach($get_all_companies as $company) {?>
                      <?php if($ecompany_id == $company->company_id):?>
                      <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                      <?php endif;?>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <?php } ?>

<!-- LOCATION (H0/AREA) -->
                <div class="col-md-6" id="location_ajax">
                  <div class="form-group">
                    <label for="name"><?php echo $this->lang->line('left_location');?><i class="hrpremium-asterisk">*</i></label>
                    <select disabled="disabled" name="location_id" id="location_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
                      <option value=""><?php echo $this->lang->line('left_location');?></option>
                    </select>
                  </div>
                </div>
              </div>
<!-- DEPARTEMENT -->
              <div class="row">
                <?php $colmd=4; if($system[0]->is_active_sub_departments=='yes'){ $ncolmd = 4; } else { $ncolmd = 6;}?>
                <div class="col-md-<?php echo $ncolmd;?>">
                  <div class="form-group" id="department_ajax">
                    <label for="department"><?php echo $this->lang->line('xin_hr_main_department');?><i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_department');?>" disabled="disabled">
                      <option value=""><?php echo $this->lang->line('xin_employee_department');?></option>
                    </select>
                  </div>
                </div>
                <?php $colmd=4; if($system[0]->is_active_sub_departments=='yes'){?>
                <div class="col-md-4" id="subdepartment_ajax">
                  <div class="form-group">
                    <label for="designation"><?php echo $this->lang->line('xin_hr_sub_department');?><i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="subdepartment_id" data-plugin="select_hrm" disabled="disabled" data-placeholder="<?php echo $this->lang->line('xin_hr_sub_department');?>">
                      <option value=""><?php echo $this->lang->line('xin_hr_sub_department');?></option>
                    </select>
                  </div>
                </div>
                <?php $colmd = '4'; } else { $colmd = '6';?>
                <input type="hidden" name="subdepartment_id" value="YES" />
                <?php } ?>
<!-- DIVISI -->
                <div class="col-md-<?php echo $colmd;?>" id="designation_ajax">
                  <div class="form-group">
                    <label for="designation"><?php echo $this->lang->line('xin_designation');?><i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="designation_id" data-plugin="select_hrm" disabled="disabled" data-placeholder="<?php echo $this->lang->line('xin_designation');?>">
                      <option value=""><?php echo $this->lang->line('xin_designation');?></option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
<!--SHIFT-->
                <div class="col-md-6">
                  <div class="form-group" id="ajax_office_shift">
                    <label for="office_shift_id" class="control-label"><?php echo $this->lang->line('xin_employee_office_shift');?></label>
                    <select class="form-control" name="office_shift_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_office_shift');?>">
                      <option value=""><?php echo $this->lang->line('xin_employee_office_shift');?></option>
                    </select>
                  </div>
                </div>

              </div>

<!-- end row -->

            </div>
          </div>

          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="role"><?php echo $this->lang->line('xin_employee_role');?><i class="hrpremium-asterisk">*</i></label>
                <select class="form-control" name="role" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_role');?>">
                  <option value=""><?php echo $this->lang->line('xin_employee_role');?></option>
                  <?php foreach($all_user_roles as $role) {?>
                  <?php if($user_info[0]->user_role_id==1){?>
                  <option value="<?php echo $role->role_id?>"><?php echo $role->role_name?></option>
                  <?php } else {?>
                  <?php if($role->role_id!=1){?>
                  <option value="<?php echo $role->role_id?>"><?php echo $role->role_name?></option>
                  <?php } ?>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
            <?php if(!in_array('13',$role_resources_ids)) { ?>
            <div class="col-md-3">
              <div class="form-group">
                <label for="reports_to"><?php echo $this->lang->line('xin_reports_to');?></label>
                <select name="reports_to" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_reports_to');?>">
                  <option value=""><?php echo $this->lang->line('xin_reports_to');?></option>
                  <?php foreach(get_reports_to() as $reports_to) {?>
                  <?php if($reports_to->user_id == $session['user_id']):?>
                  <option value="<?php echo $reports_to->user_id?>" <?php if($reports_to->user_id == $session['user_id']):?> selected="selected"<?php endif;?>><?php echo $reports_to->first_name.' '.$reports_to->last_name;?></option>
                  <?php endif;?>
                  <?php } ?>
                </select>
              </div>
            </div>
            <?php } else {?>
            <div class="col-md-3">
              <div class="form-group">
                <label for="reports_to"><?php echo $this->lang->line('xin_reports_to');?></label>
                <select name="reports_to" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_reports_to');?>">
                  <option value=""><?php echo $this->lang->line('xin_reports_to');?></option>
                  <?php foreach(get_reports_to() as $reports_to) {?>
                  <option value="<?php echo $reports_to->user_id?>"><?php echo $reports_to->first_name.' '.$reports_to->last_name;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <?php } ?>
            <div class="col-md-6">
              <div class="form-group">
                <label for="xin_hr_leave_cat"><?php echo $this->lang->line('xin_hr_leave_cat');?></label>
                <input type="hidden" name="leave_categories[]" value="0" />
                <select multiple="multiple" class="form-control" name="leave_categories[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_hr_leave_cat');?>">
                  <option value=""><?php echo $this->lang->line('xin_hr_leave_cat');?></option>
                  <?php foreach($all_leave_types as $leave_type) {?>
                  <option value="<?php echo $leave_type->leave_type_id?>"><?php echo $leave_type->type_name?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
<!--PIN CODE
            <div class="col-md-3">
              <div class="form-group">
                <label for="xin_pincode"><?php echo $this->lang->line('xin_pincode');?><i class="hrpremium-asterisk">*</i></label>
              -->
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_pincode');?>" name="pin_code" type="hidden" value="<?php echo $employee_pincode;?>">
                <!--
              </div>
            </div>
          -->
<!--ADDRESS-->
            <div class="col-md-9">
              <div class="form-group">
                <label for="address"><?php echo $this->lang->line('xin_employee_address');?></label>
                <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_address');?>" name="address">
              </div>
            </div>

          </div>
        </div>
        <?php $count_module_attributes = $this->Custom_fields_model->count_module_attributes();?>
        <?php $module_attributes = $this->Custom_fields_model->all_hrpremium_module_attributes();?>
        <!--<div class="row">
                    <?php foreach($module_attributes as $mattribute):?>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                        <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text">
                      </div>
                    </div>
                    <?php endforeach;?>
                  </div>-->
        <?php if($count_module_attributes > 0):?>
        <div class="row">
          <?php foreach($module_attributes as $mattribute):?>
          <?php if($mattribute->attribute_type == 'date'){?>
          <div class="col-md-4">
            <div class="form-group">
              <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
              <input class="form-control date" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text">
            </div>
          </div>
          <?php } else if($mattribute->attribute_type == 'select'){?>
          <div class="col-md-4">
            <?php $iselc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
            <div class="form-group">
              <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
              <select class="form-control" name="<?php echo $mattribute->attribute;?>" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute->attribute_label;?>">
                <?php foreach($iselc_val as $selc_val) {?>
                <option value="<?php echo $selc_val->attributes_select_value_id?>"><?php echo $selc_val->select_label?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <?php } else if($mattribute->attribute_type == 'multiselect'){?>
          <div class="col-md-4">
            <?php $imulti_selc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
            <div class="form-group">
              <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
              <select multiple="multiple" class="form-control" name="<?php echo $mattribute->attribute;?>[]" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute->attribute_label;?>">
                <?php foreach($imulti_selc_val as $multi_selc_val) {?>
                <option value="<?php echo $multi_selc_val->attributes_select_value_id?>"><?php echo $multi_selc_val->select_label?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <?php } else if($mattribute->attribute_type == 'textarea'){?>
          <div class="col-md-8">
            <div class="form-group">
              <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
              <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text">
            </div>
          </div>
          <?php } else if($mattribute->attribute_type == 'fileupload'){?>
          <div class="col-md-4">
            <div class="form-group">
              <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
              <input class="form-control-file" name="<?php echo $mattribute->attribute;?>" type="file">
            </div>
          </div>
          <?php } else { ?>
          <div class="col-md-4">
            <div class="form-group">
              <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
              <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text">
            </div>
          </div>
          <?php }	?>
          <?php endforeach;?>
        </div>
        <?php endif;?>
        <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php }?>


<div class="card">

<!-- add employee \\ check rule -->  

<div class="card-header with-elements"> 
  <span class="card-header-title mr-2">
    <strong><?php echo $this->lang->line('xin_list_all');?></strong> 
    <?php echo $this->lang->line('xin_employees');?>
  </span>
  <div class="card-header-elements ml-md-auto"> 


    <a class="text-dark collapsed" data-toggle="collapse" href="#filter_hrpremium" aria-expanded="false">
      <button type="button" class="btn btn-xs btn-primary"> 
        <span class="ion ion-ios-color-filter"></span> 
        <?php echo $this->lang->line('xin_filter');?>
      </button>
    </a> 

    <a href="<?php echo site_url('admin/reports/employees/');?>" class="text-dark collapsed">
      <button type="button" class="btn btn-xs btn-primary"> 
        <span class="fas fa-chart-bar"></span> 
        <?php echo $this->lang->line('xin_report');?>
      </button>
    </a>
  </div>
</div>

  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th>NIP</th>
            <th>KTP</th>
            <th><i class="fa fa-user"></i> NAMA LENGKAP</th>
            <th>PROJECT</th>
            <th>POSISI/JABATAN</th>
            <th>AREA</th>
            <th><?php echo $this->lang->line('dashboard_contact');?></th>
            <th><?php    $this->lang->line('xin_employee_dob');?></th>
            <th>Last Login</th>
            <th><?php echo $this->lang->line('xin_employee_role');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

</div>
