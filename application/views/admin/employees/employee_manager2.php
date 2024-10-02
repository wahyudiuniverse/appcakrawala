<?php $session = $this->session->userdata('username'); ?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php $leave_user = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>

<!-- FOTO PROFILE -->
<?php
if ($profile_picture != '' && $profile_picture != 'no file') {
  $t = time();
  $de_file = base_url() . 'uploads/profile/' . $profile_picture . '?' . $t;
} else {
  if ($gender == 'L') {
    $de_file = base_url() . 'uploads/profile/default_male.jpg';
  } else {
    $de_file = base_url() . 'uploads/profile/default_female.jpg';
  }
}
?>

<!-- NAMA LENGKAP -->
<?php $full_name = $user[0]->first_name . ' ' . $user[0]->last_name; ?>

<!-- MODAL UNTUK VERIFIKASI -->
<div class="modal fade" id="verifikasiModal" role="dialog" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verifikasiModalLabel">
          <div class="judul-modal-verifikasi">Verifikasi data</div>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-verifikasi">
          <div class="container" id="container_modal_verifikasi">
            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <td style='width:20%'><strong>NIK <span class="icon-verify-nik"></span></strong></td>
                    <td style='width:50%'>
                      <input type='text' id="nik_modal" class='form-control' placeholder='Nomor NIK KTP' value='<?php echo $ktp_no; ?>'>
                      <span id='pesan_nik_verifikasi_modal'></span>
                    </td>
                    <td style='width:30%'>
                      <button id="button_verify_nik_modal" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>
                      <?php if (($user[0]->user_role_id == "1") || ($user[0]->user_role_id == "11")) { ?>
                        <button id="button_unverify_nik_modal" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <td style='width:20%'><strong>KK <span class="icon-verify-kk"></span></strong></td>
                    <td style='width:50%'>
                      <input type='text' id="kk_modal" class='form-control' placeholder='Nomor Kartu Keluarga' value='<?php echo $kk_no; ?>'>
                      <span id='pesan_kk_verifikasi_modal'></span>
                    </td>
                    <td style='width:30%'>
                      <button id="button_verify_kk_modal" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>
                      <?php if (($user[0]->user_role_id == "1") || ($user[0]->user_role_id == "11")) { ?>
                        <button id="button_unverify_kk_modal" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <td style='width:20%'><strong>Nama Lengkap <span class="icon-verify-nama"></span></strong></td>
                    <td style='width:50%'>
                      <input type='text' id="nama_modal" class='form-control' placeholder='Nama Lengkap' value="<?php echo $first_name; ?>">
                      <span id='pesan_nama_verifikasi_modal'></span>
                    </td>
                    <td style='width:30%'>
                      <button id="button_verify_nama_modal" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>
                      <?php if (($user[0]->user_role_id == "1") || ($user[0]->user_role_id == "11")) { ?>
                        <button id="button_unverify_nama_modal" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <td style='width:20%'><strong>Bank <span class="icon-verify-bank"></span></strong></td>
                    <td style='width:50%'>
                      <select name="bank_modal" id="bank_modal" class="form-control" data-plugin="select_modal_verifikasi" data-placeholder="<?php echo $this->lang->line('xin_bank_choose_name'); ?>">
                        <option value=""></option>
                        <?php
                        foreach ($list_bank as $bank) {
                        ?>
                          <option value="<?php echo $bank->secid; ?>" <?php if ($id_bank == $bank->secid) : ?> selected <?php endif; ?>> <?php echo $bank->bank_name; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <span id='pesan_bank_verifikasi_modal'></span>
                    </td>
                    <td style='width:30%'>
                      <button id="button_verify_bank_modal" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>
                      <?php if (($user[0]->user_role_id == "1") || ($user[0]->user_role_id == "11")) { ?>
                        <button id="button_unverify_bank_modal" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <td style='width:20%'><strong>Nomor Rekening <span class="icon-verify-norek"></span></strong></td>
                    <td style='width:50%'>
                      <input type='text' id="rekening_modal" class='form-control' placeholder='Nomor Rekening' value='<?php echo $nomor_rek; ?>'>
                      <span id='pesan_norek_verifikasi_modal'></span>
                    </td>
                    <td style='width:30%'>
                      <button id="button_verify_norek_modal" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>
                      <?php if (($user[0]->user_role_id == "1") || ($user[0]->user_role_id == "11")) { ?>
                        <button id="button_unverify_norek_modal" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>
                      <?php } ?>
                    </td>
                  </tr>
                  <tr>
                    <td style='width:20%'><strong>Pemilik Rekening <span class="icon-verify-pemilik-rek"></span></strong></td>
                    <td style='width:50%'>
                      <input type='text' id="pemilik_rekening_modal" class='form-control' placeholder='Pemilik Rekening' value="<?php echo $pemilik_rek; ?>">
                      <span id='pesan_pemilik_rekening_verifikasi_modal'></span>
                    </td>
                    <td style='width:30%'>
                      <button id="button_verify_pemilik_rek_modal" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>
                      <?php if (($user[0]->user_role_id == "1") || ($user[0]->user_role_id == "11")) { ?>
                        <button id="button_unverify_pemilik_rek_modal" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>
                      <?php } ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr class="text-center align-self-center">
                    <td style='width:33.33%'>
                      <button id="button_show_ktp_modal" class="btn btn-xs btn-outline-success" data-style="expand-right">Show/Hide KTP</button>
                    </td>
                    <td style='width:33.33%'>
                      <button id="button_show_kk_modal" class="btn btn-xs btn-outline-success" data-style="expand-right">Show/Hide KK</button>
                    </td>
                    <td style='width:33.33%'>
                      <button id="button_show_rekening_modal" class="btn btn-xs btn-outline-success" data-style="expand-right">Show/Hide Rekening</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="row">
              <div class="rekening-modal col-md-12"></div>
              <div class="ktp-modal col-md-12"></div>
              <div class="kk-modal col-md-12"></div>
              <div class="api-rekening-modal col-md-12"></div>
            </div>
          </div>
        </div>
        <div class="info-modal-verifikasi">
        </div>
      </div>
      <div class="modal-footer">
        <button type='button' id="close_modal" class='btn btn-secondary' data-dismiss='modal'>Close</button>
      </div>
    </div>
  </div>
</div>


<!-- MODAL UNTUK EDIT -->
<div class="modal fade" id="editModal" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">
          <div class="judul-modal"></div>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- <iframe src="" style="zoom:0.60" frameborder="0" height="250" width="99.6%"></iframe> -->
        <div class="isi-modal"></div>
      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <button hidden id='button_save_pin' name='button_save_pin' type='button' class='btn btn-primary'>Save PIN</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL LOADING -->
<div class="modal fade" id="loadingModal" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <!-- <div class="modal-header">
        <h5 class="modal-title" id="loadingModalLabel">Edit Data Diri</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> -->
      <div class="modal-body">

        <div class="col-12 col-md-12 col-auto text-center align-self-center">
          <img src="<?php echo base_url('assets/icon/loading_animation3.gif'); ?>" alt="">
          <h2>LOADING...</h2>
        </div>

      </div>
      <!-- <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <button id='button_save_data_diri' name='button_save_data_diri' type='button' class='btn btn-primary'>Save Data Diri</button>
      </div> -->
    </div>
  </div>
</div>

<!-- MODAL EDIT DATA DIRI -->
<div class="modal fade" id="editDataDiriModal" tabindex="-1" role="dialog" aria-labelledby="editDataDiriModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editDataDiriModalLabel">Edit Data Diri</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- <pre>
          <?php //print_r($session); 
          ?>
        </pre> -->
        <div class="isi-modal-edit-data-diri">
          <div class="container" id="container_modal">
            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <td style='width:25%'><strong>Nama Lengkap <span class="icon-verify-nama"></span></strong></td>
                    <td style='width:75%'>
                      <input id='first_name_modal' name='first_name_modal' type='text' class='form-control' placeholder='Nama Lengkap' value=''>
                      <span id='pesan_first_name_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Jenis Kelamin</strong></td>
                    <td>
                      <select class="form-control" id="gender_modal" name="gender_modal" data-plugin="select_modal" data-placeholder="Jenis Kelamin">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" <?php if ($gender == 'L'): ?> selected <?php endif; ?>>LAKI-LAKI</option>
                        <option value="P" <?php if ($gender == 'P'): ?> selected <?php endif; ?>>PEREMPUAN</option>
                      </select>
                      <span id='pesan_gender_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Tempat Lahir</strong></td>
                    <td>
                      <input id='tempat_lahir_modal' name='tempat_lahir_modal' type='text' class='form-control' placeholder='Tempat Lahir' value=''>
                      <span id='pesan_tempat_lahir_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Tanggal Lahir</strong></td>
                    <td>
                      <input type='date' class='form-control date' name='date_of_birth_modal' id='date_of_birth_modal' placeholder='Tanggal Lahir' value=''>
                      <span id='pesan_date_of_birth_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Pendidikan Terakhir</strong></td>
                    <td>
                      <select class="form-control" id="last_edu_modal" name="last_edu_modal" data-plugin="select_modal" data-placeholder="Pendidikan Terakhir">
                        <option value="">Pilih Pendidikan Terakhir</option>
                        <?php foreach ($all_education as $edu): ?>
                          <option value="<?php echo $edu->education_level_id; ?>" <?php if ($last_edu == $edu->education_level_id): ?> selected <?php endif; ?>><?php echo strtoupper($edu->name); ?></option>
                        <?php endforeach; ?>
                      </select>
                      <span id='pesan_last_edu_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Agama</strong></td>
                    <td>
                      <select class="form-control" id="ethnicity_modal" name="ethnicity_modal" data-plugin="select_modal" data-placeholder="Agama">
                        <option value="">Pilih Agama</option>
                        <?php foreach ($all_ethnicity as $eth): ?>
                          <option value="<?php echo $eth->ethnicity_type_id; ?>" <?php if ($ethnicity_type == $eth->ethnicity_type_id): ?> selected <?php endif; ?>><?php echo strtoupper($eth->type); ?></option>
                        <?php endforeach; ?>
                      </select>
                      <span id='pesan_ethnicity_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Status Kawin</strong></td>
                    <td>
                      <select class="form-control" id="marital_status_modal" name="marital_status_modal" data-plugin="select_modal" data-placeholder="Status Kawin">
                        <option value="">Pilih Status Kawin</option>
                        <?php foreach ($all_marital as $marital): ?>
                          <option value="<?php echo $marital->id_marital; ?>" <?php if ($marital_status == $marital->id_marital): ?> selected <?php endif; ?>>[<?php echo $marital->kode; ?>] <?php echo strtoupper($marital->nama); ?></option>
                        <?php endforeach; ?>
                      </select>
                      <span id='pesan_marital_status_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Tinggi Badan</strong></td>
                    <td>
                      <input id='tinggi_badan_modal' name='tinggi_badan_modal' type='number' class='form-control' placeholder='Tinggi Badan' value=''>
                      <span id='pesan_tinggi_badan_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Berat Badan</strong></td>
                    <td>
                      <input id='berat_badan_modal' name='berat_badan_modal' type='number' class='form-control' placeholder='Berat Badan' value=''>
                      <span id='pesan_berat_badan_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Golongan Darah</strong></td>
                    <td>
                      <select class="form-control" id="blood_group_modal" name="blood_group_modal" data-plugin="select_modal" data-placeholder="Golongan Darah">
                        <option value="">Pilih Golongan Darah</option>
                        <option value="A" <?php if ($blood_group == 'A'): ?> selected="selected" <?php endif; ?>>A</option>
                        <option value="A+" <?php if ($blood_group == 'A+'): ?> selected="selected" <?php endif; ?>>A+</option>
                        <option value="A-" <?php if ($blood_group == 'A-'): ?> selected="selected" <?php endif; ?>>A-</option>
                        <option value="B" <?php if ($blood_group == 'B'): ?> selected="selected" <?php endif; ?>>B</option>
                        <option value="B+" <?php if ($blood_group == 'B+'): ?> selected="selected" <?php endif; ?>>B+</option>
                        <option value="B-" <?php if ($blood_group == 'B-'): ?> selected="selected" <?php endif; ?>>B-</option>
                        <option value="AB" <?php if ($blood_group == 'AB'): ?> selected="selected" <?php endif; ?>>AB</option>
                        <option value="AB+" <?php if ($blood_group == 'AB+'): ?> selected="selected" <?php endif; ?>>AB+</option>
                        <option value="AB-" <?php if ($blood_group == 'AB-'): ?> selected="selected" <?php endif; ?>>AB-</option>
                        <option value="O" <?php if ($blood_group == 'O'): ?> selected="selected" <?php endif; ?>>O</option>
                        <option value="O+" <?php if ($blood_group == 'O+'): ?> selected="selected" <?php endif; ?>>O+</option>
                        <option value="O-" <?php if ($blood_group == 'O-'): ?> selected="selected" <?php endif; ?>>O-</option>
                      </select>
                      <span id='pesan_blood_group_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Nomor KTP <span class="icon-verify-nik"></span></strong></td>
                    <td>
                      <input <?php in_array('1004', $role_resources_ids) ? print("") : print("readonly"); ?> id='ktp_no_modal' name='ktp_no_modal' type='number' class='form-control' placeholder='Nomor KTP' value=''>
                      <span id='pesan_ktp_no_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Nomor KK <span class="icon-verify-kk"></span></strong></td>
                    <td>
                      <input <?php in_array('1004', $role_resources_ids) ? print("") : print("readonly"); ?> id='kk_no_modal' name='kk_no_modal' type='number' class='form-control' placeholder='Nomor KK' value=''>
                      <span id='pesan_kk_no_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Nomor NPWP</strong></td>
                    <td>
                      <input <?php in_array('1004', $role_resources_ids) ? print("") : print("readonly"); ?> id='npwp_no_modal' name='npwp_no_modal' type='number' class='form-control' placeholder='Nomor NPWP' value=''>
                      <span id='pesan_npwp_no_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Nomor HP/Whatasapp</strong></td>
                    <td>
                      <input <?php in_array('1004', $role_resources_ids) ? print("") : print("readonly"); ?> id='contact_no_modal' name='contact_no_modal' type='number' class='form-control' placeholder='Nomor HP/Whatsapp' value=''>
                      <span id='pesan_contact_no_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>e-Mail</strong></td>
                    <td>
                      <input id='email_modal' name='email_modal' type='email' class='form-control' placeholder='e-Mail' value=''>
                      <span id='pesan_email_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Nama Ibu Kandung</strong></td>
                    <td>
                      <input <?php in_array('1004', $role_resources_ids) ? print("") : print("readonly"); ?> id='ibu_kandung_modal' name='ibu_kandung_modal' type='text' class='form-control' placeholder='Nama Ibu Kandung' value=''>
                      <span id='pesan_ibu_kandung_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Alamat KTP</strong></td>
                    <td>
                      <textarea <?php in_array('1004', $role_resources_ids) ? print("") : print("readonly"); ?> id="alamat_ktp_modal" name="alamat_ktp_modal" class='form-control' placeholder='Alamat KTP' rows="4"></textarea>
                      <span id='pesan_alamat_ktp_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Alamat Domisili</strong></td>
                    <td>
                      <textarea id="alamat_domisili_modal" name="alamat_domisili_modal" class='form-control' placeholder='Alamat Domisili' rows="4"></textarea>
                      <span id='pesan_alamat_domisili_modal'></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="info-modal-edit-data-diri"></div>

      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <button id='button_save_data_diri' name='button_save_data_diri' type='button' class='btn btn-primary'>Save Data Diri</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL EDIT PROJECT -->
<div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" aria-labelledby="editProjectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProjectModalLabel">Edit Posisi/Jabatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-edit-project">
          <div class="container" id="container_modal_project">
            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <td style='width:25%'><strong>Perusahaan</strong></td>
                    <td style='width:75%'>
                      <?php echo $company_name; ?>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Departemen</strong></td>
                    <td>
                      <?php echo $department_name; ?>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Project</strong></td>
                    <td>
                      <?php echo $project_name; ?>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Sub Project</strong></td>
                    <td>
                      <select class="form-control" id="sub_project_modal" name="sub_project_modal" data-plugin="select_modal_project" data-placeholder="Sub Project">
                        <option value="">Pilih Sub Project</option>
                        <?php foreach ($all_sub_projects as $sub): ?>
                          <option value="<?php echo $sub->secid; ?>" <?php if ($sub_project_id == $sub->secid): ?> selected <?php endif; ?>><?php echo strtoupper($sub->sub_project_name); ?></option>
                        <?php endforeach; ?>
                      </select>
                      <span id='pesan_sub_project_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Posisi/Jabatan</strong></td>
                    <td>
                      <div id="area_jabatan">
                        <select class="form-control" id="jabatan_modal" name="jabatan_modal" data-plugin="select_modal_project" data-placeholder="Posisi/Jabatan">
                          <option value="">Pilih Posisi/Jabatan</option>
                          <?php foreach ($all_sub_projects as $sub): ?>
                            <option value="<?php echo $sub->secid; ?>" <?php if ($sub_project_id == $sub->secid): ?> selected <?php endif; ?>><?php echo strtoupper($sub->sub_project_name); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <span id='pesan_jabatan_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Area/Penempatan</strong></td>
                    <td>
                      <input id='penempatan_modal' name='penempatan_modal' type='text' class='form-control' placeholder='Area/Penempatan' value='<?php echo strtoupper($penempatan); ?>'>
                      <span id='pesan_penempatan_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Kategori</strong></td>
                    <td>
                      <select class="form-control" id="kategori_modal" name="kategori_modal" data-plugin="select_modal_project" data-placeholder="Golongan Darah">
                        <option value="">Pilih Kategori Karyawan</option>
                        <option value="1" <?php if ($location_id == '1'): ?> selected="selected" <?php endif; ?>>INHOUSE</option>
                        <option value="2" <?php if ($location_id == '2'): ?> selected="selected" <?php endif; ?>>AREA</option>
                        <option value="3" <?php if ($location_id == '3'): ?> selected="selected" <?php endif; ?>>RATECARD</option>
                        <option value="4" <?php if ($location_id == '4'): ?> selected="selected" <?php endif; ?>>PROJECT</option>
                      </select>
                      <span id='pesan_kategori_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Tanggal Bergabung</strong></td>
                    <td>
                      <input type='date' class='form-control date' name='date_of_join_modal' id='date_of_join_modal' placeholder='Tanggal Bergabung' value='<?php echo $date_of_joining; ?>'>
                      <span id='pesan_date_of_join_modal'></span>
                    </td>
                  </tr>
                  <tr <?php in_array('1013', $role_resources_ids) ? print("") : print("hidden"); ?>>
                    <td><strong>Role Karyawan</strong></td>
                    <td>
                      <div id="area_role">
                        <select class="form-control" id="role_modal" name="role_modal" data-plugin="select_modal_project" data-placeholder="Role Karyawan">
                          <option value="">Pilih Role Karyawan</option>
                          <?php foreach ($all_user_roles as $role): ?>
                            <option value="<?php echo $role->role_id; ?>" <?php if ($role_id == $role->role_id): ?> selected <?php endif; ?>><?php echo strtoupper($role->role_name); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <span id='pesan_role_modal'></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="info-modal-edit-project"></div>

      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <button id='button_save_project' name='button_save_project' type='button' class='btn btn-primary'>Save Posisi/Jabatan</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL EDIT KONTAK DARURAT -->
<div class="modal fade" id="editKontakModal" tabindex="-1" role="dialog" aria-labelledby="editKontakModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editKontakModalLabel">Edit Kontak Darurat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-edit-kontak">
          <div class="container" id="container_modal_kontak">
            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <td style='width:25%'><strong>Nama Kontak</strong></td>
                    <td style='width:75%'>
                      <input id='nama_kontak_modal' name='nama_kontak_modal' type='text' class='form-control' placeholder='Area/Penempatan' value='<?php echo strtoupper($penempatan); ?>'>
                      <span id='pesan_nama_kontak_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Hubungan</strong></td>
                    <td>
                      <select class="form-control" id="hubungan_modal" name="hubungan_modal" data-plugin="select_modal_kontak" data-placeholder="Pilih Hubungan">
                        <option value="">Pilih Hubungan</option>
                        <?php foreach ($all_family_relation as $family): ?>
                          <option value="<?php echo $family->secid; ?>"><?php echo strtoupper($family->name); ?></option>
                        <?php endforeach; ?>
                      </select>
                      <span id='pesan_hubungan_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Nomor Kontak</strong></td>
                    <td>
                      <input id='nomor_kontak_modal' name='nomor_kontak_modal' type='text' class='form-control' placeholder='Area/Penempatan' value='<?php echo strtoupper($penempatan); ?>'>
                      <span id='pesan_nomor_kontak_modal'></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="info-modal-edit-kontak"></div>

      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <button id='button_save_kontak' name='button_save_kontak' type='button' class='btn btn-primary'>Save Kontak Darurat</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL EDIT RESIGN -->
<div class="modal fade" id="editResignModal" tabindex="-1" role="dialog" aria-labelledby="editResignModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editResignModalLabel">Status Karyawan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-edit-resign">
          <div class="container" id="container_modal_resign">
            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <td style='width:25%'><strong>NIP</strong></td>
                    <td style='width:75%'>
                      <span id='nip_modal2'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Nama Lengkap</strong></td>
                    <td>
                      <span id='nama_modal2'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Status Aktif</strong></td>
                    <td>
                      <span id='status_aktif_modal2'></span>
                    </td>
                  </tr>
                  <tr id="isi_non_aktif_by_modal3">
                    <td><strong>Non Aktif By</strong></td>
                    <td>
                      <span id='non_aktif_by_modal2'></span>
                    </td>
                  </tr>
                  <tr id="isi_non_aktif_date_modal3">
                    <td><strong>Non Aktif Date</strong></td>
                    <td>
                      <span id='non_aktif_on_modal2'></span>
                    </td>
                  </tr>
                  <tr id="isi_keterangan_aktif_modal3">
                    <td><strong>Non Aktif Pesan</strong></td>
                    <td>
                      <span id='non_aktif_pesan_modal2'></span>
                    </td>
                  </tr>
                  <tr id="isi_status_aktif_modal2">
                    <td><strong>Status Aktif</strong></td>
                    <td>
                      <select class="form-control" id="kategori_resign_modal" name="kategori_resign_modal" data-plugin="select_modal_resign" data-placeholder="Status Aktif">
                        <option value="">Pilih Status Aktif Karyawan</option>
                        <option value="1" <?php if ($status_resign == '1'): ?> selected="selected" <?php endif; ?>>AKTIF</option>
                        <option value="2" <?php if (($status_resign == '2') || ($status_resign == '5')): ?> selected="selected" <?php endif; ?>>RESIGN</option>
                        <option value="3" <?php if ($status_resign == '3'): ?> selected="selected" <?php endif; ?>>BLACKLIST</option>
                        <option value="4" <?php if ($status_resign == '4'): ?> selected="selected" <?php endif; ?>>END CONTRACT</option>
                      </select>
                      <span id='pesan_kategori_resign_modal'></span>
                    </td>
                  </tr>
                  <tr id="isi_tanggal_aktif_modal2">
                    <td><strong>Tanggal Resign</strong></td>
                    <td>
                      <input type='date' class='form-control date' name='tanggal_resign_modal2' id='tanggal_resign_modal2' placeholder='Tanggal Resign' value=''>
                      <span id='pesan_tanggal_resign_modal2'></span>
                    </td>
                  </tr>
                  <tr id="isi_keterangan_aktif_modal2">
                    <td><strong>Keterangan Resign</strong></td>
                    <td>
                      <input id='keterangan_resign_modal2' name='keterangan_resign_modal2' type='text' class='form-control' placeholder='Keterangan Resign' value=''>
                      <span id='pesan_keterangan_resign_modal2'></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="info-modal-edit-resign"></div>

      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <button id='button_save_resign' name='button_save_resign' type='button' class='btn btn-primary'>Save Status Karyawan</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL HAPUS KONTRAK -->
<div class="modal fade" id="hapusKontrakModal" tabindex="-1" role="dialog" aria-labelledby="hapusKontrakModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="hapusKontrakModalLabel">Hapus Kontrak</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-hapus-kontrak">
          <div class="container" id="container_modal_hapus_kontrak">
            <div class="row">
              <strong>Apakah anda ingin menghapus kontrak ini?</strong></br>
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <td style='width:25%'><strong>Jenis Kontrak</strong></td>
                    <td style='width:75%'>
                      <span id='jenis_kontrak_modal2'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Nomor Dokumen</strong></td>
                    <td>
                      <span id='nomor_dokumen_modal2'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Periode</strong></td>
                    <td>
                      <span id='periode_kontrak_modal2'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Tanggal Terbit</strong></td>
                    <td>
                      <span id='tgl_terbit_kontrak_modal2'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Project</strong></td>
                    <td>
                      <span id='project_kontrak_modal2'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Sub Project</strong></td>
                    <td>
                      <span id='sub_project_kontrak_modal2'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Jabatan</strong></td>
                    <td>
                      <span id='jabatan_kontrak_modal2'></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="info-modal-hapus-kontrak"></div>

      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <span id='button_delete_kontrak'></span>
      </div>
    </div>
  </div>
</div>

<!-- MODAL EDIT REKENING BANK -->
<div class="modal fade" id="editRekeningModal" tabindex="-1" role="dialog" aria-labelledby="editRekeningModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editRekeningModalLabel">Edit Rekening Bank</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-edit-rekening">
          <div class="container" id="container_modal_rekening">
            <?php $attributes = array('name' => 'rekening_form', 'id' => 'rekening_form', 'autocomplete' => 'off', 'class' => 'm-b-1'); ?>
            <?php echo form_open_multipart('admin/profile/uploadaddendum/', $attributes); ?>
            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <td style='width:25%'><strong>Nama Bank <span class="icon-verify-bank"></span></strong></td>
                    <td style='width:75%'>
                      <select class="form-control" id="nama_bank2" name="nama_bank2" data-plugin="select_modal_rekening" data-placeholder="Pilih Bank">
                        <option value="">Pilih Bank</option>
                        <?php foreach ($list_bank as $bank): ?>
                          <option value="<?php echo $bank->secid; ?>"><?php echo strtoupper($bank->bank_name); ?></option>
                        <?php endforeach; ?>
                      </select>
                      <span id='pesan_nama_bank'></span>
                      <input hidden name="nama_bank" id="nama_bank" placeholder="Nomor Rekening Bank" type="text" value="">
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Nomor Rekening <span class="icon-verify-norek"></span></strong></td>
                    <td>
                      <input id='nomor_rekening' name='nomor_rekening' type='text' class='form-control' placeholder='Nomor Rekening' value=''>
                      <span id='pesan_nomor_rekening'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Pemilik Rekening <span class="icon-verify-pemilik-rek"></span></strong></td>
                    <td>
                      <input id='pemilik_rekening' name='pemilik_rekening' type='text' class='form-control' placeholder='Pemilik Rekening' value=''>
                      <span id='pesan_pemilik_rekening'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Foto Buku Rekening</strong></td>
                    <td>
                      <div id="file_buku_tabungan_kosong" class="mb-2">BELUM ADA DATA. SILAHKAN UPLOAD FOTO BUKU TABUNGAN</div>
                      <div id="file_buku_tabungan_isi" class="mb-2">
                        <button id="button_open_buku_tabungan" type="button" onclick="open_buku_tabungan(<?php echo $employee_id; ?>)" class="btn btn-sm btn-outline-primary ladda-button mx-1 mb-1" data-style="expand-right">Open Buku Tabungan</button>
                        <button id="button_open_upload_buku_tabungan" type="button" onclick="open_upload_buku_tabungan()" class="btn btn-sm btn-outline-primary ladda-button mx-1" data-style="expand-right">Upload Buku Tabungan</button>
                      </div>
                      <div id="form_upload_buku_tabungan" class="form-group">
                        <fieldset class="form-group">
                          <input type="file" class="form-control-file" id="buku_rekening" name="buku_rekening" accept="application/pdf, image/png, image/jpg, image/jpeg">
                          <small>Jenis File: JPG, JPEG, PNG, PDF | Size MAX 5 MB</small>
                        </fieldset>
                      </div>
                      <!-- <input class="form-control" type="file" id="buku_rekening" name="buku_rekening" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"> -->
                      <span id='pesan_buku_rekening'></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="info-modal-edit-rekening"></div>

      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <button id='button_save_rekening' name='button_save_rekening' type='submit' class='btn btn-primary'>Save Rekening</button>
      </div>

      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<!-- MODAL UPLOAD DOKUMEN PRIBADI -->
<div class="modal fade" id="uploadDokumenModal" tabindex="-1" role="dialog" aria-labelledby="uploadDokumenModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadDokumenModalLabel"><span id="judul_modal_upload_dokumen">Upload Dokumen Pribadi</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-upload-dokumen">
          <div class="container" id="container_modal_upload_dokumen">
            <?php $attributes = array('name' => 'dokumen_form', 'id' => 'dokumen_form', 'autocomplete' => 'off', 'class' => 'm-b-1'); ?>
            <?php echo form_open_multipart('admin/profile/uploadaddendum/', $attributes); ?>
            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <!-- <td style='width:25%'><strong id="label_upload_dokumen">Foto Buku Rekening</strong></td> -->
                    <td style='width:100%'>
                      <strong>
                        <div id="file_dokumen_kosong" class="mb-2">SILAHKAN UPLOAD FOTO BUKU TABUNGAN</div>
                      </strong>
                      <!-- <div id="file_dokumen_isi" class="mb-2">
                        <button id="button_open_dokumen" type="button" onclick="open_buku_tabungan(<?php echo $employee_id; ?>)" class="btn btn-sm btn-outline-primary ladda-button mx-1" data-style="expand-right">Open Buku Tabungan</button>
                        <button id="button_open_upload_dokumen" type="button" onclick="open_upload_buku_tabungan()" class="btn btn-sm btn-outline-primary ladda-button mx-1" data-style="expand-right">Upload Buku Tabungan</button>
                      </div> -->
                      <div id="input_upload_dokumen" class="form-group">
                        <fieldset class="form-group">
                          <input type="file" class="form-control-file" id="file_dokumen" name="file_dokumen" accept="application/pdf, image/png, image/jpg, image/jpeg">
                          <small>Jenis File: JPG, JPEG, PNG, PDF | Size MAX 5 MB</small>
                        </fieldset>
                      </div>
                      <!-- <input class="form-control" type="file" id="buku_rekening" name="buku_rekening" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"> -->
                      <span id='pesan_upload_dokumen'></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="info-modal-upload-dokumen"></div>

      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <span id='button_upload_dokumen'><button type='button' onclick='open_buku_tabungan(<?php echo $employee_id; ?>)' class='btn btn-primary'>Save Dokumen</button></span>
      </div>

      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<!-- MODAL EDIT BPJS -->
<div class="modal fade" id="editBPJSModal" tabindex="-1" role="dialog" aria-labelledby="editBPJSModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editBPJSModalLabel">Edit BPJS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-edit-bpjs">
          <div class="container" id="container_modal_bpjs">
            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <td style='width:25%'><strong>Nomor BPJS Kesehatan</strong></td>
                    <td style='width:75%'>
                      <input id='no_bpjs_ks_modal' name='no_bpjs_ks_modal' type='text' class='form-control' placeholder='Nomor BPJS Kesehatan' value=''>
                      <span id='pesan_no_bpjs_ks_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Nomor BPJS Ketenagakerjaan</strong></td>
                    <td>
                      <input id='no_bpjs_tk_modal' name='no_bpjs_tk_modal' type='text' class='form-control' placeholder='Nomor BPJS Ketenagakerjaan' value=''>
                      <span id='pesan_no_bpjs_tk_modal'></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="info-modal-edit-bpjs"></div>

      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <button id='button_save_bpjs' name='button_save_bpjs' type='button' class='btn btn-primary'>Save Nomor BPJS</button>
      </div>
    </div>
  </div>
</div>

<!-- CARD DATA -->
<div class="row <?php echo $get_animate; ?>">
  <div class="col-12">
    <div class="card mb-1 bg-primary border-0 text-white">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-4 col-sm-3 col-md-2 text-center align-self-center">
            <div class="row">
              <div class="col-12 col-md-12 text-center align-self-center">
                <span id="foto_profile"><button onclick="open_foto_profil(<?php echo $employee_id; ?>)" type='button' class='btn btn-block btn-primary'><img src="<?php echo $de_file; ?>" alt="" width="100%"></button></span>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 text-center align-self-center">
                <button id="button_ubah_foto" class="btn btn-block btn-sm btn-white ladda-button mx-0 mt-1" data-style="expand-right">Ubah Foto</button>
              </div>
              <div class="w-100"></div>
              <div class="col-md-12 text-center align-self-center">
                <div id="button_resign"><?php echo $button_resign; ?></div>
              </div>
            </div>
          </div>
          <div class="col-8 col-sm-9 col-md-10">
            <div class="ml-0">
              <div class="text-big mt-1"><span id="nama_lengkap_card"><?php echo $first_name; ?></span> <span class="icon-verify-nama"></span></div>
              <div class="mt-1">NIP: <?php echo $employee_id; ?> <button id="button_ganti_pin" class="btn btn-sm btn-white ladda-button mx-1 mb-1" data-style="expand-right">Ganti PIN</button><button id="button_show_pin" class="btn btn-sm btn-white ladda-button mx-1" data-style="expand-right">Show PIN</button></div>
              <div class="mt-1">PROJECT: <?php echo $project_name; ?></div>
              <div class="mt-1" id="jabatan_name_card">JABATAN: <?php echo $designation_name; ?></div>
              <div class="mt-1" id="kategori_name_card">KATEGORI: <?php echo $kategori; ?></div>
              <div class="mt-3">
                <?php if (in_array('1000', $role_resources_ids)) { ?>
                  <button id="button_verifikasi" class="btn btn-sm btn-white ladda-button mr-1 mb-1" data-style="expand-right">Verifikasi Data</button>
                <?php } ?>
                <button id="button_download_resume" class="btn btn-sm btn-white ladda-button mx-0" data-style="expand-right">Download Resume</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- PAGE CONTENT -->
<div class="mb-3 sw-container tab-content">
  <div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
    <div class="mb-3 sw-container tab-content">
      <div id="smartwizard-2-step-1" class="card animated fadeIn tab-pane step-content mt-3" style="display: block;">
        <div class="cards-body">
          <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">

              <ul class="nav nav-pills mb-3" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="data-diri-tab" data-toggle="tab" href="#data-diri" role="tab" aria-controls="data-diri" aria-selected="true"><i class="ion ion-ios-man"></i> &nbsp; Data Diri</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="project-jabatan-tab" data-toggle="tab" href="#project-jabatan" role="tab" aria-controls="project-jabatan" aria-selected="false"><i class="ion ion-ios-business"></i> &nbsp; Posisi/Jabatan</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="kontak-darurat-tab" data-toggle="tab" href="#kontak-darurat" role="tab" aria-controls="kontak-darurat" aria-selected="false"><i class="ion ion-ios-warning"></i> &nbsp; Kontak Darurat</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="rekening-bank-tab" data-toggle="tab" href="#rekening-bank" role="tab" aria-controls="rekening-bank" aria-selected="false"><i class="ion ion-ios-card"></i> &nbsp; Rekening Bank</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="dokumen-pribadi-tab" data-toggle="tab" href="#dokumen-pribadi" role="tab" aria-controls="dokumen-pribadi" aria-selected="false"><i class="ion ion-ios-paper"></i> &nbsp; Dokumen Pribadi</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="dokumen-kontrak-tab" data-toggle="tab" href="#dokumen-kontrak" role="tab" aria-controls="dokumen-kontrak" aria-selected="false"><i class="ion ion-ios-filing"></i> &nbsp; Dokumen Kontrak</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="dokumen-sk-tab" data-toggle="tab" href="#dokumen-sk" role="tab" aria-controls="dokumen-sk" aria-selected="false"><i class="ion ion-ios-document"></i> &nbsp; Dokumen SK</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="dokumen-eslip-tab" data-toggle="tab" href="#dokumen-eslip" role="tab" aria-controls="dokumen-eslip" aria-selected="false"><i class="ion ion-logo-usd"></i> &nbsp; E-SLIP</a>
                </li>
              </ul>

              <div class="col-md-12">
                <div class="tab-content" id="nav-tabContent">
                  <!-- TAB DATA DIRI -->
                  <div class="tab-pane fade show active" id="data-diri" role="tabpanel" aria-labelledby="data-diri-tab">
                    <div class="row">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> DATA DIRI</strong></span> </div>
                      <div class="col-md-6">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <th scope="row" style="width: 30%">Nama Lengkap <span class="icon-verify-nama"></span></th>
                              <td id="nama_lengkap_tabel"><?php echo $first_name; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Jenis Kelamin</th>
                              <td id="gender_name_tabel"><?php echo $gender_name; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Tempat Lahir</th>
                              <td id="tempat_lahir_tabel"><?php echo $tempat_lahir; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Tanggal Lahir</th>
                              <td id="tanggal_lahir_tabel"><?php echo $date_of_birth; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Pendidikan Terakhir</th>
                              <td id="pendidikan_terakhir_tabel"><?php echo $last_edu_name; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Agama</th>
                              <td id="agama_tabel"><?php echo $ethnicity_name; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Status Kawin</th>
                              <td id="status_kawin_tabel"><?php echo $marital_status_name; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Tinggi Badan</th>
                              <td id="tinggi_badan_tabel"><?php echo $tinggi_badan; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Berat Badan</th>
                              <td id="berat_badan_tabel"><?php echo $berat_badan; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Golongan Darah</th>
                              <td id="golongan_darah_tabel"><?php echo $blood_group; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-md-6">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <th scope="row" style="width: 30%">Nomor KTP <span class="icon-verify-nik"></span></th>
                              <td id="nomor_ktp_tabel"><?php echo $ktp_no; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Nomor KK <span class="icon-verify-kk"></span></th>
                              <td id="nomor_kk_tabel"><?php echo $kk_no; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Nomor NPWP</th>
                              <td id="nomor_npwp_tabel"><?php echo $npwp_no; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Nomor HP/Whatsapp</th>
                              <td>
                                <span id="nomor_kontak_tabel"><?php echo $contact_no; ?></span>
                                <?php if (in_array('1003', $role_resources_ids)) { ?>
                                  <button id="button_send_whatsapp" class="btn btn-sm btn-outline-primary ladda-button mx-1" data-style="expand-right">Send Whatsapp</button>
                                <?php } ?>
                                <?php if (in_array('1002', $role_resources_ids)) { ?>
                                  <button id="button_send_pin" class="btn btn-sm btn-outline-primary mx-0">Send PIN</button>
                                <?php } ?>
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">E-mail</th>
                              <td id="email_tabel"><?php echo $email; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Nama Ibu Kandung</th>
                              <td id="ibu_kandung_tabel"><?php echo $ibu_kandung; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Alamat KTP</th>
                              <td id="alamat_ktp_tabel"><?php echo $alamat_ktp; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Alamat Domisili</th>
                              <td id="alamat_domisili_tabel"><?php echo $alamat_domisili; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <?php if (in_array('1001', $role_resources_ids)) { ?>
                      <hr class="border-light m-0">
                      <div class="row">
                        <div class="col-12 my-3">
                          <button id="button_edit_data_diri" class="btn btn-primary ladda-button mx-3" data-style="expand-right">Edit Data</button>
                        </div>
                      </div>
                    <?php } ?>

                  </div>
                  <!-- END TAB DATA DIRI -->

                  <!-- TAB POSISI/JABATAN -->
                  <div class="tab-pane fade" id="project-jabatan" role="tabpanel" aria-labelledby="project-jabatan-tab">
                    <div class="row">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> PROJECT - POSISI/JABATAN</strong></span> </div>
                      <div class="col-md-6">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <th scope="row" style="width: 30%">Perusahaan</th>
                              <td><?php echo $company_name; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Departemen</th>
                              <td><?php echo $department_name; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Project</th>
                              <td><?php echo $project_name; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Sub Project</th>
                              <td id="sub_project_tabel"><?php echo $nama_subproject; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Posisi/Jabatan</th>
                              <td id="jabatan_tabel"><?php echo $designation_name; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-md-6">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <th scope="row" style="width: 30%">Area/Penempatan</th>
                              <td id="penempatan_tabel"><?php echo $penempatan; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Kategori</th>
                              <td id="kategori_tabel"><?php echo $kategori; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Tanggal Bergabung</th>
                              <td id="date_of_join_tabel"><?php echo $date_of_joining_name; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                    </div>
                    <?php if ((in_array('1005', $role_resources_ids)) && ($user[0]->employee_id != $employee_id)) { ?>
                      <hr class="border-light m-0">
                      <div class="row">
                        <div class="col-12 my-3">
                          <button id="button_edit_project" class="btn btn-primary ladda-button mx-3" data-style="expand-right">Edit Data</button>
                        </div>
                      </div>
                    <?php } ?>

                  </div>
                  <!-- END TAB POSISI/JABATAN -->

                  <!-- TAB KONTAK DARURAT -->
                  <!-- <div class="tab-pane fade show active" id="account-basic_info" role="tabpanel" aria-labelledby="home-tab"> -->
                  <div class="tab-pane fade" id="kontak-darurat" role="tabpanel" aria-labelledby="kontak-darurat-tab">
                    <div class="row">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> KONTAK DARURAT</strong></span> </div>
                      <div class="col-md-6">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <th scope="row" style="width: 30%">Nama Kontak</th>
                              <td id="nama_kontak_tabel"><?php echo $nama_kontak_darurat; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Hubungan</th>
                              <td id="hubungan_tabel"><?php echo $hubungan_kontak_darurat; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-md-6">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <th scope="row" style="width: 30%">Nomor Kontak</th>
                              <td id="nomor_kontak_darurat_tabel"><?php echo $nomor_kontak_darurat; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                    </div>
                    <?php if (in_array('1006', $role_resources_ids)) { ?>
                      <hr class="border-light m-0">
                      <div class="row">
                        <div class="col-12 my-3">
                          <button id="button_edit_kontak_darurat" class="btn btn-primary ladda-button mx-3" data-style="expand-right">Edit Data</button>
                        </div>
                      </div>
                    <?php } ?>

                  </div>
                  <!-- END TAB KONTAK DARURAT -->

                  <!-- TAB REKENING BANK -->
                  <!-- <div class="tab-pane fade show active" id="account-basic_info" role="tabpanel" aria-labelledby="home-tab"> -->
                  <div class="tab-pane fade" id="rekening-bank" role="tabpanel" aria-labelledby="rekening-bank-tab">
                    <div class="row">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> REKENING BANK</strong></span> </div>
                      <div class="col-md-6">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <th scope="row" style="width: 30%">Nama Bank <span class="icon-verify-bank"></span></th>
                              <td id="nama_bank_tabel"><?php echo $bank_name; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Nomor Rekening <span class="icon-verify-norek"></span></th>
                              <td id="nomor_rekening_table"><?php echo $nomor_rek; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Nama Pemilik Rekening <span class="icon-verify-pemilik-rek"></span></th>
                              <td id="pemilik_rekening_tabel"><?php echo $pemilik_rek; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-md-6">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <th scope="row" style="width: 30%">Foto Buku Tabungan</th>
                              <td id="buku_rekening_tabel"><?php echo $filename_rek; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                    </div>
                    <?php if (in_array('1007', $role_resources_ids)) { ?>
                      <hr class="border-light m-0">
                      <div class="row">
                        <div class="col-12 my-3">
                          <button id="button_edit_rekening" class="btn btn-primary ladda-button mx-3" data-style="expand-right">Edit Data</button>
                        </div>
                      </div>
                    <?php } ?>

                  </div>
                  <!-- END TAB REKENING BANK -->

                  <!-- TAB DOKUMEN PRIBADI -->
                  <!-- <div class="tab-pane fade show active" id="account-basic_info" role="tabpanel" aria-labelledby="home-tab"> -->
                  <div class="tab-pane fade" id="dokumen-pribadi" role="tabpanel" aria-labelledby="dokumen-pribadi-tab">
                    <div class="row">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> DOKUMEN PRIBADI</strong></span> </div>
                      <div class="col-md-6">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <th scope="row" style="width: 30%">Dokumen KTP <span class="icon-verify-nik"></span></th>
                              <td id="dokumen_ktp_tabel"><?php echo $display_ktp; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Dokumen KK <span class="icon-verify-kk"></span></th>
                              <td id="dokumen_kk_tabel"><?php echo $display_kk; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Dokumen NPWP</th>
                              <td id="dokumen_npwp_tabel"><?php echo $display_npwp; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Dokumen CV</th>
                              <td id="dokumen_cv_tabel"><?php echo $display_cv; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Dokumen SKCK</th>
                              <td id="dokumen_skck_tabel"><?php echo $display_skck; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Dokumen Ijazah</th>
                              <td id="dokumen_ijazah_tabel"><?php echo $display_isd; ?></td>
                            </tr>
                            <!-- <tr>
                              <th scope="row">Dokumen Paklaring (SK Kerja)</th>
                              <td><?php //echo $filename_paklaring; 
                                  ?></td>
                            </tr> -->
                          </tbody>
                        </table>
                      </div>
                      <div class="col-md-6">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <th scope="row" style="width: 30%">Nomor BPJS Kesehatan</th>
                              <td id="dokumen_bpjs_ks_tabel"><?php echo $display_bpjs_ks_no; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Nomor BPJS Ketenagakerjaan</th>
                              <td id="dokumen_bpjs_tk_tabel"><?php echo $display_bpjs_tk_no; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                    </div>
                    <!-- <hr class="border-light m-0">
                    <div class="row">
                      <div class="col-12 my-3">
                        <button id="button_edit_dokumen_pribadi" class="btn btn-primary ladda-button mx-3" data-style="expand-right">Upload Dokumen</button>
                      </div>
                    </div> -->

                  </div>
                  <!-- END TAB DOKUMEN PRIBADI -->

                  <!-- TAB DOKUMEN KONTRAK -->
                  <!-- <div class="tab-pane fade show active" id="account-basic_info" role="tabpanel" aria-labelledby="home-tab"> -->
                  <div class="tab-pane fade" id="dokumen-kontrak" role="tabpanel" aria-labelledby="dokumen-kontrak-tab">
                    <div class="row" id="isi-dokumen-kontrak-tabel">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> DOKUMEN KONTRAK</strong></span> </div>

                      <?php foreach ($all_contract as $kontrak): ?>
                        <div class="card-header with-elements" <?php echo ($kontrak['jenis_dokumen'] == "ADDENDUM" ? 'style="background-color:#c0ebbc;"' : 'style="background-color:#bcbeeb;"'); ?>> <span class="card-header-title mr-2"> <strong> <?php echo $kontrak['jenis_dokumen']; ?>. Periode: <?php echo $kontrak['periode_start']; ?> - <?php echo $kontrak['periode_end']; ?></strong></span> </div>
                        <div class="col-md-6">
                          <table class="table table-striped">
                            <tbody>
                              <tr>
                                <th scope="row" style="width: 30%">Nomor Dokumen</th>
                                <td><?php echo $kontrak['nomor_surat']; ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Project</th>
                                <td><?php echo $kontrak['project']; ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Sub Project</th>
                                <td><?php echo $kontrak['sub_project']; ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Jabatan</th>
                                <td><?php echo $kontrak['jabatan']; ?></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-md-6">
                          <table class="table table-striped">
                            <tbody>
                              <tr>
                                <th scope="row" style="width: 30%">Tanggal Terbit</th>
                                <td><?php echo $kontrak['tanggal_terbit']; ?></td>
                              </tr>
                              <tr>
                                <!-- <th scope="row">Status</th> -->
                                <td colspan="2">
                                  <?php echo $kontrak['button_open']; ?>
                                  <?php echo $kontrak['button_upload']; ?>
                                  <?php echo $kontrak['button_lihat']; ?>
                                  <?php echo $kontrak['button_hapus']; ?>
                                  <?php echo $kontrak['button_edit']; ?>
                                  <?php echo $kontrak['button_add_addendum']; ?>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      <?php endforeach; ?>

                    </div>
                  </div>
                  <!-- END TAB DOKUMEN KONTRAK -->

                  <!-- TAB DOKUMEN SK -->
                  <!-- <div class="tab-pane fade show active" id="account-basic_info" role="tabpanel" aria-labelledby="home-tab"> -->
                  <div class="tab-pane fade" id="dokumen-sk" role="tabpanel" aria-labelledby="dokumen-sk-tab">
                    <div class="row">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> DOKUMEN SK</strong></span> </div>
                      <!-- <pre>
                        <?php //print_r($all_sk);
                        ?>
                      </pre> -->

                      <?php if (!is_null($all_sk)) {
                        foreach ($all_sk->result_array() as $sk): ?>
                          <div class="card-header with-elements" style="background-color:#c0ebbc;"> <span class="card-header-title mr-2"> <strong> PAKLARING. Periode: <?php echo $sk['join_date']; ?> - <?php echo $sk['resign_date']; ?></strong></span> </div>
                          <div class="col-md-6">
                            <table class="table table-striped">
                              <tbody>
                                <tr>
                                  <th scope="row" style="width: 30%">Nomor Dokumen</th>
                                  <td><?php echo $sk['nomor_dokumen']; ?></td>
                                </tr>
                                <tr>
                                  <th scope="row" style="width: 30%">Tanggal Terbit</th>
                                  <td><?php echo $sk['createdon']; ?></td>
                                </tr>
                                <tr>
                                  <th scope="row" style="width: 30%">Action</th>
                                  <td>
                                    <button onclick="lihat_sk(<?php echo $sk['secid']; ?>,<?php echo $sk['nip']; ?>)" class="btn btn-sm btn-outline-primary mr-1 my-1">Lihat SK</button>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <div class="col-md-6">
                            <table class="table table-striped">
                              <tbody>
                                <tr>
                                  <th scope="row" style="width: 30%">QR Code</th>
                                  <td>
                                    <img src='<?= base_url() ?>assets/images/<?php echo $sk['qr_code']; ?>' width='150px'>
                                    <?php //echo $sk['button_open']; 
                                    ?>
                                    <?php //echo $sk['button_upload']; 
                                    ?>
                                    <?php //echo $sk['button_lihat']; 
                                    ?>
                                    <?php //echo $sk['button_hapus']; 
                                    ?>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        <?php endforeach;
                      } else { ?>
                        <div class="card-header with-elements" style="background-color:#c0ebbc;"> <span class="card-header-title mr-2"> <strong> BELUM ADA DATA </strong></span> </div>
                      <?php } ?>

                    </div>
                    <!-- <hr class="border-light m-0">
                    <div class="row">
                      <div class="col-12 my-3">
                        <button id="button_edit_dokumen_kontrak" class="btn btn-primary ladda-button mx-3" data-style="expand-right">Upload Dokumen</button>
                      </div>
                    </div> -->

                  </div>
                  <!-- END TAB DOKUMEN SK -->

                  <!-- TAB DOKUMEN ESLIP -->
                  <!-- <div class="tab-pane fade show active" id="account-basic_info" role="tabpanel" aria-labelledby="home-tab"> -->
                  <div class="tab-pane fade" id="dokumen-eslip" role="tabpanel" aria-labelledby="dokumen-eslip-tab">
                    <div class="row">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> DOKUMEN E-Slip</strong></span> </div>
                      <!-- <pre>
                        <?php //print_r($all_sk); 
                        ?>
                      </pre> -->

                      <?php if (empty($all_eslip)) { ?>
                        <div class="card-header with-elements" style="background-color:#e1e1e1;"> <span class="card-header-title mr-2"> <strong> Belum ada data </strong></span> </div>
                      <?php } else { ?>
                        <?php foreach ($all_eslip as $eslip): ?>
                          <div class="card-header with-elements" style="background-color:#e1e1e1;"> <span class="card-header-title mr-2"> <strong> e-SLIP. Periode: <?php echo $eslip['cutoff_start']; ?> - <?php echo $eslip['cutoff_end']; ?></strong></span> </div>
                          <div class="col-md-6">
                            <table class="table table-striped">
                              <tbody>
                                <tr>
                                  <th scope="row" style="width: 30%">NIP</th>
                                  <td><?php echo $eslip['nip']; ?></td>
                                </tr>
                                <tr>
                                  <th scope="row">Nama</th>
                                  <td><?php echo $eslip['nama']; ?></td>
                                </tr>
                                <tr>
                                  <th scope="row">Project</th>
                                  <td><?php echo $eslip['project']; ?></td>
                                </tr>
                                <tr>
                                  <th scope="row">Jabatan</th>
                                  <td><?php echo $eslip['jabatan']; ?></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <div class="col-md-6">
                            <table class="table table-striped">
                              <tbody>
                                <tr>
                                  <th scope="row" style="width: 30%">Tanggal Penggajian</th>
                                  <td><?php echo $eslip['tanggal_penggajian']; ?></td>
                                </tr>
                                <tr>
                                  <th>Action</th>
                                  <td><?php echo $eslip['button_lihat']; ?></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        <?php endforeach; ?>

                      <?php } ?>

                    </div>
                    <!-- <hr class="border-light m-0">
                    <div class="row">
                      <div class="col-12 my-3">
                        <button id="button_edit_dokumen_kontrak" class="btn btn-primary ladda-button mx-3" data-style="expand-right">Upload Dokumen</button>
                      </div>
                    </div> -->

                  </div>
                  <!-- END TAB DOKUMEN ESLIP -->

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

<!-- SCRIPT INITIATE VALIDATION -->
<script type=text/javascript>
  //read variable

  var nik_validation = "<?php echo $nik_validation; ?>";
  var kk_validation = "<?php print($kk_validation); ?>";
  var nama_validation = "<?php print($nama_validation); ?>";
  var bank_validation = "<?php print($bank_validation); ?>";
  var norek_validation = "<?php print($norek_validation); ?>";
  var pemilik_rekening_validation = "<?php print($pemilik_rekening_validation); ?>";

  //initiate state validation
  if (nik_validation == 0) {
    $('.icon-verify-nik').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");
    if (ktp_no_modal.readOnly) document.getElementById("ktp_no_modal").removeAttribute("readonly");
    if (nik_modal.readOnly) document.getElementById("nik_modal").removeAttribute("readonly");
  } else if (nik_validation == 1) {
    ktp_no_modal.setAttribute("readonly", "readonly");
    nik_modal.setAttribute("readonly", "readonly");
    $('.icon-verify-nik').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");
  }
  if (kk_validation == 0) {
    $('.icon-verify-kk').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");
    if (kk_no_modal.readOnly) document.getElementById("kk_no_modal").removeAttribute("readonly");
    if (kk_modal.readOnly) document.getElementById("kk_modal").removeAttribute("readonly");
  } else if (kk_validation == 1) {
    kk_no_modal.setAttribute("readonly", "readonly");
    kk_modal.setAttribute("readonly", "readonly");
    $('.icon-verify-kk').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");
  }
  if (nama_validation == 0) {
    $('.icon-verify-nama').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");
    if (first_name_modal.readOnly) document.getElementById("first_name_modal").removeAttribute("readonly");
    if (nama_modal.readOnly) document.getElementById("nama_modal").removeAttribute("readonly");
  } else if (nama_validation == 1) {
    first_name_modal.setAttribute("readonly", "readonly");
    nama_modal.setAttribute("readonly", "readonly");
    $('.icon-verify-nama').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");
  }
  if (bank_validation == 0) {
    $('.icon-verify-bank').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");
    if (nama_bank2.disabled) document.getElementById("nama_bank2").removeAttribute("disabled");
    if (bank_modal.disabled) document.getElementById("bank_modal").removeAttribute("disabled");
  } else if (bank_validation == 1) {
    bank_modal.setAttribute("disabled", "disabled");
    nama_bank2.setAttribute("disabled", "disabled");
    $('.icon-verify-bank').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");
  }
  if (norek_validation == 0) {
    $('.icon-verify-norek').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");
    if (nomor_rekening.readOnly) document.getElementById("nomor_rekening").removeAttribute("readonly");
    if (rekening_modal.readOnly) document.getElementById("rekening_modal").removeAttribute("readonly");
    $('#button_open_upload_buku_tabungan').attr("hidden", false);
  } else if (norek_validation == 1) {
    nomor_rekening.setAttribute("readonly", "readonly");
    rekening_modal.setAttribute("readonly", "readonly");
    $('#button_open_upload_buku_tabungan').attr("hidden", true);
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

<script type="text/javascript">
  $(document).ready(function() {
    //-- GLOBAL VARIABLE --
    // $('[data-plugin="select_modal"]').select2($(this).attr("data-options"));
    $('[data-plugin="select_modal"]').select2({
      width: "100%",
      dropdownParent: $("#container_modal")
    });
    $('[data-plugin="select_modal_project"]').select2({
      width: "100%",
      dropdownParent: $("#container_modal_project")
    });
    $('[data-plugin="select_modal_kontak"]').select2({
      width: "100%",
      dropdownParent: $("#container_modal_kontak")
    });
    $('[data-plugin="select_modal_rekening"]').select2({
      width: "100%",
      dropdownParent: $("#container_modal_rekening")
    });
    $('[data-plugin="select_modal_upload_dokumen"]').select2({
      width: "100%",
      dropdownParent: $("#container_modal_upload_dokumen")
    });
    $('[data-plugin="select_modal_bpjs"]').select2({
      width: "100%",
      dropdownParent: $("#container_modal_bpjs")
    });
    $('[data-plugin="select_modal_verifikasi"]').select2({
      width: "100%",
      dropdownParent: $("#container_modal_verifikasi")
    });
    $('[data-plugin="select_modal_resign"]').select2({
      width: "100%",
      dropdownParent: $("#container_modal_resign")
    });

    // Sub Change - Jabatan
    $('#sub_project_modal').change(function() {
      var nip = "<?php echo $employee_id; ?>";
      var sub_project = $("#sub_project_modal").val();

      // AJAX request
      $.ajax({
        url: '<?= base_url() ?>admin/Employees/getJabatanBySubProject/',
        method: 'post',
        data: {
          [csrfName]: csrfHash,
          sub_project: sub_project,
          nip: nip,
        },
        beforeSend: function() {
          $('#area_jabatan').html("<div class='form-control'>LOADING...</div>");
        },
        success: function(response) {
          var res = jQuery.parseJSON(response);
          var data_result = res['data'];
          var flag_select = "";
          var html_jabatan = '<select class="form-control" id="jabatan_modal" name="jabatan_modal" data-plugin="select_modal_project" data-placeholder="Posisi/Jabatan">';
          html_jabatan = html_jabatan + '<option value="">Pilih Posisi/Jabatan</option>';

          // Add options
          $.each(data_result, function(index, data) {
            if (res['parameter'] == data['designation_id']) {
              flag_select = "selected";
            }
            html_jabatan = html_jabatan + '<option value="' + data['designation_id'] + '" ' + flag_select + '>' + data['designation_name'] + '</option>';
            flag_select = "";
          });

          //write element
          $('#area_jabatan').html(html_jabatan);

          //load select2 ke element dropdown jabatan
          $('[data-plugin="select_modal_project"]').select2({
            width: "100%",
            dropdownParent: $("#container_modal_project")
          });
        }
      });
    });

    // Bank Change - isi value ke variable hidden bank_name (untuk save)
    $('#nama_bank2').change(function() {
      var bank = $("#nama_bank2").val();
      var nama_bank = $("#nama_bank2 option:selected").text();
      document.getElementById("nama_bank").value = bank;
      // document.getElementById("bank_name").value = nama_bank;
    });

    //save data Rekneing
    $('#rekening_form').submit(function(event) {
      event.preventDefault();
      var nip = "<?php echo $employee_id; ?>";
      var form = document.getElementById('rekening_form');
      var formData = new FormData(form);
      formData.append('nip', nip);

      var nama_bank = $("#nama_bank option:selected").val();
      var nomor_rekening = $("#nomor_rekening").val();
      var pemilik_rekening = $("#pemilik_rekening").val();

      //-------testing-------
      // alert(pemilik_rekening);
      // alert("masuk button save Data Diri");
      // alert('Server Time: '+ getServerTime());
      // alert('Locale Time: '+ new Date(getServerTime()));

      //-------cek apakah ada yang tidak diisi-------
      var pesan_nama_bank = "";
      var pesan_nomor_rekening = "";
      var pesan_pemilik_rekening = "";
      if (nama_bank == "") {
        pesan_nama_bank = "<small style='color:#FF0000;'>Bank tidak boleh kosong</small>";
        $('#nama_bank').focus();
      }
      if (nomor_rekening == "") {
        pesan_nomor_rekening = "<small style='color:#FF0000;'>Nomor rekening tidak boleh kosong</small>";
        $('#nomor_rekening').focus();
      }
      if (pemilik_rekening == "") {
        pesan_pemilik_rekening = "<small style='color:#FF0000;'>Nama pemilik rekening tidak boleh kosong</small>";
        $('#pemilik_rekening').focus();
      }
      $('#pesan_nama_bank').html(pesan_nama_bank);
      $('#pesan_nomor_rekening').html(pesan_nomor_rekening);
      $('#pesan_pemilik_rekening').html(pesan_pemilik_rekening);

      //cek isi form data
      // var html_text_formdata = "";
      // for (var pair of formData.entries()) { // Display the key/value pairs
      //   html_text_formdata = html_text_formdata + pair[0] + ', ' + pair[1] + '\n';
      // }
      // alert(html_text_formdata);

      //-------action-------
      if (
        (pesan_nama_bank != "") || (pesan_nomor_rekening != "") || (pesan_pemilik_rekening != "")
      ) { //kalau ada input kosong 
        alert("Tidak boleh ada input kosong");
        setTimeout(() => {
          $('#button_save_rekening').attr("disabled", false);
          $('#button_save_rekening').removeAttr("data-loading");
        }, 10);

      } else { //kalau semua terisi
        $.ajax({
          url: '<?= base_url() ?>admin/Employees/save_rekening/',
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          beforeSend: function() {
            // $('#editRekeningModal').modal('show');
            $('.info-modal-edit-rekening').attr("hidden", false);
            $('.isi-modal-edit-rekening').attr("hidden", true);
            $('.info-modal-edit-rekening').html(uploading_html_text);
            $('#button_save_rekening').attr("hidden", true);
          },
          success: function(response) {
            var res = jQuery.parseJSON(response);

            if (res['status'] == "200") { //sukses tanpa upload file
              // $("#ethnicity_modal").val(res['data']['ethnicity_type']).change();
              $('#nama_bank_tabel').html(res['nama_bank_read']);
              $('#nomor_rekening_table').html(res['data']['nomor_rek']);
              $('#pemilik_rekening_tabel').html(res['data']['pemilik_rek']);
              $('.info-modal-edit-rekening').html(success_html_text);
              $('.info-modal-edit-rekening').attr("hidden", false);
              $('.isi-modal-edit-rekening').attr("hidden", true);
              $('#button_save_rekening').attr("hidden", true);
              $('#button_save_rekening').attr("disabled", false);
              $('#button_save_rekening').removeAttr("data-loading");
            } else if (res['status'] == "201") { //sukses dengan upload file 301088
              $('#buku_rekening_tabel').html(res['open_buku_tabungan']);
              $('#nama_bank_tabel').html(res['nama_bank_read']);
              $('#nomor_rekening_table').html(res['data']['nomor_rek']);
              $('#pemilik_rekening_tabel').html(res['data']['pemilik_rek']);
              $('.info-modal-edit-rekening').html(success_html_text);
              $('.info-modal-edit-rekening').attr("hidden", false);
              $('.isi-modal-edit-rekening').attr("hidden", true);
              $('#button_save_rekening').attr("hidden", true);
              $('#button_save_rekening').attr("disabled", false);
              $('#button_save_rekening').removeAttr("data-loading");
            } else if (res['status'] == "202") { //upload file error
              $('#pesan_buku_rekening').html("<small style='color:#FF0000;'>" + res['pesan_error'] + "</small>");
              $("#buku_rekening").val("");
              $('.info-modal-edit-rekening').attr("hidden", true);
              $('.isi-modal-edit-rekening').attr("hidden", false);
              $('#button_save_rekening').attr("hidden", false);
              $('#button_save_rekening').attr("disabled", false);
              $('#button_save_rekening').removeAttr("data-loading");
            } else { //another error (unspecified)
              $('.info-modal-edit-rekening').html(res['pesan_error']);
              $('.info-modal-edit-rekening').attr("hidden", false);
              $('.isi-modal-edit-rekening').attr("hidden", true);
              $('#button_save_rekening').attr("hidden", true);
              $('#button_save_rekening').attr("disabled", false);
              $('#button_save_rekening').removeAttr("data-loading");
            }

            // alert('Your form has been sent successfully.');
          },
          error: function(xhr, status, error) {
            html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
            html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
            // html_text = "Gagal fetch data. Kode error: " + xhr.status;
            $('.info-modal-edit-rekening').html(html_text); //coba pake iframe
            $('.isi-modal-edit-rekening').attr("hidden", true);
            $('.info-modal-edit-rekening').attr("hidden", false);
            $('#button_save_rekening').attr("hidden", true);
            $('#button_save_rekening').attr("disabled", false);
            $('#button_save_rekening').removeAttr("data-loading");
          }
        });
      }

    });

  });
</script>
<script type="text/javascript">
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

  var flag_ktp = 0;
  var flag_kk = 0;
  var flag_rekening = 0;
  var flag_api_rekening = 0;
  var baseURL = "<?php echo base_url(); ?>";

  var user_id = "<?php print($session['user_id']); ?>";
  var user_name = "<?php print($user['0']->first_name); ?>";

  var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
  var loading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
  loading_html_text = loading_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
  loading_html_text = loading_html_text + '<h2>LOADING...</h2>';
  loading_html_text = loading_html_text + '</div>';

  var uploading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
  var uploading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
  uploading_html_text = uploading_html_text + '<img src="' + uploading_image + '" alt="" width="100px">';
  uploading_html_text = uploading_html_text + '<h2>PROCESSING...</h2>';
  uploading_html_text = uploading_html_text + '</div>';

  var success_image = "<?php echo base_url('assets/icon/ceklis_hijau.png'); ?>";
  var success_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
  success_html_text = success_html_text + '<img src="' + success_image + '" alt="" width="100px">';
  success_html_text = success_html_text + '<h2 style="color: #00FFA3;">BERHASIL UPDATE DATA</h2>';
  success_html_text = success_html_text + '</div>';

  function getServerTime() {
    return $.ajax({
      async: false
    }).getResponseHeader('Date');
  }
</script>

<!-- Tombol Ubah Foto -->
<script type="text/javascript">
  document.getElementById("button_ubah_foto").onclick = function(e) {
    // alert("Under Construction. Masuk button ubah foto");
    var nip = "<?php echo $employee_id; ?>";
    var jenis_dokumen = "foto";
    var button_save_foto = "<button onclick='save_dokumen(" + nip + ",\"" + jenis_dokumen + "\")' class='btn btn-primary'>Save Foto</button>";
    // alert(jenis_dokumen);

    var input_upload = '<fieldset class="form-group">';
    input_upload = input_upload + '<input type="file" class="form-control-file" id="file_dokumen" name="file_dokumen" accept="image/png, image/jpg, image/jpeg">';
    input_upload = input_upload + '<small>Jenis File: JPG, JPEG, PNG | Size MAX 5 MB</small>';
    input_upload = input_upload + '</fieldset>';

    //inisialisasi pesan
    $('#judul_modal_upload_dokumen').html("Upload Foto");
    $('#label_upload_dokumen').html("File Foto");
    $('#file_dokumen_kosong').html("SILAHKAN UPLOAD FOTO");
    $('#input_upload_dokumen').html(input_upload);
    $('#button_upload_dokumen').html(button_save_foto);

    $("#file_dokumen").val("");
    $('#pesan_upload_dokumen').html("");
    $('.info-modal-upload-dokumen').attr("hidden", true);
    $('.isi-modal-upload-dokumen').attr("hidden", false);
    $('#button_upload_dokumen').attr("hidden", false);
    $('#button_upload_dokumen').attr("disabled", false);
    $('#button_upload_dokumen').removeAttr("data-loading");
    $('#uploadDokumenModal').modal('show');
  };
</script>

<!-- Tombol Show PIN -->
<script type="text/javascript">
  document.getElementById("button_show_pin").onclick = function(e) {
    var nip = "<?php echo $employee_id; ?>";

    // AJAX request untuk cek PIN ke database
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_pin/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: nip
      },
      beforeSend: function() {
        // setting a timeout
        $('.judul-modal').html("Show PIN");
        $('.isi-modal').html(loading_html_text);
        $('#button_save_pin').attr("hidden", true);
        $('#editModal').modal('show');
      },
      success: function(response) {
        // alert("sukses ajax");
        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          html_text = '<div class="container"><div class="row"><table class="table table-striped col-md-12"><tbody>';
          html_text = html_text + "<tr><td><strong>" + "Nama" + "</strong></td><td>" + res['data']['first_name'] + "</td></tr>";
          html_text = html_text + "<tr><td><strong>" + "NIP" + "</strong></td><td>" + res['data']['employee_id'] + "</td></tr>";
          html_text = html_text + "<tr><td><strong>" + "PIN" + "</strong></td><td>" + res['data']['private_code'] + "</td></tr>";
          html_text = html_text + "</tbody></div></div>";
          $('.isi-modal').html(html_text);
        } else {
          html_text = res['pesan'];
          $('.isi-modal').html(html_text);
        }
      },
      error: function(xhr, status, error) {
        // alert("gagal ajax");
        html_text = "Gagal ambil data";
        $('.isi-modal').html(html_text);
      }
    });

  };
</script>

<!-- Tombol Ganti PIN -->
<script type="text/javascript">
  document.getElementById("button_ganti_pin").onclick = function(e) {
    var html_text = '<div class="container"><div class="row"><table class="table table-striped col-md-12"><tbody>';
    html_text = html_text + "<tr><td style='width:25%'>" + "PIN Lama" + "</td><td style='width:75%'><input id='pin_lama' name='pin_lama' type='password' class='form-control' placeholder='PIN Lama' value=''></td></tr>";
    html_text = html_text + "<tr><td>" + "PIN Baru" + "</td><td><input id='pin_baru' name='pin_lama' type='password' class='form-control' placeholder='PIN Baru' value=''></td></tr>";
    html_text = html_text + "<tr><td>" + "Konfirmasi PIN Baru" + "</td><td><input id='konfirmasi_pin_baru' name='konfirmasi_pin_baru' type='password' class='form-control' placeholder='Konfirmasi PIN Baru' value=''></td></tr>";
    html_text = html_text + "</tbody></div></div>";

    $('.judul-modal').html("Ubah PIN");
    $('.isi-modal').html(html_text);
    $('#button_save_pin').attr("hidden", false);
    $('#editModal').modal('show');
  };
</script>

<!-- Tombol SAVE PIN -->
<script type="text/javascript">
  document.getElementById("button_save_pin").onclick = function(e) {
    var nip = "<?php echo $employee_id; ?>";
    var pin_lama = $("#pin_lama").val();
    var pin_baru = $("#pin_baru").val();
    var konfirmasi_pin_baru = $("#konfirmasi_pin_baru").val();
    // var dob = $("#date_of_birth").val();

    // alert(pin_lama);

    var pesan_pin_lama = "";
    var pesan_pin_baru = "";
    var pesan_konfirmasi_pin_baru = "";
    var html_text = "";

    if (pin_lama == "") {
      pesan_pin_lama = "<small style='color:#FF0000;'>Pin lama tidak boleh kosong</small>";
      $('#pin_lama').focus();
    } else {
      pesan_pin_lama = "";
    }

    if (pin_baru == "") {
      pesan_pin_baru = "<small style='color:#FF0000;'>Pin baru tidak boleh kosong</small>";
      $('#pin_baru').focus();
    } else {
      if ($.isNumeric(pin_baru)) {
        if (pin_baru.length < 6) {
          pesan_pin_baru = "<small style='color:#FF0000;'>Pin baru minimal 6 digit</small>";
          $('#pin_baru').focus();
        } else {
          if (pin_baru != konfirmasi_pin_baru) {
            pesan_pin_baru = "<small style='color:#FF0000;'>Pin baru harus sama dengan konfirmasi pin baru</small>";
            pesan_konfirmasi_pin_baru = "<small style='color:#FF0000;'>Pin baru harus sama dengan konfirmasi pin baru</small>";
            $('#pin_baru').focus();
          } else {
            pesan_pin_baru = "";
          }
        }
      } else {
        pesan_pin_baru = "<small style='color:#FF0000;'>Pin baru harus berupa angka</small>";
        $('#pin_baru').focus();
      }
    }

    if (konfirmasi_pin_baru == "") {
      pesan_konfirmasi_pin_baru = "<small style='color:#FF0000;'>Pin baru tidak boleh kosong</small>";
      $('#konfirmasi_pin_baru').focus();
    } else {
      if ($.isNumeric(konfirmasi_pin_baru)) {
        if (konfirmasi_pin_baru.length < 6) {
          pesan_konfirmasi_pin_baru = "<small style='color:#FF0000;'>Pin baru minimal 6 digit</small>";
          $('#konfirmasi_pin_baru').focus();
        } else {
          if (pin_baru != konfirmasi_pin_baru) {
            pesan_pin_baru = "<small style='color:#FF0000;'>Pin baru harus sama dengan konfirmasi pin baru</small>";
            pesan_konfirmasi_pin_baru = "<small style='color:#FF0000;'>Pin baru harus sama dengan konfirmasi pin baru</small>";
            $('#konfirmasi_pin_baru').focus();
          } else {
            pesan_konfirmasi_pin_baru = "";
          }
        }
      } else {
        pesan_konfirmasi_pin_baru = "<small style='color:#FF0000;'>Pin baru harus berupa angka</small>";
        $('#konfirmasi_pin_baru').focus();
      }
    }

    //cek pin baru dengan konfirmasi pin baru
    if ((pesan_pin_lama != "") || (pesan_pin_baru != "") || (pesan_konfirmasi_pin_baru != "")) {
      html_text = '<div class="container"><div class="row"><table class="table table-striped col-md-12"><tbody>';
      html_text = html_text + "<tr><td style='width:25%'>" + "PIN Lama" + "</td><td style='width:75%'><input id='pin_lama' name='pin_lama' type='password' class='form-control' placeholder='PIN Lama' value='" + pin_lama + "'>" + pesan_pin_lama + "</td></tr>";
      html_text = html_text + "<tr><td>" + "PIN Baru" + "</td><td><input id='pin_baru' name='pin_lama' type='password' class='form-control' placeholder='PIN Baru' value='" + pin_baru + "'>" + pesan_pin_baru + "</td></tr>";
      html_text = html_text + "<tr><td>" + "Konfirmasi PIN Baru" + "</td><td><input id='konfirmasi_pin_baru' name='konfirmasi_pin_baru' type='password' class='form-control' placeholder='Konfirmasi PIN Baru' value='" + konfirmasi_pin_baru + "'>" + pesan_konfirmasi_pin_baru + "</td></tr>";
      html_text = html_text + "</tbody></div></div>";
      $('.isi-modal').html(html_text);
      $('#button_save_pin').attr("hidden", false);
    } else {
      // AJAX request untuk ganti PIN
      $.ajax({
        url: '<?= base_url() ?>admin/Employees/ganti_pin/',
        method: 'post',
        data: {
          [csrfName]: csrfHash,
          nip: nip,
          pin_lama: pin_lama,
          pin_baru: pin_baru,
          konfirmasi_pin_baru: konfirmasi_pin_baru,
        },
        beforeSend: function() {
          $('.isi-modal').html(loading_html_text);
          // $('#button_save_pin').attr("hidden", true);
          // $('#editModal').modal('show');
        },
        success: function(response) {
          var res = jQuery.parseJSON(response);

          if (res['status'] == "200") {
            html_text = "<h4 style='color:#00AA00;'>" + res['pesan'] + "</h4>"
            html_text = html_text + '<div class="container"><div class="row"><table class="table table-striped col-md-12"><tbody>';
            html_text = html_text + "<tr><td><strong>" + "Nama" + "</strong></td><td>" + res['data']['first_name'] + "</td></tr>";
            html_text = html_text + "<tr><td><strong>" + "NIP" + "</strong></td><td>" + res['data']['employee_id'] + "</td></tr>";
            html_text = html_text + "<tr><td><strong>" + "PIN" + "</strong></td><td>" + res['data']['private_code'] + "</td></tr>";
            html_text = html_text + "</tbody></div></div>";
            $('.isi-modal').html(html_text);
            $('#button_save_pin').attr("hidden", true);
          } else if (res['status'] == "202") {
            html_text = "<h4 style='color:#FF0000;'>" + res['pesan'] + "</h4>"
            html_text = html_text + '<div class="container"><div class="row"><table class="table table-striped col-md-12"><tbody>';
            html_text = html_text + "<tr><td style='width:25%'>" + "PIN Lama" + "</td><td style='width:75%'><input id='pin_lama' name='pin_lama' type='password' class='form-control' placeholder='PIN Lama' value='" + pin_lama + "'></td></tr>";
            html_text = html_text + "<tr><td>" + "PIN Baru" + "</td><td><input id='pin_baru' name='pin_lama' type='password' class='form-control' placeholder='PIN Baru' value='" + pin_baru + "'></td></tr>";
            html_text = html_text + "<tr><td>" + "Konfirmasi PIN Baru" + "</td><td><input id='konfirmasi_pin_baru' name='konfirmasi_pin_baru' type='password' class='form-control' placeholder='Konfirmasi PIN Baru' value='" + konfirmasi_pin_baru + "'></td></tr>";
            html_text = html_text + "</tbody></div></div>";
            $('.isi-modal').html(html_text);
            $('#button_save_pin').attr("hidden", false);
          } else {
            html_text = res['pesan'];
            $('.isi-modal').html(html_text);
            $('#button_save_pin').attr("hidden", true);
          }
        },
        error: function(xhr, status, error) {
          html_text = "Gagal ambil data";
          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        }
      });
    }
  };
</script>

<!-- Tombol Send PIN -->
<script type="text/javascript">
  document.getElementById("button_send_pin").onclick = function(e) {
    // alert("masuk button send pin");
    var first_name = '<?php echo $first_name; ?>';
    var employee_id = '<?php echo $employee_id; ?>';
    var private_code = '<?php echo $private_code; ?>';
    var project_name = '<?php echo $project_name; ?>';
    var nomor_kontak = '<?php echo $this->Xin_model->clean_post($contact_no); ?>';

    var pesan_whatsapp = '*C.I.S -> Employees Registration.*%0a%0a' +
      'Nama Lengkap: *' + first_name +
      '*%0aNIP: *' + employee_id +
      '*%0aPIN: *' + private_code +
      '*%0aPROJECT: *' + project_name +
      '* %0a%0aSilahkan Login C.I.S Menggunakan NIP dan PIN anda melalui Link Dibawah ini.' +
      '%0aLink C.I.S : https://apps-cakrawala.com/admin%0a' +
      'Lakukan Pembaharuan PIN anda secara berkala, dengan cara, Pilih Menu *My Profile* kemudian *Ubah Pin*%0a%0a' +
      '*INFO HRD di Nomor Whatsapp: 085175168275* %0a' +
      '*IT-CARE di Nomor Whatsapp: 085174123434* %0a%0a' +
      'Terima kasih.';

    window.open("https://wa.me/62" + nomor_kontak + "?text=" + pesan_whatsapp, "_blank");
  };
</script>

<!-- Tombol Send Whatsapp -->
<script type="text/javascript">
  document.getElementById("button_send_whatsapp").onclick = function(e) {
    // alert("masuk button send whatsapp");
    var nomor_kontak = '<?php echo $this->Xin_model->clean_post($contact_no); ?>';

    window.open("https://wa.me/62" + nomor_kontak, "_blank");
  };
</script>

<!-- Tombol Verifikasi -->
<script type="text/javascript">
  document.getElementById("button_verifikasi").onclick = function(e) {
    // alert("Under Construction. Masuk button verifikasi");
    var nip = "<?php echo $employee_id; ?>";

    //inisialisasi pesan
    $('#pesan_nik_verifikasi_modal').html("");
    $('#pesan_kk_verifikasi_modal').html("");
    $('#pesan_nama_verifikasi_modal').html("");
    $('#pesan_bank_verifikasi_modal').html("");
    $('#pesan_norek_verifikasi_modal').html("");
    $('#pesan_pemilik_rekening_verifikasi_modal').html("");

    // AJAX untuk ambil data employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_diri/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: nip,
      },
      beforeSend: function() {
        $('.info-modal-verifkasi').attr("hidden", false);
        $('.isi-modal-verifkasi').attr("hidden", true);
        $('.info-modal-verifkasi').html(loading_html_text);
        $('#verifikasiModal').modal('show');
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          $('#nik_modal').val(res['data']['ktp_no']);
          $("#kk_modal").val(res['data']['kk_no']);
          $('#nama_modal').val(res['data']['first_name']);
          $("#bank_modal").val(res['data']['bank_name']).change();
          $('#rekening_modal').val(res['data']['nomor_rek']);
          $('#pemilik_rekening_modal').val(res['data']['pemilik_rek']);

          $('.isi-modal-verifkasi').attr("hidden", false);
          $('.info-modal-verifkasi').attr("hidden", true);
        } else {
          html_text = res['pesan'];
          $('.info-modal-verifkasi').html(html_text);
          $('.isi-modal-verifkasi').attr("hidden", true);
          $('.info-modal-verifkasi').attr("hidden", false);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-verifkasi').html(html_text); //coba pake iframe
        $('.isi-modal-verifkasi').attr("hidden", true);
        $('.info-modal-verifkasi').attr("hidden", false);
      }
    });

  };
