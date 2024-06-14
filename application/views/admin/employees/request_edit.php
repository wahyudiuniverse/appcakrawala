<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php $count_emp_request_cancel = $this->Xin_model->count_emp_request_cancel($session['employee_id']); ?>
<?php $count_emp_request_nae = $this->Xin_model->count_emp_request_nae($session['employee_id']); ?>
<?php $count_emp_request_nom = $this->Xin_model->count_emp_request_nom($session['employee_id']); ?>
<?php $count_emp_request_hrd = $this->Xin_model->count_emp_request_hrd($session['employee_id']); ?>



<?php //$list_bank = $this->Xin_model->get_bank_code();
?>
<!-- $data['list_bank'] = $this->Xin_model->get_bank_code(); -->

<hr class="border-light m-0 mb-3">
<?php $employee_id = $this->Xin_model->generate_random_employeeid(); ?>
<?php $employee_pincode = $this->Xin_model->generate_random_pincode(); ?>

<!-- Modal -->
<div class="modal fade" id="verifikasiModal" tabindex="-1" role="dialog" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifikasiModalLabel">
          <div class="judul-modal">
            Verifikasi data
          </div>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"> X </span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
          <!-- <pre>
            <?php //print_r($user_info); 
            ?>
          </pre><br> -->
          <div class="col-md-3">NIK <span class="icon-verify-nik"></span>
          </div>
          <div class="col-md-5"><input type='text' id="nik_modal" class='form-control' placeholder='Nomor NIK KTP' value='<?php echo $ktp_no; ?>'></div>
          <div class="col-md-4">
            <button id="button_verify_nik_modal" class="btn btn-success ladda-button" data-style="expand-right">Verifikasi</button>
            <?php if (($user_info[0]->user_role_id == "1") || ($user_info[0]->user_role_id == "11")) { ?>
              <button id="button_unverify_nik_modal" class="btn btn-danger ladda-button" data-style="expand-right">Cancel</button>
            <?php } ?>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-3">KK <span class="icon-verify-kk"></span>
          </div>
          <div class="col-md-5"><input type='text' id="kk_modal" class='form-control' placeholder='Nomor Kartu Keluarga' value='<?php echo $kk_no; ?>'></div>
          <div class="col-md-4">
            <button id="button_verify_kk_modal" class="btn btn-success ladda-button" data-style="expand-right">Verifikasi</button>
            <?php if (($user_info[0]->user_role_id == "1") || ($user_info[0]->user_role_id == "11")) { ?>
              <button id="button_unverify_kk_modal" class="btn btn-danger ladda-button" data-style="expand-right">Cancel</button>
            <?php } ?>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-3">Nama Lengkap <span class="icon-verify-nama"></span>
          </div>
          <div class="col-md-5"><input type='text' id="nama_modal" class='form-control' placeholder='Nama Lengkap' value="<?php echo $fullname; ?>"></div>
          <div class="col-md-4">
            <button id="button_verify_nama_modal" class="btn btn-success ladda-button" data-style="expand-right">Verifikasi</button>
            <?php if (($user_info[0]->user_role_id == "1") || ($user_info[0]->user_role_id == "11")) { ?>
              <button id="button_unverify_nama_modal" class="btn btn-danger ladda-button" data-style="expand-right">Cancel</button>
            <?php } ?>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-3">Bank <span class="icon-verify-bank"></span>
          </div>
          <div class="col-md-5">
            <select name="bank_modal" id="bank_modal" class="form-control" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_bank_choose_name'); ?>">
              <option value=""></option>
              <?php
              foreach ($list_bank as $bank) {
              ?>
                <option value="<?php echo $bank->secid; ?>" <?php if ($bank_id == $bank->secid) : ?> selected <?php endif; ?>> <?php echo $bank->bank_name; ?></option>
              <?php
              }
              ?>
            </select>
            <!-- <input type='text' id="bank_modal" class='form-control' placeholder='Bank' value='<?php echo $bank_id; ?>'> -->
          </div>
          <div class="col-md-4">
            <button id="button_verify_bank_modal" class="btn btn-success ladda-button" data-style="expand-right">Verifikasi</button>
            <?php if (($user_info[0]->user_role_id == "1") || ($user_info[0]->user_role_id == "11")) { ?>
              <button id="button_unverify_bank_modal" class="btn btn-danger ladda-button" data-style="expand-right">Cancel</button>
            <?php } ?>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-3">Nomor Rekening <span class="icon-verify-norek"></span>
          </div>
          <div class="col-md-5"><input type='text' id="rekening_modal" class='form-control' placeholder='Nomor Rekening' value='<?php echo $nomor_rek; ?>'></div>
          <div class="col-md-4">
            <button id="button_verify_norek_modal" class="btn btn-success ladda-button" data-style="expand-right">Verifikasi</button>
            <?php if (($user_info[0]->user_role_id == "1") || ($user_info[0]->user_role_id == "11")) { ?>
              <button id="button_unverify_norek_modal" class="btn btn-danger ladda-button" data-style="expand-right">Cancel</button>
            <?php } ?>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-3">Pemilik Rekening <span class="icon-verify-pemilik-rek"></span>
          </div>
          <div class="col-md-5"><input type='text' id="pemilik_rekening_modal" class='form-control' placeholder='Pemilik Rekening' value="<?php echo $pemilik_rek; ?>"></div>
          <div class="col-md-4">
            <button id="button_verify_pemilik_rek_modal" class="btn btn-success ladda-button" data-style="expand-right">Verifikasi</button>
            <?php if (($user_info[0]->user_role_id == "1") || ($user_info[0]->user_role_id == "11")) { ?>
              <button id="button_unverify_pemilik_rek_modal" class="btn btn-danger ladda-button" data-style="expand-right">Cancel</button>
            <?php } ?>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-3"><button id="button_show_ktp_modal" class="btn btn-xs btn-outline-success" data-style="expand-right">Show/Hide KTP</button></div>
          <div class="col-md-3"><button id="button_show_kk_modal" class="btn btn-xs btn-outline-success" data-style="expand-right">Show/Hide KK</button></div>
          <div class="col-md-3"><button id="button_show_rekening_modal" class="btn btn-xs btn-outline-success" data-style="expand-right">Show/Hide Rekening</button></div>
        </div>

        <div class="isi-modal">
          <div class="rekening-modal"></div>
          <div class="ktp-modal"></div>
          <div class="kk-modal"></div>
          <div class="api-rekening-modal"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="close_modal" class="btn btn-primary ladda-button" data-style="expand-right">Close Modal</button>
        <!-- <button type="button" class="btn btn-primary" data-dismiss="modal"> Close </button> -->
      </div>
    </div>
  </div>
</div>

