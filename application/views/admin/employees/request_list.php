<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $count_emp_request_cancel = $this->Xin_model->count_emp_request_cancel($session['employee_id']);?>
<?php $count_emp_request_nae = $this->Xin_model->count_emp_request_nae($session['employee_id']);?>
<?php $count_emp_request_nom = $this->Xin_model->count_emp_request_nom($session['employee_id']);?>
<?php $count_emp_request_hrd = $this->Xin_model->count_emp_request_hrd($session['employee_id']);?>



<?php //$list_bank = $this->Xin_model->get_bank_code();?>
<!-- $data['list_bank'] = $this->Xin_model->get_bank_code(); -->

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">

    <?php if(in_array('337',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/employee_request/');?>" data-link-data="<?php echo site_url('admin/employee_request/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon fa fa-database"></span>AREA
      </a> </li>
    <?php } ?>  

    <?php if(in_array('378',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_request_hrd/');?>" data-link-data="<?php echo site_url('admin/employee_request_hrd/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span>KARYAWAN BARU<?php echo '('.$count_emp_request_hrd.')';?>
      </a> </li>
    <?php } ?>

    <?php if(in_array('338',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/Employee_request_cancelled/');?>" data-link-data="<?php echo site_url('admin/Employee_request_cancelled/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span>DITOLAK<?php echo '('.$count_emp_request_cancel.')';?>
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
        <?php echo form_open_multipart('admin/employee_request/request_add_employee', $attributes, $hidden);?>
        <div class="form-body">

          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <input name="employee_id" type="hidden" value="<?php echo $employee_id;?>">

                <!--NAMA LENGKAP-->
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="fullname"><?php echo $this->lang->line('xin_employees_full_name');?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employees_full_name');?>" name="fullname" type="text" value="">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nama_ibu">Nama Ibu<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="Nama Ibu" name="nama_ibu" type="text" value="">
                  </div>
                </div>
              </div>

              <div class="row">

                <!--TEMPAT LAHIR-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_hp" class="control-label">Tempat Lahir<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="Tempat Lahir" name="tempat_lahir" type="text" value="">
                  </div>
                </div>

                <!--TANGGAL LAHIR-->
                <div class="col-md-4">
                  <div class="form-group">
                  <label for="date_of_birth">Tanggal Lahir<i class="hrpremium-asterisk">*</i></label>
                  <input class="form-control date" readonly placeholder="Tanggal Lahir" name="date_of_birth" type="text" value="">
                  </div>
                </div>


              </div>

              <div class="row">

                <!--JENIS KELAMIN-->
                <div class="col-md-4">
                  <div class="form-group">
                                  <label class="form-label control-label"><?php echo $this->lang->line('xin_employee_gender');?>*</label>
                                  <select class="form-control" name="gender" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_employee_gender');?>">
                                    <option value="">Jenis Kelamin</option>
                                    <option value="L"><?php echo $this->lang->line('xin_gender_male');?></option>
                                    <option value="P"><?php echo $this->lang->line('xin_gender_female');?></option>
                                  </select>
                  </div>
                </div>

                <!--AGAMA-->
                <div class="col-md-4">
                  <div class="form-group">
                                  <label class="form-label control-label">Agama/Kepercayaan*</label>

                                  <select class="form-control" name="ethnicity" data-plugin="xin_select" data-placeholder="Agama/Kepercayaan">
                                  <option value="">Agama/Kepercayaan</option>
                                              <?php foreach($all_ethnicity as $eth):?>
                                              <option value="<?php echo $eth->ethnicity_type_id;?>"><?php echo $eth->type;?></option>
                                              <?php endforeach;?>
                                  </select>
                  </div>
                </div>

                <!--STATUS PERKAWINAN-->
                <div class="col-md-4">
                  <div class="form-group">
                                  <label class="form-label control-label"><?php echo $this->lang->line('xin_employee_mstatus');?>*</label>

                                  <select class="form-control" name="marital_status" data-plugin="xin_select" data-placeholder="Status Perkawinan">
                                  <option value="">Status Perkawinan</option>
                                              <option value="TK/0">Belum Menikah</option>
                                              <option value="K/0">Menikah (0 Anak)</option>
                                              <option value="K/1">Menikah (1 Anak)</option>
                                              <option value="K/2">Menikah (2 Anak)</option>
                                              <option value="K/3">Menikah (3 Anak)</option>
                                              <option value="TK/0">Janda/Duda (0 Anak)</option>
                                              <option value="TK/1">Janda/Duda (1 Anak)</option>
                                              <option value="TK/2">Janda/Duda (2 Anak)</option>
                                              <option value="TK/3">Janda/Duda (3 Anak)</option>
                                              
                                </select>
                  </div>
                </div>

              </div>

              <div class="row">
                <!--NO KP-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_ktp" class="control-label">Nomor KTP<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="Nomor KTP" name="nomor_ktp" type="text" value="" maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--ALAMAT SESUAI KTP-->
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="alamat_ktp"><?php echo $this->lang->line('xin_address_1');?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="alamat_ktp" type="text" value="">
                  </div>
                </div>

              </div>

              <div class="row">

                <!--NOMOR KK-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_kk" class="control-label">Nomor KK<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="Nomor KK" name="nomor_kk" type="text" value="" maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--ALAMAT DOMISILI-->
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="alamat_domisili">Alamat Domisili</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="alamat_domisili" type="text" value="">
                  </div>
                </div>

              </div>

              <div class="row">

                <!--NPWP-->
                <div class="col-md-4">
                  <div class="form-group">
                  <label for="npwp">NPWP<i class="hrpremium-asterisk"></i></label>
                  <input class="form-control" placeholder="NPWP" name="npwp" type="text" value="">
                  </div>
                </div>

                <!--NO HP-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_hp" class="control-label">Nomor HP/Whatsapp<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="08xxxxxx" name="nomor_hp" type="text" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--EMAIL-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="email" class="control-label">Email<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="example@mail.com" name="email" type="text" value="">
                  </div>
                </div>

              </div>


              <div class="row">

                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="bank_name"><?php echo $this->lang->line('xin_e_details_bank_name');?><i class="hrpremium-asterisk">*</i></label>
                              <select name="bank_name" id="bank_name" class="form-control" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_bank_choose_name');?>">
                                <option value=""></option>
                                <?php 
                                foreach ( $list_bank as $bank ) { 
                                ?>
                                  <option value="<?php echo $bank->secid;?>"> <?php echo $bank->bank_name;?></option>
                                <?php 
                                } 
                                ?>                                 
                              </select>
                            </div>
                          </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="no_rek" class="control-label"><?php echo $this->lang->line('xin_e_details_acc_number');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="Nomor Rekening Bank" name="no_rek" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="16" value="">
                          </div>
                        </div>

                <!--PEMILIK REKENING-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="email" class="control-label">Pemilik Rekening<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="Nama Pemilik Rekening" name="pemilik_rekening" type="text" value="">
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

              <div class="row">

                <!--TANGGAL JOIN-->
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="date_of_join"><?php echo $this->lang->line('xin_employee_doj');?><i class="hrpremium-asterisk">*</i></label>
                  <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('xin_employee_doj');?>" name="date_of_join" type="text" value="">
                  </div>
                </div>

                <!-- PENEMPATAN -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="penempatan"><?php echo $this->lang->line('xin_placement_area');?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_placement_area');?>" name="penempatan" type="text" value="">
                  </div>
                </div>

              </div>
            <!-- end row -->
            </div>
          </div>


<!--  --> <br><span class="card-header-title mr-2"><strong>UPLOAD </strong>DOKUMEN & FOTO</span><hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;"><br>

                      <!-- KTP -->
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <fieldset class="form-group">
                              <label for="logo">Foto KTP<strong></strong></label>
                              <input type="file" class="form-control-file" id="document_file" name="document_file" accept="image/png,image/jpg, image/jpeg">
                              <small>Jenis Foto: png, jpg, dan jpeg | Size MAX 2 MB</small>
                            </fieldset>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="form-group">
                            <fieldset class="form-group">
                              <label for="logo">Foto KK<strong></strong></label>
                              <input type="file" class="form-control-file" id="document_kk" name="document_kk" accept="image/png,image/jpg, image/jpeg">
                              <small>Jenis Foto: png, jpg, dan jpeg | Size MAX 2 MB</small>
                            </fieldset>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="form-group">
                            <fieldset class="form-group">
                              <label for="logo">IJAZAH Terakhir<strong></strong></label>
                              <input type="file" class="form-control-file" id="document_ijz" name="document_ijz" accept="image/png,image/jpg, image/jpeg">
                              <small>Jenis Foto: png, jpg, dan jpeg | Size MAX 2 MB</small>
                            </fieldset>
                          </div>
                        </div>
                      </div>
<br>
                      <!-- CV -->
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <fieldset class="form-group">
                              <label for="logo">Riwayat Hidup (CV)<strong></strong></label>
                              <input type="file" class="form-control-file" id="document_cv" name="document_cv" accept="application/pdf">
                              <small>Jenis File: PDF | Size MAX 2 MB</small>
                            </fieldset>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="form-group">
                            <fieldset class="form-group">
                              <label for="logo">SKCK<strong></strong></label>
                              <input type="file" class="form-control-file" id="document_skck" name="document_skck" accept="application/pdf">
                              <small>Jenis File: PDF | Size MAX 2 MB</small>
                            </fieldset>
                          </div>
                        </div>
                        
                        <div class="col-md-3">
                          <div class="form-group">
                            <fieldset class="form-group">
                              <label for="logo">Surat Keterangan Kerja (PAKLARING)<strong></strong></label>
                              <input type="file" class="form-control-file" id="document_pkl" name="document_pkl" accept="application/pdf">
                              <small>Jenis File: PDF | Size MAX 2 MB</small>
                            </fieldset>
                          </div>
                        </div>

                      </div>

<!--  --> <br><span class="card-header-title mr-2"><strong>PAKET GAJI</strong> KARYAWAN</span><hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;"><br>
          <div class="row">
            <div class="col-md-8">
              <div class="row">

                <!--GAJI POKOK-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="gaji_pokok">Gaji Pokok<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="gaji_pokok" type="text" value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN JABATAN-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_jabatan" class="control-label">Tunjangan Jabatan<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_jabatan" type="text" value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN AREA-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_area" class="control-label">Tunjangan Area<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_area" type="text" value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN MASA KERJA-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_masakerja">Tunjangan Masa Kerja<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_masakerja" type="text" value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>
              </div>

              <div class="row">


                <!--TUNJANGAN MAKAN TRANSPORT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_makan_trans" class="control-label">Tunjangan Makan & Transport<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_makan_trans" type="text" value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN MAKAN-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_makan" class="control-label">Tunjangan Makan<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_makan" type="text" value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN TRANSPORT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_transport" class="control-label">Tunjangan Transport<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_transport" type="text" value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN KOMUNIKASI-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_komunikasi" class="control-label">Tunjangan Komunikasi<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_komunikasi" type="text" value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>
              </div>

              <div class="row">


                <!--TUNJANGAN DEVICE-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_device" class="control-label">Tunjangan Laptop/HP<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_device" type="text" value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN TEMPAT TINGGAL-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_tempat_tinggal">Tunjangan Tempat Tinggal<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_tempat_tinggal" type="text" value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN RENTAL-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_rental">Tunjangan Rental<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_rental" type="text" value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN PARKIR-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_parkir" class="control-label">Tunjangan Parkir<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_parkir" type="text" value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>
              </div>

              <div class="row">


                <!--TUNJANGAN KESEHATAN-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_kesehatan" class="control-label">Tunjangan Kesehatan<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_kesehatan" type="text" value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>


                <!--TUNJANGAN AKOMODASI-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_akomodasi">Tunjangan Akomodasi<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_akomodasi" type="text" value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN KASIR-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_kasir" class="control-label">Tunjangan Kasir<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_kasir" type="text" value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN OPERATIONAL-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_operational" class="control-label">Tunjangan Operational<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_operational" type="text" value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>
              </div>
              

            </div>

            <div class="col-md-4">
              <div class="row">
                <!--PERUSAHAAN-->


                <!--TANGGAL MULAI KONTRAK-->
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="pkwt_join_date">Tanggal Mulai Kontrak<i class="hrpremium-asterisk">*</i></label>
                  <input class="form-control date" readonly placeholder="YYYY-MM-DD" name="join_date_pkwt" type="text" value="">
                  </div>
                </div>

                <!--TANGGAL AKHIR KONTRAK-->
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="pkwt_end_date">Tanggal Akhir Kontrak<i class="hrpremium-asterisk">*</i></label>
                  <input class="form-control date" readonly placeholder="YYYY-MM-DD" name="pkwt_end_date" type="text" value="">
                  </div>
                </div>

              </div>

              <div class="row">
                <!--PERIODE KONTRAK-->
                <div class="col-md-6">
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

                <!-- HK -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="hari_kerja">Hari Kerja<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="hari_kerja" type="text" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2">
                  </div>
                </div>
              </div>

              <div class="row">
                <!--PERIODE KONTRAK-->
                <div class="col-md-4">
                  <div class="form-group">                                  
                    <label class="form-label control-label">Tanggal CUT-START</label>
                                  <input class="form-control" placeholder="0" name="cut_start" type="text" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2">
                                
                  </div>
                </div>

                <!-- HK -->
                <div class="col-md-4">                                
                  <div class="form-group">
                                  <label class="form-label control-label">Tanggal CUT-OFF</label>                    
                                  <input class="form-control" placeholder="0" name="cut_off" type="text" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2">
                                </div>
                </div>

                <!-- HK -->
                <div class="col-md-4">                                
                  <div class="form-group">
                                  <label class="form-label">Tanggal Penggajian</label><input class="form-control" placeholder="0" name="date_payment" type="text" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2">
                                </div>
                </div>

              </div>


            <!-- end row -->
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
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_companies');?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th>No.</th>
            <th><?php echo $this->lang->line('xin_request_employee_status');?></th>
            <th>NIK-KTP</th>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_employees_full_name');?></th>
            <th><?php echo $this->lang->line('left_projects');?></th>
            <th><?php echo $this->lang->line('left_sub_projects');?></th>
            <th><?php echo $this->lang->line('left_department');?></th>
            <th><?php echo $this->lang->line('left_designation');?></th>
            <th><?php echo $this->lang->line('xin_placement');?></th>
            <th><?php echo $this->lang->line('xin_employee_doj');?></th>
            <th><?php echo $this->lang->line('xin_e_details_contact');?></th>
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
