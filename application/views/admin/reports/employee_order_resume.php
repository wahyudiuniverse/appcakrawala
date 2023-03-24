<?php
/* Date Wise Attendance Report > EMployees view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('114',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/reports/report_resume/');?>" data-link-data="<?php echo site_url('admin/reports/report_resume/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon fa fa-database"></span> Resume Order
      </a> </li>
    <?php } ?>  
    <?php if(in_array('114',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/reports/report_order/');?>" data-link-data="<?php echo site_url('admin/reports/report_order/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> Detail Order</a> </li>
    <?php } ?>

  </ul>
</div>

<hr class="border-light m-0 mb-3">

<div class="row">
    <div class="col-md-12 <?php echo $get_animate;?>">
        <div class="ui-bordered px-4 pt-4 mb-4">
        <input type="hidden" id="user_id" value="0" />
        <?php $attributes = array('name' => 'attendance_datewise_report', 'id' => 'attendance_datewise_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
    <?php $hidden = array('euser_id' => $session['user_id']);?>
        <?php echo form_open('admin/reports/report_order', $attributes, $hidden);?>
        <?php
            $data = array(
              'name'        => 'user_id',
              'id'          => 'user_id',
              'value'       => $session['user_id'],
              'type'      => 'hidden',
              'class'       => 'form-control',
            );
            
            echo form_input($data);
            ?>
          <div class="form-row">

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


          <div class="col-md mb-3" id="project_ajax">
            <label class="form-label"><?php echo $this->lang->line('left_projects');?></label>
            <select class="form-control" name="project_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_projects');?>">
              <option value="0">--</option>
            </select>
          </div>

          <div class="col-md mb-3" id="subproject_ajax">
            <label class="form-label">Sub Projects</label>
            <select class="form-control" name="sub_project_id" data-plugin="select_hrm" data-placeholder="Sub Project">
              <option value="0">--</option>
            </select>
          </div>

          <div class="col-md mb-3">
              <label class="form-label">Start Date</label>
              <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="start_date" name="start_date" id="aj_sdate" type="text" value="<?php echo date('Y-m-d');?>">
          </div>
            
            <div class="col-md mb-3">
              <label class="form-label">End Date</label>
              <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="end_date" name="end_date" id="aj_edate" type="text" value="<?php echo date('Y-m-d');?>">
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
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_order_report');?></strong></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th colspan="2"><?php echo $this->lang->line('xin_hr_info');?></th>
                <th colspan="9"><?php echo $this->lang->line('xin_attendance_report');?></th>
              </tr>
              <tr>
                <th style="width:50px;">NIP</th>
                <th style="width:200px;">FULLNAME</th>
                <th style="width:100px;">AREA</th>
                <th style="width:100px;">START DATE</th>
                <th style="width:100px;">END DATE</th>
                <th style="width:100px;">CALL</th>
                <th style="width:100px;">EC</th>
                <th style="width:100px;">QTY (Renceng)</th>
                <th style="width:100px;">PRICE/Renceng</th>
                <th style="width:100px;">TOTAL</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