<?php if (in_array('337', $role_resources_ids)) { ?>

  <div class="card mb-4">
    <!-- <div id="accordion"> -->
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>UBAH DATA </strong> PERMINTAAN KARYAWAN</span>
      <div class="card-header-elements ml-md-auto"> </div>
    </div>
    <div id="add_form" class="add-form <?php echo $get_animate; ?>" data-parent="#accordion" style="">
      <div class="card-body">
        <?php $attributes = array('name' => 'add_employee', 'id' => 'xin-form', 'autocomplete' => 'off'); ?>
        <?php $hidden = array('_user' => $session['user_id']); ?>
        <?php echo form_open_multipart('admin/employee_request_cancelled/request_edit_employee', $attributes, $hidden); ?>
        <div class="form-body">

          <div class="row">
            <div class="col-md-6">
              <div class="row">
                <input name="idrequest" type="hidden" value="<?php echo $secid; ?>">

                <!--NAMA LENGKAP-->
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="fullname"><?php echo $this->lang->line('xin_employees_full_name'); ?><i class="hrpremium-asterisk">*</i></label>
                    <!-- icon lock - unlock - log -->
                    <!-- <i hidden id="lock_nama" onclick="lock_on_nama()" style="color:green;" class="sidenav-icon ion ion-md-unlock" data-toggle="tooltip" data-placement="top" title="Lock Kolom"></i>
                    <i hidden id="unlock_nama" onclick="lock_off_nama()" style="color:red;" class="sidenav-icon ion ion-md-lock" data-toggle="tooltip" data-placement="top" title="Unlock Kolom"></i>
                    <i hidden id="log_nama" onclick="show_log_nama()" style="color:orange;" class="sidenav-icon ion ion-md-clipboard" data-toggle="tooltip" data-placement="top" title="Catatan"></i> -->
                    <span class="icon-verify-nama"></span>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employees_full_name'); ?>" name="fullname" id="fullname" type="text" value="<?php echo $fullname; ?>">
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
                    <label class="form-label control-label"><?php echo $this->lang->line('xin_employee_gender'); ?>*</label>
                    <select class="form-control" name="gender" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_employee_gender'); ?>">
                      <option value="">Jenis Kelamin</option>
                      <option value="L" <?php if ($gender == 'L') {
                                          echo 'selected';
                                        } ?>><?php echo $this->lang->line('xin_gender_male'); ?></option>
                      <option value="P" <?php if ($gender == 'P') {
                                          echo 'selected';
                                        } ?>><?php echo $this->lang->line('xin_gender_female'); ?></option>
                    </select>
                  </div>
                </div>

                <!--AGAMA-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label control-label">Agama/Kepercayaan*</label>


                    <select class="form-control" name="ethnicity" data-plugin="xin_select">
                      <option value=""></option>
                      <?php foreach ($all_ethnicity as $eth) : ?>
                        <option value="<?php echo $eth->ethnicity_type_id; ?>" <?php if ($ethnicity_type == $eth->ethnicity_type_id) : ?> selected <?php endif; ?>><?php echo $eth->type; ?></option>
                      <?php endforeach; ?>
                    </select>


                  </div>
                </div>

                <!--STATUS PERKAWINAN-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label control-label"><?php echo $this->lang->line('xin_employee_mstatus'); ?>*</label>
                    <select class="form-control" name="marital_status" data-plugin="xin_select">
                      <option value=""></option>
                      <?php foreach ($list_marital as $marital) : ?>
                        <option value="<?php echo $marital['id_marital']; ?>" <?php if ($marital_status == $marital['id_marital']) : ?> selected <?php endif; ?>><?php echo $marital['nama']; ?></option>
                      <?php endforeach; ?>
                      <!-- <option value="TK/0" <?php if ($marital_status == 'TK/0') : ?> selected <?php endif; ?>>Single/Janda/Duda (0 Anak)</option>
                      <option value="K/0" <?php if ($marital_status == 'K/0') : ?> selected <?php endif; ?>>Menikah (0 Anak)</option>
                      <option value="K/1" <?php if ($marital_status == 'K/1') : ?> selected <?php endif; ?>>Menikah (1 Anak)</option>
                      <option value="K/2" <?php if ($marital_status == 'K/2') : ?> selected <?php endif; ?>>Menikah (2 Anak)</option>
                      <option value="K/3" <?php if ($marital_status == 'K/3') : ?> selected <?php endif; ?>>Menikah (3 Anak)</option>
                      <option value="TK/1" <?php if ($marital_status == 'TK/1') : ?> selected <?php endif; ?>>Janda/Duda (1 Anak)</option>
                      <option value="TK/2" <?php if ($marital_status == 'TK/2') : ?> selected <?php endif; ?>>Janda/Duda (2 Anak)</option>
                      <option value="TK/3" <?php if ($marital_status == 'TK/3') : ?> selected <?php endif; ?>>Janda/Duda (3 Anak)</option> -->

                    </select>

                  </div>
                </div>

              </div>

              <div class="row">
                <!--NO KTP-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_ktp" class="control-label">Nomor KTP<i class="hrpremium-asterisk">*</i></label>
                    <!-- icon lock - unlock - log -->
                    <!-- <i hidden id="lock_ktp" onclick="lock_on_ktp()" style="color:green;" class="sidenav-icon ion ion-md-unlock" data-toggle="tooltip" data-placement="top" title="Lock Kolom"></i>
                    <i hidden id="unlock_ktp" onclick="lock_off_ktp()" style="color:red;" class="sidenav-icon ion ion-md-lock" data-toggle="tooltip" data-placement="top" title="Unlock Kolom"></i>
                    <i hidden id="log_ktp" onclick="show_log_ktp()" style="color:orange;" class="sidenav-icon ion ion-md-clipboard" data-toggle="tooltip" data-placement="top" title="Catatan"></i> -->
                    <span class="icon-verify-nik"></span>
                    <input class="form-control" placeholder="Nomor KTP" name="nomor_ktp" id="nomor_ktp" type="text" value="<?php echo $ktp_no; ?>" maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--ALAMAT SESUAI KTP-->
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="alamat_ktp"><?php echo $this->lang->line('xin_address_1'); ?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1'); ?>" name="alamat_ktp" type="text" value="<?php echo $alamat_ktp; ?>">
                  </div>
                </div>

              </div>

              <div class="row">

                <!--NOMOR KK-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_kk" class="control-label">Nomor KK<i class="hrpremium-asterisk">*</i></label>
                    <!-- icon lock - unlock - log -->
                    <!-- <i hidden id="lock_kk" onclick="lock_on_kk()" style="color:green;" class="sidenav-icon ion ion-md-unlock" data-toggle="tooltip" data-placement="top" title="Lock Kolom"></i>
                    <i hidden id="unlock_kk" onclick="lock_off_kk()" style="color:red;" class="sidenav-icon ion ion-md-lock" data-toggle="tooltip" data-placement="top" title="Unlock Kolom"></i>
                    <i hidden id="log_kk" onclick="show_log_kk()" style="color:orange;" class="sidenav-icon ion ion-md-clipboard" data-toggle="tooltip" data-placement="top" title="Catatan"></i> -->
                    <span class="icon-verify-kk"></span>
                    <input class="form-control" placeholder="Nomor KK" name="nomor_kk" id="nomor_kk" type="text" value="<?php echo $kk_no; ?>" maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--ALAMAT DOMISILI-->
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="alamat_domisili">Alamat Domisili</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1'); ?>" name="alamat_domisili" type="text" value="<?php echo $alamat_domisili; ?>">
                  </div>
                </div>

              </div>

              <div class="row">

                <!--NPWP-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="npwp">NPWP<i class="hrpremium-asterisk"></i></label>
                    <input class="form-control" placeholder="NPWP" name="npwp" type="text" value="<?php echo $npwp_no; ?>">
                  </div>
                </div>

                <!--NO HP-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_hp" class="control-label">Nomor HP/Whatsapp<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="08xxxxxx" name="nomor_hp" type="text" value="<?php echo $contact_no; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                  </div>
                </div>

                <!--EMAIL-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="email" class="control-label">Email<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="example@mail.com" name="email" type="text" value="<?php echo $email; ?>">
                  </div>
                </div>

              </div>


              <div class="row">

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="bank_name2"><?php echo $this->lang->line('xin_e_details_bank_name'); ?><i class="hrpremium-asterisk">*</i></label><span class="icon-verify-bank"></span>


                    <select name="bank_name2" id="bank_name2" class="form-control" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_bank_choose_name'); ?>">
                      <option value=""></option>
                      <?php
                      foreach ($list_bank as $bank) {
                      ?>
                        <option value="<?php echo $bank->secid; ?>" <?php if ($bank_id == $bank->secid) : ?> selected <?php endif; ?>> <?php echo $bank->bank_name; ?></option>
                      <?php
                      }
                      ?>
                    </select>

                    <input hidden name="bank_name" id="bank_name" placeholder="Nomor Rekening Bank" type="text" value="<?php echo $bank_id; ?>">

                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="no_rek" class="control-label"><?php echo $this->lang->line('xin_e_details_acc_number'); ?><i class="hrpremium-asterisk">*</i></label><span class="icon-verify-norek"></span>
                    <input class="form-control" placeholder="Nomor Rekening Bank" id="no_rek" name="no_rek" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="16" value="<?php echo $nomor_rek; ?>">
                  </div>
                </div>

                <!--PEMILIK REKENING-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="pemilik_rek" class="control-label">Pemilik Rekening<i class="hrpremium-asterisk">*</i></label><span class="icon-verify-pemilik-rek"></span>
                    <input class="form-control" placeholder="Nama Pemilik Rekening" id="pemilik_rekening" name="pemilik_rekening" type="text" value="<?php echo $pemilik_rek; ?>">
                  </div>
                </div>

              </div>
            </div>

            <div class="col-md-6">

              <div class="row">
                <!--PROJECT-->

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="projects"><?php echo $this->lang->line('left_projects'); ?><i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" id="aj_project" name="project_id" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_projects'); ?>">
                      <option value=""></option>
                      <?php foreach ($project_list as $projects) { ?>
                        <option value="<?php echo $projects->project_id ?>" <?php if ($project_id == $projects->project_id) : ?> selected <?php endif; ?>><?php echo $projects->title ?></option>
                      <?php } ?>
                    </select>

                  </div>
                </div>

                <!--SUB PROJECT-->
                <div class="col-md-6" id="project_sub_project">

                  <label for="sub_project"><?php echo $this->lang->line('left_sub_projects'); ?></label>


                  <select class="form-control" id="project_sub_project" name="sub_project_id" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_projects'); ?>">
                    <option value=""></option>
                    <?php foreach ($sub_project_list as $sbproject) { ?>
                      <option value="<?php echo $sbproject->secid ?>" <?php if ($sub_project == $sbproject->secid) : ?> selected <?php endif; ?>><?php echo $sbproject->sub_project_name ?></option>
                    <?php } ?>
                  </select>

                </div>
              </div>

              <div class="row">

                <!--DEPARTEMENT-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="department_id"><?php echo $this->lang->line('left_department'); ?><i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="department_id" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_department'); ?>">

                      <option value="<?php echo $department_id; ?>"><?php echo $department_name; ?></option>

                    </select>
                  </div>
                </div>

                <!--POSISI/JABATAN-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="posisi"><?php echo $this->lang->line('left_designation'); ?><i class="hrpremium-asterisk">*</i></label>


                    <select class="form-control" name="posisi" data-plugin="xin_select" data-placeholder="posisi/jabatan">
                      <option value=""></option>
                      <?php foreach ($designations_list as $posisi) { ?>
                        <option value="<?php echo $posisi->designation_id ?>" <?php if ($designation_id == $posisi->designation_id) : ?> selected <?php endif; ?>><?php echo $posisi->designation_name ?></option>
                      <?php } ?>
                    </select>

                  </div>
                </div>

              </div>

              <div class="row">

                <!--TANGGAL JOIN-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="date_of_join"><?php echo $this->lang->line('xin_employee_doj'); ?><i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control date" readonly placeholder="<?php echo $this->lang->line('xin_employee_doj'); ?>" name="date_of_join" type="text" value="<?php echo $date_of_joining ?>">
                  </div>
                </div>

                <!-- PENEMPATAN -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="penempatan">Kota/Area Penempatan (Sesuai RateCard)<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_placement_area'); ?>" name="penempatan" type="text" value="<?php echo $penempatan ?>">
                  </div>
                </div>

              </div>

              <div class="row">

                <!--REG-TKHL-->
                <div class="col-md-6">

                  <div class="form-group">
                    <label for="e_status">Jenis Dokumen<i class="hrpremium-asterisk">*</i></label>
                    <!-- <select class="form-control" name="e_status" id="e_status" data-plugin="xin_select" data-placeholder="e_status">
                      <option value="">-Pilih Jenis Dokumen-</option>
                      <option value="0" <?php if ($e_status == 0) : ?> selected <?php endif; ?>>Pilih Jenis Dokumen-</option>
                      <option value="1" <?php if ($e_status == 1) : ?> selected <?php endif; ?>>PKWT</option>
                      <option value="2" <?php if ($e_status == 2) : ?> selected <?php endif; ?>>TKHL</option>
                    </select> -->
                    <?php
                    $jenis_dokumen = "";
                    if ($e_status == 1) {
                      $jenis_dokumen = "PKWT";
                    } else if ($e_status == 2) {
                      $jenis_dokumen = "TKHL";
                    }
                    ?>
                    <input class="form-control" hidden readonly placeholder="Jenis Dokumen" name="e_status" id="e_status" type="text" value="<?php echo $e_status; ?>">
                    <input class="form-control" readonly placeholder="Jenis Dokumen" name="jenis_dokumen" id="jenis_dokumen" type="text" value="<?php echo $jenis_dokumen; ?>">
                  </div>
                </div>

                <!--Kateori karyawan-->
                <?php //echo $location_id; 
                ?>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="location_id">Kategori Karyawan<i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="location_id" data-plugin="xin_select" data-placeholder="location_id">
                      <option value="0" <?php if ($location_id == 0) : ?> selected <?php endif; ?>>-Pilih Kategori Karyawan-</option>
                      <option value="1" <?php if ($location_id == 1) : ?> selected <?php endif; ?>>In House</option>
                      <option value="2" <?php if ($location_id == 2) : ?> selected <?php endif; ?>>Area</option>
                      <option value="3" <?php if ($location_id == 3) : ?> selected <?php endif; ?>>Ratecard</option>
                      <option value="4" <?php if ($location_id == 4) : ?> selected <?php endif; ?>>Project</option>
                    </select>
                  </div>
                </div>

                <!-- PENEMPATAN -->
                <div class="col-md-6">
                </div>

              </div>

              <!-- end row -->
            </div>
          </div>

          <!-- Section Dokumen Karyawan -->
          <br><span class="card-header-title mr-2"><strong>DOKUMEN</strong> KARYAWAN</span>
          <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;"><br>
          <!-- baris 1 -->
          <div class="form-row">
            <!-- upload ktp -->
            <div class="form-group col-md-2">
              <?php
              //untuk menghindari cache image (saat ganti gambar, gambar masuk tapi tampilan masih mengambil cache iamge lama) 
              $t = time();
              // $ktp = '';
              if ($ktp == "" || $ktp == "0") {
                $tesfile1 = base_url('/uploads/document/ktp/') . "default.jpg";
                $file_ada = "";
              } else {
                $tesfile1 = base_url('/uploads/document/ktp/') . $ktp . "?" . $t;
                $file_ada = "ada";
              }

              $parameterfile1 = substr($tesfile1, -14);
              ?>

              <label>Foto KTP</label>
              <embed class="form-group col-md-12" id="output_ktp" type='<?php if (substr($parameterfile1, 0, 3) == "pdf") {
                                                                          echo "application/pdf";
                                                                        } else {
                                                                          echo "image/jpg";
                                                                        }
                                                                        ?>' src="<?php echo $tesfile1; ?>"></embed>
              <a <?php if ($file_ada == "") : ?> hidden <?php endif; ?> class="btn btn-primary btn-sm btn-lg btn-block" href="<?php echo $tesfile1; ?>" target="_blank">Buka File</a>
            </div>

            <!-- upload kk -->
            <div class="form-group col-md-2">
              <?php
              //untuk menghindari cache image (saat ganti gambar, gambar masuk tapi tampilan masih mengambil cache iamge lama) 
              $t = time(); ?>
              <?php if ($kk == "" || $kk == "0") {
                $tesfile2 = base_url('/uploads/document/kk/') . "default.jpg";
                $file_ada = "";
              } else {
                $file_ada = "ada";
                // $kk = '';
                $tesfile2 = base_url('/uploads/document/kk/') . $kk . "?" . $t;
              }
              $parameterfile2 = substr($tesfile2, -14);
              ?>
              <label>Foto KK</label>
              <embed class="form-group col-md-12" id="output_kk" type='<?php if (substr($parameterfile2, 0, 3) == "pdf") {
                                                                          echo "application/pdf";
                                                                        } else {
                                                                          echo "image/jpg";
                                                                        }
                                                                        ?>' src="<?php echo $tesfile2; ?>"></embed>
              <a <?php if ($file_ada == "") : ?> hidden <?php endif; ?> class="btn btn-primary btn-sm btn-lg btn-block" href="<?php echo $tesfile2; ?>" target="_blank">Buka File</a>
            </div>

            <!-- upload npwp -->
            <div class="form-group col-md-2">
              <?php
              //untuk menghindari cache image (saat ganti gambar, gambar masuk tapi tampilan masih mengambil cache iamge lama) 
              $t = time(); ?>
              <?php if ($file_npwp == "" || $file_npwp == "0") {
                $tesfile3 = base_url('/uploads/document/npwp/') . "default.jpg";
                $file_ada = "";
              } else {
                $file_ada = "ada";
                // $file_npwp = '';
                $tesfile3 = base_url('/uploads/document/npwp/') . $file_npwp . "?" . $t;
              }
              $parameterfile3 = substr($tesfile3, -14);
              ?>
              <label>Foto NPWP</label>
              <embed class="form-group col-md-12" id="output_npwp" type='<?php if (substr($parameterfile3, 0, 3) == "pdf") {
                                                                            echo "application/pdf";
                                                                          } else {
                                                                            echo "image/jpg";
                                                                          }
                                                                          ?>' src="<?php echo $tesfile3; ?>"></embed>
              <a <?php if ($file_ada == "") : ?> hidden <?php endif; ?> class="btn btn-primary btn-sm btn-lg btn-block" href="<?php echo $tesfile3; ?>" target="_blank">Buka File</a>
            </div>
            <div class="form-group col-md-2">
              <?php
              //untuk menghindari cache image (saat ganti gambar, gambar masuk tapi tampilan masih mengambil cache iamge lama) 
              $t = time(); ?>
              <?php if ($ijazah == "" || $ijazah == "0") {
                $tesfile4 = base_url('/uploads/document/ijazah/') . "default.jpg";
                $file_ada = "";
              } else {
                $file_ada = "ada";
                // $ijazah = '';
                $tesfile4 = base_url('/uploads/document/ijazah/') . $ijazah . "?" . $t;
              }
              $parameterfile4 = substr($tesfile4, -14);
              ?>
              <label>Foto Ijazah</label>
              <embed class="form-group col-md-12" id="output_ijazah" type='<?php if (substr($parameterfile4, 0, 3) == "pdf") {
                                                                              echo "application/pdf";
                                                                            } else {
                                                                              echo "image/jpg";
                                                                            }
                                                                            ?>' src="<?php echo $tesfile4; ?>"></embed>
              <a <?php if ($file_ada == "") : ?> hidden <?php endif; ?> class="btn btn-primary btn-sm btn-lg btn-block" href="<?php echo $tesfile4; ?>" target="_blank">Buka File</a>
            </div>

            <!-- upload CV -->
            <div class="form-group col-md-2">
              <?php
              //untuk menghindari cache image (saat ganti gambar, gambar masuk tapi tampilan masih mengambil cache iamge lama) 
              $t = time(); ?>
              <?php if ($civi == "" || $civi == "0") {
                $tesfile5 = base_url('/uploads/document/cv/') . "default.jpg";
                $file_ada = "";
              } else {
                $file_ada = "ada";
                // $civi = '';
                $tesfile5 = base_url('/uploads/document/cv/') . $civi . "?" . $t;
              }
              $parameterfile5 = substr($tesfile5, -14);
              ?>
              <label>Foto CV</label>
              <embed class="form-group col-md-12" id="output_cv" type='<?php if (substr($parameterfile5, 0, 3) == "pdf") {
                                                                          echo "application/pdf";
                                                                        } else {
                                                                          echo "image/jpg";
                                                                        }
                                                                        ?>' src="<?php echo $tesfile5; ?>"></embed>
              <a <?php if ($file_ada == "") : ?> hidden <?php endif; ?> class="btn btn-primary btn-sm btn-lg btn-block" href="<?php echo $tesfile5; ?>" target="_blank">Buka File</a>
            </div>

            <!-- upload SKCK -->
            <div class="form-group col-md-2">
              <?php
              //untuk menghindari cache image (saat ganti gambar, gambar masuk tapi tampilan masih mengambil cache iamge lama) 
              $t = time(); ?>
              <?php if ($skck == "" || $skck == "0") {
                $tesfile6 = base_url('/uploads/document/skck/') . "default.jpg";
                $file_ada = "";
              } else {
                $file_ada = "ada";
                // $skck = '';
                $tesfile6 = base_url('/uploads/document/skck/') . $skck . "?" . $t;
              }
              $parameterfile6 = substr($tesfile6, -14);
              ?>
              <label>Foto SKCK</label>
              <embed class="form-group col-md-12" id="output_skck" type='<?php if (substr($parameterfile6, 0, 3) == "pdf") {
                                                                            echo "application/pdf";
                                                                          } else {
                                                                            echo "image/jpg";
                                                                          }
                                                                          ?>' src="<?php echo $tesfile6; ?>"></embed>
              <a <?php if ($file_ada == "") : ?> hidden <?php endif; ?> class="btn btn-primary btn-sm btn-lg btn-block" href="<?php echo $tesfile6; ?>" target="_blank">Buka File</a>
            </div>
          </div>

          <!-- Section Paket Gaji Karyawan -->
          <br><span class="card-header-title mr-2"><strong>PAKET GAJI</strong> KARYAWAN</span>
          <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;"><br>
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
                    <input class="form-control" placeholder="0" name="tunjangan_jabatan" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_jabatan); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah2">
                  </div>
                </div>

                <!--TUNJANGAN AREA-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_area" class="control-label">Tunjangan Area<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_area" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_area); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah3">
                  </div>
                </div>

                <!--TUNJANGAN MASA KERJA-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_masakerja">Tunjangan Masa Kerja<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_masakerja" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_masakerja); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah4">
                  </div>
                </div>
              </div>

              <div class="row">

                <!--TUNJANGAN MAKAN-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_makan" class="control-label">Tunjangan Makan<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_makan" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_konsumsi); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah5">
                  </div>
                </div>

                <!--TUNJANGAN TRANSPORT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_transport" class="control-label">Tunjangan Transport<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_transport" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_transport); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah6">
                  </div>
                </div>

                <!--TUNJANGAN KOMUNIKASI-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_komunikasi" class="control-label">Tunjangan Komunikasi<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_komunikasi" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_comunication); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah7">
                  </div>
                </div>

                <!--TUNJANGAN DEVICE-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_device" class="control-label">Tunjangan Laptop/HP<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_device" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_device); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah8">
                  </div>
                </div>

              </div>

              <div class="row">

                <!--TUNJANGAN TEMPAT TINGGAL-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_tempat_tinggal">Tunjangan Tempat Tinggal<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_tempat_tinggal" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_residence_cost); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah9">
                  </div>
                </div>

                <!--TUNJANGAN RENTAL-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_rental">Tunjangan Rental<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_rental" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_rent); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah10">
                  </div>
                </div>

                <!--TUNJANGAN PARKIR-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_parkir" class="control-label">Tunjangan Parkir<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_parkir" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_parking); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah11">
                  </div>
                </div>

                <!--TUNJANGAN KESEHATAN-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_kesehatan" class="control-label">Tunjangan Kesehatan<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_kesehatan" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_medichine); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah12">
                  </div>
                </div>

              </div>

              <div class="row">

                <!--TUNJANGAN AKOMODASI-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_akomodasi">Tunjangan Akomodasi<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_akomodasi" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_akomodsasi); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah13">
                  </div>
                </div>

                <!--TUNJANGAN KASIR-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_kasir" class="control-label">Tunjangan Kasir<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_kasir" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_kasir); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah14">
                  </div>
                </div>

                <!--TUNJANGAN OPERATIONAL-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_operational" class="control-label">Tunjangan Operational<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_operational" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_operational); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah15">
                  </div>
                </div>
              </div>


              <div class="row">

                <!--TUNJANGAN MAKAN TRANSPORT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_makan_trans" class="control-label">Tunjangan Makan & Transport<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_makan_trans" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_trans_meal); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah16">
                  </div>
                </div>

                <!--TUNJANGAN TRANSPORT RENTAL-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="tunjangan_trans_rent" class="control-label">Tunjangan Transport & Rental<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="tunjangan_trans_rent" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_trans_rent); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah17">
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
                    <input class="form-control date" readonly placeholder="YYYY-MM-DD" name="join_date_pkwt" type="text" value="<?php echo $contract_start; ?>">
                  </div>
                </div>

                <!--TANGGAL AKHIR KONTRAK-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pkwt_end_date">Tanggal Akhir Kontrak<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control date" readonly placeholder="YYYY-MM-DD" name="pkwt_end_date" type="text" value="<?php echo $contract_end; ?>">
                  </div>
                </div>

              </div>

              <div class="row">
                <!--PERIODE KONTRAK-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="waktu_kontrak">Waktu Kontrak<i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="waktu_kontrak" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('xin_e_details_office_location'); ?>">
                      <option value="1" <?php if ($contract_periode == '1') : ?> selected <?php endif; ?>>1 (Bulan)</option>
                      <option value="2" <?php if ($contract_periode == '2') : ?> selected <?php endif; ?>>2 (Bulan)</option>
                      <option value="3" <?php if ($contract_periode == '3') : ?> selected <?php endif; ?>>3 (Bulan)</option>
                      <option value="4" <?php if ($contract_periode == '4') : ?> selected <?php endif; ?>>4 (Bulan)</option>
                      <option value="5" <?php if ($contract_periode == '5') : ?> selected <?php endif; ?>>5 (Bulan)</option>
                      <option value="6" <?php if ($contract_periode == '6') : ?> selected <?php endif; ?>>6 (Bulan)</option>
                      <option value="7" <?php if ($contract_periode == '7') : ?> selected <?php endif; ?>>7 (Bulan)</option>
                      <option value="8" <?php if ($contract_periode == '8') : ?> selected <?php endif; ?>>8 (Bulan)</option>
                      <option value="9" <?php if ($contract_periode == '9') : ?> selected <?php endif; ?>>9 (Bulan)</option>
                      <option value="10" <?php if ($contract_periode == '10') : ?> selected <?php endif; ?>>10 (Bulan)</option>
                      <option value="12" <?php if ($contract_periode == '12') : ?> selected <?php endif; ?>>12 (Bulan)</option>
                    </select>
                  </div>
                </div>

                <!-- HK -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="hari_kerja">Hari Kerja<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="0" name="hari_kerja" type="text" value="<?php echo $hari_kerja; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2">
                  </div>
                </div>
              </div>

              <div class="row">
                <!--PERIODE KONTRAK-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label control-label">Tanggal CUT-START</label>
                    <input class="form-control" placeholder="0" name="cut_start" type="text" value="<?php echo $cut_start; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2">

                  </div>
                </div>

                <!-- HK -->
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label control-label">Tanggal CUT-OFF</label>
                    <input class="form-control" placeholder="0" name="cut_off" type="text" value="<?php echo $cut_off; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2">
                  </div>
                </div>

                <!-- HK -->
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">Tanggal Penggajian</label><input class="form-control" placeholder="0" name="date_payment" type="text" value="<?php echo $date_payment; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="2">
                  </div>
                </div>

              </div>


              <!-- end row -->
            </div>
          </div>
        </div>

      </div>

      <div class="form-actions box-footer">
        <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> ' . $this->lang->line('xin_save'))); ?>
        <button id="button_verifikasi" class="btn btn-success ladda-button" data-style="expand-right">Verifikasi Data</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>

  </div>

