<?php
/*
Employee -> Employee Details view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php //$default_currency = $this->Xin_model->read_currency_con_info($system[0]->default_currency_id);?>
<?php
$eid = $this->uri->segment(4);
$eresult = $this->Employees_model->read_employee_information($eid);
?>
<?php
$ar_sc = explode('- ',$system[0]->default_currency_symbol);
$sc_show = $ar_sc[1];
$leave_user = $this->Xin_model->read_user_info($eid);
$company = $this->Company_model->read_company_information($company_id);
        if(!is_null($company)){
          $company_nama = $company[0]->name;
        } else {
          $company_nama = '--'; 
        }

$location = $this->Location_model->read_location_information($location_id);
        if(!is_null($location)){
          $location_nama = $location[0]->location_name;
        } else {
          $location_nama = '--'; 
        }

$department = $this->Department_model->read_department_information($department_id);
        if(!is_null($department)){
          $department_name = $department[0]->department_name;
        } else {
          $department_name = '--'; 
        }

$posisi = $this->Designation_model->read_designation_information($designation_id);
        if(!is_null($posisi)){
          $posisi_name = $posisi[0]->designation_name;
        } else {
          $posisi_name = '--'; 
        }

      if($is_active==0){
          $status = 'Tidak Aktif';
      } else {
          $status = 'Aktif';
      }

?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $leave_categories_ids = explode(',',$leave_categories);?>
<?php $view_companies_ids = explode(',',$view_companies_id);?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $list_bank = $this->Xin_model->get_bank(); ?>

<div class="mb-3 sw-container tab-content">
  <div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
    <hr class="border-light m-0">
    <div class="mb-3 sw-container tab-content">
      <div id="smartwizard-2-step-1" class="card animated fadeIn tab-pane step-content mt-3" style="display: block;">
        <div class="cards-body">
          <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
              <div class="col-md-3 pt-0">
                <div class="list-group list-group-flush account-settings-links"> 

                  <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-basic_info"> 
                    <i class="lnr lnr-user text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_e_details_basic');?>
                  </a>

<!--                   <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-document_id"> 
                    <i class="lnr lnr-user text-lightest"></i> &nbsp; <?php //echo $this->lang->line('xin_document_id');?>
                  </a> -->

<!--side menu profile picture-->
<!--
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-profile_picture"> 
                    <i class="lnr lnr-picture text-lightest"></i> &nbsp; <?php /*echo $this->lang->line('xin_e_details_profile_picture');*/?>
                  </a> 
-->

<!--side menu immigration-->
<!--
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-immigration"> 
                    <i class="lnr lnr-rocket text-lightest"></i> &nbsp; <?php /*echo $this->lang->line('xin_employee_immigration').'ZZ';*/?>
                  </a>
-->

<!--side menu sosmed-->                  
<!--
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-social"> 
                    <i class="lnr lnr-earth text-lightest"></i> &nbsp; <?php /*echo $this->lang->line('xin_e_details_social');*/?>
                  </a> 
-->

<!--                   <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-experience"> 
                    <i class="lnr lnr-hourglass text-lightest"></i> &nbsp; <?php //echo $this->lang->line('xin_e_details_w_experience');?>
                  </a>  -->


<!--                   <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-document"> 
                    <i class="lnr lnr-file-add text-lightest"></i> &nbsp; 
                    <?php //echo $this->lang->line('xin_e_details_document');?>
                  </a> --> 

                   <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-contacts"> 
                    <i class="lnr lnr-phone-handset text-lightest"></i> &nbsp; 
                    <?php echo $this->lang->line('xin_document_id');?>
                  </a>



                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-baccount"> 
                    <i class="lnr lnr-apartment text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_rekening');?>
                  </a> 

<!--side menu security level-->
<!--
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-security_level"> 
                    <i class="lnr lnr-link text-lightest"></i> &nbsp; <?php /*echo $this->lang->line('xin_esecurity_level_title');*/?>
                  </a> 