</script>

<!-- Tombol Show/hide KTP Modal -->
<script type="text/javascript">
  document.getElementById("button_show_ktp_modal").onclick = function(e) {
    // e.preventDefault();
    var nip = '<?php echo $employee_id; ?>';

    if (flag_ktp == 0) {
      // AJAX untuk ambil data buku tabungan employee terupdate
      $.ajax({
        url: '<?= base_url() ?>admin/Employees/get_data_dokumen_pribadi/',
        method: 'post',
        data: {
          [csrfName]: csrfHash,
          nip: nip,
        },
        beforeSend: function() {
          $('.ktp-modal').html(loading_html_text);
        },
        success: function(response) {

          var res = jQuery.parseJSON(response);

          if (res['status']['filename_ktp'] == "200") {
            var nama_file = res['data']['filename_ktp'];
            var tipe_file = nama_file.substr(-3, 3);
            var atribut = "";
            var height = '';
            var d = new Date();
            var time = d.getTime();
            nama_file = nama_file + "?" + time;

            if (tipe_file == "pdf") {
              atribut = "application/pdf";
              height = 'height="500px"';
            } else {
              atribut = "image/jpg";
            }

            var html_text = "<div class='row'>";
            // html_text = html_text + "<div class='form-group col-md-12'>";
            html_text = html_text + "<label>Foto KTP  </label>";
            html_text = html_text + '<embed width="100%" ' + height + ' class="col-md-12" type="' + atribut + '" src="' + nama_file + '"></embed>';
            // html_text = html_text + "</div>";
            html_text = html_text + "</div>";

            $('.ktp-modal').html(html_text);
            flag_ktp = 1;
          } else {
            var html_text = "<div class='row'>";
            html_text = html_text + "<label>Foto KTP: </label>";
            html_text = html_text + res['pesan']['filename_ktp'];
            html_text = html_text + "</div>";
            $('.ktp-modal').html(html_text);
            flag_ktp = 1;
          }
        },
        error: function(xhr, status, error) {
          html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
          html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
          // html_text = "Gagal fetch data. Kode error: " + xhr.status;
          $('.ktp-modal').html(html_text); //coba pake iframe
          flag_ktp = 1;
        }
      });

    } else if (flag_ktp == 1) {
      $('.ktp-modal').html("");
      flag_ktp = 0;
    }

  };
