<!-- Filepond css -->
<link rel="stylesheet" href="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond/filepond.min.css" type="text/css" />
<!-- <link href="assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css" type="text/css" />

<?php
/* Employees report view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $_tasks = $this->Timesheet_model->get_tasks(); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<!-- MODAL UNTUK DISPLAY DOKUMEN -->
<div class="modal fade" id="editModal" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">
          <div class="judul-modal">
            <span id="judul-modal-edit"></span>
            <?php if (in_array('1016', $role_resources_ids)) { ?>
              <span id="button_download_dokumen_conditional">tes</span>
            <?php } ?>
          </div>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- <iframe src="" style="zoom:0.60" frameborder="0" height="250" width="99.6%"></iframe> -->
        <div class="isi-modal"></div>
        <div class="pesan-isi-modal"></div>
      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <button hidden id='button_save_pin' name='button_save_pin' type='button' class='btn btn-primary'>Save PIN</button>
      </div>
    </div>
  </div>
</div>
<!-- END MODAL UNTUK DISPLAY DOKUMEN -->

<!-- MODAL ADD CLIENT -->
<div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Client</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- <p>Modal body text goes here.</p> -->
        <div class="isi-modal-add-client">
          <!-- NAV TAB -->
          <ul class="nav nav-pills mb-3" id="add-client-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="detail-client-tab" data-toggle="pill" href="#detail-client" role="tab" aria-controls="detail-client" aria-selected="true">Detail</a>
            </li>
            <li class="nav-item" role="presentation">
              <a disabled class="nav-link" id="dokumen-client-tab" data-toggle="pill" href="#dokumen-client" role="tab" aria-controls="dokumen-client" aria-selected="false">Dokumen</a>
            </li>
            <li class="nav-item" role="presentation">
              <a disabled class="nav-link" id="kontak-client-tab" data-toggle="pill" href="#kontak-client" role="tab" aria-controls="kontak-client" aria-selected="false">Kontak</a>
            </li>
          </ul>
          <!-- END NAV TAB -->

          <!-- NAV CONTENT -->
          <div class="tab-content" id="add-client-tabContent">
            <div class="tab-pane fade show active" id="detail-client" role="tabpanel" aria-labelledby="detail-client-tab">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <input hidden type="text" id="id_client">
                    <td style="width:30%">NAMA PERUSAHAAN <font color="#FF0000">*</font>
                    </td>
                    <td style="width:70%">
                      <input type='text' id="nama_pt" class='form-control' placeholder='Nama Perusahaan' value=''>
                      <span id='pesan_nama_pt'></span>
                    </td>
                  </tr>
                  <tr>
                    <td>ALAMAT PERUSAHAAN <font color="#FF0000">*</font>
                    </td>
                    <td>
                      <input type='text' id="alamat_pt" class='form-control' placeholder='Alamat Perusahaan' value=''>
                      <span id='pesan_alamat_pt'></span>
                    </td>
                  </tr>
                </tbody>
              </table>

              <!-- BUTTON NAVIGASI TAB DETAIL CLIENT -->
              <button type="button" class="btn btn-secondary float-right mx-2" data-dismiss="modal">Cancel</button>

              <button
                type="button"
                onclick="next_client_detail()"
                class="btn btn-success btn-label float-right ms-auto">
                <i
                  class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next
              </button>
              <!-- END BUTTON NAVIGASI TAB DETAIL CLIENT -->

            </div>
            <div class="tab-pane fade" id="dokumen-client" role="tabpanel" aria-labelledby="dokumen-client-tab">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <td style="width:30%">NOMOR NPWP <font color="#FF0000">*</font>
                    </td>
                    <td style="width:70%">
                      <input type='number' id="nomor_npwp" class='form-control' placeholder='Nomor NPWP Perusahaan' value=''>
                      <span id='pesan_nomor_npwp'></span>
                    </td>
                  </tr>
                  <tr>
                    <td style="width:30%">DOKUMEN NPWP <font color="#FF0000">*</font>
                    </td>
                    <td style="width:70%">
                      <input type="file" class="filepond filepond-input-multiple" multiple id="file_npwp" data-allow-reorder="true" data-max-file-size="5MB" data-max-files="1" accept="image/png, image/jpeg, application/pdf">
                      <span><small class="text-muted">File bertipe jpg, jpeg, png atau pdf. Ukuran maksimal 5 MB</small></span>
                      </br><span id='pesan_file_npwp'></span>
                      <input hidden type="text" id="link_file_npwp" value="0">
                      <input hidden type="text" id="status_file_npwp" value="0">
                    </td>
                  </tr>
                </tbody>
              </table>

              <!-- BUTTON NAVIGASI TAB DOKUMEN CLIENT -->
              <button
                type="button"
                onclick="previous_dokumen_client()"
                class="btn btn-light btn-label">
                <i
                  class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                Back to Detail Client
              </button>

              <button type="button" class="btn btn-secondary float-right mx-2" data-dismiss="modal">Cancel</button>

              <button
                type="button"
                id="button_next_dokumen_client"
                onclick="next_dokumen_client()"
                class="btn btn-success btn-label float-right ms-auto">
                <i
                  class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next
              </button>
              <!-- END BUTTON NAVIGASI TAB DOKUMEN CLIENT -->

            </div>
            <div class="tab-pane fade" id="kontak-client" role="tabpanel" aria-labelledby="kontak-client-tab">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <td style="width:30%">NAMA KONTAK</td>
                    <td style="width:70%">
                      <input type='text' id="nama_kontak_pt" class='form-control' placeholder='Nama Kontak' value=''>
                    </td>
                  </tr>
                  <tr>
                    <td>NOMOR KONTAK</td>
                    <td>
                      <input type='number' id="nomor_kontak_pt" class='form-control' placeholder='Nomor Kontak' value=''>
                    </td>
                  </tr>
                  <tr>
                    <td>EMAIL KONTAK</td>
                    <td>
                      <input type='email' id="email_kontak_pt" class='form-control' placeholder='Email Kontak' value=''>
                    </td>
                  </tr>
                </tbody>
              </table>

              <!-- BUTTON NAVIGASI TAB KONTAK CLIENT -->
              <button
                type="button"
                onclick="previous_kontak_client()"
                class="btn btn-light btn-label">
                <i
                  class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                Back to Dokumen Client
              </button>

              <button type="button" class="btn btn-secondary float-right mx-2" data-dismiss="modal">Cancel</button>

              <button
                type="button"
                onclick="next_kontak_client()"
                class="btn btn-success btn-label float-right ms-auto">
                <i
                  class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Finish
              </button>
              <!-- END BUTTON NAVIGASI TAB KONTAK CLIENT -->

            </div>
          </div>
          <!-- END NAV CONTENT -->

        </div>

        <div class="info-modal-add-client"></div>

      </div>
      <!-- <div class="modal-footer">
        <button id="next_add_client" type="button" class="btn btn-primary">Next</button>
        <button id="finish_add_client" type="button" class="btn btn-primary">Tambah Client</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div> -->
    </div>
  </div>
</div>
<!-- END MODAL ADD CLIENT -->

<!-- MODAL ADD BRAND -->
<div class="modal fade" id="brandModal" tabindex="-1" role="dialog" aria-labelledby="brandModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Brand</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- <p>Modal body text goes here.</p> -->
        <div class="isi-modal-add-brand">
          <div class="container" id="container_modal_project">
            <!-- NAV TAB -->
            <ul class="nav nav-pills mb-3" id="add-project-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="detail-project-tab" data-toggle="pill" href="#detail-project" role="tab" aria-controls="detail-project" aria-selected="true">Detail</a>
              </li>
              <li class="nav-item" role="presentation">
                <a disabled class="nav-link" id="dokumen-project-tab" data-toggle="pill" href="#dokumen-project" role="tab" aria-controls="dokumen-project" aria-selected="false">Dokumen</a>
              </li>
              <li class="nav-item" role="presentation">
                <a disabled class="nav-link" id="kontak-project-tab" data-toggle="pill" href="#kontak-project" role="tab" aria-controls="kontak-project" aria-selected="false">Kontak</a>
              </li>
            </ul>
            <!-- END NAV TAB -->

            <!-- NAV CONTENT -->
            <div class="tab-content" id="add-project-tabContent">
              <div class="tab-pane fade show active" id="detail-project" role="tabpanel" aria-labelledby="detail-project-tab">
                <table class="table table-striped col-md-12">
                  <tbody>
                    <tr>
                      <td style="width:30%">PERUSAHAAN <font color="#FF0000">*</font>
                      </td>
                      <td style="width:70%">
                        <select class=" form-control" id="perusahaan_id_modal" name="perusahaan_id_modal" data-plugin="select_project_modal" data-placeholder="--Pilih Perusahaan--">
                          <option value=""></option>
                          <?php foreach ($all_companies as $emp) { ?>
                            <option value="<?php echo $emp->company_id ?>"><?php echo $emp->name ?></option>
                          <?php } ?>
                        </select>
                        <span id='pesan_perusahaan_id_modal'></span>
                      </td>
                    </tr>
                    <tr>
                      <input hidden type="text" id="id_client_project">
                      <input hidden type="text" id="id_project_modal">
                      <td style="width:30%">NAMA PROJECT <font color="#FF0000">*</font>
                      </td>
                      <td style="width:70%">
                        <input type='text' id="nama_project_modal" class='form-control' placeholder='Nama Project' value=''>
                        <span id='pesan_nama_project_modal'></span>
                      </td>
                    </tr>
                    <tr>
                      <td>ALIAS <font color="#FF0000">*</font>
                      </td>
                      <td>
                        <input type='text' id="alias_project_modal" class='form-control' placeholder='Alias' value=''>
                        <span id='pesan_alias_project_modal'></span>
                      </td>
                    </tr>
                    <tr>
                      <td>JENIS DOKUMEN <font color="#FF0000">*</font>
                      </td>
                      <td>
                        <select class="form-control" name="jenis_dokumen" id="jenis_dokumen" data-plugin="select_project_modal" data-placeholder="Jenis Dokumen">
                          <option value="">Jenis Dokumen</option>
                          <option value="1">REGULER</option>
                          <option value="2">TKHL</option>
                        </select>
                        <span id='pesan_jenis_dokumen'></span>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <!-- BUTTON NAVIGASI TAB DETAIL PROJECT -->
                <button type="button" class="btn btn-secondary float-right mx-2" data-dismiss="modal">Cancel</button>

                <button
                  type="button"
                  onclick="next_project_detail()"
                  class="btn btn-success btn-label float-right ms-auto">
                  <i
                    class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next
                </button>
                <!-- END BUTTON NAVIGASI TAB DETAIL PROJECT -->

              </div>
              <div class="tab-pane fade" id="dokumen-project" role="tabpanel" aria-labelledby="dokumen-project-tab">
                <table class="table table-striped col-md-12">
                  <tbody>
                    <tr>
                      <td style="width:30%">DOKUMEN PKS</td>
                      <td style="width:70%">
                        <input type="file" class="filepond filepond-input-multiple" multiple id="file_pks" data-allow-reorder="true" data-max-file-size="5MB" data-max-files="1" accept="image/png, image/jpeg, application/pdf">
                        <small class="text-muted">File bertipe jpg, jpeg, png atau pdf. Ukuran maksimal 5 MB</small>
                        <input hidden type="text" id="status_file_pks" value="0">
                        <input hidden type="text" id="link_file_pks" value="0">
                      </td>
                    </tr>
                    <tr>
                      <td style="width:30%">DOKUMEN MOU</td>
                      <td style="width:70%">
                        <input type="file" class="filepond filepond-input-multiple" multiple id="file_mou" data-allow-reorder="true" data-max-file-size="5MB" data-max-files="1" accept="image/png, image/jpeg, application/pdf">
                        <small class="text-muted">File bertipe jpg, jpeg, png atau pdf. Ukuran maksimal 5 MB</small>
                        <input hidden type="text" id="status_file_mou" value="0">
                        <input hidden type="text" id="link_file_mou" value="0">
                      </td>
                    </tr>
                    <tr>
                      <td style="width:30%">DOKUMEN RATECARD</td>
                      <td style="width:70%">
                        <input type="file" class="filepond filepond-input-multiple" multiple id="file_ratecard" data-allow-reorder="true" data-max-file-size="5MB" data-max-files="1" accept="image/png, image/jpeg, application/pdf">
                        <small class="text-muted">File bertipe jpg, jpeg, png atau pdf. Ukuran maksimal 5 MB</small>
                        <input hidden type="text" id="status_file_ratecard" value="0">
                        <input hidden type="text" id="link_file_ratecard" value="0">
                      </td>
                    </tr>
                  </tbody>
                </table>

                <!-- BUTTON NAVIGASI TAB DOKUMEN PROJECT -->
                <button
                  type="button"
                  onclick="previous_dokumen_project()"
                  class="btn btn-light btn-label">
                  <i
                    class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                  Back to Detail Project
                </button>

                <button type="button" class="btn btn-secondary float-right mx-2" data-dismiss="modal">Cancel</button>

                <button
                  type="button"
                  id="button_next_dokumen_peoject"
                  onclick="next_dokumen_project()"
                  class="btn btn-success btn-label float-right ms-auto">
                  <i
                    class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next
                </button>
                <!-- END BUTTON NAVIGASI TAB DOKUMEN PROJECT -->

              </div>
              <div class="tab-pane fade" id="kontak-project" role="tabpanel" aria-labelledby="kontak-project-tab">
                <table class="table table-striped col-md-12">
                  <tbody>
                    <tr>
                      <td style="width:30%">NAMA KONTAK</td>
                      <td style="width:70%"><input type='text' id="nama_kontak_project" class='form-control' placeholder='Nama Kontak' value=''></td>
                    </tr>
                    <tr>
                      <td>NOMOR KONTAK</td>
                      <td><input type='number' id="nomor_kontak_project" class='form-control' placeholder='Nomor Kontak' value=''></td>
                    </tr>
                    <tr>
                      <td>EMAIL KONTAK</td>
                      <td><input type='email' id="email_kontak_project" class='form-control' placeholder='Email Kontak' value=''></td>
                    </tr>
                  </tbody>
                </table>

                <!-- BUTTON NAVIGASI TAB KONTAK PROJECT -->
                <button
                  type="button"
                  onclick="previous_kontak_project()"
                  class="btn btn-light btn-label">
                  <i
                    class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                  Back to Dokumen Project
                </button>

                <button type="button" class="btn btn-secondary float-right mx-2" data-dismiss="modal">Cancel</button>

                <button
                  type="button"
                  onclick="next_kontak_project()"
                  class="btn btn-success btn-label float-right ms-auto">
                  <i
                    class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Finish
                </button>
                <!-- END BUTTON NAVIGASI TAB KONTAK PROJECT -->

              </div>
            </div>
            <!-- END NAV CONTENT -->
          </div>
        </div>

        <div class="info-modal-add-brand"></div>

      </div>
      <!-- <div class="modal-footer">
        <button id="close_modal" class="btn btn-primary ladda-button" data-style="expand-right">Close Modal</button>
        <button type="button" class="btn btn-primary">Tambah Project</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div> -->
    </div>
  </div>
</div>
<!-- END MODAL ADD BRAND -->

<!-- SECTION FILTER -->
<div class="card border-blue">
  <div class="card-header with-elements">
    <div class="col-md-6">
      <span class="card-header-title mr-2"><strong>MANAGE CLIENT | </strong>FILTER</span>
    </div>

    <!-- <div class="col-md-6">
      <div class="pull-right">
        <span class="card-header-title mr-2">
          <button id="button_clear_search" class="btn btn-success" data-style="expand-right">Clear Filter</button>
        </span>
      </div>
    </div> -->
  </div>

  <div class="card-body border-bottom-blue ">

    <?php echo form_open_multipart('/admin/importexcel/import_saltab2/'); ?>

    <input type="hidden" id="nik" name="nik" value=<?php echo $session['employee_id']; ?>>

    <div class="form-row">
      <div class="col-md-3">
        <div class="form-group project-option">
          <label class="form-label">Project</label>
          <select class="form-control" data-live-search="true" name="project_id" id="aj_project" data-plugin="select_hrm" data-placeholder="Project" required>
            <option value="0">-ALL-</option>
            <?php foreach ($all_projects as $proj) { ?>
              <option value="<?php echo $proj->project_id; ?>"> <?php echo $proj->title; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="col-md-3" id="subproject_ajax">
        <label class="form-label">Sub Project</label>
        <select class="form-control" data-live-search="true" name="sub_project_id" id="aj_sub_project" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_projects'); ?>">
          <option value="0">--ALL--</option>
          <!-- <?php foreach ($all_projects as $proj) { ?>
            <option value="<?php echo $proj->project_id; ?>" <?php if ($project_karyawan == $proj->project_id) {
                                                                echo " selected";
                                                              } ?>> <?php echo $proj->title; ?></option>
          <?php } ?> -->
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Status</label>
        <select class="form-control" name="status" id="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status'); ?>">
          <option value="1">AKTIF</option>
          <option value="5">DEACTIVE</option>
          <option value="2">RESIGN</option>
          <option value="4">END CONTRACT</option>
          <option value="3">BLACKLIST</option>
          <option value="0">--ALL--</option>
        </select>
      </div>

      <div class="col-md-3">
        <div class="form-group">
          <!-- button submit -->
          <label class="form-label">&nbsp;</label>
          <button onclick="filter_employee()" name="filter_employee" id="filter_employee" class="btn btn-primary btn-block"><i class="fa fa-search"></i> FILTER</button>
        </div>
      </div>
    </div>

    <?php echo form_close(); ?>

  </div>
</div>
<!-- END SECTION FILTER -->

<!-- SECTION DATA TABLES -->
<div class="row m-b-1 <?php echo $get_animate; ?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements">
        <div class="col-md-6">
          <span class="card-header-title mr-2"><strong>LIST CLIENT</strong></span>
        </div>

        <div class="col-md-6">
          <div class="pull-right">
            <!-- <div class="card-header with-elements"> -->
            <span class="card-header-title mr-2">
              <button onclick="tambah_client()" id="button_tambah_client" class="btn btn-primary" data-style="expand-right">Tambah Client</button>
              <button id="button_download_client" class="btn btn-success" data-style="expand-right">Download List Data</button>
            </span>
          </div>
        </div>
      </div>

      <!-- <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>LIST EMPLOYEES</strong></span> </div> -->
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="tabel_client">
            <thead>
              <tr>
                <th>Aksi</th>
                <th>Nama PT</th>
                <th>Alamat</th>
                <th>NO. NPWP</th>
                <th>Project/Brand</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END SECTION DATA TABLES -->

<!-- filepond js -->
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond/filepond.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-file-rename/filepond-plugin-file-rename.js"></script>

<script type="text/javascript">
  //global variable
  var tabel_client;
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
  var session_id = '<?php echo $session['employee_id']; ?>';

  FilePond.registerPlugin(
    FilePondPluginFileEncode,
    FilePondPluginFileValidateType,
    FilePondPluginFileValidateSize,
    FilePondPluginFileRename,
    // FilePondPluginImageEdit,
    FilePondPluginImageExifOrientation,
    FilePondPluginImagePreview
  );

  //create object filepond untuk npwp
  var pond_npwp = FilePond.create(document.querySelector('input[id="file_npwp"]'), {
    labelIdle: 'Drag & Drop file NPWP atau klik <span class="filepond--label-action">Browse</span>',
    imagePreviewHeight: 170,
    maxFileSize: "5MB",
    acceptedFileTypes: ['image/png', 'image/jpeg', 'application/pdf'],
    imageCropAspectRatio: "1:1",
    imageResizeTargetWidth: 200,
    imageResizeTargetHeight: 200,
    fileRenameFunction: (file) => {
      return `npwp${file.extension}`;
    }
  });

  //create object filepond untuk PKS
  var pond_pks = FilePond.create(document.querySelector('input[id="file_pks"]'), {
    labelIdle: 'Drag & Drop file NPWP atau klik <span class="filepond--label-action">Browse</span>',
    imagePreviewHeight: 170,
    maxFileSize: "5MB",
    acceptedFileTypes: ['image/png', 'image/jpeg', 'application/pdf'],
    imageCropAspectRatio: "1:1",
    imageResizeTargetWidth: 200,
    imageResizeTargetHeight: 200,
    fileRenameFunction: (file) => {
      return `pks${file.extension}`;
    }
  });

  //create object filepond untuk MOU
  var pond_mou = FilePond.create(document.querySelector('input[id="file_mou"]'), {
    labelIdle: 'Drag & Drop file MOU atau klik <span class="filepond--label-action">Browse</span>',
    imagePreviewHeight: 170,
    maxFileSize: "5MB",
    acceptedFileTypes: ['image/png', 'image/jpeg', 'application/pdf'],
    imageCropAspectRatio: "1:1",
    imageResizeTargetWidth: 200,
    imageResizeTargetHeight: 200,
    fileRenameFunction: (file) => {
      return `mou${file.extension}`;
    }
  });

  //create object filepond untuk RATECARD
  var pond_ratecard = FilePond.create(document.querySelector('input[id="file_ratecard"]'), {
    labelIdle: 'Drag & Drop file RATECARD atau klik <span class="filepond--label-action">Browse</span>',
    imagePreviewHeight: 170,
    maxFileSize: "5MB",
    acceptedFileTypes: ['image/png', 'image/jpeg', 'application/pdf'],
    imageCropAspectRatio: "1:1",
    imageResizeTargetWidth: 200,
    imageResizeTargetHeight: 200,
    fileRenameFunction: (file) => {
      return `ratecard${file.extension}`;
    }
  });

  //append id_kandidat ke objek filepond
  // pond_pks.setOptions({
  //   server: {
  //     process: {
  //       url: '<?php echo base_url() ?>Registrasi/upload_dokumen',
  //       method: 'POST',
  //       ondata: (formData) => {
  //         formData.append('id_kandidat', '12');
  //         formData.append([csrfName], csrfHash);
  //         return formData;
  //       }
  //     },
  //   }
  // });

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

  $(document).ready(function() {
    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({
      width: '100%'
    });

    $('[data-plugin="select_project_modal"]').select2({
      width: "100%",
      dropdownParent: $("#container_modal_project")
    });

    var project = document.getElementById("aj_project").value;
    var sub_project = document.getElementById("aj_sub_project").value;
    var status = document.getElementById("status").value;

    // tabel_client = $('#tabel_client').DataTable().on('search.dt', () => eventFired('Search'));

    tabel_client = $('#tabel_client').DataTable({
      //"bDestroy": true,
      'processing': true,
      'serverSide': true,
      // 'stateSave': true,
      'bFilter': true,
      'serverMethod': 'post',
      //'dom': 'plBfrtip',
      'dom': 'plfrtip',
      // "buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
      //'columnDefs': [{
      //  targets: 11,
      //  type: 'date-eu'
      //}],
      'order': [
        [1, 'asc']
      ],
      'ajax': {
        'url': '<?= base_url() ?>admin/reports/list_clients',
        data: {
          [csrfName]: csrfHash,
          // session_id: session_id,
          // project: project,
          // sub_project: sub_project,
          // status: status,
          //base_url_catat: base_url_catat
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert("Status :" + xhr.status);
          alert("responseText :" + xhr.responseText);
        },
      },
      'columns': [{
          data: 'aksi',
          "orderable": false
        },
        {
          data: 'company_name',
          // "orderable": false,
          //searchable: true
        },
        {
          data: 'alamat',
          "orderable": false,
          //searchable: true
        },
        {
          data: 'no_npwp',
          "orderable": false,
          //searchable: true
        },
        {
          data: 'brand',
          "orderable": false,
          //searchable: true
        },
      ]
    });
    // }).on('search.dt', () => eventFired('Search'));
  });
</script>

<!-- Tombol Filter -->
<script type="text/javascript">
  function filter_employee() {
    tabel_client.destroy();

    e.preventDefault();

    var project = document.getElementById("aj_project").value;
    var sub_project = document.getElementById("aj_sub_project").value;
    var status = document.getElementById("status").value;

    var searchVal = $('#tabel_client').find('input').val();

    if ((searchVal == "") && (project == "0")) {
      $('#button_download_data').attr("hidden", true);

    } else {
      $('#button_download_data').attr("hidden", false);

      tabel_client = $('#tabel_client').DataTable({
        //"bDestroy": true,
        'processing': true,
        'serverSide': true,
        // 'stateSave': true,
        'bFilter': true,
        'serverMethod': 'post',
        //'dom': 'plBfrtip',
        'dom': 'lfrtip',
        //"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
        //'columnDefs': [{
        //  targets: 11,
        //  type: 'date-eu'
        //}],
        // 'order': [
        //   [4, 'asc']
        // ],
        'ajax': {
          'url': '<?= base_url() ?>admin/reports/list_clients',
          data: {
            [csrfName]: csrfHash,
            session_id: session_id,
            project: project,
            sub_project: sub_project,
            status: status,
            //base_url_catat: base_url_catat
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert("Status :" + xhr.status);
            alert("responseText :" + xhr.responseText);
          },
        },
        'columns': [{
            data: 'aksi',
            "orderable": false
          },
          {
            data: 'employee_id',
            "orderable": false,
            //searchable: true
          },
          {
            data: 'pincode',
            "orderable": false,
          },
          {
            data: 'ktp_no',
            "orderable": false,
            //searchable: true
          },
          {
            data: 'first_name',
            "orderable": false,
            //searchable: true
          },
          {
            data: 'project',
            "orderable": false
          },
          {
            data: 'sub_project',
            "orderable": false,
          },
          {
            data: 'designation_name',
            "orderable": false,
          },
          {
            data: 'penempatan',
            "orderable": false,
          },
          {
            data: 'periode',
            "orderable": false,
          },
        ]
      }).on('search.dt', () => eventFired('Search'));

      $('#tombol_filter').attr("disabled", false);
      $('#tombol_filter').removeAttr("data-loading");
    }

    // alert(project);
    // alert(sub_project);
    // alert(status);
  };
</script>

<!-- Tombol Tambah Client -->
<script type="text/javascript">
  function tambah_client() {
    // alert("tambah Client");
    pond_npwp.removeFile();
    $('#status_file_npwp').val("0");
    $('#id_client').val("");
    $("#nama_pt").val("");
    $("#alamat_pt").val("");
    $("#nomor_npwp").val("");
    $('#pesan_nama_pt').html("");
    $('#pesan_alamat_pt').html("");

    $('#detail-client-tab').removeClass('disabled');
    $("#dokumen-client-tab").addClass('disabled');
    $('#kontak-client-tab').addClass('disabled');

    $('#detail-client-tab').addClass('active');
    $('#dokumen-client-tab').removeClass('active');
    $('#kontak-client-tab').removeClass('active');

    $('#detail-client').addClass('active');
    $('#detail-client').addClass('show');
    $('#dokumen-client').removeClass('active');
    $('#dokumen-client').removeClass('show');
    $('#kontak-client').removeClass('active');
    $('#kontak-client').removeClass('show');

    $('#clientModal').appendTo("body").modal('show');
  }
</script>

<!-- button next client detail -->
<script>
  function next_client_detail() {
    var nama_pt = $("#nama_pt").val();
    var alamat_pt = $("#alamat_pt").val();

    //-------cek apakah ada yang tidak diisi-------
    var pesan_nama_pt = "";
    var pesan_alamat_pt = "";
    if (nama_pt == "") {
      pesan_nama_pt = "<small style='color:#FF0000;'>Nama perusahaan tidak boleh kosong</small>";
      $('#pesan_nama_pt').focus();
    }
    if (alamat_pt == "") {
      pesan_alamat_pt = "<small style='color:#FF0000;'>Alamat perusahaan tidak boleh kosong</small>";
      $('#pesan_alamat_pt').focus();
    }
    $('#pesan_nama_pt').html(pesan_nama_pt);
    $('#pesan_alamat_pt').html(pesan_alamat_pt);

    // alert("Nama PT: " + nama_pt + "\nAlamat PT: " + alamat_pt);

    if (
      (pesan_nama_pt != "") || (pesan_alamat_pt != "")
    ) { //kalau ada input kosong 
      // alert("Tidak boleh ada input kosong");
    } else {
      // AJAX untuk save data diri
      $.ajax({
        url: '<?= base_url() ?>admin/reports/save_client_name/',
        method: 'post',
        data: {
          [csrfName]: csrfHash,
          nama_pt: nama_pt,
          alamat_pt: alamat_pt,
        },
        beforeSend: function() {},
        success: function(response) {
          var res = jQuery.parseJSON(response);

          // alert(res);

          $('#id_client').val(res);

          //append id_client ke objek filepond npwp
          pond_npwp.setOptions({
            server: {
              process: {
                url: 'https://karir.onecorp.co.id/upload/upload_dokumen_eksternal',
                method: 'POST',
                ondata: (formData) => {
                  formData.append('id_client', res);
                  formData.append('nama_client', nama_pt);
                  formData.append('identifier', 'npwp_client');
                  formData.append([csrfName], csrfHash);
                  return formData;
                },
                // onload: (response) => response.key,
                onload: (res) => {
                  // select the right value in the response here and return
                  // return res;
                  var serverResponse = jQuery.parseJSON(res);
                  $('#link_file_npwp').val(serverResponse['0']['link_file']);
                  // serverResponse = JSON.parse(res);
                  // console.log(serverResponse['0']['link_file']);
                  // alert(serverResponse['0']['link_file']);
                }
              },
            }
          });
          $('#pesan_nomor_npwp').html("");
          $('#pesan_file_npwp').html("");

          $('#detail-client-tab').addClass('disabled');
          $('#kontak-client-tab').addClass('disabled');
          $("#dokumen-client-tab").removeClass('disabled');

          $('#detail-client-tab').removeClass('active');
          $('#dokumen-client-tab').addClass('active');
          $('#kontak-client-tab').removeClass('active');

          $('#detail-client').removeClass('active');
          $('#detail-client').removeClass('show');
          $('#dokumen-client').addClass('active');
          $('#dokumen-client').addClass('show');
          $('#kontak-client').removeClass('active');
          $('#kontak-client').removeClass('show');
        },
        error: function(xhr, status, error) {
          alert("error save detail client");
        }
      });
    }

  }
</script>
<!-- end button next client detail -->

<!-- button previous dokumen client -->
<script>
  function previous_dokumen_client() {
    $('#pesan_nama_pt').html("");
    $('#pesan_alamat_pt').html("");

    $('#detail-client-tab').removeClass('disabled');
    $('#kontak-client-tab').addClass('disabled');
    $("#dokumen-client-tab").addClass('disabled');

    $('#detail-client-tab').addClass('active');
    $('#dokumen-client-tab').removeClass('active');
    $('#kontak-client-tab').removeClass('active');

    $('#detail-client').addClass('active');
    $('#detail-client').addClass('show');
    $('#dokumen-client').removeClass('active');
    $('#dokumen-client').removeClass('show');
    $('#kontak-client').removeClass('active');
    $('#kontak-client').removeClass('show');
  }
</script>
<!-- end button previous dokumen client -->

<!-- button next dokumen client -->
<script>
  function next_dokumen_client() {
    var no_npwp = $("#nomor_npwp").val();
    var file_npwp = $("#status_file_npwp").val();
    var link_file_npwp = $("#link_file_npwp").val();
    var id_client = $("#id_client").val();

    // alert(link_file_npwp);

    // alert("Nama PT: " + nama_pt + "\nAlamat PT: " + alamat_pt);

    //-------cek apakah ada yang tidak diisi-------
    var pesan_nomor_npwp = "";
    var pesan_file_npwp = "";
    if (no_npwp == "") {
      pesan_nomor_npwp = "<small style='color:#FF0000;'>Nomor NPWP perusahaan tidak boleh kosong</small>";
      $('#pesan_nomor_npwp').focus();
    }
    if (file_npwp == "0") {
      pesan_file_npwp = "<small style='color:#FF0000;'>File NPWP perusahaan tidak boleh kosong</small>";
      $('#pesan_file_npwp').focus();
    }
    $('#pesan_nomor_npwp').html(pesan_nomor_npwp);
    $('#pesan_file_npwp').html(pesan_file_npwp);

    if (
      (pesan_nomor_npwp != "") || (pesan_file_npwp != "")
    ) { //kalau ada input kosong 
      // alert("Tidak boleh ada input kosong");
    } else {
      // AJAX untuk save data diri
      $.ajax({
        url: '<?= base_url() ?>admin/reports/save_dokumen_client/',
        method: 'post',
        data: {
          [csrfName]: csrfHash,
          id_client: id_client,
          no_npwp: no_npwp,
          link_file_npwp: link_file_npwp,
        },
        beforeSend: function() {},
        success: function() {
          $('#detail-client-tab').addClass('disabled');
          $("#dokumen-client-tab").addClass('disabled');
          $('#kontak-client-tab').removeClass('disabled');

          $('#detail-client-tab').removeClass('active');
          $('#dokumen-client-tab').removeClass('active');
          $('#kontak-client-tab').addClass('active');

          $('#detail-client').removeClass('active');
          $('#detail-client').removeClass('show');
          $('#dokumen-client').removeClass('active');
          $('#dokumen-client').removeClass('show');
          $('#kontak-client').addClass('active');
          $('#kontak-client').addClass('show');
        },
        error: function(xhr, status, error) {
          alert("error save dokumen client");
        }
      });
    }

  }
</script>
<!-- end button next next dokumen client -->

<!-- button previous kontak client -->
<script>
  function previous_kontak_client() {
    $('#pesan_nomor_npwp').html("");
    $('#pesan_file_npwp').html("");

    $('#detail-client-tab').addClass('disabled');
    $("#dokumen-client-tab").removeClass('disabled');
    $('#kontak-client-tab').addClass('disabled');

    $('#detail-client-tab').removeClass('active');
    $('#dokumen-client-tab').addClass('active');
    $('#kontak-client-tab').removeClass('active');

    $('#detail-client').removeClass('active');
    $('#detail-client').removeClass('show');
    $('#dokumen-client').addClass('active');
    $('#dokumen-client').addClass('show');
    $('#kontak-client').removeClass('active');
    $('#kontak-client').removeClass('show');
  }
</script>
<!-- end button previous kontak client -->

<!-- button next kontak client -->
<script>
  function next_kontak_client() {
    var nama_kontak_pt = $("#nama_kontak_pt").val();
    var nomor_kontak_pt = $("#nomor_kontak_pt").val();
    var email_kontak_pt = $("#email_kontak_pt").val();
    var id_client = $("#id_client").val();

    // alert(id_client);

    // alert("Id Client" + id_client + "\nNama kontak: " + nama_kontak_pt + "\nNomor Kontak: " + nomor_kontak_pt + "\nEmail Kontak: " + email_kontak_pt);

    // AJAX untuk save data diri
    $.ajax({
      url: '<?= base_url() ?>admin/reports/save_kontak_client/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id_client: id_client,
        nama_kontak_pt: nama_kontak_pt,
        nomor_kontak_pt: nomor_kontak_pt,
        email_kontak_pt: email_kontak_pt,
      },
      beforeSend: function() {},
      success: function() {
        tabel_client.ajax.reload(null, false);

        alert("Behasil simpan data client");
        $('#clientModal').modal('hide');
      },
      error: function(xhr, status, error) {
        alert("error save kontak client");
      }
    });

  }
</script>
<!-- end button next next kontak client -->

<!-- Tombol Tambah Brand -->
<script type="text/javascript">
  function add_brand(id_client) {
    alert("ID Client: " + id_client);

    //clear form data
    pond_pks.removeFile();
    pond_mou.removeFile();
    pond_ratecard.removeFile();
    $("#id_client_project").val(id_client);
    $("#id_project_modal").val("");
    $("#perusahaan_id_modal").val("");
    $("#nama_project_modal").val("");
    $("#alias_project_modal").val("");
    $("#jenis_dokumen").val("").change();
    $('#status_file_pks').val("0");
    $('#status_file_mou').val("0");
    $('#status_file_ratecard').val("0");
    $("#nama_kontak_project").val("");
    $("#nomor_kontak_project").val("");
    $("#email_kontak_project").val("");
    $("#pesan_perusahaan_id_modal").val("");
    $("#pesan_nama_project_modal").val("");
    $("#pesan_alias_project_modal").val("");
    $("#pesan_jenis_dokumen").val("");

    $('#detail-project-tab').removeClass('disabled');
    $("#dokumen-project-tab").addClass('disabled');
    $('#kontak-project-tab').addClass('disabled');

    $('#detail-project-tab').addClass('active');
    $('#dokumen-project-tab').removeClass('active');
    $('#kontak-project-tab').removeClass('active');

    $('#detail-project').addClass('active');
    $('#detail-project').addClass('show');
    $('#dokumen-project').removeClass('active');
    $('#dokumen-project').removeClass('show');
    $('#kontak-project').removeClass('active');
    $('#kontak-project').removeClass('show');

    $('#brandModal').appendTo("body").modal('show');
  }
</script>

<!-- button next project detail -->
<script>
  function next_project_detail() {
    var id_client = $("#id_client_project").val();
    var perusahaan_id = $("#perusahaan_id_modal").val();
    var nama_project = $("#nama_project_modal").val();
    var alias_project = $("#alias_project_modal").val();
    var jenis_dokumen = $("#jenis_dokumen").val();

    // alert("Nama PT: " + nama_pt + "\nAlamat PT: " + alamat_pt);

    //-------cek apakah ada yang tidak diisi-------
    var pesan_perusahaan_id_modal = "";
    var pesan_nama_project_modal = "";
    var pesan_alias_project_modal = "";
    var pesan_jenis_dokumen = "";
    if (perusahaan_id == "") {
      pesan_perusahaan_id_modal = "<small style='color:#FF0000;'>Perusahaan tidak boleh kosong</small>";
      $('#pesan_perusahaan_id_modal').focus();
    }
    if (nama_project == "") {
      pesan_nama_project_modal = "<small style='color:#FF0000;'>Nama project tidak boleh kosong</small>";
      $('#pesan_nama_project_modal').focus();
    }
    if (alias_project == "") {
      pesan_alias_project_modal = "<small style='color:#FF0000;'>Alias project tidak boleh kosong</small>";
      $('#pesan_alias_project_modal').focus();
    }
    if (jenis_dokumen == "") {
      pesan_jenis_dokumen = "<small style='color:#FF0000;'>Jenis dokumen project tidak boleh kosong</small>";
      $('#pesan_jenis_dokumen').focus();
    }
    $('#pesan_perusahaan_id_modal').html(pesan_perusahaan_id_modal);
    $('#pesan_nama_project_modal').html(pesan_nama_project_modal);
    $('#pesan_alias_project_modal').html(pesan_alias_project_modal);
    $('#pesan_jenis_dokumen').html(pesan_jenis_dokumen);

    if (
      (pesan_perusahaan_id_modal != "") || (pesan_nama_project_modal != "") ||
      (pesan_alias_project_modal != "") || (pesan_jenis_dokumen != "")
    ) { //kalau ada input kosong 
      // alert("Tidak boleh ada input kosong");
    } else {
      // AJAX untuk save data detail project
      $.ajax({
        url: '<?= base_url() ?>admin/reports/save_project_detail/',
        method: 'post',
        data: {
          [csrfName]: csrfHash,
          id_client: id_client,
          perusahaan_id: perusahaan_id,
          nama_project: nama_project,
          alias_project: alias_project,
          jenis_dokumen: jenis_dokumen,
          created_by: session_id,
        },
        beforeSend: function() {},
        success: function(response) {
          var res = jQuery.parseJSON(response);

          // alert(res);

          $('#id_project_modal').val(res);

          //append id_client ke objek filepond pks
          pond_pks.setOptions({
            server: {
              process: {
                url: 'https://karir.onecorp.co.id/upload/upload_dokumen_eksternal',
                method: 'POST',
                ondata: (formData) => {
                  formData.append('id_project', res);
                  formData.append('nama_project', nama_project);
                  formData.append('identifier', 'pks_project');
                  formData.append([csrfName], csrfHash);
                  return formData;
                },
                // onload: (response) => response.key,
                onload: (res, file) => {
                  // select the right value in the response here and return
                  // return res;
                  var serverResponse = jQuery.parseJSON(res);
                  $('#link_file_pks').val(serverResponse['0']['link_file']);
                  // alert(serverResponse['0']['link_file']);
                  // serverResponse = JSON.parse(res);
                  // console.log(serverResponse['0']['link_file']);
                  // alert(serverResponse['0']['link_file']);
                }
              },
            }
          });

          //append id_client ke objek filepond mou
          pond_mou.setOptions({
            server: {
              process: {
                url: 'https://karir.onecorp.co.id/upload/upload_dokumen_eksternal',
                method: 'POST',
                ondata: (formData) => {
                  formData.append('id_project', res);
                  formData.append('nama_project', nama_project);
                  formData.append('identifier', 'mou_project');
                  formData.append([csrfName], csrfHash);
                  return formData;
                },
                // onload: (response) => response.key,
                onload: (res) => {
                  // select the right value in the response here and return
                  // return res;
                  var serverResponse = jQuery.parseJSON(res);
                  $('#link_file_mou').val(serverResponse['0']['link_file']);
                  // alert(serverResponse['0']['link_file']);
                  // serverResponse = JSON.parse(res);
                  // console.log(serverResponse['0']['link_file']);
                  // alert(serverResponse['0']['link_file']);
                }
              },
            }
          });

          //append id_client ke objek filepond ratecard
          pond_ratecard.setOptions({
            server: {
              process: {
                url: 'https://karir.onecorp.co.id/upload/upload_dokumen_eksternal',
                method: 'POST',
                ondata: (formData) => {
                  formData.append('id_project', res);
                  formData.append('nama_project', nama_project);
                  formData.append('identifier', 'ratecard_project');
                  formData.append([csrfName], csrfHash);
                  return formData;
                },
                // onload: (response) => response.key,
                onload: (res) => {
                  // select the right value in the response here and return
                  // return res;
                  var serverResponse = jQuery.parseJSON(res);
                  $('#link_file_ratecard').val(serverResponse['0']['link_file']);
                  // alert(serverResponse['0']['link_file']);
                  // serverResponse = JSON.parse(res);
                  // console.log(serverResponse['0']['link_file']);
                  // alert(serverResponse['0']['link_file']);
                }
              },
            }
          });
          $('#pesan_perusahaan_id_modal').html("");
          $('#pesan_nama_project_modal').html("");
          $('#pesan_alias_project_modal').html("");
          $('#pesan_jenis_dokumen').html("");

          $('#detail-project-tab').addClass('disabled');
          $('#kontak-project-tab').addClass('disabled');
          $("#dokumen-project-tab").removeClass('disabled');

          $('#detail-project-tab').removeClass('active');
          $('#dokumen-project-tab').addClass('active');
          $('#kontak-project-tab').removeClass('active');

          $('#detail-project').removeClass('active');
          $('#detail-project').removeClass('show');
          $('#dokumen-project').addClass('active');
          $('#dokumen-project').addClass('show');
          $('#kontak-project').removeClass('active');
          $('#kontak-project').removeClass('show');
        },
        error: function(xhr, status, error) {
          alert("error save detail project");
        }
      });
    }

  }
</script>
<!-- end button next project detail -->

<!-- button previous project client -->
<script>
  function previous_dokumen_project() {
    $("#pesan_perusahaan_id_modal").val("");
    $("#pesan_nama_project_modal").val("");
    $("#pesan_alias_project_modal").val("");
    $("#pesan_jenis_dokumen").val("");

    $('#detail-project-tab').removeClass('disabled');
    $("#dokumen-project-tab").addClass('disabled');
    $('#kontak-project-tab').addClass('disabled');

    $('#detail-project-tab').addClass('active');
    $('#dokumen-project-tab').removeClass('active');
    $('#kontak-project-tab').removeClass('active');

    $('#detail-project').addClass('active');
    $('#detail-project').addClass('show');
    $('#dokumen-project').removeClass('active');
    $('#dokumen-project').removeClass('show');
    $('#kontak-project').removeClass('active');
    $('#kontak-project').removeClass('show');
  }
</script>
<!-- end button previous dokumen project -->

<!-- Action Open PKS -->
<script type="text/javascript">
  //-----buka dokumen pks-----
  function open_pks(id) {
    alert("masuk fungsi open PKS. id Project: " + id);
    // window.open('<?= base_url() ?>admin/employees/emp_view/' + id, "_blank");
  }
</script>

<!-- Action Open MOU -->
<script type="text/javascript">
  //-----buka dokumen pks-----
  function open_mou(id) {
    alert("masuk fungsi open MOU. id Project: " + id);
    // window.open('<?= base_url() ?>admin/employees/emp_view/' + id, "_blank");
  }
</script>

<!-- Action Open Ratecard -->
<script type="text/javascript">
  //-----buka dokumen pks-----
  function open_ratecard(id) {
    alert("masuk fungsi open Ratecard. id Project: " + id);
    // window.open('<?= base_url() ?>admin/employees/emp_view/' + id, "_blank");
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
        $('#judul-modal-edit').html("File KTP");
        $('#button_download_dokumen_conditional').html("");
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

          var button_download = "<a href='" + nama_file + "' target='_blank'><button type='button' class='btn btn-sm btn-outline-success mx-2'>Download File</button></a>";

          $('#button_download_dokumen_conditional').html(button_download);

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

<script type="text/javascript">
  // document.getElementById("button_download_data").onclick = function(e) {
  //   var project = document.getElementById("aj_project").value;
  //   var sub_project = document.getElementById("aj_sub_project").value;
  //   var status = document.getElementById("status").value;

  //   // ambil input search dari datatable
  //   var filter = $('.dataTables_filter input').val(); //cara 1
  //   var searchVal = $('#tabel_employees_filter').find('input').val(); //cara 2

  //   if (searchVal == "") {
  //     searchVal = "-no_input-";
  //   }

  //   var text_pesan = "Project: " + project;
  //   text_pesan = text_pesan + "\nSub Project: " + sub_project;
  //   text_pesan = text_pesan + "\nStatus: " + status;
  //   text_pesan = text_pesan + "\nSearch: " + searchVal;
  //   // alert(text_pesan);

  //   window.open('<?php echo base_url(); ?>admin/reports/printExcel/' + project + '/' + sub_project + '/' + status + '/' + searchVal + '/' + session_id + '/', '_self');

  // };

  //-----lihat employee-----
  function viewClient(id) {
    alert("masuk fungsi lihat. id Client: " + id);
    // window.open('<?= base_url() ?>admin/employees/emp_view/' + id, "_blank");
  }

  //-----lihat dokumen employee-----
  function viewDocumentEmployee(id) {
    //alert("masuk fungsi lihat. id: " + id);
    $('#dokumenModal').appendTo("body").modal('show');
    // $('#dokumenModal').modal('show');
    // window.open('<?= base_url() ?>admin/employees/emp_edit/' + id, "_blank");
  }

  // employee_table.on('search.dt', function() {
  //   alert("ada search");
  // });

  function eventFired(type) {
    var searchVal = $('#tabel_employees_filter').find('input').val();
    var project = document.getElementById("aj_project").value;
    var sub_project = document.getElementById("aj_sub_project").value;
    var status = document.getElementById("status").value;
    // alert(searchVal.length);

    if ((searchVal.length <= 2) && (project == "0")) {
      $('#button_download_data').attr("hidden", true);
    } else {
      // employee_table.destroy();

      // employee_table = $('#tabel_employees').DataTable({
      //   //"bDestroy": true,
      //   'processing': true,
      //   'serverSide': true,
      //   // 'stateSave': true,
      //   'bFilter': true,
      //   'serverMethod': 'post',
      //   //'dom': 'plBfrtip',
      //   'dom': 'lfrtip',
      //   //"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
      //   //'columnDefs': [{
      //   //  targets: 11,
      //   //  type: 'date-eu'
      //   //}],
      //   'order': [
      //     [3, 'asc']
      //   ],
      //   'ajax': {
      //     'url': '<?= base_url() ?>admin/reports/list_employees',
      //     data: {
      //       [csrfName]: csrfHash,
      //       session_id: session_id,
      //       project: project,
      //       sub_project: sub_project,
      //       status: status,
      //       //base_url_catat: base_url_catat
      //     },
      //     error: function(xhr, ajaxOptions, thrownError) {
      //       alert("Status :" + xhr.status);
      //       alert("responseText :" + xhr.responseText);
      //     },
      //   },
      //   'columns': [{
      //       data: 'aksi',
      //       "orderable": false
      //     },
      //     {
      //       data: 'employee_id',
      //       // "orderable": false,
      //       //searchable: true
      //     },
      //     {
      //       data: 'pincode',
      //       "orderable": false,
      //     },
      //     {
      //       data: 'first_name',
      //       // "orderable": false,
      //       //searchable: true
      //     },
      //     {
      //       data: 'project',
      //       "orderable": false
      //     },
      //     {
      //       data: 'sub_project',
      //       "orderable": false,
      //     },
      //     {
      //       data: 'designation_name',
      //       // "orderable": false,
      //     },
      //     {
      //       data: 'penempatan',
      //       //"orderable": false,
      //     },
      //     {
      //       data: 'periode',
      //       "orderable": false,
      //     },
      //   ]
      // }).on('search.dt', () => eventFired('Search'));

      // $('#tabel_employees_filter').find('input').val(searchVal);

      // employee_table.ajax.reload(null, false);

      $('#button_download_data').attr("hidden", false);
    }
    // let n = document.querySelector('#demo_info');
    // n.innerHTML +=
    //   '<div>' + type + ' event - ' + new Date().getTime() + '</div>';
    // n.scrollTop = n.scrollHeight;

  }

  jQuery("#aj_project").change(function() {

    var p_id = jQuery(this).val();

    jQuery.get(base_url + "/get_subprojects/" + p_id, function(data, status) {
      jQuery('#subproject_ajax').html(data);
    });


  });
</script>

<!-- Event filepond-->
<script>
  document.addEventListener('FilePond:processfiles', (e) => {
    // alert("selesai upload file");
    $('#button_next_dokumen_client').attr("hidden", false);
    // console.log('FilePond ready for use', e.detail);

    // // get create method reference
    // const { create } = e.detail;FilePond:processfilestart
  });

  document.addEventListener('FilePond:processfile', (e) => {
    // alert("selesai upload file");
    $('#button_next_dokumen_client').attr("hidden", false);
    // console.log('FilePond ready for use', e.detail);

    // // get create method reference
    // const { create } = e.detail;FilePond:processfilestart
  });

  document.addEventListener('FilePond:error', (e) => {
    // alert("selesai upload file");
    $('#button_next_dokumen_client').attr("hidden", false);
    // console.log('FilePond ready for use', e.detail);

    // // get create method reference
    // const { create } = e.detail;FilePond:processfilestart
  });

  document.addEventListener('FilePond:processfileabort', (e) => {
    // alert("selesai upload file");
    $('#button_next_dokumen_client').attr("hidden", false);
    // console.log('FilePond ready for use', e.detail);

    // // get create method reference
    // const { create } = e.detail;FilePond:processfilestart
  });

  document.addEventListener('FilePond:processfilestart', (e) => {
    // alert("mulai upload file");
    $('#button_next_dokumen_client').attr("hidden", true);
    // console.log('FilePond ready for use', e.detail);

    // // get create method reference
    // const { create } = e.detail;FilePond:addfilestart
  });

  document.addEventListener('FilePond:addfilestart', (e) => {
    // alert("mulai add file");
    $('#button_next_dokumen_client').attr("hidden", true);
    // console.log('FilePond ready for use', e.detail);

    // // get create method reference
    // const { create } = e.detail;FilePond:addfilestart 
  });

  pond_npwp.on('processfiles', (error, file) => {
    $('#status_file_npwp').val("1");
  }); 


  pond_npwp.on('removefile', (error, file) => {
    // alert("remove file " + file['name']); ->
    $('#status_file_npwp').val("0");
  });
</script>
