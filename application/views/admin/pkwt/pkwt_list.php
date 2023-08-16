<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>

<?php $count_appnae = $this->Xin_model->count_approve_nae_pkwt($session['employee_id']);?>
<?php $count_appnom = $this->Xin_model->count_approve_nom_pkwt($session['employee_id']);?>
<?php $count_apphrd = $this->Xin_model->count_approve_hrd_pkwt($session['employee_id']);?>
<?php $count_pkwtcancel = $this->Xin_model->count_approve_pkwt_cancel($session['employee_id']);?>
<?php $count_emp_request = $this->Xin_model->count_emp_request($session['employee_id']);?>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('377',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/employee_pkwt/');?>" data-link-data="<?php echo site_url('admin/employee_pkwt/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon fa fa-database"></span>PENGAJUAN PKWT
      </a> </li>
    <?php } ?>  

    <?php if(in_array('505',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_pkwt_aphrd');?>" data-link-data="<?php echo site_url('admin/Employee_pkwt_aphrd/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span>TERBITKAN PKWT
      <?php echo '('.$count_apphrd.')';?></a> </li>
    <?php } ?>
    
    <?php if(in_array('379',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_pkwt_cancel');?>" data-link-data="<?php echo site_url('admin/Employee_pkwt_cancel/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span>PKWT Ditolak <?php echo '('.$count_pkwtcancel.')';?>
      </a> </li>
    <?php } ?>

    <?php if(in_array('377',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/reports/pkwt_history');?>" data-link-data="<?php echo site_url('admin/reports/pkwt_history/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span>PKWT Status
      </a> </li>
    <?php } ?>
  </ul>
</div>

<hr class="border-light m-0 mb-3">
<?php $employee_id = $this->Xin_model->generate_random_employeeid();?>
<?php $employee_pincode = $this->Xin_model->generate_random_pincode();?>

<?php if(in_array('376',$role_resources_ids)) {?>

<div class="card mb-4">
  <!-- <div id="accordion"> -->
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>REQUEST</strong> PKWT</span>
      <div class="card-header-elements ml-md-auto"> </div>
    </div>
    <div id="add_form" class="add-form <?php echo $get_animate;?>">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_employee', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/employee_pkwt/request_employee_pkwt', $attributes, $hidden);?>
        <div class="form-body">

          <div class="row">

            <div class="col-md-6">

              <div class="row">
                <input name="employee_id" type="hidden" value="<?php echo $employee_id;?>">

                <!--PROJECT-->
                <div class="col-md-4">
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
                <div class="col-md-4" >
                  <div class="form-group" id="project_employees_ajax">
                   <label for="employee_id"><?php echo $this->lang->line('xin_karyawan');?><i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="employee_id" id="aj_ktp" data-plugin="xin_select">
                      <option value="">--</option>
                    </select>
                  </div>
                </div>

                <!-- WAKTU KONTRAK -->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="waktu_kontrak">Waktu Kontrak<i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="waktu_kontrak" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_e_details_office_location');?>">
                      <option value="1">1 (Bulan)</option>
                      <option value="2">2 (Bulan)</option>
                      <option value="3" selected>3 (Bulan)</option>
                      <option value="4">4 (Bulan)</option>
                      <option value="5">5 (Bulan)</option>
                      <option value="6">6 (Bulan)</option>
                      <option value="7">7 (Bulan)</option>
                      <option value="12">12 (Bulan)</option>
                    </select>
                  </div>
                </div>
            <!-- end row -->
            </div>
          </div>

            <div class="col-md-6">
              <div class="row">

                <!-- AREA -->
                <div class="col-md-4" hidden>
                  <div class="form-group" id="project_area_ajax">
                    <label for="area">Area/Penempatan<i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="area" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_e_details_office_location');?>" disabled>
                      <option value="0">--</option>
                    </select>
                  </div>
                </div>

                <!-- POSISI -->
                <div class="col-md-4" hidden>
                  <div class="form-group" id="x">
                    <label for="posisi">Posisi/Jabatan<i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="posisi" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_e_details_office_location');?>" disabled>
                      <option value="0">--</option>
                    </select>
                  </div>
                </div>

                <!-- NONE -->
                <div class="col-md-4" hidden>
                  <div class="form-group">
                    <label for="office_lokasi">None<i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="office_lokasi" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_e_details_office_location');?>" disabled>
                      <option value="0">--</option>
                    </select>
                  </div>
                </div>

            <!-- end row -->
            </div>
          </div>

        </div>
<BR>


<div class="card">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>DATABASE</strong> X PKWT</span> </div>
  <div class="card-body">

        <div class="row">
          <div class="col-md-6" id="info_ajax">

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">NIP</label>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="projects">: -</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Nama Lengkap</label>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="projects">: -</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Perusahaan</label>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="projects">: -</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Departmen</label>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="projects">: -</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Project</label>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="projects">: -</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Posisi/Jabatan</label>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="projects">: -</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Penempatan</label>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="projects">: -</label>
                  </div>
                </div>
              </div>
          </div>

          <div class="col-md-6">

              <div class="row">
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Project</label>
                  </div>
                </div>

                <!--PROJECT-->
                <div class="col-md-8">
                  <div class="form-group" id="pkwt_project_ajax">
                    <label for="projects">: -</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Posisi/Jabatan</label>
                  </div>
                </div>

                <!--PROJECT-->
                <div class="col-md-8">
                  <div class="form-group" id="pkwt_posisi_ajax">
                    <label for="projects">: -</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Penempatan</label>
                  </div>
                </div>

                <!--PROJECT-->
                <div class="col-md-8">
                  <div class="form-group" id="pkwt_area_ajax">
                    <label for="projects">: -</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group" >
                    <label for="projects">Waktu Kontrak</label>
                  </div>
                </div>

                <!--PROJECT-->
                <div class="col-md-8">
                  <div class="form-group" id="pkwt_kontrak_ajax">
                    <label for="projects">: -</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Begin - Until</label>
                  </div>
                </div>

                <!--PROJECT-->
                <div class="col-md-8">
                  <div class="form-group" id="pkwt_begin_ajax">
                    <label for="projects">: -</label>
                  </div>
                </div>
              </div>


              <div class="row">
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Hari Kerja</label>
                  </div>
                </div>

                <!--PROJECT-->
                <div class="col-md-8">
                  <div class="form-group" id="pkwt_hk_ajax">
                    <label for="projects">: -</label>
                  </div>
                </div>
              </div>

              <div id="pkwt_gaji_ajax">
                <div class="row">
                  <!--PROJECT-->
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="projects">Gaji Pokok</label>
                    </div>
                  </div>

                  <!--PROJECT-->
                  <div class="col-md-8">
                    <div class="form-group" >
                      <label for="projects">: -</label>
                    </div>
                  </div>
                  

                </div>
              </div>
          </div>
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
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>MONITORING </strong> PKWT</span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th>No.</th>
            <th><?php echo $this->lang->line('xin_request_employee_status');?></th>
            <th>NIP</th>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_employees_full_name');?></th>
            <th><?php echo $this->lang->line('left_projects');?></th>
            <th><?php echo $this->lang->line('left_designation');?></th>
            <th>Waktu Kontrak</th>
            <th>Gaji Pokok</th>
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