</script>

<!-- Tombol Show/hide KK Modal -->
<script type="text/javascript">
  document.getElementById("button_show_kk_modal").onclick = function(e) {
    // e.preventDefault();
    var nip = '<?php echo $employee_id; ?>';

    if (flag_kk == 0) {
      // AJAX untuk ambil data buku tabungan employee terupdate
      $.ajax({
        url: '<?= base_url() ?>admin/Employees/get_data_dokumen_pribadi/',
        method: 'post',
        data: {
          [csrfName]: csrfHash,
          nip: nip,
        },
        beforeSend: function() {
          $('.kk-modal').html(loading_html_text);
        },
        success: function(response) {

          var res = jQuery.parseJSON(response);

          if (res['status']['filename_kk'] == "200") {
            var nama_file = res['data']['filename_kk'];
            var tipe_file = nama_file.substr(-3, 3);
            var atribut = "";
            var height = '';
            var d = new Date();
            var time = d.getTime();
            nama_file = nama_file + "?" + time;

            if (tipe_file == "pdf") {
              atribut = "application/pdf";
              height = 'height="500px"';
            } else {
              atribut = "image/jpg";
            }

            var html_text = "<div class='row'>";
            // html_text = html_text + "<div class='form-group col-md-12'>";
            html_text = html_text + "<label>Foto KK  </label>";
            html_text = html_text + '<embed width="100%" ' + height + ' class="col-md-12" type="' + atribut + '" src="' + nama_file + '"></embed>';
            // html_text = html_text + "</div>";
            html_text = html_text + "</div>";

            $('.kk-modal').html(html_text);
            flag_kk = 1;
          } else {
            var html_text = "<div class='row'>";
            html_text = html_text + "<label>Foto KK: </label>";
            html_text = html_text + res['pesan']['filename_kk'];
            html_text = html_text + "</div>";
            $('.kk-modal').html(html_text);
            flag_kk = 1;
          }
        },
        error: function(xhr, status, error) {
          html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
          html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
          // html_text = "Gagal fetch data. Kode error: " + xhr.status;
          $('.kk-modal').html(html_text); //coba pake iframe
          flag_kk = 1;
        }
      });

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

      // html_text = html_text + "<div class='row'>";
      // html_text = html_text + "<div class='form-group col-md-12'>";
      // html_text = html_text + "<label>Rekening  </label>";
      // html_text = html_text + "<br>LOADING DATA ....";
      // html_text = html_text + "</div>";
      // html_text = html_text + "</div>";

      // $('.rekening-modal').html(html_text);
      $('.rekening-modal').html(loading_html_text);

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

<!-- Tombol Download Resume -->
<script type="text/javascript">
  document.getElementById("button_download_resume").onclick = function(e) {
    alert("Under Construction. Masuk button download resume");
  };
</script>

<!-- Tombol Edit Data Diri -->
<script type="text/javascript">
  document.getElementById("button_edit_data_diri").onclick = function(e) {
    var nip = "<?php echo $employee_id; ?>";

    //inisialisasi pesan
    $('#pesan_first_name_modal').html("");
    $('#pesan_gender_modal').html("");
    $('#pesan_tempat_lahir_modal').html("");
    $('#pesan_date_of_birth_modal').html("");
    $('#pesan_last_edu_modal').html("");
    $('#pesan_ethnicity_modal').html("");
    $('#pesan_marital_status_modal').html("");
    $('#pesan_tinggi_badan_modal').html("");
    $('#pesan_berat_badan_modal').html("");
    $('#pesan_blood_group_modal').html("");
    $('#pesan_ktp_no_modal').html("");
    $('#pesan_kk_no_modal').html("");
    $('#pesan_npwp_no_modal').html("");
    $('#pesan_contact_no_modal').html("");
    $('#pesan_email_modal').html("");
    $('#pesan_ibu_kandung_modal').html("");
    $('#pesan_alamat_ktp_modal').html("");
    $('#pesan_alamat_domisili_modal').html("");

    // AJAX untuk ambil data employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_diri/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: nip,
      },
      beforeSend: function() {
        $('#editDataDiriModal').modal('show');
        $('.info-modal-edit-data-diri').attr("hidden", false);
        $('.isi-modal-edit-data-diri').attr("hidden", true);
        $('.info-modal-edit-data-diri').html(loading_html_text);
        $('#button_save_data_diri').attr("hidden", true);
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          $('#first_name_modal').val(res['data']['first_name']);
          $("#gender_modal").val(res['data']['gender']).change();
          $('#tempat_lahir_modal').val(res['data']['tempat_lahir']);
          $('#date_of_birth_modal').val(res['data']['date_of_birth']);
          $("#ethnicity_modal").val(res['data']['ethnicity_type']).change();
          $("#last_edu_modal").val(res['data']['last_edu']).change();
          $("#marital_status_modal").val(res['data']['marital_status']).change();
          $('#tinggi_badan_modal').val(res['data']['tinggi_badan']);
          $('#berat_badan_modal').val(res['data']['berat_badan']);
          $("#blood_group_modal").val(res['data']['blood_group']).change();
          $('#ktp_no_modal').val(res['data']['ktp_no']);
          $('#kk_no_modal').val(res['data']['kk_no']);
          $('#npwp_no_modal').val(res['data']['npwp_no']);
          $('#contact_no_modal').val(res['data']['contact_no']);
          $('#email_modal').val(res['data']['email']);
          $('#ibu_kandung_modal').val(res['data']['ibu_kandung']);
          $('#alamat_ktp_modal').val(res['data']['alamat_ktp']);
          $('#alamat_domisili_modal').val(res['data']['alamat_domisili']);

          $('.isi-modal-edit-data-diri').attr("hidden", false);
          $('.info-modal-edit-data-diri').attr("hidden", true);
          $('#button_save_data_diri').attr("hidden", false);
        } else {
          html_text = res['pesan'];
          $('.info-modal-edit-data-diri').html(html_text);
          $('.isi-modal-edit-data-diri').attr("hidden", true);
          $('.info-modal-edit-data-diri').attr("hidden", false);
          $('#button_save_data_diri').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-edit-data-diri').html(html_text); //coba pake iframe
        $('.isi-modal-edit-data-diri').attr("hidden", true);
        $('.info-modal-edit-data-diri').attr("hidden", false);
        $('#button_save_data_diri').attr("hidden", true);
      }
    });

  };