<?php } ?>
<div class="card" hidden>
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all'); ?></strong> <?php echo $this->lang->line('xin_companies'); ?></span> </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th>No.</th>
            <th><?php echo $this->lang->line('xin_request_employee_status'); ?></th>
            <th>NIK-KTP</th>
            <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_employees_full_name'); ?></th>
            <th><?php echo $this->lang->line('left_projects'); ?></th>
            <th><?php echo $this->lang->line('left_sub_projects'); ?></th>
            <th><?php echo $this->lang->line('left_department'); ?></th>
            <th><?php echo $this->lang->line('left_designation'); ?></th>
            <th><?php echo $this->lang->line('xin_placement'); ?></th>
            <th><?php echo $this->lang->line('xin_employee_doj'); ?></th>
            <th><?php echo $this->lang->line('xin_e_details_contact'); ?></th>
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

<!-- SCRIPT INITIATE VALIDATION -->
<script type=text/javascript>
  //read variable
  var baseURL = "<?php echo base_url(); ?>";
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
  var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
  var nama_lock = "<?php print($nama_lock); ?>";
  var ktp_lock = "<?php print($ktp_lock); ?>";
  var kk_lock = "<?php print($kk_lock); ?>";
  var user_id = "<?php print($session['user_id']); ?>";
  var user_name = "<?php print($user_info['0']->first_name); ?>";
  var employee_id = "<?php print($secid); ?>";

  var nik_validation = "<?php echo $nik_validation; ?>";
  var kk_validation = "<?php print($kk_validation); ?>";
  var nama_validation = "<?php print($nama_validation); ?>";
  var bank_validation = "<?php print($bank_validation); ?>";
  var norek_validation = "<?php print($norek_validation); ?>";
  var pemilik_rekening_validation = "<?php print($pemilik_rekening_validation); ?>";

  //initiate state validation
  if (nik_validation == 0) {
    $('.icon-verify-nik').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");
    if (nomor_ktp.readOnly) document.getElementById("nomor_ktp").removeAttribute("readonly");
    if (nik_modal.readOnly) document.getElementById("nik_modal").removeAttribute("readonly");
  } else if (nik_validation == 1) {
    nomor_ktp.setAttribute("readonly", "readonly");
    nik_modal.setAttribute("readonly", "readonly");
    $('.icon-verify-nik').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");
  }
  if (kk_validation == 0) {
    $('.icon-verify-kk').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");
    if (nomor_kk.readOnly) document.getElementById("nomor_kk").removeAttribute("readonly");
    if (kk_modal.readOnly) document.getElementById("kk_modal").removeAttribute("readonly");
  } else if (kk_validation == 1) {
    nomor_kk.setAttribute("readonly", "readonly");
    kk_modal.setAttribute("readonly", "readonly");
    $('.icon-verify-kk').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");
  }
  if (nama_validation == 0) {
    $('.icon-verify-nama').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");
    if (fullname.readOnly) document.getElementById("fullname").removeAttribute("readonly");
    if (nama_modal.readOnly) document.getElementById("nama_modal").removeAttribute("readonly");
  } else if (nama_validation == 1) {
    fullname.setAttribute("readonly", "readonly");
    nama_modal.setAttribute("readonly", "readonly");
    $('.icon-verify-nama').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");
  }
  if (bank_validation == 0) {
    $('.icon-verify-bank').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");
    if (bank_name2.disabled) document.getElementById("bank_name2").removeAttribute("disabled");
    if (bank_modal.disabled) document.getElementById("bank_modal").removeAttribute("disabled");
  } else if (bank_validation == 1) {
    bank_modal.setAttribute("disabled", "disabled");
    bank_name2.setAttribute("disabled", "disabled");
    $('.icon-verify-bank').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");
  }
  if (norek_validation == 0) {
    $('.icon-verify-norek').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");
    if (no_rek.readOnly) document.getElementById("no_rek").removeAttribute("readonly");
    if (rekening_modal.readOnly) document.getElementById("rekening_modal").removeAttribute("readonly");
  } else if (norek_validation == 1) {
    no_rek.setAttribute("readonly", "readonly");
    rekening_modal.setAttribute("readonly", "readonly");
    $('.icon-verify-norek').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");
  }
  if (pemilik_rekening_validation == 0) {
    $('.icon-verify-pemilik-rek').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");
    if (pemilik_rekening.readOnly) document.getElementById("pemilik_rekening").removeAttribute("readonly");
    if (pemilik_rekening_modal.readOnly) document.getElementById("pemilik_rekening_modal").removeAttribute("readonly");
  } else if (pemilik_rekening_validation == 1) {
    pemilik_rekening.setAttribute("readonly", "readonly");
    pemilik_rekening_modal.setAttribute("readonly", "readonly");
    $('.icon-verify-pemilik-rek').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");
  }

  // alert(nik_validation);
