<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>


<!-- Filepond css -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/filepond/filepond.min.css" type="text/css" />
<!-- <link href="assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css">


<!-- START MODAL EDIT EMPLOYEE REQUEST -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProfileModalLabel"><span class="judulModalProfile">Edit Data Karyawan Baru</span></h5>
        <button onclick="close_edit_employee()" type="button" class="close mb-3" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>


      </div>


                    <!-- Nav tabs -->
                    <ul id="navigasi_profile" style="background: #0B0B0B;" class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">

                      <li class="nav-item">
                        <a onclick="show_profile()" id="edit-profile-nav" class="nav-link fs-14 active" data-bs-toggle="tab" href="#edit-profile-tab" role="tab" title="Data Diri">
                          <i class="ri-briefcase-5-line d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Data Diri</span>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a onclick="show_project()" id="edit-project-nav" class="nav-link fs-14" data-bs-toggle="tab" href="#edit-project-tab" role="tab" title="Show Project">
                          <i class="ri-folder-4-line d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block"> Project</span>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a onclick="show_rekening()" id="edit-rekening-nav" class="nav-link fs-14" data-bs-toggle="tab" href="#edit-rekening-tab" role="tab" title="Show Rekening">
                          <i class="ri-folder-4-line d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block"> Rekening</span>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a onclick="show_dokumen()" id="edit-dokumen-nav" class="nav-link fs-14" data-bs-toggle="tab" href="#edit-dokumen-tab" role="tab" title="Show Dokumen">
                          <i class="ri-folder-4-line d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block"> Dokumen</span>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a onclick="show_upah()" id="edit-upah-nav" class="nav-link fs-14" data-bs-toggle="tab" href="#edit-upah-tab" role="tab" title="Show Upah">
                          <i class="ri-folder-4-line d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block"> Paket Upah</span>
                        </a>
                      </li>

                    </ul>

      <!-- <div class="modal-body bg-light"> -->
        <div class="isi-modal-edit-outlet">
          <div class="container" id="container_modal_emprequest">
            <div class="row">
              <div class="col-lg-12">
                <div>
                  <!-- <div class="d-flex profile-wrapper bg-primary"> -->
                  <div class="d-flex profile-wrapper">

                  </div>
                  <!-- TAB PANEL -->
                  <div class="tab-content pt-2 text-muted">

                    <!-- TAB PROFILE -->
                    <div class="tab-pane fade show active" id="edit-profile-tab" role="tabpanel">
                        <div class="card-body">
                          <!-- <h5 class="card-title mb-3">Add 1 Data SKU</h5> -->
                          <div class="row">
                            <table class="table table-striped table-bordered col-md-12">

                              <tbody>
                                <tr>
                                  <td style='width:100%'>
                                    <div class="row">
                                      <div class="col-md-6 mt-2">
                                        <input hidden id='id_kandidat_modal' name='id_kandidat_modal' type='text' class='form-control' value=''>
                                        <strong>Nama Lengkap</strong> <font color="#FF0000"><i> * Hanya Lihat</i></font>
                                        <input disabled id='nama_lengkap_modal' name='nama_lengkap_modal' type='text' class='form-control' placeholder='Nama Lengkap' value=''>
                                        <span id='pesan_nama_lengkap'></span>
                                      </div>
                                      <div class="col-md-6 mt-2">
                                        <strong>Nama Ibu Kandung <font color="#FF0000">*</font></strong>
                                        <input id='nama_ibu_modal' name='nama_ibu_modal' type='text' class='form-control' placeholder='Nama Outlet' value=''>
                                        <span id='pesan_nama_ibu_modal'></span>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6 mt-2">
                                        <strong>No. KTP</strong><font color="#FF0000"><i> * Hanya Lihat</i></font>
                                        <input disabled id='no_ktp_modal' name='no_ktp_modal' type='text' class='form-control' placeholder='No. KTP' value=''>
                                        <span id='pesan_nama_lengkap'></span>
                                      </div>
                                      <div class="col-md-6 mt-2">
                                        <strong>No. KK</strong><font color="#FF0000"><i> * Hanya Lihat</i></font>
                                        <input disabled id='no_kk_modal' name='no_kk_modal' type='text' class='form-control' placeholder='No. KK' value=''>
                                        <span id='pesan_nama_outlet_modal'></span>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6 mt-2">
                                        <strong>Tempat Lahir <font color="#FF0000">*</font></strong>
                                        <input id='tempat_lahir_modal' name='tempat_lahir_modal' type='text' class='form-control' placeholder='Tempat Lahir' value=''>
                                        <span id='pesan_tempat_lahir_modal'></span>
                                      </div>
                                      <div class="col-md-6 mt-2">
                                        <strong>Tanggal Lahir <font color="#FF0000">*</font></strong>
                                        <input id='tanggal_lahir_modal' name='tanggal_lahir_modal' class="form-control date" readonly placeholder="YYYY-MM-DD" type="text" value="">
                                        <span id='pesan_tanggal_lahir_modal'></span>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="card-header col-md-12">
                                      </div>
                                      <br>
                                    </div>
                                      <br>
                                    
                                    <div class="row">
                                      <div class="col-md-4 mt-2">
                                        <strong>Jenis Kelamin (P/L) <font color="#FF0000">*</font></strong>
                                        <select name="gender_modal" id="gender_modal" class="form-control xin_selection">
                                                  <option value="">Pilih Jenis Kelamin</option>
                                                  <option value="L">L (Laki-Laki)</option>
                                                  <option value="P">P (Perempuan)</option>
                                                </select>

                                        <span id='pesan_gender_modal'></span>
                                      </div>

                                      <div class="col-md-4 mt-2">
                                        <strong>Agama/Kepercayaan <font color="#FF0000">*</font></strong>
                                        <select name="agama_modal" id="agama_modal" class="form-control xin_selection">
                                          <option value="">Pilih Agama</option>
                                          <?php foreach ($list_agama as $agama) : ?>
                                            <option value="<?= $agama['ethnicity_type_id']; ?>" style="text-wrap: wrap;">
                                              <?php echo $agama['type']; ?>
                                            </option>
                                          <?php endforeach; ?>
                                        </select>

                                        <span id='pesan_agama_modal'></span>
                                      </div>

                                      <div class="col-md-4 mt-2">
                                        <strong>Status Pernikahan <font color="#FF0000">*</font></strong>
                                        <select name="status_kawin_modal" id="status_kawin_modal" class="form-control xin_selection">
                                          <option value="">Pilih Status</option>
                                          <?php foreach ($list_ptkp as $ptkp) : ?>
                                            <option value="<?= $ptkp['id_marital']; ?>" style="text-wrap: wrap;">
                                              <?php echo $ptkp['kode']. ' - ' . $ptkp['nama']; ?>
                                            </option>
                                          <?php endforeach; ?>
                                        </select>
                                        <span id='pesan_status_kawin_modal'></span>
                                      </div>

                                    </div>

                                    <div class="row">
                                      <div class="col-md-4 mt-2">
                                        <strong>NPWP</strong>
                                        <input id='no_npwp_modal' name='no_npwp_modal' type='text' class='form-control' placeholder='No. NPWP' value=''>
                                      </div>
                                      <div class="col-md-4 mt-2">
                                        <strong>No. HP <font color="#FF0000">*</font></strong>
                                        <input id='no_hp_modal' name='no_hp_modal' type='text' class='form-control' placeholder='No. HP' value=''>
                                        <span id='pesan_no_hp_modal'></span>
                                      </div>
                                      <div class="col-md-4 mt-2">
                                        <strong>Email <font color="#FF0000">*</font></strong>
                                        <input id='alamat_email_modal' name='alamat_email_modal' type='text' class='form-control' placeholder='Alamat Email' value=''>
                                        <span id='pesan_alamat_email_modal'></span>
                                      </div>
                                    </div>

                                    <div class="row">
                                      <div class="col-md-4 mt-2">
                                        <strong>Nama Kotak Darurat<font color="#FF0000">*</font></strong>
                                        <input id='emergency_name_modal' name='emergency_name_modal' type='text' class='form-control' placeholder='Nama Kotak Darurat' value=''>
                                        <span id='pesan_emergency_name_modal'></span>
                                      </div>
                                      <div class="col-md-4 mt-2">
                                        <strong>Hub. Kontak Darurat <font color="#FF0000">*</font></strong>

                                        <select name="emergency_hubungan_modal" id="emergency_hubungan_modal" class="form-control xin_selection">
                                          <option value="">Pilih Keluarga</option>
                                          <?php foreach ($list_relation as $relasi) : ?>
                                            <option value="<?= $relasi['secid']; ?>" style="text-wrap: wrap;">
                                              <?php echo $relasi['name']; ?>
                                            </option>
                                          <?php endforeach; ?>
                                        </select>
                                        <span id='pesan_emergency_hubungan_modal'></span>
                                      </div>
                                      <div class="col-md-4 mt-2">
                                        <strong>No. Kontak Darurat <font color="#FF0000">*</font></strong>
                                        <input id='emergency_kontak_modal' name='emergency_kontak_modal' type='text' class='form-control' placeholder='No. Kontak Darurat' value=''>
                                        <span id='pesan_emergency_kontak_modal'></span>
                                      </div>
                                    </div>

                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                    </div>

                    <!-- TAB PROJECT -->
                    <div class="tab-pane fade" id="edit-project-tab" role="tabpanel">
                        <div class="card-body">

                          <div class="row">
                            <table class="table table-striped table-bordered col-md-12">

                              <tbody>
                                <tr>
                                  <td style='width:100%'>
                                    
                                    <div class="row">


                                      <div class="col-md-6 mt-2">
                                        <strong>Projecct/Client <font color="#FF0000">*</font></strong>
                                        <select name="project_name_modal" id="project_name_modal" class="form-control xin_selection">
                                          <option value="">Pilih Project</option>
                                          <?php foreach ($list_project as $project) : ?>
                                            <option value="<?= $project['project_id']; ?>" style="text-wrap: wrap;">
                                              <?php echo '['.$project['priority'].'] '. $project['title']; ?>
                                            </option>
                                          <?php endforeach; ?>
                                        </select>
                                        <span id='pesan_project_name_modal'></span>
                                      </div>

                                      <div class="col-md-6 mt-2">
                                        <strong>Entitas <font color="#FF0000">*</font></strong>
                                        <select name="subproject_name_modal" id="subproject_name_modal" class="form-control xin_selection">
                                          <option value="">Pilih Entitas</option>
                                          <?php foreach ($list_subproject as $entitas) : ?>
                                            <option value="<?= $entitas['secid']; ?>" style="text-wrap: wrap;">
                                              <?php echo $entitas['sub_project_name'].' - '.$entitas['doc_id'] ; ?>
                                            </option>
                                          <?php endforeach; ?>
                                        </select>
                                        <span id='pesan_subproject_name_modal'></span>
                                      </div>

                                    </div>

                                    <div class="row">

                                      <input id='vendor_id_modal' name='vendor_id_modal' type='text' value='' hidden>
                                      <input id='doc_id_modal' name='vendor_id_modal' type='text' value='' hidden>

                                      <div class="col-md-6 mt-2">
                                        <strong>Vendor/PT.</strong>
                                        <input id='vendor_name_modal' name='vendor_name_modal' type='text' class='form-control' placeholder='Nama Vendor/PT.' value='' disabled>
                                      </div>

                                      <div class="col-md-6 mt-2">
                                        <strong>Jabatan <font color="#FF0000">*</font></strong>
                                        <select name="jabatan_name_modal" id="jabatan_name_modal" class="form-control xin_selection">
                                          <option value="">Pilih Posisi</option>
                                          <?php foreach ($list_posisi as $posisi) : ?>
                                            <option value="<?= $posisi['designation_id']; ?>" style="text-wrap: wrap;">
                                              <?php echo $posisi['disignation_name']; ?>
                                            </option>
                                          <?php endforeach; ?>

                                        </select>
                                        <span id='pesan_jabatan_name_modal'></span>
                                      </div>

                                    </div>

                                    <div class="row">
                                     
                                      <div class="col-md-4 mt-2">
                                        <strong>Kategory <font color="#FF0000">*</font></strong>
                                        <select name="kategory_name_modal" id="kategory_name_modal" class="form-control xin_selection">
                                          <option value="">Pilih Jabatan</option>
                                          <?php foreach ($list_location as $location) : ?>
                                            <option value="<?= $location['secid']; ?>" style="text-wrap: wrap;">
                                              <?php echo $location['location_name']; ?>
                                            </option>
                                          <?php endforeach; ?>
                                        </select>

                                        <span id='pesan_kategory_name_modal'></span>
                                      </div>

                                      <div class="col-md-4 mt-2">
                                        <strong>Area/Kota-Kab (Ratecard)<font color="#FF0000">*</font></strong>
                                        <input id='penempatan_modal' name='penempatan_modal' type='text' class='form-control' placeholder='Area / Kota - Kab (Sesuai Ratecard)' value=''>
                                        <span id='pesan_penempatan_modal'></span>
                                      </div>

                                      <div class="col-md-4 mt-2">
                                        <strong>Lokasi Kerja / Detail Area</strong>
                                        <input id='penempatan_kerja_modal' name='penempatan_kerja_modal' type='text' class='form-control' placeholder='Lokasi Kerja / Detail Area' value=''>
                                        <span id='pesan_penempatan_kerja_modal'></span>
                                      </div>

                                    </div>


                                    <div class="row">

                                      <div class="col-md-4 mt-2">
                                        <strong>Region</strong>
                                        <input id='region_name_modal' name='region_name_modal' type='text' class='form-control' placeholder='Nama Region' value=''>
                                        <span id='pesan_region_name_modal'></span>
                                      </div>

                                      <div class="col-md-4 mt-2">
                                        <strong>DC (Data Center)</strong>
                                        <input id='dc_name_modal' name='dc_name_modal' type='text' class='form-control' placeholder='Nama Data Center (DC)' value=''>
                                        <span id='pesan_dc_name_modal'></span>
                                      </div>

                                      <div class="col-md-4 mt-2">
                                        <strong>Tanggal Join <font color="#FF0000">*</font></strong>
                                        <input id='tanggal_join_modal' name='tanggal_join_modal' class="form-control date" readonly placeholder="YYYY-MM-DD" type="text" value="">
                                        <span id='pesan_tanggal_join_modal'></span>
                                      </div>
                                    </div>

                                    <div class="row">

                                      <div class="col-md-4 mt-2">
                                        <strong>Tanggal Mulai Kontrak<font color="#FF0000">*</font></strong>
                                        <input id='tanggal_mulai_modal' name='tanggal_mulai_modal' class="form-control date" readonly placeholder="YYYY-MM-DD" type="text" value="">
                                        <span id='pesan_tanggal_mulai_modal'></span>
                                      </div>

                                      <div class="col-md-4 mt-2">
                                        <strong>Tanggal Akhir Kontrak <font color="#FF0000">*</font></strong>
                                        <input id='tanggal_akhir_modal' name='tanggal_akhir_modal' class="form-control date" readonly placeholder="YYYY-MM-DD" type="text" value="">
                                        <span id='pesan_tanggal_akhir_modal'></span>
                                      </div>
                                      <div class="col-md-4 mt-2">
                                        <strong>Waktu Kontrak <font color="#FF0000">*</font></strong>
                                        <select name="waktu_kontrak_modal" id="waktu_kontrak_modal" class="form-control xin_selection">
                                            <option value="">Pilih Waktu Kontrak</option>
                                            <option value="1">1 (Bulan)</option>
                                            <option value="2">2 (Bulan)</option>
                                            <option value="3">3 (Bulan)</option>
                                            <option value="4">4 (Bulan)</option>
                                            <option value="5">4 (Bulan)</option>
                                            <option value="6">6 (Bulan)</option>
                                            <option value="7">7 (Bulan)</option>
                                            <option value="8">8 (Bulan)</option>
                                            <option value="9">9 (Bulan)</option>
                                            <option value="10">10 (Bulan)</option>
                                            <option value="11">11 (Bulan)</option>
                                            <option value="12">12 (Bulan)</option>
                                        </select>

                                        <span id='pesan_waktu_kontrak_modal'></span>
                                      </div>
                                    </div>

                                    <div class="row">

                                      <div class="col-md-4 mt-2">
                                        <strong>Cut Off contoh: 01/30 <font color="#FF0000">*</font></strong>


                                        <input id='cut_off_modal' name='cut_off_modal' type='text' class='form-control' placeholder='00/00' value=''>



                                        <span id='pesan_cut_off_modal'></span>
                                      </div>

                                      <div class="col-md-4 mt-2">
                                        <strong>Hari Kerja (HK) <font color="#FF0000">*</font></strong>
                                        <input id='hari_kerja_model' name='hari_kerja_model' type='number' class='form-control' placeholder='Jumlah Hari Kerja (HK)' value=''>
                                        <span id='pesan_hari_kerja_model'></span>
                                      </div>

                                      <div class="col-md-4 mt-2">
                                        <strong>Tanggal Penggajian <font color="#FF0000">*</font></strong>
                                        <input id='tanggal_penggajian_modal' name='tanggal_penggajian_modal' class="form-control" placeholder="00" type="text" value="">
                                        <span id='pesan_tanggal_penggajian_modal'></span>
                                      </div>
                                    </div>

                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>

                        </div>
                    </div>

                    <!-- TAB DOKUMEN -->
                    <div class="tab-pane fade" id="edit-dokumen-tab" role="tabpanel">
                      <div class="card">
                        <div class="card-body">

                          <div class="isi-modal-verifikasi">
                            <div class="container" id="container_modal_verifikasi">
                              <div class="row">
                                <table class="table table-striped col-md-12">
                                  <tbody>
                                    <!-- FILE KTP -->
                                    <tr>
                                      <td style='width:25%'><strong>File KTP <span class="icon-verify-file-ktp"></span></strong></td>
                                      <td style='width:50%'>
                                        <!-- <div class="row align-items-center"> -->
                                        <span class='display_file_ktp_modal'></span>
                                        <input hidden type="text" id="link_file_ktp_sebelum_modal">
                                        <input hidden type="text" id="link_file_ktp_modal">
                                        <input type="file" class="filepond filepond-input-multiple" multiple id="file_ktp_modal" data-allow-reorder="true" data-max-file-size="5MB" data-max-files="1" accept="image/png, image/jpeg, application/pdf">
                                        <span id='pesan_file_ktp_modal'></span>
                                        <!-- </div> -->
                                      </td>
                                      <td style='width:30%'>
                                        <span id="button_verify_file_ktp_modal"></span>
                                        <span id="button_unverify_file_ktp_modal"></span>
                                      </td>
                                    </tr>
                                    <!-- NIK KTP -->
                                    <tr>
                                      <td style='width:20%'><strong>NIK <span class="icon-verify-nik"></span></strong></td>
                                      <td style='width:50%'>
                                        <input hidden type="text" id="nik_modal_sebelum_verifikasi">
                                        <input type='text' id="nik_modal_verifikasi" class='form-control' placeholder='Nomor NIK KTP' value=''>
                                        <span id='pesan_nik_verifikasi_modal'></span>
                                      </td>
                                      <td style='width:30%'>
                                        <span id="button_verify_nik_modal"></span>
                                        <span id="button_unverify_nik_modal"></span>
                                      </td>
                                    </tr>
                                    <!-- NAMA LENKGAP -->
                                    <tr>
                                      <td style='width:20%'><strong>Nama Lengkap <span class="icon-verify-nama"></span></strong></td>
                                      <td style='width:50%'>
                                        <input hidden type="text" id="nama_modal_sebelum">
                                        <input type='text' id="nama_modal" class='form-control' placeholder='Nama Lengkap' value="">
                                        <span id='pesan_nama_verifikasi_modal'></span>
                                      </td>
                                      <td style='width:30%'>
                                        <span id="button_verify_nama_modal"></span>
                                        <span id="button_unverify_nama_modal"></span>
                                      </td>
                                    </tr>
                                    <!-- FILE KK -->
                                    <tr>
                                      <td style='width:25%'><strong>File KK <span class="icon-verify-file-kk"></span></strong></td>
                                      <td style='width:75%'>
                                        <!-- <div class="row align-items-center"> -->
                                        <span class='display_file_kk_modal'></span>
                                        <input hidden type="text" id="link_file_kk_sebelum_modal">
                                        <input hidden type="text" id="link_file_kk_modal">
                                        <input type="file" class="filepond filepond-input-multiple" multiple id="file_kk_modal" data-allow-reorder="true" data-max-file-size="5MB" data-max-files="1" accept="image/png, image/jpeg, application/pdf">
                                        <span id='pesan_file_kk_modal'></span>
                                        <!-- </div> -->
                                      </td>
                                      <td style='width:30%'>
                                        <span id="button_verify_file_kk_modal"></span>
                                        <span id="button_unverify_file_kk_modal"></span>
                                      </td>
                                    </tr>
                                    <!-- NOMOR KK -->
                                    <tr>
                                      <td style='width:20%'><strong>KK <span class="icon-verify-kk"></span></strong></td>
                                      <td style='width:50%'>
                                        <input hidden type="text" id="kk_modal_sebelum">
                                        <input type='text' id="kk_modal" class='form-control' placeholder='Nomor Kartu Keluarga' value=''>
                                        <span id='pesan_kk_verifikasi_modal'></span>
                                      </td>
                                      <td style='width:30%'>
                                        <span id="button_verify_kk_modal"></span>
                                        <span id="button_unverify_kk_modal"></span>
                                      </td>
                                    </tr>
                                    <!-- FILE CV -->
                                    <tr>
                                      <td style='width:25%'><strong>File CV <span class="icon-verify-file-cv"></span></strong></td>
                                      <td style='width:75%'>
                                        <!-- <div class="row align-items-center"> -->
                                        <span class='display_file_cv_modal'></span>
                                        <input hidden type="text" id="link_file_cv_sebelum_modal">
                                        <input hidden type="text" id="link_file_cv_modal">
                                        <input type="file" class="filepond filepond-input-multiple" multiple id="file_cv_modal" data-allow-reorder="true" data-max-file-size="5MB" data-max-files="1" accept="image/png, image/jpeg, application/pdf">
                                        <span id='pesan_file_cv_modal'></span>
                                        <!-- </div> -->
                                      </td>
                                      <td style='width:30%'>
                                        <span id="button_verify_file_cv_modal"></span>
                                        <span id="button_unverify_file_cv_modal"></span>
                                      </td>
                                    </tr>
                                    <!-- FILE SKCK -->
                                    <tr>
                                      <td style='width:25%'><strong>File SKCK <span class="icon-verify-file-skck"></span></strong></td>
                                      <td style='width:75%'>
                                        <!-- <div class="row align-items-center"> -->
                                        <span class='display_file_skck_modal'></span>
                                        <input hidden type="text" id="link_file_skck_sebelum_modal">
                                        <input hidden type="text" id="link_file_skck_modal">
                                        <input type="file" class="filepond filepond-input-multiple" multiple id="file_skck_modal" data-allow-reorder="true" data-max-file-size="5MB" data-max-files="1" accept="image/png, image/jpeg, application/pdf">
                                        <span id='pesan_file_skck_modal'></span>
                                        <!-- </div> -->
                                      </td>
                                      <td style='width:30%'>
                                        <span id="button_verify_file_skck_modal"></span>
                                        <span id="button_unverify_file_skck_modal"></span>
                                      </td>
                                    </tr>
                                    <!-- FILE IJAZAH -->
                                    <tr>
                                      <td style='width:25%'><strong>File Ijazah <span class="icon-verify-file-ijazah"></span></strong></td>
                                      <td style='width:75%'>
                                        <!-- <div class="row align-items-center"> -->
                                        <span class='display_file_ijazah_modal'></span>
                                        <input hidden type="text" id="link_file_ijazah_sebelum_modal">
                                        <input hidden type="text" id="link_file_ijazah_modal">
                                        <input type="file" class="filepond filepond-input-multiple" multiple id="file_ijazah_modal" data-allow-reorder="true" data-max-file-size="5MB" data-max-files="1" accept="image/png, image/jpeg, application/pdf">
                                        <span id='pesan_file_ijazah_modal'></span>
                                        <!-- </div> -->
                                      </td>
                                      <td style='width:30%'>
                                        <span id="button_verify_file_ijazah_modal"></span>
                                        <span id="button_unverify_file_ijazah_modal"></span>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="info-modal-verifikasi">
                          </div>
                        

                        </div>
                      </div>
                    </div>

                    <!-- TAB REKENING -->
                    <div class="tab-pane fade" id="edit-rekening-tab" role="tabpanel">
                      <div class="card">
                        <div class="card-header">
                          <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0"><span class="judulModalProfile"></span></h5>
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="isi-modal-rekening">
                          <!-- <h5 class="card-title mb-3">Add 1 Data SKU</h5> -->
                          <div class="row">
                            <table class="table table-striped table-bordered col-md-12">

                              <tbody>

                                    <tr>
                                      <td style='width:20%'><strong>Bank <span class="icon-verify-bank"></span></strong></td>
                                      <td style='width:50%'>
                                        <input hidden type="text" id="bank_modal_sebelum">
                                        <select name="bank_modal" id="bank_modal" class="form-control" data-plugin="select_modal_verifikasi" data-placeholder="<?php echo $this->lang->line('xin_bank_choose_name'); ?>">
                                          <option value="">Pilih Bank</option>
                                          <?php
                                          foreach ($list_bank as $bank) {
                                          ?>
                                            <option value="<?php echo $bank->secid; ?>"> <?php echo $bank->bank_name; ?></option>
                                          <?php
                                          }
                                          ?>
                                        </select>
                                        <span id='pesan_bank_verifikasi_modal'></span>
                                      </td>
                                      <td style='width:30%'>
                                        <span id="button_verify_bank_modal"></span>
                                        <span id="button_unverify_bank_modal"></span>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style='width:20%'><strong>Nomor Rekening <span class="icon-verify-norek"></span></strong></td>
                                      <td style='width:50%'>
                                        <input hidden type="text" id="rekening_modal_sebelum">
                                        <input type='text' id="rekening_modal" class='form-control' placeholder='Nomor Rekening' value=''>
                                        <span id='pesan_norek_verifikasi_modal'></span>
                                      </td>
                                      <td style='width:30%'>
                                        <span id="button_verify_norek_modal"></span>
                                        <span id="button_unverify_norek_modal"></span>
                                        <!-- <button id="button_verify_norek_modal" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>
                                        <?php //if (($user[0]->user_role_id == "1") || ($user[0]->user_role_id == "11") || ($user[0]->user_role_id == "22") || ($user[0]->user_role_id == "3")) { 
                                        ?>
                                          <button id="button_unverify_norek_modal" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>
                                        <?php //} 
                                        ?> -->
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style='width:20%'><strong>Pemilik Rekening <span class="icon-verify-pemilik-rek"></span></strong></td>
                                      <td style='width:50%'>
                                        <input hidden type="text" id="pemilik_rekening_modal_sebelum">
                                        <input type='text' id="pemilik_rekening_modal" class='form-control' placeholder='Pemilik Rekening' value="">
                                        <span id='pesan_pemilik_rekening_verifikasi_modal'></span>
                                      </td>
                                      <td style='width:30%'>
                                        <span id="button_verify_pemilik_rek_modal"></span>
                                        <span id="button_unverify_pemilik_rek_modal"></span>
                                        <!-- <button id="button_verify_pemilik_rek_modal" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>
                                        <?php //if (($user[0]->user_role_id == "1") || ($user[0]->user_role_id == "11") || ($user[0]->user_role_id == "22") || ($user[0]->user_role_id == "3")) { 
                                        ?>
                                          <button id="button_unverify_pemilik_rek_modal" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>
                                        <?php //} 
                                        ?> -->
                                      </td>
                                    </tr>
                              </tbody>
                            </table>
                          </div>
                          </div>
                        </div>

                          <div class="info-modal-rekening">
                          </div>
                      </div>
                    </div>

                    <!-- TAB UPAH -->
                    <div class="tab-pane fade" id="edit-upah-tab" role="tabpanel">
                        <div class="card-body">

                          <div class="row">
                            <table class="table table-striped table-bordered col-md-12">

                              <tbody>
                                <tr>
                                  <td style='width:100%'>
                                    

                                    <div class="row" style="padding-bottom: inherit;">
                                      
                                      <div class="col-md-6 mt-2">
                                        <strong>Gaji Pokok<font color="#FF0000">*</font></strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id="gaji_pokok_modal" name="gaji_pokok_modal" type="text" class="form-control" placeholder="Gaji Pokok / UMK" value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                <span id="pesan_gaji_pokok_modal"></span>
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="#" id="#" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>
                                    </div>

                                    <!-- jabatan - area -->
                                    <div class="row" style="background: #dce1e5; padding-bottom: inherit;">
                                      
                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Jabatan</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_jabatan_modal' name='allow_jabatan_modal' type='text' class='form-control' placeholder='Tunjangan Jabatan' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_jabatan" id="dm_allow_jabatan" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Area</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_area_modal' name='allow_area_modal' type='text' class='form-control' placeholder='Tunjangan Area' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_area" id="dm_allow_area" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>
                                    </div>

                                    <!-- makan - transport -->
                                    <div class="row" style="padding-bottom: inherit;">
                                      
                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Makan</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_makan_modal' name='allow_makan_modal' type='text' class='form-control' placeholder='Tunjangan Makan' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_makan" id="dm_allow_makan" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Transport</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_transport_modal' name='allow_transport_modal' type='text' class='form-control' placeholder='Tunjangan Transport' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_transport" id="dm_allow_transport" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>
                                    </div>

                                    <!-- komunikasi - laptop -->
                                    <div class="row" style="background: #dce1e5; padding-bottom: inherit;">
                                      
                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Komunikasi</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_kom_modal' name='allow_kom_modal' type='text' class='form-control' placeholder='Tunjangan Komunikasi' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_kom" id="dm_allow_kom" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Laptop/Elektronik</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_device_modal' name='allow_device_modal' type='text' class='form-control' placeholder='Tunjangan Laptop/Komputer/Elektronik' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_device" id="dm_allow_device" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>
                                    </div>

                                    <!-- parkir - akomodasi -->
                                    <div class="row" style="padding-bottom: inherit;">
                                      
                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Parkir</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_parkir_modal' name='allow_parkir_modal' type='text' class='form-control' placeholder='Tunjangan Parkir' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_parkir" id="dm_allow_parkir" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Akomodasi/DLK</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_akomodasi_modal' name='allow_akomodasi_modal' type='text' class='form-control' placeholder='Tunjangan Akomodasi/DLK' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_akomodasi" id="dm_allow_akomodasi" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>
                                    </div>

                                    <!-- rental - kasir -->
                                    <div class="row" style="background: #dce1e5; padding-bottom: inherit;">
                                      
                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Rental/Sewa</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_rental_modal' name='allow_rental_modal' type='text' class='form-control' placeholder='Tunjangan Rental/Sewa' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_rental" id="dm_allow_rental" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Kasir/Admin</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_kasir_modal' name='allow_kasir_modal' type='text' class='form-control' placeholder='Tunjangan Kasir/Admin' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_kasir" id="dm_allow_kasir" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>
                                    </div>

                                    <!-- masa kerja - temat tinggal -->
                                    <div class="row" style="padding-bottom: inherit;">
                                      
                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Masa Kerja</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_masa_modal' name='allow_masa_modal' type='text' class='form-control' placeholder='Tunjangan Masa Kerja' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_masa" id="dm_allow_masa" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Tempat Tinggal</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_tempattinggal_modal' name='allow_tempattinggal_modal' type='text' class='form-control' placeholder='Tunjangan Tempat Tinggal' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_tempattinggal" id="dm_allow_tempattinggal" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>
                                    </div>

                                    <!-- TRANS MEAL - TRANS RENT -->
                                    <div class="row" style="background: #dce1e5; padding-bottom: inherit;">
                                      

                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Transport - Makan</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_transmeal_modal' name='allow_transmeal_modal' type='text' class='form-control' placeholder='Tunjangan Transport - Makan' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_transmeal" id="dm_allow_transmeal" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Transport - Rental</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_transrent_modal' name='allow_transrent_modal' type='text' class='form-control' placeholder='Tunjangan Transport - Rental' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_transrent" id="dm_allow_transrent" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>
                                    </div>

                                    <!-- MEDICIN - GROOMING -->
                                    <div class="row" style="padding-bottom: inherit;">
                                      
                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Vitamin/Obat</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_medicine_modal' name='allow_medicine_modal' type='text' class='form-control' placeholder='Tunjangan Vitamin/Obat' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_medicine" id="dm_allow_medicine" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Grooming</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_grooming_modal' name='allow_grooming_modal' type='text' class='form-control' placeholder='Tunjangan Grooming' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_grooming" id="dm_allow_grooming" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>
                                    </div>

                                    <!-- KEHADIRAN - DISIPLIN -->
                                    <div class="row" style="background: #dce1e5; padding-bottom: inherit;">
                                      
                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Kehadiran</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_kehadiran_modal' name='allow_kehadiran_modal' type='text' class='form-control' placeholder='Tunjangan Kehadiran' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_kehadiran" id="dm_allow_kehadiran" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Disiplin</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_disiplin_modal' name='allow_disiplin_modal' type='text' class='form-control' placeholder='Tunjangan Disiplin' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_disiplin" id="dm_allow_disiplin" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>
                                    </div>

                                    <!-- TRAINING - KEAHLIAN -->
                                    <div class="row" style="padding-bottom: inherit;">
                                      
                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Training/Pelatihan</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_training_modal' name='allow_training_modal' type='text' class='form-control' placeholder='Tunjangan Training/Pelatihan' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_training" id="dm_allow_training" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Keahlian</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_keahlian_modal' name='allow_keahlian_modal' type='text' class='form-control' placeholder='Tunjangan Keahlian' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_keahlian" id="dm_allow_keahlian" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>
                                    </div>


                                    <!-- KINERJA - PPH -->
                                    <div class="row" style="background: #dce1e5; padding-bottom: inherit;">
                                      
                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Kinerja</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_kinerja_modal' name='allow_kinerja_modal' type='text' class='form-control' placeholder='Tunjangan Kinerja' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_kinerja" id="dm_allow_kinerja" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan PPH Karyawan</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_pph_modal' name='allow_pph_modal' type='text' class='form-control' placeholder='Tunjangan PPH Karyawan' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_pph" id="dm_allow_pph" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>
                                    </div>

                                    <!-- OPERATIONAL - OTHERS -->
                                    <div class="row" style="padding-bottom: inherit;">
                                      
                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Operational</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_operational_modal' name='allow_operational_modal' type='text' class='form-control' placeholder='Tunjangan Operational' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_operational" id="dm_allow_operational" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-md-6 mt-2">
                                        <strong>Tunjangan Lain-Lain</strong>
                                          <div class="row">
                                              <div class="col-md-6 mt-2">
                                                <input id='allow_other_modal' name='allow_other_modal' type='text' class='form-control' placeholder='Tunjangan Lain-Lain' value="" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                              </div>
                                              <div class="col-md-3 mt-2">
                                                <select name="dm_allow_other" id="dm_allow_other" data-plugin="xin_select">
                                                  <option value="Bulan">Bulan</option>
                                                  <option value="Hari">Hari</option>
                                                </select>
                                              </div>
                                          </div>
                                      </div>
                                    </div>

                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>

                        </div>
                    </div>
                    <!--end tab-pane-->
                  </div>
                  <!--end tab-content-->
                </div>
              </div>
              <!--end col-->
            </div>
            <!--end row-->

          </div>
        </div>

        <div class="info-modal-edit-outlet"></div>

      <!-- </div> -->
      <div class="modal-footer">
        <button onclick="close_edit_employee()" type='button' class='btn btn-secondary mt-2' data-dismiss='modal'>Close</button>
        <button onclick="save_data_diri()" id='button_save_profile' name='button_save_profile' type='button' class='btn btn-primary mt-2'>Save Data Profile</button>

        <button onclick="save_data_project()" id='button_save_project' name='button_save_project' type='button' class='btn btn-primary mt-2'>Save Data Project</button>

        <button onclick="save_data_dokumen()" id='button_save_dokumen' name='button_save_dokumen' type='button' class='btn btn-primary mt-2'>Save Data Dokumen</button>

        <button onclick="save_data_rekening()" id='button_save_rekening' name='button_save_rekening' type='button' class='btn btn-primary mt-2'>Save Data Rekening</button>

        <button onclick="save_data_upah()" id='button_save_upah' name='button_save_upah' type='button' class='btn btn-primary mt-2'>Save Data Upah</button>


        <button onclick="delete_outlet()" id='button_delete_outlet' name='button_delete_outlet' type='button' class='btn btn-danger mt-2'>Delete Data Outlet</button>
      </div>
    </div>
  </div>