</script>

<!-- Tombol Save Data Diri -->
<script type="text/javascript">
  document.getElementById("button_save_data_diri").onclick = function(e) {
    //-------ambil isi variabel-------
    var nip = "<?php echo $employee_id; ?>";
    var nama_lengkap = $("#first_name_modal").val();
    var jenis_kelamin = $("#gender_modal option:selected").val();
    var tempat_lahir = $("#tempat_lahir_modal").val();
    var tanggal_lahir = $("#date_of_birth_modal").val();
    var pendidikan_terakhir = $("#last_edu_modal option:selected").val();
    var agama = $("#ethnicity_modal option:selected").val();
    var status_kawin = $("#marital_status_modal option:selected").val();
    var tinggi_badan = $("#tinggi_badan_modal").val();
    var berat_badan = $("#berat_badan_modal").val();
    var golongan_darah = $("#blood_group_modal option:selected").val();
    var no_ktp = $("#ktp_no_modal").val();
    var no_kk = $("#kk_no_modal").val();
    var no_npwp = $("#npwp_no_modal").val();
    var no_hp = $("#contact_no_modal").val();
    var email = $("#email_modal").val();
    var ibu_kandung = $("#ibu_kandung_modal").val();
    var alamat_ktp = $("#alamat_ktp_modal").val();
    var alamat_domisili = $("#alamat_domisili_modal").val();

    //-------testing-------
    // alert("masuk button save Data Diri");
    // alert('Server Time: '+ getServerTime());
    // alert('Locale Time: '+ new Date(getServerTime()));

    //-------cek apakah ada yang tidak diisi-------
    var pesan_first_name_modal = "";
    var pesan_gender_modal = "";
    var pesan_tempat_lahir_modal = "";
    var pesan_date_of_birth_modal = "";
    var pesan_last_edu_modal = "";
    var pesan_ethnicity_modal = "";
    var pesan_marital_status_modal = "";
    var pesan_tinggi_badan_modal = "";
    var pesan_berat_badan_modal = "";
    var pesan_blood_group_modal = "";
    var pesan_ktp_no_modal = "";
    var pesan_kk_no_modal = "";
    var pesan_npwp_no_modal = "";
    var pesan_contact_no_modal = "";
    var pesan_email_modal = "";
    var pesan_ibu_kandung_modal = "";
    var pesan_alamat_ktp_modal = "";
    var pesan_alamat_domisili_modal = "";
    if (nama_lengkap == "") {
      pesan_first_name_modal = "<small style='color:#FF0000;'>Nama lengkap tidak boleh kosong</small>";
      $('#first_name_modal').focus();
    }
    if (jenis_kelamin == "") {
      pesan_gender_modal = "<small style='color:#FF0000;'>Jenis kelamin tidak boleh kosong</small>";
      $('#gender_modal').focus();
    }
    if (tempat_lahir == "") {
      pesan_tempat_lahir_modal = "<small style='color:#FF0000;'>Tempat lahir tidak boleh kosong</small>";
      $('#tempat_lahir_modal').focus();
    }
    if (tanggal_lahir == "") {
      pesan_date_of_birth_modal = "<small style='color:#FF0000;'>Tanggal lahir tidak boleh kosong</small>";
      $('#date_of_birth_modal').focus();
    }
    if (pendidikan_terakhir == "") {
      pesan_last_edu_modal = "<small style='color:#FF0000;'>Pendidikan terakhir tidak boleh kosong</small>";
      $('#last_edu_modal').focus();
    }
    if (agama == "") {
      pesan_ethnicity_modal = "<small style='color:#FF0000;'>Agama tidak boleh kosong</small>";
      $('#ethnicity_modal').focus();
    }
    if (status_kawin == "") {
      pesan_marital_status_modal = "<small style='color:#FF0000;'>Status kawin tidak boleh kosong</small>";
      $('#marital_status_modal').focus();
    }
    if (tinggi_badan == "") {
      pesan_tinggi_badan_modal = "<small style='color:#FF0000;'>Tinggi badan tidak boleh kosong</small>";
      $('#tinggi_badan_modal').focus();
    }
    if (berat_badan == "") {
      pesan_berat_badan_modal = "<small style='color:#FF0000;'>Berat badan tidak boleh kosong</small>";
      $('#berat_badan_modal').focus();
    }
    if (golongan_darah == "") {
      pesan_blood_group_modal = "<small style='color:#FF0000;'>Golongan darah tidak boleh kosong</small>";
      $('#blood_group_modal').focus();
    }
    if (no_ktp == "") {
      pesan_ktp_no_modal = "<small style='color:#FF0000;'>Nomor KTP tidak boleh kosong</small>";
      $('#ktp_no_modal').focus();
    }
    if (no_kk == "") {
      pesan_kk_no_modal = "<small style='color:#FF0000;'>Nomor KK tidak boleh kosong</small>";
      $('#kk_no_modal').focus();
    }
    if (no_npwp == "") {
      pesan_npwp_no_modal = "<small style='color:#FF0000;'>Nomor NPWP tidak boleh kosong</small>";
      $('#npwp_no_modal').focus();
    }
    if (no_hp == "") {
      pesan_contact_no_modal = "<small style='color:#FF0000;'>Nomor HP tidak boleh kosong</small>";
      $('#contact_no_modal').focus();
    }
    if (email == "") {
      pesan_email_modal = "<small style='color:#FF0000;'>e-Mail tidak boleh kosong</small>";
      $('#email_modal').focus();
    }
    if (ibu_kandung == "") {
      pesan_ibu_kandung_modal = "<small style='color:#FF0000;'>Nama ibu kandung tidak boleh kosong</small>";
      $('#ibu_kandung_modal').focus();
    }
    if (alamat_ktp == "") {
      pesan_alamat_ktp_modal = "<small style='color:#FF0000;'>Alamat KTP tidak boleh kosong</small>";
      $('#alamat_ktp_modal').focus();
    }
    if (alamat_domisili == "") {
      pesan_alamat_domisili_modal = "<small style='color:#FF0000;'>Alamat Domisili tidak boleh kosong</small>";
      $('#alamat_domisili_modal').focus();
    }
    $('#pesan_first_name_modal').html(pesan_first_name_modal);
    $('#pesan_gender_modal').html(pesan_gender_modal);
    $('#pesan_tempat_lahir_modal').html(pesan_tempat_lahir_modal);
    $('#pesan_date_of_birth_modal').html(pesan_date_of_birth_modal);
    $('#pesan_last_edu_modal').html(pesan_last_edu_modal);
    $('#pesan_ethnicity_modal').html(pesan_ethnicity_modal);
    $('#pesan_marital_status_modal').html(pesan_marital_status_modal);
    $('#pesan_tinggi_badan_modal').html(pesan_tinggi_badan_modal);
    $('#pesan_berat_badan_modal').html(pesan_berat_badan_modal);
    $('#pesan_ktp_no_modal').html(pesan_ktp_no_modal);
    $('#pesan_kk_no_modal').html(pesan_kk_no_modal);
    $('#pesan_npwp_no_modal').html(pesan_npwp_no_modal);
    $('#pesan_contact_no_modal').html(pesan_contact_no_modal);
    $('#pesan_ibu_kandung_modal').html(pesan_ibu_kandung_modal);
    $('#pesan_alamat_ktp_modal').html(pesan_alamat_ktp_modal);
    $('#pesan_alamat_domisili_modal').html(pesan_alamat_domisili_modal);

    //-------action-------
    if (
      (pesan_first_name_modal != "") || (pesan_gender_modal != "") || (pesan_tempat_lahir_modal != "") ||
      (pesan_date_of_birth_modal != "") || (pesan_last_edu_modal != "") || (pesan_ethnicity_modal != "") ||
      (pesan_marital_status_modal != "") || (pesan_tinggi_badan_modal != "") || (pesan_berat_badan_modal != "") ||
      (pesan_ktp_no_modal != "") || (pesan_kk_no_modal != "") ||
      (pesan_npwp_no_modal != "") || (pesan_contact_no_modal != "") ||
      (pesan_ibu_kandung_modal != "") || (pesan_alamat_ktp_modal != "") || (pesan_alamat_domisili_modal != "")
    ) { //kalau ada input kosong 
      alert("Tidak boleh ada input kosong");
    } else { //kalau semua terisi
      // AJAX untuk save data employee
      $.ajax({
        url: '<?= base_url() ?>admin/Employees/save_data_diri/',
        method: 'post',
        data: {
          [csrfName]: csrfHash,
          nip: nip,
          nama_lengkap: nama_lengkap,
          jenis_kelamin: jenis_kelamin,
          tempat_lahir: tempat_lahir,
          tanggal_lahir: tanggal_lahir,
          pendidikan_terakhir: pendidikan_terakhir,
          agama: agama,
          status_kawin: status_kawin,
          tinggi_badan: tinggi_badan,
          berat_badan: berat_badan,
          golongan_darah: golongan_darah,
          no_ktp: no_ktp,
          no_kk: no_kk,
          no_npwp: no_npwp,
          no_hp: no_hp,
          email: email,
          ibu_kandung: ibu_kandung,
          alamat_ktp: alamat_ktp,
          alamat_domisili: alamat_domisili,
        },
        beforeSend: function() {
          $('#editDataDiriModal').modal('show');
          $('.info-modal-edit-data-diri').attr("hidden", false);
          $('.isi-modal-edit-data-diri').attr("hidden", true);
          $('.info-modal-edit-data-diri').html(loading_html_text);
          $('#button_save_data_diri').attr("hidden", true);
        },
        success: function(response) {

          var res = jQuery.parseJSON(response);

          if (res['status'] == "200") {
            //update nilai terbaru di halaman profile
            $('#nama_lengkap_tabel').html(res['data']['first_name']);
            $('#nama_lengkap_card').html(res['data']['first_name']);
            $('#gender_name_tabel').html(res['data']['gender']);
            $('#tempat_lahir_tabel').html(res['data']['tempat_lahir']);
            $('#tanggal_lahir_tabel').html(res['data']['date_of_birth']);
            $('#pendidikan_terakhir_tabel').html(res['data']['last_edu']);
            $('#agama_tabel').html(res['data']['ethnicity_type']);
            $('#status_kawin_tabel').html(res['data']['marital_status']);
            $('#tinggi_badan_tabel').html(res['data']['tinggi_badan']);
            $('#berat_badan_tabel').html(res['data']['berat_badan']);
            $('#golongan_darah_tabel').html(res['data']['blood_group']);
            $('#nomor_ktp_tabel').html(res['data']['ktp_no']);
            $('#nomor_kk_tabel').html(res['data']['kk_no']);
            $('#nomor_npwp_tabel').html(res['data']['npwp_no']);
            $('#nomor_kontak_tabel').html(res['data']['contact_no']);
            $('#email_tabel').html(res['data']['email']);
            $('#ibu_kandung_tabel').html(res['data']['ibu_kandung']);
            $('#alamat_ktp_tabel').html(res['data']['alamat_ktp']);
            $('#alamat_domisili_tabel').html(res['data']['alamat_domisili']);

            //tampilkan pesan sukses
            $('.info-modal-edit-data-diri').attr("hidden", false);
            $('.isi-modal-edit-data-diri').attr("hidden", true);
            $('.info-modal-edit-data-diri').html(success_html_text);
            $('#button_save_data_diri').attr("hidden", true);
          } else {
            html_text = res['pesan'];
            $('.info-modal-edit-data-diri').html(html_text);
            $('.isi-modal-edit-data-diri').attr("hidden", true);
            $('.info-modal-edit-data-diri').attr("hidden", false);
            $('#button_save_data_diri').attr("hidden", true);
          }
        },
        error: function(xhr, status, error) {
          html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
          html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
          // html_text = "Gagal fetch data. Kode error: " + xhr.status;
          $('.info-modal-edit-data-diri').html(html_text); //coba pake iframe
          $('.isi-modal-edit-data-diri').attr("hidden", true);
          $('.info-modal-edit-data-diri').attr("hidden", false);
          $('#button_save_data_diri').attr("hidden", true);
        }
      });

      // alert("Tidak ada input kosong");
    }

  };
