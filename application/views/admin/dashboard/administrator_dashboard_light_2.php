<?php
$session = $this->session->userdata('username');
$system = $this->Xin_model->read_setting_info(1);
$company_info = $this->Xin_model->read_company_setting_info(1);
$user = $this->Xin_model->read_employee_info($session['user_id']);
$theme = $this->Xin_model->read_theme_info(1);
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<h4 class="font-weight-bold pys-3 mb-4"> <?php echo $this->lang->line('xin_title_wcb');?>, <?php echo $user[0]->first_name.' '.$user[0]->last_name;?>!
  <div class="text-muted text-tiny mt-1"><small class="font-weight-normal"><?php echo $this->lang->line('xin_title_today_is');?> <?php echo date('l, j F Y');?></small></div>
</h4>
<?php if($theme[0]->statistics_cards=='4' || $theme[0]->statistics_cards=='8'){?>
<div class="row <?php echo $get_animate;?>">
<?php if(in_array('13',$role_resources_ids)) { ?>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/employees');?>" class="text-body">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-contacts display-4 text-primary"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_people');?></div>
            <div class="text-big"><?php echo $this->Employees_model->get_total_employees();?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
  <?php } ?>  
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/roles');?>" class="text-body">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-lock display-4 text-primary"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_roles');?></div>
            <div class="text-big"><?php echo $this->lang->line('xin_permission');?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
  <?php if(in_array('46',$role_resources_ids)) { ?>  
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/timesheet/leave');?>" class="text-body">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-md-calendar display-4 text-primary"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('left_leave');?></div>
            <div class="text-big"><?php echo $this->lang->line('xin_performance_management');?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
  <?php } ?>
  <?php if(in_array('36',$role_resources_ids)) { ?>   
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/payroll/generate_payslip');?>" class="text-body">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-calculator display-4 text-primary"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('dashboard_total_salaries');?></div>
            <div class="text-big"><?php echo $this->Xin_model->currency_sign(total_salaries_paid());?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
  <?php } ?>  
</div>
<?php } ?>

<?php if($theme[0]->statistics_cards=='8'){?>
<div class="row <?php echo $get_animate;?>">
  <?php if($system[0]->module_files=='true'){?>
  <?php if(in_array('47',$role_resources_ids)) { ?>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/files');?>" class="text-body">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-primary"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_e_details_document');?></div>
            <div class="text-big"><?php echo $this->lang->line('xin_performance_management');?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
  <?php } ?>  
  <?php } ?>
  <?php if(in_array('93',$role_resources_ids)) { ?>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/settings/modules');?>" class="text-body">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="fas fa-life-ring display-4 text-primary"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_configure_hr');?></div>
            <div class="text-big"><?php echo $this->lang->line('xin_modules');?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
  <?php } ?>  
  <?php if($system[0]->module_projects_tasks=='true'){?>
  <?php if(in_array('44',$role_resources_ids)) { ?>
  <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/project');?>" class="text-body">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-logo-buffer display-4 text-primary"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('dashboard_projects');?></div>
            <div class="text-big"><?php echo $this->Xin_model->get_all_projects();?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div>
    <?php } ?>
    <?php if(in_array('45',$role_resources_ids)) { ?>
    <div class="col-sm-6 col-xl-3"> <a href="<?php echo site_url('admin/timesheet/tasks');?>" class="text-body">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="fab fa-fantasy-flight-games display-4 text-primary"></div>
          <div class="ml-3">
            <div class="text-muted small"><?php echo $this->lang->line('xin_tasks');?></div>
            <div class="text-big"><?php echo completed_tasks();?></div>
          </div>
        </div>
      </div>
    </div>
    </a> </div> 
    <?php } ?> 
  <?php } ?>
