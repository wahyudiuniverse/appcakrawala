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
                
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
