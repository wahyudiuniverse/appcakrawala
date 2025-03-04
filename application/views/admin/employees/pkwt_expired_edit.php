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

<hr class="border-light m-0 mb-3">
<?php $employee_id = $this->Xin_model->generate_random_employeeid();?>
<?php $employee_pincode = $this->Xin_model->generate_random_pincode();?>

<?php if(in_array('337',$role_resources_ids)) {?>

<div class="card mb-4">
  <!-- <div id="accordion"> -->
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>UBAH DATA </strong> PERMINTAAN KARYAWAx</span>
      <div class="card-header-elements ml-md-auto"> </div>
    </div>
    <div id="add_form" class="add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_employee', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/Employees/pkwt_expired_save', $attributes, $hidden);?>
        <div class="form-body">

          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <input name="idrequest" type="hidden" value="<?php echo $employee_id;?>">

                <!--NAMA LENGKAP-->
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="fullname"><?php echo $this->lang->line('xin_employees_full_name');?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employees_full_name');?>" name="fullname" type="text" value="<?php echo $fullname; ?>">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nama_ibu">Nama Ibu<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="Nama Ibu" name="nama_ibu" type="text" value="<?php echo $nama_ibu; ?>">
                  </div>
                </div>
              </div>

              <div class="row">

                <!--TEMPAT LAHIR-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_hp" class="control-label">Tempat Lahir<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="Tempat Lahir" name="tempat_lahir" type="text" value="<?php echo $tempat_lahir; ?>">
                  </div>
                </div>

                <!--TANGGAL LAHIR-->
                <div class="col-md-4">
                  <div class="form-group">
                  <label for="date_of_birth">Tanggal Lahir<i class="hrpremium-asterisk">*</i></label>
                  <input class="form-control date" readonly placeholder="Tanggal Lahir" name="date_of_birth" type="text" value="<?php echo $tanggal_lahir; ?>">
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
                                    <option value="L"<?php if($gender=='L'){ echo 'selected';}?>><?php echo $this->lang->line('xin_gender_male');?></option>
                                    <option value="P"<?php if($gender=='P'){ echo 'selected';}?>><?php echo $this->lang->line('xin_gender_female');?></option>
                                  </select>
                  </div>
                </div>

                <!--AGAMA-->
                <div class="col-md-4">
                  <div class="form-group">
                                  <label class="form-label control-label">Agama/Kepercayaan*</label>


                                  <select class="form-control" name="ethnicity" data-plugin="xin_select">
                                  <option value=""></option>
                                              <?php foreach($all_ethnicity as $eth):?>
                                              <option value="<?php echo $eth->ethnicity_type_id;?>" <?php if($ethnicity_type==$eth->ethnicity_type_id):?> selected <?php endif; ?> ><?php echo $eth->type;?></option>
                                              <?php endforeach;?>
                                  </select>


                  </div>
                </div>

                <!--STATUS PERKAWINAN-->
                <div class="col-md-4">
                  <div class="form-group">
                                  <label class="form-label control-label"><?php echo $this->lang->line('xin_employee_mstatus');?>*</label>


                                  <select class="form-control" name="marital_status" data-plugin="xin_select">
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
                <!--NO KP-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_ktp" class="control-label">Nomor KTP<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="Nomor KTP" name="nomor_ktp" type="text" value="<?php echo $ktp_no;?>" maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--ALAMAT SESUAI KTP-->
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="alamat_ktp"><?php echo $this->lang->line('xin_address_1');?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="alamat_ktp" type="text" value="<?php echo $alamat_ktp;?>">
                  </div>
                </div>

              </div>

              <div class="row">

                <!--NOMOR KK-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_kk" class="control-label">Nomor KK<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="Nomor KK" name="nomor_kk" type="text" value="<?php echo $kk_no;?>" maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--ALAMAT DOMISILI-->
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="alamat_domisili">Alamat Domisili</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="alamat_domisili" type="text" value="<?php echo $alamat_domisili;?>">
                  </div>
                </div>

              </div>

              <div class="row">

                <!--NPWP-->
                <div class="col-md-4">
                  <div class="form-group">
                  <label for="npwp">NPWP<i class="hrpremium-asterisk"></i></label>
                  <input class="form-control" placeholder="NPWP" name="npwp" type="text" value="<?php echo $npwp_no;?>">
                  </div>
                </div>

                <!--NO HP-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_hp" class="control-label">Nomor HP/Whatsapp<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="08xxxxxx" name="nomor_hp" type="text" value="<?php echo $contact_no;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--EMAIL-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="email" class="control-label">Email<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="example@mail.com" name="email" type="text" value="<?php echo $email;?>">
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
                                  <option value="<?php echo $bank->secid;?>" <?php if($bank_id==$bank->secid):?> selected <?php endif; ?>> <?php echo $bank->bank_name;?></option>
                                <?php 
                                } 
                                ?>                                 
                              </select>

                            </div>
                          </div>

                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="no_rek" class="control-label"><?php echo $this->lang->line('xin_e_details_acc_number');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="Nomor Rekening Bank" name="no_rek" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="16" value="<?php echo $nomor_rek;?>">
                          </div>
                        </div>

                <!--PEMILIK REKENING-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="email" class="control-label">Pemilik Rekening<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="Nama Pemilik Rekening" name="pemilik_rekening" type="text" value="<?php echo $pemilik_rek;?>">
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

               
                              
                    <select class="form-control" id="aj_project" name="project_id" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_projects');?>">
                                <option value=""></option>
                                <?php foreach($project_list as $projects) {?>
                                <option value="<?php echo $projects->project_id?>" <?php if($project_id==$projects->project_id):?> selected <?php endif;?>><?php echo $projects->title?></option>
                                <?php } ?>
                    </select>

                  </div>
                </div>

                <!--SUB PROJECT-->
                <div class="col-md-6" id="project_sub_project">
                    
                    <label for="sub_project"><?php echo $this->lang->line('left_sub_projects');?></label>
                    

                    <select class="form-control" id="project_sub_project" name="sub_project" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_projects');?>">
                                <option value=""></option>
                                <?php foreach($sub_project_list as $sbproject) {?>
                                <option value="<?php echo $sbproject->secid?>" <?php if($sub_project==$sbproject->secid):?> selected <?php endif;?>><?php echo $sbproject->sub_project_name?></option>
                                <?php } ?>
                    </select>

                </div>
              </div>

              <div class="row">

                <!--DEPARTEMENT-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="department_id"><?php echo $this->lang->line('left_department');?><i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="department_id" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_department');?>">

                      <option value="<?php echo $department_id;?>"><?php echo $department_name;?></option>
                     
                    </select>
                  </div>
                </div>

                <!--POSISI/JABATAN-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="posisi"><?php echo $this->lang->line('left_designation');?><i class="hrpremium-asterisk">*</i></label>

                              
                    <select class="form-control" name="posisi" data-plugin="xin_select" data-placeholder="posisi/jabatan">
                                <option value=""></option>
                                <?php foreach($designations_list as $posisi) {?>
                                <option value="<?php echo $posisi->designation_id?>" <?php if($designation_id==$posisi->designation_id):?> selected <?php endif;?>><?php echo $posisi->designation_name?></option>
                                <?php } ?>
                    </select>

                  </div>
                </div>

              </div>

              <div class="row">

                <!--TANGGAL JOIN-->
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="date_of_join"><?php echo $this->lang->line('xin_employee_doj');?><i class="hrpremium-asterisk">*</i></label>
                  <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('xin_employee_doj');?>" name="date_of_join" type="text" value="<?php echo $date_of_joining?>">
                  </div>
                </div>

                <!-- PENEMPATAN -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="penempatan"><?php echo $this->lang->line('xin_placement_area');?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_placement_area');?>" name="penempatan" type="text" value="<?php echo $penempatan?>">
                  </div>
                </div>

              </div>
            <!-- end row -->
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
                    <input class="form-control" placeholder="0" name="gaji_pokok" type="text" value="<?php echo $basic_salary;?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN JABATAN-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_jabatan" class="control-label">Tunjangan Jabatan<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_jabatan" type="text" value="<?php echo $allow_jabatan;?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"> 
                  </div>
                </div>

                <!--TUNJANGAN AREA-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_area" class="control-label">Tunjangan Area<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_area" type="text" value="<?php echo $allow_area;?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN MASA KERJA-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_masakerja">Tunjangan Masa Kerja<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_masakerja" type="text" value="<?php echo $allow_masakerja;?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>
              </div>

              <div class="row">


                <!--TUNJANGAN MAKAN TRANSPORT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_makan_trans" class="control-label">Tunjangan Makan & Transport<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_makan_trans" type="text" value="<?php echo $allow_trans_meal;?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN MAKAN-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_makan" class="control-label">Tunjangan Makan<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_makan" type="text" value="<?php echo $allow_konsumsi;?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN TRANSPORT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_transport" class="control-label">Tunjangan Transport<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_transport" type="text" value="<?php echo $allow_transport;?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN KOMUNIKASI-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_komunikasi" class="control-label">Tunjangan Komunikasi<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_komunikasi" type="text" value="<?php echo $allow_comunication;?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>
              </div>

              <div class="row">


                <!--TUNJANGAN DEVICE-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_device" class="control-label">Tunjangan Laptop/HP<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_device" type="text" value="<?php echo $allow_device;?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN TEMPAT TINGGAL-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_tempat_tinggal">Tunjangan Tempat Tinggal<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_tempat_tinggal" type="text" value="<?php echo $allow_residence_cost;?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN RENTAL-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_rental">Tunjangan Rental<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_rental" type="text" value="<?php echo $allow_rent;?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN PARKIR-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_parkir" class="control-label">Tunjangan Parkir<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_parkir" type="text" value="<?php echo $allow_parking;?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>
              </div>

              <div class="row">


                <!--TUNJANGAN KESEHATAN-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_kesehatan" class="control-label">Tunjangan Kesehatan<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_kesehatan" type="text" value="<?php echo $allow_medichine;?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>


                <!--TUNJANGAN AKOMODASI-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_akomodasi">Tunjangan Akomodasi<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_akomodasi" type="text" value="<?php echo $allow_akomodsasi;?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN KASIR-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_kasir" class="control-label">Tunjangan Kasir<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_kasir" type="text" value="<?php echo $allow_kasir;?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--TUNJANGAN OPERATIONAL-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_operational" class="control-label">Tunjangan Operational<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_operational" type="text" value="<?php echo $allow_operational;?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
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
                  <input class="form-control date" readonly placeholder="YYYY-MM-DD" name="join_date_pkwt" type="text" value="<?php echo $contract_start;?>">
                  </div>
                </div>

                <!--TANGGAL AKHIR KONTRAK-->
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="pkwt_end_date">Tanggal Akhir Kontrak<i class="hrpremium-asterisk">*</i></label>
                  <input class="form-control date" readonly placeholder="YYYY-MM-DD" name="pkwt_end_date" type="text" value="<?php echo $contract_end;?>">
                  </div>
                </div>

              </div>

              <div class="row">
                <!--PERIODE KONTRAK-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="waktu_kontrak">Waktu Kontrak<i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="waktu_kontrak" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_e_details_office_location');?>">
                      <option value="1" <?php if($contract_periode=='1'):?> selected <?php endif; ?>>1 (Bulan)</option>
                      <option value="2" <?php if($contract_periode=='2'):?> selected <?php endif; ?>>2 (Bulan)</option>
                      <option value="3" <?php if($contract_periode=='3'):?> selected <?php endif; ?>>3 (Bulan)</option>
                      <option value="4" <?php if($contract_periode=='4'):?> selected <?php endif; ?>>4 (Bulan)</option>
                      <option value="5" <?php if($contract_periode=='5'):?> selected <?php endif; ?>>5 (Bulan)</option>
                      <option value="6" <?php if($contract_periode=='6'):?> selected <?php endif; ?>>6 (Bulan)</option>
                      <option value="7" <?php if($contract_periode=='7'):?> selected <?php endif; ?>>7 (Bulan)</option>
                      <option value="8" <?php if($contract_periode=='8'):?> selected <?php endif; ?>>8 (Bulan)</option>
                      <option value="9" <?php if($contract_periode=='9'):?> selected <?php endif; ?>>9 (Bulan)</option>
                      <option value="10" <?php if($contract_periode=='10'):?> selected <?php endif; ?>>10 (Bulan)</option>
                      <option value="11" <?php if($contract_periode=='11'):?> selected <?php endif; ?>>11 (Bulan)</option>
                      <option value="12" <?php if($contract_periode=='12'):?> selected <?php endif; ?>>12 (Bulan)</option>
                    </select>
                  </div>
                </div>

                <!-- HK -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="hari_kerja">Hari Kerja<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="hari_kerja" type="text" value="<?php echo $hari_kerja;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2">
                  </div>
                </div>
              </div>

              <div class="row">
                <!--PERIODE KONTRAK-->
                <div class="col-md-4">
                  <div class="form-group">                                  
                    <label class="form-label control-label">Tanggal CUT-START</label>
                                  <input class="form-control" placeholder="0" name="cut_start" type="text" value="<?php echo $cut_start;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2">
                                
                  </div>
                </div>

                <!-- HK -->
                <div class="col-md-4">                                
                  <div class="form-group">
                                  <label class="form-label control-label">Tanggal CUT-OFF</label>                    
                                  <input class="form-control" placeholder="0" name="cut_off" type="text" value="<?php echo $cut_off;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2">
                                </div>
                </div>

                <!-- HK -->
                <div class="col-md-4">                                
                  <div class="form-group">
                                  <label class="form-label">Tanggal Penggajian</label><input class="form-control" placeholder="0" name="date_payment" type="text" value="<?php echo $date_payment;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2">
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
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>DAFTAR</strong> PENGAJUAN PAKLARING KARYAWAN</span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th>No.</th>
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
