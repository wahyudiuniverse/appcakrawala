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
<?php
if($e_status=='1'){
  $dokname = 'PKWT';
} else if ($e_status=='2'){
  $dokname = 'TKHL';
} else {
  $dokname = 'TIDAK DIKETAHUI';
}
?>

<?php //$list_bank = $this->Xin_model->get_bank_code();?>
<!-- $data['list_bank'] = $this->Xin_model->get_bank_code(); -->

<hr class="border-light m-0 mb-3">
<?php //$employee_id = $this->Xin_model->generate_random_employeeid();?>
<?php $employee_pincode = $this->Xin_model->generate_random_pincode();?>

<?php if(in_array('337',$role_resources_ids)) { ?>

<div class="card mb-4">
  <!-- <div id="accordion"> -->
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>UBAH DATA </strong> PERMINTAAN PKWT KARYAWAN</span>
      <div class="card-header-elements ml-md-auto"> </div>
    </div>
    <div id="add_form" class="add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_employee', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/employee_pkwt_cancel/pkwt_expired_approve', $attributes, $hidden);?>
        <div class="form-body">

          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <input name="idrequest" type="hidden" value="<?php echo $secid;?>">
                <input name="employee_id" type="hidden" value="<?php echo $employee_id;?>">
                <input name="company" type="hidden" value="<?php echo $company;?>">

                <!--NAMA LENGKAP-->
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="fullname"><?php echo $this->lang->line('xin_employees_full_name').'APPROVE';?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employees_full_name');?>" name="fullname" type="text" value="<?php echo $fullname; ?>" disabled>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nama_ibu">Nama Ibu<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="Nama Ibu" name="nama_ibu" type="text" value="<?php echo $nama_ibu; ?>" disabled>
                  </div>
                </div>
              </div>

              <div class="row">

                <!--TEMPAT LAHIR-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_hp" class="control-label">Tempat Lahir<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="Tempat Lahir" name="tempat_lahir" type="text" value="<?php echo $tempat_lahir; ?>" disabled>
                  </div>
                </div>

                <!--TANGGAL LAHIR-->
                <div class="col-md-4">
                  <div class="form-group">
                  <label for="date_of_birth">Tanggal Lahir<i class="hrpremium-asterisk">*</i></label>
                  <input class="form-control date" readonly placeholder="Tanggal Lahir" name="date_of_birth" type="text" value="<?php echo $tanggal_lahir; ?>" disabled>
                  </div>
                </div>


              </div>

              <div class="row">

                <!--JENIS KELAMIN-->
                <div class="col-md-4">
                  <div class="form-group">
                                  <label class="form-label control-label"><?php echo $this->lang->line('xin_employee_gender');?>*</label>
                                  <select class="form-control" name="gender" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_employee_gender');?>" disabled>
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


                                  <select class="form-control" name="ethnicity" data-plugin="xin_select" disabled>
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


                                  <select class="form-control" name="marital_status" data-plugin="xin_select" disabled>
                                  <option value=""></option>
                                              <option value="1" <?php if($marital_status=='1'):?> selected <?php endif; ?>>Belum Menikah</option>
                                              <option value="2" <?php if($marital_status=='2'):?> selected <?php endif; ?>>Janda/Duda (0 Anak)</option>
                                              <option value="6" <?php if($marital_status=='6'):?> selected <?php endif; ?>>Menikah (0 Anak)</option>
                                              <option value="7" <?php if($marital_status=='7'):?> selected <?php endif; ?>>Menikah (1 Anak)</option>
                                              <option value="8" <?php if($marital_status=='8'):?> selected <?php endif; ?>>Menikah (2 Anak)</option>
                                              <option value="9" <?php if($marital_status=='9'):?> selected <?php endif; ?>>Menikah (3 Anak)</option>
                                              <option value="3" <?php if($marital_status=='3'):?> selected <?php endif; ?>>Janda/Duda (1 Anak)</option>
                                              <option value="4" <?php if($marital_status=='4'):?> selected <?php endif; ?>>Janda/Duda (2 Anak)</option>
                                              <option value="5" <?php if($marital_status=='5'):?> selected <?php endif; ?>>Janda/Duda (3 Anak)</option>
                                              
                                </select>

                  </div>
                </div>

              </div>

              <div class="row">
                <!--NO KP-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_ktp" class="control-label">Nomor KTP<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="Nomor KTP" name="nomor_ktp" type="text" value="<?php echo $ktp_no;?>" maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" disabled>
                  </div>
                </div>

                <!--ALAMAT SESUAI KTP-->
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="alamat_ktp"><?php echo $this->lang->line('xin_address_1');?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="alamat_ktp" type="text" value="<?php echo $alamat_ktp;?>" disabled>
                  </div>
                </div>

              </div>

              <div class="row">

                <!--NOMOR KK-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_kk" class="control-label">Nomor KK<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="Nomor KK" name="nomor_kk" type="text" value="<?php echo $kk_no;?>" maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" disabled>
                  </div>
                </div>

                <!--ALAMAT DOMISILI-->
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="alamat_domisili">Alamat Domisili</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="alamat_domisili" type="text" value="<?php echo $alamat_domisili;?>" disabled>
                  </div>
                </div>

              </div>

              <div class="row">

                <!--NPWP-->
                <div class="col-md-4">
                  <div class="form-group">
                  <label for="npwp">NPWP<i class="hrpremium-asterisk"></i></label>
                  <input class="form-control" placeholder="NPWP" name="npwp" type="text" value="<?php echo $npwp_no;?>" disabled>
                  </div>
                </div>

                <!--NO HP-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_hp" class="control-label">Nomor HP/Whatsapp<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="08xxxxxx" name="nomor_hp" type="text" value="<?php echo $contact_no;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" disabled>
                  </div>
                </div>

                <!--EMAIL-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="email" class="control-label">Email<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="example@mail.com" name="email" type="text" value="<?php echo $email;?>" disabled>
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

               
                              
                    <select  class="form-control" id="aj_project" name="project_id" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_projects');?>">
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
                    

                    <select class="form-control" id="project_sub_project" name="sub_project_id" data-plugin="xin_select" data-placeholder="Sub-Project">
                                <option value=""></option>
                                <?php foreach($sub_project_list as $sbproject) {?>
                                <option value="<?php echo $sbproject->secid?>" <?php if($sub_project_id==$sbproject->secid):?> selected <?php endif;?>><?php echo $sbproject->sub_project_name?></option>
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

                      <option value="5">OPERATION</option>
                     
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


              <div class="row">



                <div class="col-md-4" id="jenis_dokumen">
  
                  <div class="form-group">
                    <label for="jenis_dokumen">Jenis Dokumen<i class="hrpremium-asterisk"></i></label>
                      <select class="form-control" name="jenis_dokumen" data-plugin="select_hrm">
                        <option value="<?php echo $e_status;?>"><?php echo $dokname;?></option>
                      </select>
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
                    <input class="form-control" placeholder="0" name="gaji_pokok" type="text" value="<?php echo $this->Xin_model->rupiah_titik($basic_salary); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah1">
                  </div>
                </div>

                <!--TUNJANGAN JABATAN-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_jabatan" class="control-label">Tunjangan Jabatan<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_jabatan" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_jabatan);?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah2"> 
                  </div>
                </div>

                <!--TUNJANGAN AREA-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_area" class="control-label">Tunjangan Area<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_area" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_area);?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah3">
                  </div>
                </div>

                <!--TUNJANGAN MASA KERJA-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_masakerja">Tunjangan Masa Kerja<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_masakerja" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_masakerja);?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah4">
                  </div>
                </div>
              </div>

              <div class="row">



                <!--TUNJANGAN MAKAN-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_makan" class="control-label">Tunjangan Makan<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_makan" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_konsumsi);?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah5">
                  </div>
                </div>

                <!--TUNJANGAN TRANSPORT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_transport" class="control-label">Tunjangan Transport<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_transport" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_transport);?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah6">
                  </div>
                </div>

                <!--TUNJANGAN KOMUNIKASI-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_komunikasi" class="control-label">Tunjangan Komunikasi<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_komunikasi" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_comunication);?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah7">
                  </div>
                </div>

                <!--TUNJANGAN DEVICE-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_device" class="control-label">Tunjangan Laptop/HP<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_device" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_device);?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah8">
                  </div>
                </div>
              </div>
              
              <div class="row">



                <!--TUNJANGAN TEMPAT TINGGAL-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_tempat_tinggal">Tunjangan Tempat Tinggal<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_tempat_tinggal" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_residence_cost);?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah9">
                  </div>
                </div>

                <!--TUNJANGAN RENTAL-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_rental">Tunjangan Rental<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_rental" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_rent);?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah10">
                  </div>
                </div>

                <!--TUNJANGAN PARKIR-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_parkir" class="control-label">Tunjangan Parkir<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_parkir" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_parking);?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah11">
                  </div>
                </div>

                <!--TUNJANGAN KESEHATAN-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_kesehatan" class="control-label">Tunjangan Kesehatan<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_kesehatan" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_medichine);?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah12">
                  </div>
                </div>

              </div>
              
              <div class="row">

                <!--TUNJANGAN AKOMODASI-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_akomodasi">Tunjangan Akomodasi<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_akomodasi" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_akomodsasi);?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah13">
                  </div>
                </div>

                <!--TUNJANGAN KASIR-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_kasir" class="control-label">Tunjangan Kasir<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_kasir" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_kasir);?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah14">
                  </div>
                </div>

                <!--TUNJANGAN OPERATIONAL-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_operational" class="control-label">Tunjangan Operational<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_operational" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_operational);?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah15">
                  </div>
                </div>

                <!--TUNJANGAN KEAHLIAN-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_keahlian" class="control-label">Tunjangan Keahlian<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_keahlian" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_skill); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah18">
                  </div>
                </div>

              </div>
              
              <div class="row">

                <!--TUNJANGAN MAKAN TRANSPORT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_makan_trans" class="control-label">Tunjangan Makan & Transport<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_makan_trans" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_trans_meal);?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah16">
                  </div>
                </div>

                <!--TUNJANGAN TRANSPORT RENTAL-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_trans_rental" class="control-label">Tunjangan Transport Rental<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_trans_rental" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_trans_rent);?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah17">
                  </div>
                </div>

                <!--TUNJANGAN PELATIHAN-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_pelatihan" class="control-label">Tunjangan Pelatihan<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_pelatihan" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_training); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah19">
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
                      <option value="11" <?php if($contract_periode=='10'):?> selected <?php endif; ?>>11 (Bulan)</option>
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

        <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'id' => 'button_approve_pkwtexpired', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.'AJUKAN PERPANJANG PKWT')); ?> 
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