</script>

<!-- Chained Dropdown (Project - Jenis Dokumen) -->
<script type='text/javascript'>
  // baseURL variable
  var flag_ktp = 0;
  var flag_kk = 0;
  var flag_rekening = 0;
  var flag_api_rekening = 0;
  var baseURL = "<?php echo base_url(); ?>";
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

  $(document).ready(function() {

    // Project Change - Jenis Dokumen (on Change)
    $('#aj_project').change(function() {
      var project = $(this).val();
      //alert("masuk javascript");

      // AJAX request
      $.ajax({
        url: '<?= base_url() ?>admin/employee_request_cancelled/getDocId/',
        method: 'post',
        data: {
          [csrfName]: csrfHash,
          project: project
        },
        dataType: 'json',
        success: function(response) {
          // Add options
          $.each(response, function(index, data) {
            document.getElementById("e_status").value = data['doc_id'];
            if (data['doc_id'] == 1) {
              document.getElementById("jenis_dokumen").value = "PKWT";
            } else if (data['doc_id'] == 2) {
              document.getElementById("jenis_dokumen").value = "TKHL";
            }
            //$('#jenis_dokumen').append('<input class="form-control" readonly placeholder="Nama Ibu" name="e_status" id="e_status" type="text" value="' + data['title'] + '">');
          }).show();
        }
      });
      //alert("selesai ajax");
    });

    // Bank Change - isi value ke variable hidden bank_name (untuk save)
    $('#bank_name2').change(function() {
      var bank = $("#bank_name2").val();
      document.getElementById("bank_name").value = bank;
    });


  });