-->
<!-- 
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-contract"> 
                    <i class="lnr lnr-pencil text-lightest"></i> &nbsp; <?php //echo $this->lang->line('xin_e_details_contract');?>
                  </a>  -->

                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-cpassword"> 
                    <i class="lnr lnr-lock text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_reset_password');?>
                  </a> 

                </div>
              </div>

              <div class="col-md-9">
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="account-basic_info">
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>  <?php echo $this->lang->line('dashboard_personal_details');?></strong></span> </div>

                    <div class="card-body">
                      <?php 
                        $attributes = array(
                          'name' => 'basic_info', 
                          'id' => 'basic_info', 
                          'autocomplete' => 'off'
                        );
                      ?>

                      <?php 
                        $hidden = array(
                          'user_id' => $user_id, 
                          'u_basic_info' => 'UPDATE'
                        );
                      ?>

                      <?php echo form_open_multipart('admin/employees/update_employee_resign', $attributes, $hidden);?>
                      <div class="bg-white">
                        
                        <div class="row">

                              <!-- HIDDEN -->
                              <input name="employee_id" type="hidden" value="<?php echo $employee_id;?>">
                              <input name="tanggal_bergabung" type="hidden" value="<?php echo $date_of_joining;?>">

                              <input name="company_id" type="hidden" value="<?php echo $company_id;?>">
                              <input name="location_id" type="hidden" value="<?php echo $location_id;?>">
                              <input name="department_id" type="hidden" value="<?php echo $department_id;?>">
                              <input name="designation_id" type="hidden" value="<?php echo $designation_id;?>">
                              <input name="role" type="hidden" value="<?php echo $user_role_id;?>">

                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username"><?php echo $this->lang->line('dashboard_empid');?><i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div> 
                          <!--NIP2-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $employee_id;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--PERUSAHAAN-->                          
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Perusahaan/PT<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $company_nama;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>

                        </div>

                        <div class="row">
                          <!--FULLNAME-->
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Nama Lengkap<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $first_name;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--LOKASI-->
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Lokasi<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $location_nama;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Tanggal Lahir<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--TGL LAHIR-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $date_of_birth;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                          <!--DEPARTMENT-->
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Departmen<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $department_name;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Email<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--EMAIL-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $email;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--POSISI-->                          
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Posisi/Jabatan<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $posisi_name;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Nomor HP<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--NO HP-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $contact_no;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                          <!--TANGGAL BERGABUNG-->
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Tanggal Bergabung<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $date_of_joining;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Ibu Kandung<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--IBU KANDUNG-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $ibu_kandung;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--STATUS-->                          
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Status<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $status_resign;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Alamat Domisili<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--ALAMAT-->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $address;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--STATUS-->                          
                          <div class="col-md-1">
                            <div class="form-group">
                              <label for="date_of_birth"><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-1">
                            <div class="form-group">
                              <label for="date_of_birth"><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>
                        
                        <div class="row">
                          <!--rule-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="emp_status"><?php echo $this->lang->line('xin_manage_employees_status');?></label>
                              <select class="form-control" name="emp_status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_manage_employees_status');?>">
                                <option value=""></option>
                                <option value="AKTIF" <?php if($status_resign == 'AKTIF'):?> selected="selected"<?php endif;?>>AKTIF</option>
                                <option value="RESIGN" <?php if($status_resign == 'RESIGN'):?> selected="selected"<?php endif;?>>RESIGN</option>
                                <option value="BLACKLIST" <?php if($status_resign == 'BLACKLIST'):?> selected="selected"<?php endif;?>>BLACKLIST</option>
                              </select>
                            </div>
                          </div>
              
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_end"><?php echo $this->lang->line('xin_end_date');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('xin_end_date');?>" name="date_of_end" type="text" value="<?php echo $date_of_leaving;?>">
                            </div>
                          </div>

                          <div class="col-md-5">
                            <div class="form-group">
                              <label for="to_year" class="control-label"><?php echo $this->lang->line('xin_description');?></label>
                              <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" data-show-counter="1" data-limit="300" name="desc_resign" cols="30" rows="2" id="desc_resign"><?php echo $description_resign;?></textarea>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- button save basic info employee-->
                      <div class="form-actions box-footer"> 
                        <?php echo form_button( 
                          array(
                            'name' => 'hrpremium_form', 
                            'type' => 'submit', 
                            'class' => $this->Xin_model->form_button_class(), 
                            'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save')
                          )); 
                        ?> 
                      </div>
                      <?php echo form_close(); ?> 
                    </div>
                  </div>

                  <div class="tab-pane fade show" id="account-document_id">

                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>  <?php echo $this->lang->line('xin_document_id');?></strong></span> </div>

                    <div class="card-body">
                      <?php 
                        $attributes = array(
                          'name' => 'document_id', 
                          'id' => 'document_id', 
                          'autocomplete' => 'off'
                        );
                      ?>

                      <?php 
                        $hidden = array(
                          'user_id' => $user_id, 
                          'u_basic_info' => 'UPDATE'
                        );
                      ?>

                      <?php echo form_open_multipart('admin/employees/update_employee_docid', $attributes, $hidden);?>
                      <div class="bg-white">
                        
                        <div class="row">

                              <!-- HIDDEN -->
                              <input name="employee_id" type="hidden" value="<?php echo $employee_id;?>">
                              <input name="tanggal_bergabung" type="hidden" value="<?php echo $date_of_joining;?>">

                              <input name="company_id" type="hidden" value="<?php echo $company_id;?>">
                              <input name="location_id" type="hidden" value="<?php echo $location_id;?>">
                              <input name="department_id" type="hidden" value="<?php echo $department_id;?>">
                              <input name="designation_id" type="hidden" value="<?php echo $designation_id;?>">
                              <input name="role" type="hidden" value="<?php echo $user_role_id;?>">

                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username"><?php echo $this->lang->line('dashboard_empid');?><i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div> 
                          <!--NIP2-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $employee_id;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--PERUSAHAAN-->                          
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Perusahaan/PT<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $company_nama;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>

                        </div>

                        <div class="row">
                          <!--FULLNAME-->
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Nama Lengkap<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $first_name;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--LOKASI-->
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Lokasi<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $location_nama;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Tanggal Lahir<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--TGL LAHIR-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $date_of_birth;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                          <!--DEPARTMENT-->
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Departmen<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $department_name;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Email<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--EMAIL-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $email;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--POSISI-->                          
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Posisi/Jabatan<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $posisi_name;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Nomor HP<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--NO HP-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $contact_no;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                          <!--TANGGAL BERGABUNG-->
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Tanggal Bergabung<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $date_of_joining;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Ibu Kandung<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--IBU KANDUNG-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $ibu_kandung;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--STATUS-->                          
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Status<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $status_resign;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Alamat Domisili<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--ALAMAT-->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $address;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--STATUS-->                          
                          <div class="col-md-1">
                            <div class="form-group">
                              <label for="date_of_birth"><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-1">
                            <div class="form-group">
                              <label for="date_of_birth"><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>
                        



                        <div class="row">
                          <!--rule-->

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title"><?php echo $this->lang->line('xin_nomor_ktp');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_nomor_ktp');?>" name="no_ktp" type="number" value="<?php echo $ktp_no;?>" id="title">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="ktp_confirm"><?php echo $this->lang->line('xin_document_status');?></label>
                              <select class="form-control" name="ktp_confirm" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_document_status');?>">
                                <option value=""></option>
                                <option value="VERIFY" <?php if($ktp_status == 'VERIFY'):?> selected="selected"<?php endif;?>>VERIFY</option>
                                <option value="CONFIRM" <?php if($ktp_status == 'CONFIRM'):?> selected="selected"<?php endif;?>>CONFIRM</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!--rule-->

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title"><?php echo $this->lang->line('xin_kk');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_kk');?>" name="no_kk" type="number" value="<?php echo $kk_no;?>" id="title">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="kk_confirm"><?php echo $this->lang->line('xin_document_status');?></label>
                              <select class="form-control" name="kk_confirm" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_document_status');?>">
                                <option value=""></option>
                                <option value="VERIFY" <?php if($kk_status == 'VERIFY'):?> selected="selected"<?php endif;?>>VERIFY</option>
                                <option value="CONFIRM" <?php if($kk_status == 'CONFIRM'):?> selected="selected"<?php endif;?>>CONFIRM</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!--rule-->

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title"><?php echo $this->lang->line('xin_npwp');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_npwp');?>" name="no_npwp" type="number" value="<?php echo $npwp_no;?>" id="title">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="npwp_confirm"><?php echo $this->lang->line('xin_document_status');?></label>
                              <select class="form-control" name="npwp_confirm" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_document_status');?>">
                                <option value=""></option>
                                <option value="VERIFY" <?php if($npwp_status == 'VERIFY'):?> selected="selected"<?php endif;?>>VERIFY</option>
                                <option value="CONFIRM" <?php if($npwp_status == 'CONFIRM'):?> selected="selected"<?php endif;?>>CONFIRM</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!--rule-->

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title"><?php echo $this->lang->line('xin_bpjstk');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_bpjstk');?>" name="no_bpjstk" type="number" value="<?php echo $bpjs_tk_no;?>" id="title">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="bpjstk_confirm"><?php echo $this->lang->line('xin_document_status');?></label>
                              <select class="form-control" name="bpjstk_confirm" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_document_status');?>">
                                <option value=""></option>
                                <option value="AKTIF" <?php if($bpjs_tk_status == 'AKTIF'):?> selected="selected"<?php endif;?>>AKTIF</option>
                                <option value="TIDAK AKTIF" <?php if($bpjs_tk_status == 'TIDAK AKTIF'):?> selected="selected"<?php endif;?>>TIDAK AKTIF</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!--rule-->

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title"><?php echo $this->lang->line('xin_bpjsks');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_bpjsks');?>" name="no_bpjsks" type="number" value="<?php echo $bpjs_ks_no;?>" id="title">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="bpjsks_confirm"><?php echo $this->lang->line('xin_document_status');?></label>
                              <select class="form-control" name="bpjsks_confirm" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_document_status');?>">
                                <option value=""></option>
                                <option value="AKTIF" <?php if($bpjs_ks_status == 'AKTIF'):?> selected="selected"<?php endif;?>>AKTIF</option>
                                <option value="TIDAK AKTIF" <?php if($bpjs_ks_status == 'TIDAK AKTIF'):?> selected="selected"<?php endif;?>>TIDAK AKTIF</option>
                              </select>
                            </div>
                          </div>
                        </div>

                      </div>

     
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> 
                          </div>
                        </div>
                      </div>
                    </div>

                      <?php echo form_close(); ?> 
                    </div>
                  </div>

                  <div class="tab-pane fade" id="account-profile_picture">
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'profile_picture', 'id' => 'f_profile_picture', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_profile_picture' => 'UPDATE');?>
                      <?php echo form_open_multipart('admin/employees/profile_picture', $attributes, $hidden);?>
                      <?php
        						  $data_usr = array(
        								'type'  => 'hidden',
        								'name'  => 'user_id',
        								'id'    => 'user_id',
        								'value' => $user_id,
        						  );
          						echo form_input($data_usr);
          					  ?>
                      <?php
        						  $data_usr = array(
        								'type'  => 'hidden',
        								'name'  => 'session_id',
        								'id'    => 'session_id',
        								'value' => $session['user_id'],
        						  );
          						echo form_input($data_usr);
          					  ?>
                      <div class="bg-white">
                        <div class="row">
                          <div class="col-md-12">
                            <div class='form-group'>
                              <fieldset class="form-group">
                                <label for="logo"><?php echo $this->lang->line('xin_browse');?><i class="hrpremium-asterisk">*</i></label>
                                <input type="file" class="form-control-file" id="p_file" name="p_file">
                                <small><?php echo $this->lang->line('xin_e_details_picture_type');?></small>
                              </fieldset>
                              <?php if($profile_picture!='' && $profile_picture!='no file') {?>
                              <img src="<?php echo base_url().'uploads/profile/'.$profile_picture;?>" width="50px" style="margin-left:20px;" id="u_file">
                              <?php } else {?>
                              <?php if($gender=='L') { ?>
                              <?php $de_file = base_url().'uploads/profile/default_male.jpg';?>
                              <?php } else { ?>
                              <?php $de_file = base_url().'uploads/profile/default_female.jpg';?>
                              <?php } ?>
                              <img src="<?php echo $de_file;?>" width="50px" style="margin-left:20px;" id="u_file">
                              <?php } ?>
                              <?php if($profile_picture!='' && $profile_picture!='no file') {?>
                              <br />
                              <label>
                                <input type="checkbox" class="minimal" value="1" id="remove_profile_picture" name="remove_profile_picture">
                                <?php echo $this->lang->line('xin_e_details_remove_pic');?></span> </label>
                              <?php } else {?>
                              <div id="remove_file" style="display:none;">
                                <label>
                                  <input type="checkbox" class="minimal" value="1" id="remove_profile_picture" name="remove_profile_picture">
                                  <?php echo $this->lang->line('xin_e_details_remove_pic');?></span> </label>
                              </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>

                        <div class="form-action box-footer"> 
                          <?php echo form_button(
                            array(
                              'name' => 'hrpremium_form', 
                              'type' => 'submit', 
                              'class' => $this->Xin_model->form_button_class(), 
                              'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save')
                              )
                            ); 
                          ?> 
                        </div>

                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>

                  <div class="tab-pane fade" id="account-immigration">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('xin_assigned_immigration');?></strong> <?php echo $this->lang->line('xin_records');?></span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_imgdocument" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('xin_e_details_document');?></th>
                                <th><?php echo $this->lang->line('xin_issue_date');?></th>
                                <th><?php echo $this->lang->line('xin_expiry_date');?></th>
                                <th><?php echo $this->lang->line('xin_issued_by');?></th>
                                <th><?php echo $this->lang->line('xin_eligible_review_date');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_employee_immigration').'XX';?></span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'immigration_info', 'id' => 'immigration_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('user_id' => $user_id, 'u_document_info' => 'UPDATE');?>
                      <?php echo form_open_multipart('admin/employees/immigration_info', $attributes, $hidden);?>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="relation"><?php echo $this->lang->line('xin_e_details_document');?><i class="hrpremium-asterisk">*</i></label>
                            <select name="document_type_id" id="document_type_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_e_details_choose_dtype');?>">
                              <option value=""></option>
                              <?php foreach($all_document_types as $document_type) {?>
                              <option value="<?php echo $document_type->document_type_id;?>"> <?php echo $document_type->document_type;?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="document_number" class="control-label"><?php echo $this->lang->line('xin_employee_document_number');?><i class="hrpremium-asterisk">*</i></label>
                            <input type="number" class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_document_number');?>" name="document_number" >
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="issue_date" class="control-label"><?php echo $this->lang->line('xin_issue_date');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control date" readonly="readonly" placeholder="Issue Date" name="issue_date" type="text">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="expiry_date" class="control-label"><?php echo $this->lang->line('xin_e_details_doe');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_e_details_doe');?>" name="expiry_date" type="text">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <fieldset class="form-group">
                              <label for="logo"><?php echo $this->lang->line('xin_e_details_document_file');?><i class="hrpremium-asterisk">*</i></label>
                              <input type="file" class="form-control-file" id="p_file2" name="document_file">
                              <small><?php echo $this->lang->line('xin_e_details_d_type_file');?></small>
                            </fieldset>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="eligible_review_date" class="control-label"><?php echo $this->lang->line('xin_eligible_review_date');?></label>
                            <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_eligible_review_date');?>" name="eligible_review_date" type="text">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="send_mail"><?php echo $this->lang->line('xin_country');?></label>
                            <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
                              <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                              <?php foreach($all_countries as $scountry) {?>
                              <option value="<?php echo $scountry->country_id;?>"> <?php echo $scountry->country_name;?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">

                            <div class="form-actions box-footer"> 
                              <?php echo form_button(
                                array(
                                  'name' => 'hrpremium_form', 
                                  'type' => 'submit', 
                                  'class' => $this->Xin_model->form_button_class(), 
                                  'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save')
                                  )
                                ); 
                              ?> 
                            </div>

                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>


                  <div class="tab-pane fade show" id="account-document_id">

                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>  <?php echo $this->lang->line('xin_document_id');?></strong></span> </div>

                    <div class="card-body">
                      <?php 
                        $attributes = array(
                          'name' => 'document_id', 
                          'id' => 'document_id', 
                          'autocomplete' => 'off'
                        );
                      ?>

                      <?php 
                        $hidden = array(
                          'user_id' => $user_id, 
                          'u_basic_info' => 'UPDATE'
                        );
                      ?>

                      <?php echo form_open_multipart('admin/employees/update_employee_docid', $attributes, $hidden);?>
                      <div class="bg-white">
                        
                        <div class="row">

                              <!-- HIDDEN -->
                              <input name="employee_id" type="hidden" value="<?php echo $employee_id;?>">
                              <input name="tanggal_bergabung" type="hidden" value="<?php echo $date_of_joining;?>">

                              <input name="company_id" type="hidden" value="<?php echo $company_id;?>">
                              <input name="location_id" type="hidden" value="<?php echo $location_id;?>">
                              <input name="department_id" type="hidden" value="<?php echo $department_id;?>">
                              <input name="designation_id" type="hidden" value="<?php echo $designation_id;?>">
                              <input name="role" type="hidden" value="<?php echo $user_role_id;?>">

                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username"><?php echo $this->lang->line('dashboard_empid');?><i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div> 
                          <!--NIP2-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $employee_id;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--PERUSAHAAN-->                          
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Perusahaan/PT<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $company_nama;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>

                        </div>
<!--  -->
                        <div class="row">
                          <!--FULLNAME-->
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Nama Lengkap<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $first_name;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--LOKASI-->
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Lokasi<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $location_nama;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Tanggal Lahir<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--TGL LAHIR-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $date_of_birth;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                          <!--DEPARTMENT-->
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Departmen<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $department_name;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Email<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--EMAIL-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $email;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--POSISI-->                          
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Posisi/Jabatan<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $posisi_name;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Nomor HP<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--NO HP-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $contact_no;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                          <!--TANGGAL BERGABUNG-->
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Tanggal Bergabung<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $date_of_joining;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Ibu Kandung<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--IBU KANDUNG-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $ibu_kandung;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--STATUS-->                          
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Status<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $status_resign;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Alamat Domisili<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--ALAMAT-->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $address;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--STATUS-->                          
                          <div class="col-md-1">
                            <div class="form-group">
                              <label for="date_of_birth"><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-1">
                            <div class="form-group">
                              <label for="date_of_birth"><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>
                        



                        <div class="row">
                          <!--rule-->

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title"><?php echo $this->lang->line('xin_nomor_ktp');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_nomor_ktp');?>" name="no_ktp" type="number" value="<?php echo $ktp_no;?>" id="title">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="ktp_confirm"><?php echo $this->lang->line('xin_document_status');?></label>
                              <select class="form-control" name="ktp_confirm" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_document_status');?>">
                                <option value=""></option>
                                <option value="VERIFY" <?php if($ktp_status == 'VERIFY'):?> selected="selected"<?php endif;?>>VERIFY</option>
                                <option value="CONFIRM" <?php if($ktp_status == 'CONFIRM'):?> selected="selected"<?php endif;?>>CONFIRM</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!--rule-->

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title"><?php echo $this->lang->line('xin_kk');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_kk');?>" name="no_kk" type="number" value="<?php echo $kk_no;?>" id="title">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="kk_confirm"><?php echo $this->lang->line('xin_document_status');?></label>
                              <select class="form-control" name="kk_confirm" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_document_status');?>">
                                <option value=""></option>
                                <option value="VERIFY" <?php if($kk_status == 'VERIFY'):?> selected="selected"<?php endif;?>>VERIFY</option>
                                <option value="CONFIRM" <?php if($kk_status == 'CONFIRM'):?> selected="selected"<?php endif;?>>CONFIRM</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!--rule-->

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title"><?php echo $this->lang->line('xin_npwp');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_npwp');?>" name="no_npwp" type="number" value="<?php echo $npwp_no;?>" id="title">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="npwp_confirm"><?php echo $this->lang->line('xin_document_status');?></label>
                              <select class="form-control" name="npwp_confirm" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_document_status');?>">
                                <option value=""></option>
                                <option value="VERIFY" <?php if($npwp_status == 'VERIFY'):?> selected="selected"<?php endif;?>>VERIFY</option>
                                <option value="CONFIRM" <?php if($npwp_status == 'CONFIRM'):?> selected="selected"<?php endif;?>>CONFIRM</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!--rule-->

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title"><?php echo $this->lang->line('xin_bpjstk');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_bpjstk');?>" name="no_bpjstk" type="number" value="<?php echo $bpjs_tk_no;?>" id="title">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="bpjstk_confirm"><?php echo $this->lang->line('xin_document_status');?></label>
                              <select class="form-control" name="bpjstk_confirm" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_document_status');?>">
                                <option value=""></option>
                                <option value="AKTIF" <?php if($bpjs_tk_status == 'AKTIF'):?> selected="selected"<?php endif;?>>AKTIF</option>
                                <option value="TIDAK AKTIF" <?php if($bpjs_tk_status == 'TIDAK AKTIF'):?> selected="selected"<?php endif;?>>TIDAK AKTIF</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!--rule-->

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title"><?php echo $this->lang->line('xin_bpjsks');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_bpjsks');?>" name="no_bpjsks" type="number" value="<?php echo $bpjs_ks_no;?>" id="title">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="bpjsks_confirm"><?php echo $this->lang->line('xin_document_status');?></label>
                              <select class="form-control" name="bpjsks_confirm" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_document_status');?>">
                                <option value=""></option>
                                <option value="AKTIF" <?php if($bpjs_ks_status == 'AKTIF'):?> selected="selected"<?php endif;?>>AKTIF</option>
                                <option value="TIDAK AKTIF" <?php if($bpjs_ks_status == 'TIDAK AKTIF'):?> selected="selected"<?php endif;?>>TIDAK AKTIF</option>
                              </select>
                            </div>
                          </div>
                        </div>

                      </div>

     
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => 'btn btn-primary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> 
                          </div>
                        </div>
                      </div>
                    </div>

                      <?php echo form_close(); ?> 
                    </div>
                  </div>

                  <div class="tab-pane fade" id="account-contacts">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_document_id');?> </strong></span> </div>
                      <div class="card-body" hidden>
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_contact" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('xin_employees_full_name');?></th>
                                <th><?php echo $this->lang->line('xin_e_details_relation');?></th>
                                <th><?php echo $this->lang->line('dashboard_email');?></th>
                                <th><?php echo $this->lang->line('xin_e_details_mobile');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
   
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'contact_info', 'id' => 'contact_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'ADD');?>
                      <?php echo form_open('admin/employees/contact_info', $attributes, $hidden);?>
                      <?php
      						  $data_usr1 = array(
      								'type'  => 'hidden',
      								'name'  => 'user_id',
      								'id'    => 'user_id',
      								'value' => $user_id,
      						  );
        						echo form_input($data_usr1);
        					  ?>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username"><?php echo $this->lang->line('dashboard_empid');?><i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div> 
                          <!--NIP2-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $employee_id;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--PERUSAHAAN-->                          
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Perusahaan/PT<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $company_nama;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>

                        </div>

                        <div class="row">
                          <!--FULLNAME-->
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Nama Lengkap<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $first_name;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--LOKASI-->
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Lokasi<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $location_nama;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Tanggal Lahir<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--TGL LAHIR-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $date_of_birth;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                          <!--DEPARTMENT-->
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Departmen<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $department_name;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Email<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--EMAIL-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $email;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--POSISI-->                          
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Posisi/Jabatan<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $posisi_name;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Nomor HP<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--NO HP-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $contact_no;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                          <!--TANGGAL BERGABUNG-->
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Tanggal Bergabung<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $date_of_joining;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Ibu Kandung<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--IBU KANDUNG-->
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $ibu_kandung;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--STATUS-->                          
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="date_of_birth">Status<i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date_of_birth">: <?php echo $status_resign;?><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="username">Alamat Domisili<i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <!--ALAMAT-->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="first_name">: <?php echo $address;?><i class="hrpremium-asterisk"></i></label>
        
                            </div>
                          </div>
                          <!--STATUS-->                          
                          <div class="col-md-1">
                            <div class="form-group">
                              <label for="date_of_birth"><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
           
                          <div class="col-md-1">
                            <div class="form-group">
                              <label for="date_of_birth"><i class="hrpremium-asterisk"></i></label>

                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!--rule-->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title"><?php echo $this->lang->line('xin_nomor_ktp');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_nomor_ktp');?>" name="no_ktp" type="number" value="<?php echo $ktp_no;?>" id="title">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="ktp_confirm"><?php echo $this->lang->line('xin_document_status');?></label>
                              <select class="form-control" name="ktp_confirm" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_document_status');?>">
                                <option value=""></option>
                                <option value="VERIFY" <?php if($ktp_status == 'VERIFY'):?> selected="selected"<?php endif;?>>VERIFY</option>
                                <option value="CONFIRM" <?php if($ktp_status == 'CONFIRM'):?> selected="selected"<?php endif;?>>CONFIRM</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!--rule-->

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title"><?php echo $this->lang->line('xin_kk');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_kk');?>" name="no_kk" type="number" value="<?php echo $kk_no;?>" id="title">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="kk_confirm"><?php echo $this->lang->line('xin_document_status');?></label>
                              <select class="form-control" name="kk_confirm" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_document_status');?>">
                                <option value=""></option>
                                <option value="VERIFY" <?php if($kk_status == 'VERIFY'):?> selected="selected"<?php endif;?>>VERIFY</option>
                                <option value="CONFIRM" <?php if($kk_status == 'CONFIRM'):?> selected="selected"<?php endif;?>>CONFIRM</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!--rule-->

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title"><?php echo $this->lang->line('xin_npwp');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_npwp');?>" name="no_npwp" type="number" value="<?php echo $npwp_no;?>" id="title">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="npwp_confirm"><?php echo $this->lang->line('xin_document_status');?></label>
                              <select class="form-control" name="npwp_confirm" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_document_status');?>">
                                <option value=""></option>
                                <option value="VERIFY" <?php if($npwp_status == 'VERIFY'):?> selected="selected"<?php endif;?>>VERIFY</option>
                                <option value="CONFIRM" <?php if($npwp_status == 'CONFIRM'):?> selected="selected"<?php endif;?>>CONFIRM</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!--rule-->

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title"><?php echo $this->lang->line('xin_bpjstk');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_bpjstk');?>" name="no_bpjstk" type="number" value="<?php echo $bpjs_tk_no;?>" id="title">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="bpjstk_confirm"><?php echo $this->lang->line('xin_document_status');?></label>
                              <select class="form-control" name="bpjstk_confirm" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_document_status');?>">
                                <option value=""></option>
                                <option value="AKTIF" <?php if($bpjs_tk_status == 'AKTIF'):?> selected="selected"<?php endif;?>>AKTIF</option>
                                <option value="TIDAK AKTIF" <?php if($bpjs_tk_status == 'TIDAK AKTIF'):?> selected="selected"<?php endif;?>>TIDAK AKTIF</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <!--rule-->

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title"><?php echo $this->lang->line('xin_bpjsks');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_bpjsks');?>" name="no_bpjsks" type="number" value="<?php echo $bpjs_ks_no;?>" id="title">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="bpjsks_confirm"><?php echo $this->lang->line('xin_document_status');?></label>
                              <select class="form-control" name="bpjsks_confirm" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_document_status');?>">
                                <option value=""></option>
                                <option value="AKTIF" <?php if($bpjs_ks_status == 'AKTIF'):?> selected="selected"<?php endif;?>>AKTIF</option>
                                <option value="TIDAK AKTIF" <?php if($bpjs_ks_status == 'TIDAK AKTIF'):?> selected="selected"<?php endif;?>>TIDAK AKTIF</option>
                              </select>
                            </div>
                          </div>
                        </div>

                      <div class="form-actions box-footer"> 
                        <?php echo form_button(
                          array(
                            'name' => 'hrpremium_form', 
                            'type' => 'submit', 
                            'class' => $this->Xin_model->form_button_class(), 
                            'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save')
                            )
                          ); 
                        ?> 
                      </div>

                      <?php echo form_close(); ?> </div>
                  </div>

                  <div class="tab-pane fade" id="account-social">
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'social_networking', 'id' => 'f_social_networking', 'autocomplete' => 'off');?>
                      <?php $hidden = array('user_id' => $user_id, 'u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/employees/social_info', $attributes, $hidden);?>
                      <div class="bg-white">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="facebook_profile"><?php echo $this->lang->line('xin_e_details_fb_profile');?></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_fb_profile');?>" name="facebook_link" type="text" value="<?php echo $facebook_link;?>">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="facebook_profile"><?php echo $this->lang->line('xin_e_details_twit_profile');?></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_twit_profile');?>" name="twitter_link" type="text" value="<?php echo $twitter_link;?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="twitter_profile"><?php echo $this->lang->line('xin_e_details_blogr_profile');?></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_blogr_profile');?>" name="blogger_link" type="text" value="<?php echo $blogger_link;?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="blogger_profile"><?php echo $this->lang->line('xin_e_details_linkd_profile');?></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_linkd_profile');?>" name="linkdedin_link" type="text" value="<?php echo $linkdedin_link;?>">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="blogger_profile"><?php echo $this->lang->line('xin_e_details_gplus_profile');?></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_gplus_profile');?>" name="google_plus_link" type="text" value="<?php echo $google_plus_link;?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="linkdedin_profile"><?php echo $this->lang->line('xin_e_details_insta_profile');?></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_insta_profile');?>" name="instagram_link" type="text" value="<?php echo $instagram_link;?>">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="linkdedin_profile"><?php echo $this->lang->line('xin_e_details_pintrst_profile');?></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_pintrst_profile');?>" name="pinterest_link" type="text" value="<?php echo $pinterest_link;?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="linkdedin_profile"><?php echo $this->lang->line('xin_e_details_utube_profile');?></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_utube_profile');?>" name="youtube_link" type="text" value="<?php echo $youtube_link;?>">
                            </div>
                          </div>
                        </div>
                        <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>