</div>
<!-- END MODAL EDIT EMPLOYEE REQUEST -->


<!-- FILTER -->
<div class="card border-blue">
  <h5 class="card-header text-black bg-gradient-blue">Filter Daftar Karyawan Baru</h5>
  <div class="card-body border-bottom-blue ">
    <div class="form-row">
      <div class="col-md mb-3">
        <label class="form-label">Kesiapan Data</label>
        <select class="form-control" data-live-search="true" name="approve" id="approve" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_projects'); ?>">
          <option value="0">--ALL--</option>
          <option value="1" <?php if ($approve_karyawan == "1") {
                              echo " selected";
                            } ?>>Siap approve</option>
          <option value="2" <?php if ($approve_karyawan == "2") {
                              echo " selected";
                            } ?>>Belum siap approve</option>
        </select>
      </div>

      <div class="col-md mb-3">
        <label class="form-label">Jenis Dokumen</label>
        <select class="form-control" data-live-search="true" name="golongan" id="golongan" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_projects'); ?>">
          <option value="0">--ALL--</option>
          <option value="1" <?php if ($golongan_karyawan == "1") {
                              echo " selected";
                            } ?>>PKWT</option>
          <option value="2" <?php if ($golongan_karyawan == "2") {
                              echo " selected";
                            } ?>>TKHL</option>
        </select>
      </div>

      <div class="col-md mb-3">
        <label class="form-label">Kategori</label>
        <select class="form-control" data-live-search="true" name="kategori" id="kategori" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_projects'); ?>">
          <option value="0">--ALL--</option>
          <option value="1" <?php if ($kategori_karyawan == "1") {
                              echo " selected";
                            } ?>>In House</option>
          <option value="2" <?php if ($kategori_karyawan == "2") {
                              echo " selected";
                            } ?>>Area</option>
          <option value="3" <?php if ($kategori_karyawan == "3") {
                              echo " selected";
                            } ?>>Ratecard</option>
          <option value="4" <?php if ($kategori_karyawan == "4") {
                              echo " selected";
                            } ?>>Project</option>
        </select>
      </div>
      <!-- <?php //echo print_r($this->db->last_query()); ?> -->

      <div class="col-md mb-3">
        <label class="form-label">Projects</label>
        <select class="form-control" data-live-search="true" name="project_id" id="aj_project" data-plugin="xin_select" data-placeholder="<?php echo $this->lang->line('left_projects'); ?>">
          <option value="0">--ALL--</option>
          <?php foreach ($all_projects as $proj) { ?>
            <option value="<?php echo $proj->project_id; ?>" <?php if ($project_karyawan == $proj->project_id) {
                                                                echo " selected";
                                                              } ?>> <?php echo $proj->title; ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="col-md mb-3">
        <!-- button submit -->
        <label class="form-label">&nbsp;</label>
        <button onclick="filter_karyawan_baru()" name="filter_karyawan_baru" id="filter_karyawan_baru" class="btn btn-primary btn-block col-12">FILTER</button>

        <!-- <button type="submit" class="btn btn-primary  btn-block">FILTER</button> -->
      </div>

    </div>
  </div>
</div>
<?php echo form_close(); ?>

<div class="row m-b-1">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all'); ?></strong> Request Karyawan Baru</span><button onclick="printExcel()" type="button" id="button_download" class="btn btn-primary ladda-button" data-style="expand-right">Download Excel</button> </div>
      <div class=" card-body">
        <div class="box-datatable table-responsive" id="btn-place">
          <table class="display dataTable table table-striped table-bordered" id="xin_table2" style="width:100%">
            <thead>
              <tr>
                <th>Aksi</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>Entitas / Project</th>
                <th>Posisi / Penempatan</th>
                <th>UMK</th>
                <th>Periode</th>
                <th>Registrasi</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>

    <?php
    //echo $this->db->last_query();
    ?>

    <!-- Script data table xin_table2 -->
    <script type="text/javascript">
      var table;

      var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
          csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

      var sub_project_id_temp;
      var jabatan_id_temp;

      var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
      var loading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
      loading_html_text = loading_html_text + '<img src="' + loading_image + '" alt="" width="60px">';
      loading_html_text = loading_html_text + '<h2>LOADING...</h2>';
      loading_html_text = loading_html_text + '</div>';

      var uploading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
      var uploading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
      uploading_html_text = uploading_html_text + '<img src="' + uploading_image + '" alt="" width="60px">';
      uploading_html_text = uploading_html_text + '<h2>PROCESSING...</h2>';
      uploading_html_text = uploading_html_text + '</div>';

      var success_image = "<?php echo base_url('assets/icon/ceklis_hijau.png'); ?>";
      var success_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
      success_html_text = success_html_text + '<img src="' + success_image + '" alt="" width="60px">';
      success_html_text = success_html_text + '<h3 style="color: #03ad42;">Berhasil Update Data...!</h3>';
      success_html_text = success_html_text + '</div>';

      $(document).ready(function() {



        var project_id = document.getElementById("aj_project").value;
        var kategori = document.getElementById("kategori").value;
        var golongan = document.getElementById("golongan").value;
        var approve = document.getElementById("approve").value;
        var idsession = "<?php print($session['employee_id']); ?>";
        //alert(approve);

        //$.fn.dataTable.moment('YYYY-MM-DD HH:mm:ss');
        table = $('#xin_table2').DataTable({
          'processing': true,
          'serverSide': true,
          'stateSave': true,
          'bFilter': true,
          'serverMethod': 'post',
          'dom': 'pPlBfrtip',
          //'columnDefs': [{
          //  targets: 11,
          //  type: 'date-eu'
          //}],
          'order': [
            [7, 'desc']
          ],
          'ajax': {
            'url': '<?= base_url() ?>admin/employee_request_hrd/request_list_hrd2',
            data: {
              [csrfName]: csrfHash,
              project_id: project_id,
              kategori: kategori,
              golongan: golongan,
              approve: approve,
              idsession: idsession
            },
          },
          'columns': [{
              data: 'aksi',
              "orderable": false
            },
            {
              data: 'nik_ktp',
              //"orderable": false
            },
            {
              data: 'fullname',
              //"orderable": false,
            },
            {
              data: 'project',
              //"orderable": false
            },
            {
              data: 'posisi',
              //"orderable": false
            },
            {
              data: 'gaji_pokok',
              // "orderable": false
            },
            {
              data: 'periode',
              // "orderable": false
            },
            {
              data: 'request_empon',
              //type: 'date-eu'
              // "orderable": false
            },
          ]
        });
        //end



        // Project modal Change -> cari jabatan dari data request man power JO
        $('#project_name_modal').change(function() {
          var project_id = $(this).val();

          // AJAX request Kota
          $.ajax({
            // url: '<?= base_url() ?>admin/Callplan/get_outlet_user_mobile_by_project',
            url: '<?= base_url() ?>admin/employee_request_hrd/get_entitas_project',
            method: 'post',
            data: {
              [csrfName]: csrfHash,
              project_id: project_id,
            },
            // dataType: 'json',
            success: function(response) {
              var res = jQuery.parseJSON(response);

              if (res['status'] == "1") {

                  $('#vendor_id_modal').val(res['data_pt'][0]['company_id']);
                  $('#vendor_name_modal').val(res['data_pt'][0]['name']);


                // -----Data Entitas-----
                $('#subproject_name_modal').find('option').not(':first').remove();
                $('#jabatan_name_modal').find('option').not(':first').remove();
                // Add options
                $.each(res['data_entitas'], function(index, data) {

                  if(data['doc_id']==1){
                    var doc_id = '[PKWT]';
                  } else {
                    var doc_id = '[TKHL]';
                  }

                  $('#subproject_name_modal').append('<option value="' + data['secid'] + '" style="text-wrap: wrap;">' + data['sub_project_name']+ ' - ' + doc_id + '</option>');
                });

              } else {
                $('#subproject_name_modal').find('option').not(':first').remove();
                $('#jabatan_name_modal').find('option').not(':first').remove();
              }
            }
          });
        });

        // Sub Project modal Change -> cari jabatan dari data request man power JO
        $('#subproject_name_modal').change(function() {
          var sub_project_id = $(this).val();
          // AJAX request Kota
          $.ajax({
            url: '<?= base_url() ?>admin/employee_request_hrd/get_posisi_subproject',
            method: 'post',
            data: {
              [csrfName]: csrfHash,
              sub_project_id: sub_project_id,
            },
            // dataType: 'json',
            success: function(response) {
              var res = jQuery.parseJSON(response);

              if (res['status'] == "1") {

                  // $('#vendor_id_modal').val(res['data_pt'][0]['company_id']);
                  // $('#vendor_name_modal').val(res['data_pt'][0]['name']);

                // -----Data Entitas-----
                $('#jabatan_name_modal').find('option').not(':first').remove();
                // Add options
                $.each(res['data_posisi'], function(index, data) {
                  $('#jabatan_name_modal').append('<option value="' + data['posisi'] + '" style="text-wrap: wrap;">' + data['designation_name']+ ' - ['+ data['level']+']' + '</option>');
                });

                  if(sub_project_id == sub_project_id_temp){
                    $('#jabatan_name_modal').val(jabatan_id_temp).change(); 
                  } else {
                    $('#jabatan_name_modal').val(0).change(); 
                  }

              } else {
                $('#jabatan_name_modal').find('option').not(':first').remove();
              }
            }
          });
        });

        $('.xin_selection').select2({
          width: "100%",
          dropdownParent: $("#container_modal_emprequest")
        });

      });

    </script>



<!-- Tombol Filter -->
<script type="text/javascript">
  function filter_karyawan_baru() {
    //ambil variable search
      
    var searchVal = $('#table').find('input').val();

    table.destroy();

        var project_id = document.getElementById("aj_project").value;
        var kategori = document.getElementById("kategori").value;
        var golongan = document.getElementById("golongan").value;
        var approve = document.getElementById("approve").value;
        var idsession = "<?php print($session['employee_id']); ?>";

    // alert(searchVal);

    // if ((range_tanggal == "")) {
    //   $('#button_download_data').attr("hidden", true);

    // } else {
    //   $('#button_download_data').attr("hidden", false);
    // }

    // $('#button_download_data').attr("hidden", false);

        table = $('#xin_table2').DataTable({
          'processing': true,
          'serverSide': true,
          'stateSave': true,
          'bFilter': true,
          'serverMethod': 'post',
          'dom': 'pPlBfrtip',
          //'columnDefs': [{
          //  targets: 11,
          //  type: 'date-eu'
          //}],
          'order': [
            [7, 'desc']
          ],
          'ajax': {
            'url': '<?= base_url() ?>admin/employee_request_hrd/request_list_hrd2',
            data: {
              [csrfName]: csrfHash,
              project_id: project_id,
              kategori: kategori,
              golongan: golongan,
              approve: approve,
              idsession: idsession
            },
          },
          'columns': [{
              data: 'aksi',
              "orderable": false
            },
            {
              data: 'nik_ktp',
              //"orderable": false
            },
            {
              data: 'fullname',
              //"orderable": false,
            },
            {
              data: 'project',
              //"orderable": false
            },
            {
              data: 'posisi',
              //"orderable": false
            },
            {
              data: 'gaji_pokok',
              // "orderable": false
            },
            {
              data: 'periode',
              // "orderable": false
            },
            {
              data: 'request_empon',
              //type: 'date-eu'
              // "orderable": false
            },
          ]
        });
        //end
        // table.search(searchVal).draw();
  };
</script>

<!-- filepond js -->
<script src="<?= base_url() ?>assets/libs/filepond/filepond.min.js"></script>
<script src="<?= base_url() ?>assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js"></script>
<script src="<?= base_url() ?>assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js"></script>
<script src="<?= base_url() ?>assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js"></script>
<script src="<?= base_url() ?>assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js"></script>
<script src="<?= base_url() ?>assets/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.js"></script>
<script src="<?= base_url() ?>assets/libs/filepond-plugin-file-rename/filepond-plugin-file-rename.js"></script>
<!-- <script src="assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.js"></script> -->

<!-- SCRIPT INITIATE VALIDATION -->
<script type=text/javascript>
  var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
  var loading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
  loading_html_text = loading_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
  loading_html_text = loading_html_text + '<h2>LOADING...</h2>';
  loading_html_text = loading_html_text + '</div>';

  var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
  var sending_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
  sending_html_text = sending_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
  sending_html_text = sending_html_text + '<h2>Sending PIN...</h2>';
  sending_html_text = sending_html_text + '</div>';

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

  //read variable
  var baseURL = "<?php echo base_url(); ?>";
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
  var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
  var user_id = "<?php print($session['user_id']); ?>";
  var user_name = "<?php print($user_info['0']->first_name); ?>";

  FilePond.registerPlugin(
    FilePondPluginFileEncode,
    FilePondPluginFileValidateType,
    FilePondPluginFileValidateSize,
    FilePondPluginFileRename,
    // FilePondPluginImageEdit,
    FilePondPluginImageExifOrientation,
    FilePondPluginImagePreview
  );

  //----------BEGIN FILEPOND EDIT DOKUMEN KARYAWAN BARU----------------------------

  //create object filepond untuk file KTP
  var pond_file_ktp_modal = FilePond.create(document.querySelector('input[id="file_ktp_modal"]'), {
    labelIdle: 'Drag & Drop file KTP atau <span class="filepond--label-action">Browse</span>',
    imagePreviewHeight: 170,
    maxFileSize: "25MB",
    // acceptedFileTypes: ['image/png', 'image/jpeg'],
    imageCropAspectRatio: "1:1",
    imageResizeTargetWidth: 200,
    imageResizeTargetHeight: 200,
    fileRenameFunction: (file) => {
      return `file_ktp${file.extension}`;
    }
  });

  //create object filepond untuk file cv
  var pond_file_cv_modal = FilePond.create(document.querySelector('input[id="file_cv_modal"]'), {
    labelIdle: 'Drag & Drop file CV atau <span class="filepond--label-action">Browse</span>',
    imagePreviewHeight: 170,
    maxFileSize: "25MB",
    // acceptedFileTypes: ['image/png', 'image/jpeg'],
    imageCropAspectRatio: "1:1",
    imageResizeTargetWidth: 200,
    imageResizeTargetHeight: 200,
    fileRenameFunction: (file) => {
      return `file_cv${file.extension}`;
    }
  });

  //create object filepond untuk file KK
  var pond_file_kk_modal = FilePond.create(document.querySelector('input[id="file_kk_modal"]'), {
    labelIdle: 'Drag & Drop file KK atau <span class="filepond--label-action">Browse</span>',
    imagePreviewHeight: 170,
    maxFileSize: "25MB",
    // acceptedFileTypes: ['image/png', 'image/jpeg'],
    imageCropAspectRatio: "1:1",
    imageResizeTargetWidth: 200,
    imageResizeTargetHeight: 200,
    fileRenameFunction: (file) => {
      return `file_kk${file.extension}`;
    }
  });

  //create object filepond untuk file skck
  var pond_file_skck_modal = FilePond.create(document.querySelector('input[id="file_skck_modal"]'), {
    labelIdle: 'Drag & Drop file SKCK atau <span class="filepond--label-action">Browse</span>',
    imagePreviewHeight: 170,
    maxFileSize: "25MB",
    // acceptedFileTypes: ['image/png', 'image/jpeg'],
    imageCropAspectRatio: "1:1",
    imageResizeTargetWidth: 200,
    imageResizeTargetHeight: 200,
    fileRenameFunction: (file) => {
      return `file_skck${file.extension}`;
    }
  });

  //create object filepond untuk file ijazah
  var pond_file_ijazah_modal = FilePond.create(document.querySelector('input[id="file_ijazah_modal"]'), {
    labelIdle: 'Drag & Drop file ijazah atau <span class="filepond--label-action">Browse</span>',
    imagePreviewHeight: 170,
    maxFileSize: "25MB",
    // acceptedFileTypes: ['image/png', 'image/jpeg'],
    imageCropAspectRatio: "1:1",
    imageResizeTargetWidth: 200,
    imageResizeTargetHeight: 200,
    fileRenameFunction: (file) => {
      return `file_ijazah${file.extension}`;
    }
  });

  //----------END FILEPOND EDIT DOKUMEN KARYAWAN BARU----------------------------

</script>


<!-- SHOW MODAL PROFILE -->
<script>
  function show_profile(secid) {
    
    if(secid==null){
      var secid = $("#id_kandidat_modal").val();
    } else {
      $('#id_kandidat_modal').val(secid);
    }
    // alert(secid);
    // alert(id_karyawan_request);
    //judul modal
    $('.judulModalProfile').html("Edit Data Diri");

        // AJAX untuk ambil data employee terupdate
        $.ajax({
            url: '<?= base_url() ?>admin/employee_request_hrd/get_data_employee_request/',
            method: 'post',
            data: {
                [csrfName]: csrfHash,
                secid: secid,
            },
            beforeSend: function() {
                // $('.info-modal-adjustment').attr("hidden", false);
                // $('.info-modal-adjustment').html(loading_html_text);
                // $('#button_save_adjustment').attr("hidden", true);
                // $('#adjustmentModal').modal('show');
            },
            success: function(response) {

                var res = jQuery.parseJSON(response);

                if (res['status'] == "1") { 

                  // var email = res['data']['email'].toLowerCase();
                  $('#id_kandidat_modal').val(secid);
                  $('#nama_lengkap_modal').val(res['data']['fullname']);
                  $('#nama_ibu_modal').val(res['data']['nama_ibu']);
                  $('#no_ktp_modal').val(res['data']['nik_ktp']);
                  $('#no_kk_modal').val(res['data']['no_kk']);
                  $('#tempat_lahir_modal').val(res['data']['tempat_lahir']);
                  $('#tanggal_lahir_modal').val(res['data']['tanggal_lahir']);
                  $('#gender_modal').val(res['data']['gender']).change();;
                  $('#agama_modal').val(res['data']['agama']).change();
                  $('#status_kawin_modal').val(res['data']['status_kawin']).change();
                  $('#no_npwp_modal').val(res['data']['npwp']);
                  $('#no_hp_modal').val(res['data']['contact_no']);
                  $('#alamat_email_modal').val(res['data']['email'].toLowerCase());

                  $('#emergency_name_modal').val(res['data']['nama']);
                  $('#emergency_kontak_modal').val(res['data']['no_kontak']);
                  $('#emergency_hubungan_modal').val(res['data']['hubungan']).change();
                  $('#project_name_modal').val(res['data']['project']).change();
                  $('#kategory_name_modal').val(res['data']['location_id']).change();
                  $('#penempatan_modal').val(res['data']['penempatan']);
                  $('#penempatan_kerja_modal').val(res['data']['region_name']);
                  $('#region_name_modal').val(res['data']['region']);
                  $('#dc_name_modal').val(res['data']['dc_name']);
                  $('#tanggal_join_modal').val(res['data']['doj']);
                  $('#tanggal_mulai_modal').val(res['data']['contract_start']);
                  $('#tanggal_akhir_modal').val(res['data']['contract_end']);
                  $('#waktu_kontrak_modal').val(res['data']['contract_periode']).change();
                  $('#cut_off_modal').val(res['data']['cut_start']+'/'+res['data']['cut_off']);
                  $('#hari_kerja_model').val(res['data']['hari_kerja']);
                  $('#tanggal_penggajian_modal').val(res['data']['date_payment']);


                  sub_project_id_temp = res['data']['sub_project'];
                  jabatan_id_temp = res['data']['posisi'];

                  $('#gaji_pokok_modal').val(formatRupiahInput(res['data']['gaji_pokok'])); 

                  $('#allow_jabatan_modal').val(formatRupiahInput(res['data']['allow_jabatan'])); 
                  $('#dm_allow_jabatan').val(res['data']['dm_allow_jabatan']).change();

                  $('#allow_area_modal').val(formatRupiahInput(res['data']['allow_area'])); 
                  $('#dm_allow_area').val(res['data']['dm_allow_area']).change();


                  $('#allow_makan_modal').val(formatRupiahInput(res['data']['allow_konsumsi'])); 
                  $('#dm_allow_makan').val(res['data']['dm_allow_konsumsi']).change();

                  $('#allow_transport_modal').val(formatRupiahInput(res['data']['allow_transport'])); 
                  $('#dm_allow_transport').val(res['data']['dm_allow_transport']).change();

                  $('#allow_kom_modal').val(formatRupiahInput(res['data']['allow_comunication'])); 
                  $('#dm_allow_kom').val(res['data']['dm_allow_comunication']).change();


                  $('#allow_device_modal').val(formatRupiahInput(res['data']['allow_device'])); 
                  $('#dm_allow_device').val(res['data']['dm_allow_device']).change();

                  $('#allow_parkir_modal').val(formatRupiahInput(res['data']['allow_parking'])); 
                  $('#dm_allow_parkir').val(res['data']['dm_allow_park']).change();

                  $('#allow_akomodasi_modal').val(formatRupiahInput(res['data']['allow_akomodsasi'])); 
                  $('#dm_allow_akomodasi').val(res['data']['dm_allow_akomodasi']).change();


                  $('#allow_rental_modal').val(formatRupiahInput(res['data']['allow_rent'])); 
                  $('#dm_allow_rental').val(res['data']['dm_allow_rent']).change();

                  $('#allow_masa_modal').val(formatRupiahInput(res['data']['allow_masakerja'])); 
                  $('#dm_allow_masa').val(res['data']['dm_allow_masakerja']).change();

                  $('#allow_tempattinggal_modal').val(formatRupiahInput(res['data']['allow_residence_cost'])); 
                  $('#dm_allow_tempattinggal').val(res['data']['dm_allow_residance']).change();

                  $('#allow_transmeal_modal').val(formatRupiahInput(res['data']['allow_trans_meal'])); 
                  $('#dm_allow_transmeal').val(res['data']['dm_allow_transmeal']).change();

                  $('#allow_transrent_modal').val(formatRupiahInput(res['data']['allow_trans_rent'])); 
                  $('#dm_allow_transrent').val(res['data']['dm_allow_transrent']).change();

                  $('#allow_medicine_modal').val(formatRupiahInput(res['data']['allow_medicine'])); 
                  $('#dm_allow_medicine').val(res['data']['dm_allow_medicine']).change();

                  $('#allow_grooming_modal').val(formatRupiahInput(res['data']['allow_grooming'])); 
                  $('#dm_allow_grooming').val(res['data']['dm_allow_grooming']).change();

                  $('#allow_kehadiran_modal').val(formatRupiahInput(res['data']['allow_kehadiran'])); 
                  $('#dm_allow_kehadiran').val(res['data']['dm_allow_kehadiran']).change();

                  $('#allow_disiplin_modal').val(formatRupiahInput(res['data']['allow_disiplin'])); 
                  $('#dm_allow_disiplin').val(res['data']['dm_allow_disiplin']).change();

                  $('#allow_training_modal').val(formatRupiahInput(res['data']['allow_training'])); 
                  $('#dm_allow_training').val(res['data']['dm_allow_training']).change();

                  $('#allow_keahlian_modal').val(formatRupiahInput(res['data']['allow_skill'])); 
                  $('#dm_allow_keahlian').val(res['data']['dm_allow_skill']).change();

                  $('#allow_kinerja_modal').val(formatRupiahInput(res['data']['allow_kinerja'])); 
                  $('#dm_allow_kinerja').val(res['data']['dm_allow_kinerja']).change();

                  $('#allow_pph_modal').val(formatRupiahInput(res['data']['allow_pph'])); 
                  $('#dm_allow_pph').val(res['data']['dm_allow_pph']).change();

                  $('#allow_operational_modal').val(formatRupiahInput(res['data']['allow_operational'])); 
                  $('#dm_allow_operational').val(res['data']['dm_allow_operational']).change();

                  $('#allow_other_modal').val(formatRupiahInput(res['data']['allow_others'])); 
                  $('#dm_allow_other').val(res['data']['dm_allow_others']).change();

                } else {
                    html_text = res['pesan'];
                    // $('.info-modal-adjustment').html(html_text);
                    // $('.isi-modal-edit-interviewer').attr("hidden", true);
                    // $('.info-modal-adjustment').attr("hidden", false);
                    $('#button_save_profile').attr("hidden", true);
                }

            },
            error: function(xhr, status, error) {
                html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
                html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
                // html_text = "Gagal fetch data. Kode error: " + xhr.status;
                // $('.info-modal-adjustment').html(html_text); //coba pake iframe
                // $('.isi-modal-edit-interviewer').attr("hidden", true);
                // $('.info-modal-adjustment').attr("hidden", false);
                // $('#button_save_adjustment').attr("hidden", true);
            }
        });


    //hidden tombol navigasi
    $('#navigasi_profile').attr("hidden", false);

    //aktivasi tab
    $('#edit-profile-nav').addClass('active');
    $('#edit-profile-tab').addClass('active');
    $('#edit-profile-tab').addClass('show');

    $('#edit-project-nav').removeClass('active');
    $('#edit-project-tab').removeClass('active');
    $('#edit-project-tab').removeClass('show');
    $('#edit-rekening-nav').removeClass('active');
    $('#edit-rekening-tab').removeClass('active');
    $('#edit-rekening-tab').removeClass('show');
    $('#edit-dokumen-nav').removeClass('active');
    $('#edit-dokumen-tab').removeClass('active');
    $('#edit-dokumen-tab').removeClass('show');
    $('#edit-upah-nav').removeClass('active');
    $('#edit-upah-tab').removeClass('active');
    $('#edit-upah-tab').removeClass('show');


    $('.info-modal-edit-outlet').attr("hidden", true);
    $('.isi-modal-edit-outlet').attr("hidden", false);
    $('#button_save_profile').attr("hidden", false);
    $('#button_save_project').attr("hidden", true);
    $('#button_save_rekening').attr("hidden", true);
    $('#button_save_dokumen').attr("hidden", true);
    $('#button_save_upah').attr("hidden", true);
    $('#button_delete_outlet').attr("hidden", true);
    $('#editProfileModal').appendTo('body').modal('show');
    // $('#editProfileModal').appendTo("body").modal('show');
  }
</script>

<!-- SHOW PROJECT -->
<script>
  function show_project() {
    // alert(id);

    //judul modal
    $('.judulModalProfile').html("Edit Project");




    //inisialisasi variabel
    // $('#link_file_excel').val("");
    // $('#tipe_file_excel').val("");
    array_data_import = "";
    jumlah_data_import = 0;
    // pond_outlet.removeFile();

    //inisialisasi pesan
    $('#pesan_file_excel').html("");

    //hidden tombol navigasi
    $('#navigasi_add_outlet').attr("hidden", false);

    //aktivasi tab
    $('#edit-project-nav').addClass('active');
    $('#edit-project-tab').addClass('active');
    $('#edit-project-tab').addClass('show');

    $('#edit-profile-nav').removeClass('active');
    $('#edit-profile-tab').removeClass('active');
    $('#edit-profile-tab').removeClass('show');
    $('#edit-rekening-nav').removeClass('active');
    $('#edit-rekening-tab').removeClass('active');
    $('#edit-rekening-tab').removeClass('show');
    $('#edit-dokumen-nav').removeClass('active');
    $('#edit-dokumen-tab').removeClass('active');
    $('#edit-dokumen-tab').removeClass('show');
    $('#edit-upah-nav').removeClass('active');
    $('#edit-upah-tab').removeClass('active');
    $('#edit-upah-tab').removeClass('show');

    $('#subproject_name_modal').val(sub_project_id_temp).change();

    $('.info-modal-edit-outlet').attr("hidden", true);
    $('.isi-modal-edit-outlet').attr("hidden", false);
    $('#button_save_project').attr("hidden", false);
    $('#button_save_profile').attr("hidden", true);
    $('#button_save_dokumen').attr("hidden", true);
    $('#button_save_rekening').attr("hidden", true);
    $('#button_save_upah').attr("hidden", true);
    $('#button_delete_outlet').attr("hidden", true);
    $('#editProfileModal').modal('show');
  }
</script>

<!-- SHOW REKENING -->
<script>
  function show_rekening() {
    // alert(id);

    //judul modal
    $('.judulModalProfile').html("Verifikasi Rekening");

    //inisialisasi variabel
    // $('#link_file_excel').val("");
    // $('#tipe_file_excel').val("");
    array_data_import = "";
    jumlah_data_import = 0;
    //inisialisasi pesan
    //DEFINISI VERIFIKASI
    var id_karyawan_request = $("#id_kandidat_modal").val();
    $('#id_kandidat_modal').val(id_karyawan_request);
    $('#pesan_file_excel').html("");
    var user_role = <?php echo $user[0]->user_role_id; ?>;




    //inisialisasi input
    $("#bank_modal").val("").change();
    $('#rekening_modal').val("");
    $('#pemilik_rekening_modal').val("");

    //inisialisasi attribut input
    $('#bank_modal').prop('disabled', false);
    $('#rekening_modal').prop('readonly', false);
    $('#pemilik_rekening_modal').prop('readonly', false);

    //inisialisasi pesan
    $('#pesan_bank_verifikasi_modal').html("");
    $('#pesan_norek_verifikasi_modal').html("");
    $('#pesan_pemilik_rekening_verifikasi_modal').html("");

    //inisialisasi button verifikasi
    $('#button_verify_bank_modal').html("");
    $('#button_unverify_bank_modal').html("");
    $('#button_verify_norek_modal').html("");
    $('#button_unverify_norek_modal').html("");
    $('#button_verify_pemilik_rek_modal').html("");
    $('#button_unverify_pemilik_rek_modal').html("");

    // AJAX untuk ambil data employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_diri_request/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_karyawan_request: id_karyawan_request,
      },
      beforeSend: function() {
        $('.info-modal-rekening').attr("hidden", false);
        $('.isi-modal-rekening').attr("hidden", true);
        $('.info-modal-rekening').html(loading_html_text);
        $('#verifikasiModal').appendTo("body").modal('show');
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          //isi value
          // $('#nik_modal_sebelum_verifikasi').val(res['data']['nik_ktp']);
          // $("#kk_modal_sebelum").val(res['data']['no_kk']);
          // $('#nama_modal_sebelum').val(res['data']['fullname']);
          $("#bank_modal_sebelum").val(res['data']['bank_id']).change();
          $('#rekening_modal_sebelum').val(res['data']['no_rek']);
          $('#pemilik_rekening_modal_sebelum').val(res['data']['pemilik_rekening']);

          // $('#nik_modal_verifikasi').val(res['data']['nik_ktp']);
          // $("#kk_modal").val(res['data']['no_kk']);
          // $('#nama_modal').val(res['data']['fullname']);
          $("#bank_modal").val(res['data']['bank_id']).change();
          $('#rekening_modal').val(res['data']['no_rek']);
          $('#pemilik_rekening_modal').val(res['data']['pemilik_rekening']);

          //isi dokumen
          $.ajax({
            url: '<?= base_url() ?>admin/Employees/get_data_dokumen_pribadi_request/',
            method: 'post',
            data: {
              [csrfName]: csrfHash,
              id_karyawan_request: id_karyawan_request,
            },
            // beforeSend: function() {
            //  $('.ktp-modal').html(loading_html_text);
            // },
            success: function(response) {

              var res2 = jQuery.parseJSON(response);
              //BANK
              if (res['data']['bank_validation'] == "0") {
                //button
                $('#button_verify_bank_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'bank\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

                $('#button_unverify_bank_modal').html('');

                //icon
                $('.icon-verify-bank').html(res['data']['validate_bank']);

                //attribut input
                $('#bank_modal').prop('disabled', false);
              } else {
                //button
                $('#button_verify_bank_modal').html('');
                if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
                  $('#button_unverify_bank_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'bank\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
                } else {
                  $('#button_unverify_bank_modal').html('');
                }

                //icon
                $('.icon-verify-bank').html(res['data']['validate_bank']);

                //attribut input
                $('#bank_modal').prop('disabled', true);
              }

              //NOMOR REKENING
              if (res['data']['norek_validation'] == "0") {
                //button
                $('#button_verify_norek_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'norek\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

                $('#button_unverify_norek_modal').html('');

                //icon
                $('.icon-verify-norek').html(res['data']['validate_norek']);

                //attribut input
                $('#rekening_modal').prop('readonly', false);
              } else {
                //button
                $('#button_verify_norek_modal').html('');
                if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
                  $('#button_unverify_norek_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'norek\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
                } else {
                  $('#button_unverify_norek_modal').html('');
                }

                //icon
                $('.icon-verify-norek').html(res['data']['validate_norek']);

                //attribut input
                $('#rekening_modal').prop('readonly', true);
              }

              //PEMILIK REKENING
              if (res['data']['pemilik_rekening_validation'] == "0") {
                //button
                $('#button_verify_pemilik_rek_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'pemilik_rekening\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

                $('#button_unverify_pemilik_rek_modal').html('');

                //icon
                $('.icon-verify-pemilik-rek').html(res['data']['validate_pemilik_rekening']);

                //attribut input
                $('#pemilik_rekening_modal').prop('readonly', false);
              } else {
                //button
                $('#button_verify_pemilik_rek_modal').html('');
                if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
                  $('#button_unverify_pemilik_rek_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'pemilik_rekening\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
                } else {
                  $('#button_unverify_pemilik_rek_modal').html('');
                }

                //icon
                $('.icon-verify-pemilik-rek').html(res['data']['validate_pemilik_rekening']);

                //attribut input
                $('#pemilik_rekening_modal').prop('readonly', true);
              }

                //icon
                $('.icon-verify-file-ijazah').html(res['data']['validate_ijazah']);

                //attribut input
                $('#file_ijazah_modal').prop("hidden", true);
            

              //display isi modal
              $('.isi-modal-rekening').attr("hidden", false);
              $('.info-modal-rekening').attr("hidden", true);
            },
            error: function(xhr, status, error) {
              var html_text = '<strong>ERROR LOAD FILE</strong>';
              // $('.display_file_ktp_modal').html(html_text);
              // $('.display_file_kk_modal').html(html_text);
              // $('.display_file_cv_modal').html(html_text);
              // $('.display_file_skck_modal').html(html_text);
              // $('.display_file_ijazah_modal').html(html_text);

              //display isi modal
              $('.isi-modal-rekening').attr("hidden", false);
              $('.info-modal-rekening').attr("hidden", true);
            }
          });
        } else {
          html_text = res['pesan'];
          $('.info-modal-rekening').html(html_text);
          $('.isi-modal-rekening').attr("hidden", true);
          $('.info-modal-rekening').attr("hidden", false);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-rekening').html(html_text); //coba pake iframe
        $('.isi-modal-rekening').attr("hidden", true);
        $('.info-modal-rekening').attr("hidden", false);
      }
    });

    //inisialisasi pesan
    $('#pesan_file_excel').html("");

    //hidden tombol navigasi
    // $('#navigasi_add_outlet').attr("hidden", false);

    //aktivasi tab
    $('#edit-rekening-nav').addClass('active');
    $('#edit-rekening-tab').addClass('active');
    $('#edit-rekening-tab').addClass('show');

    $('#edit-profile-nav').removeClass('active');
    $('#edit-profile-tab').removeClass('active');
    $('#edit-profile-tab').removeClass('show');
    $('#edit-project-nav').removeClass('active');
    $('#edit-project-tab').removeClass('active');
    $('#edit-project-tab').removeClass('show');
    $('#edit-dokumen-nav').removeClass('active');
    $('#edit-dokumen-tab').removeClass('active');
    $('#edit-dokumen-tab').removeClass('show');
    $('#edit-upah-nav').removeClass('active');
    $('#edit-upah-tab').removeClass('active');
    $('#edit-upah-tab').removeClass('show');

    $('.info-modal-edit-outlet').attr("hidden", true);
    $('.isi-modal-edit-outlet').attr("hidden", false);
    $('#button_save_rekening').attr("hidden", true);
    $('#button_save_profile').attr("hidden", true);
    $('#button_save_project').attr("hidden", true);
    $('#button_save_dokumen').attr("hidden", true);
    $('#button_save_upah').attr("hidden", true);
    $('#button_delete_outlet').attr("hidden", true);
    $('#editProfileModal').modal('show');
  }
</script>

<!-- SHOW DOKUMEN -->
<script>
  function show_dokumen() {
    // alert(id);

    //judul modal
    $('.judulModalProfile').html("Edit Dokumen");

    //inisialisasi variabel
    // $('#link_file_excel').val("");
    // $('#tipe_file_excel').val("");
    array_data_import = "";
    jumlah_data_import = 0;
    // pond_outlet.removeFile();


    //Display dokumen
    var id_karyawan_request = $("#id_kandidat_modal").val();
    //isi dokumen
    // alert(id_karyawan_request);
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_dokumen_pribadi_request/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_karyawan_request: id_karyawan_request,
      },
      beforeSend: function() {
        $('.display_file_ktp_modal').html(loading_html_text);
        // $('.display_file_kk_modal').html(loading_html_text);
        // $('.display_file_cv_modal').html(loading_html_text);
        // $('.display_file_skck_modal').html(loading_html_text);
        // $('.display_file_ijazah_modal').html(loading_html_text);
        // $('.display_file_npwp_modal').html(loading_html_text);
      },
      success: function(response) {

        var res2 = jQuery.parseJSON(response);

        //dokumen KTP
        if (res2['status']['filename_ktp'] == "200") {
          var nama_file = res2['data']['filename_ktp'];
          var tipe_file = nama_file.substr(-3, 3);
          var atribut = "";
          var height = '';
          var d = new Date();
          var time = d.getTime();
          nama_file = nama_file + "?" + time;

          if (tipe_file == "pdf") {
            atribut = "application/pdf";
            // height = 'height="500px"';
          } else {
            atribut = "image/jpg";
          }

          var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
          $('.display_file_ktp_modal').html(html_text);
        } else {
          var html_text = '<strong>' + res2['pesan']['filename_ktp'] + '</strong>';
          $('.display_file_ktp_modal').html(html_text);
        }

      },
      error: function(xhr, status, error) {
        var html_text = '<strong>ERROR LOAD FILE</strong>';
        $('.display_file_ktp_modal').html(html_text);
        $('.display_file_kk_modal').html(html_text);
        $('.display_file_cv_modal').html(html_text);
        $('.display_file_skck_modal').html(html_text);
        $('.display_file_ijazah_modal').html(html_text);
        $('.display_file_npwp_modal').html(html_text);

        //display isi modal
        $('.isi-modal-verifikasi').attr("hidden", false);
        $('.info-modal-verifikasi').attr("hidden", true);
      }
    });

    //inisialisasi pesan
    $('#pesan_file_excel').html("");



    //DEFINISI VERIFIKASI


    var user_role = <?php echo $user[0]->user_role_id; ?>;

    //inisialisasi input
    $('#nik_modal_verifikasi').val("");
    $("#kk_modal").val("");
    $('#nama_modal').val("");
    $("#bank_modal").val("").change();
    $('#rekening_modal').val("");
    $('#pemilik_rekening_modal').val("");

    $('#link_file_ktp_modal').val("");
    $('#link_file_kk_modal').val("");
    $('#link_file_cv_modal').val("");
    $('#link_file_skck_modal').val("");
    $('#link_file_ijazah_modal').val("");

    //inisialisasi attribut input
    $('#file_ktp_modal').prop("hidden", false);
    $('#file_kk_modal').prop("hidden", false);
    $('#file_cv_modal').prop("hidden", false);
    $('#file_skck_modal').prop("hidden", false);
    $('#file_ijazah_modal').prop("hidden", false);

    $('#nik_modal_verifikasi').prop('readonly', false);
    $('#kk_modal').prop('readonly', false);
    $('#nama_modal').prop('readonly', false);
    $('#bank_modal').prop('disabled', false);
    $('#rekening_modal').prop('readonly', false);
    $('#pemilik_rekening_modal').prop('readonly', false);

    //inisialisasi pesan
    $('#pesan_nik_verifikasi_modal').html("");
    $('#pesan_kk_verifikasi_modal').html("");
    $('#pesan_nama_verifikasi_modal').html("");
    $('#pesan_bank_verifikasi_modal').html("");
    $('#pesan_norek_verifikasi_modal').html("");
    $('#pesan_pemilik_rekening_verifikasi_modal').html("");

    $('#pesan_file_ktp_modal').html("");
    $('#pesan_file_kk_modal').html("");
    $('#pesan_file_cv_modal').html("");
    $('#pesan_file_skck_modal').html("");
    $('#pesan_file_ijazah_modal').html("");

    //inisialisasi button verifikasi
    $('#button_verify_file_ktp_modal').html("");
    $('#button_unverify_file_ktp_modal').html("");
    $('#button_verify_nik_modal').html("");
    $('#button_unverify_nik_modal').html("");
    $('#button_verify_nama_modal').html("");
    $('#button_unverify_nama_modal').html("");
    $('#button_verify_file_kk_modal').html("");
    $('#button_unverify_file_kk_modal').html("");
    $('#button_verify_kk_modal').html("");
    $('#button_unverify_kk_modal').html("");
    $('#button_verify_bank_modal').html("");
    $('#button_unverify_bank_modal').html("");
    $('#button_verify_norek_modal').html("");
    $('#button_unverify_norek_modal').html("");
    $('#button_verify_pemilik_rek_modal').html("");
    $('#button_unverify_pemilik_rek_modal').html("");
    $('#button_verify_file_cv_modal').html("");
    $('#button_unverify_file_cv_modal').html("");
    $('#button_verify_file_skck_modal').html("");
    $('#button_unverify_file_skck_modal').html("");
    $('#button_verify_file_ijazah_modal').html("");
    $('#button_unverify_file_ijazah_modal').html("");



    // AJAX untuk ambil data employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/get_data_diri_request/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_karyawan_request: id_karyawan_request,
      },
      beforeSend: function() {
        $('.info-modal-verifikasi').attr("hidden", false);
        $('.isi-modal-verifikasi').attr("hidden", true);
        $('.info-modal-verifikasi').html(loading_html_text);
        $('#verifikasiModal').appendTo("body").modal('show');
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          //isi value
          $('#nik_modal_sebelum_verifikasi').val(res['data']['nik_ktp']);
          $("#kk_modal_sebelum").val(res['data']['no_kk']);
          $('#nama_modal_sebelum').val(res['data']['fullname']);
          $("#bank_modal_sebelum").val(res['data']['bank_id']).change();
          $('#rekening_modal_sebelum').val(res['data']['no_rek']);
          $('#pemilik_rekening_modal_sebelum').val(res['data']['pemilik_rekening']);

          $('#nik_modal_verifikasi').val(res['data']['nik_ktp']);
          $("#kk_modal").val(res['data']['no_kk']);
          $('#nama_modal').val(res['data']['fullname']);
          $("#bank_modal").val(res['data']['bank_id']).change();
          $('#rekening_modal').val(res['data']['no_rek']);
          $('#pemilik_rekening_modal').val(res['data']['pemilik_rekening']);

          //isi dokumen
          $.ajax({
            url: '<?= base_url() ?>admin/Employees/get_data_dokumen_pribadi_request/',
            method: 'post',
            data: {
              [csrfName]: csrfHash,
              id_karyawan_request: id_karyawan_request,
            },
            // beforeSend: function() {
            //  $('.ktp-modal').html(loading_html_text);
            // },
            success: function(response) {

              var res2 = jQuery.parseJSON(response);

              //dokumen KTP
              if (res2['status']['filename_ktp'] == "200") {
                var nama_file = res2['data']['filename_ktp'];
                $('#link_file_ktp_sebelum_modal').val(res2['database_record']['filename_ktp']);
                $('#link_file_ktp_modal').val(res2['database_record']['filename_ktp']);
                var tipe_file = nama_file.substr(-3, 3);
                var atribut = "";
                var height = '';
                var d = new Date();
                var time = d.getTime();
                nama_file = nama_file + "?" + time;

                if (tipe_file == "pdf") {
                  atribut = "application/pdf";
                  // height = 'height="500px"';
                } else {
                  atribut = "image/jpg";
                }

                var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
                $('.display_file_ktp_modal').html(html_text);
              } else {
                $('#link_file_ktp_sebelum_modal').val(res2['database_record']['filename_ktp']);
                var html_text = '<strong>' + res2['pesan']['filename_ktp'] + '</strong>';
                $('.display_file_ktp_modal').html(html_text);
              }

              //append nip dan identifier ke objek filepond file ktp
              pond_file_ktp_modal.setOptions({
                server: {
                  process: {
                    url: '<?php echo base_url() ?>admin/Employees/upload_dokumen_request',
                    method: 'POST',
                    ondata: (formData) => {
                      formData.append('id_karyawan_request', id_karyawan_request);
                      formData.append('identifier', 'ktp');
                      formData.append([csrfName], csrfHash);
                      return formData;
                    },
                    onload: (res) => {
                      // select the right value in the response here and return
                      // return res;
                      var serverResponse = jQuery.parseJSON(res);

                      //display file
                      if ((serverResponse['0']['link_file'] == null) || (serverResponse['0']['link_file'] == "")) {
                        //do nothing
                      } else {
                        var nama_file = '<?= base_url("uploads/document/ktp/") ?>' + serverResponse['0']['link_file'];
                        var tipe_file = nama_file.slice(-3);
                        var atribut = "";
                        var height = '';
                        var d = new Date();
                        var time = d.getTime();
                        nama_file = nama_file + "?" + time;

                        if (tipe_file == "pdf") {
                          atribut = "application/pdf";
                          // height = 'height="500px"';
                        } else {
                          atribut = "image/jpg";
                        }

                        var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
                        $('.display_file_ktp_modal').html(html_text);

                        $('#link_file_ktp_modal').val(serverResponse['0']['link_file']);

                        // alert($('#link_file_ktp_modal').val());

                        pond_file_ktp_modal.removeFile();
                      }
                    }
                  }
                }
              });

              //dokumen KK
              if (res2['status']['filename_kk'] == "200") {
                var nama_file = res2['data']['filename_kk'];
                $('#link_file_kk_sebelum_modal').val(res2['database_record']['filename_kk']);
                $('#link_file_kk_modal').val(res2['database_record']['filename_kk']);
                var tipe_file = nama_file.substr(-3, 3);
                var atribut = "";
                var height = '';
                var d = new Date();
                var time = d.getTime();
                nama_file = nama_file + "?" + time;

                if (tipe_file == "pdf") {
                  atribut = "application/pdf";
                  // height = 'height="500px"';
                } else {
                  atribut = "image/jpg";
                }

                var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
                $('.display_file_kk_modal').html(html_text);
              } else {
                $('#link_file_kk_sebelum_modal').val(res2['database_record']['filename_kk']);
                var html_text = '<strong>' + res2['pesan']['filename_kk'] + '</strong>';
                $('.display_file_kk_modal').html(html_text);
              }

              //append nip dan identifier ke objek filepond file kk
              pond_file_kk_modal.setOptions({
                server: {
                  process: {
                    url: '<?php echo base_url() ?>admin/Employees/upload_dokumen_request',
                    method: 'POST',
                    ondata: (formData) => {
                      formData.append('id_karyawan_request', id_karyawan_request);
                      formData.append('identifier', 'kk');
                      formData.append([csrfName], csrfHash);
                      return formData;
                    },
                    onload: (res) => {
                      // select the right value in the response here and return
                      // return res;
                      var serverResponse = jQuery.parseJSON(res);

                      //display file
                      if ((serverResponse['0']['link_file'] == null) || (serverResponse['0']['link_file'] == "")) {
                        //do nothing
                      } else {
                        var nama_file = '<?= base_url("uploads/document/kk/") ?>' + serverResponse['0']['link_file'];
                        var tipe_file = nama_file.slice(-3);
                        var atribut = "";
                        var height = '';
                        var d = new Date();
                        var time = d.getTime();
                        nama_file = nama_file + "?" + time;

                        if (tipe_file == "pdf") {
                          atribut = "application/pdf";
                          // height = 'height="500px"';
                        } else {
                          atribut = "image/jpg";
                        }

                        var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
                        $('.display_file_kk_modal').html(html_text);

                        $('#link_file_kk_modal').val(serverResponse['0']['link_file']);

                        // alert($('#link_file_kk_modal').val());

                        pond_file_kk_modal.removeFile();
                      }
                    }
                  }
                }
              });

              //dokumen CV
              if (res2['status']['filename_cv'] == "200") {
                var nama_file = res2['data']['filename_cv'];
                $('#link_file_cv_sebelum_modal').val(res2['database_record']['filename_cv']);
                $('#link_file_cv_modal').val(res2['database_record']['filename_cv']);
                var tipe_file = nama_file.substr(-3, 3);
                var atribut = "";
                var height = '';
                var d = new Date();
                var time = d.getTime();
                nama_file = nama_file + "?" + time;

                if (tipe_file == "pdf") {
                  atribut = "application/pdf";
                  // height = 'height="500px"';
                } else {
                  atribut = "image/jpg";
                }

                var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
                $('.display_file_cv_modal').html(html_text);
              } else {
                $('#link_file_cv_sebelum_modal').val(res2['database_record']['filename_cv']);
                var html_text = '<strong>' + res2['pesan']['filename_cv'] + '</strong>';
                $('.display_file_cv_modal').html(html_text);
              }

              //append nip dan identifier ke objek filepond file cv
              pond_file_cv_modal.setOptions({
                server: {
                  process: {
                    url: '<?php echo base_url() ?>admin/Employees/upload_dokumen_request',
                    method: 'POST',
                    ondata: (formData) => {
                      formData.append('id_karyawan_request', id_karyawan_request);
                      formData.append('identifier', 'cv');
                      formData.append([csrfName], csrfHash);
                      return formData;
                    },
                    onload: (res) => {
                      // select the right value in the response here and return
                      // return res;
                      var serverResponse = jQuery.parseJSON(res);

                      //display file
                      if ((serverResponse['0']['link_file'] == null) || (serverResponse['0']['link_file'] == "")) {
                        //do nothing
                      } else {
                        var nama_file = '<?= base_url("uploads/document/cv/") ?>' + serverResponse['0']['link_file'];
                        var tipe_file = nama_file.slice(-3);
                        var atribut = "";
                        var height = '';
                        var d = new Date();
                        var time = d.getTime();
                        nama_file = nama_file + "?" + time;

                        if (tipe_file == "pdf") {
                          atribut = "application/pdf";
                          // height = 'height="500px"';
                        } else {
                          atribut = "image/jpg";
                        }

                        var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
                        $('.display_file_cv_modal').html(html_text);

                        $('#link_file_cv_modal').val(serverResponse['0']['link_file']);

                        // alert($('#link_file_cv_modal').val());

                        pond_file_cv_modal.removeFile();
                      }
                    }
                  }
                }
              });

              //dokumen SKCK
              if (res2['status']['filename_skck'] == "200") {
                var nama_file = res2['data']['filename_skck'];
                $('#link_file_skck_sebelum_modal').val(res2['database_record']['filename_skck']);
                $('#link_file_skck_modal').val(res2['database_record']['filename_skck']);
                var tipe_file = nama_file.substr(-3, 3);
                var atribut = "";
                var height = '';
                var d = new Date();
                var time = d.getTime();
                nama_file = nama_file + "?" + time;

                if (tipe_file == "pdf") {
                  atribut = "application/pdf";
                  // height = 'height="500px"';
                } else {
                  atribut = "image/jpg";
                }

                var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
                $('.display_file_skck_modal').html(html_text);
              } else {
                $('#link_file_skck_sebelum_modal').val(res2['database_record']['filename_skck']);
                var html_text = '<strong>' + res2['pesan']['filename_skck'] + '</strong>';
                $('.display_file_skck_modal').html(html_text);
              }

              //append nip dan identifier ke objek filepond file skck
              pond_file_skck_modal.setOptions({
                server: {
                  process: {
                    url: '<?php echo base_url() ?>admin/Employees/upload_dokumen_request',
                    method: 'POST',
                    ondata: (formData) => {
                      formData.append('id_karyawan_request', id_karyawan_request);
                      formData.append('identifier', 'skck');
                      formData.append([csrfName], csrfHash);
                      return formData;
                    },
                    onload: (res) => {
                      // select the right value in the response here and return
                      // return res;
                      var serverResponse = jQuery.parseJSON(res);

                      //display file
                      if ((serverResponse['0']['link_file'] == null) || (serverResponse['0']['link_file'] == "")) {
                        //do nothing
                      } else {
                        var nama_file = '<?= base_url("uploads/document/skck/") ?>' + serverResponse['0']['link_file'];
                        var tipe_file = nama_file.slice(-3);
                        var atribut = "";
                        var height = '';
                        var d = new Date();
                        var time = d.getTime();
                        nama_file = nama_file + "?" + time;

                        if (tipe_file == "pdf") {
                          atribut = "application/pdf";
                          // height = 'height="500px"';
                        } else {
                          atribut = "image/jpg";
                        }

                        var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
                        $('.display_file_skck_modal').html(html_text);

                        $('#link_file_skck_modal').val(serverResponse['0']['link_file']);

                        // alert($('#link_file_skck_modal').val());

                        pond_file_skck_modal.removeFile();
                      }
                    }
                  }
                }
              });

              //dokumen Ijazah
              if (res2['status']['filename_isd'] == "200") {
                var nama_file = res2['data']['filename_isd'];
                $('#link_file_ijazah_sebelum_modal').val(res2['database_record']['filename_isd']);
                $('#link_file_ijazah_modal').val(res2['database_record']['filename_isd']);
                var tipe_file = nama_file.substr(-3, 3);
                var atribut = "";
                var height = '';
                var d = new Date();
                var time = d.getTime();
                nama_file = nama_file + "?" + time;

                if (tipe_file == "pdf") {
                  atribut = "application/pdf";
                  // height = 'height="500px"';
                } else {
                  atribut = "image/jpg";
                }

                var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
                $('.display_file_ijazah_modal').html(html_text);
              } else {
                $('#link_file_ijazah_sebelum_modal').val(res2['database_record']['filename_isd']);
                var html_text = '<strong>' + res2['pesan']['filename_isd'] + '</strong>';
                $('.display_file_ijazah_modal').html(html_text);
              }

              //append nip dan identifier ke objek filepond file ijazah
              pond_file_ijazah_modal.setOptions({
                server: {
                  process: {
                    url: '<?php echo base_url() ?>admin/Employees/upload_dokumen_request',
                    method: 'POST',
                    ondata: (formData) => {
                      formData.append('id_karyawan_request', id_karyawan_request);
                      formData.append('identifier', 'ijazah');
                      formData.append([csrfName], csrfHash);
                      return formData;
                    },
                    onload: (res) => {
                      // select the right value in the response here and return
                      // return res;
                      var serverResponse = jQuery.parseJSON(res);

                      //display file
                      if ((serverResponse['0']['link_file'] == null) || (serverResponse['0']['link_file'] == "")) {
                        //do nothing
                      } else {
                        var nama_file = '<?= base_url("uploads/document/ijazah/") ?>' + serverResponse['0']['link_file'];
                        var tipe_file = nama_file.slice(-3);
                        var atribut = "";
                        var height = '';
                        var d = new Date();
                        var time = d.getTime();
                        nama_file = nama_file + "?" + time;

                        if (tipe_file == "pdf") {
                          atribut = "application/pdf";
                          // height = 'height="500px"';
                        } else {
                          atribut = "image/jpg";
                        }

                        var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
                        $('.display_file_ijazah_modal').html(html_text);

                        $('#link_file_ijazah_modal').val(serverResponse['0']['link_file']);

                        // alert($('#link_file_ijazah_modal').val());

                        pond_file_ijazah_modal.removeFile();
                      }
                    }
                  }
                }
              });

              //assign button verifikasi sesuai status verifikasi
              //file KTP
              if (res['data']['dokumen_ktp_validation'] == "0") {
                //button
                $('#button_verify_file_ktp_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'dokumen_ktp\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');
                // if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
                //  $('#button_unverify_file_ktp_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'dokumen_ktp\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
                // } else {
                $('#button_unverify_file_ktp_modal').html('');
                // }

                //icon
                $('.icon-verify-file-ktp').html(res['data']['validate_dokumen_ktp']);

                //attribut input
                $('#file_ktp_modal').prop("hidden", false);
              } else {
                //button
                $('#button_verify_file_ktp_modal').html('');
                if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
                  // alert("button ada isinya");
                  $('#button_unverify_file_ktp_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'dokumen_ktp\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
                } else {
                  // alert("button ngga ada isinya");
                  $('#button_unverify_file_ktp_modal').html('');
                }

                //icon
                $('.icon-verify-file-ktp').html(res['data']['validate_dokumen_ktp']);

                //attribut input
                $('#file_ktp_modal').prop("hidden", true);
              }
              //NIK
              if (res['data']['nik_validation'] == "0") {
                //button
                $('#button_verify_nik_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'nik\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

                $('#button_unverify_nik_modal').html('');

                //icon
                $('.icon-verify-nik').html(res['data']['validate_nik']);

                //attribut input
                $('#nik_modal_verifikasi').prop('readonly', false);
              } else {
                //button
                $('#button_verify_nik_modal').html('');
                if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
                  $('#button_unverify_nik_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'nik\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
                } else {
                  $('#button_unverify_nik_modal').html('');
                }

                //icon
                $('.icon-verify-nik').html(res['data']['validate_nik']);

                //attribut input
                $('#nik_modal_verifikasi').prop('readonly', true);
              }
              //NAMA
              if (res['data']['nama_validation'] == "0") {
                //button
                $('#button_verify_nama_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'nama\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

                $('#button_unverify_nama_modal').html('');

                //icon
                $('.icon-verify-nama').html(res['data']['validate_nama']);

                //attribut input
                $('#nama_modal').prop('readonly', false);
              } else {
                //button
                $('#button_verify_nama_modal').html('');
                if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
                  $('#button_unverify_nama_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'nama\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
                } else {
                  $('#button_unverify_nama_modal').html('');
                }

                //icon
                $('.icon-verify-nama').html(res['data']['validate_nama']);

                //attribut input
                $('#nama_modal').prop('readonly', true);
              }
              //FILE KK
              if (res['data']['dokumen_kk_validation'] == "0") {
                //button
                $('#button_verify_file_kk_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'dokumen_kk\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

                $('#button_unverify_file_kk_modal').html('');

                //icon
                $('.icon-verify-file-kk').html(res['data']['validate_dokumen_kk']);

                //attribut input
                $('#file_kk_modal').prop("hidden", false);
              } else {
                //button
                $('#button_verify_file_kk_modal').html('');
                if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
                  $('#button_unverify_file_kk_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'dokumen_kk\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
                } else {
                  $('#button_unverify_file_kk_modal').html('');
                }

                //icon
                $('.icon-verify-file-kk').html(res['data']['validate_dokumen_kk']);

                //attribut input
                $('#file_kk_modal').prop("hidden", true);
              }
              //KK
              if (res['data']['kk_validation'] == "0") {
                //button
                $('#button_verify_kk_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'kk\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

                $('#button_unverify_kk_modal').html('');

                //icon
                $('.icon-verify-kk').html(res['data']['validate_kk']);

                //attribut input
                $('#kk_modal').prop('readonly', false);
              } else {
                //button
                $('#button_verify_kk_modal').html('');
                if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
                  $('#button_unverify_kk_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'kk\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
                } else {
                  $('#button_unverify_kk_modal').html('');
                }

                //icon
                $('.icon-verify-kk').html(res['data']['validate_kk']);

                //attribut input
                $('#kk_modal').prop('readonly', true);
              }
              //BANK
              if (res['data']['bank_validation'] == "0") {
                //button
                $('#button_verify_bank_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'bank\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

                $('#button_unverify_bank_modal').html('');

                //icon
                $('.icon-verify-bank').html(res['data']['validate_bank']);

                //attribut input
                $('#bank_modal').prop('disabled', false);
              } else {
                //button
                $('#button_verify_bank_modal').html('');
                if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
                  $('#button_unverify_bank_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'bank\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
                } else {
                  $('#button_unverify_bank_modal').html('');
                }

                //icon
                $('.icon-verify-bank').html(res['data']['validate_bank']);

                //attribut input
                $('#bank_modal').prop('disabled', true);
              }
              //NOMOR REKENING
              if (res['data']['norek_validation'] == "0") {
                //button
                $('#button_verify_norek_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'norek\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

                $('#button_unverify_norek_modal').html('');

                //icon
                $('.icon-verify-norek').html(res['data']['validate_norek']);

                //attribut input
                $('#rekening_modal').prop('readonly', false);
              } else {
                //button
                $('#button_verify_norek_modal').html('');
                if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
                  $('#button_unverify_norek_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'norek\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
                } else {
                  $('#button_unverify_norek_modal').html('');
                }

                //icon
                $('.icon-verify-norek').html(res['data']['validate_norek']);

                //attribut input
                $('#rekening_modal').prop('readonly', true);
              }
              //PEMILIK REKENING
              if (res['data']['pemilik_rekening_validation'] == "0") {
                //button
                $('#button_verify_pemilik_rek_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'pemilik_rekening\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

                $('#button_unverify_pemilik_rek_modal').html('');

                //icon
                $('.icon-verify-pemilik-rek').html(res['data']['validate_pemilik_rekening']);

                //attribut input
                $('#pemilik_rekening_modal').prop('readonly', false);
              } else {
                //button
                $('#button_verify_pemilik_rek_modal').html('');
                if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
                  $('#button_unverify_pemilik_rek_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'pemilik_rekening\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
                } else {
                  $('#button_unverify_pemilik_rek_modal').html('');
                }

                //icon
                $('.icon-verify-pemilik-rek').html(res['data']['validate_pemilik_rekening']);

                //attribut input
                $('#pemilik_rekening_modal').prop('readonly', true);
              }
              //FILE CV
              if (res['data']['cv_validation'] == "0") {
                //button
                $('#button_verify_file_cv_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'cv\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

                $('#button_unverify_file_cv_modal').html('');

                //icon
                $('.icon-verify-file-cv').html(res['data']['validate_cv']);

                //attribut input
                $('#file_cv_modal').prop("hidden", false);
              } else {
                //button
                $('#button_verify_file_cv_modal').html('');
                if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
                  $('#button_unverify_file_cv_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'cv\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
                } else {
                  $('#button_unverify_file_cv_modal').html('');
                }

                //icon
                $('.icon-verify-file-cv').html(res['data']['validate_cv']);

                //attribut input
                $('#file_cv_modal').prop("hidden", true);
              }
              //FILE SKCK
              if (res['data']['skck_validation'] == "0") {
                //button
                $('#button_verify_file_skck_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'skck\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

                $('#button_unverify_file_skck_modal').html('');

                //icon
                $('.icon-verify-file-skck').html(res['data']['validate_skck']);

                //attribut input
                $('#file_skck_modal').prop("hidden", false);
              } else {
                //button
                $('#button_verify_file_skck_modal').html('');
                if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
                  $('#button_unverify_file_skck_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'skck\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
                } else {
                  $('#button_unverify_file_skck_modal').html('');
                }

                //icon
                $('.icon-verify-file-skck').html(res['data']['validate_skck']);

                //attribut input
                $('#file_skck_modal').prop("hidden", true);
              }
              //FILE IJAZAH
              if (res['data']['ijazah_validation'] == "0") {
                //button
                $('#button_verify_file_ijazah_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'ijazah\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

                $('#button_unverify_file_ijazah_modal').html('');

                //icon
                $('.icon-verify-file-ijazah').html(res['data']['validate_ijazah']);

                //attribut input
                $('#file_ijazah_modal').prop("hidden", false);
              } else {
                //button
                $('#button_verify_file_ijazah_modal').html('');
                if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
                  $('#button_unverify_file_ijazah_modal').html('<button onclick="save_verifikasi(\'' + res['data']['secid'] + '\',\'ijazah\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
                } else {
                  $('#button_unverify_file_ijazah_modal').html('');
                }

                //icon
                $('.icon-verify-file-ijazah').html(res['data']['validate_ijazah']);

                //attribut input
                $('#file_ijazah_modal').prop("hidden", true);
              }

              //display isi modal
              $('.isi-modal-verifikasi').attr("hidden", false);
              $('.info-modal-verifikasi').attr("hidden", true);
            },
            error: function(xhr, status, error) {
              var html_text = '<strong>ERROR LOAD FILE</strong>';
              $('.display_file_ktp_modal').html(html_text);
              $('.display_file_kk_modal').html(html_text);
              $('.display_file_cv_modal').html(html_text);
              $('.display_file_skck_modal').html(html_text);
              $('.display_file_ijazah_modal').html(html_text);

              //display isi modal
              $('.isi-modal-verifikasi').attr("hidden", false);
              $('.info-modal-verifikasi').attr("hidden", true);
            }
          });
        } else {
          html_text = res['pesan'];
          $('.info-modal-verifikasi').html(html_text);
          $('.isi-modal-verifikasi').attr("hidden", true);
          $('.info-modal-verifikasi').attr("hidden", false);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-verifikasi').html(html_text); //coba pake iframe
        $('.isi-modal-verifikasi').attr("hidden", true);
        $('.info-modal-verifikasi').attr("hidden", false);
      }
    });

    //hidden tombol navigasi
    $('#navigasi_add_outlet').attr("hidden", false);

    //aktivasi tab
    $('#edit-dokumen-nav').addClass('active');
    $('#edit-dokumen-tab').addClass('active');
    $('#edit-dokumen-tab').addClass('show');

    $('#edit-profile-nav').removeClass('active');
    $('#edit-profile-tab').removeClass('active');
    $('#edit-profile-tab').removeClass('show');
    $('#edit-project-nav').removeClass('active');
    $('#edit-project-tab').removeClass('active');
    $('#edit-project-tab').removeClass('show');
    $('#edit-rekening-nav').removeClass('active');
    $('#edit-rekening-tab').removeClass('active');
    $('#edit-rekening-tab').removeClass('show');
    $('#edit-upah-nav').removeClass('active');
    $('#edit-upah-tab').removeClass('active');
    $('#edit-upah-tab').removeClass('show');

    $('.info-modal-edit-outlet').attr("hidden", true);
    $('.isi-modal-edit-outlet').attr("hidden", false);
    $('#button_save_dokumen').attr("hidden", true);
    $('#button_save_profile').attr("hidden", true);
    $('#button_save_project').attr("hidden", true);
    $('#button_save_rekening').attr("hidden", true);
    $('#button_save_upah').attr("hidden", true);
    $('#button_delete_outlet').attr("hidden", true);
    $('#editProfileModal').modal('show');
  }
</script>

<!-- SHOW PAKET UPAH -->
<script>
  function show_upah() {
    // alert(id);

    //judul modal
    $('.judulModalProfile').html("Edit Upah");



    //inisialisasi variabel
    // $('#link_file_excel').val("");
    // $('#tipe_file_excel').val("");
    array_data_import = "";
    jumlah_data_import = 0;
    // pond_outlet.removeFile();

    //inisialisasi pesan
    $('#pesan_file_excel').html("");

    //hidden tombol navigasi
    $('#navigasi_add_outlet').attr("hidden", false);

    //aktivasi tab
    $('#edit-upah-nav').addClass('active');
    $('#edit-upah-tab').addClass('active');
    $('#edit-upah-tab').addClass('show');


    $('#edit-profile-nav').removeClass('active');
    $('#edit-profile-tab').removeClass('active');
    $('#edit-profile-tab').removeClass('show');
    $('#edit-project-nav').removeClass('active');
    $('#edit-project-tab').removeClass('active');
    $('#edit-project-tab').removeClass('show');
    $('#edit-rekening-nav').removeClass('active');
    $('#edit-rekening-tab').removeClass('active');
    $('#edit-rekening-tab').removeClass('show');
    $('#edit-dokumen-nav').removeClass('active');
    $('#edit-dokumen-tab').removeClass('active');
    $('#edit-dokumen-tab').removeClass('show');

    $('#subproject_name_modal').val(sub_project_id_temp).change();

    $('.info-modal-edit-outlet').attr("hidden", true);
    $('.isi-modal-edit-outlet').attr("hidden", false);
    $('#button_save_upah').attr("hidden", false);
    $('#button_save_profile').attr("hidden", true);
    $('#button_save_project').attr("hidden", true);
    $('#button_save_dokumen').attr("hidden", true);
    $('#button_save_rekening').attr("hidden", true);
    $('#button_delete_outlet').attr("hidden", true);
    $('#editProfileModal').modal('show');
  }
</script>

<!-- Tombol Verifikasi Data NIK -->
<script type="text/javascript">
  function save_verifikasi(secid, jenis_dokumen, verification_id, status) {
    // e.preventDefault();
    // alert("masuk verify nik");base_url
    // alert("Coming Soon." + "\nVerification id: " + verification_id + "\nJenis Dokumen: " + jenis_dokumen);

    var base_url_cis = "<?php echo base_url(); ?>";
    var user_role = <?php echo $user[0]->user_role_id; ?>;
    var verified_by = "<?php echo $user[0]->first_name; ?>";
    var verified_by_id = "<?php echo $session['user_id']; ?>";
    $('#id_kandidat_modal').val(secid);

    if (jenis_dokumen == "dokumen_ktp") {
      var nilai_sebelum = $("#link_file_ktp_sebelum_modal").val();
      var nilai_sesudah = $("#link_file_ktp_modal").val();
    } else if (jenis_dokumen == "nik") {
      var nilai_sebelum = $("#nik_modal_sebelum_verifikasi").val();
      var nilai_sesudah = $("#nik_modal_verifikasi").val();
    } else if (jenis_dokumen == "nama") {
      var nilai_sebelum = $("#nama_modal_sebelum").val();
      var nilai_sesudah = $("#nama_modal").val();
    } else if (jenis_dokumen == "dokumen_kk") {
      var nilai_sebelum = $("#link_file_kk_sebelum_modal").val();
      var nilai_sesudah = $("#link_file_kk_modal").val();
    } else if (jenis_dokumen == "kk") {
      var nilai_sebelum = $("#kk_modal_sebelum").val();
      var nilai_sesudah = $("#kk_modal").val();
    } else if (jenis_dokumen == "bank") {
      var nilai_sebelum = $("#bank_modal_sebelum").val();
      var nilai_sesudah = $("#bank_modal").val();
    } else if (jenis_dokumen == "norek") {
      var nilai_sebelum = $("#rekening_modal_sebelum").val();
      var nilai_sesudah = $("#rekening_modal").val();
    } else if (jenis_dokumen == "pemilik_rekening") {
      var nilai_sebelum = $("#pemilik_rekening_modal_sebelum").val();
      var nilai_sesudah = $("#pemilik_rekening_modal").val();
    } else if (jenis_dokumen == "cv") {
      var nilai_sebelum = $("#link_file_cv_sebelum_modal").val();
      var nilai_sesudah = $("#link_file_cv_modal").val();
    } else if (jenis_dokumen == "skck") {
      var nilai_sebelum = $("#link_file_skck_sebelum_modal").val();
      var nilai_sesudah = $("#link_file_skck_modal").val();
    } else if (jenis_dokumen == "ijazah") {
      var nilai_sebelum = $("#link_file_ijazah_sebelum_modal").val();
      var nilai_sesudah = $("#link_file_ijazah_modal").val();
    }

    //debug
    // alert("NIP: " + nip + "\nVerification id: " + verification_id + "\nJenis Dokumen: " + jenis_dokumen + "\nNilai sebelum: " + nilai_sebelum + "\nNilai Sesudah: " + nilai_sesudah + "\nStatus: " + status + "\nverified_by: " + verified_by + "\nverified_by_id: " + verified_by_id);

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Employees/valiadsi_employee_request/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        secid: secid,
        id_employee_request: verification_id,
        kolom: jenis_dokumen,
        nilai_sebelum: nilai_sebelum,
        nilai_sesudah: nilai_sesudah,
        status: status,
        verified_by: verified_by,
        verified_by_id: verified_by_id,
      },
      beforeSend: function() {
        $('.info-modal-verifikasi').attr("hidden", false);
        $('.isi-modal-verifikasi').attr("hidden", true);
        $('.info-modal-verifikasi').html(loading_html_text);
      },
      success: function(response) {
        var res = jQuery.parseJSON(response);

        // alert("NIP: " + nip + "\nVerification id: " + verification_id + "\nJenis Dokumen: " + jenis_dokumen + "\nNilai sebelum: " + nilai_sebelum + "\nNilai Sesudah: " + nilai_sesudah + "\nStatus: " + status + "\nverified_by: " + verified_by + "\nverified_by_id: " + verified_by_id);

        if (jenis_dokumen == "dokumen_ktp") {
          //file KTP
          if (status == "0") {
            //button
            $('#button_verify_file_ktp_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'dokumen_ktp\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');
            // if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
            //  $('#button_unverify_file_ktp_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'dokumen_ktp\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
            // } else {
            $('#button_unverify_file_ktp_modal').html('');
            // }

            //icon
            $('.icon-verify-file-ktp').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

            //attribut input
            $('#file_ktp_modal').prop("hidden", false);
          } else {
            //button
            $('#button_verify_file_ktp_modal').html('');
            if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
              // alert("button ada isinya");
              $('#button_unverify_file_ktp_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'dokumen_ktp\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
            } else {
              // alert("button ngga ada isinya");
              $('#button_unverify_file_ktp_modal').html('');
            }

            //icon
            $('.icon-verify-file-ktp').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

            //attribut input
            $('#file_ktp_modal').prop("hidden", true);
          }
        } else if (jenis_dokumen == "nik") {
          //NIK
          if (status == "0") {
            //button
            $('#button_verify_nik_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'nik\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

            $('#button_unverify_nik_modal').html('');

            //icon
            $('.icon-verify-nik').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

            //attribut input
            $('#nik_modal_verifikasi').prop('readonly', false);
          } else {
            //button
            $('#button_verify_nik_modal').html('');
            if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
              $('#button_unverify_nik_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'nik\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
            } else {
              $('#button_unverify_nik_modal').html('');
            }

            //icon
            $('.icon-verify-nik').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

            //attribut input
            $('#nik_modal_verifikasi').prop('readonly', true);
          }
        } else if (jenis_dokumen == "nama") {
          //NAMA
          if (status == "0") {
            //button
            $('#button_verify_nama_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'nama\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

            $('#button_unverify_nama_modal').html('');

            //icon
            $('.icon-verify-nama').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

            //attribut input
            $('#nama_modal').prop('readonly', false);
          } else {
            //button
            $('#button_verify_nama_modal').html('');
            if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
              $('#button_unverify_nama_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'nama\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
            } else {
              $('#button_unverify_nama_modal').html('');
            }

            //icon
            $('.icon-verify-nama').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

            //attribut input
            $('#nama_modal').prop('readonly', true);
          }
        } else if (jenis_dokumen == "dokumen_kk") {
          //FILE KK
          if (status == "0") {
            //button
            $('#button_verify_file_kk_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'dokumen_kk\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

            $('#button_unverify_file_kk_modal').html('');

            //icon
            $('.icon-verify-file-kk').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

            //attribut input
            $('#file_kk_modal').prop("hidden", false);
          } else {
            //button
            $('#button_verify_file_kk_modal').html('');
            if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
              $('#button_unverify_file_kk_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'dokumen_kk\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
            } else {
              $('#button_unverify_file_kk_modal').html('');
            }

            //icon
            $('.icon-verify-file-kk').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

            //attribut input
            $('#file_kk_modal').prop("hidden", true);
          }
        } else if (jenis_dokumen == "kk") {
          //KK
          if (status == "0") {
            //button
            $('#button_verify_kk_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'kk\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

            $('#button_unverify_kk_modal').html('');

            //icon
            $('.icon-verify-kk').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

            //attribut input
            $('#kk_modal').prop('readonly', false);
          } else {
            //button
            $('#button_verify_kk_modal').html('');
            if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
              $('#button_unverify_kk_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'kk\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
            } else {
              $('#button_unverify_kk_modal').html('');
            }

            //icon
            $('.icon-verify-kk').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

            //attribut input
            $('#kk_modal').prop('readonly', true);
          }
        } else if (jenis_dokumen == "bank") {
          //BANK
          if (status == "0") {
            //button
            $('#button_verify_bank_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'bank\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

            $('#button_unverify_bank_modal').html('');

            //icon
            $('.icon-verify-bank').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

            //attribut input
            $('#bank_modal').prop('disabled', false);
          } else {
            //button
            $('#button_verify_bank_modal').html('');
            if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
              $('#button_unverify_bank_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'bank\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
            } else {
              $('#button_unverify_bank_modal').html('');
            }

            //icon
            $('.icon-verify-bank').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

            //attribut input
            $('#bank_modal').prop('disabled', true);
          }
        } else if (jenis_dokumen == "norek") {
          //NOMOR REKENING
          if (status == "0") {
            //button
            $('#button_verify_norek_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'norek\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

            $('#button_unverify_norek_modal').html('');

            //icon
            $('.icon-verify-norek').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

            //attribut input
            $('#rekening_modal').prop('readonly', false);
          } else {
            //button
            $('#button_verify_norek_modal').html('');
            if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
              $('#button_unverify_norek_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'norek\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
            } else {
              $('#button_unverify_norek_modal').html('');
            }

            //icon
            $('.icon-verify-norek').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

            //attribut input
            $('#rekening_modal').prop('readonly', true);
          }
        } else if (jenis_dokumen == "pemilik_rekening") {
          //PEMILIK REKENING
          if (status == "0") {
            //button
            $('#button_verify_pemilik_rek_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'pemilik_rekening\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

            $('#button_unverify_pemilik_rek_modal').html('');

            //icon
            $('.icon-verify-pemilik-rek').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

            //attribut input
            $('#pemilik_rekening_modal').prop('readonly', false);
          } else {
            //button
            $('#button_verify_pemilik_rek_modal').html('');
            if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
              $('#button_unverify_pemilik_rek_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'pemilik_rekening\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
            } else {
              $('#button_unverify_pemilik_rek_modal').html('');
            }

            //icon
            $('.icon-verify-pemilik-rek').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

            //attribut input
            $('#pemilik_rekening_modal').prop('readonly', true);
          }
        } else if (jenis_dokumen == "cv") {
          //FILE CV
          if (status == "0") {
            //button
            $('#button_verify_file_cv_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'cv\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

            $('#button_unverify_file_cv_modal').html('');

            //icon
            $('.icon-verify-file-cv').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

            //attribut input
            $('#file_cv_modal').prop("hidden", false);
          } else {
            //button
            $('#button_verify_file_cv_modal').html('');
            if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
              $('#button_unverify_file_cv_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'cv\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
            } else {
              $('#button_unverify_file_cv_modal').html('');
            }

            //icon
            $('.icon-verify-file-cv').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

            //attribut input
            $('#file_cv_modal').prop("hidden", true);
          }
        } else if (jenis_dokumen == "skck") {
          //FILE SKCK
          if (status == "0") {
            //button
            $('#button_verify_file_skck_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'skck\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

            $('#button_unverify_file_skck_modal').html('');

            //icon
            $('.icon-verify-file-skck').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

            //attribut input
            $('#file_skck_modal').prop("hidden", false);
          } else {
            //button
            $('#button_verify_file_skck_modal').html('');
            if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
              $('#button_unverify_file_skck_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'skck\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
            } else {
              $('#button_unverify_file_skck_modal').html('');
            }

            //icon
            $('.icon-verify-file-skck').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

            //attribut input
            $('#file_skck_modal').prop("hidden", true);
          }
        } else if (jenis_dokumen == "ijazah") {
          //FILE IJAZAH
          if (status == "0") {
            //button
            $('#button_verify_file_ijazah_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'ijazah\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

            $('#button_unverify_file_ijazah_modal').html('');

            //icon
            $('.icon-verify-file-ijazah').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

            //attribut input
            $('#file_ijazah_modal').prop("hidden", false);
          } else {
            //button
            $('#button_verify_file_ijazah_modal').html('');
            if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
              $('#button_unverify_file_ijazah_modal').html('<button onclick="save_verifikasi(\'' + secid + '\',\'ijazah\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
            } else {
              $('#button_unverify_file_ijazah_modal').html('');
            }

            //icon
            $('.icon-verify-file-ijazah').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

            //attribut input
            $('#file_ijazah_modal').prop("hidden", true);
          }
        }

        //Display dokumen
        var id_karyawan_request = $("#id_kandidat_modal").val();
        //isi dokumen
        $.ajax({
          url: '<?= base_url() ?>admin/Employees/get_data_dokumen_pribadi_request/',
          method: 'post',
          data: {
            [csrfName]: csrfHash,
            id_karyawan_request: id_karyawan_request,
          },
          beforeSend: function() {
            $('.display_file_ktp_modal').html(loading_html_text);
            $('.display_file_kk_modal').html(loading_html_text);
            $('.display_file_cv_modal').html(loading_html_text);
            $('.display_file_skck_modal').html(loading_html_text);
            $('.display_file_ijazah_modal').html(loading_html_text);
            $('.display_file_npwp_modal').html(loading_html_text);
          },
          success: function(response) {

            var res2 = jQuery.parseJSON(response);

            //dokumen KTP
            if (res2['status']['filename_ktp'] == "200") {
              var nama_file = res2['data']['filename_ktp'];
              var tipe_file = nama_file.substr(-3, 3);
              var atribut = "";
              var height = '';
              var d = new Date();
              var time = d.getTime();
              nama_file = nama_file + "?" + time;

              if (tipe_file == "pdf") {
                atribut = "application/pdf";
                // height = 'height="500px"';
              } else {
                atribut = "image/jpg";
              }

              var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
              $('.display_file_ktp_modal').html(html_text);
            } else {
              var html_text = '<strong>' + res2['pesan']['filename_ktp'] + '</strong>';
              $('.display_file_ktp_modal').html(html_text);
            }

            //dokumen KK
            if (res2['status']['filename_kk'] == "200") {
              var nama_file = res2['data']['filename_kk'];
              var tipe_file = nama_file.substr(-3, 3);
              var atribut = "";
              var height = '';
              var d = new Date();
              var time = d.getTime();
              nama_file = nama_file + "?" + time;

              if (tipe_file == "pdf") {
                atribut = "application/pdf";
                // height = 'height="500px"';
              } else {
                atribut = "image/jpg";
              }

              var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
              $('.display_file_kk_modal').html(html_text);
            } else {
              var html_text = '<strong>' + res2['pesan']['filename_kk'] + '</strong>';
              $('.display_file_kk_modal').html(html_text);
            }

            //dokumen CV
            if (res2['status']['filename_cv'] == "200") {
              var nama_file = res2['data']['filename_cv'];
              var tipe_file = nama_file.substr(-3, 3);
              var atribut = "";
              var height = '';
              var d = new Date();
              var time = d.getTime();
              nama_file = nama_file + "?" + time;

              if (tipe_file == "pdf") {
                atribut = "application/pdf";
                // height = 'height="500px"';
              } else {
                atribut = "image/jpg";
              }

              var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
              $('.display_file_cv_modal').html(html_text);
            } else {
              var html_text = '<strong>' + res2['pesan']['filename_cv'] + '</strong>';
              $('.display_file_cv_modal').html(html_text);
            }

            //dokumen SKCK
            if (res2['status']['filename_skck'] == "200") {
              var nama_file = res2['data']['filename_skck'];
              var tipe_file = nama_file.substr(-3, 3);
              var atribut = "";
              var height = '';
              var d = new Date();
              var time = d.getTime();
              nama_file = nama_file + "?" + time;

              if (tipe_file == "pdf") {
                atribut = "application/pdf";
                // height = 'height="500px"';
              } else {
                atribut = "image/jpg";
              }

              var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
              $('.display_file_skck_modal').html(html_text);
            } else {
              var html_text = '<strong>' + res2['pesan']['filename_skck'] + '</strong>';
              $('.display_file_skck_modal').html(html_text);
            }

            //dokumen Ijazah
            if (res2['status']['filename_isd'] == "200") {
              var nama_file = res2['data']['filename_isd'];
              var tipe_file = nama_file.substr(-3, 3);
              var atribut = "";
              var height = '';
              var d = new Date();
              var time = d.getTime();
              nama_file = nama_file + "?" + time;

              if (tipe_file == "pdf") {
                atribut = "application/pdf";
                // height = 'height="500px"';
              } else {
                atribut = "image/jpg";
              }

              var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
              $('.display_file_ijazah_modal').html(html_text);
            } else {
              var html_text = '<strong>' + res2['pesan']['filename_isd'] + '</strong>';
              $('.display_file_ijazah_modal').html(html_text);
            }

            //dokumen NPWP
            if (res2['status']['filename_npwp'] == "200") {
              var nama_file = res2['data']['filename_npwp'];
              var tipe_file = nama_file.substr(-3, 3);
              var atribut = "";
              var height = '';
              var d = new Date();
              var time = d.getTime();
              nama_file = nama_file + "?" + time;

              if (tipe_file == "pdf") {
                atribut = "application/pdf";
                // height = 'height="500px"';
              } else {
                atribut = "image/jpg";
              }

              var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
              $('.display_file_npwp_modal').html(html_text);
            } else {
              var html_text = '<strong>' + res2['pesan']['filename_npwp'] + '</strong>';
              $('.display_file_npwp_modal').html(html_text);
            }

            alert("Berhasil melakukan verifikasi");
            
            //display isi modal
            $('.isi-modal-verifikasi').attr("hidden", false);
            $('.info-modal-verifikasi').attr("hidden", true);
          },
          error: function(xhr, status, error) {
            var html_text = '<strong>ERROR LOAD FILE</strong>';
            $('.display_file_ktp_modal').html(html_text);
            $('.display_file_kk_modal').html(html_text);
            $('.display_file_cv_modal').html(html_text);
            $('.display_file_skck_modal').html(html_text);
            $('.display_file_ijazah_modal').html(html_text);
            $('.display_file_npwp_modal').html(html_text);

            //display isi modal
            $('.isi-modal-verifikasi').attr("hidden", false);
            $('.info-modal-verifikasi').attr("hidden", true);
          }
        });
      },
      error: function(xhr, status, error) {
        // var res = jQuery.parseJSON(response);
        html_text = "Gagal melakukan verifikasi.\n";
        html_text = html_text + "Error :\n";
        html_text = html_text + xhr.responseText;
        alert(html_text)
      }
    });

  };
</script>

<!-- RUPIAH -->
<script type="text/javascript">
  var rupiah1 = document.getElementById("gaji_pokok_modal");
  rupiah1.addEventListener("keyup", function(e) {
    rupiah1.value = convertRupiah(this.value);
  });

  var rupiah2 = document.getElementById("allow_jabatan_modal");
  rupiah2.addEventListener("keyup", function(e) {
    rupiah2.value = convertRupiah(this.value);
  });

  var rupiah3 = document.getElementById("allow_area_modal");
  rupiah3.addEventListener("keyup", function(e) {
    rupiah3.value = convertRupiah(this.value);
  });


  var rupiah4 = document.getElementById("allow_makan_modal");
  rupiah4.addEventListener("keyup", function(e) {
    rupiah4.value = convertRupiah(this.value);
  });

  var rupiah5 = document.getElementById("allow_transport_modal");
  rupiah5.addEventListener("keyup", function(e) {
    rupiah5.value = convertRupiah(this.value);
  });

  var rupiah6 = document.getElementById("allow_kom_modal");
  rupiah6.addEventListener("keyup", function(e) {
    rupiah6.value = convertRupiah(this.value);
  });

  var rupiah7 = document.getElementById("allow_device_modal");
  rupiah7.addEventListener("keyup", function(e) {
    rupiah7.value = convertRupiah(this.value);
  });

  var rupiah8 = document.getElementById("allow_parkir_modal");
  rupiah8.addEventListener("keyup", function(e) {
    rupiah8.value = convertRupiah(this.value);
  });

  var rupiah9 = document.getElementById("allow_akomodasi_modal");
  rupiah9.addEventListener("keyup", function(e) {
    rupiah9.value = convertRupiah(this.value);
  });

  var rupiah10 = document.getElementById("allow_rental_modal");
  rupiah10.addEventListener("keyup", function(e) {
    rupiah10.value = convertRupiah(this.value);
  });

  var rupiah11 = document.getElementById("allow_kasir_modal");
  rupiah11.addEventListener("keyup", function(e) {
    rupiah11.value = convertRupiah(this.value);
  });

  var rupiah12 = document.getElementById("allow_masa_modal");
  rupiah12.addEventListener("keyup", function(e) {
    rupiah12.value = convertRupiah(this.value);
  });

  var rupiah13 = document.getElementById("allow_tempattinggal_modal");
  rupiah13.addEventListener("keyup", function(e) {
    rupiah13.value = convertRupiah(this.value);
  });

  var rupiah14 = document.getElementById("allow_transmeal_modal");
  rupiah14.addEventListener("keyup", function(e) {
    rupiah14.value = convertRupiah(this.value);
  });

  var rupiah15 = document.getElementById("allow_transrent_modal");
  rupiah15.addEventListener("keyup", function(e) {
    rupiah15.value = convertRupiah(this.value);
  });

  var rupiah16 = document.getElementById("allow_medicine_modal");
  rupiah16.addEventListener("keyup", function(e) {
    rupiah16.value = convertRupiah(this.value);
  });

  var rupiah17 = document.getElementById("allow_grooming_modal");
  rupiah17.addEventListener("keyup", function(e) {
    rupiah17.value = convertRupiah(this.value);
  });

  var rupiah18 = document.getElementById("allow_kehadiran_modal");
  rupiah18.addEventListener("keyup", function(e) {
    rupiah18.value = convertRupiah(this.value);
  });

  var rupiah19 = document.getElementById("allow_disiplin_modal");
  rupiah19.addEventListener("keyup", function(e) {
    rupiah19.value = convertRupiah(this.value);
  });

  var rupiah20 = document.getElementById("allow_training_modal");
  rupiah20.addEventListener("keyup", function(e) {
    rupiah20.value = convertRupiah(this.value);
  });

  var rupiah21 = document.getElementById("allow_keahlian_modal");
  rupiah21.addEventListener("keyup", function(e) {
    rupiah21.value = convertRupiah(this.value);
  });

  var rupiah22 = document.getElementById("allow_kinerja_modal");
  rupiah22.addEventListener("keyup", function(e) {
    rupiah22.value = convertRupiah(this.value);
  });

  var rupiah23 = document.getElementById("allow_pph_modal");
  rupiah23.addEventListener("keyup", function(e) {
    rupiah23.value = convertRupiah(this.value);
  });

  var rupiah24 = document.getElementById("allow_operational_modal");
  rupiah24.addEventListener("keyup", function(e) {
    rupiah24.value = convertRupiah(this.value);
  });

  var rupiah25 = document.getElementById("allow_other_modal");
  rupiah25.addEventListener("keyup", function(e) {
    rupiah25.value = convertRupiah(this.value);
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

  function formatRupiahInput(angka) {
    // let angka = input.value.replace(/\D/g, '');
    // input.value = angka ? Number(angka).toLocaleString('id-ID') : '';
    return Number(angka).toLocaleString('id-ID');
  }

    $('#cut_off_modal').on('blur', function() {

      let val = $(this).val().replace(/\D/g, '');

      if (val.length === 1) {
          val = '0' + val;
      }

      let part1 = val.substring(0, 2).padStart(2, '0');
      let part2 = val.substring(2, 4).padEnd(2, '0');

      $(this).val(part1 + '/' + part2);

    });
</script>

<!-- SAVE PROFILE -->
<script type="text/javascript">
  function save_data_diri() {

    //-------ambil isi variabel-------
    var id_karyawan_request     = $('#id_kandidat_modal').val();
    var no_ktp                  = $('#no_ktp_modal').val();
    var nama_ibu_modal          = $('#nama_ibu_modal').val();
    var tempat_lahir_modal      = $('#tempat_lahir_modal').val();
    var tanggal_lahir_modal     = $('#tanggal_lahir_modal').val();
    var gender_modal            = $('#gender_modal').val();
    var agama_modal             = $('#agama_modal').val();
    var status_kawin_modal      = $('#status_kawin_modal').val();
    var no_npwp_modal           = $('#no_npwp_modal').val();
    var no_hp_modal             = $('#no_hp_modal').val();
    var alamat_email_modal      = $('#alamat_email_modal').val();
    var emergency_name_modal    = $('#emergency_name_modal').val();
    var emergency_hubungan_modal = $('#emergency_hubungan_modal').val();
    var emergency_kontak_modal  = $('#emergency_kontak_modal').val();

    //-------testing-------
    // alert(agama_modal);
    // alert(status_kawin_modal);
    // alert("masuk button save Data Diri");

    //inisialisasi pesan
    $('#pesan_nama_ibu_modal').html("");
    $('#pesan_tempat_lahir_modal').html("");
    $('#pesan_tanggal_lahir_modal').html("");
    $('#pesan_gender_modal').html("");
    $('#pesan_agama_modal').html("");
    $('#pesan_status_kawin_modal').html("");
    $('#pesan_no_hp_modal').html("");
    $('#pesan_alamat_email_modal').html("");
    $('#pesan_emergency_name_modal').html("");
    $('#pesan_emergency_hubungan_modal').html("");
    $('#pesan_emergency_kontak_modal').html("");

    //-------cek apakah ada yang tidak diisi-------
    var pesan_nama_ibu = "";
    var pesan_tempat_lahir = "";
    var pesan_tanggal_lahir = "";
    var pesan_gender = "";
    var pesan_agama = "";
    var pesan_status_kawin = "";
    var pesan_no_hp = "";
    var pesan_alamat_email = "";
    var pesan_emergency_name = "";
    var pesan_emergency_hubungan = "";
    var pesan_emergency_kontak = "";

    if ((nama_ibu_modal == "") || (nama_ibu_modal == null)) {
      pesan_nama_ibu = "<small style='color:#FF0000;'>Nama Ibu Kandung tidak boleh kosong</small>";
      $('#nama_ibu_modal').focus();
    }
    if ((tempat_lahir_modal == "") || (tempat_lahir_modal == null)) {
      pesan_tempat_lahir = "<small style='color:#FF0000;'>Tempat Lahir tidak boleh kosong</small>";
      $('#tempat_lahir_modal').focus();
    }
    if ((tanggal_lahir_modal == "") || (tanggal_lahir_modal == null)) {
      pesan_tanggal_lahir = "<small style='color:#FF0000;'>Tanggal Lahir tidak boleh kosong</small>";
      $('#tanggal_lahir_modal').focus();
    }
    if ((gender_modal == "") || (gender_modal == null)) {
      pesan_gender = "<small style='color:#FF0000;'>Jenis Kelamin tidak boleh kosong</small>";
      $('#pesan_gender_modal').focus();
    }
    if ((agama_modal == "") || (agama_modal == null)) {
      pesan_agama = "<small style='color:#FF0000;'>Agama/Kepercayaan tidak boleh kosong</small>";
      $('#pesan_agama_modal').focus();
    }
    if ((status_kawin_modal == "") || (status_kawin_modal == null)) {
      pesan_status_kawin = "<small style='color:#FF0000;'>Status Pernikaahan tidak boleh kosong</small>";
      $('#pesan_status_kawin_modal').focus();
    }
    if ((no_hp_modal == "") || (no_hp_modal == null)) {
      pesan_no_hp = "<small style='color:#FF0000;'>Nomor Kontak/HP tidak boleh kosong</small>";
      $('#pesan_no_hp_modal').focus();
    }
    if ((alamat_email_modal == "") || (alamat_email_modal == null)) {
      pesan_alamat_email = "<small style='color:#FF0000;'>Alamat e-mail tidak boleh kosong</small>";
      $('#pesan_alamat_email_modal').focus();
    }
    if ((emergency_name_modal == "") || (emergency_name_modal == null)) {
      pesan_emergency_name = "<small style='color:#FF0000;'>Nama dalam Kontak Darurat tidak boleh kosong</small>";
      $('#pesan_emergency_name_modal').focus();
    }
    if ((emergency_hubungan_modal == "") || (emergency_hubungan_modal == null)) {
      pesan_emergency_hubungan = "<small style='color:#FF0000;'>Hubungan dengan Kontak Darurat tidak boleh kosong</small>";
      $('#pesan_emergency_hubungan_modal').focus();
    }
    if ((emergency_kontak_modal == "") || (emergency_kontak_modal == null)) {
      pesan_emergency_kontak = "<small style='color:#FF0000;'>Nomor Kontak darurat tidak boleh kosong</small>";
      $('#pesan_emergency_kontak_modal').focus();
    }
    $('#pesan_nama_ibu_modal').html(pesan_nama_ibu);
    $('#pesan_tempat_lahir_modal').html(pesan_tempat_lahir);
    $('#pesan_tanggal_lahir_modal').html(pesan_tanggal_lahir);
    $('#pesan_gender_modal').html(pesan_gender);
    $('#pesan_agama_modal').html(pesan_agama);
    $('#pesan_status_kawin_modal').html(pesan_status_kawin);
    $('#pesan_no_hp_modal').html(pesan_no_hp);
    $('#pesan_alamat_email_modal').html(pesan_alamat_email);
    $('#pesan_emergency_name_modal').html(pesan_emergency_name);
    $('#pesan_emergency_hubungan_modal').html(pesan_emergency_hubungan);
    $('#pesan_emergency_kontak_modal').html(pesan_emergency_kontak);



    //-------action-------
    if (
      (pesan_nama_ibu != "") || (pesan_tempat_lahir != "") || (pesan_tanggal_lahir != "") || (pesan_gender != "" || (pesan_agama != "") || (pesan_status_kawin != "") || (pesan_no_hp != "") || (pesan_alamat_email != "") || 
        (pesan_emergency_name != "") || (pesan_emergency_hubungan != "") || (pesan_emergency_kontak != ""))
    ) { //kalau ada input kosong 
      alert("Masih ada kolom yang kosong, mohon cek kembali...!");
    } else {
      // AJAX untuk update data interviewer
      // alert("Data OK");
      $.ajax({
        url: '<?= base_url() ?>admin/employee_request_hrd/update_data_profile/',
        method: 'post',
        data: {
          [csrfName]: csrfHash,
          secid: id_karyawan_request,
          no_ktp: no_ktp,
          nama_ibu: nama_ibu_modal,
          tempat_lahir: tempat_lahir_modal,
          tanggal_lahir: tanggal_lahir_modal,
          gender: gender_modal,
          agama: agama_modal,
          status_kawin: status_kawin_modal,
          no_npwp: no_npwp_modal,
          contact_no: no_hp_modal,
          email: alamat_email_modal,
          emergency_name_modal: emergency_name_modal,
          emergency_hubungan_modal: emergency_hubungan_modal,
          emergency_kontak_modal: emergency_kontak_modal,
        },
        beforeSend: function() {
          // $('#editKontakModal').modal('show');
          $('.info-modal-edit-outlet').attr("hidden", false);
          $('.isi-modal-edit-outlet').attr("hidden", true);
          $('.info-modal-edit-outlet').html(loading_html_text);
          $('#button_save_profile').attr("hidden", true);
          // $('#button_add_batch_outlet').attr("hidden", true);
          // $('#button_delete_outlet').attr("hidden", true);
        },
        success: function(response) {

          var res = jQuery.parseJSON(response);

          if (res['status'] == "200") {
            //tampilkan pesan sukses
            $('.info-modal-edit-outlet').attr("hidden", false);
            $('.isi-modal-edit-outlet').attr("hidden", true);
            $('.info-modal-edit-outlet').html(success_html_text);
            // $('#area').attr("hidden", true);
            // filter_outlet_product();
            // tabel_outlet.ajax.reload(null, false);
          } else {
            html_text = res['pesan'];
            $('.info-modal-edit-outlet').html(html_text);
            $('.isi-modal-edit-outlet').attr("hidden", true);
            $('.info-modal-edit-outlet').attr("hidden", false);
            // $('#area').attr("hidden", true);
          }
        },
        error: function(xhr, status, error) {
          html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
          html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
          // html_text = "Gagal fetch data. Kode error: " + xhr.status;
          $('.info-modal-edit-outlet').html(html_text); //coba pake iframe
          $('.isi-modal-edit-outlet').attr("hidden", true);
          $('.info-modal-edit-outlet').attr("hidden", false);
          $('#button_add_batch_outlet').attr("hidden", true);
          $('#button_delete_outlet').attr("hidden", true);
        }
      });

      // alert("Tidak ada input kosong");
    }
  };
</script>

<!-- SAVE PROJECT -->
<script type="text/javascript">
  function save_data_project() {

    //-------ambil isi variabel-------
    var id_karyawan_request       = $('#id_kandidat_modal').val();
    var project_name_modal        = $('#project_name_modal').val();
    var subproject_name_modal     = $('#subproject_name_modal').val();
    var vendor_id_modal           = $('#vendor_id_modal').val();
    var doc_id_modal              = $('#doc_id_modal').val();
    var jabatan_name_modal        = $('#jabatan_name_modal').val();
    var kategory_name_modal       = $('#kategory_name_modal').val();
    var penempatan_modal          = $('#penempatan_modal').val();
    var penempatan_kerja_modal    = $('#penempatan_kerja_modal').val();
    var region_name_modal         = $('#region_name_modal').val();
    var dc_name_modal             = $('#dc_name_modal').val();
    var tanggal_join_modal        = $('#tanggal_join_modal').val();
    var tanggal_mulai_modal       = $('#tanggal_mulai_modal').val();
    var tanggal_akhir_modal       = $('#tanggal_akhir_modal').val();
    var waktu_kontrak_modal       = $('#waktu_kontrak_modal').val();
    var cut_off_modal             = $('#cut_off_modal').val();
    var hari_kerja_model          = $('#hari_kerja_model').val();
    var tanggal_penggajian_modal  = $('#tanggal_penggajian_modal').val();

    //-------testing-------
    // alert(agama_modal);
    // alert(status_kawin_modal);
    // alert("masuk button save Data Diri");

    //inisialisasi pesan
    $('#pesan_project_name_modal').html("");
    $('#pesan_subproject_name_modal').html("");
    $('#pesan_jabatan_name_modal').html("");
    $('#pesan_kategory_name_modal').html("");
    $('#pesan_penempatan_modal').html("");
    $('#pesan_tanggal_join_modal').html("");
    $('#pesan_tanggal_mulai_modal').html("");
    $('#pesan_tanggal_akhir_modal').html("");
    $('#pesan_waktu_kontrak_modal').html("");
    $('#pesan_cut_off_modal').html("");
    $('#pesan_hari_kerja_model').html("");
    $('#pesan_tanggal_penggajian_modal').html("");


    //-------cek apakah ada yang tidak diisi-------
    var pesan_project_name_modal = "";
    var pesan_subproject_name_modal = "";
    var pesan_jabatan_name_modal = "";
    var pesan_kategory_name_modal = "";
    var pesan_penempatan_modal = "";
    var pesan_tanggal_join_modal = "";
    var pesan_tanggal_mulai_modal = "";
    var pesan_tanggal_akhir_modal = "";
    var pesan_waktu_kontrak_modal = "";
    var pesan_cut_off_modal = "";
    var pesan_hari_kerja_model = "";
    var pesan_tanggal_penggajian_modal = "";

    if ((project_name_modal == "") || (project_name_modal == null)) {
      pesan_project_name_modal = "<small style='color:#FF0000;'>Nama Ibu Kandung tidak boleh kosong</small>";
      $('#nama_ibu_modal').focus();
    }
    if ((subproject_name_modal == "") || (subproject_name_modal == null)) {
      pesan_subproject_name_modal = "<small style='color:#FF0000;'>Tempat Lahir tidak boleh kosong</small>";
      $('#tempat_lahir_modal').focus();
    }
    if ((jabatan_name_modal == "") || (jabatan_name_modal == null)) {
      pesan_jabatan_name_modal = "<small style='color:#FF0000;'>Tanggal Lahir tidak boleh kosong</small>";
      $('#tanggal_lahir_modal').focus();
    }
    if ((kategory_name_modal == "") || (kategory_name_modal == null)) {
      pesan_kategory_name_modal = "<small style='color:#FF0000;'>Jenis Kelamin tidak boleh kosong</small>";
      $('#pesan_gender_modal').focus();
    }
    if ((penempatan_modal == "") || (penempatan_modal == null)) {
      pesan_penempatan_modal = "<small style='color:#FF0000;'>Agama/Kepercayaan tidak boleh kosong</small>";
      $('#pesan_agama_modal').focus();
    }
    if ((tanggal_join_modal == "") || (tanggal_join_modal == null)) {
      pesan_tanggal_join_modal = "<small style='color:#FF0000;'>Status Pernikaahan tidak boleh kosong</small>";
      $('#pesan_status_kawin_modal').focus();
    }
    if ((tanggal_mulai_modal == "") || (tanggal_mulai_modal == null)) {
      pesan_tanggal_mulai_modal = "<small style='color:#FF0000;'>Nomor Kontak/HP tidak boleh kosong</small>";
      $('#pesan_no_hp_modal').focus();
    }
    if ((tanggal_akhir_modal == "") || (tanggal_akhir_modal == null)) {
      pesan_tanggal_akhir_modal = "<small style='color:#FF0000;'>Alamat e-mail tidak boleh kosong</small>";
      $('#pesan_alamat_email_modal').focus();
    }
    if ((waktu_kontrak_modal == "") || (waktu_kontrak_modal == null)) {
      pesan_waktu_kontrak_modal = "<small style='color:#FF0000;'>Nama dalam Kontak Darurat tidak boleh kosong</small>";
      $('#pesan_emergency_name_modal').focus();
    }
    if ((cut_off_modal == "") || (cut_off_modal == null)) {
      pesan_cut_off_modal = "<small style='color:#FF0000;'>Hubungan dengan Kontak Darurat tidak boleh kosong</small>";
      $('#pesan_emergency_hubungan_modal').focus();
    }
    if ((hari_kerja_model == "") || (hari_kerja_model == null)) {
      pesan_hari_kerja_model = "<small style='color:#FF0000;'>Nomor Kontak darurat tidak boleh kosong</small>";
      $('#pesan_emergency_kontak_modal').focus();
    }
    if ((tanggal_penggajian_modal == "") || (tanggal_penggajian_modal == null)) {
      pesan_tanggal_penggajian_modal = "<small style='color:#FF0000;'>Nomor Kontak darurat tidak boleh kosong</small>";
      $('#pesan_emergency_kontak_modal').focus();
    }

    $('#pesan_project_name_modal').html(pesan_project_name_modal);
    $('#pesan_subproject_name_modal').html(pesan_subproject_name_modal);
    $('#pesan_jabatan_name_modal').html(pesan_jabatan_name_modal);
    $('#pesan_kategory_name_modal').html(pesan_kategory_name_modal);
    $('#pesan_penempatan_modal').html(pesan_penempatan_modal);
    $('#pesan_tanggal_join_modal').html(pesan_tanggal_join_modal);
    $('#pesan_tanggal_mulai_modal').html(pesan_tanggal_mulai_modal);
    $('#pesan_tanggal_akhir_modal').html(pesan_tanggal_akhir_modal);
    $('#pesan_waktu_kontrak_modal').html(pesan_waktu_kontrak_modal);
    $('#pesan_cut_off_modal').html(pesan_cut_off_modal);
    $('#pesan_hari_kerja_model').html(pesan_hari_kerja_model);
    $('#pesan_tanggal_penggajian_modal').html(pesan_tanggal_penggajian_modal);

    //-------action-------
    if (
      (pesan_project_name_modal != "") || (pesan_subproject_name_modal != "") || (pesan_jabatan_name_modal != "") || (pesan_kategory_name_modal != "" || (pesan_penempatan_modal != "") || (pesan_tanggal_join_modal != "") || (pesan_tanggal_mulai_modal != "") || (pesan_tanggal_akhir_modal != "") || (pesan_waktu_kontrak_modal != "") || (pesan_cut_off_modal != "") || (pesan_hari_kerja_model != "") || (pesan_tanggal_penggajian_modal != ""))
    ) { //kalau ada input kosong 
      alert("Masih ada kolom yang kosong, mohon cek kembali...!");
    } else {
      // AJAX untuk update data interviewer
      // alert("Data OK");
      $.ajax({
        url: '<?= base_url() ?>admin/employee_request_hrd/update_data_project/',
        method: 'post',
        data: {
          [csrfName]: csrfHash,
          secid: id_karyawan_request,
          project: project_name_modal,
          sub_project: subproject_name_modal,
          company_id: vendor_id_modal,
          e_status: doc_id_modal,
          posisi: jabatan_name_modal,
          location_id: kategory_name_modal,
          penempatan: penempatan_modal,
          region_name: penempatan_kerja_modal,
          region: region_name_modal,
          dc_name: dc_name_modal,
          email: tanggal_join_modal,
          doj: tanggal_mulai_modal,
          contract_start: tanggal_mulai_modal,
          contract_end: tanggal_akhir_modal,
          contract_periode: waktu_kontrak_modal,
          hari_kerja: hari_kerja_model,
          date_payment: tanggal_penggajian_modal,
          cut_off: cut_off_modal,
        },

        beforeSend: function() {
          // $('#editKontakModal').modal('show');
          $('.info-modal-edit-outlet').attr("hidden", false);
          $('.isi-modal-edit-outlet').attr("hidden", true);
          $('.info-modal-edit-outlet').html(loading_html_text);
          $('#button_save_project').attr("hidden", true);
          // $('#button_add_batch_outlet').attr("hidden", true);
          // $('#button_delete_outlet').attr("hidden", true);
        },
        success: function(response) {

          var res = jQuery.parseJSON(response);

          if (res['status'] == "200") {
            //tampilkan pesan sukses
            $('.info-modal-edit-outlet').attr("hidden", false);
            $('.isi-modal-edit-outlet').attr("hidden", true);
            $('.info-modal-edit-outlet').html(success_html_text);
            // $('#area').attr("hidden", true);
            // filter_outlet_product();
            // tabel_outlet.ajax.reload(null, false);
          } else {
            html_text = res['pesan'];
            $('.info-modal-edit-outlet').html(html_text);
            $('.isi-modal-edit-outlet').attr("hidden", true);
            $('.info-modal-edit-outlet').attr("hidden", false);
            // $('#area').attr("hidden", true);
          }
        },
        error: function(xhr, status, error) {
          html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
          html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
          // html_text = "Gagal fetch data. Kode error: " + xhr.status;
          $('.info-modal-edit-outlet').html(html_text); //coba pake iframe
          $('.isi-modal-edit-outlet').attr("hidden", true);
          $('.info-modal-edit-outlet').attr("hidden", false);
          $('#button_add_batch_outlet').attr("hidden", true);
          $('#button_delete_outlet').attr("hidden", true);
        }
      });

      // alert("Tidak ada input kosong");
    }
  };
</script>


<!-- SAVE PAKET UPAH -->
<script type="text/javascript">
  function save_data_upah() {

    //-------ambil isi variabel-------
    var id_karyawan_request           = $('#id_kandidat_modal').val();
    var gaji_pokok_modal              = $('#gaji_pokok_modal').val();
    var allow_jabatan_modal       = $('#allow_jabatan_modal').val();
    var dm_allow_jabatan          = $('#dm_allow_jabatan').val();
    var allow_area_modal          = $('#allow_area_modal').val();
    var dm_allow_area             = $('#dm_allow_area').val();
    var allow_makan_modal         = $('#allow_makan_modal').val();
    var dm_allow_makan            = $('#dm_allow_makan').val();
    var allow_transport_modal     = $('#allow_transport_modal').val();
    var dm_allow_transport        = $('#dm_allow_transport').val();
    var allow_kom_modal           = $('#allow_kom_modal').val();
    var dm_allow_kom              = $('#dm_allow_kom').val();
    var allow_device_modal        = $('#allow_device_modal').val();
    var dm_allow_device           = $('#dm_allow_device').val();
    var allow_parkir_modal        = $('#allow_parkir_modal').val();
    var dm_allow_parkir           = $('#dm_allow_parkir').val();
    var allow_akomodasi_modal     = $('#allow_akomodasi_modal').val();
    var dm_allow_akomodasi        = $('#dm_allow_akomodasi').val();
    var allow_rental_modal        = $('#allow_rental_modal').val();
    var dm_allow_rental           = $('#dm_allow_rental').val();
    var allow_kasir_modal         = $('#allow_kasir_modal').val();
    var dm_allow_kasir            = $('#dm_allow_kasir').val();
    var allow_masa_modal          = $('#allow_masa_modal').val();
    var dm_allow_masa             = $('#dm_allow_masa').val();
    var allow_tempattinggal_modal = $('#allow_tempattinggal_modal').val();
    var dm_allow_tempattinggal    = $('#dm_allow_tempattinggal').val();
    var allow_transmeal_modal     = $('#allow_transmeal_modal').val();
    var dm_allow_transmeal        = $('#dm_allow_transmeal').val();
    var allow_transrent_modal     = $('#allow_transrent_modal').val();
    var dm_allow_transrent        = $('#dm_allow_transrent').val();
    var allow_medicine_modal      = $('#allow_medicine_modal').val();
    var dm_allow_medicine         = $('#dm_allow_medicine').val();
    var allow_grooming_modal      = $('#allow_grooming_modal').val();
    var dm_allow_grooming         = $('#dm_allow_grooming').val();
    var allow_kehadiran_modal     = $('#allow_kehadiran_modal').val();
    var dm_allow_kehadiran        = $('#dm_allow_kehadiran').val();
    var allow_disiplin_modal      = $('#allow_disiplin_modal').val();
    var dm_allow_disiplin         = $('#dm_allow_disiplin').val();
    var allow_training_modal      = $('#allow_training_modal').val();
    var dm_allow_training         = $('#dm_allow_training').val();
    var allow_keahlian_modal      = $('#allow_keahlian_modal').val();
    var dm_allow_keahlian         = $('#dm_allow_keahlian').val();
    var allow_operational_modal   = $('#allow_operational_modal').val();
    var dm_allow_operational      = $('#dm_allow_operational').val();
    var allow_kinerja_modal       = $('#allow_kinerja_modal').val();
    var dm_allow_kinerja          = $('#dm_allow_kinerja').val();
    var allow_pph_modal           = $('#allow_pph_modal').val();
    var dm_allow_pph              = $('#dm_allow_pph').val();
    var allow_other_modal         = $('#allow_other_modal').val();
    var dm_allow_other            = $('#dm_allow_other').val();



    //-------testing-------
    // alert(agama_modal);
    // alert(status_kawin_modal);
    // alert("masuk button save Data Diri");

    //inisialisasi pesan
    $('#pesan_gaji_pokok_modal').html("");

    //-------cek apakah ada yang tidak diisi-------
    var pesan_gaji_pokok_modal = "";

    if ((gaji_pokok_modal == "") || (gaji_pokok_modal == null) || (gaji_pokok_modal == "0")) {
      pesan_gaji_pokok_modal = "<small style='color:#FF0000;'>Gaji Pokok tidak boleh kosong / Nol...!</small>";
      $('#nama_ibu_modal').focus();
    }
    $('#pesan_gaji_pokok_modal').html(pesan_gaji_pokok_modal);


    //-------action-------
    if (pesan_gaji_pokok_modal != "") { //kalau ada input kosong 
      alert("Masih ada kolom yang kosong, mohon cek kembali...!");
    } else {
      // AJAX untuk update data interviewer
      // alert("Data OK");
      $.ajax({
        url: '<?= base_url() ?>admin/employee_request_hrd/update_data_upah/',
        method: 'post',
        data: {
          [csrfName]: csrfHash,
          secid: id_karyawan_request,
            gaji_pokok: gaji_pokok_modal,
            allow_jabatan: allow_jabatan_modal,
            dm_allow_jabatan: dm_allow_jabatan,
            allow_skill: allow_keahlian_modal,
            dm_allow_skill: dm_allow_keahlian,
            allow_area: allow_area_modal,
            dm_allow_area: dm_allow_area,
            allow_masakerja: allow_masa_modal,
            dm_allow_masakerja: dm_allow_masa,
            allow_konsumsi: allow_makan_modal,
            dm_allow_konsumsi: dm_allow_makan,
            allow_transport: allow_transport_modal,
            dm_allow_transport: dm_allow_transport,
            allow_rent: allow_rental_modal,
            dm_allow_rent: dm_allow_rental,
            allow_comunication: allow_kom_modal,
            dm_allow_comunication: dm_allow_kom,
            allow_parking: allow_parkir_modal,
            dm_allow_park: dm_allow_parkir,
            allow_residence_cost: allow_tempattinggal_modal,
            dm_allow_residance: dm_allow_tempattinggal,
            allow_akomodsasi: allow_akomodasi_modal,
            dm_allow_akomodasi: dm_allow_akomodasi,
            allow_device: allow_device_modal,
            dm_allow_device: dm_allow_device,
            allow_kasir: allow_kasir_modal,
            dm_allow_kasir: dm_allow_kasir,
            allow_trans_meal: allow_transmeal_modal,
            dm_allow_transmeal: dm_allow_transmeal,
            allow_trans_rent: allow_transrent_modal,
            dm_allow_transrent: dm_allow_transrent,
            allow_medicine: allow_medicine_modal,
            dm_allow_medicine: dm_allow_medicine,
            allow_grooming: allow_grooming_modal,
            dm_allow_grooming: dm_allow_grooming,
            allow_kehadiran: allow_kehadiran_modal,
            dm_allow_kehadiran: dm_allow_kehadiran,
            allow_operational: allow_operational_modal,
            dm_allow_operational: dm_allow_operational,
            allow_training: allow_training_modal,
            dm_allow_training: dm_allow_training,
            allow_kinerja: allow_kinerja_modal,
            dm_allow_kinerja: dm_allow_kinerja,
            allow_disiplin: allow_disiplin_modal,
            dm_allow_disiplin: dm_allow_disiplin,
            allow_pph: allow_pph_modal,
            dm_allow_pph: dm_allow_pph,
            allow_others: allow_other_modal,
            dm_allow_others: dm_allow_other,

        },
        beforeSend: function() {
          // $('#editKontakModal').modal('show');
          $('.info-modal-edit-outlet').attr("hidden", false);
          $('.isi-modal-edit-outlet').attr("hidden", true);
          $('.info-modal-edit-outlet').html(loading_html_text);
          $('#button_save_upah').attr("hidden", true);
          // $('#button_add_batch_outlet').attr("hidden", true);
          // $('#button_delete_outlet').attr("hidden", true);
        },
        success: function(response) {

          var res = jQuery.parseJSON(response);

          if (res['status'] == "200") {
            //tampilkan pesan sukses
            $('.info-modal-edit-outlet').attr("hidden", false);
            $('.isi-modal-edit-outlet').attr("hidden", true);
            $('.info-modal-edit-outlet').html(success_html_text);
            // $('#area').attr("hidden", true);
            // filter_outlet_product();
            // tabel_outlet.ajax.reload(null, false);
          } else {
            html_text = res['pesan'];
            $('.info-modal-edit-outlet').html(html_text);
            $('.isi-modal-edit-outlet').attr("hidden", true);
            $('.info-modal-edit-outlet').attr("hidden", false);
            // $('#area').attr("hidden", true);
          }
        },
        error: function(xhr, status, error) {
          html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
          html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
          // html_text = "Gagal fetch data. Kode error: " + xhr.status;
          $('.info-modal-edit-outlet').html(html_text); //coba pake iframe
          $('.isi-modal-edit-outlet').attr("hidden", true);
          $('.info-modal-edit-outlet').attr("hidden", false);
          $('#button_add_batch_outlet').attr("hidden", true);
          $('#button_delete_outlet').attr("hidden", true);
        }
      });

      // alert("Tidak ada input kosong");
    }
  };
</script>

<!-- Chained Dropdown -->
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

  });
</script>

<script type="text/javascript">
    function close_edit_employee() {
        // alert("show modal screening");
        $('#editProfileModal').modal('hide');
    }
</script>

<script type="text/javascript">
    function printExcel() {
        var project_id = document.getElementById("aj_project").value;
        var kategori = document.getElementById("kategori").value;
        var golongan = document.getElementById("golongan").value;
        var approve = document.getElementById("approve").value;
        var idsession = "<?php print($session['employee_id']); ?>";
        // var filter = $('#table').find('input').val();
        var filter = $('.dataTables_filter input').val() //ambil filter search dari datatables

        //alert($('.dataTables_filter input').val());
        if (filter == "") {
          filter = "-no_input-";
        }
        
        alert('<?php echo base_url(); ?>admin/employee_request_hrd/printExcel/' + project_id + '/' + kategori + '/' + golongan + '/' + approve + '/' + idsession + '/' + filter + '/');

        window.open('<?php echo base_url(); ?>admin/employee_request_hrd/printExcel/' + project_id + '/' + kategori + '/' + golongan + '/' + approve + '/' + idsession + '/' + filter + '/', '_blank');
    }
</script>