</script>

<!-- Tombol Edit Project Jabatan -->
<script type="text/javascript">
  document.getElementById("button_edit_project").onclick = function(e) {
    var nip = "<?php echo $employee_id; ?>";

    //inisialisasi pesan
    $('#pesan_sub_project_modal').html("");
    $('#pesan_jabatan_modal').html("");
    $('#pesan_penempatan_modal').html("");
    $('#pesan_kategori_modal').html("");
    $('#pesan_date_of_join_modal').html("");

    // AJAX untuk ambil data employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_project/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: nip,
      },
      beforeSend: function() {
        $('#editProjectModal').modal('show');
        $('.info-modal-edit-project').attr("hidden", false);
        $('.isi-modal-edit-project').attr("hidden", true);
        $('.info-modal-edit-project').html(loading_html_text);
        $('#button_save_project').attr("hidden", true);
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          $('#role_modal').val(res['data']['user_role_id']).change();
          $('#sub_project_modal').val(res['data']['sub_project_id']).change();
          $("#jabatan_modal").val(res['data']['designation_id']).change();
          $('#penempatan_modal').val(res['data']['penempatan']);
          $('#kategori_modal').val(res['data']['location_id']).change();
          $("#date_of_join_modal").val(res['data']['date_of_joining']);

          $('.isi-modal-edit-project').attr("hidden", false);
          $('.info-modal-edit-project').attr("hidden", true);
          $('#button_save_project').attr("hidden", false);
        } else {
          html_text = res['pesan'];
          $('.info-modal-edit-project').html(html_text);
          $('.isi-modal-edit-project').attr("hidden", true);
          $('.info-modal-edit-project').attr("hidden", false);
          $('#button_save_project').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-edit-project').html(html_text); //coba pake iframe
        $('.isi-modal-edit-project').attr("hidden", true);
        $('.info-modal-edit-project').attr("hidden", false);
        $('#button_save_project').attr("hidden", true);
      }
    });

    // alert("masuk button edit Project Jabatan");
    // $('#editProjectModal').modal('show');
  };
</script>

<!-- Tombol Save Project -->
<script type="text/javascript">
  document.getElementById("button_save_project").onclick = function(e) {
    // alert("masuk button save Project");
    //-------ambil isi variabel-------
    var nip = "<?php echo $employee_id; ?>";
    var sub_project = $("#sub_project_modal option:selected").val();
    var jabatan = $("#jabatan_modal option:selected").val();
    var penempatan = $("#penempatan_modal").val();
    var kategori = $("#kategori_modal option:selected").val();
    var date_of_join = $("#date_of_join_modal").val();
    var role_id_karyawan = $("#role_modal").val();

    //-------testing-------
    // alert("masuk button save Data Diri");
    // alert('Server Time: '+ getServerTime());
    // alert('Locale Time: '+ new Date(getServerTime()));

    //-------cek apakah ada yang tidak diisi-------
    var pesan_sub_project_modal = "";
    var pesan_jabatan_modal = "";
    var pesan_penempatan_modal = "";
    var pesan_kategori_modal = "";
    var pesan_date_of_join_modal = "";
    if (sub_project == "") {
      pesan_sub_project_modal = "<small style='color:#FF0000;'>Sub Project tidak boleh kosong</small>";
      $('#sub_project_modal').focus();
    }
    if (jabatan == "") {
      pesan_jabatan_modal = "<small style='color:#FF0000;'>Jabatan tidak boleh kosong</small>";
      $('#jabatan_modal').focus();
    }
    if (penempatan == "") {
      pesan_penempatan_modal = "<small style='color:#FF0000;'>Penempatan tidak boleh kosong</small>";
      $('#penempatan_modal').focus();
    }
    if (kategori == "") {
      pesan_kategori_modal = "<small style='color:#FF0000;'>Kategori tidak boleh kosong</small>";
      $('#kategori_modal').focus();
    }
    if (date_of_join == "") {
      pesan_date_of_join_modal = "<small style='color:#FF0000;'>Tanggal bergabung tidak boleh kosong</small>";
      $('#date_of_join_modal').focus();
    }
    $('#pesan_sub_project_modal').html(pesan_sub_project_modal);
    $('#pesan_jabatan_modal').html(pesan_jabatan_modal);
    $('#pesan_penempatan_modal').html(pesan_penempatan_modal);
    $('#pesan_kategori_modal').html(pesan_kategori_modal);
    $('#pesan_date_of_join_modal').html(pesan_date_of_join_modal);

    //-------action-------
    if (
      (pesan_sub_project_modal != "") || (pesan_jabatan_modal != "") || (pesan_penempatan_modal != "") ||
      (pesan_kategori_modal != "") || (pesan_date_of_join_modal != "")
    ) { //kalau ada input kosong 
      alert("Tidak boleh ada input kosong");
    } else { //kalau semua terisi
      // AJAX untuk save data employee
      $.ajax({
        url: '<?= base_url() ?>admin/Employees/save_project/',
        method: 'post',
        data: {
          [csrfName]: csrfHash,
          nip: nip,
          sub_project: sub_project,
          jabatan: jabatan,
          penempatan: penempatan,
          kategori: kategori,
          date_of_join: date_of_join,
          role_id_karyawan: role_id_karyawan,
        },
        beforeSend: function() {
          $('#editProjectModal').modal('show');
          $('.info-modal-edit-project').attr("hidden", false);
          $('.isi-modal-edit-project').attr("hidden", true);
          $('.info-modal-edit-project').html(loading_html_text);
          $('#button_save_project').attr("hidden", true);
        },
        success: function(response) {

          var res = jQuery.parseJSON(response);

          if (res['status'] == "200") {
            //update nilai terbaru di halaman profile
            $('#sub_project_tabel').html(res['data']['sub_project_id']);
            $('#jabatan_tabel').html(res['data']['designation_id']);
            $('#jabatan_name_card').html("JABATAN: " + res['data']['designation_id']);
            $('#penempatan_tabel').html(res['data']['penempatan']);
            $('#kategori_tabel').html(res['data']['location_id']);
            $('#kategori_name_card').html("KATEGORI: " + res['data']['location_id']);
            $('#date_of_join_tabel').html(res['data']['date_of_joining']);

            //tampilkan pesan sukses
            $('.info-modal-edit-project').attr("hidden", false);
            $('.isi-modal-edit-project').attr("hidden", true);
            $('.info-modal-edit-project').html(success_html_text);
            $('#button_save_project').attr("hidden", true);
          } else {
            html_text = res['pesan'];
            $('.info-modal-edit-project').html(html_text);
            $('.isi-modal-edit-project').attr("hidden", true);
            $('.info-modal-edit-project').attr("hidden", false);
            $('#button_save_project').attr("hidden", true);
          }
        },
        error: function(xhr, status, error) {
          html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
          html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
          // html_text = "Gagal fetch data. Kode error: " + xhr.status;
          $('.info-modal-edit-project').html(html_text); //coba pake iframe
          $('.isi-modal-edit-project').attr("hidden", true);
          $('.info-modal-edit-project').attr("hidden", false);
          $('#button_save_project').attr("hidden", true);
        }
      });

      // alert("Tidak ada input kosong");
    }
  };
</script>

<!-- Tombol Edit Kontak Darurat -->
<script type="text/javascript">
  document.getElementById("button_edit_kontak_darurat").onclick = function(e) {
    var nip = "<?php echo $employee_id; ?>";

    //inisialisasi pesan
    $('#pesan_nama_kontak_modal').html("");
    $('#pesan_hubungan_modal').html("");
    $('#pesan_nomor_kontak_modal').html("");

    // AJAX untuk ambil data employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_kontak/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: nip,
      },
      beforeSend: function() {
        $('#editKontakModal').modal('show');
        $('.info-modal-edit-kontak').attr("hidden", false);
        $('.isi-modal-edit-kontak').attr("hidden", true);
        $('.info-modal-edit-kontak').html(loading_html_text);
        $('#button_save_kontak').attr("hidden", true);
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          $('#nama_kontak_modal').val(res['data']['nama']);
          $("#hubungan_modal").val(res['data']['hubungan']).change();
          $('#nomor_kontak_modal').val(res['data']['no_kontak']);

          $('.isi-modal-edit-kontak').attr("hidden", false);
          $('.info-modal-edit-kontak').attr("hidden", true);
          $('#button_save_kontak').attr("hidden", false);
        } else {
          html_text = res['pesan'];
          $('.info-modal-edit-kontak').html(html_text);
          $('.isi-modal-edit-kontak').attr("hidden", true);
          $('.info-modal-edit-kontak').attr("hidden", false);
          $('#button_save_kontak').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-edit-kontak').html(html_text); //coba pake iframe
        $('.isi-modal-edit-kontak').attr("hidden", true);
        $('.info-modal-edit-kontak').attr("hidden", false);
        $('#button_save_kontak').attr("hidden", true);
      }
    });

    // alert("Under Construction. Masuk button edit Kontak Darurat");
    // $('#editKontakModal').modal('show');
  };
</script>

<!-- Tombol Save Kontak Darurat -->
<script type="text/javascript">
  document.getElementById("button_save_kontak").onclick = function(e) {
    //-------ambil isi variabel-------
    var nip = "<?php echo $employee_id; ?>";
    var nama_kontak_modal = $("#nama_kontak_modal").val();
    var hubungan_modal = $("#hubungan_modal option:selected").val();
    var nomor_kontak_modal = $("#nomor_kontak_modal").val();

    //-------testing-------
    // alert("masuk button save Data Diri");
    // alert('Server Time: '+ getServerTime());
    // alert('Locale Time: '+ new Date(getServerTime()));

    //-------cek apakah ada yang tidak diisi-------
    var pesan_nama_kontak_modal = "";
    var pesan_hubungan_modal = "";
    var pesan_nomor_kontak_modal = "";
    if (nama_kontak_modal == "") {
      pesan_nama_kontak_modal = "<small style='color:#FF0000;'>Nama kontak darurat tidak boleh kosong</small>";
      $('#nama_kontak_modal').focus();
    }
    if (hubungan_modal == "") {
      pesan_hubungan_modal = "<small style='color:#FF0000;'>Hubungan kontak darurat tidak boleh kosong</small>";
      $('#hubungan_modal').focus();
    }
    if (nomor_kontak_modal == "") {
      pesan_nomor_kontak_modal = "<small style='color:#FF0000;'>Nomor kontak darurat tidak boleh kosong</small>";
      $('#nomor_kontak_modal').focus();
    }
    $('#pesan_nama_kontak_modal').html(pesan_nama_kontak_modal);
    $('#pesan_hubungan_modal').html(pesan_hubungan_modal);
    $('#pesan_nomor_kontak_modal').html(pesan_nomor_kontak_modal);

    //-------action-------
    if (
      (pesan_nama_kontak_modal != "") || (pesan_hubungan_modal != "") || (pesan_nomor_kontak_modal != "")
    ) { //kalau ada input kosong 
      alert("Tidak boleh ada input kosong");
    } else { //kalau semua terisi
      // AJAX untuk save data employee
      $.ajax({
        url: '<?= base_url() ?>admin/Employees/save_kontak/',
        method: 'post',
        data: {
          [csrfName]: csrfHash,
          nip: nip,
          nama_kontak: nama_kontak_modal,
          hubungan: hubungan_modal,
          nomor_kontak: nomor_kontak_modal,
        },
        beforeSend: function() {
          $('#editKontakModal').modal('show');
          $('.info-modal-edit-kontak').attr("hidden", false);
          $('.isi-modal-edit-kontak').attr("hidden", true);
          $('.info-modal-edit-kontak').html(loading_html_text);
          $('#button_save_kontak').attr("hidden", true);
        },
        success: function(response) {

          var res = jQuery.parseJSON(response);

          if (res['status'] == "200") {
            //update nilai terbaru di halaman profile
            $('#nama_kontak_tabel').html(res['data']['nama']);
            $('#hubungan_tabel').html(res['data']['hubungan']);
            $('#nomor_kontak_darurat_tabel').html(res['data']['no_kontak']);

            //tampilkan pesan sukses
            $('.info-modal-edit-kontak').attr("hidden", false);
            $('.isi-modal-edit-kontak').attr("hidden", true);
            $('.info-modal-edit-kontak').html(success_html_text);
            $('#button_save_kontak').attr("hidden", true);
          } else {
            html_text = res['pesan'];
            $('.info-modal-edit-kontak').html(html_text);
            $('.isi-modal-edit-kontak').attr("hidden", true);
            $('.info-modal-edit-kontak').attr("hidden", false);
            $('#button_save_kontak').attr("hidden", true);
          }
        },
        error: function(xhr, status, error) {
          html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
          html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
          // html_text = "Gagal fetch data. Kode error: " + xhr.status;
          $('.info-modal-edit-kontak').html(html_text); //coba pake iframe
          $('.isi-modal-edit-kontak').attr("hidden", true);
          $('.info-modal-edit-kontak').attr("hidden", false);
          $('#button_save_kontak').attr("hidden", true);
        }
      });

      // alert("Tidak ada input kosong");
    }
  };
</script>