<!-- DOKUMEN -->
                  <div class="tab-pane fade" id="account-document">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_e_details_documents');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_document" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('xin_e_details_dtype');?></th>
                                <th><?php echo $this->lang->line('xin_employee_document_number');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_e_details_document');?> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'document_info', 'id' => 'document_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_document_info' => 'UPDATE');?>
                      <?php echo form_open_multipart('admin/employees/document_info', $attributes, $hidden);?>
                      <?php
      						  $data_usr2 = array(
      								'type'  => 'hidden',
      								'name'  => 'user_id',
      								'value' => $user_id,
          						 );
          						echo form_input($data_usr2);
          					  ?>



                      <div class="row">

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="relation"><?php echo $this->lang->line('xin_e_details_dtype');?><i class="hrpremium-asterisk">*</i></label>
                            <select name="document_type_id" id="document_type_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_e_details_choose_dtype');?>">
                              <option value=""></option>
                              <?php foreach($all_document_types as $document_type) {?>
                              <option value="<?php echo $document_type->document_type_id;?>"> <?php echo $document_type->document_type;?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="title" class="control-label"><?php echo $this->lang->line('xin_employee_document_number');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_document_number');?>" name="title" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="16">
                          </div>
                        </div>


                        <div class="col-md-6">
                          <div class="form-group">
                            <fieldset class="form-group">
                              <label for="logo"><?php echo $this->lang->line('xin_e_details_document_file');?></label>
                              <input type="file" class="form-control-file" id="document_file" name="document_file">
                              <small><?php echo $this->lang->line('xin_e_details_d_type_file');?></small>
                            </fieldset>
                          </div>
                        </div>
                        <!--<div class="col-md-6">
                          <div class="form-group">
                            <label for="date_of_expiry" class="control-label"><?php /*echo $this->lang->line('xin_e_details_doe');*/?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control date" readonly placeholder="<?php /*echo $this->lang->line('xin_e_details_doe');*/?>" name="date_of_expiry" type="text">
                          </div>
                        </div> -->

                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
<!-- BANK AKUN -->
                  <div class="tab-pane fade" id="account-baccount">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_e_details_baccount');?> </span> 
                      </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_bank_account" style="width:100%;">
                            <thead>
                              <tr>
                                <th width="30"><?php echo $this->lang->line('xin_action');?></th>
                                <th width="30">Kode</th>
                                <th><?php echo $this->lang->line('xin_e_details_bank_name');?></th>
                                <th><?php echo $this->lang->line('xin_e_details_acc_number');?></th>
                                <th><?php echo $this->lang->line('xin_e_details_acc_title');?></th>
                                <th>Status</th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>


                    <?php if($user_info[0]->user_role_id==1 || $user_info[0]->user_role_id==3) {
                    ?>

                    <div class="card-header with-elements"> 
                      <span class="card-header-title mr-2"> 
                        <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_e_details_baccount');?> 
                      </span> 
                    </div>

                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'bank_account_info', 'id' => 'bank_account_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/employees/bank_account_info', $attributes, $hidden);?>
                      <?php
                        $data_usr4 = array(
                          'type'  => 'hidden',
                          'name'  => 'user_id',
                          'value' => $user_id,
                        );
                        echo form_input($data_usr4);
                       ?>
                        
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="bank_name"><?php echo $this->lang->line('xin_e_details_bank_name');?><i class="hrpremium-asterisk">*</i></label>
                              <select name="bank_name" id="bank_name" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_bank_choose_name');?>">
                                <option value=""></option>
                                <?php 
                                foreach ( $list_bank as $bank ) { 
                                ?>
                                  <option value="<?php echo $bank->bank_name;?>"> <?php echo $bank->bank_name;?></option>
                                <?php 
                                } 
                                ?>
                                  <input class="form-control" name="bank_code" type="hidden" value="<?php echo $bank->bank_code;?>">                                  
                              </select>
                            </div>
                          </div>
                            
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="account_number"><?php echo $this->lang->line('xin_e_details_acc_number');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_acc_number');?>" name="account_number" type="text" value="" id="account_number">
                            </div>
                          </div>
                        </div>
                          
                        <div class="row">

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="account_title"><?php echo $this->lang->line('xin_e_details_acc_title');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_acc_title');?>" name="account_title" type="text" value="" id="account_name">
                            </div>
                          </div>

                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="bank_confirm"><?php echo $this->lang->line('xin_document_status');?></label>
                              <select class="form-control" name="bank_confirm" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_document_status');?>">
                                <option value=""></option>
                                <option value="0">ON CHECKING</option>
                                <option value="1">CONFIRM</option>
                              </select>
                            </div>
                        </div> 


                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> 
                    </div>

                    <?php
                    }
                    ?>
                  </div>

