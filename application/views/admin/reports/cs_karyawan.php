<?php
/* Employees report view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $_tasks = $this->Timesheet_model->get_tasks();?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="row">
    <div class="col-md-12 <?php echo $get_animate;?>">
        <div class="ui-bordered px-4 pt-4 mb-4">
        <input type="hidden" id="user_id" value="0" />
        <?php $attributes = array('name' => 'employee_reports', 'id' => 'employee_reports', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
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
      <?php 
        if ($user_info[0]->user_role_id==1) { 
      ?>
        <div class="col-md mb-3">
          <label class="form-label"><?php echo $this->lang->line('left_company');?></label>
          <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
            <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
            <?php 
              foreach ($all_companies as $company) {
            ?>
                <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
            <?php 
              } 
            ?>
          </select>
        </div>
      <?php 
        } else {
      ?>
      <?php $ecompany_id = $user_info[0]->company_id;?>
        
        <div class="col-md mb-3">
          <label class="form-label"><?php echo $this->lang->line('left_company');?></label>
          <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
            <option value=""><?php echo $this->lang->line('left_company');?></option>
            <?php 
              foreach ($all_companies as $company) {
            ?>
              <?php if ($ecompany_id == $company->company_id): ?>
                <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
              <?php endif;?>
            <?php 
              } 
            ?>
          </select>
        </div>
      <?php 
        } 
      ?>
      
        <div class="col-md mb-3" hidden>
          <div class="form-group" id="department_ajax">
            <label class="form-label"><?php echo $this->lang->line('xin_employee_department');?></label>
            <select disabled="disabled" class="form-control" name="department_id" id="aj_department" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_department');?>">
              <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
            </select>
          </div>   
        </div>
             
        <div class="col-md mb-3">
          <label class="form-label"><?php echo $this->lang->line('left_projects');?></label>
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

        <div class="col-md mb-2">
          <div class="form-group">
            <label class="form-label"><?php echo $this->lang->line('dashboard_xin_status');?></label>
            <select class="form-control" name="status_resign" id="aj_status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
              <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
              <option value="1">AKTIF</option>
              <option value="2">RESIGN</option>
              <option value="3">BLACKLIST</option>
            </select>
          </div>   
        </div>

        <div class="col-md col-xl-2 mb-4">
          <label class="form-label d-none d-md-block">&nbsp;</label>
            <button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('xin_get');?></button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_hr_report_employees');?></strong></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table" style="width:100%;table-layout: fixed;">
            <thead>
              <tr>
                <th style="width: 60px;">Status</th>
                <th style="width: 60px;"><?php echo $this->lang->line('xin_nip');?></th>
                <th style="width: 180px;"><?php echo $this->lang->line('xin_employees_full_name');?></th>
                <th style="width: 100px;"><?php echo $this->lang->line('xin_contact_number');?></th>
                <th style="width: 150px;"><?php echo $this->lang->line('left_department');?></th>
                <th style="width: 200px;"><?php echo $this->lang->line('left_designation');?></th>
                <th style="width: 120px;"><?php echo $this->lang->line('left_projects');?></th>
                <th style="width: 120px;"><?php echo $this->lang->line('left_sub_projects');?></th>
                <th style="width: 120px;"><?php echo $this->lang->line('xin_employee_dob');?></th>
                <th style="width: 50px;"><?php echo $this->lang->line('xin_pin');?></th>
                
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