</div>
<?php } ?>
<div class="row <?php echo $get_animate;?>">
  <div class="col-md-6">
    <div class="card mb-4">
      <h6 class="card-header with-elements border-0 pr-0 pb-0">
        <div class="card-header-title"><?php echo $this->lang->line('xin_employee_department_txt');?></div>
      </h6>
      <div class="row">
        <div class="col-md-6">
          <div id="overflow-scrolls" class="overflow-scrolls py-4 px-3 " style="overflow:auto; height:200px;">
            <div class="table-responsive">
              <table class="table mb-0 table-dashboard">
                <tbody>
                  <?php $c_color = array('#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b');?>
                  <?php $j=0;foreach($this->Department_model->all_departments() as $department) { ?>
                  <?php
						$condition = "department_id =" . "'" . $department->department_id . "'";
						$this->db->select('*');
						$this->db->from('xin_employees');
						$this->db->where($condition);
						$query = $this->db->get();
						// check if department available
						if ($query->num_rows() > 0) {
					?>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid <?php echo $c_color[$j];?>;"></div></td>
                    <td><?php echo htmlspecialchars_decode($department->department_name);?> (<?php echo $query->num_rows();?>)</td>
                  </tr>
                  <?php $j++; } ?>
                  <?php  } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div style="height:150px;">
            <canvas id="employee_department" height="250" width="270" style="display: block; height: 150px; width:300px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card mb-4">
      <h6 class="card-header with-elements border-0 pr-0 pb-0">
        <div class="card-header-title"><?php echo $this->lang->line('xin_employee_designation_txt');?></div>
      </h6>
      <div class="row">
        <div class="col-md-6">
          <div id="overflow-scrolls2" class="py-4 px-3 " style="overflow:auto; height:200px;">
            <div class="table-responsive">
              <table class="table mb-0 table-dashboard">
                <tbody>
                  <?php $c_color2 = array('#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b','#46be8a','#f96868','#00c0ef','#3c8dbc','#f39c12','#605ca8','#d81b60','#001f3f','#39cccc','#3c8dbc','#006400','#dd4b39','#a98852','#b26fc2','#66456e','#c674ad','#975df3','#61a3ca','#6bddbd','#6bdd74','#95b655','#668b20','#bea034','#d3733b');?>
                  <?php $k=0;foreach($this->Designation_model->all_designations() as $designation) { ?>
                  <?php
						$condition1 = "designation_id =" . "'" . $designation->designation_id . "'";
						$this->db->select('*');
						$this->db->from('xin_employees');
						$this->db->where($condition1);
						$query1 = $this->db->get();
						// check if department available
						if ($query1->num_rows() > 0) {
					?>
                  <tr>
                    <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid <?php echo $c_color2[$k];?>;"></div></td>
                    <td><?php echo htmlspecialchars_decode($designation->designation_name);?> (<?php echo $query1->num_rows();?>)</td>
                  </tr>
                  <?php $k++; } ?>
                  <?php  } ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div style="height:150px;">
            <canvas id="employee_designation" height="250" width="270" style="display: block; height: 150px; width:300px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