</script>

<!-- Tombol Show Verifikasi Data -->
<script type="text/javascript">
  document.getElementById("button_verifikasi").onclick = function(e) {
    e.preventDefault();

    $('#verifikasiModal').modal('show');
  };
</script>

<!-- Tombol Show/hide KTP Modal -->
<script type="text/javascript">
  document.getElementById("button_show_ktp_modal").onclick = function(e) {
    e.preventDefault();

    if (flag_ktp == 0) {
      var filektp = "<?php echo $tesfile1; ?>";

      var html_text = "";

      var html_text = html_text + "<div class='row'>";
      var html_text = html_text + "<div class='form-group col-md-12'>";
      var html_text = html_text + "<label>Foto KTP  </label>";
      var html_text = html_text + "<button id='button_verify_bank_modal' class='btn btn-xs btn-outline-success' data-style='expand-right'>Open File</button>";
      var html_text = html_text + "<embed class='form-group col-md-12' id='output_ktp' type='image/jpg' src='" + filektp + "'></embed>";
      var html_text = html_text + "</div>";
      var html_text = html_text + "</div>";

      $('.ktp-modal').html(html_text);
      flag_ktp = 1;
    } else if (flag_ktp == 1) {
      $('.ktp-modal').html("");
      flag_ktp = 0;
    }

  };