<!-- Tombol Edit Rekening Bank -->
<script type="text/javascript">
  document.getElementById("button_edit_rekening").onclick = function(e) {
    var nip = "<?php echo $employee_id; ?>";
    //var buka_buku_tabungan = '<button id="button_open_buku_tabungan" type="button" class="btn btn-sm btn-outline-primary ladda-button mx-1" data-style="expand-right">Open Buku Tabungan</button>';
    // alert();

    //inisialisasi pesan
    $('#pesan_nama_bank').html("");
    $('#pesan_nomor_rekening').html("");
    $('#pesan_pemilik_rekening').html("");
    $('#pesan_buku_rekening').html("");

    // AJAX untuk ambil data employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_rekening/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: nip,
      },
      beforeSend: function() {
        $('#editRekeningModal').modal('show');
        $('.info-modal-edit-rekening').attr("hidden", false);
        $('.isi-modal-edit-rekening').attr("hidden", true);
        $('.info-modal-edit-rekening').html(loading_html_text);
        $('#button_save_rekening').attr("hidden", true);
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          $('#nama_bank2').val(res['data']['bank_name']).change();
          $('#nama_bank').val(res['data']['bank_name']);
          $("#nomor_rekening").val(res['data']['nomor_rek']);
          $('#pemilik_rekening').val(res['data']['pemilik_rek']);

          if ((res['data']['filename_rek'] == null) || (res['data']['filename_rek'] == "") || (res['data']['filename_rek'] == "0")) {
            $('#file_buku_tabungan_kosong').attr("hidden", false);
            $('#file_buku_tabungan_isi').attr("hidden", true);
            $('#form_upload_buku_tabungan').attr("hidden", false);
          } else {
            $('#file_buku_tabungan_kosong').attr("hidden", true);
            $('#file_buku_tabungan_isi').attr("hidden", false);
            if (res['validation'] == "1") {
              $('#button_open_upload_buku_tabungan').attr("hidden", true);
            } else {
              $('#button_open_upload_buku_tabungan').attr("hidden", false);
            }
            $('#form_upload_buku_tabungan').attr("hidden", true);
          }

          $('.isi-modal-edit-rekening').attr("hidden", false);
          $('.info-modal-edit-rekening').attr("hidden", true);
          $('#button_save_rekening').attr("hidden", false);
        } else {
          html_text = res['pesan'];
          $('.info-modal-edit-rekening').html(html_text);
          $('.isi-modal-edit-rekening').attr("hidden", true);
          $('.info-modal-edit-rekening').attr("hidden", false);
          $('#button_save_rekening').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-edit-rekening').html(html_text); //coba pake iframe
        $('.isi-modal-edit-rekening').attr("hidden", true);
        $('.info-modal-edit-rekening').attr("hidden", false);
        $('#button_save_rekening').attr("hidden", true);
      }
    });

  };
</script>

<!-- Tombol Open Buku Tabungan -->
<script type="text/javascript">
  function open_buku_tabungan(nip) {
    // AJAX untuk ambil data buku tabungan employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_dokumen_pribadi/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: nip,
      },
      beforeSend: function() {
        $('.judul-modal').html("File Buku Tabungan");
        $('.isi-modal').html(loading_html_text);
        $('#button_save_pin').attr("hidden", true);
        $('#editModal').appendTo("body").modal('show');

        // $('#editRekeningModal').modal('show');
        // $('.info-modal-edit-rekening').attr("hidden", false);
        // $('.isi-modal-edit-rekening').attr("hidden", true);
        // $('.info-modal-edit-rekening').html(loading_html_text);
        // $('#button_save_rekening').attr("hidden", true);
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status']['filename_rek'] == "200") {
          var nama_file = res['data']['filename_rek'];
          var tipe_file = nama_file.substr(-3, 3);
          var atribut = "";
          var height = '';
          var d = new Date();
          var time = d.getTime();
          nama_file = nama_file + "?" + time;

          if (tipe_file == "pdf") {
            atribut = "application/pdf";
            height = 'height="500px"';
          } else {
            atribut = "image/jpg";
          }

          var html_text = '<embed ' + height + ' class="col-md-12" type="' + atribut + '" src="' + nama_file + '"></embed>';

          // var html_text = '<iframe src="http://localhost/appcakrawala/uploads/document/rekening/' + res['data']['filename_rek'] + '" style="zoom:1.00" frameborder="0" height="400" width="99.6%"></iframe>';
          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        } else {
          html_text = res['pesan']['filename_rek'];
          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.isi-modal').html(html_text); //coba pake iframe
        $('#button_save_pin').attr("hidden", true);
      }
    });

  }

  function open_upload_buku_tabungan(nip) {
    $('#form_upload_buku_tabungan').attr("hidden", false);
    $('#button_open_upload_buku_tabungan').attr("hidden", true);
  }
</script>


<!-- Tombol Open KTP -->
<script type="text/javascript">
  function open_ktp(nip) {
    // AJAX untuk ambil data buku tabungan employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_dokumen_pribadi/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: nip,
      },
      beforeSend: function() {
        $('.judul-modal').html("File KTP");
        $('.isi-modal').html(loading_html_text);
        $('#button_save_pin').attr("hidden", true);
        $('#editModal').appendTo("body").modal('show');
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status']['filename_ktp'] == "200") {
          var nama_file = res['data']['filename_ktp'];
          var tipe_file = nama_file.substr(-3, 3);
          var atribut = "";
          var height = '';
          var d = new Date();
          var time = d.getTime();
          nama_file = nama_file + "?" + time;

          if (tipe_file == "pdf") {
            atribut = "application/pdf";
            height = 'height="500px"';
          } else {
            atribut = "image/jpg";
          }

          var html_text = '<embed ' + height + ' class="col-md-12" type="' + atribut + '" src="' + nama_file + '"></embed>';

          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        } else {
          html_text = res['pesan']['filename_ktp'];
          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.isi-modal').html(html_text); //coba pake iframe
        $('#button_save_pin').attr("hidden", true);
      }
    });

  }
</script>

<!-- Tombol Upload KTP -->
<script type="text/javascript">
  function upload_ktp(nip) {
    var nip = "<?php echo $employee_id; ?>";
    var jenis_dokumen = "ktp";
    var button_save_ktp = "<button onclick='save_dokumen(" + nip + ",\"" + jenis_dokumen + "\")' class='btn btn-primary'>Save KTP</button>";
    // alert();

    var input_upload = '<fieldset class="form-group">';
    input_upload = input_upload + '<input type="file" class="form-control-file" id="file_dokumen" name="file_dokumen" accept="application/pdf, image/png, image/jpg, image/jpeg">';
    input_upload = input_upload + '<small>Jenis File: JPG, JPEG, PNG, PDF | Size MAX 5 MB</small>';
    input_upload = input_upload + '</fieldset>';

    //inisialisasi pesan
    $('#judul_modal_upload_dokumen').html("Upload KTP");
    $('#label_upload_dokumen').html("Foto KTP");
    $('#file_dokumen_kosong').html("SILAHKAN UPLOAD FOTO KTP");
    $('#input_upload_dokumen').html(input_upload);
    $('#button_upload_dokumen').html(button_save_ktp);

    $("#file_dokumen").val("");
    $('#pesan_upload_dokumen').html("");
    $('.info-modal-upload-dokumen').attr("hidden", true);
    $('.isi-modal-upload-dokumen').attr("hidden", false);
    $('#button_upload_dokumen').attr("hidden", false);
    $('#button_upload_dokumen').attr("disabled", false);
    $('#button_upload_dokumen').removeAttr("data-loading");
    $('#uploadDokumenModal').modal('show');

  }
</script>

<!-- Tombol Save Dokumen -->
<script type="text/javascript">
  function save_dokumen(nip, jenis_dokumen) {
    var form = document.getElementById('dokumen_form');
    var formData = new FormData(form);
    formData.append('nip', nip);
    formData.append('jenis_dokumen', jenis_dokumen);

    $('#pesan_upload_dokumen').html("");

    //-------testing-------
    // alert("masuk button save");
    // alert('Server Time: '+ getServerTime());
    // alert('Locale Time: '+ new Date(getServerTime()));

    //cek isi form data
    // var html_text_formdata = "";
    // for (var pair of formData.entries()) { // Display the key/value pairs
    //   html_text_formdata = html_text_formdata + pair[0] + ', ' + pair[1] + '\n';
    // }
    // alert(html_text_formdata);

    //-------action-------
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/save_dokumen/',
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: function() {
        // $('#editRekeningModal').modal('show');
        $('.info-modal-upload-dokumen').attr("hidden", false);
        $('.isi-modal-upload-dokumen').attr("hidden", true);
        $('.info-modal-upload-dokumen').html(uploading_html_text);
        $('#button_upload_dokumen').attr("hidden", true);
      },
      success: function(response) {
        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") { //sukses upload file
          //update foto profile
          var file_foto_profile = "";
          if ((res['data']['profile_picture'] == null) || (res['data']['profile_picture'] == '') || (res['data']['profile_picture'] == 'no file')) {
            if (res['data']['gender'] == 'L') {
              file_foto_profile = '<?= base_url() ?>uploads/profile/default_male.jpg' + '?' + res['time'];
            } else {
              file_foto_profile = '<?= base_url() ?>uploads/profile/default_female.jpg' + '?' + res['time'];
            }
          } else {
            file_foto_profile = '<?= base_url() ?>uploads/profile/' + res['data']['profile_picture'] + '?' + res['time'];
          }
          var foto_profile_html = '<button onclick="open_foto_profil(' + nip + ')" type="button" class="btn btn-primary"><img src="' + file_foto_profile + '" alt="" width="100%"></button>';

          $('#dokumen_ktp_tabel').html(res['button_upload_ktp']);
          $('#dokumen_kk_tabel').html(res['button_upload_kk']);
          $('#dokumen_npwp_tabel').html(res['button_upload_npwp']);
          $('#dokumen_cv_tabel').html(res['button_upload_cv']);
          $('#dokumen_skck_tabel').html(res['button_upload_skck']);
          $('#dokumen_ijazah_tabel').html(res['button_upload_ijazah']);

          $('#foto_profile').html(foto_profile_html);
          $('.info-modal-upload-dokumen').html(success_html_text);
          $('.info-modal-upload-dokumen').attr("hidden", false);
          $('.isi-modal-upload-dokumen').attr("hidden", true);
          $('#button_upload_dokumen').attr("hidden", true);
          $('#button_upload_dokumen').attr("disabled", false);
          $('#button_upload_dokumen').removeAttr("data-loading");
        } else if (res['status'] == "201") { //upload file error
          $('#pesan_upload_dokumen').html("<small style='color:#FF0000;'>" + res['pesan_error'] + "</small>");
          $("#file_dokumen").val("");
          $('.info-modal-upload-dokumen').attr("hidden", true);
          $('.isi-modal-upload-dokumen').attr("hidden", false);
          $('#button_upload_dokumen').attr("hidden", false);
          $('#button_upload_dokumen').attr("disabled", false);
          $('#button_upload_dokumen').removeAttr("data-loading");
        } else { //another error (unspecified)
          $('#pesan_upload_dokumen').html("<small style='color:#FF0000;'>" + res['pesan_error'] + "</small>");
          $('.info-modal-upload-dokumen').attr("hidden", true);
          $('.isi-modal-upload-dokumen').attr("hidden", false);
          $('#button_upload_dokumen').attr("hidden", false);
          $('#button_upload_dokumen').attr("disabled", false);
          $('#button_upload_dokumen').removeAttr("data-loading");
        }

        // alert('Your form has been sent successfully.');
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-upload-dokumen').html(html_text); //coba pake iframe
        $('.isi-modal-upload-dokumen').attr("hidden", true);
        $('.info-modal-upload-dokumen').attr("hidden", false);
        $('#button_upload_dokumen').attr("hidden", true);
        $('#button_upload_dokumen').attr("disabled", false);
        $('#button_upload_dokumen').removeAttr("data-loading");
      }
    });

  }
</script>

<!-- Tombol Open KK -->
<script type="text/javascript">
  function open_kk(nip) {
    // AJAX untuk ambil data buku tabungan employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_dokumen_pribadi/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: nip,
      },
      beforeSend: function() {
        $('.judul-modal').html("File KK");
        $('.isi-modal').html(loading_html_text);
        $('#button_save_pin').attr("hidden", true);
        $('#editModal').appendTo("body").modal('show');

        // $('#editRekeningModal').modal('show');
        // $('.info-modal-edit-rekening').attr("hidden", false);
        // $('.isi-modal-edit-rekening').attr("hidden", true);
        // $('.info-modal-edit-rekening').html(loading_html_text);
        // $('#button_save_rekening').attr("hidden", true);
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status']['filename_kk'] == "200") {
          var nama_file = res['data']['filename_kk'];
          var tipe_file = nama_file.substr(-3, 3);
          var atribut = "";
          var height = '';
          var d = new Date();
          var time = d.getTime();
          nama_file = nama_file + "?" + time;

          if (tipe_file == "pdf") {
            atribut = "application/pdf";
            height = 'height="500px"';
          } else {
            atribut = "image/jpg";
          }

          var html_text = '<embed ' + height + ' class="col-md-12" type="' + atribut + '" src="' + nama_file + '"></embed>';

          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        } else {
          html_text = res['pesan']['filename_kk'];
          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.isi-modal').html(html_text); //coba pake iframe
        $('#button_save_pin').attr("hidden", true);
      }
    });

  }
</script>

<!-- Tombol Upload KK -->
<script type="text/javascript">
  function upload_kk(nip) {
    var nip = "<?php echo $employee_id; ?>";
    var jenis_dokumen = "kk";
    var button_save = "<button onclick='save_dokumen(" + nip + ",\"" + jenis_dokumen + "\")' class='btn btn-primary'>Save KK</button>";
    // alert();

    var input_upload = '<fieldset class="form-group">';
    input_upload = input_upload + '<input type="file" class="form-control-file" id="file_dokumen" name="file_dokumen" accept="application/pdf, image/png, image/jpg, image/jpeg">';
    input_upload = input_upload + '<small>Jenis File: JPG, JPEG, PNG, PDF | Size MAX 5 MB</small>';
    input_upload = input_upload + '</fieldset>';

    //inisialisasi pesan
    $('#judul_modal_upload_dokumen').html("Upload Kartu Keluarga");
    $('#label_upload_dokumen').html("Foto KK");
    $('#file_dokumen_kosong').html("SILAHKAN UPLOAD FOTO KK");
    $('#input_upload_dokumen').html(input_upload);
    $('#button_upload_dokumen').html(button_save);

    $("#file_dokumen").val("");
    $('#pesan_upload_dokumen').html("");
    $('.info-modal-upload-dokumen').attr("hidden", true);
    $('.isi-modal-upload-dokumen').attr("hidden", false);
    $('#button_upload_dokumen').attr("hidden", false);
    $('#button_upload_dokumen').attr("disabled", false);
    $('#button_upload_dokumen').removeAttr("data-loading");
    $('#uploadDokumenModal').modal('show');

  }
</script>

<!-- Tombol Open NPWP -->
<script type="text/javascript">
  function open_npwp(nip) {
    // AJAX untuk ambil data buku tabungan employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_dokumen_pribadi/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: nip,
      },
      beforeSend: function() {
        $('.judul-modal').html("File NPWP");
        $('.isi-modal').html(loading_html_text);
        $('#button_save_pin').attr("hidden", true);
        $('#editModal').appendTo("body").modal('show');

        // $('#editRekeningModal').modal('show');
        // $('.info-modal-edit-rekening').attr("hidden", false);
        // $('.isi-modal-edit-rekening').attr("hidden", true);
        // $('.info-modal-edit-rekening').html(loading_html_text);
        // $('#button_save_rekening').attr("hidden", true);
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status']['filename_npwp'] == "200") {
          var nama_file = res['data']['filename_npwp'];
          var tipe_file = nama_file.substr(-3, 3);
          var atribut = "";
          var height = '';
          var d = new Date();
          var time = d.getTime();
          nama_file = nama_file + "?" + time;

          if (tipe_file == "pdf") {
            atribut = "application/pdf";
            height = 'height="500px"';
          } else {
            atribut = "image/jpg";
          }

          var html_text = '<embed ' + height + ' class="col-md-12" type="' + atribut + '" src="' + nama_file + '"></embed>';

          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        } else {
          html_text = res['pesan']['filename_npwp'];
          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.isi-modal').html(html_text); //coba pake iframe
        $('#button_save_pin').attr("hidden", true);
      }
    });

  }
</script>

<!-- Tombol Upload NPWP -->
<script type="text/javascript">
  function upload_npwp(nip) {
    var nip = "<?php echo $employee_id; ?>";
    var jenis_dokumen = "npwp";
    var button_save = "<button onclick='save_dokumen(" + nip + ",\"" + jenis_dokumen + "\")' class='btn btn-primary'>Save NPWP</button>";
    // alert();

    var input_upload = '<fieldset class="form-group">';
    input_upload = input_upload + '<input type="file" class="form-control-file" id="file_dokumen" name="file_dokumen" accept="application/pdf, image/png, image/jpg, image/jpeg">';
    input_upload = input_upload + '<small>Jenis File: JPG, JPEG, PNG, PDF | Size MAX 5 MB</small>';
    input_upload = input_upload + '</fieldset>';

    //inisialisasi pesan
    $('#judul_modal_upload_dokumen').html("Upload NPWP");
    $('#label_upload_dokumen').html("Foto NPWP");
    $('#file_dokumen_kosong').html("SILAHKAN UPLOAD FOTO NPWP");
    $('#input_upload_dokumen').html(input_upload);
    $('#button_upload_dokumen').html(button_save);

    $("#file_dokumen").val("");
    $('#pesan_upload_dokumen').html("");
    $('.info-modal-upload-dokumen').attr("hidden", true);
    $('.isi-modal-upload-dokumen').attr("hidden", false);
    $('#button_upload_dokumen').attr("hidden", false);
    $('#button_upload_dokumen').attr("disabled", false);
    $('#button_upload_dokumen').removeAttr("data-loading");
    $('#uploadDokumenModal').modal('show');

  }
</script>

<!-- Tombol Open CV -->
<script type="text/javascript">
  function open_cv(nip) {
    // AJAX untuk ambil data buku tabungan employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_dokumen_pribadi/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: nip,
      },
      beforeSend: function() {
        $('.judul-modal').html("File NPWP");
        $('.isi-modal').html(loading_html_text);
        $('#button_save_pin').attr("hidden", true);
        $('#editModal').appendTo("body").modal('show');

        // $('#editRekeningModal').modal('show');
        // $('.info-modal-edit-rekening').attr("hidden", false);
        // $('.isi-modal-edit-rekening').attr("hidden", true);
        // $('.info-modal-edit-rekening').html(loading_html_text);
        // $('#button_save_rekening').attr("hidden", true);
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status']['filename_cv'] == "200") {
          var nama_file = res['data']['filename_cv'];
          var tipe_file = nama_file.substr(-3, 3);
          var atribut = "";
          var height = '';
          var d = new Date();
          var time = d.getTime();
          nama_file = nama_file + "?" + time;

          if (tipe_file == "pdf") {
            atribut = "application/pdf";
            height = 'height="500px"';
          } else {
            atribut = "image/jpg";
          }

          var html_text = '<embed ' + height + ' class="col-md-12" type="' + atribut + '" src="' + nama_file + '"></embed>';

          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        } else {
          html_text = res['pesan']['filename_cv'];
          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.isi-modal').html(html_text); //coba pake iframe
        $('#button_save_pin').attr("hidden", true);
      }
    });

  }
</script>

<!-- Tombol Upload CV -->
<script type="text/javascript">
  function upload_cv(nip) {
    var nip = "<?php echo $employee_id; ?>";
    var jenis_dokumen = "cv";
    var button_save = "<button onclick='save_dokumen(" + nip + ",\"" + jenis_dokumen + "\")' class='btn btn-primary'>Save CV</button>";
    // alert();

    var input_upload = '<fieldset class="form-group">';
    input_upload = input_upload + '<input type="file" class="form-control-file" id="file_dokumen" name="file_dokumen" accept="application/pdf, image/png, image/jpg, image/jpeg">';
    input_upload = input_upload + '<small>Jenis File: JPG, JPEG, PNG, PDF | Size MAX 5 MB</small>';
    input_upload = input_upload + '</fieldset>';

    //inisialisasi pesan
    $('#judul_modal_upload_dokumen').html("Upload CV");
    $('#label_upload_dokumen').html("Foto CV");
    $('#file_dokumen_kosong').html("SILAHKAN UPLOAD FOTO CV");
    $('#input_upload_dokumen').html(input_upload);
    $('#button_upload_dokumen').html(button_save);

    $("#file_dokumen").val("");
    $('#pesan_upload_dokumen').html("");
    $('.info-modal-upload-dokumen').attr("hidden", true);
    $('.isi-modal-upload-dokumen').attr("hidden", false);
    $('#button_upload_dokumen').attr("hidden", false);
    $('#button_upload_dokumen').attr("disabled", false);
    $('#button_upload_dokumen').removeAttr("data-loading");
    $('#uploadDokumenModal').modal('show');

  }
</script>

<!-- Tombol Open SKCK -->
<script type="text/javascript">
  function open_skck(nip) {
    // AJAX untuk ambil data buku tabungan employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_dokumen_pribadi/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: nip,
      },
      beforeSend: function() {
        $('.judul-modal').html("File NPWP");
        $('.isi-modal').html(loading_html_text);
        $('#button_save_pin').attr("hidden", true);
        $('#editModal').appendTo("body").modal('show');

        // $('#editRekeningModal').modal('show');
        // $('.info-modal-edit-rekening').attr("hidden", false);
        // $('.isi-modal-edit-rekening').attr("hidden", true);
        // $('.info-modal-edit-rekening').html(loading_html_text);
        // $('#button_save_rekening').attr("hidden", true);
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status']['filename_skck'] == "200") {
          var nama_file = res['data']['filename_skck'];
          var tipe_file = nama_file.substr(-3, 3);
          var atribut = "";
          var height = '';
          var d = new Date();
          var time = d.getTime();
          nama_file = nama_file + "?" + time;

          if (tipe_file == "pdf") {
            atribut = "application/pdf";
            height = 'height="500px"';
          } else {
            atribut = "image/jpg";
          }

          var html_text = '<embed ' + height + ' class="col-md-12" type="' + atribut + '" src="' + nama_file + '"></embed>';

          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        } else {
          html_text = res['pesan']['filename_skck'];
          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.isi-modal').html(html_text); //coba pake iframe
        $('#button_save_pin').attr("hidden", true);
      }
    });

  }
</script>

<!-- Tombol Upload SKCK -->
<script type="text/javascript">
  function upload_skck(nip) {
    var nip = "<?php echo $employee_id; ?>";
    var jenis_dokumen = "skck";
    var button_save = "<button onclick='save_dokumen(" + nip + ",\"" + jenis_dokumen + "\")' class='btn btn-primary'>Save SKCK</button>";
    // alert();

    var input_upload = '<fieldset class="form-group">';
    input_upload = input_upload + '<input type="file" class="form-control-file" id="file_dokumen" name="file_dokumen" accept="application/pdf, image/png, image/jpg, image/jpeg">';
    input_upload = input_upload + '<small>Jenis File: JPG, JPEG, PNG, PDF | Size MAX 5 MB</small>';
    input_upload = input_upload + '</fieldset>';

    //inisialisasi pesan
    $('#judul_modal_upload_dokumen').html("Upload SKCK");
    $('#label_upload_dokumen').html("Foto SKCK");
    $('#file_dokumen_kosong').html("SILAHKAN UPLOAD FOTO SKCK");
    $('#input_upload_dokumen').html(input_upload);
    $('#button_upload_dokumen').html(button_save);

    $("#file_dokumen").val("");
    $('#pesan_upload_dokumen').html("");
    $('.info-modal-upload-dokumen').attr("hidden", true);
    $('.isi-modal-upload-dokumen').attr("hidden", false);
    $('#button_upload_dokumen').attr("hidden", false);
    $('#button_upload_dokumen').attr("disabled", false);
    $('#button_upload_dokumen').removeAttr("data-loading");
    $('#uploadDokumenModal').modal('show');

  }
</script>

