<?php
/* Profile view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php if($profile_picture!='' && $profile_picture!='no file') {?>
<?php $de_file = base_url().'uploads/profile/'.$profile_picture;?>
<?php } else {?>
<?php if($gender=='L') { ?>
<?php $de_file = base_url().'uploads/profile/default_male.jpg';?>
<?php } else { ?>
<?php $de_file = base_url().'uploads/profile/default_female.jpg';?>
<?php } ?>
<?php } ?>
<?php $full_name = $user[0]->first_name.' '.$user[0]->last_name;?>
<?php $designation = $this->Designation_model->read_designation_information($user[0]->designation_id);?>
<?php
  if(!is_null($designation)){
    $designation_name = $designation[0]->designation_name;
  } else {
    $designation_name = '--'; 
  }

    $subprojects = $this->Project_model->read_single_subproject($sub_project_id);
    if(!is_null($subprojects)){
      $nama_subproject = $subprojects[0]->sub_project_name;
    } else {
      $nama_subproject = '--';  
    }

    if($status_employee==1){
      $status_deactive = 'ACTIVE';
    }else {
      $status_deactive = 'DEACTIVE';
    }

    $emp_deactive = $this->Employees_model->read_employee_info($deactive_by);
    if(!is_null($emp_deactive)){
      $name_by_deactive = $emp_deactive[0]->first_name;
    } else {
      $name_by_deactive = '--';  
    }

// deactive_by

  
  $leave_user = $this->Xin_model->read_user_info($session['user_id']);
?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

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


                  <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-basic_info"> <i class="lnr lnr-user text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_e_details_basic');?></a>

                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-grade"> <i class="lnr lnr-earth text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_e_details_post');?></a>

                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-bpjs"> <i class="lnr lnr-earth text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_manage_employees_bpjs');?></a>

                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-docpkwt"> <i class="lnr lnr-apartment text-lightest"></i> &nbsp; Dokumen PKWT</a>

                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-document"> <i class="lnr lnr-earth text-lightest"></i> &nbsp; Dokumen Pribadi</a>

                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-baccount"> <i class="lnr lnr-apartment text-lightest"></i> &nbsp; <?php echo $this->lang->line('xin_e_details_baccount');?></a>
            
                  
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-cpassword"> <i class="lnr lnr-file-empty text-lightest"></i> &nbsp; Ubah PIN</a>


                  <?php if($system[0]->employee_manage_own_work_experience=='yes'){?>
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-experience"> <i class="lnr lnr-hourglass text-lightest"></i> &nbsp; Ubah PIN</a>
                  <?php } ?>
                </div>
              </div>
              <div class="col-md-9">
                <div class="tab-content">

                  <!-- BASIC INFO -->
                  <div class="tab-pane fade show active" id="account-basic_info">
                    <?php $shift_info = $this->Employees_model->read_shift_information($user[0]->office_shift_id); ?>
                    <?php
                        if(!is_null($shift_info)){
                            $shift_name = $shift_info[0]->shift_name;
                        } else {
                            $shift_name = '--';
                        }
                      ?>

                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> DATA </strong> DIRI </span> </div>
                    <div class="card-body media align-items-center"> <img src="<?php echo $de_file;?>" alt="" class="d-block ui-w-80">
                      <div class="media-body ml-4">
                        <div class="text-big  mt-1"><label class="form-label"><?php echo $first_name;?></label></div>
                        <div class="text-big  mt-1"><label class="form-label">NIP: <?php echo $employee_id;?></label></div>
                        <div class="text-muted  mt-1"><label class="form-label"><?php echo $designations;?></label></div>
                      </div>
                    </div>

                    <hr class="border-light m-0">
                    <div class="card-body">
                      <?php $attributes = array('name' => 'basic_info', 'id' => 'basic_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/profile/user_basic_info/', $attributes, $hidden);?>
                      <?php
                              $data_usr1 = array(
                                    'type'  => 'hidden',
                                    'name'  => 'user_id',
                                    'id'  => 'user_id',
                                    'value' => $session['user_id'],
                             );
                            echo form_input($data_usr1);
                            ?>
                      <div class="box">
                        <div class="box-body">
                          <div class="card-block">


                            <input name="user_id" type="text" value="<?php echo $user_id;?>" hidden>

                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-label"><?php echo $this->lang->line('xin_employee_first_name');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_first_name');?>" name="first_name" type="text" value="<?php echo $first_name;?>">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="control-label form-label"><?php echo $this->lang->line('xin_profile_tempat_lahir');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_profile_tempat_lahir');?>" name="tempat_lahir" type="text" value="<?php echo $tempat_lahir;?>">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="tanggal_lahir" class="control-label"><?php echo $this->lang->line('xin_employee_dob');?></label>
                                  <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_employee_dob');?>" name="tanggal_lahir" type="text" value="<?php echo $date_of_birth;?>">
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-label control-label">Nama Ibu Kandung</label>
                                  <input class="form-control" placeholder="Nama Ibu Kandung" name="ibu_kandung" type="text" value="<?php echo $ibu_kandung;?>">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-label control-label">Nomor HP/Whatsapp</label>
                                  <input class="form-control" placeholder="Nomor HP/Whatsapp" name="no_kontak" type="text" value="<?php echo $contact_no;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-label">Email*</label>
                                  <input class="form-control" placeholder="Alamat Email" name="email" type="text" value="<?php echo $email;?>">
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-label control-label">Nomor KTP*</label>
                                  <input class="form-control" placeholder="Nomor HP/Whatsapp" name="ktp_no" type="text" value="<?php echo $ktp_no;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="16">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-label">Nomor KK*</label>
                                  <input class="form-control" placeholder="Nomor Kartu Keluarga" name="kk_no" type="text" value="<?php echo $kk_no;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="16">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-label">NPWP</label>
                                  <input class="form-control" placeholder="Nomor Pokok Wajib Pajak" name="npwp_no" type="text" value="<?php echo $npwp_no;?>">
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="form-label"><?php echo $this->lang->line('xin_address_1');?></label>
                                  <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="alamat_ktp" cols="30" rows="3" ><?php echo $alamat_ktp;?></textarea>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label class="form-label"><?php echo $this->lang->line('xin_address_domisili');?></label>
                                  <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_address_domisili');?>" name="alamat_domisili" cols="30" rows="3"><?php echo $alamat_domisili;?></textarea>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-label control-label"><?php echo $this->lang->line('xin_employee_gender');?></label>
                                  <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_gender');?>">
                                    <option value="L" <?php if($gender=='L'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_gender_male');?></option>
                                    <option value="P" <?php if($gender=='P'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_gender_female');?></option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-label control-label">Agama</label>

                                  <select class="form-control" name="ethnicity" data-plugin="select_hrm">
                                  <option value=""></option>
                                              <?php foreach($all_ethnicity as $eth):?>
                                              <option value="<?php echo $eth->ethnicity_type_id;?>" <?php if($ethnicity_type==$eth->ethnicity_type_id):?> selected <?php endif; ?> ><?php echo $eth->type;?></option>
                                              <?php endforeach;?>
                                  </select>

                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-label control-label"><?php echo $this->lang->line('xin_employee_mstatus');?></label>

                                  <select class="form-control" name="marital_status" data-plugin="select_hrm">
                                  <option value=""></option>
                                              <option value="TK/0" <?php if($marital_status=='TK/0'):?> selected <?php endif; ?>>Single/Janda/Duda (0 Anak)</option>
                                              <option value="K/0" <?php if($marital_status=='K/0'):?> selected <?php endif; ?>>Menikah (0 Anak)</option>
                                              <option value="K/1" <?php if($marital_status=='K/1'):?> selected <?php endif; ?>>Menikah (1 Anak)</option>
                                              <option value="K/2" <?php if($marital_status=='K/2'):?> selected <?php endif; ?>>Menikah (2 Anak)</option>
                                              <option value="K/3" <?php if($marital_status=='K/3'):?> selected <?php endif; ?>>Menikah (3 Anak)</option>
                                              <option value="TK/1" <?php if($marital_status=='TK/1'):?> selected <?php endif; ?>>Janda/Duda (1 Anak)</option>
                                              <option value="TK/2" <?php if($marital_status=='TK/2'):?> selected <?php endif; ?>>Janda/Duda (2 Anak)</option>
                                              <option value="TK/3" <?php if($marital_status=='TK/3'):?> selected <?php endif; ?>>Janda/Duda (3 Anak)</option>

                                </select>

                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-label control-label">Golongan Darah</label>
                               <select class="form-control" name="blood_group" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_blood_group');?>">
                                <option value=""></option>
                                <option value="A" <?php if($blood_group == 'A+'):?> selected="selected"<?php endif;?>>A</option>
                                <option value="A+" <?php if($blood_group == 'A+'):?> selected="selected"<?php endif;?>>A+</option>
                                <option value="A-" <?php if($blood_group == 'A-'):?> selected="selected"<?php endif;?>>A-</option>
                                <option value="B" <?php if($blood_group == 'A+'):?> selected="selected"<?php endif;?>>B</option>
                                <option value="B+" <?php if($blood_group == 'B+'):?> selected="selected"<?php endif;?>>B+</option>
                                <option value="B-" <?php if($blood_group == 'B-'):?> selected="selected"<?php endif;?>>B-</option>
                                <option value="AB" <?php if($blood_group == 'A+'):?> selected="selected"<?php endif;?>>AB</option>
                                <option value="AB+" <?php if($blood_group == 'AB+'):?> selected="selected"<?php endif;?>>AB+</option>
                                <option value="AB-" <?php if($blood_group == 'AB-'):?> selected="selected"<?php endif;?>>AB-</option>
                                <option value="O" <?php if($blood_group == 'A+'):?> selected="selected"<?php endif;?>>0</option>
                                <option value="O+" <?php if($blood_group == 'O+'):?> selected="selected"<?php endif;?>>O+</option>
                                <option value="O-" <?php if($blood_group == 'O-'):?> selected="selected"<?php endif;?>>O-</option>
                              </select>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-label">Tinggi Badan</label>
                                  <input class="form-control" placeholder="0 kg" name="tinggi_badan" type="text" value="<?php echo $tinggi_badan;?>">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label class="form-label">Berat Badan</label>
                                  <input class="form-control" placeholder="0 kg" name="berat_badan" type="text" value="<?php echo $berat_badan;?>">
                                </div>
                              </div>
                            </div>

                            <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="far fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>

                  <!-- POSISI/JABATAN -->
                  <div class="tab-pane fade" id="account-grade">
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> POSISI </strong> DAN JABATAN </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'grade_info', 'id' => 'grade_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open('admin/profile/grade/', $attributes, $hidden);?>
                      <?php
                              $data_usr4 = array(
                                    'type'  => 'hidden',
                                    'name'  => 'user_id',
                                    'value' => $session['user_id'],
                             );
                            echo form_input($data_usr4);
                            ?>
                      <div class="box">
                        <div class="box-body">
                          <div class="card-block">


                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="pt">Perusahaan / PT</label>
                              <input class="form-control" placeholder="" name="twitter_link" type="text" value="<?php echo $company_name;?>" disabled>
                                </div>
                              </div>
                            </div>

                                  <input class="form-control" placeholder="" name="company_id" type="text" value="<?php echo $user_id;?>" hidden>

                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="department">Department</label>
                                  <input class="form-control" placeholder="" name="twitter_link" type="text" value="<?php echo $department_name;?>" disabled>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                              <label for="projects"><?php echo $this->lang->line('xin_projects');?><i class="hrpremium-asterisk"></i></label>
                              <input class="form-control" placeholder="" name="project_id" type="text" value="<?php echo $project_name;?>" disabled>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6" id="project_sub_project">
                                <div class="form-group">
                                  <label for="blogger_profile">Sub Project</label>
                                  <input class="form-control" placeholder="" name="sub_project_id" type="text" value="<?php echo $nama_subproject;?>" disabled>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="blogger_profile">Posisi/Jabatan</label>
                                  <input class="form-control" placeholder="" name="designation_id" type="text" value="<?php echo $designations;?>" disabled>
                                </div>
                              </div>
                            </div>


                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="linkdedin_profile">Area/Penempatan</label>
                                  <input class="form-control" placeholder="" name="penempatan" type="text" value="<?php echo $penempatan;?>">
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="tanggal_bergabung" class="control-label"><?php echo $this->lang->line('xin_employee_doj');?></label>
                                  <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_employee_doj');?>" name="tanggal_bergabung" type="text" value="<?php echo $date_of_joining;?>">
                                </div>
                              </div>
                            </div>


                            <div class="form-actions box-footer" hidden> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="far fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>

                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>

                  <!-- BPJS-->
                  <div class="tab-pane fade" id="account-bpjs">
                    <div class="box" hidden>
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> BPJS </strong> TK & KS </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_bpjs" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('xin_e_details_dtype');?></th>
                                <th><?php echo $this->lang->line('xin_employee_document_number');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>s
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> BPJS </strong> TK & KS </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'bpjs_info', 'id' => 'bpjs_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open_multipart('admin/employees/bpjs_info', $attributes, $hidden);?>
                      <?php
                      $data_usr2 = array(
                        'type'  => 'hidden',
                        'name'  => 'user_id',
                        'value' => $user_id,
                       );
                      echo form_input($data_usr2);
                      ?>

                        <div class="row">
                          <!--rule-->

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title"><?php echo $this->lang->line('xin_bpjstk');?><i class="hrpremium-asterisk">*</i></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_bpjstk');?>" name="no_bpjstk" type="number" value="<?php echo $bpjs_tk_no;?>" id="title">
                            </div>
                          </div>

                          <div class="col-md-3" hidden>
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

                          <div class="col-md-3" hidden>
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

                      <div class="row" hidden>
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>

                  <!-- DOKUMEN PKWT -->
                  <div class="tab-pane fade" id="account-docpkwt">
                    <div class="box md-4" hidden>
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_e_details_baccount');?> </span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <?php $attributes = array('name' => 'dokumen_pkwt', 'id' => 'dokumen_pkwt', 'autocomplete' => 'off');?>
                          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                          <?php echo form_open('admin/employees/contract/', $attributes, $hidden);?>
                          <?php
                              $data_usr10 = array(
                                    'type'  => 'hidden',
                                    'name'  => 'user_id',
                                    'value' => $session['employee_id'],
                             );
                            echo form_input($data_usr10);
                            ?>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="account_title"><?php echo $this->lang->line('xin_e_details_acc_title');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_acc_title');?>" name="account_title" type="text" value="" id="account_name">
                              </div>
                              <div class="form-group">
                                <label for="account_number"><?php echo $this->lang->line('xin_e_details_acc_number');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_acc_number');?>" name="account_number" type="text" value="" id="account_number">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="bank_name"><?php echo $this->lang->line('xin_e_details_bank_name');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_bank_name');?>" name="bank_name" type="text" value="" id="bank_name">
                              </div>
                              <div class="form-group">
                                <label for="bank_code"><?php echo $this->lang->line('xin_e_details_bank_code');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_bank_code');?>" name="bank_code" type="text" value="" id="bank_code">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="bank_branch"><?php echo $this->lang->line('xin_e_details_bank_branch');?></label>
                              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_bank_branch');?>" name="bank_branch" type="text" value="" id="bank_branch">
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="far fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                              </div>
                            </div>
                            <?php echo form_close(); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_e_details_baccount');?> </span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <div class="table-responsive" data-pattern="priority-columns">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_contract" style="width:100%;">
                              <thead>
                                <tr>
                                  <th>No. Dokumen</th>
                                  <th>Project</th>
                                  <th>Jabatan</th>
                                  <th>Status</th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="account-docpkwt">

                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> DOKUMEN PKWT </span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <div class="table-responsive" data-pattern="priority-columns">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_contract" style="width:100%;">
                              <thead>
                                <tr>
                                  <th>No. Dokumen</th>
                                  <th>Project</th>
                                  <th>Jabatan</th>
                                  <th>Status</th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>


                  <!-- DOKUMEN FOTO-->
                  <div class="tab-pane fade" id="account-document">
                   <div class="box" hidden>
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

                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> DOKUMEN </strong> PRIBADI </span> </div>
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

                        <input name="user_id" type="text" value="<?php echo $user_id;?>" hidden>
                        <input name="employee_id" type="text" value="<?php echo $employee_id;?>" hidden>
                        <input name="nomor_ktp" type="text" value="<?php echo $ktp_no;?>" hidden>
                        <input name="kk_no" type="text" value="<?php echo $kk_no;?>" hidden>
                        <input name="npwp_no" type="text" value="<?php echo $npwp_no;?>" hidden>
                        
                        <input name="ffoto_ktp" type="text" value="<?php echo $filename_ktp;?>" hidden>
                        <input name="ffoto_kk" type="text" value="<?php echo $filename_kk;?>" hidden>
                        <input name="ffoto_npwp" type="text" value="<?php echo $filename_npwp;?>" hidden>
                        <input name="ffile_cv" type="text" value="<?php echo $filename_cv;?>" hidden>
                        <input name="ffile_skck" type="text" value="<?php echo $filename_skck;?>" hidden>
                        <input name="ffile_isd" type="text" value="<?php echo $filename_isd;?>" hidden>
                        <input name="ffile_pak" type="text" value="<?php echo $filename_paklaring;?>" hidden>
                        <input name="ffile_pkwt" type="text" value="<?php echo $filename_pkwt;?>" hidden>


                      <!-- KTP -->
                      <div class="row">
                        <div class="col-md-5">
                          <div class="form-group">
                            <fieldset class="form-group">
                              <label for="logo">Foto KTP</label>
                              <input type="file" class="form-control-file" id="document_file" name="document_file" accept="image/png,image/jpg, image/jpeg">
                              <small>Jenis Foto: png, jpg, dan jpeg | Size MAX 2 MB</small>
                            </fieldset>
                          </div>
                        </div>
                        <div class="col-md-4" hidden>
                          <div class="form-group">
                            <label for="nomor_ktp" class="control-label"><?php echo $this->lang->line('xin_ktp');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="Nomor Kartu Tanda Penduduk" name="nomor_ktp" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="16" value="<?php echo $ktp_no;?>">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <div class="card-body media align-items-center"> 
                                <a href="<?php echo base_url().'uploads/document/ktp/'.$filename_ktp;?>" target="_blank"><?php echo $filename_ktp; ?></a>
                              <div class="media-body ml-4"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- KK -->
                      <div class="row">
                        <div class="col-md-5">
                          <div class="form-group">
                            <fieldset class="form-group">
                              <label for="logo">Foto KK </label>
                              <input type="file" class="form-control-file" id="document_file_kk" name="document_file_kk" accept="image/png,image/jpg, image/jpeg">
                              <small>Jenis Foto: png, jpg, dan jpeg | Size MAX 2 MB</small>
                            </fieldset>
                          </div>
                        </div>
                        <div class="col-md-4" hidden>
                          <div class="form-group">
                            <label for="title" class="control-label"><?php echo $this->lang->line('xin_kk');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="Nomor Kartu Keluarga" name="kk_no" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="16" value="<?php echo $kk_no;?>">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <div class="card-body media align-items-center"> 
                                <a href="<?php echo base_url().'uploads/document/kk/'.$filename_kk;?>" target="_blank"><?php echo $filename_kk; ?></a>
                              <div class="media-body ml-4"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- NPWP -->
                      <div class="row">
                        <div class="col-md-5">
                          <div class="form-group">
                            <fieldset class="form-group">
                              <label for="logo">Foto NPWP </label>
                              <input type="file" class="form-control-file" id="document_file_npwp" name="document_file_npwp" accept="image/png,image/jpg, image/jpeg">
                              <small>Jenis Foto: png, jpg, dan jpeg | Size MAX 2 MB</small>
                            </fieldset>
                          </div>
                        </div>
                        <div class="col-md-4" hidden>
                          <div class="form-group">
                            <label for="title" class="control-label"><?php echo $this->lang->line('xin_npwp');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="Nomor Pokok Wajib Pajak" name="npwp_no" type="text" maxlength="25" value="<?php echo $npwp_no;?>">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <div class="card-body media align-items-center"> 
                                <a href="<?php echo base_url().'uploads/document/npwp/'.$filename_npwp;?>" target="_blank"><?php echo $filename_npwp; ?></a>
                              <div class="media-body ml-4"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- CV -->
                      <div class="row">
                        <div class="col-md-5">
                          <div class="form-group">
                            <fieldset class="form-group">
                              <label for="logo">CV / Riwayat Hidup</label>
                              <input type="file" class="form-control-file" id="document_file_cv" name="document_file_cv" accept="application/pdf">
                              <small>Jenis File: PDF | Size MAX 2 MB</small>
                            </fieldset>
                          </div>
                        </div>
                        <div class="col-md-4">
          
                          <div class="form-group">
                            <div class="card-body media align-items-center"> 
                                <a href="<?php echo $filename_cv;?>" target="_blank"><?php echo $filename_cv; ?></a>
                              <div class="media-body ml-4"></div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                        </div>
                      </div>

                      <!-- SKCK -->
                      <div class="row">
                        <div class="col-md-5">
                          <div class="form-group">
                            <fieldset class="form-group">
                              <label for="logo">SKCK POLRI</label>
                              <input type="file" class="form-control-file" id="document_file_skck" name="document_file_skck" accept="application/pdf">
                              <small>Jenis File: PDF | Size MAX 2 MB</small>
                            </fieldset>
                          </div>
                        </div>
                        <div class="col-md-4">
          
                          <div class="form-group">
                            <div class="card-body media align-items-center"> 
                                <a href="<?php echo base_url().'uploads/document/skck/'.$filename_skck;?>" target="_blank"><?php echo $filename_skck; ?></a>
                              <div class="media-body ml-4"></div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                        </div>
                      </div>

                      <!-- IJAZAH SD -->
                      <div class="row">
                        <div class="col-md-5">
                          <div class="form-group">
                            <fieldset class="form-group">
                              <label for="logo">IJAZAH TERAKHIR</label>
                              <input type="file" class="form-control-file" id="document_file_isd" name="document_file_isd" accept="application/pdf">
                              <small>Jenis File: PDF | Size MAX 2 MB</small>
                            </fieldset>
                          </div>
                        </div>
                        <div class="col-md-4">
        
                          <div class="form-group">
                            <div class="card-body media align-items-center"> 
                                <a href="<?php echo base_url().'uploads/document/ijazah/'.$filename_isd;?>" target="_blank"><?php echo $filename_isd; ?></a>
                              <div class="media-body ml-4"></div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                        </div>
                      </div>
                      
                      <!-- PAKLARING -->
                      <div class="row">
                        <div class="col-md-5">
                          <div class="form-group">
                            <fieldset class="form-group">
                              <label for="logo">PAKLARING</label>
                              <input type="file" class="form-control-file" id="document_file_pak" name="document_file_pak" accept="application/pdf">
                              <small>Jenis File: PDF | Size MAX 2 MB</small>
                            </fieldset>
                          </div>
                        </div>
                        <div class="col-md-4">
        
                          <div class="form-group">
                            <div class="card-body media align-items-center"> 
                                <a href="<?php echo base_url().'uploads/document/paklaring/'.$filename_paklaring;?>" target="_blank"><?php echo $filename_paklaring; ?></a>
                              <div class="media-body ml-4"></div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                        </div>
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

                  <!-- REKENING -->
                  <div class="tab-pane fade" id="account-baccount">
                    <div class="box md-4">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong>REKENING</strong>  BANK</span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <?php $attributes = array('name' => 'bank_account_info', 'id' => 'bank_account_info', 'autocomplete' => 'off');?>
                          <?php $hidden = array('u_rekening_info' => 'UPDATE');?>
                          <?php echo form_open('admin/profile/bank_account_info/', $attributes, $hidden);?>
                          <?php
                              $data_usr10 = array(
                                    'type'  => 'hidden',
                                    'name'  => 'user_id',
                                    'value' => $session['user_id'],
                             );
                            echo form_input($data_usr10);
                            ?>

                        <input name="user_id" type="text" value="<?php echo $user_id;?>" hidden>
                        <input name="ffoto_rek" type="text" value="<?php echo $filename_rek;?>" hidden>

                      <!-- REKENING -->
                      <div class="row">
                        <div class="col-md-5">
                          <div class="form-group">
                            <label for="no_rek" class="control-label"><?php echo $this->lang->line('xin_e_details_acc_number');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="Nomor Rekening Bank" name="no_rek" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="16" value="<?php echo $nomor_rek;?>">
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">

                            <fieldset class="form-group">
                              <label for="logo">Foto Rekening (Buku/E-Banking/Mobile-Banking)</label>
                              <input type="file" class="form-control-file" id="docfile_rek" name="docfile_rek" accept="image/png,image/jpg, image/jpeg">
                              <small>Jenis Foto: png, jpg, dan jpeg | Size MAX 2 MB</small>
                            </fieldset>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="form-group">
                            <div class="card-body media align-items-center"> 
                              <a href="<?php echo base_url().'uploads/document/rekening/'.$filename_rek;?>" target="_blank"><?php echo $filename_rek; ?></a>
                              <div class="media-body ml-4"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                          <div class="row">
                          <div class="col-md-5">
                            <div class="form-group">
                              <label for="bank_name"><?php echo $this->lang->line('xin_e_details_bank_name');?><i class="hrpremium-asterisk">*</i></label>
                              <select name="bank_name" id="bank_name" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_bank_choose_name');?>">
                                <option value=""></option>
                                <?php 
                                foreach ( $list_bank as $bank ) { 
                                ?>
                                  <option value="<?php echo $bank->secid;?>" <?php if($bank_name==$bank->secid):?> selected <?php endif; ?>> <?php echo $bank->bank_name;?></option>
                                <?php 
                                } 
                                ?>                                 
                              </select>
                            </div>
                          </div>
                          </div>

                          <div class="row">
                            <div class="col-md-5">
                              <div class="form-group">
                                <label for="account_title">Nama Pemilik Rekening</label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_acc_title');?>" name="pemilik_rek" type="text" value="<?php echo $pemilik_rek;?>">
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="far fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                              </div>
                            </div>

                            <?php echo form_close(); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="box" hidden>
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_e_details_baccount');?> </span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <div class="table-responsive" data-pattern="priority-columns">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_baccount" style="width:100%;">
                              <thead>
                                <tr>
                                  <th><?php echo $this->lang->line('xin_action');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_acc_title');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_acc_number');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_bank_name');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_bank_code');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_bank_branch');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- PK GAJI -->
                  <div class="tab-pane fade" id="account-salary">
                    <div class="box" hidden>
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_e_details_documents');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_gaji" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('xin_e_details_dtype');?></th>
                                <th><?php echo $this->lang->line('xin_employee_document_number');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>s
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> PAKET </strong> GAJI </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'salary_info', 'id' => 'salary_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open_multipart('admin/employees/salary_info', $attributes, $hidden);?>
                      <?php
                      $data_usr2 = array(
                        'type'  => 'hidden',
                        'name'  => 'user_id',
                        'value' => $user_id,
                       );
                      echo form_input($data_usr2);
                      ?>


                            <input name="user_id" type="text" value="<?php echo $user_id;?>" hidden>
                            <!-- ROW 1 -->
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="form-label control-label">Gaji Pokok</label>
                                  <input class="form-control" placeholder="0" name="gaji_pokok" type="text" value="<?php echo $basic_salary;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="form-label control-label">Tunjangan Jabatan</label>
                                  <input class="form-control" placeholder="0" name="allow_jabatan" type="text" value="<?php echo $allow_jabatan;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="form-label">Tunjangan Area</label>
                                  <input class="form-control" placeholder="0" name="allow_area" type="text" value="<?php echo $allow_area;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                              </div>

                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="form-label">Tunjangan Masa Kerja</label>
                                  <input class="form-control" placeholder="0" name="allow_masa_kerja" type="text" value="<?php echo $allow_masakerja;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                              </div>
                            </div>

                            <!-- ROW 2 -->
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="form-label control-label">Tunjangan Makan & Transport</label>
                                  <input class="form-control" placeholder="0" name="allow_trans_meal" type="text" value="<?php echo $allow_trans_meal;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="form-label control-label">Tunjangan Makan</label>
                                  <input class="form-control" placeholder="0" name="allow_meal" type="text" value="<?php echo $allow_konsumsi;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="form-label">Tunjangan Transport</label>
                                  <input class="form-control" placeholder="0" name="allow_trans" type="text" value="<?php echo $allow_transport;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                              </div>

                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="form-label">Tunjangan Komunikasi</label>
                                  <input class="form-control" placeholder="0" name="allow_comunication" type="text" value="<?php echo $allow_comunication;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                              </div>
                            </div>

                            <!-- ROW 3 -->
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="form-label control-label">Tunjangan Laptop/HP</label>
                                  <input class="form-control" placeholder="0" name="allow_device" type="text" value="<?php echo $allow_device;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="form-label control-label">Tunjangan Tempat Tinggal</label>
                                  <input class="form-control" placeholder="0" name="tunjangan_tempat_tinggal" type="text" value="<?php echo $allow_residence_cost;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="form-label">Tunjangan Rental</label>
                                  <input class="form-control" placeholder="0" name="allow_rent" type="text" value="<?php echo $allow_rent;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                              </div>

                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="form-label">Tunjangan Parkir</label>
                                  <input class="form-control" placeholder="0" name="allow_parking" type="text" value="<?php echo $allow_parking;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                              </div>
                            </div>

                            <!-- ROW 4 -->
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="form-label control-label">Tunjangan Kesehatan</label>
                                  <input class="form-control" placeholder="0" name="allow_medicine" type="text" value="<?php echo $allow_medichine;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="form-label control-label">Tunjangan Akomodasi</label>
                                  <input class="form-control" placeholder="0" name="allow_akomodasi" type="text" value="<?php echo $allow_akomodsasi;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="form-label">Tunjangan Kasir</label>
                                  <input class="form-control" placeholder="0" name="allow_kasir" type="text" value="<?php echo $allow_kasir;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                              </div>

                              <div class="col-md-3">
                                <div class="form-group">
                                  <label class="form-label">Tunjangan Operational</label>
                                  <input class="form-control" placeholder="0" name="allow_operation" type="text" value="<?php echo $allow_operational;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </div>
                              </div>
                            </div>


                            <div class="row">
                              <!--PERUSAHAAN-->


                              <!--TANGGAL MULAI KONTRAK-->
                              <div class="col-md-3">
                                <div class="form-group">
                                <label for="pkwt_join_date">Tanggal Mulai Kontrak<i class="hrpremium-asterisk">*</i></label>
                                <input class="form-control date" readonly placeholder="YYYY-MM-DD" name="join_date_pkwt" type="text" value="<?php echo $contract_start;?>">
                                </div>
                              </div>

                              <!--TANGGAL AKHIR KONTRAK-->
                              <div class="col-md-3">
                                <div class="form-group">
                                <label for="pkwt_end_date">Tanggal Akhir Kontrak<i class="hrpremium-asterisk">*</i></label>
                                <input class="form-control date" readonly placeholder="YYYY-MM-DD" name="pkwt_end_date" type="text" value="<?php echo $contract_end;?>">
                                </div>
                              </div>
                            </div>


                          <div class="row">
                            <!--PERIODE KONTRAK-->
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="waktu_kontrak">Waktu Kontrak<i class="hrpremium-asterisk">*</i></label>
                                <select class="form-control" name="waktu_kontrak" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_e_details_office_location');?>">
                                  <option value="1" <?php if($contract_periode=='1'):?> selected <?php endif; ?>>1 (Bulan)</option>
                                  <option value="3" <?php if($contract_periode=='3'):?> selected <?php endif; ?>>3 (Bulan)</option>
                                  <option value="6" <?php if($contract_periode=='6'):?> selected <?php endif; ?>>6 (Bulan)</option>
                                  <option value="12" <?php if($contract_periode=='12'):?> selected <?php endif; ?>>12 (Bulan)</option>
                                </select>
                              </div>
                            </div>

                            <!-- HK -->
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="hari_kerja">Hari Kerja<i class="hrpremium-asterisk">*</i></label>
                                <input class="form-control" placeholder="0" name="hari_kerja" type="text" value="<?php echo $hari_kerja;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2">
                              </div>
                            </div>
                          </div>

                            <!-- ROW 7 -->
                            <div class="row">
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label class="form-label control-label">Tanggal CUT-START</label>
                                  <input class="form-control" placeholder="0" name="cut_start" type="text" value="<?php echo $cut_start;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2">
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label class="form-label control-label">Tanggal CUT-OFF</label>                    
                                  <input class="form-control" placeholder="0" name="cut_off" type="text" value="<?php echo $cut_off;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2">
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label class="form-label">Tanggal Penggajian</label><input class="form-control" placeholder="0" name="date_payment" type="text" value="<?php echo $date_payment;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2">
                                </div>
                              </div>

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

                  <?php if($system[0]->employee_manage_own_work_experience=='yes'){?>
                  <div class="tab-pane fade" id="account-experience">
                    <div class="box md-4">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_e_details_w_experience');?> </span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <?php $attributes = array('name' => 'work_experience_info', 'id' => 'work_experience_info', 'autocomplete' => 'off');?>
                          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                          <?php echo form_open('admin/employees/work_experience_info/', $attributes, $hidden);?>
                          <?php
                              $data_usr9 = array(
                                    'type'  => 'hidden',
                                    'name'  => 'user_id',
                                    'value' => $session['user_id'],
                             );
                            echo form_input($data_usr9);
                            ?>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="company_name"><?php echo $this->lang->line('xin_company_name');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_company_name');?>" name="company_name" type="text" value="" id="company_name">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="post"><?php echo $this->lang->line('xin_e_details_post');?></label>
                                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_post');?>" name="post" type="text" value="" id="post">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="from_year" class="control-label"><?php echo $this->lang->line('xin_e_details_timeperiod');?></label>
                                <div class="row">
                                  <div class="col-md-6">
                                    <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('xin_e_details_from');?>" name="from_date" type="text">
                                  </div>
                                  <div class="col-md-6">
                                    <input class="form-control date" readonly="readonly" placeholder="<?php echo $this->lang->line('dashboard_to');?>" name="to_date" type="text">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="description"><?php echo $this->lang->line('xin_description');?></label>
                                <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" data-show-counter="1" data-limit="300" name="description" cols="30" rows="4" id="description"></textarea>
                                <span class="countdown"></span> </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="far fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                              </div>
                            </div>
                            <?php echo form_close(); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_e_details_w_experience');?> </span> </div>
                      <div class="card-body">
                        <div class="card-block">
                          <div class="table-responsive" data-pattern="priority-columns">
                            <table class="table table-striped table-bordered dataTable" id="xin_table_work_experience" style="width:100%;">
                              <thead>
                                <tr>
                                  <th><?php echo $this->lang->line('xin_action');?></th>
                                  <th><?php echo $this->lang->line('xin_company_name');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_frm_date');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_to_date');?></th>
                                  <th><?php echo $this->lang->line('xin_e_details_post');?></th>
                                  <th><?php echo $this->lang->line('xin_description');?></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>

                  <!-- PASSWORD -->
                  <div class="tab-pane fade" id="account-cpassword">

                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> UBAH </strong> PIN </span> </div>
                    <div class="card-body pb-2">
                      <div class="box">
                        <div class="box-body">
                          <div class="card-block">
                            <?php $attributes = array('name' => 'e_change_password', 'id' => 'e_change_password', 'autocomplete' => 'off');?>
                            <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                            <?php echo form_open('admin/employees/change_password/', $attributes, $hidden);?>
                            <?php
                              $data_usr11 = array(
                                    'type'  => 'hidden',
                                    'name'  => 'user_id',
                                    'value' => $session['user_id'],
                             );
                            echo form_input($data_usr11);
                            ?>
                            <?php if($this->input->get('change_password')):?>
                            <input type="hidden" id="change_pass" value="<?php echo $this->input->get('change_password');?>" />
                            <?php endif;?>
                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="old_password"><?php echo $this->lang->line('xin_old_password');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_old_password');?>" name="old_password" type="password">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="new_password"><?php echo $this->lang->line('xin_e_details_enpassword');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_enpassword');?>" name="new_password" type="password">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="new_password_confirm" class="control-label"><?php echo $this->lang->line('xin_e_details_ecnpassword');?></label>
                                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_e_details_ecnpassword');?>" name="new_password_confirm" type="password">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="far fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                                </div>
                              </div>
                            </div>
                            <?php echo form_close(); ?> </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- DEACTIVE-->
                  <div class="tab-pane fade" id="account-deactive">
                    <div class="box" hidden>
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> ACTIVE / </strong> DEACTIVE</span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_deactive" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('xin_e_details_dtype');?></th>
                                <th><?php echo $this->lang->line('xin_employee_document_number');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>s
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> ACTIVE / </strong> DEACTIVE </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'deactive_info', 'id' => 'deactive_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_basic_info' => 'UPDATE');?>
                      <?php echo form_open_multipart('admin/employees/deactive_info', $attributes, $hidden);?>
                      <?php
                      $data_usr2 = array(
                        'type'  => 'hidden',
                        'name'  => 'user_id',
                        'value' => $user_id,
                       );
                      echo form_input($data_usr2);
                      ?>


                        <input name="user_id" type="text" value="<?php echo $user_id;?>" hidden>
                        <input name="session_by" type="text" value="<?php echo $session['user_id'];?>" hidden>


                        <div class="row">
                          <!--rule-->

                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="title">NIP <i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title">: <?php echo $employee_id;?></label>
                            </div>
                          </div>

                        </div>


                        <div class="row">
                          <!--rule-->

                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="title">Nama Lengkap</label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title">: <?php echo $first_name;?></label>
                            </div>
                          </div>

                        </div>

                        <div class="row">
                          <!--rule-->

                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="title">Status Karyawan <i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title">: <?php echo $status_deactive;?><i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>

                        </div>

                        <div class="row">
                          <!--rule-->

                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="title">Deactive By <i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title">: <?php echo $name_by_deactive;?><i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>

                        </div>

                        <div class="row">
                          <!--rule-->

                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="title">Deactive Date <i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title">: <?php echo $deactive_date;?><i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>

                        </div>

                        <div class="row">
                          <!--rule-->

                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="title">Deactive Reason <i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title">: <?php echo $deactive_reason;?><i class="hrpremium-asterisk"></i></label>
                            </div>
                          </div>

                        </div>

                        <br><br>
                        <div class="row">
                          <!--rule-->

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="bpjstk_confirm">Status</label>
                              <select class="form-control" name="status_employee" data-plugin="select_hrm" data-placeholder="active or deactive">
                                <option value=""></option>
                                <option value="1" <?php if($status_employee == 1):?> selected="selected"<?php endif;?>>ACTIVE</option>
                                <option value="0" <?php if($status_employee == 0):?> selected="selected"<?php endif;?>>DEACTIVE</option>
                              </select>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="bpjstk_confirm">Kategori</label>
                              <select class="form-control" name="head_reason" data-plugin="select_hrm" data-placeholder="Kategori">
                                <option value=""></option>
                                <option value="[RESIGN]">RESIGN</option>
                                <option value="[END CONTRACT]">END CONTRACT</option>
                                <option value="[BLACKLIST]">BLACKLIST</option>
                              </select>
                            </div>
                          </div>

                        </div>

                        <div class="row">
                          <!--rule-->

                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="tanggal_bergabung" class="control-label">Tanggal Resign</label>
                                  <input class="form-control date" readonly="readonly" placeholder="Date of Resign" name="tanggal_resign" type="text" value="<?php echo $date_of_leaving;?>">
                                </div>
                              </div>
                            
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="title">Keterangan Deactive<i class="hrpremium-asterisk">*</i></label>
                              <textarea class="form-control" placeholder="isi alasan/keterangan deactive" name="keterangan_deactive" type="textarea" value="<?php echo $bpjs_ks_no;?>" id="title"></textarea>
                            </div>
                          </div>


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
                <!-- end row -->

                </div>
              <!-- </div> -->
            <!-- </div> -->
          <!-- </div> -->


 

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


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