$current_month = date('Y-m-d');
$working = $this->Xin_model->current_month_day_attendance($current_month);
$query = $this->Xin_model->all_employees_status();
$total = $query->num_rows();
// absent
$abs = $total - $working;
?>
<?php
$emp_abs = $abs / $total * 100;
$emp_work = $working / $total * 100;
?>
<?php
$emp_abs = $abs / $total * 100;
$emp_work = $working / $total * 100;
?>
<div class="row row-card-no-pd mt--2 <?php echo $get_animate;?>">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5><span><?php echo $this->lang->line('xin_hrpremium_absent_today');?></span></h5>
                        <p class="text-muted"><?php echo $this->lang->line('xin_absent');?></p>
                    </div>
                    <h3 class="text-info fw-bold"><?php echo $abs;?></h3>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar progress-bar-info w-75" role="progressbar" aria-valuenow="<?php echo $this->Xin_model->set_percentage($emp_abs);?>" aria-valuemin="8" aria-valuemax="100" style="width: <?php echo $this->Xin_model->set_percentage($emp_abs);?>%"></div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <p class="text-muted mb-0"><?php echo $this->lang->line('xin_hrpremium_absent_status');?></p>
                    <p class="text-muted mb-0"><?php echo $this->Xin_model->set_percentage($emp_abs);?>%</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5><span><?php echo $this->lang->line('xin_hrpremium_present_today');?></span></h5>
                        <p class="text-muted"><?php echo $this->lang->line('xin_emp_working');?></p>
                    </div>
                    <h3 class="text-info fw-bold"><?php echo $working;?></h3>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar progress-bar-info w-75" role="progressbar" aria-valuenow="<?php echo $this->Xin_model->set_percentage($emp_work);?>" aria-valuemin="8" aria-valuemax="100" style="width: <?php echo $this->Xin_model->set_percentage($emp_work);?>%"></div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <p class="text-muted mb-0"><?php echo $this->lang->line('xin_hrpremium_present_status');?></p>
                    <p class="text-muted mb-0"><?php echo $this->Xin_model->set_percentage($emp_work);?>%</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5><span><?php echo $this->lang->line('dashboard_projects');?></span></h5>
                        <p class="text-muted"><?php echo $this->lang->line('xin_hrpremium_project_status');?></p>
                    </div>
                    <?php $completed_proj = $this->Project_model->complete_projects();?>
                    <?php $proj = $this->Xin_model->get_all_projects();
					if($proj < 1) {
						$proj_percnt = 0;
					} else {
						$proj_percnt = $completed_proj / $proj * 100;
                    }
					?>
                    <h3 class="text-info fw-bold"><a class="text-card-mduted" href="<?php echo site_url('admin/project');?>"><?php echo $this->Xin_model->get_all_projects();?></a></h3>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar progress-bar-info w-75" role="progressbar" aria-valuenow="<?php echo $this->Xin_model->set_percentage($proj_percnt);?>" aria-valuemin="8" aria-valuemax="100" style="width: <?php echo $this->Xin_model->set_percentage($proj_percnt);?>%"></div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <p class="text-muted mb-0"><?php echo $this->lang->line('xin_completed');?></p>
                    <p class="text-muted mb-0"><?php echo $this->Xin_model->set_percentage($proj_percnt);?>%</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5><span><?php echo $this->lang->line('xin_tasks');?></span></h5>
                        <p class="text-muted"><?php echo $this->lang->line('xin_hrpremium_task_status');?></p>
                    </div>
                    <?php $completed_tasks = completed_tasks();?>
                    <?php $task_all = $this->Xin_model->get_all_tasks();
					if($task_all < 1) {
						$task_percnt = 0;
					} else {
						$task_percnt = $completed_tasks / $task_all * 100;
                    }
                    ?>
                    <h3 class="text-info fw-bold"><a class="text-card-mduted" href="<?php echo site_url('admin/timesheet/tasks');?>"><?php echo $this->Xin_model->get_all_tasks();?></a></h3>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar progress-bar-info w-75" role="progressbar" aria-valuenow="<?php echo $this->Xin_model->set_percentage($task_percnt);?>" aria-valuemin="8" aria-valuemax="100" style="width: <?php echo $this->Xin_model->set_percentage($task_percnt);?>%"></div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <p class="text-muted mb-0"><?php echo $this->lang->line('xin_completed');?></p>
                    <p class="text-muted mb-0"><?php echo $this->Xin_model->set_percentage($task_percnt);?>%</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if($system[0]->module_inquiry=='true'){?>
<div class="row mt-4">
    <div class="d-flex col-xl-12 align-items-stretch">
    <!-- Stats + Links -->
    <div class="card d-flex w-100 mb-4">
      <div class="row no-gutters row-bordered h-100">
        <div class="d-flex col-sm-4 col-md-4 col-lg-4 align-items-center">
    
          <a href="javascript:void(0)" class="card-body media align-items-center text-body">
            <i class="fab fa-critical-role display-4 d-block text-primary"></i>
            <span class="media-body d-block ml-3">
              <span class="text-big font-weight-bolder"><?php echo total_tickets();?></span><br>
              <small class="text-muted"><?php echo $this->lang->line('xin_hr_total_tickets');?></small>
            </span>
          </a>
    
        </div>
        <div class="d-flex col-sm-4 col-md-4 col-lg-4 align-items-center">
    
          <a href="javascript:void(0)" class="card-body media align-items-center text-body">
            <i class="lnr lnr-chart-bars display-4 d-block text-primary"></i>
            <span class="media-body d-block ml-3">
              <span class="text-big"><?php echo total_open_tickets();?></span><br>
              <small class="text-muted"><?php echo $this->lang->line('xin_hr_total_open_tickets');?></small>
            </span>
          </a>
    
        </div>
        <div class="d-flex col-sm-4 col-md-4 col-lg-4 align-items-center">
    
          <a href="javascript:void(0)" class="card-body media align-items-center text-body">
            <i class="lnr lnr-checkmark-circle display-4 d-block text-primary"></i>
            <span class="media-body d-block ml-3">
              <span class="text-big"><?php echo total_closed_tickets();?></span><br>
              <small class="text-muted"><?php echo $this->lang->line('xin_hr_total_closed_tickets');?></small>
            </span>
          </a>
    
        </div>
        
      </div>
    </div>
    <!-- / Stats + Links -->
</div>  
</div>
<?php } ?>
<?php if($theme[0]->dashboard_calendar == 'true'):?>
<?php $this->load->view('admin/calendar/calendar_hr');?>
<?php endif; ?>