</script>

<!-- Tombol Show/hide KK Modal -->
<script type="text/javascript">
  document.getElementById("button_show_kk_modal").onclick = function(e) {
    e.preventDefault();

    if (flag_kk == 0) {
      var filekk = "<?php echo $tesfile2; ?>";

      var html_text = "";

      var html_text = html_text + "<div class='row'>";
      var html_text = html_text + "<div class='form-group col-md-12'>";
      var html_text = html_text + "<label>Foto KK  </label>";
      var html_text = html_text + "<button id='button_verify_bank_modal' class='btn btn-xs btn-outline-success' data-style='expand-right'>Open File</button>";
      var html_text = html_text + "<embed class='form-group col-md-12' id='output_ktp' type='image/jpg' src='" + filekk + "'></embed>";
      var html_text = html_text + "</div>";
      var html_text = html_text + "</div>";

      $('.kk-modal').html(html_text);
      flag_kk = 1;
    } else if (flag_kk == 1) {
      $('.kk-modal').html("");
      flag_kk = 0;
    }

  };
</script>

<!-- Tombol Show/hide Rekening Modal -->
<script type="text/javascript">
  document.getElementById("button_show_rekening_modal").onclick = function(e) {
    e.preventDefault();

    if (flag_rekening == 0) {
      var bank_id = $("#bank_modal").val();
      // var nomor_rekening = "<?php echo $nomor_rek; ?>";
      var nomor_rekening = $("#rekening_modal").val();
      var bank_code = "<?php echo $nomor_rek; ?>";

      // alert(bank_id);
      // alert(nomor_rekening);

      var html_text = "";

      html_text = html_text + "<div class='row'>";
      html_text = html_text + "<div class='form-group col-md-12'>";
      html_text = html_text + "<label>Rekening  </label>";
      html_text = html_text + "<br>LOADING DATA ....";
      html_text = html_text + "</div>";
      html_text = html_text + "</div>";

      $('.rekening-modal').html(html_text);

      // AJAX request
      $.ajax({
        url: '<?= base_url() ?>registrasi/tes_API_bank/' + bank_id + "/" + nomor_rekening,
        method: 'get',
        success: function(response) {
          // alert(response);
          var res = jQuery.parseJSON(response);
          // var res2 = jQuery.parseJSON(res);
          // html_text = "";
          if (res['status'] == true) {
            html_text = "";
            html_text = html_text + "<div class='row'>";
            html_text = html_text + "<div class='form-group col-md-12'>";
            html_text = html_text + "<label>Rekening  </label>";
            html_text = html_text + "<br>Pesan: " + res['msg'] + "<br>";
            html_text = html_text + "kode bank: " + res['data']['bankcode'] + "<br>";
            html_text = html_text + "nama bank: " + res['data']['bankname'] + "<br>";
            html_text = html_text + "nomor rekening: " + res['data']['accountnumber'] + "<br>";
            html_text = html_text + "nama pemilik rekening: " + res['data']['accountname'] + "<br>";
            html_text = html_text + "</div>";
            html_text = html_text + "</div>";

          } else {
            html_text = "";
            html_text = html_text + "<div class='row'>";
            html_text = html_text + "<div class='form-group col-md-12'>";
            html_text = html_text + "<label>Rekening  </label>";
            html_text = html_text + "<br>Pesan: " + res['msg'] + "<br>";
            html_text = html_text + "</div>";
            html_text = html_text + "</div>";
          }

          $('.rekening-modal').html(html_text);
          flag_rekening = 1;
        },
        error: function(xhr, status, error) {
          // var res = jQuery.parseJSON(response);
          html_text = "";
          html_text = html_text + "<div class='row'>";
          html_text = html_text + "<div class='form-group col-md-12'>";
          html_text = html_text + "<label>Rekening  </label>";
          html_text = html_text + "<br>" + xhr.responseText;
          html_text = html_text + "</div>";
          html_text = html_text + "</div>";
          $('.rekening-modal').html(html_text);
          flag_rekening = 1;
        }
      });
    } else if (flag_rekening == 1) {
      $('.rekening-modal').html("");
      flag_rekening = 0;
    }

  };