<script type="text/javascript">
  var rupiah1 = document.getElementById("rupiah1");
  rupiah1.addEventListener("keyup", function(e) {
    rupiah1.value = convertRupiah(this.value);
  });

  var rupiah2 = document.getElementById("rupiah2");
  rupiah2.addEventListener("keyup", function(e) {
    rupiah2.value = convertRupiah(this.value);
  });

  var rupiah3 = document.getElementById("rupiah3");
  rupiah3.addEventListener("keyup", function(e) {
    rupiah3.value = convertRupiah(this.value);
  });


  var rupiah4 = document.getElementById("rupiah4");
  rupiah4.addEventListener("keyup", function(e) {
    rupiah4.value = convertRupiah(this.value);
  });

  var rupiah5 = document.getElementById("rupiah5");
  rupiah5.addEventListener("keyup", function(e) {
    rupiah5.value = convertRupiah(this.value);
  });

  var rupiah6 = document.getElementById("rupiah6");
  rupiah6.addEventListener("keyup", function(e) {
    rupiah6.value = convertRupiah(this.value);
  });

  var rupiah7 = document.getElementById("rupiah7");
  rupiah7.addEventListener("keyup", function(e) {
    rupiah7.value = convertRupiah(this.value);
  });

  var rupiah8 = document.getElementById("rupiah8");
  rupiah8.addEventListener("keyup", function(e) {
    rupiah8.value = convertRupiah(this.value);
  });


  var rupiah9 = document.getElementById("rupiah9");
  rupiah9.addEventListener("keyup", function(e) {
    rupiah9.value = convertRupiah(this.value);
  });

  var rupiah10 = document.getElementById("rupiah10");
  rupiah10.addEventListener("keyup", function(e) {
    rupiah10.value = convertRupiah(this.value);
  });

  var rupiah11 = document.getElementById("rupiah11");
  rupiah11.addEventListener("keyup", function(e) {
    rupiah11.value = convertRupiah(this.value);
  });

  var rupiah12 = document.getElementById("rupiah12");
  rupiah12.addEventListener("keyup", function(e) {
    rupiah12.value = convertRupiah(this.value);
  });

  var rupiah13 = document.getElementById("rupiah13");
  rupiah13.addEventListener("keyup", function(e) {
    rupiah13.value = convertRupiah(this.value);
  });

  var rupiah14 = document.getElementById("rupiah14");
  rupiah14.addEventListener("keyup", function(e) {
    rupiah14.value = convertRupiah(this.value);
  });

  var rupiah15 = document.getElementById("rupiah15");
  rupiah15.addEventListener("keyup", function(e) {
    rupiah15.value = convertRupiah(this.value);
  });

  var rupiah16 = document.getElementById("rupiah16");
  rupiah16.addEventListener("keyup", function(e) {
    rupiah16.value = convertRupiah(this.value);
  });

  var rupiah17 = document.getElementById("rupiah17");
  rupiah17.addEventListener("keyup", function(e) {
    rupiah17.value = convertRupiah(this.value);
  });

  var rupiah18 = document.getElementById("rupiah18");
  rupiah18.addEventListener("keyup", function(e) {
    rupiah18.value = convertRupiah(this.value);
  });

  var rupiah19 = document.getElementById("rupiah19");
  rupiah19.addEventListener("keyup", function(e) {
    rupiah19.value = convertRupiah(this.value);
  });


  function convertRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
      split = number_string.split(","),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
      separator = sisa ? "." : "";
      rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? prefix + rupiah : "";
  }
</script>

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