<!-- CHENGE PASSWORD -->
                  <div class="tab-pane fade" id="account-cpassword">
                                        <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> Reset Password</strong></span> 
                      </div>
                   
                    </div>

                        <div class="card-body pb-2">
                          <?php $attributes = array('name' => 'e_change_password', 'id' => 'e_change_password', 'autocomplete' => 'off');?>
                          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                          <?php echo form_open('admin/employees/reset_password', $attributes, $hidden);?>
                          <?php
            						  $data_usr5 = array(
            								'type'  => 'hidden',
            								'name'  => 'user_id',
            								'value' => $user_id,
              						 ); 
              						echo form_input($data_usr5);
                          $private_code = rand(100000,999999);
              					  ?>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="reset_password">Reset Password</label>
                                <input class="form-control" placeholder="Reset Password" name="new_password" type="contact_number" value="<?php echo $private_code;?>">
                              </div>
                            </div>

                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <div class="form-actions"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> RESET PASSWORD')); ?> </div>
                              </div>
                            </div>
                          </div>
                          <?php echo form_close(); ?>
                      </div>
                  </div>

                  <div class="tab-pane fade" id="account-security_level">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_esecurity_level_title');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_security_level" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('xin_esecurity_level_title');?></th>
                                <th><?php echo $this->lang->line('xin_e_details_doe');?></th>
                                <th><?php echo $this->lang->line('xin_e_details_do_clearance');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_esecurity_level_title');?> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'security_level_info', 'id' => 'security_level_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/employees/add_security_level', $attributes, $hidden);?>
                      <?php
      						  $data_usr4 = array(
      							'type'  => 'hidden',
      							'name'  => 'user_id',
      							'value' => $user_id,
        						 );
        						echo form_input($data_usr4);
        					  ?>
                      <?php $security_level_list = $this->Xin_model->get_security_level_type();?>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="account_title"><?php echo $this->lang->line('xin_esecurity_level_title');?><i class="hrpremium-asterisk">*</i></label>
                            <select class="form-control" name="security_level" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_esecurity_level_title');?>">
                              <option value=""><?php echo $this->lang->line('xin_esecurity_level_title');?></option>
                              <?php foreach($security_level_list->result() as $sc_level) {?>
                              <option value="<?php echo $sc_level->type_id?>"><?php echo $sc_level->name?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="account_number"><?php echo $this->lang->line('xin_e_details_doe');?></label>
                            <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_e_details_doe');?>" name="expiry_date" type="text" value="" id="expiry_date">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="account_number"><?php echo $this->lang->line('xin_e_details_do_clearance');?></label>
                            <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_e_details_do_clearance');?>" name="date_of_clearance" type="text" value="" id="date_of_clearance">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>

<!-- KONTRAK PKWT -->
            <div class="tab-pane fade" id="account-contract">
              <div class="box">
                <div class="card-header with-elements"> 
                  <span class="card-header-title mr-2"> 
                    <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_e_details_contracts');?> 
                  </span> 
                </div>
                    
                <div class="card-body">
                  <div class="box-datatable table-responsive">
                    <table class="table table-striped table-bordered dataTable" id="xin_table_contract" style="width:100%;">
                      <thead>
                        <tr>
                          <th><?php echo $this->lang->line('xin_action');?></th>
                          <th><?php echo $this->lang->line('xin_nomor_surat');?></th>
                          <th><?php echo $this->lang->line('xin_e_details_duration');?></th>
                          <th><?php echo $this->lang->line('dashboard_designation');?></th>
                          <th><?php echo $this->lang->line('xin_e_details_contract_type');?></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
                 

              <?php if($user_info[0]->user_role_id==1 || $user_info[0]->user_role_id==3) {?>     

              <div class="card-header with-elements"> 
                <span class="card-header-title mr-2"> 
                  <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_e_details_contract');?> 
                </span> 
              </div>
                      
              <div class="card-body pb-2">
                <?php $attributes = array('name' => 'contract_info', 'id' => 'contract_info', 'autocomplete' => 'off');?>
                <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                <?php echo form_open('admin/employees/contract_info', $attributes, $hidden);?>
                <?php
      					  $data_usr4 = array(
    							'type'  => 'hidden',
    							'name'  => 'user_id',
        					'value' => $user_id,
        				  );
  					      echo form_input($data_usr4);
                ?>
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contract_type_id" class=""><?php echo $this->lang->line('xin_e_details_contract_type');?></label>
                      <select class="form-control" name="contract_type_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_one');?>">
                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                        
                        <?php foreach($all_contract_types as $contract_type) {?>
                        <option value="<?php echo $contract_type->contract_type_id;?>"> <?php echo $contract_type->name;?></option>
                        <?php } ?>

                      </select>
                    </div>
                    <div class="form-group">
                      <label class="" for="from_date"><?php echo $this->lang->line('xin_e_details_frm_date');?></label>
                      <input type="text" class="form-control date" name="from_date" placeholder="<?php echo $this->lang->line('xin_e_details_frm_date');?>" readonly value="">
                    </div>
                    <div class="form-group">
                      <label for="designation_id" class=""><?php echo $this->lang->line('dashboard_designation');?></label>
                      <select class="form-control" name="designation_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_one');?>">
                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>

                        <?php foreach($all_designations as $designation) {?>
                          <option value="<?php echo $designation->designation_id;?>"> <?php echo $designation->designation_name;?></option>
                        <?php } ?>
                        
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="title" class=""><?php echo $this->lang->line('xin_e_details_contract_title');?></label>
                      <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_contract_title');?>" name="title" type="text" value="" id="title">
                    </div>
                    <div class="form-group">
                      <label for="to_date"><?php echo $this->lang->line('xin_e_details_to_date');?></label>
                      <input type="text" class="form-control date" name="to_date" placeholder="<?php echo $this->lang->line('xin_e_details_to_date');?>" readonly value="">
                    </div>
                    <div class="form-group">
                      <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                      <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="3" id="description"></textarea>
                      <span class="countdown"></span>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                    </div>
                  </div>
                </div>

                <?php echo form_close(); ?> 
              </div>
              <?php } ?>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
      <?php if(in_array('351',$role_resources_ids)) { ?> 
      <div id="smartwizard-2-step-2" class="animated fadeIn tab-pane step-content mt-3" style="display: none;">
        <div class="cards-body">
          <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
              <div class="col-md-3 pt-0">
                <div class="list-group list-group-flush account-settings-links"> <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-update_salary"> <i class="lnr lnr-strikethrough text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_employee_update_salary');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-allowances"> <i class="lnr lnr-car text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_employee_set_allowances');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-commissions"> <i class="lnr lnr-graduation-hat text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_hr_commissions');?></a>  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-statutory_deductions"> <i class="lnr lnr-store text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_employee_set_statutory_deductions');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-other_payment"> <i class="lnr lnr-tag text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_employee_set_other_payment');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-overtime"> <i class="lnr lnr-tag text-lightest"></i> &nbsp; <?php echo $this->lang->line('dashboard_overtime');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-loan_deductions"> <i class="lnr lnr-location text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_employee_set_loan_deductions');?></a></div>
              </div>
              <div class="col-md-9">
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="account-update_salary">
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'employee_update_salary', 'id' => 'employee_update_salary', 'autocomplete' => 'off');?>
                      <?php $hidden = array('user_id' => $user_id, 'u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/employees/update_salary_option', $attributes, $hidden);?>
                      <div class="bg-white">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="wages_type"><?php echo $this->lang->line('xin_employee_type_wages');?><i class="hrpremium-asterisk">*</i></label>
                              <select name="wages_type" id="wages_type" class="form-control" data-plugin="select_hrm">
                                <option value="1" <?php if($wages_type==1):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_payroll_basic_salary');?></option>
                                <option value="2" <?php if($wages_type==2):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_employee_daily_wages');?></option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="basic_salary"><?php echo $this->lang->line('xin_salary_title');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control basic_salary" placeholder="<?php echo $this->lang->line('xin_salary_title');?>" name="basic_salary" type="text" value="<?php echo $basic_salary;?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                  <div class="tab-pane fade" id="account-allowances">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_employee_set_allowances');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_all_allowances" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                                <th><?php echo $this->lang->line('xin_amount');?></th>
                                <th><?php echo $this->lang->line('xin_salary_allowance_options');?></th>
                                <th><?php echo $this->lang->line('xin_amount_option');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_employee_set_allowances');?></strong> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'employee_update_allowance', 'id' => 'employee_update_allowance', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/employees/employee_allowance_option', $attributes, $hidden);?>
                      <?php
                              $data_usr4 = array(
                                'type'  => 'hidden',
                                'name'  => 'user_id',
                                'value' => $user_id,
                             );
                            echo form_input($data_usr4);
                          ?>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="is_allowance_taxable"><?php echo $this->lang->line('xin_salary_allowance_options');?><i class="hrpremium-asterisk">*</i></label>
                            <select name="is_allowance_taxable" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?php echo $this->lang->line('xin_salary_allowance_non_taxable');?></option>
                              <option value="1"><?php echo $this->lang->line('xin_fully_taxable');?></option>
                              <option value="2"><?php echo $this->lang->line('xin_partially_taxable');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="amount_option"><?php echo $this->lang->line('xin_amount_option');?><i class="hrpremium-asterisk">*</i></label>
                            <select name="amount_option" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?php echo $this->lang->line('xin_title_tax_fixed');?></option>
                              <option value="1"><?php echo $this->lang->line('xin_title_tax_percent');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="account_title"><?php echo $this->lang->line('dashboard_xin_title');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_xin_title');?>" name="allowance_title" type="text" value="" id="allowance_title">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="account_number"><?php echo $this->lang->line('xin_amount');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_amount');?>" name="allowance_amount" type="text" value="" id="allowance_amount">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                  <div class="tab-pane fade" id="account-commissions">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_hr_commissions');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_all_commissions" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                                <th><?php echo $this->lang->line('xin_amount');?></th>
                                <th><?php echo $this->lang->line('xin_salary_commission_options');?></th>
                                <th><?php echo $this->lang->line('xin_amount_option');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_hr_commissions');?></strong> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'employee_update_commissions', 'id' => 'employee_update_commissions', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/employees/employee_commissions_option', $attributes, $hidden);?>
                      <?php
							  $data_usr4 = array(
								'type'  => 'hidden',
								'name'  => 'user_id',
								'value' => $user_id,
							 );
							echo form_input($data_usr4);
						  ?>
                      <div class="row">
                      <div class="col-md-3">
                          <div class="form-group">
                            <label for="is_commission_taxable"><?php echo $this->lang->line('xin_salary_commission_options');?><i class="hrpremium-asterisk">*</i></label>
                            <select name="is_commission_taxable" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?php echo $this->lang->line('xin_salary_allowance_non_taxable');?></option>
                              <option value="1"><?php echo $this->lang->line('xin_fully_taxable');?></option>
                              <option value="2"><?php echo $this->lang->line('xin_partially_taxable');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="amount_option"><?php echo $this->lang->line('xin_amount_option');?><i class="hrpremium-asterisk">*</i></label>
                            <select name="amount_option" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?php echo $this->lang->line('xin_title_tax_fixed');?></option>
                              <option value="1"><?php echo $this->lang->line('xin_title_tax_percent');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="title"><?php echo $this->lang->line('dashboard_xin_title');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_xin_title');?>" name="title" type="text" value="" id="title">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="amount"><?php echo $this->lang->line('xin_amount');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_amount');?>" name="amount" type="text" value="" id="amount">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                  <div class="tab-pane fade" id="account-loan_deductions">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_employee_set_loan_deductions');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_all_deductions" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('xin_employee_set_loan_deductions');?></th>
                                <th><?php echo $this->lang->line('xin_employee_monthly_installment_title');?></th>
                                <th><?php echo $this->lang->line('xin_employee_loan_time');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_employee_set_loan_deductions');?></strong> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'add_loan_info', 'id' => 'add_loan_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/employees/employee_loan_info', $attributes, $hidden);?>
                      <?php
							  $data_usr4 = array(
									'type'  => 'hidden',
									'name'  => 'user_id',
									'value' => $user_id,
							 );
							echo form_input($data_usr4);
						  ?>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="loan_options"><?php echo $this->lang->line('xin_salary_loan_options');?><i class="hrpremium-asterisk">*</i></label>
                            <select name="loan_options" id="loan_options" class="form-control" data-plugin="select_hrm">
                              <option value="1"><?php echo $this->lang->line('xin_loan_ssc_title');?></option>
                              <option value="2"><?php echo $this->lang->line('xin_loan_hdmf_title');?></option>
                              <option value="0"><?php echo $this->lang->line('xin_loan_other_sd_title');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="month_year"><?php echo $this->lang->line('dashboard_xin_title');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_xin_title');?>" name="loan_deduction_title" type="text">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="edu_role"><?php echo $this->lang->line('xin_employee_monthly_installment_title');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_monthly_installment_title');?>" name="monthly_installment" type="text" id="m_monthly_installment">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="month_year"><?php echo $this->lang->line('xin_start_date');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly="readonly" name="start_date" type="text">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="end_date"><?php echo $this->lang->line('xin_end_date');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_end_date');?>" name="end_date" type="text">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="description"><?php echo $this->lang->line('xin_reason');?></label>
                            <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_reason');?>" name="reason" cols="30" rows="2" id="reason2"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                  <div class="tab-pane fade" id="account-statutory_deductions">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_employee_set_statutory_deductions');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_all_statutory_deductions" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                                <th><?php echo $this->lang->line('xin_amount');?></th>
                                <th><?php echo $this->lang->line('xin_salary_sd_options');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_employee_set_statutory_deductions');?></strong> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'statutory_deductions_info', 'id' => 'statutory_deductions_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/employees/set_statutory_deductions', $attributes, $hidden);?>
                      <?php
							  $data_usr4 = array(
								'type'  => 'hidden',
								'name'  => 'user_id',
								'value' => $user_id,
							 );
							echo form_input($data_usr4);
						  ?>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="statutory_options"><?php echo $this->lang->line('xin_salary_sd_options');?><i class="hrpremium-asterisk">*</i></label>
                            <select name="statutory_options" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?php echo $this->lang->line('xin_title_tax_fixed');?></option>
                              <option value="1"><?php echo $this->lang->line('xin_title_tax_percent');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-5">
                          <div class="form-group">
                            <label for="title"><?php echo $this->lang->line('dashboard_xin_title');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_xin_title');?>" name="title" type="text" value="" id="title">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="amount"><?php echo $this->lang->line('xin_amount');?>
                              <i class="hrpremium-asterisk">*</i> </label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_amount');?>" name="amount" type="text" value="" id="amount">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                  <div class="tab-pane fade" id="account-other_payment">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_employee_set_other_payment');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_all_other_payments" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                                <th><?php echo $this->lang->line('xin_amount');?></th>
                                <th><?php echo $this->lang->line('xin_salary_otherpayment_options');?></th>
                                <th><?php echo $this->lang->line('xin_amount_option');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_employee_set_other_payment');?></strong> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'other_payments_info', 'id' => 'other_payments_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/employees/set_other_payments', $attributes, $hidden);?>
                      <?php
							  $data_usr4 = array(
								'type'  => 'hidden',
								'name'  => 'user_id',
								'value' => $user_id,
							 );
							echo form_input($data_usr4);
						  ?>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="is_otherpayment_taxable"><?php echo $this->lang->line('xin_salary_otherpayment_options');?><i class="hrpremium-asterisk">*</i></label>
                            <select name="is_otherpayment_taxable" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?php echo $this->lang->line('xin_salary_allowance_non_taxable');?></option>
                              <option value="1"><?php echo $this->lang->line('xin_fully_taxable');?></option>
                              <option value="2"><?php echo $this->lang->line('xin_partially_taxable');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="amount_option"><?php echo $this->lang->line('xin_amount_option');?><i class="hrpremium-asterisk">*</i></label>
                            <select name="amount_option" class="form-control" data-plugin="select_hrm">
                              <option value="0"><?php echo $this->lang->line('xin_title_tax_fixed');?></option>
                              <option value="1"><?php echo $this->lang->line('xin_title_tax_percent');?></option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="title"><?php echo $this->lang->line('dashboard_xin_title');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_xin_title');?>" name="title" type="text" value="" id="title">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="amount"><?php echo $this->lang->line('xin_amount');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_amount');?>" name="amount" type="text" value="" id="amount">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                  <div class="tab-pane fade" id="account-overtime">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('dashboard_overtime');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_emp_overtime" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('xin_employee_overtime_title');?></th>
                                <th><?php echo $this->lang->line('xin_employee_overtime_no_of_days');?></th>
                                <th><?php echo $this->lang->line('xin_employee_overtime_hour');?></th>
                                <th><?php echo $this->lang->line('xin_employee_overtime_rate');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('dashboard_overtime');?></strong> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'overtime_info', 'id' => 'overtime_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/employees/set_overtime', $attributes, $hidden);?>
                      <?php
						  $data_usr4 = array(
								'type'  => 'hidden',
								'name'  => 'user_id',
								'value' => $user_id,
						 );
						echo form_input($data_usr4);
					  ?>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="overtime_type"><?php echo $this->lang->line('xin_employee_overtime_title');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_overtime_title');?>" name="overtime_type" type="text" value="" id="overtime_type">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="no_of_days"><?php echo $this->lang->line('xin_employee_overtime_no_of_days');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_overtime_no_of_days');?>" name="no_of_days" type="text" value="" id="no_of_days">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="overtime_hours"><?php echo $this->lang->line('xin_employee_overtime_hour');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_overtime_hour');?>" name="overtime_hours" type="text" value="" id="overtime_hours">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="overtime_rate"><?php echo $this->lang->line('xin_employee_overtime_rate');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_overtime_rate');?>" name="overtime_rate" type="text" value="" id="overtime_rate">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php }?>
      <div id="smartwizard-2-step-3" class="animated fadeIn tab-pane step-content mt-3" style="display: none;">
        <div class="box-body">
          <div class="row no-gutters row-bordered row-border-light">
            <div class="col-md-12">
              <div class="tab-content">
                <div class="box-body pb-2">
                  <div class="row">
                    <?php $leave_categories_ids = explode(',',$leave_user[0]->leave_categories); ?>
                    <?php foreach($all_leave_types as $type) {
                                if(in_array($type->leave_type_id,$leave_categories_ids)){?>
                    <?php
                                $hlfcount =0;
                                //$count_l =0;
                                $leave_halfday_cal = employee_leave_halfday_cal($type->leave_type_id,$this->uri->segment(4));
                                foreach($leave_halfday_cal as $lhalfday):
                                    $hlfcount += 0.5;
                                endforeach;
                                
                                $count_l = count_leaves_info($type->leave_type_id,$this->uri->segment(4));
                                $count_l = $count_l - $hlfcount;
                            ?>
                    <?php
                                $edays_per_year = $type->days_per_year;
                                
                                if($count_l == 0){
                                    $progress_class = '';
                                    $count_data = 0;
                                } else {
                                    if($edays_per_year > 0){
                                        $count_data = $count_l / $edays_per_year * 100;
                                    } else {
                                        $count_data = 0;
                                    }
                                    // progress
                                    if($count_data <= 20) {
                                        $progress_class = 'progress-success';
                                    } else if($count_data > 20 && $count_data <= 50){
                                        $progress_class = 'progress-info';
                                    } else if($count_data > 50 && $count_data <= 75){
                                        $progress_class = 'progress-warning';
                                    } else {
                                        $progress_class = 'progress-danger';
                                    }
                                }
                            ?>
                    <div class="col-md-3">
                      <div class="card mb-4">
                        <div class="card-body">
                          <div class="d-flex align-items-center">
                            <div class="fas fa-calendar-alt display-4 text-success"></div>
                            <div class="ml-3">
                              <div class="text-muted small"><?php echo $type->type_name;?> (<?php echo $count_l;?>/<?php echo $edays_per_year;?>)</div>
                              <div class="text-large">
                                <div class="progress" style="height: 6px;">
                                  <div class="progress-bar" style="width: <?php echo $count_data;?>%;"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php
							} }
							?>
                  </div>
                </div>
                <?php $leave = $this->Timesheet_model->get_employee_leaves($user_id); ?>
                <div class="card <?php echo $get_animate;?>">
                  <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_leave');?></span> </div>
                  <div class="card-body">
                    <div class="box-datatable table-responsive">
                      <table class="datatables-demo table table-striped table-bordered xin_hrpremium_table" id="xin_hr_table">
                        <thead>
                          <tr>
                            <th><?php echo $this->lang->line('xin_view');?></th>
                            <th width="250"><?php echo $this->lang->line('xin_leave_type');?></th>
                            <th><?php echo $this->lang->line('left_department');?></th>
                            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_leave_duration');?></th>
                            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_applied_on');?></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($leave->result() as $r) { ?>
                          <?php
							// get start date and end date
							$user = $this->Xin_model->read_user_info($r->employee_id);
							if(!is_null($user)){
								$full_name = $user[0]->first_name. ' '.$user[0]->last_name;
								// department
								$department = $this->Department_model->read_department_information($user[0]->department_id);
								if(!is_null($department)){
									$department_name = $department[0]->department_name;
								} else {
									$department_name = '--';	
								}
							} else {
								$full_name = '--';	
								$department_name = '--';
							}
							 
							 // get leave type
							 $leave_type = $this->Timesheet_model->read_leave_type_information($r->leave_type_id);
							 if(!is_null($leave_type)){
								$type_name = $leave_type[0]->type_name;
							} else {
								$type_name = '--';	
							}
							
							// get company
							$company = $this->Xin_model->read_company_info($r->company_id);
							if(!is_null($company)){
								$comp_name = $company[0]->name;
							} else {
								$comp_name = '--';	
							}
							 
							$datetime1 = new DateTime($r->from_date);
							$datetime2 = new DateTime($r->to_date);
							$interval = $datetime1->diff($datetime2);
							if(strtotime($r->from_date) == strtotime($r->to_date)){
								$no_of_days =1;
							} else {
								$no_of_days = $interval->format('%a') + 1;
							}
							$applied_on = $this->Xin_model->set_date_format($r->applied_on);
							if($r->is_half_day == 1){
							$duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date).'<br>'.$this->lang->line('xin_hrpremium_total_days').': '.$this->lang->line('xin_hr_leave_half_day');
							} else {
								$duration = $this->Xin_model->set_date_format($r->from_date).' '.$this->lang->line('dashboard_to').' '.$this->Xin_model->set_date_format($r->to_date).'<br>'.$this->lang->line('xin_hrpremium_total_days').': '.$no_of_days;
							}
							
							 
							if($r->status==1): $status = '<span class="badge bg-orange">'.$this->lang->line('xin_pending').'</span>';
							elseif($r->status==2): $status = '<span class="badge bg-green">'.$this->lang->line('xin_approved').'</span>';
							elseif($r->status==4): $status = '<span class="badge bg-green">'.$this->lang->line('xin_role_first_level_approved').'</span>';
							else: $status = '<span class="badge bg-red">'.$this->lang->line('xin_rejected').'</span>'; endif;
							
							if(in_array('290',$role_resources_ids)) { //view
								$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/timesheet/leave_details/id/'.$r->leave_id.'/" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
							} else {
								$view = '';
							}
							$combhr = $view;
							$itype_name = $type_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_reason').': '.$r->reason.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('left_company').': '.$comp_name.'<i></i></i></small>';
							?>
                          <tr>
                            <td><?php echo $combhr;?></td>
                            <td><?php echo $itype_name;?></td>
                            <td><?php echo $department_name;?></td>
                            <td><i class="fa fa-calendar"></i> <?php echo $duration;?></td>
                            <td><i class="fa fa-calendar"></i> <?php echo $applied_on;?></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="smartwizard-2-step-4" class="animated fadeIn tab-pane step-content mt-3" style="display: none;">
        <div class="cards-body">
          <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
              <div class="col-md-3 pt-0">
                <div class="list-group list-group-flush account-settings-links"> <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-awards"> <i class="lnr lnr-strikethrough text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_awards');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-travels"> <i class="lnr lnr-car text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_travels');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-training"> <i class="lnr lnr-graduation-hat text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_training');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-tickets"> <i class="lnr lnr-location text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_tickets');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-transfers"> <i class="lnr lnr-store text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_transfers');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-promotions"> <i class="lnr lnr-tag text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_promotions');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-complaints"> <i class="lnr lnr-file-add text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_complaints');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-warnings"> <i class="lnr lnr-paw text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_warnings');?></a> </div>
              </div>
              <div class="col-md-9">
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="account-awards">
                    <div class="card">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_awards');?> </span> </div>
                      <?php $award = $this->Awards_model->get_employee_awards($user_id); ?>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="datatables-demo table table-striped table-bordered xin_hrpremium_table" id="xin_hr_table">
                            <thead>
                              <tr>
                                <th style="width:100px;"><?php echo $this->lang->line('xin_view');?></th>
                                <th width="300"><i class="fa fa-trophy"></i> <?php echo $this->lang->line('xin_award_name');?></th>
                                <th><i class="fa fa-gift"></i> <?php echo $this->lang->line('xin_gift');?></th>
                                <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_award_month_year');?></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($award->result() as $r) { ?>
                              <?php
							// get user > added by
							$user = $this->Xin_model->read_user_info($r->employee_id);
							// user full name
							if(!is_null($user)){
								$full_name = $user[0]->first_name.' '.$user[0]->last_name;
							} else {
								$full_name = '--';	
							}
							// get award type
							$award_type = $this->Awards_model->read_award_type_information($r->award_type_id);
							if(!is_null($award_type)){
								$award_type = $award_type[0]->award_type;
							} else {
								$award_type = '--';	
							}
							
							$d = explode('-',$r->award_month_year);
							$get_month = date('F', mktime(0, 0, 0, $d[1], 10));
							$award_date = $get_month.', '.$d[0];
							// get currency
							if($r->cash_price == '') {
								$currency = $this->Xin_model->currency_sign(0);
							} else {
								$currency = $this->Xin_model->currency_sign($r->cash_price);
							}		
							// get company
							$company = $this->Xin_model->read_company_info($r->company_id);
							if(!is_null($company)){
								$comp_name = $company[0]->name;
							} else {
								$comp_name = '--';	
							}
							
							if(in_array('232',$role_resources_ids)) { //view
								$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-xfield_id="'. $r->award_id . '" data-field_type="awards"><span class="fa fa-eye"></span></button></span>';
							} else {
								$view = '';
							}
							$award_info = $award_type.'<br><small class="text-muted"><i>'.$r->description.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('xin_cash_price').': '.$currency.'<i></i></i></small>';
							$combhr = $view;
							?>
                              <tr>
                                <td><?php echo $combhr;?></td>
                                <td><?php echo $award_info;?></td>
                                <td><?php echo $r->gift_item;?></td>
                                <td><?php echo $award_date;?></td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-travels">
                    <div class="card">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_travel');?> </span> </div>
                      <?php $travel = $this->Travel_model->get_employee_travel($user_id); ?>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="datatables-demo table table-striped table-bordered xin_hrpremium_table">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_view');?></th>
                                <th><?php echo $this->lang->line('xin_summary');?></th>
                                <th><?php echo $this->lang->line('xin_visit_place');?></th>
                                <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_start_date');?></th>
                                <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_end_date');?></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($travel->result() as $r) { ?>
                              <?php
							// get start date
							$start_date = $this->Xin_model->set_date_format($r->start_date);
							// get end date
							$end_date = $this->Xin_model->set_date_format($r->end_date);
							// get company
							$company = $this->Xin_model->read_company_info($r->company_id);
							if(!is_null($company)){
								$comp_name = $company[0]->name;
							} else {
								$comp_name = '--';	
							}
							// status
							//if($r->status==0): $status = $this->lang->line('xin_pending');
							//elseif($r->status==1): $status = $this->lang->line('xin_accepted'); else: $status = $this->lang->line('xin_rejected'); endif;
							if($r->status==0): $status = '<span class="badge bg-orange">'.$this->lang->line('xin_pending').'</span>';
								elseif($r->status==1): $status = '<span class="badge bg-green">'.$this->lang->line('xin_accepted').'</span>';else: $status = '<span class="badge bg-red">'.$this->lang->line('xin_rejected'); endif;
							
							if(in_array('235',$role_resources_ids)) { //view
								$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-xfield_id="'. $r->travel_id . '" data-field_type="travel"><span class="fa fa-eye"></span></button></span>';
							} else {
								$view = '';
							}
							$combhr = $view;
							$expected_budget = $this->Xin_model->currency_sign($r->expected_budget);
							$actual_budget = $this->Xin_model->currency_sign($r->actual_budget);
							$iemployee_name = $r->visit_purpose.'<br><small class="text-muted"><i>'.$this->lang->line('xin_expected_travel_budget').': '.$expected_budget.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('xin_actual_travel_budget').': '.$actual_budget.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
							?>
                              <tr>
                                <td><?php echo $combhr;?></td>
                                <td><?php echo $iemployee_name;?></td>
                                <td><?php echo $r->visit_place;?></td>
                                <td><?php echo $start_date;?></td>
                                <td><?php echo $end_date;?></td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-training">
                    <div class="card">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_training');?> </span> </div>
                      <?php $training = $this->Training_model->get_employee_training($user_id); ?>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="datatables-demo table table-striped table-bordered xin_hrpremium_table">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_view');?></th>
                                <th><?php echo $this->lang->line('left_training_type');?></th>
                                <th><?php echo $this->lang->line('xin_trainer');?></th>
                                <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_training_duration');?></th>
                                <th><i class="fa fa-dollar"></i> <?php echo $this->lang->line('xin_cost');?></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($training->result() as $r) { ?>
                              <?php
							$aim = explode(',',$r->employee_id);
							// get training type
							$type = $this->Training_model->read_training_type_information($r->training_type_id);
							if(!is_null($type)){
								$itype = $type[0]->type;
							} else {
								$itype = '--';	
							}
							// get trainer
							$trainer = $this->Trainers_model->read_trainer_information($r->trainer_id);
							// trainer full name
							if(!is_null($trainer)){
								$trainer_name = $trainer[0]->first_name.' '.$trainer[0]->last_name;
							} else {
								$trainer_name = '--';	
							}
							// get start date
							$start_date = $this->Xin_model->set_date_format($r->start_date);
							// get end date
							$finish_date = $this->Xin_model->set_date_format($r->finish_date);
							// training date
							$training_date = $start_date.' '.$this->lang->line('dashboard_to').' '.$finish_date;
							// set currency
							$training_cost = $this->Xin_model->currency_sign($r->training_cost);
							/* get Employee info*/
							if($r->employee_id == '') {
								$ol = '--';
							} else {
								$ol = '<ol class="nl">';
								foreach(explode(',',$r->employee_id) as $uid) {
									$user = $this->Xin_model->read_user_info($uid);
									if(!is_null($user)){
										$ol .= '<li>'.$user[0]->first_name.' '.$user[0]->last_name.'</li>';
									} else {
										$ol .= '--';
									}
								 }
								 $ol .= '</ol>';
							}
							// status
							//if($r->training_status==0): $status = $this->lang->line('xin_pending');
							//elseif($r->training_status==1): $status = $this->lang->line('xin_started'); elseif($r->training_status==2): $status = $this->lang->line('xin_completed');
							//else: $status = $this->lang->line('xin_terminated'); endif;
							if($r->training_status==0): $status = '<span class="badge bg-orange">'.$this->lang->line('xin_pending').'</span>';
							elseif($r->training_status==1): $status = '<span class="badge bg-teal">'.$this->lang->line('xin_started').'</span>'; elseif($r->training_status==2): $status = '<span class="badge bg-green">'.$this->lang->line('xin_completed').'</span>';
							else: $status = '<span class="badge bg-red">'.$this->lang->line('xin_terminated').'</span>'; endif;
							// get company
							$company = $this->Xin_model->read_company_info($r->company_id);
							if(!is_null($company)){
							$comp_name = $company[0]->name;
							} else {
							  $comp_name = '--';	
							}
							if(in_array('344',$role_resources_ids)) { //view
								$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/training/details/'.$r->training_id.'" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
							} else {
								$view = '';
							}
							$combhr = $view;
							$iitype = $itype.'<br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
							?>
                              <tr>
                                <td><?php echo $combhr;?></td>
                                <td><?php echo $iitype;?></td>
                                <td><?php echo $trainer_name;?></td>
                                <td><?php echo $training_date;?></td>
                                <td><?php echo $training_cost;?></td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-tickets">
                    <div class="card">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_tickets');?> </span> </div>
                      <?php $ticket = $this->Tickets_model->get_employees_tickets($user_id);?>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="datatables-demo table table-striped table-bordered xin_hrpremium_table">
                            <thead>
                              <tr class="xin-bg-dark">
                                <th><?php echo $this->lang->line('xin_view');?></th>
                                <th><?php echo $this->lang->line('xin_ticket_code');?></th>
                                <th><?php echo $this->lang->line('xin_subject');?></th>
                                <th><?php echo $this->lang->line('xin_p_priority');?></th>
                                <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_e_details_date');?></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($ticket->result() as $r) { ?>
                              <?php		
							// priority
							if($r->ticket_priority==1): $priority = $this->lang->line('xin_low'); elseif($r->ticket_priority==2): $priority = $this->lang->line('xin_medium'); elseif($r->ticket_priority==3): $priority = $this->lang->line('xin_high'); elseif($r->ticket_priority==4): $priority = $this->lang->line('xin_critical');  endif;
							 
							 // status
							 //if($r->ticket_status==1): $status = $this->lang->line('xin_open'); elseif($r->ticket_status==2): $status = $this->lang->line('xin_closed'); endif;
							 if($r->ticket_status==1): $status = '<span class="badge bg-orange">'.$this->lang->line('xin_open').'</span>';
								else: $status = '<span class="badge bg-green">'.$this->lang->line('xin_closed').'</span>';endif;
							 // ticket date and time
							 $created_at = date('h:i A', strtotime($r->created_at));
							 $_date = explode(' ',$r->created_at);
							 $edate = $this->Xin_model->set_date_format($_date[0]);
							 $_created_at = $edate. ' '. $created_at;
							
							
								$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/tickets/details/'.$r->ticket_id.'" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
							
							$combhr = $view;
							$iticket_code = $r->ticket_code.'<br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
							?>
                              <tr>
                                <td><?php echo $combhr;?></td>
                                <td><?php echo $iticket_code;?></td>
                                <td><?php echo $r->subject;?></td>
                                <td><?php echo $priority;?></td>
                                <td><?php echo $_created_at;?></td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-transfers">
                    <div class="card">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_transfers');?> </span> </div>
                      <?php $transfer = $this->Transfers_model->get_employee_transfers($user_id); ?>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="datatables-demo table table-striped table-bordered xin_hrpremium_table">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_view');?></th>
                                <th><?php echo $this->lang->line('xin_summary');?></th>
                                <th><?php echo $this->lang->line('left_company');?></th>
                                <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_transfer_date');?></th>
                                <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($transfer->result() as $r) { ?>
                              <?php
							// get date
							$transfer_date = $this->Xin_model->set_date_format($r->transfer_date);
							// get department by id
							$department = $this->Department_model->read_department_information($r->transfer_department);
							if(!is_null($department)){
								$department_name = $department[0]->department_name;
							} else {
								$department_name = '--';	
							}
							// get location by id
							$location = $this->Location_model->read_location_information($r->transfer_location);
							if(!is_null($location)){
								$location_name = $location[0]->location_name;
							} else {
								$location_name = '--';	
							}
							// get status
							if($r->status==0): $status = '<span class="badge bg-orange">'.$this->lang->line('xin_pending').'</span>';
							elseif($r->status==1): $status = '<span class="badge bg-green">'.$this->lang->line('xin_accepted').'</span>';else: $status = '<span class="badge bg-red">'.$this->lang->line('xin_rejected').'</span>'; endif;
							
							// get company
							$company = $this->Xin_model->read_company_info($r->company_id);
							if(!is_null($company)){
								$comp_name = $company[0]->name;
							} else {
								$comp_name = '--';	
							}
							
							if(in_array('233',$role_resources_ids)) { //view
								$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-xfield_id="'. $r->transfer_id . '" data-field_type="transfers"><span class="fa fa-eye"></span></button></span>';
							} else {
								$view = '';
							}
						$combhr = $view;
						$xinfo = $this->lang->line('xin_transfer_to_department').': '.$department_name.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('xin_transfer_to_location').': '.$location_name.'<i></i></i></small>';
							?>
                              <tr>
                                <td><?php echo $combhr;?></td>
                                <td><?php echo $xinfo;?></td>
                                <td><?php echo $comp_name;?></td>
                                <td><?php echo $transfer_date;?></td>
                                <td><?php echo $status;?></td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-promotions">
                    <div class="card">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_promotions');?> </span> </div>
                      <?php $promotion = $this->Promotion_model->get_employee_promotions($user_id); ?>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="datatables-demo table table-striped table-bordered xin_hrpremium_table">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_view');?></th>
                                <th><?php echo $this->lang->line('xin_promotion_title');?></th>
                                <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_e_details_date');?></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($promotion->result() as $r) { ?>
                              <?php
							// get company
							$company = $this->Xin_model->read_company_info($r->company_id);
							if(!is_null($company)){
								$comp_name = $company[0]->name;
							} else {
								$comp_name = '--';	
							}
							// get promotion date
							$promotion_date = $this->Xin_model->set_date_format($r->promotion_date);
							if(in_array('236',$role_resources_ids)) { //view
								$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-xfield_id="'. $r->promotion_id . '" data-field_type="promotion"><span class="fa fa-eye"></span></button></span>';
							} else {
								$view = '';
							}
							$combhr = $view;
							$pro_desc = $r->title.'<br><small class="text-muted"><i>'.$this->lang->line('xin_description').': '.$r->description.'<i></i></i></small>';
							?>
                              <tr>
                                <td><?php echo $combhr;?></td>
                                <td><?php echo $pro_desc;?></td>
                                <td><?php echo $promotion_date;?></td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-complaints">
                    <div class="card">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_complaints');?> </span> </div>
                      <?php $complaint = $this->Complaints_model->get_employee_complaints($user_id); ?>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="datatables-demo table table-striped table-bordered xin_hrpremium_table">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_view');?></th>
                                <th width="200"><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_complaint_from');?></th>
                                <th><i class="fa fa-users"></i> <?php echo $this->lang->line('xin_complaint_against');?></th>
                                <th><?php echo $this->lang->line('xin_complaint_title');?></th>
                                <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_complaint_date');?></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($complaint->result() as $r) { ?>
                              <?php
							// get user > added by
							$user = $this->Xin_model->read_user_info($r->complaint_from);
							// user full name
							if(!is_null($user)){
								$complaint_from = $user[0]->first_name.' '.$user[0]->last_name;
							} else {
								$complaint_from = '--';	
							}
							
							if($r->complaint_against == '') {
								$ol = '--';
							} else {
								$ol = '<ol class="nl">';
								foreach(explode(',',$r->complaint_against) as $desig_id) {
									$_comp_name = $this->Xin_model->read_user_info($desig_id);
									if(!is_null($_comp_name)){
										$ol .= '<li>'.$_comp_name[0]->first_name.' '.$_comp_name[0]->last_name.'</li>';
									} else {
										$ol .= '';
									}
									
								 }
								 $ol .= '</ol>';
							}
							// get complaint date
							$complaint_date = $this->Xin_model->set_date_format($r->complaint_date);
						
							if(in_array('237',$role_resources_ids)) { //view
								$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-xfield_id="'. $r->complaint_id . '" data-field_type="complaints"><span class="fa fa-eye"></span></button></span>';
							} else {
								$view = '';
							}
							// get company
							$company = $this->Xin_model->read_company_info($r->company_id);
							if(!is_null($company)){
								$comp_name = $company[0]->name;
							} else {
								$comp_name = '--';	
							}
							// get status
							if($r->status==0): $status = '<span class="badge bg-red">'.$this->lang->line('xin_pending').'</span>';
							elseif($r->status==1): $status = '<span class="badge bg-green">'.$this->lang->line('xin_accepted').'</span>'; else: $status = '<span class="badge bg-red">'.$this->lang->line('xin_rejected').'</span>';endif;
							// info
							$icomplaint_from = $complaint_from.'<br><small class="text-muted"><i>'.$this->lang->line('xin_description').': '.$r->description.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
							$combhr = $view;
							?>
                              <tr>
                                <td><?php echo $combhr;?></td>
                                <td><?php echo $icomplaint_from;?></td>
                                <td><?php echo $ol;?></td>
                                <td><?php echo $r->title;?></td>
                                <td><?php echo $complaint_date;?></td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-warnings">
                    <div class="card">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_warnings');?> </span> </div>
                      <?php $warning = $this->Warning_model->get_employee_warning($user_id); ?>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="datatables-demo table table-striped table-bordered xin_hrpremium_table">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_view');?></th>
                                <th><?php echo $this->lang->line('xin_subject');?></th>
                                <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_warning_date');?></th>
                                <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_warning_by');?></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($warning->result() as $r) { ?>
                              <?php
							// get user > warning to
							$user = $this->Xin_model->read_user_info($r->warning_to);
							// user full name
							if(!is_null($user)){
								$warning_to = $user[0]->first_name.' '.$user[0]->last_name;
							} else {
								$warning_to = '--';	
							}
							// get user > warning by
							$user_by = $this->Xin_model->read_user_info($r->warning_by);
							// user full name
							if(!is_null($user_by)){
								$warning_by = $user_by[0]->first_name.' '.$user_by[0]->last_name;
							} else {
								$warning_by = '--';	
							}
							// get warning date
							$warning_date = $this->Xin_model->set_date_format($r->warning_date);
									
							// get status
							if($r->status==0): $status = $this->lang->line('xin_pending');
							elseif($r->status==1): $status = $this->lang->line('xin_accepted'); else: $status = $this->lang->line('xin_rejected'); endif;
							// get warning type
							$warning_type = $this->Warning_model->read_warning_type_information($r->warning_type_id);
							if(!is_null($warning_type)){
								$wtype = $warning_type[0]->type;
							} else {
								$wtype = '--';	
							}
							// get company
							$company = $this->Xin_model->read_company_info($r->company_id);
							if(!is_null($company)){
								$comp_name = $company[0]->name;
							} else {
								$comp_name = '--';	
							}
							
							if(in_array('238',$role_resources_ids)) { //view
								$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target="#modals-slide" data-xfield_id="'. $r->warning_id . '" data-field_type="warning"><span class="fa fa-eye"></span></button></span>';
							} else {
								$view = '';
							}
							if($r->status==0): $status = '<span class="badge bg-orange">'.$this->lang->line('xin_pending').'</span>';
							elseif($r->status==1): $status = '<span class="badge bg-green">'.$this->lang->line('xin_accepted').'</span>';else: $status = '<span class="badge bg-red">'.$this->lang->line('xin_rejected').'</span>'; endif;
							
							$combhr = $view;
							
							$iwarning_to = $warning_to.'<br><small class="text-muted"><i>'.$wtype.'<i></i></i></small><br><small class="text-muted"><i>'.$status.'<i></i></i></small>';
							?>
                              <tr>
                                <td><?php echo $combhr;?></td>
                                <td><?php echo $r->subject;?></td>
                                <td><?php echo $warning_date;?></td>
                                <td><?php echo $warning_by;?></td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="smartwizard-2-step-5" class="animated fadeIn tab-pane step-content mt-3" style="display: none;">
        <div class="cards-body">
          <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
              <div class="col-md-3 pt-0">
                <div class="list-group list-group-flush account-settings-links"> <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-projects"> <i class="lnr lnr-layers text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_projects');?></a> <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-tasks"> <i class="lnr lnr-dice text-lightest"></i> &nbsp; <?php echo $this->lang->line('left_tasks');?></a> </div>
              </div>
              <div class="col-md-9">
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="account-projects">
                    <div class="card">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_projects');?> </span> </div>
                      <?php $project = $this->Project_model->get_employee_projects($user_id); ?>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="datatables-demo table table-striped table-bordered xin_hrpremium_table" id="xin_hr_table">
                            <thead>
                              <tr>
                                <th width="230"><?php echo $this->lang->line('xin_project_summary');?></th>
                                <th><?php echo $this->lang->line('xin_p_priority');?></th>
                                <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_project_users');?></th>
                                <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_p_enddate');?></th>
                                <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($project->result() as $r) { ?>
                              <?php
							$aim = explode(',',$r->assigned_to);
					 		// get user > added by
							$user = $this->Xin_model->read_user_info($r->added_by);
							// user full name
							if(!is_null($user)){
								$full_name = $user[0]->first_name.' '.$user[0]->last_name;
							} else {
								$full_name = '--';	
							}
							// get date
							$pdate = '<i class="fa fa-calendar position-left"></i> '.$this->Xin_model->set_date_format($r->end_date);
							
							//project_progress
							if($r->project_progress <= 20) {
								$progress_class = 'progress-danger';
							} else if($r->project_progress > 20 && $r->project_progress <= 50){
								$progress_class = 'progress-warning';
							} else if($r->project_progress > 50 && $r->project_progress <= 75){
								$progress_class = 'progress-info';
							} else {
								$progress_class = 'progress-success';
							}
							
							// progress
							$pbar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$r->project_progress.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$r->project_progress.'" max="100">'.$r->project_progress.'%</progress>';
									
							//status
							if($r->status == 0) {
								$status = $this->lang->line('xin_not_started');
							} else if($r->status ==1){
								$status = $this->lang->line('xin_in_progress');
							} else if($r->status ==2){
								$status = $this->lang->line('xin_completed');
							} else {
								$status = $this->lang->line('xin_deffered');
							}
							
							// priority
							if($r->priority == 1) {
								$priority = '<span class="label label-danger">'.$this->lang->line('xin_highest').'</span>';
							} else if($r->priority ==2){
								$priority = '<span class="label label-danger">'.$this->lang->line('xin_high').'</span>';
							} else if($r->priority ==3){
								$priority = '<span class="label label-primary">'.$this->lang->line('xin_normal').'</span>';
							} else {
								$priority = '<span class="label label-success">'.$this->lang->line('xin_low').'</span>';
							}
							
							//assigned user
							if($r->assigned_to == '') {
								$ol = $this->lang->line('xin_not_assigned');
							} else {
								$ol = '';
								foreach(explode(',',$r->assigned_to) as $desig_id) {
									$assigned_to = $this->Xin_model->read_user_info($desig_id);
									if(!is_null($assigned_to)){
										
									  $assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
									 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
										$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
										} else {
										if($assigned_to[0]->gender=='L') { 
											$de_file = base_url().'uploads/profile/default_male.jpg';
										 } else {
											$de_file = base_url().'uploads/profile/default_female.jpg';
										 }
										$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
										}
									} ////
									else {
										$ol .= '';
									}
								 }
								 $ol .= '';
							}
							
							$project_summary = '<div class="text-semibold"><a href="'.site_url().'admin/project/detail/'.$r->project_id . '" target="_blank">'.$r->title.'</a></div><div class="text-muted">'.$r->summary.'</div>';
							?>
                              <tr>
                                <td><?php echo $project_summary;?></td>
                                <td><?php echo $priority;?></td>
                                <td><?php echo $ol;?></td>
                                <td><?php echo $pdate;?></td>
                                <td><?php echo $pbar;?></td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="account-tasks">
                    <div class="card">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_tasks');?> </span> </div>
                      <?php $task = $this->Timesheet_model->get_employee_tasks($user_id); ?>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="datatables-demo table table-striped table-bordered xin_hrpremium_table">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_view');?></th>
                                <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                                <th><?php echo $this->lang->line('xin_end_date');?></th>
                                <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
                                <th><?php echo $this->lang->line('xin_assigned_to');?></th>
                                <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($task->result() as $r) { ?>
                              <?php
							$aim = explode(',',$r->assigned_to);
				  
							if($r->assigned_to == '' || $r->assigned_to == 'None') {
								$ol = 'None';
							} else {
								$ol = '<ol class="nl">';
								foreach(explode(',',$r->assigned_to) as $uid) {
									//$user = $this->Xin_model->read_user_info($uid);
									$assigned_to = $this->Xin_model->read_user_info($uid);
									if(!is_null($assigned_to)){
										
									$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
									 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
										$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
										} else {
										if($assigned_to[0]->gender=='L') { 
											$de_file = base_url().'uploads/profile/default_male.jpg';
										 } else {
											$de_file = base_url().'uploads/profile/default_female.jpg';
										 }
										$ol .= '<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="ui-w-30 rounded-circle" alt=""></span></a>';
										}
									}
								 }
							 $ol .= '</ol>';
							}							
							// task project
							$prj_task = $this->Project_model->read_project_information($r->project_id);
							if(!is_null($prj_task)){
								$prj_name = $prj_task[0]->title;
							} else {
								$prj_name = '--';
							}
							
							/// set task progress
							if($r->task_progress=='' || $r->task_progress==0): $progress = 0; else: $progress = $r->task_progress; endif;				
							// task progress
							if($r->task_progress <= 20) {
							$progress_class = 'progress-danger';
							} else if($r->task_progress > 20 && $r->task_progress <= 50){
							$progress_class = 'progress-warning';
							} else if($r->task_progress > 50 && $r->task_progress <= 75){
							$progress_class = 'progress-info';
							} else {
							$progress_class = 'progress-success';
							}
							
							$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$r->task_progress.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$r->task_progress.'" max="100">'.$r->task_progress.'%</progress>';
							// task end date
							$tdate = $this->Xin_model->set_date_format($r->end_date);							
							// task status

							if($r->task_status == 0) {
								$status = $this->lang->line('xin_not_started');
							} else if($r->task_status ==1){
								$status = $this->lang->line('xin_in_progress');
							} else if($r->task_status ==2){
								$status = $this->lang->line('xin_completed');
							} else {
								$status = $this->lang->line('xin_deffered');
							}
							// task end date
							if(in_array('322',$role_resources_ids)) { //view
								$view = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/timesheet/task_details/id/'.$r->task_id.'/" target="_blank"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span>';
							} else {
								$view = '';
							}
							$combhr = $view;
							$task_name = $r->task_name.'<br>'.$this->lang->line('xin_project').': <a href="'.site_url().'admin/project/detail/'.$r->project_id.'" target="_blank">'.$prj_name.'</a>';
							?>
                              <tr>
                                <td><?php echo $combhr;?></td>
                                <td><?php echo $task_name;?></td>
                                <td><?php echo $tdate;?></td>
                                <td><?php echo $status;?></td>
                                <td><?php echo $ol;?></td>
                                <td><?php echo $progress_bar;?></td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="smartwizard-2-step-6" class="card animated fadeIn tab-pane step-content mt-3" style="display: none;">
        <div class="card">
          <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_payment_history');?> </span> </div>
          <?php $history = $this->Payroll_model->get_payroll_slip($user_id); ?>
          <div class="card-body">
            <div class="box-datatable table-responsive">
              <table class="datatables-demo table table-striped table-bordered xin_hrpremium_table" id="xin_hr_table">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('xin_action');?></th>
                    <th><?php echo $this->lang->line('xin_payroll_net_payable');?></th>
                    <th><?php echo $this->lang->line('xin_salary_month');?></th>
                    <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_payroll_date_title');?></th>
                    <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($history->result() as $r) { ?>
                  <?php
                        // get addd by > template
                        $user = $this->Xin_model->read_user_info($r->employee_id);
                        // user full name
                        if(!is_null($user)){
                        $full_name = $user[0]->first_name.' '.$user[0]->last_name;
                        $emp_link = $user[0]->employee_id;			  		  
                        $month_payment = date("F, Y", strtotime($r->salary_month));
                        
                        $p_amount = $this->Xin_model->currency_sign($r->net_salary);
                        
                        // get date > created at > and format
                        $created_at = $this->Xin_model->set_date_format($r->created_at);
                        // get designation
                        $designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
                        if(!is_null($designation)){
                            $designation_name = $designation[0]->designation_name;
                        } else {
                            $designation_name = '--';	
                        }
                        // department
                        $department = $this->Department_model->read_department_information($user[0]->department_id);
                        if(!is_null($department)){
                        $department_name = $department[0]->department_name;
                        } else {
                        $department_name = '--';	
                        }
                        $department_designation = $designation_name.' ('.$department_name.')';
                        // get company
                        $company = $this->Xin_model->read_company_info($user[0]->company_id);
                        if(!is_null($company)){
                            $comp_name = $company[0]->name;
                        } else {
                            $comp_name = '--';	
                        }
                        // bank account
                        $bank_account = $this->Employees_model->get_employee_bank_account_last($user[0]->user_id);
                        if(!is_null($bank_account)){
                            $account_number = $bank_account[0]->account_number;
                        } else {
                            $account_number = '--';	
                        }
                        $payslip = '<span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_view').'"><a href="'.site_url().'admin/payroll/payslip/id/'.$r->payslip_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" data-state="primary" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/payroll/pdf_create/p/'.$r->payslip_key.'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="oi oi-cloud-download"></span></button></a></span>';
                        
                    $ifull_name = nl2br ($full_name."\r\n <small class='text-muted'><i>".$this->lang->line('xin_employees_id').': '.$emp_link."<i></i></i></small>\r\n <small class='text-muted'><i>".$department_designation.'<i></i></i></small>');
                        ?>
                  <tr>
                    <td><?php echo $payslip;?></td>
                    <td><?php echo $p_amount;?></td>
                    <td><?php echo $month_payment;?></td>
                    <td><?php echo $created_at;?></td>
                    <td><?php echo $this->lang->line('xin_payroll_paid');?></td>
                  </tr>
                  <?php } } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>