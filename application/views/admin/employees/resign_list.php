<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>

<?php $count_appnae = $this->Xin_model->count_approve_nae();?>
<?php $count_appnom = $this->Xin_model->count_approve_nom();?>
<?php $count_apphrd = $this->Xin_model->count_approve_hrd();?>
<?php $count_emp_request = $this->Xin_model->count_emp_request();?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('491',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/employee_resign/');?>" data-link-data="<?php echo site_url('admin/employee_resign/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon fa fa-database"></span> Status Resign
      </a> </li>
    <?php } ?>  
    
    <?php if(in_array('492',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/Employee_resign_apnae/');?>" data-link-data="<?php echo site_url('admin/Employee_resign_apnae/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> Approve NAE <?php echo '('.$count_appnae.')';?>
      </a> </li>
    <?php } ?>

    <?php if(in_array('493',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/Employee_resign_apnom/');?>" data-link-data="<?php echo site_url('admin/Employee_resign_apnom/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> Approve NOM/SM <?php echo '('.$count_appnom.')';?>
      </a> </li>
    <?php } ?>

    <?php if(in_array('494',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/Employee_resign_aphrd/');?>" data-link-data="<?php echo site_url('admin/Employee_resign_aphrd/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> Approve HRD
      <?php echo '('.$count_apphrd.')';?></a> </li>
    <?php } ?>
    
    <?php if(in_array('491',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/Employee_resign_history/');?>" data-link-data="<?php echo site_url('admin/Employee_resign_history/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> History Resign
      </a> </li>
    <?php } ?>
  </ul>
</div>

<hr class="border-light m-0 mb-3">
<?php $employee_id = $this->Xin_model->generate_random_employeeid();?>
<?php $employee_pincode = $this->Xin_model->generate_random_pincode();?>

<?php if(in_array('491',$role_resources_ids)) {?>

<div class="card mb-4">
  <!-- <div id="accordion"> -->
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>REQUEST</strong> EMPLOYEE RESIGN</span>
      <div class="card-header-elements ml-md-auto"> </div>
    </div>
    <div id="add_form" class="add-form <?php echo $get_animate;?>">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_employee', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/employee_resign/request_employee_resign', $attributes, $hidden);?>
        <div class="form-body">

          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <input name="employee_id" type="hidden" value="<?php echo $employee_id;?>">

                <!--PROJECT-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="projects"><?php echo $this->lang->line('left_projects');?><i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="project_id" id="aj_project" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_projects');?>">

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

                <!--NAMA LENGKAP-->
                <div class="col-md-6" >
                  <div class="form-group" id="project_employees_ajax">
                   <label for="employee_id"><?php echo $this->lang->line('xin_karyawan');?><i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="employee_id" id="aj_ktp" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_karyawan');?>">
                      <option value=""></option>
                      <?php foreach($all_emp_active as $empactive) {?>
                      <option value="<?php echo $empactive->employee_id;?>"><?php echo $empactive->fullname?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

              </div>

              <div class="row">
                <!-- KTP RESIGN -->
                <div class="col-md-4">
                  <div class="form-group" id="ktp_ajax">
                    <label for="nomor_ktp" class="control-label">Nomor KTP<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="Nomor KTP" name="nomor_ktp" type="text" value="">
                  </div>
                </div>

                <!--STATUS RESIGN-->
                <div class="col-md-4">
                  <div class="form-group">
                   <label for="employee_id">Status Resign<i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="status_resign" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_karyawan');?>">
                      <option value=""></option>
                      <option value="2">RESIGN</option>
                      <option value="4">END CONTRACT</option>
                      <option value="3">BLACKLIST</option>

                    </select>
                  </div>
                </div>

                <!--TANGGAL RESIGN-->
                <div class="col-md-4">
                  <div class="form-group">
                  <label for="date_of_birth">Tanggal Berakhir<i class="hrpremium-asterisk">*</i></label>
                  <input class="form-control date" readonly placeholder="Tanggal Resign" name="date_of_leave" type="text" value="">
                  </div>
                </div>

              </div>

              <div class="row">
                <!--NO KP-->
                <div class="col-md-8">
                  <br>
                  <div class="form-group">
                  <label for="date_of_birth">Upload Exit Clearance<i class="hrpremium-asterisk">*</i></label>
                  <br>
                  <p class="form-row"> &nbsp;&nbsp;
                    <input type="file" id="dok_exitc" name="dok_exitc" />
                  </p>
                  </div>
                </div>
              </div>

              <div class="row">
                <!--NO KP-->
                <div class="col-md-8">
                  <br>
                  <div class="form-group">
                  <label for="date_of_birth">Upload Surat Resign<i class="hrpremium-asterisk">*</i></label>
                  <br>
                  <p class="form-row"> &nbsp;&nbsp;
                    <input type="file" id="dok_sresign" name="dok_sresign" />
                  </p>
                  </div>
                </div>
              </div>

              <div class="row">
                <!--NO KP-->
                <div class="col-md-8">
                  <br>
                  <div class="form-group">
                  <label for="date_of_birth">Upload Surat Hand Over<i class="hrpremium-asterisk"></i></label>
                  <br>
                  <p class="form-row"> &nbsp;&nbsp;
                    <input type="file" id="dok_sover" name="dok_sover" />
                  </p>
                  </div>
                </div>
              </div>

            </div>

            <div class="col-md-6" id="info_ajax">

              <div class="row">
                <!--TANGGAL BERGABUNG-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="department_id"><?php echo $this->lang->line('xin_employee_doj');?><i class="hrpremium-asterisk"></i></label>
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="form-group">
                    <label for="department_id">: -<i class="hrpremium-asterisk"></i></label>
                  </div>
                </div>
              </div>

              <div class="row">
                <!--POSISI JABATAN-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="department_id"><?php echo $this->lang->line('dashboard_designation');?><i class="hrpremium-asterisk"></i></label>
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="form-group">
                    <label for="department_id">: -<i class="hrpremium-asterisk"></i></label>
                  </div>
                </div>
              </div>


              <div class="row">
                <!--LOKASI PENEMPATAN-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="department_id"><?php echo $this->lang->line('left_lokasi_penempatan');?><i class="hrpremium-asterisk"></i></label>
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="form-group">
                    <label for="department_id">: -<i class="hrpremium-asterisk"></i></label>
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
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>DAFTAR</strong> PERMINTAAN KARYAWAN RESIGN</span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_request_employee_status');?></th>
            <th>NIP</th>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_employees_full_name');?></th>
            <th><?php echo $this->lang->line('left_projects');?></th>
            <th><?php echo $this->lang->line('left_designation');?></th>
            <th>Tanggal Resign</th>
            <th><?php echo $this->lang->line('xin_placement');?></th>
            <th>No KTP</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<style type="text/css">
  
  input[type=file]::file-selector-button {
  margin-right: 20px;
  border: none;
  background: #26ae61;
  padding: 10px 20px;
  border-radius: 2px;
  color: #fff;
  cursor: pointer;
  transition: background .2s ease-in-out;
}

input[type=file]::file-selector-button:hover {
  background: #20c997;
}
</style>