</script>

<!-- Tombol Close Modal Verifikasi Data -->
<script type="text/javascript">
  document.getElementById("close_modal").onclick = function(e) {
    e.preventDefault();

    $('.ktp-modal').html("");
    $('.kk-modal').html("");
    $('.rekening-modal').html("");
    // $('.api-rekening-modal').html("");
    flag_ktp = 0;
    flag_kk = 0;
    flag_rekening = 0;
    // flag_api_rekening = 0;
    $('#verifikasiModal').modal('hide');

    // alert("masuk fungsi verifikasi data.");
  };
</script>

<!-- Tombol Verifikasi Data NIK -->
<script type="text/javascript">
  document.getElementById("button_verify_nik_modal").onclick = function(e) {
    e.preventDefault();

    var nik = $("#nik_modal").val();
    var nik_lama = "<?php echo $ktp_no; ?>";
    var id_employee = "<?php echo $secid; ?>";
    var nama_kolom = "nik";
    var status = "1";

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employee_request_cancelled/valiadsi_employee_request/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: nik_lama,
        nilai_sesudah: nik,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        nomor_ktp.setAttribute("readonly", "readonly");
        nik_modal.setAttribute("readonly", "readonly");

        document.getElementById("nomor_ktp").value = nik;

        $('.icon-verify-nik').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");
        alert("Berhasil melakukan verifikasi NIK.\nNIK Lama : " + nik_lama + "\nNik Baru : " + nik);
      },
      error: function(xhr, status, error) {
        // var res = jQuery.parseJSON(response);
        html_text = "Gagal melakukan verifikasi NIK.\n";
        html_text = html_text + "Error :\n";
        html_text = html_text + xhr.responseText;
        alert(html_text)
      }
    });

  };
</script>

<!-- Tombol Cancel Verifikasi Data NIK -->
<script type="text/javascript">
  document.getElementById("button_unverify_nik_modal").onclick = function(e) {
    e.preventDefault();

    var nik = $("#nik_modal").val();
    var nik_lama = "<?php echo $ktp_no; ?>";
    var id_employee = "<?php echo $secid; ?>";
    var nama_kolom = "nik";
    var status = "0";

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employee_request_cancelled/valiadsi_employee_request/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: nik_lama,
        nilai_sesudah: nik,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        document.getElementById("nomor_ktp").removeAttribute("readonly");
        document.getElementById("nik_modal").removeAttribute("readonly");

        $('.icon-verify-nik').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

        alert("Berhasil melakukan cancel verifikasi NIK.\nNIK Lama : " + nik_lama + "\nNik Baru : " + nik);
      },
      error: function(xhr, status, error) {
        // var res = jQuery.parseJSON(response);
        html_text = "Gagal melakukan cancel verifikasi NIK.\n";
        html_text = html_text + "Error :\n";
        html_text = html_text + xhr.responseText;
        alert(html_text)
      }
    });

  };
</script>

<!-- Tombol Verifikasi Data KK -->
<script type="text/javascript">
  document.getElementById("button_verify_kk_modal").onclick = function(e) {
    e.preventDefault();

    var kk = $("#kk_modal").val();
    var kk_lama = "<?php echo $kk_no; ?>";
    var id_employee = "<?php echo $secid; ?>";
    var nama_kolom = "kk";
    var status = "1";

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employee_request_cancelled/valiadsi_employee_request/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: kk_lama,
        nilai_sesudah: kk,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        nomor_kk.setAttribute("readonly", "readonly");
        kk_modal.setAttribute("readonly", "readonly");

        document.getElementById("nomor_kk").value = kk;

        $('.icon-verify-kk').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");
        alert("Berhasil melakukan verifikasi KK.\nKK Lama : " + kk_lama + "\nKK Baru : " + kk);
      },
      error: function(xhr, status, error) {
        // var res = jQuery.parseJSON(response);
        html_text = "Gagal melakukan verifikasi KK.\n";
        html_text = html_text + "Error :\n";
        html_text = html_text + xhr.responseText;
        alert(html_text)
      }
    });

  };
</script>

<!-- Tombol Cancel Verifikasi Data KK -->
<script type="text/javascript">
  document.getElementById("button_unverify_kk_modal").onclick = function(e) {
    e.preventDefault();

    var kk = $("#kk_modal").val();
    var kk_lama = "<?php echo $kk_no; ?>";
    var id_employee = "<?php echo $secid; ?>";
    var nama_kolom = "kk";
    var status = "0";

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employee_request_cancelled/valiadsi_employee_request/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: kk_lama,
        nilai_sesudah: kk,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        document.getElementById("nomor_kk").removeAttribute("readonly");
        document.getElementById("kk_modal").removeAttribute("readonly");

        $('.icon-verify-kk').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");
        alert("Berhasil melakukan cancel verifikasi KK.\nKK Lama : " + kk_lama + "\nKK Baru : " + kk);
      },
      error: function(xhr, status, error) {
        // var res = jQuery.parseJSON(response);
        html_text = "Gagal melakukan verifikasi KK.\n";
        html_text = html_text + "Error :\n";
        html_text = html_text + xhr.responseText;
        alert(html_text)
      }
    });

  };
</script>

<!-- Tombol Verifikasi Data Nama Lengkap -->
<script type="text/javascript">
  document.getElementById("button_verify_nama_modal").onclick = function(e) {
    e.preventDefault();

    var nama = $("#nama_modal").val();
    var nama_lama = "<?php echo $fullname; ?>";
    var id_employee = "<?php echo $secid; ?>";
    var nama_kolom = "nama";
    var status = "1";

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employee_request_cancelled/valiadsi_employee_request/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: nama_lama,
        nilai_sesudah: nama,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        fullname.setAttribute("readonly", "readonly");
        nama_modal.setAttribute("readonly", "readonly");

        document.getElementById("fullname").value = nama;

        $('.icon-verify-nama').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

        alert("Berhasil melakukan verifikasi Nama.\nNama Lama : " + nama_lama + "\nNama Baru : " + nama);
      },
      error: function(xhr, status, error) {
        // var res = jQuery.parseJSON(response);
        html_text = "Gagal melakukan verifikasi Nama.\n";
        html_text = html_text + "Error :\n";
        html_text = html_text + xhr.responseText;
        alert(html_text)
      }
    });

  };
</script>

<!-- Tombol Cancel Verifikasi Data Nama Lengkap -->
<script type="text/javascript">
  document.getElementById("button_unverify_nama_modal").onclick = function(e) {
    e.preventDefault();

    var nama = $("#nama_modal").val();
    var nama_lama = "<?php echo $fullname; ?>";
    var id_employee = "<?php echo $secid; ?>";
    var nama_kolom = "nama";
    var status = "0";

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employee_request_cancelled/valiadsi_employee_request/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: nama_lama,
        nilai_sesudah: nama,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        document.getElementById("fullname").removeAttribute("readonly");
        document.getElementById("nama_modal").removeAttribute("readonly");

        $('.icon-verify-nama').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

        alert("Berhasil melakukan cancel verifikasi Nama.\nNama Lama : " + nama_lama + "\nNama Baru : " + nama);
      },
      error: function(xhr, status, error) {
        // var res = jQuery.parseJSON(response);
        html_text = "Gagal melakukan verifikasi Nama.\n";
        html_text = html_text + "Error :\n";
        html_text = html_text + xhr.responseText;
        alert(html_text)
      }
    });

  };
