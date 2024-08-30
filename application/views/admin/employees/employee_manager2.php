<?php $session = $this->session->userdata('username'); ?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php $leave_user = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>

<!-- FOTO PROFILE -->
<?php
if ($profile_picture != '' && $profile_picture != 'no file') {
  $de_file = base_url() . 'uploads/profile/' . $profile_picture;
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
        <div class="isi-modal-edit-data-diri">
          <div class="container" id="container_modal">
            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <td style='width:25%'><strong>Nama Lengkap</strong></td>
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
                    <td><strong>Nomor KTP</strong></td>
                    <td>
                      <input id='ktp_no_modal' name='ktp_no_modal' type='number' class='form-control' placeholder='Nomor KTP' value=''>
                      <span id='pesan_ktp_no_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Nomor KK</strong></td>
                    <td>
                      <input id='kk_no_modal' name='kk_no_modal' type='number' class='form-control' placeholder='Nomor KK' value=''>
                      <span id='pesan_kk_no_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Nomor NPWP</strong></td>
                    <td>
                      <input id='npwp_no_modal' name='npwp_no_modal' type='number' class='form-control' placeholder='Nomor NPWP' value=''>
                      <span id='pesan_npwp_no_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Nomor HP/Whatasapp</strong></td>
                    <td>
                      <input id='contact_no_modal' name='contact_no_modal' type='number' class='form-control' placeholder='Nomor HP/Whatsapp' value=''>
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
                      <input id='ibu_kandung_modal' name='ibu_kandung_modal' type='text' class='form-control' placeholder='Nama Ibu Kandung' value=''>
                      <span id='pesan_ibu_kandung_modal'></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Alamat KTP</strong></td>
                    <td>
                      <textarea id="alamat_ktp_modal" name="alamat_ktp_modal" class='form-control' placeholder='Alamat KTP' rows="4"></textarea>
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
                        <option value="2" <?php if ($blood_group == '2'): ?> selected="selected" <?php endif; ?>>AREA</option>
                        <option value="3" <?php if ($blood_group == '3'): ?> selected="selected" <?php endif; ?>>RATECARD</option>
                        <option value="4" <?php if ($blood_group == '4'): ?> selected="selected" <?php endif; ?>>PROJECT</option>
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

<!-- CARD DATA -->
<div class="row <?php echo $get_animate; ?>">
  <div class="col-12">
    <div class="card mb-1 bg-primary border-0 text-white">
      <div class="card-body">
        <div class="row">
          <div class="col-3 col-md-2 col-auto text-center align-self-center">
            <img src="<?php echo $de_file; ?>" alt="" style="display: block; margin-left: auto; margin-right: auto;" class="d-block ui-w-80">
            <br>
            <button id="button_ubah_foto" class="btn btn-sm btn-white ladda-button mx-0" data-style="expand-right">Ubah Foto</button>
          </div>
          <div class="col-9 col-md-10 col-auto">
            <div class="ml-3">
              <div class="text-big mt-1" id="nama_lengkap_card"><?php echo $first_name; ?></div>
              <div class="mt-1">NIP: <?php echo $employee_id; ?> <button id="button_ganti_pin" class="btn btn-sm btn-white ladda-button mx-1" data-style="expand-right">Ganti PIN</button><button id="button_show_pin" class="btn btn-sm btn-white ladda-button mx-1" data-style="expand-right">Show PIN</button></div>
              <div class="mt-1">PROJECT: <?php echo $project_name; ?></div>
              <div class="mt-1" id="jabatan_name_card">JABATAN: <?php echo $designation_name; ?></div>
              <div class="mt-1" id="kategori_name_card">KATEGORI: <?php echo $kategori; ?></div>
              <div class="mt-3">
                <button id="button_verifikasi" class="btn btn-sm btn-white ladda-button mx-0" data-style="expand-right">Verifikasi Data</button>
                <button id="button_download_resume" class="btn btn-sm btn-white ladda-button mx-1" data-style="expand-right">Download Resume</button>
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
                  <a class="nav-link" id="project-jabatan-tab" data-toggle="tab" href="#project-jabatan" role="tab" aria-controls="project-jabatan" aria-selected="false"><i class="ion ion-ios-document"></i> &nbsp; Dokumen SK</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="project-jabatan-tab" data-toggle="tab" href="#project-jabatan" role="tab" aria-controls="project-jabatan" aria-selected="false"><i class="ion ion-logo-usd"></i> &nbsp; E-SLIP</a>
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
                              <th scope="row" style="width: 30%">Nama Lengkap</th>
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
                              <th scope="row" style="width: 30%">Nomor KTP</th>
                              <td id="nomor_ktp_tabel"><?php echo $ktp_no; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Nomor KK</th>
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
                                <button id="button_send_whatsapp" class="btn btn-sm btn-outline-primary ladda-button mx-1" data-style="expand-right">Send Whatsapp</button>
                                <button id="button_send_pin" class="btn btn-sm btn-outline-primary mx-0">Send PIN</button>
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
                    <hr class="border-light m-0">
                    <div class="row">
                      <div class="col-12 my-3">
                        <button id="button_edit_data_diri" class="btn btn-primary ladda-button mx-3" data-style="expand-right">Edit Data</button>
                      </div>
                    </div>

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
                    <hr class="border-light m-0">
                    <div class="row">
                      <div class="col-12 my-3">
                        <button id="button_edit_project" class="btn btn-primary ladda-button mx-3" data-style="expand-right">Edit Data</button>
                      </div>
                    </div>

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
                    <hr class="border-light m-0">
                    <div class="row">
                      <div class="col-12 my-3">
                        <button id="button_edit_kontak_darurat" class="btn btn-primary ladda-button mx-3" data-style="expand-right">Edit Data</button>
                      </div>
                    </div>

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
                              <th scope="row" style="width: 30%">Nama Bank</th>
                              <td><?php echo $bank_name; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Nomor Rekening</th>
                              <td><?php echo $nomor_rek; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Nama Pemilik Rekening</th>
                              <td><?php echo $pemilik_rek; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-md-6">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <th scope="row" style="width: 30%">Foto Buku Tabungan</th>
                              <td><?php echo $filename_rek; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                    </div>
                    <hr class="border-light m-0">
                    <div class="row">
                      <div class="col-12 my-3">
                        <button id="button_edit_rekening" class="btn btn-primary ladda-button mx-3" data-style="expand-right">Edit Data</button>
                      </div>
                    </div>

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
                              <th scope="row" style="width: 30%">Dokumen KTP</th>
                              <td><?php echo $display_ktp; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Dokumen KK</th>
                              <td><?php echo $display_kk; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Dokumen NPWP</th>
                              <td><?php echo $display_npwp; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Dokumen CV</th>
                              <td><?php echo $display_cv; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Dokumen SKCK</th>
                              <td><?php echo $display_skck; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Dokumen Ijazah</th>
                              <td><?php echo $display_isd; ?></td>
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
                              <th scope="row" style="width: 30%">BPJS Kesehatan</th>
                              <td><?php echo $display_bpjs_ks_no; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">BPJS Ketenagakerjaan</th>
                              <td><?php echo $display_bpjs_tk_no; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                    </div>
                    <hr class="border-light m-0">
                    <div class="row">
                      <div class="col-12 my-3">
                        <button id="button_edit_dokumen_pribadi" class="btn btn-primary ladda-button mx-3" data-style="expand-right">Upload Dokumen</button>
                      </div>
                    </div>

                  </div>
                  <!-- END TAB DOKUMEN PRIBADI -->

                  <!-- TAB DOKUMEN KONTRAK -->
                  <!-- <div class="tab-pane fade show active" id="account-basic_info" role="tabpanel" aria-labelledby="home-tab"> -->
                  <div class="tab-pane fade" id="dokumen-kontrak" role="tabpanel" aria-labelledby="dokumen-kontrak-tab">
                    <div class="row">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> DOKUMEN KONTRAK</strong></span> </div>

                      <div class="card-header with-elements" style="background-color:#e1e1e1;"> <span class="card-header-title mr-2"> <strong> KONTRAK. Periode: 1 Agustus 2024 - 31 Desember 2024</strong></span> </div>
                      <div class="col-md-6">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <th scope="row" style="width: 30%">Nomor Dokumen</th>
                              <td><?php echo $filename_ktp; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Project</th>
                              <td><?php echo $filename_kk; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Sub Project</th>
                              <td><?php echo $filename_npwp; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Jabatan</th>
                              <td><?php echo $filename_cv; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-md-6">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <th scope="row" style="width: 30%">Tanggal Terbit</th>
                              <td><?php echo $bpjs_ks_no; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Status</th>
                              <td><?php echo $bpjs_tk_no; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                    </div>
                    <!-- <hr class="border-light m-0">
                    <div class="row">
                      <div class="col-12 my-3">
                        <button id="button_edit_dokumen_kontrak" class="btn btn-primary ladda-button mx-3" data-style="expand-right">Upload Dokumen</button>
                      </div>
                    </div> -->

                  </div>
                  <!-- END TAB DOKUMEN KONTRAK -->

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

<!-- GLOBAL VARIABLE -->
<script type="text/javascript">
  $(document).ready(function() {
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

    // Sub Change - Jabatan
    $('#sub_project_modal').change(function() {
      var nip = "<?php echo $employee_id; ?>";
      var sub_project = $("#sub_project_modal").val();
      // var jabatan = "<?php //echo $designation_id; 
                        ?>";

      //-----testing-----
      // alert("sub project berubah");
      // alert(jabatan);

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

  });
</script>
<script type="text/javascript">
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
  var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
  var loading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
  loading_html_text = loading_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
  loading_html_text = loading_html_text + '<h2>LOADING...</h2>';
  loading_html_text = loading_html_text + '</div>';

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
    alert("Under Construction. Masuk button ubah foto");
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
    alert("Under Construction. Masuk button verifikasi");
  };
</script>

<!-- Tombol Download Resume -->
<script type="text/javascript">
  document.getElementById("button_download_resume").onclick = function(e) {
    // var html_text = '<iframe src="http://localhost/appcakrawala/admin/addendum/cetak/268" style="zoom:1.00" frameborder="0" height="400" width="99.6%"></iframe>';
    // $('.modal-title').html("Download Resume");
    // $('.isi-modal').html(html_text);
    // $('#button_save_pin').attr("hidden", true);
    // $('#editModal').appendTo("body").modal('show');
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
        html_text = "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
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
    $('#pesan_blood_group_modal').html(pesan_blood_group_modal);
    $('#pesan_ktp_no_modal').html(pesan_ktp_no_modal);
    $('#pesan_kk_no_modal').html(pesan_kk_no_modal);
    $('#pesan_npwp_no_modal').html(pesan_npwp_no_modal);
    $('#pesan_contact_no_modal').html(pesan_contact_no_modal);
    $('#pesan_email_modal').html(pesan_email_modal);
    $('#pesan_ibu_kandung_modal').html(pesan_ibu_kandung_modal);
    $('#pesan_alamat_ktp_modal').html(pesan_alamat_ktp_modal);
    $('#pesan_alamat_domisili_modal').html(pesan_alamat_domisili_modal);

    //-------action-------
    if (
      (pesan_first_name_modal != "") || (pesan_gender_modal != "") || (pesan_tempat_lahir_modal != "") ||
      (pesan_date_of_birth_modal != "") || (pesan_last_edu_modal != "") || (pesan_ethnicity_modal != "") ||
      (pesan_marital_status_modal != "") || (pesan_tinggi_badan_modal != "") || (pesan_berat_badan_modal != "") ||
      (pesan_blood_group_modal != "") || (pesan_ktp_no_modal != "") || (pesan_kk_no_modal != "") ||
      (pesan_npwp_no_modal != "") || (pesan_contact_no_modal != "") || (pesan_email_modal != "") ||
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
          html_text = "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
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
        html_text = "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
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
          html_text = "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
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
        html_text = "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
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
      pesan_nama_kontak_modal = "<small style='color:#FF0000;'>Sub Project tidak boleh kosong</small>";
      $('#nama_kontak_modal').focus();
    }
    if (hubungan_modal == "") {
      pesan_hubungan_modal = "<small style='color:#FF0000;'>Jabatan tidak boleh kosong</small>";
      $('#hubungan_modal').focus();
    }
    if (nomor_kontak_modal == "") {
      pesan_nomor_kontak_modal = "<small style='color:#FF0000;'>Penempatan tidak boleh kosong</small>";
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
          html_text = "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
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
    alert("Under Construction. masuk button edit Rekening Bank");
  };
</script>

<!-- Tombol Open Buku Tabungan -->
<script type="text/javascript">
  document.getElementById("button_open_buku_tabungan").onclick = function(e) {
    alert("Under Construction. masuk button Open Buku Tabungan");
  };
</script>

<!-- Tombol Open KTP -->
<script type="text/javascript">
  document.getElementById("button_open_ktp").onclick = function(e) {
    alert("Under Construction. masuk button Open KTP");
  };
</script>

<!-- Tombol Open KK -->
<script type="text/javascript">
  document.getElementById("button_open_kk").onclick = function(e) {
    alert("Under Construction. masuk button Open KK");
  };
</script>

<!-- Tombol Open NPWP -->
<script type="text/javascript">
  document.getElementById("button_open_npwp").onclick = function(e) {
    alert("Under Construction. masuk button Open NPWP");
  };
</script>

<!-- Tombol Open CV -->
<script type="text/javascript">
  document.getElementById("button_open_cv").onclick = function(e) {
    alert("Under Construction. masuk button Open CV");
  };
</script>

<!-- Tombol Open SKCK -->
<script type="text/javascript">
  document.getElementById("button_open_skck").onclick = function(e) {
    alert("Under Construction. masuk button Open SKCK");
  };
</script>

<!-- Tombol Open Ijazah -->
<script type="text/javascript">
  document.getElementById("button_open_ijazah").onclick = function(e) {
    alert("Under Construction. masuk button Open Ijazah");
  };
</script>

<!-- Tombol Open Paklaring -->
<!-- <script type="text/javascript">
  document.getElementById("button_open_paklaring").onclick = function(e) {
    alert("masuk button Open Paklaring");
  };
</script> -->

<!-- Tombol Open BPJS Kesehatan -->
<script type="text/javascript">
  document.getElementById("button_open_bpjs_ks").onclick = function(e) {
    alert("Under Construction. masuk button Open Kartu BPJS Kesehatan");
  };
</script>

<!-- Tombol Open BPJS Ketenagakerjaan -->
<script type="text/javascript">
  document.getElementById("button_open_bpjs_tk").onclick = function(e) {
    alert("Under Construction. masuk button Open Kartu BPJS Ketenagakerjaan");
  };
</script>

<!-- Tombol Edit Dokumen Pribadi -->
<script type="text/javascript">
  document.getElementById("button_edit_dokumen_pribadi").onclick = function(e) {
    alert("Under Construction. masuk button edit Dokumen Pribadi");
  };
</script>