<!-- Tombol Open Ijazah -->
<script type="text/javascript">
  function open_ijazah(nip) {
    // AJAX untuk ambil data buku tabungan employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_dokumen_pribadi/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: nip,
      },
      beforeSend: function() {
        $('.judul-modal').html("File NPWP");
        $('.isi-modal').html(loading_html_text);
        $('#button_save_pin').attr("hidden", true);
        $('#editModal').appendTo("body").modal('show');

        // $('#editRekeningModal').modal('show');
        // $('.info-modal-edit-rekening').attr("hidden", false);
        // $('.isi-modal-edit-rekening').attr("hidden", true);
        // $('.info-modal-edit-rekening').html(loading_html_text);
        // $('#button_save_rekening').attr("hidden", true);
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status']['filename_isd'] == "200") {
          var nama_file = res['data']['filename_isd'];
          var tipe_file = nama_file.substr(-3, 3);
          var atribut = "";
          var height = '';
          var d = new Date();
          var time = d.getTime();
          nama_file = nama_file + "?" + time;
          var tes = nama_file.substr(-14);

          // alert(nama_file);
          // alert(tes);

          if (tipe_file == "pdf") {
            atribut = "application/pdf";
            height = 'height="500px"';
          } else {
            atribut = "image/jpg";
          }

          var html_text = '<embed ' + height + ' class="col-md-12" type="' + atribut + '" src="' + nama_file + '"></embed>';

          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        } else {
          html_text = res['pesan']['filename_isd'];
          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.isi-modal').html(html_text); //coba pake iframe
        $('#button_save_pin').attr("hidden", true);
      }
    });

  }
</script>

<!-- Tombol Upload Ijazah -->
<script type="text/javascript">
  function upload_ijazah(nip) {
    var nip = "<?php echo $employee_id; ?>";
    var jenis_dokumen = "ijazah";
    var button_save = "<button onclick='save_dokumen(" + nip + ",\"" + jenis_dokumen + "\")' class='btn btn-primary'>Save Ijazah</button>";
    // alert();

    var input_upload = '<fieldset class="form-group">';
    input_upload = input_upload + '<input type="file" class="form-control-file" id="file_dokumen" name="file_dokumen" accept="application/pdf, image/png, image/jpg, image/jpeg">';
    input_upload = input_upload + '<small>Jenis File: JPG, JPEG, PNG, PDF | Size MAX 5 MB</small>';
    input_upload = input_upload + '</fieldset>';

    //inisialisasi pesan
    $('#judul_modal_upload_dokumen').html("Upload Ijazah");
    $('#label_upload_dokumen').html("Foto Ijazah");
    $('#file_dokumen_kosong').html("SILAHKAN UPLOAD FOTO IJAZAH");
    $('#input_upload_dokumen').html(input_upload);
    $('#button_upload_dokumen').html(button_save);

    $("#file_dokumen").val("");
    $('#pesan_upload_dokumen').html("");
    $('.info-modal-upload-dokumen').attr("hidden", true);
    $('.isi-modal-upload-dokumen').attr("hidden", false);
    $('#button_upload_dokumen').attr("hidden", false);
    $('#button_upload_dokumen').attr("disabled", false);
    $('#button_upload_dokumen').removeAttr("data-loading");
    $('#uploadDokumenModal').modal('show');

  }
</script>

<!-- Tombol Open Foto Profile -->
<script type="text/javascript">
  function open_foto_profil(nip) {
    // AJAX untuk ambil data buku tabungan employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_dokumen_pribadi/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: nip,
      },
      beforeSend: function() {
        $('.judul-modal').html("Foto Profil");
        $('.isi-modal').html(loading_html_text);
        $('#button_save_pin').attr("hidden", true);
        $('#editModal').appendTo("body").modal('show');
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status']['profile_picture'] == "200") {
          var nama_file = "";
          nama_file = res['data']['profile_picture'];
          var tipe_file = nama_file.substr(-3, 3);
          var atribut = "";
          var height = '';
          var d = new Date();
          var time = d.getTime();
          nama_file = nama_file + "?" + time;

          if (tipe_file == "pdf") {
            atribut = "application/pdf";
            height = 'height="500px"';
          } else {
            atribut = "image/jpg";
          }

          var html_text = '<embed ' + height + ' class="col-md-12" type="' + atribut + '" src="' + nama_file + '"></embed>';

          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        } else {
          html_text = res['pesan']['profile_picture'];
          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.isi-modal').html(html_text); //coba pake iframe
        $('#button_save_pin').attr("hidden", true);
      }
    });

  }
</script>

<!-- Tombol Lihat E-Slip -->
<script type="text/javascript">
  function lihat_eslip(secid, nip) {
    //testing
    // alert(secid);
    // alert(nip);

    var link_eslip = '<?= base_url() ?>admin/Importexceleslip/eslip_final/' + nip + '/' + secid;
    var html_text = "<iframe src='" + link_eslip + "' style='zoom:1' frameborder='0' height='500' width='100%'></iframe>"

    $('.judul-modal').html("Download E-Slip");
    $('.isi-modal').html(html_text);
    $('#button_save_pin').attr("hidden", true);
    $('#editModal').appendTo("body").modal('show');

  }
</script>

<!-- Tombol Lihat SK -->
<script type="text/javascript">
  function lihat_sk(secid, nip) {
    //testing
    // alert(secid);
    // alert(nip);

    var link_eslip = '<?= base_url() ?>admin/skk/view/' + secid + '/' + nip;
    var html_text = "<iframe src='" + link_eslip + "' style='zoom:1' frameborder='0' height='500' width='100%'></iframe>"

    $('.judul-modal').html("Lihat SK");
    $('.isi-modal').html(html_text);
    $('#button_save_pin').attr("hidden", true);
    $('#editModal').appendTo("body").modal('show');

  }
</script>

<!-- Tombol Lihat Kontrak -->
<script type="text/javascript">
  function open_kontrak(uniqueid, sub_project) {
    //testing
    // alert(uniqueid);
    // alert(sub_project);

    var link_eslip = '<?= base_url() ?>admin/pkwt' + sub_project + '/view/' + uniqueid;
    var html_text = "<iframe src='" + link_eslip + "' style='zoom:1' frameborder='0' height='500' width='100%'></iframe>"

    $('.judul-modal').html("Lihat Draft Kontrak");
    $('.isi-modal').html(html_text);
    $('#button_save_pin').attr("hidden", true);
    $('#editModal').appendTo("body").modal('show');

  }
</script>

<!-- Tombol Lihat Addendum -->
<script type="text/javascript">
  function open_addendum(id) {
    //testing
    // alert(id);

    var link_eslip = '<?= base_url() ?>admin/addendum/cetak/' + id;
    var html_text = "<iframe src='" + link_eslip + "' style='zoom:1' frameborder='0' height='500' width='100%'></iframe>"

    $('.judul-modal').html("Lihat Draft Addendum");
    $('.isi-modal').html(html_text);
    $('#button_save_pin').attr("hidden", true);
    $('#editModal').appendTo("body").modal('show');

  }
</script>

<!-- Tombol Update BPJS KS -->
<script type="text/javascript">
  function update_bpjs(nip) {
    var nip = "<?php echo $employee_id; ?>";

    //inisialisasi pesan
    $('#pesan_no_bpjs_ks_modal').html("");
    $('#pesan_no_bpjs_tk_modal').html("");

    // AJAX untuk ambil data employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_bpjs/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: nip,
      },
      beforeSend: function() {
        $('.info-modal-edit-bpjs').attr("hidden", false);
        $('.isi-modal-edit-bpjs').attr("hidden", true);
        $('.info-modal-edit-bpjs').html(loading_html_text);
        $('#button_save_bpjs').attr("hidden", true);
        $('#editBPJSModal').modal('show');
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          $('#no_bpjs_ks_modal').val(res['data']['bpjs_ks_no']);
          $("#no_bpjs_tk_modal").val(res['data']['bpjs_tk_no']);

          $('.isi-modal-edit-bpjs').attr("hidden", false);
          $('.info-modal-edit-bpjs').attr("hidden", true);
          $('#button_save_bpjs').attr("hidden", false);
        } else {
          html_text = res['pesan'];
          $('.info-modal-edit-bpjs').html(html_text);
          $('.isi-modal-edit-bpjs').attr("hidden", true);
          $('.info-modal-edit-bpjs').attr("hidden", false);
          $('#button_save_bpjs').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-edit-bpjs').html(html_text); //coba pake iframe
        $('.isi-modal-edit-bpjs').attr("hidden", true);
        $('.info-modal-edit-bpjs').attr("hidden", false);
        $('#button_save_bpjs').attr("hidden", true);
      }
    });

  }
</script>

<!-- Tombol Save Data BPJS -->
<script type="text/javascript">
  document.getElementById("button_save_bpjs").onclick = function(e) {
    var nip = "<?php echo $employee_id; ?>";
    var no_bpjs_ks = $("#no_bpjs_ks_modal").val();
    var no_bpjs_tk = $("#no_bpjs_tk_modal").val();

    //inisialisasi pesan
    $('#pesan_no_bpjs_ks_modal').html("");
    $('#pesan_no_bpjs_tk_modal').html("");

    // AJAX untuk ambil data employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/save_data_bpjs/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: nip,
        no_bpjs_ks: no_bpjs_ks,
        no_bpjs_tk: no_bpjs_tk,
      },
      beforeSend: function() {
        $('.info-modal-edit-bpjs').attr("hidden", false);
        $('.isi-modal-edit-bpjs').attr("hidden", true);
        $('.info-modal-edit-bpjs').html(uploading_html_text);
        $('#button_save_bpjs').attr("hidden", true);
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          $('#dokumen_bpjs_ks_tabel').html(res['data']['bpjs_ks_no']);
          $("#dokumen_bpjs_tk_tabel").html(res['data']['bpjs_tk_no']);

          $('.info-modal-edit-bpjs').html(success_html_text);
          $('.isi-modal-edit-bpjs').attr("hidden", true);
          $('.info-modal-edit-bpjs').attr("hidden", false);
          $('#button_save_bpjs').attr("hidden", true);
        } else {
          html_text = res['pesan'];
          $('.info-modal-edit-bpjs').html(html_text);
          $('.isi-modal-edit-bpjs').attr("hidden", true);
          $('.info-modal-edit-bpjs').attr("hidden", false);
          $('#button_save_bpjs').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-edit-bpjs').html(html_text); //coba pake iframe
        $('.isi-modal-edit-bpjs').attr("hidden", true);
        $('.info-modal-edit-bpjs').attr("hidden", false);
        $('#button_save_bpjs').attr("hidden", true);
      }
    });

  };
</script>

<!-- Tombol Verifikasi Data NIK -->
<script type="text/javascript">
  document.getElementById("button_verify_nik_modal").onclick = function(e) {
    e.preventDefault();
    // alert("masuk verify nik");

    var nik = $("#nik_modal").val();
    var employee_id = "<?php echo $employee_id; ?>";
    var nik_lama = "<?php echo $ktp_no; ?>";
    var id_employee = "<?php echo $verification_id; ?>";
    var nama_kolom = "nik";
    var status = "1";

    if ((id_employee == null) || (id_employee == "")) {
      id_employee = "e_" + "<?php echo $user[0]->user_id; ?>";
    }

    // alert(id_employee);

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/valiadsi_employee_existing/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        employee_id: employee_id,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: nik_lama,
        nilai_sesudah: nik,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        var res = jQuery.parseJSON(response);

        if ((res['filename_ktp'] == null) || (res['filename_ktp'] == "") || (res['filename_ktp'] == "0")) {
          var tombol_ktp_tabel = '-tidak ada data- <button onclick="upload_ktp(' + employee_id + ')" class="btn btn-sm btn-outline-primary ladda-button ml-1" data-style="expand-right">Upload KTP</button>';
        } else {
          var tombol_ktp_tabel = '<button onclick="open_ktp(' + employee_id + ')" class="btn btn-sm btn-outline-primary ladda-button ml-0" data-style="expand-right">Open KTP</button>';
        }

        $('#dokumen_ktp_tabel').html(tombol_ktp_tabel);

        ktp_no_modal.setAttribute("readonly", "readonly");
        nik_modal.setAttribute("readonly", "readonly");

        document.getElementById("ktp_no_modal").value = nik;
        $('#nomor_ktp_tabel').html(nik);

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
    var employee_id = "<?php echo $employee_id; ?>";
    var nik_lama = "<?php echo $ktp_no; ?>";
    var id_employee = "<?php echo $verification_id; ?>";
    var nama_kolom = "nik";
    var status = "0";

    if ((id_employee == null) || (id_employee == "")) {
      id_employee = "e_" + "<?php echo $user[0]->user_id; ?>";
    }

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/valiadsi_employee_existing/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        employee_id: employee_id,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: nik_lama,
        nilai_sesudah: nik,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        var res = jQuery.parseJSON(response);

        var tes_role = <?php if (in_array('1008', $role_resources_ids)) {
                          echo "1";
                        } else {
                          echo "0";
                        }; ?>

        if (tes_role == "1") {
          var tombol_upload_ktp_tabel = '<button onclick="upload_ktp(' + employee_id + ')" class="btn btn-sm btn-outline-primary ladda-button ml-1" data-style="expand-right">Upload KTP</button>';
        } else {
          var tombol_upload_ktp_tabel = '';
        }

        if ((res['filename_ktp'] == null) || (res['filename_ktp'] == "") || (res['filename_ktp'] == "0")) {
          var tombol_ktp_tabel = '-tidak ada data- <button onclick="upload_ktp(' + employee_id + ')" class="btn btn-sm btn-outline-primary ladda-button ml-1" data-style="expand-right">Upload KTP</button>';
        } else {
          var tombol_ktp_tabel = '<button onclick="open_ktp(' + employee_id + ')" class="btn btn-sm btn-outline-primary ladda-button ml-0" data-style="expand-right">Open KTP</button>' + tombol_upload_ktp_tabel;
        }

        $('#dokumen_ktp_tabel').html(tombol_ktp_tabel);

        document.getElementById("ktp_no_modal").removeAttribute("readonly");
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
    var employee_id = "<?php echo $employee_id; ?>";
    var kk_lama = "<?php echo $kk_no; ?>";
    var id_employee = "<?php echo $verification_id; ?>";
    var nama_kolom = "kk";
    var status = "1";

    if ((id_employee == null) || (id_employee == "")) {
      id_employee = "e_" + "<?php echo $user[0]->user_id; ?>";
    }

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/valiadsi_employee_existing/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        employee_id: employee_id,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: kk_lama,
        nilai_sesudah: kk,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        var res = jQuery.parseJSON(response);

        if ((res['filename_kk'] == null) || (res['filename_kk'] == "") || (res['filename_kk'] == "0")) {
          var tombol_kk_tabel = '-tidak ada data- <button onclick="upload_kk(' + employee_id + ')" class="btn btn-sm btn-outline-primary ladda-button ml-1" data-style="expand-right">Upload KK</button>';
        } else {
          var tombol_kk_tabel = '<button onclick="open_kk(' + employee_id + ')" class="btn btn-sm btn-outline-primary ladda-button ml-0" data-style="expand-right">Open KK</button>';
        }

        $('#dokumen_kk_tabel').html(tombol_kk_tabel);

        kk_no_modal.setAttribute("readonly", "readonly");
        kk_modal.setAttribute("readonly", "readonly");

        document.getElementById("kk_no_modal").value = kk;
        $('#nomor_kk_tabel').html(kk);

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
    var employee_id = "<?php echo $employee_id; ?>";
    var kk_lama = "<?php echo $kk_no; ?>";
    var id_employee = "<?php echo $verification_id; ?>";
    var nama_kolom = "kk";
    var status = "0";

    if ((id_employee == null) || (id_employee == "")) {
      id_employee = "e_" + "<?php echo $user[0]->user_id; ?>";
    }

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/valiadsi_employee_existing/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        employee_id: employee_id,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: kk_lama,
        nilai_sesudah: kk,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        var res = jQuery.parseJSON(response);

        var tes_role = <?php if (in_array('1008', $role_resources_ids)) {
                          echo "1";
                        } else {
                          echo "0";
                        }; ?>

        if (tes_role == "1") {
          var tombol_upload_kk_tabel = '<button onclick="upload_kk(' + employee_id + ')" class="btn btn-sm btn-outline-primary ladda-button ml-1" data-style="expand-right">Upload KTP</button>';
        } else {
          var tombol_upload_kk_tabel = '';
        }

        if ((res['filename_kk'] == null) || (res['filename_kk'] == "") || (res['filename_kk'] == "0")) {
          var tombol_kk_tabel = '-tidak ada data- <button onclick="upload_kk(' + employee_id + ')" class="btn btn-sm btn-outline-primary ladda-button ml-1" data-style="expand-right">Upload KK</button>';
        } else {
          var tombol_kk_tabel = '<button onclick="open_kk(' + employee_id + ')" class="btn btn-sm btn-outline-primary ladda-button ml-0" data-style="expand-right">Open KK</button>' + tombol_upload_kk_tabel;
        }

        $('#dokumen_kk_tabel').html(tombol_kk_tabel);

        document.getElementById("kk_no_modal").removeAttribute("readonly");
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
    var employee_id = "<?php echo $employee_id; ?>";
    var nama_lama = "<?php echo $first_name; ?>";
    var id_employee = "<?php echo $verification_id; ?>";
    var nama_kolom = "nama";
    var status = "1";

    if ((id_employee == null) || (id_employee == "")) {
      id_employee = "e_" + "<?php echo $user[0]->user_id; ?>";
    }

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/valiadsi_employee_existing/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        employee_id: employee_id,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: nama_lama,
        nilai_sesudah: nama,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        first_name_modal.setAttribute("readonly", "readonly");
        nama_modal.setAttribute("readonly", "readonly");

        document.getElementById("first_name_modal").value = nama;
        $('#nama_lengkap_card').html(nama);
        $('#nama_lengkap_tabel').html(nama);

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
    var employee_id = "<?php echo $employee_id; ?>";
    var nama_lama = "<?php echo $first_name; ?>";
    var id_employee = "<?php echo $verification_id; ?>";
    var nama_kolom = "nama";
    var status = "0";

    if ((id_employee == null) || (id_employee == "")) {
      id_employee = "e_" + "<?php echo $user[0]->user_id; ?>";
    }

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/valiadsi_employee_existing/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        employee_id: employee_id,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: nama_lama,
        nilai_sesudah: nama,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        document.getElementById("first_name_modal").removeAttribute("readonly");
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
    var bank_name = $("#bank_modal option:selected").text();
    var employee_id = "<?php echo $employee_id; ?>";
    var bank_lama = "<?php echo $id_bank; ?>";
    var id_employee = "<?php echo $verification_id; ?>";
    var nama_kolom = "bank";
    var status = "1";

    if ((id_employee == null) || (id_employee == "")) {
      id_employee = "e_" + "<?php echo $user[0]->user_id; ?>";
    }

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/valiadsi_employee_existing/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        employee_id: employee_id,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: bank_lama,
        nilai_sesudah: bank,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        $("#nama_bank2").val(bank).change();
        document.getElementById("nama_bank").value = bank;

        bank_modal.setAttribute("disabled", "disabled");
        nama_bank2.setAttribute("disabled", "disabled");
        $('#nama_bank_tabel').html(bank_name);

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
    var employee_id = "<?php echo $employee_id; ?>";
    var bank_lama = "<?php echo $id_bank; ?>";
    var id_employee = "<?php echo $verification_id; ?>";
    var nama_kolom = "bank";
    var status = "0";

    if ((id_employee == null) || (id_employee == "")) {
      id_employee = "e_" + "<?php echo $user[0]->user_id; ?>";
    }

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/valiadsi_employee_existing/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        employee_id: employee_id,
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
        document.getElementById("nama_bank2").removeAttribute("disabled");

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
    var employee_id = "<?php echo $employee_id; ?>";
    var norek_lama = "<?php echo $nomor_rek; ?>";
    var id_employee = "<?php echo $verification_id; ?>";
    var nama_kolom = "norek";
    var status = "1";

    if ((id_employee == null) || (id_employee == "")) {
      id_employee = "e_" + "<?php echo $user[0]->user_id; ?>";
    }

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/valiadsi_employee_existing/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        employee_id: employee_id,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: norek_lama,
        nilai_sesudah: norek,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        nomor_rekening.setAttribute("readonly", "readonly");
        rekening_modal.setAttribute("readonly", "readonly");
        $('#button_open_upload_buku_tabungan').attr("hidden", true);

        document.getElementById("nomor_rekening").value = norek;
        $('#nomor_rekening_table').html(norek);

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
    var employee_id = "<?php echo $employee_id; ?>";
    var norek_lama = "<?php echo $nomor_rek; ?>";
    var id_employee = "<?php echo $verification_id; ?>";
    var nama_kolom = "norek";
    var status = "0";

    if ((id_employee == null) || (id_employee == "")) {
      id_employee = "e_" + "<?php echo $user[0]->user_id; ?>";
    }

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/valiadsi_employee_existing/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        employee_id: employee_id,
        id_employee_request: id_employee,
        kolom: nama_kolom,
        nilai_sebelum: norek_lama,
        nilai_sesudah: norek,
        status: status,
        verified_by: user_name,
        verified_by_id: user_id,
      },
      success: function(response) {
        document.getElementById("nomor_rekening").removeAttribute("readonly");
        document.getElementById("rekening_modal").removeAttribute("readonly");
        $('#button_open_upload_buku_tabungan').attr("hidden", false);

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
    var employee_id = "<?php echo $employee_id; ?>";
    var pemilik_rek_lama = "<?php echo $pemilik_rek; ?>";
    var id_employee = "<?php echo $verification_id; ?>";
    var nama_kolom = "pemilik_rekening";
    var status = "1";

    if ((id_employee == null) || (id_employee == "")) {
      id_employee = "e_" + "<?php echo $user[0]->user_id; ?>";
    }

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/valiadsi_employee_existing/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        employee_id: employee_id,
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
        $('#pemilik_rekening_tabel').html(pemilik_rek);

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
    var employee_id = "<?php echo $employee_id; ?>";
    var pemilik_rek_lama = "<?php echo $pemilik_rek; ?>";
    var id_employee = "<?php echo $verification_id; ?>";
    var nama_kolom = "pemilik_rekening";
    var status = "0";

    if ((id_employee == null) || (id_employee == "")) {
      id_employee = "e_" + "<?php echo $user[0]->user_id; ?>";
    }

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/valiadsi_employee_existing/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        employee_id: employee_id,
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

<!-- Tombol resign -->
<script type="text/javascript">
  document.getElementById("button_resign").onclick = function(e) {
    var nip = "<?php echo $employee_id; ?>";
    var nip_session = "<?php echo $user[0]->employee_id; ?>";

    //inisialisasi pesan
    $('#pesan_kategori_modal').html("");
    $('#pesan_tanggal_resign_modal2').html("");
    $('#pesan_keterangan_resign_modal2').html("");

    // AJAX untuk ambil data employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_diri/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: nip,
      },
      beforeSend: function() {
        $('.info-modal-edit-resign').attr("hidden", false);
        $('.isi-modal-edit-resign').attr("hidden", true);
        $('#editResignModalLabel').html("Status Karyawan");
        $('.info-modal-edit-resign').html(loading_html_text);
        $('#button_save_resign').attr("hidden", true);
        $('#editResignModal').modal('show');
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          $('#nip_modal2').html(res['data']['employee_id']);
          $("#nama_modal2").html(res['data']['first_name']);
          $('#status_aktif_modal2').html(res['data']['status_resign_name']);
          $('#non_aktif_by_modal2').html(res['data']['deactive_by_name']);
          $("#non_aktif_on_modal2").html(res['data']['deactive_date_text']);
          $("#non_aktif_pesan_modal2").html(res['data']['deactive_reason']);
          $("#kategori_modal").val(res['data']['status_resign']).change();
          $('#tanggal_resign_modal2').val(res['data']['deactive_date_seed']);
          $('#keterangan_resign_modal2').val(res['data']['deactive_reason']);

          if (res['data']['employee_id'] == nip_session) {
            $('#editResignModalLabel').html("Informasi Status Karyawan");
            $("#isi_non_aktif_by_modal3").attr("hidden", true);
            $("#isi_non_aktif_date_modal3").attr("hidden", true);
            $("#isi_keterangan_aktif_modal3").attr("hidden", true);
            $("#isi_status_aktif_modal2").attr("hidden", true);
            $('#isi_tanggal_aktif_modal2').attr("hidden", true);
            $('#isi_keterangan_aktif_modal2').attr("hidden", true);
            $('#button_save_resign').attr("hidden", true);
          } else {
            $('#editResignModalLabel').html("Edit Status Karyawan");
            $('#button_save_resign').attr("hidden", false);
          }

          $('.isi-modal-edit-resign').attr("hidden", false);
          $('.info-modal-edit-resign').attr("hidden", true);

        } else {
          html_text = res['pesan'];
          $('.info-modal-edit-resign').html(html_text);
          $('.isi-modal-edit-resign').attr("hidden", true);
          $('.info-modal-edit-resign').attr("hidden", false);
          $('#button_save_resign').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-edit-resign').html(html_text); //coba pake iframe
        $('.isi-modal-edit-resign').attr("hidden", true);
        $('.info-modal-edit-resign').attr("hidden", false);
        $('#button_save_resign').attr("hidden", true);
      }
    });

  };