</script>

<!-- Tombol Verifikasi Data Bank -->
<script type="text/javascript">
  document.getElementById("button_verify_bank_modal").onclick = function(e) {
    e.preventDefault();

    var bank = $("#bank_modal").val();
    var bank_lama = "<?php echo $bank_id; ?>";
    var id_employee = "<?php echo $secid; ?>";
    var nama_kolom = "bank";
    var status = "1";

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employee_request_cancelled/valiadsi_employee_request/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: bank_lama,
        nilai_sesudah: bank,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        $("#bank_name2").val(bank).change();
        document.getElementById("bank_name").value = bank;

        bank_modal.setAttribute("disabled", "disabled");
        bank_name2.setAttribute("disabled", "disabled");

        $('.icon-verify-bank').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

        alert("Berhasil melakukan verifikasi Bank.\nBank Lama : " + bank_lama + "\nBank Baru : " + bank);
      },
      error: function(xhr, status, error) {
        // var res = jQuery.parseJSON(response);
        html_text = "Gagal melakukan verifikasi Bank.\n";
        html_text = html_text + "Error :\n";
        html_text = html_text + xhr.responseText;
        alert(html_text)
      }
    });

  };
</script>

<!-- Tombol Cancel Verifikasi Data Bank -->
<script type="text/javascript">
  document.getElementById("button_unverify_bank_modal").onclick = function(e) {
    e.preventDefault();

    var bank = $("#bank_modal").val();
    var bank_lama = "<?php echo $bank_id; ?>";
    var id_employee = "<?php echo $secid; ?>";
    var nama_kolom = "bank";
    var status = "0";

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employee_request_cancelled/valiadsi_employee_request/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: bank_lama,
        nilai_sesudah: bank,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        document.getElementById("bank_modal").removeAttribute("disabled");
        document.getElementById("bank_name2").removeAttribute("disabled");

        $('.icon-verify-bank').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

        alert("Berhasil melakukan cancel verifikasi Bank.\nBank Lama : " + bank_lama + "\nBank Baru : " + bank);
      },
      error: function(xhr, status, error) {
        // var res = jQuery.parseJSON(response);
        html_text = "Gagal melakukan verifikasi Bank.\n";
        html_text = html_text + "Error :\n";
        html_text = html_text + xhr.responseText;
        alert(html_text)
      }
    });

  };
</script>

<!-- Tombol Verifikasi Data Nomor Rekening -->
<script type="text/javascript">
  document.getElementById("button_verify_norek_modal").onclick = function(e) {
    e.preventDefault();

    var norek = $("#rekening_modal").val();
    var norek_lama = "<?php echo $nomor_rek; ?>";
    var id_employee = "<?php echo $secid; ?>";
    var nama_kolom = "norek";
    var status = "1";

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employee_request_cancelled/valiadsi_employee_request/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: norek_lama,
        nilai_sesudah: norek,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        no_rek.setAttribute("readonly", "readonly");
        rekening_modal.setAttribute("readonly", "readonly");

        document.getElementById("no_rek").value = norek;

        $('.icon-verify-norek').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

        alert("Berhasil melakukan verifikasi Nomor Rekening.\nNomor Rekening Lama : " + norek_lama + "\nNomor Rekening Baru : " + norek);
      },
      error: function(xhr, status, error) {
        // var res = jQuery.parseJSON(response);
        html_text = "Gagal melakukan verifikasi Nomor Rekening.\n";
        html_text = html_text + "Error :\n";
        html_text = html_text + xhr.responseText;
        alert(html_text)
      }
    });

  };
</script>

<!-- Tombol Cancel Verifikasi Data Nomor Rekening -->
<script type="text/javascript">
  document.getElementById("button_unverify_norek_modal").onclick = function(e) {
    e.preventDefault();

    var norek = $("#rekening_modal").val();
    var norek_lama = "<?php echo $nomor_rek; ?>";
    var id_employee = "<?php echo $secid; ?>";
    var nama_kolom = "norek";
    var status = "0";

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employee_request_cancelled/valiadsi_employee_request/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: norek_lama,
        nilai_sesudah: norek,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        document.getElementById("no_rek").removeAttribute("readonly");
        document.getElementById("rekening_modal").removeAttribute("readonly");

        $('.icon-verify-norek').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

        alert("Berhasil melakukan cancel verifikasi Nomor Rekening.\nNomor Rekening Lama : " + norek_lama + "\nNomor Rekening Baru : " + norek);
      },
      error: function(xhr, status, error) {
        // var res = jQuery.parseJSON(response);
        html_text = "Gagal melakukan verifikasi Nomor Rekening.\n";
        html_text = html_text + "Error :\n";
        html_text = html_text + xhr.responseText;
        alert(html_text)
      }
    });

  };
</script>

<!-- Tombol Verifikasi Data Pemilik Rekening -->
<script type="text/javascript">
  document.getElementById("button_verify_pemilik_rek_modal").onclick = function(e) {
    e.preventDefault();

    var pemilik_rek = $("#pemilik_rekening_modal").val();
    var pemilik_rek_lama = "<?php echo $pemilik_rek; ?>";
    var id_employee = "<?php echo $secid; ?>";
    var nama_kolom = "pemilik_rekening";
    var status = "1";

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employee_request_cancelled/valiadsi_employee_request/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: pemilik_rek_lama,
        nilai_sesudah: pemilik_rek,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        pemilik_rekening.setAttribute("readonly", "readonly");
        pemilik_rekening_modal.setAttribute("readonly", "readonly");

        document.getElementById("pemilik_rekening").value = pemilik_rek;

        $('.icon-verify-pemilik-rek').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

        alert("Berhasil melakukan verifikasi Pemilik Rekening.\nPemilik Rekening Lama : " + pemilik_rek_lama + "\nPemilik Rekening Baru : " + pemilik_rek);
      },
      error: function(xhr, status, error) {
        // var res = jQuery.parseJSON(response);
        html_text = "Gagal melakukan verifikasi Pemilik Rekening.\n";
        html_text = html_text + "Error :\n";
        html_text = html_text + xhr.responseText;
        alert(html_text)
      }
    });

  };
</script>

<!-- Tombol Cancel Verifikasi Data Pemilik Rekening -->
<script type="text/javascript">
  document.getElementById("button_unverify_pemilik_rek_modal").onclick = function(e) {
    e.preventDefault();

    var pemilik_rek = $("#pemilik_rekening_modal").val();
    var pemilik_rek_lama = "<?php echo $pemilik_rek; ?>";
    var id_employee = "<?php echo $secid; ?>";
    var nama_kolom = "pemilik_rekening";
    var status = "0";

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employee_request_cancelled/valiadsi_employee_request/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: pemilik_rek_lama,
        nilai_sesudah: pemilik_rek,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        document.getElementById("pemilik_rekening").removeAttribute("readonly");
        document.getElementById("pemilik_rekening_modal").removeAttribute("readonly");

        $('.icon-verify-pemilik-rek').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

        alert("Berhasil melakukan cancel verifikasi Pemilik Rekening.\nPemilik Rekening Lama : " + pemilik_rek_lama + "\nPemilik Rekening Baru : " + pemilik_rek);
      },
      error: function(xhr, status, error) {
        // var res = jQuery.parseJSON(response);
        html_text = "Gagal melakukan verifikasi Pemilik Rekening.\n";
        html_text = html_text + "Error :\n";
        html_text = html_text + xhr.responseText;
        alert(html_text)
      }
    });

  };
</script>