</script>

<!-- Tombol Save Data Resign -->
<script type="text/javascript">
  document.getElementById("button_save_resign").onclick = function(e) {
    var nip = "<?php echo $employee_id; ?>";
    var status_resign = $("#kategori_resign_modal").val();
    var date_resign_request = $("#tanggal_resign_modal2").val();
    var deactive_reason = $("#keterangan_resign_modal2").val();

    //inisialisasi pesan
    $('#pesan_kategori_resign_modal').html("");
    $('#pesan_tanggal_resign_modal2').html("");
    $('#pesan_keterangan_resign_modal2').html("");

    //-------cek apakah ada yang tidak diisi-------
    var pesan_kategori_resign_modal = "";
    var pesan_tanggal_resign_modal2 = "";
    var pesan_keterangan_resign_modal2 = "";
    if (status_resign == "") {
      pesan_kategori_resign_modal = "<small style='color:#FF0000;'>Status Aktif tidak boleh kosong</small>";
      $('#kategori_resign_modal').focus();
    }
    if (date_resign_request == "") {
      pesan_tanggal_resign_modal2 = "<small style='color:#FF0000;'>Tanggal Resign tidak boleh kosong</small>";
      $('#tanggal_resign_modal2').focus();
    }
    if (deactive_reason == "") {
      pesan_keterangan_resign_modal2 = "<small style='color:#FF0000;'>Keterangan Resign tidak boleh kosong</small>";
      $('#keterangan_resign_modal2').focus();
    }
    $('#pesan_kategori_resign_modal').html(pesan_kategori_resign_modal);
    $('#pesan_tanggal_resign_modal2').html(pesan_tanggal_resign_modal2);
    $('#pesan_keterangan_resign_modal2').html(pesan_keterangan_resign_modal2);

    //-------action-------
    if ((pesan_kategori_resign_modal != "") || (pesan_tanggal_resign_modal2 != "") || (pesan_keterangan_resign_modal2 != "")) { //kalau ada input kosong 
      alert("Tidak boleh ada input kosong");
    } else { //kalau semua terisi
      // AJAX untuk save data resign terupdate
      $.ajax({
        url: '<?= base_url() ?>admin/Employees/save_data_resign/',
        method: 'post',
        data: {
          [csrfName]: csrfHash,
          nip: nip,
          status_resign: status_resign,
          date_resign_request: date_resign_request,
          deactive_reason: deactive_reason,
        },
        beforeSend: function() {
          $('.info-modal-edit-resign').attr("hidden", false);
          $('.isi-modal-edit-resign').attr("hidden", true);
          $('.info-modal-edit-resign').html(loading_html_text);
          $('#button_save_resign').attr("hidden", true);
        },
        success: function(response) {

          var res = jQuery.parseJSON(response);

          if (res['status'] == "200") {
            //301088
            $('#button_resign').html(res['button_resign']);

            $('.info-modal-edit-resign').html(success_html_text);
            $('.isi-modal-edit-resign').attr("hidden", true);
            $('.info-modal-edit-resign').attr("hidden", false);
            $('#button_save_resign').attr("hidden", true);
          } else {
            html_text = res['pesan'];
            $('.info-modal-edit-resign').html(html_text);
            $('.isi-modal-edit-resign').attr("hidden", true);
            $('.info-modal-edit-resign').attr("hidden", false);
            $('#button_save_resign').attr("hidden", true);
          }
        },
        error: function(xhr, status, error) {
          html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
          html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
          // html_text = "Gagal fetch data. Kode error: " + xhr.status;
          $('.info-modal-edit-resign').html(html_text); //coba pake iframe
          $('.isi-modal-edit-resign').attr("hidden", true);
          $('.info-modal-edit-resign').attr("hidden", false);
          $('#button_save_resign').attr("hidden", true);
        }
      });
    }

  };
</script>

<!-- Tombol Upload Kontrak -->
<script type="text/javascript">
  function upload_kontrak(uniqueid) {
    var jenis_dokumen = "kontrak";
    var button_save = "<button onclick='save_kontrak(\"" + uniqueid + "\",\"" + jenis_dokumen + "\")' class='btn btn-primary'>Upload Kontrak</button>";
    // alert(uniqueid);

    var input_upload = '<fieldset class="form-group">';
    input_upload = input_upload + '<input type="file" class="form-control-file" id="file_dokumen" name="file_dokumen" accept="application/pdf">';
    input_upload = input_upload + '<small>Jenis File: PDF | Size MAX 5 MB</small>';
    input_upload = input_upload + '</fieldset>';

    //inisialisasi pesan
    $('#judul_modal_upload_dokumen').html("Upload Kontrak");
    $('#label_upload_dokumen').html("Dokumen Kontrak");
    $('#file_dokumen_kosong').html("SILAHKAN UPLOAD DOKUMEN KONTRAK YANG SUDAH DITANDATANGANI");
    $('#input_upload_dokumen').html(input_upload);
    $('#button_upload_dokumen').html(button_save);

    $("#file_dokumen").val("");
    $('#pesan_upload_dokumen').html("");
    $('.info-modal-upload-dokumen').attr("hidden", true);
    $('.isi-modal-upload-dokumen').attr("hidden", false);
    $('#button_upload_dokumen').attr("hidden", false);
    $('#button_upload_dokumen').attr("disabled", false);
    $('#button_upload_dokumen').removeAttr("data-loading");
    $('#uploadDokumenModal').modal('show');

  }
</script>

<!-- Tombol Upload Addendum -->
<script type="text/javascript">
  function upload_addendum(id) {
    var jenis_dokumen = "addendum";
    var button_save = "<button onclick='save_kontrak(" + id + ",\"" + jenis_dokumen + "\")' class='btn btn-primary'>Upload Kontrak</button>";
    // alert(id);

    var input_upload = '<fieldset class="form-group">';
    input_upload = input_upload + '<input type="file" class="form-control-file" id="file_dokumen" name="file_dokumen" accept="application/pdf">';
    input_upload = input_upload + '<small>Jenis File: PDF | Size MAX 5 MB</small>';
    input_upload = input_upload + '</fieldset>';

    //inisialisasi pesan
    $('#judul_modal_upload_dokumen').html("Upload Kontrak");
    $('#label_upload_dokumen').html("Dokumen Kontrak");
    $('#file_dokumen_kosong').html("SILAHKAN UPLOAD DOKUMEN KONTRAK YANG SUDAH DITANDATANGANI");
    $('#input_upload_dokumen').html(input_upload);
    $('#button_upload_dokumen').html(button_save);

    $("#file_dokumen").val("");
    $('#pesan_upload_dokumen').html("");
    $('.info-modal-upload-dokumen').attr("hidden", true);
    $('.isi-modal-upload-dokumen').attr("hidden", false);
    $('#button_upload_dokumen').attr("hidden", false);
    $('#button_upload_dokumen').attr("disabled", false);
    $('#button_upload_dokumen').removeAttr("data-loading");
    $('#uploadDokumenModal').modal('show');

  }
</script>

<!-- Tombol Save Kontrak -->
<script type="text/javascript">
  function save_kontrak(id, jenis_dokumen) {
    var nip = "<?php echo $employee_id; ?>";
    var form = document.getElementById('dokumen_form');
    var formData = new FormData(form);
    formData.append('nip', nip);
    formData.append('id', id);
    formData.append('jenis_dokumen', jenis_dokumen);

    $('#pesan_upload_dokumen').html("");

    //-------testing-------
    // alert("masuk button save");
    // alert('Server Time: '+ getServerTime());
    // alert('Locale Time: '+ new Date(getServerTime()));

    //cek isi form data
    // var html_text_formdata = "";
    // for (var pair of formData.entries()) { // Display the key/value pairs
    //   html_text_formdata = html_text_formdata + pair[0] + ', ' + pair[1] + '\n';
    // }
    // alert(html_text_formdata);

    //-------action-------
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/save_kontrak_ttd/',
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: function() {
        // $('#editRekeningModal').modal('show');
        $('.info-modal-upload-dokumen').attr("hidden", false);
        $('.isi-modal-upload-dokumen').attr("hidden", true);
        $('.info-modal-upload-dokumen').html(uploading_html_text);
        $('#button_upload_dokumen').attr("hidden", true);
      },
      success: function(response) {
        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") { //sukses upload file
          $('.info-modal-upload-dokumen').html(success_html_text);
          $('.info-modal-upload-dokumen').attr("hidden", false);
          $('.isi-modal-upload-dokumen').attr("hidden", true);
          $('#button_upload_dokumen').attr("hidden", true);
          $('#button_upload_dokumen').attr("disabled", false);
          $('#button_upload_dokumen').removeAttr("data-loading");
        } else if (res['status'] == "201") { //upload file error
          $('#pesan_upload_dokumen').html("<small style='color:#FF0000;'>" + res['pesan_error'] + "</small>");
          $("#file_dokumen").val("");
          $('.info-modal-upload-dokumen').attr("hidden", true);
          $('.isi-modal-upload-dokumen').attr("hidden", false);
          $('#button_upload_dokumen').attr("hidden", false);
          $('#button_upload_dokumen').attr("disabled", false);
          $('#button_upload_dokumen').removeAttr("data-loading");
        } else { //another error (unspecified)
          $('#pesan_upload_dokumen').html("<small style='color:#FF0000;'>" + res['pesan_error'] + "</small>");
          $('.info-modal-upload-dokumen').attr("hidden", true);
          $('.isi-modal-upload-dokumen').attr("hidden", false);
          $('#button_upload_dokumen').attr("hidden", false);
          $('#button_upload_dokumen').attr("disabled", false);
          $('#button_upload_dokumen').removeAttr("data-loading");
        }

        // alert('Your form has been sent successfully.');
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-upload-dokumen').html(html_text); //coba pake iframe
        $('.isi-modal-upload-dokumen').attr("hidden", true);
        $('.info-modal-upload-dokumen').attr("hidden", false);
        $('#button_upload_dokumen').attr("hidden", true);
        $('#button_upload_dokumen').attr("disabled", false);
        $('#button_upload_dokumen').removeAttr("data-loading");
      }
    });

  }
</script>

<!-- Tombol Open Kontrak -->
<script type="text/javascript">
  function lihat_kontrak(uniqueid) {
    // alert(uniqueid);
    // AJAX untuk ambil data kontrak employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_dokumen_kontrak/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        uniqueid: uniqueid,
      },
      beforeSend: function() {
        $('.judul-modal').html("File Kontrak");
        $('.isi-modal').html(loading_html_text);
        $('#button_save_pin').attr("hidden", true);
        $('#editModal').appendTo("body").modal('show');
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          var nama_file = res['data'];
          var tipe_file = nama_file.substr(-3, 3);
          var atribut = "";
          var height = '';
          var d = new Date();
          var time = d.getTime();
          nama_file = nama_file + "?" + time;
          var tes = nama_file.substr(-14);

          // alert(nama_file);
          // alert(tes);

          if (tipe_file == "pdf") {
            atribut = "application/pdf";
            height = 'height="500px"';
          } else {
            atribut = "image/jpg";
          }

          var html_text = "";
          html_text = html_text + '<embed ' + height + ' class="col-md-12" type="' + atribut + '" src="' + nama_file + '"></embed>';

          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        } else {
          html_text = res['pesan'];
          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.isi-modal').html(html_text); //coba pake iframe
        $('#button_save_pin').attr("hidden", true);
      }
    });

  }
</script>

<!-- Tombol Open Addendum -->
<script type="text/javascript">
  function lihat_addendum(id) {
    // AJAX untuk ambil data addendum employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_dokumen_addendum/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id: id,
      },
      beforeSend: function() {
        $('.judul-modal').html("File Kontrak");
        $('.isi-modal').html(loading_html_text);
        $('#button_save_pin').attr("hidden", true);
        $('#editModal').appendTo("body").modal('show');
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          var nama_file = res['data'];
          var tipe_file = nama_file.substr(-3, 3);
          var atribut = "";
          var height = '';
          var d = new Date();
          var time = d.getTime();
          nama_file = nama_file + "?" + time;
          var tes = nama_file.substr(-14);

          // alert(nama_file);
          // alert(tes);

          if (tipe_file == "pdf") {
            atribut = "application/pdf";
            height = 'height="500px"';
          } else {
            atribut = "image/jpg";
          }

          var html_text = '<embed ' + height + ' class="col-md-12" type="' + atribut + '" src="' + nama_file + '"></embed>';

          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        } else {
          html_text = res['pesan'];
          $('.isi-modal').html(html_text);
          $('#button_save_pin').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.isi-modal').html(html_text); //coba pake iframe
        $('#button_save_pin').attr("hidden", true);
      }
    });

  }
</script>

<!-- Tombol Hapus Kontrak -->
<script type="text/javascript">
  function hapus_kontrak(uniqueid) {
    var nip = "<?php echo $employee_id; ?>";
    var jenis_dokumen = "kontrak";
    var button_delete = "<button onclick='hapus_detail_kontrak(\"" + uniqueid + "\",\"" + jenis_dokumen + "\")' class='btn btn-danger'>Hapus Kontrak</button>";

    // AJAX untuk ambil data employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_detail_kontrak/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        uniqueid: uniqueid,
      },
      beforeSend: function() {
        $('.info-modal-hapus-kontrak').attr("hidden", false);
        $('.isi-modal-hapus-kontrak').attr("hidden", true);
        $('.info-modal-hapus-kontrak').html(loading_html_text);
        $('#button_delete_kontrak').html(button_delete);
        $('#button_delete_kontrak').attr("hidden", true);
        $('#hapusKontrakModal').modal('show');
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          $('#jenis_kontrak_modal2').html(res['data']['jenis_dokumen']);
          $("#nomor_dokumen_modal2").html(res['data']['nomor_surat']);
          $('#periode_kontrak_modal2').html(res['data']['periode_start'] + " s/d " + res['data']['periode_end']);
          $('#tgl_terbit_kontrak_modal2').html(res['data']['tanggal_terbit']);
          $("#project_kontrak_modal2").html(res['data']['project']);
          $("#sub_project_kontrak_modal2").html(res['data']['sub_project']);
          $("#jabatan_kontrak_modal2").html(res['data']['jabatan']);

          $('.isi-modal-hapus-kontrak').attr("hidden", false);
          $('.info-modal-hapus-kontrak').attr("hidden", true);
          $('#button_delete_kontrak').attr("hidden", false);
        } else {
          html_text = res['pesan'];
          $('.info-modal-hapus-kontrak').html(html_text);
          $('.isi-modal-hapus-kontrak').attr("hidden", true);
          $('.info-modal-hapus-kontrak').attr("hidden", false);
          $('#button_delete_kontrak').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-hapus-kontrak').html(html_text); //coba pake iframe
        $('.isi-modal-hapus-kontrak').attr("hidden", true);
        $('.info-modal-hapus-kontrak').attr("hidden", false);
        $('#button_delete_kontrak').attr("hidden", true);
      }
    });

  };
</script>

<!-- Tombol Edit Kontrak -->
<script type="text/javascript">
  function edit_kontrak(id) {
    window.open("<?= base_url() ?>admin/employee_pkwt_cancel/pkwt_edit/" + id, "_blank");
  };
</script>

<!-- Tombol Add Addendum -->
<script type="text/javascript">
  function add_addendum_kontrak(id) {
    window.open("<?= base_url() ?>admin/addendum/view/" + id, "_blank");
  };
</script>

<!-- Tombol Hapus Addendum -->
<script type="text/javascript">
  function hapus_addendum(id) {
    var nip = "<?php echo $employee_id; ?>";
    var jenis_dokumen = "addendum";
    var button_delete = "<button onclick='hapus_detail_kontrak(" + id + ",\"" + jenis_dokumen + "\")' class='btn btn-danger'>Hapus Kontrak</button>";

    // AJAX untuk ambil data employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_detail_addendum/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id: id,
      },
      beforeSend: function() {
        $('.info-modal-hapus-kontrak').attr("hidden", false);
        $('.isi-modal-hapus-kontrak').attr("hidden", true);
        $('.info-modal-hapus-kontrak').html(loading_html_text);
        $('#button_delete_kontrak').html(button_delete);
        $('#button_delete_kontrak').attr("hidden", true);
        $('#hapusKontrakModal').modal('show');
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          $('#jenis_kontrak_modal2').html(res['data']['jenis_dokumen']);
          $("#nomor_dokumen_modal2").html(res['data']['nomor_surat']);
          $('#periode_kontrak_modal2').html(res['data']['periode_start'] + " s/d " + res['data']['periode_end']);
          $('#tgl_terbit_kontrak_modal2').html(res['data']['tanggal_terbit']);
          $("#project_kontrak_modal2").html(res['data']['project']);
          $("#sub_project_kontrak_modal2").html(res['data']['sub_project']);
          $("#jabatan_kontrak_modal2").html(res['data']['jabatan']);

          $('.isi-modal-hapus-kontrak').attr("hidden", false);
          $('.info-modal-hapus-kontrak').attr("hidden", true);
          $('#button_delete_kontrak').attr("hidden", false);
        } else {
          html_text = res['pesan'];
          $('.info-modal-hapus-kontrak').html(html_text);
          $('.isi-modal-hapus-kontrak').attr("hidden", true);
          $('.info-modal-hapus-kontrak').attr("hidden", false);
          $('#button_delete_kontrak').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-hapus-kontrak').html(html_text); //coba pake iframe
        $('.isi-modal-hapus-kontrak').attr("hidden", true);
        $('.info-modal-hapus-kontrak').attr("hidden", false);
        $('#button_delete_kontrak').attr("hidden", true);
      }
    });

  };
</script>

<!-- Tombol Hapus Detail Kontrak -->
<script type="text/javascript">
  function hapus_detail_kontrak(id, jenis_dokumen) {
    var nip = "<?php echo $employee_id; ?>";
    var karyawan_id = "<?php echo $user_id; ?>";

    // alert("id: " + id + "\nJenis Dokumen: " + jenis_dokumen);

    // AJAX untuk ambil data employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/hapus_detail_kontrak/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        karyawan_id: karyawan_id,
        nip: nip,
        id: id,
        jenis_dokumen: jenis_dokumen,
      },
      beforeSend: function() {
        $('.info-modal-hapus-kontrak').attr("hidden", false);
        $('.isi-modal-hapus-kontrak').attr("hidden", true);
        $('.info-modal-hapus-kontrak').html(loading_html_text);
        $('#button_delete_kontrak').attr("hidden", true);
        $('#hapusKontrakModal').modal('show');
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          var html_kontrak = "";
          html_kontrak = html_kontrak + '<div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> DOKUMEN KONTRAK</strong></span> </div>';
          var i;
          for (i = 0; i < res['data'].length; ++i) {
            // do something with `substr[i]`
            if (res['data'][i]['jenis_dokumen'] == "ADDENDUM") {
              $variable_style = 'style="background-color:#c0ebbc;"';
            } else {
              $variable_style = 'style="background-color:#bcbeeb;"';
            }
            html_kontrak = html_kontrak + '';
            html_kontrak = html_kontrak + '<div class="card-header with-elements" ' + $variable_style + '> <span class="card-header-title mr-2"> <strong> ' + res['data'][i]['jenis_dokumen'] + '. Periode: ' + res['data'][i]['periode_start'] + ' - ' + res['data'][i]['periode_end'] + '</strong></span> </div>';
            html_kontrak = html_kontrak + '<div class="col-md-6">';
            html_kontrak = html_kontrak + '<table class="table table-striped">';
            html_kontrak = html_kontrak + '<tbody><tr>';
            html_kontrak = html_kontrak + '<th scope="row" style="width: 30%">Nomor Dokumen</th>';
            html_kontrak = html_kontrak + '<td>' + res['data'][i]['nomor_surat'] + '</td></tr><tr>';
            html_kontrak = html_kontrak + '<th scope="row">Project</th>';
            html_kontrak = html_kontrak + '<td>' + res['data'][i]['project'] + '</td></tr><tr>';
            html_kontrak = html_kontrak + '<th scope="row">Sub Project</th>';
            html_kontrak = html_kontrak + '<td>' + res['data'][i]['sub_project'] + '</td></tr><tr>';
            html_kontrak = html_kontrak + '<th scope="row">Jabatan</th>';
            html_kontrak = html_kontrak + '<td>' + res['data'][i]['jabatan'] + '</td></tr></tbody></table></div>';
            html_kontrak = html_kontrak + '<div class="col-md-6">';
            html_kontrak = html_kontrak + '<table class="table table-striped">';
            html_kontrak = html_kontrak + '<tbody><tr>';
            html_kontrak = html_kontrak + '<th scope="row" style="width: 30%">Tanggal Terbit</th>';
            html_kontrak = html_kontrak + '<td>' + res['data'][i]['tanggal_terbit'] + '</td></tr><tr>';
            html_kontrak = html_kontrak + '<td colspan="2">';
            html_kontrak = html_kontrak + res['data'][i]['button_open'] + res['data'][i]['button_upload'] + res['data'][i]['button_lihat'] + res['data'][i]['button_hapus'];
            html_kontrak = html_kontrak + '</td></tr></tbody></table></div>';
          }
          $('#isi-dokumen-kontrak-tabel').html(html_kontrak);

          $('.isi-modal-hapus-kontrak').attr("hidden", true);
          $('.info-modal-hapus-kontrak').html(success_html_text);
          $('.info-modal-hapus-kontrak').attr("hidden", false);
          $('#button_delete_kontrak').attr("hidden", true);
        } else {
          html_text = res['pesan'];
          $('.info-modal-hapus-kontrak').html(html_text);
          $('.isi-modal-hapus-kontrak').attr("hidden", true);
          $('.info-modal-hapus-kontrak').attr("hidden", false);
          $('#button_delete_kontrak').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-hapus-kontrak').html(html_text); //coba pake iframe
        $('.isi-modal-hapus-kontrak').attr("hidden", true);
        $('.info-modal-hapus-kontrak').attr("hidden", false);
        $('#button_delete_kontrak').attr("hidden", true);
      }
    });

  };
</script>