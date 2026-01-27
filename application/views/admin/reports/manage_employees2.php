<?php
/* Employees report view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $_tasks = $this->Timesheet_model->get_tasks(); ?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<!-- Filepond css -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/filepond/filepond.min.css" type="text/css" />
<!-- <link href="assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css">

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
										<td style='width:25%'><strong>File KTP <span class="icon-verify-file-ktp"></span></strong></td>
										<td style='width:50%'>
											<!-- <div class="row align-items-center"> -->
											<span id='display_file_ktp_modal'></span>
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
											<!-- <button id="button_verify_nik_modal" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>
											<?php //if (($user[0]->user_role_id == "1") || ($user[0]->user_role_id == "11") || ($user[0]->user_role_id == "22") || ($user[0]->user_role_id == "3")) { 
											?>
												<button id="button_unverify_nik_modal" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>
											<?php //} 
											?> -->
										</td>
									</tr>
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
											<!-- <button id="button_verify_nama_modal" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>
											<?php //if (($user[0]->user_role_id == "1") || ($user[0]->user_role_id == "11") || ($user[0]->user_role_id == "22") || ($user[0]->user_role_id == "3")) { 
											?>
												<button id="button_unverify_nama_modal" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>
											<?php //} 
											?> -->
										</td>
									</tr>
									<tr>
										<td style='width:25%'><strong>File KK <span class="icon-verify-file-kk"></span></strong></td>
										<td style='width:75%'>
											<!-- <div class="row align-items-center"> -->
											<span id='display_file_kk_modal'></span>
											<input hidden type="text" id="link_file_kk_sebelum_modal">
											<input hidden type="text" id="link_file_kk_modal">
											<input type="file" class="filepond filepond-input-multiple" multiple id="file_kk_modal" data-allow-reorder="true" data-max-file-size="5MB" data-max-files="1" accept="image/png, image/jpeg, application/pdf">
											<span id='pesan_file_kk_modal'></span>
											<!-- </div> -->
										</td>
										<td style='width:30%'>
											<span id="button_verify_file_kk_modal"></span>
											<span id="button_unverify_file_kk_modal"></span>
											<!-- <button id="button_verify_file_kk_modal" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>
											<?php //if (($user[0]->user_role_id == "1") || ($user[0]->user_role_id == "11") || ($user[0]->user_role_id == "22") || ($user[0]->user_role_id == "3")) { 
											?>
												<button id="button_unverify_file_kk_modal" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>
											<?php //} 
											?> -->
										</td>
									</tr>
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
											<!-- <button id="button_verify_kk_modal" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>
											<?php //if (($user[0]->user_role_id == "1") || ($user[0]->user_role_id == "11") || ($user[0]->user_role_id == "22") || ($user[0]->user_role_id == "3")) { 
											?>
												<button id="button_unverify_kk_modal" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>
											<?php //} 
											?> -->
										</td>
									</tr>
									<tr>
										<td style='width:25%'><strong>File Buku Tabungan <span class="icon-verify-file-buku-tabungan"></span></strong></td>
										<td style='width:50%'>
											<!-- <div class="row align-items-center"> -->
											<span id='display_file_buku_tabungan_modal'></span>
											<input hidden type="text" id="link_file_buku_tabungan_sebelum_modal">
											<input hidden type="text" id="link_file_buku_tabungan_modal">
											<input type="file" class="filepond filepond-input-multiple" multiple id="file_buku_tabungan_modal" data-allow-reorder="true" data-max-file-size="5MB" data-max-files="1" accept="image/png, image/jpeg, application/pdf">
											<span id='pesan_file_buku_tabungan_modal'></span>
											<!-- </div> -->
										</td>
										<td style='width:30%'>
											<span id="button_verify_file_buku_tabungan_modal"></span>
											<span id="button_unverify_file_buku_tabungan_modal"></span>
											<!-- <button id="button_verify_file_buku_tabungan_modal" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>
											<?php //if (($user[0]->user_role_id == "1") || ($user[0]->user_role_id == "11") || ($user[0]->user_role_id == "22") || ($user[0]->user_role_id == "3")) { 
											?>
												<button id="button_unverify_file_buku_tabungan_modal" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>
											<?php //} 
											?> -->
										</td>
									</tr>
									<tr>
										<td style='width:20%'><strong>Bank <span class="icon-verify-bank"></span></strong></td>
										<td style='width:50%'>
											<input hidden type="text" id="bank_modal_sebelum">
											<select name="bank_modal" id="bank_modal" class="form-control" data-plugin="select_modal_verifikasi" data-placeholder="<?php echo $this->lang->line('xin_bank_choose_name'); ?>">
												<option value=""></option>
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
											<!-- <button id="button_verify_bank_modal" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>
											<?php //if (($user[0]->user_role_id == "1") || ($user[0]->user_role_id == "11") || ($user[0]->user_role_id == "22") || ($user[0]->user_role_id == "3")) { 
											?>
												<button id="button_unverify_bank_modal" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>
											<?php //} 
											?> -->
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
									<tr>
										<td style='width:25%'><strong>File CV <span class="icon-verify-file-cv"></span></strong></td>
										<td style='width:75%'>
											<!-- <div class="row align-items-center"> -->
											<span id='display_file_cv_modal'></span>
											<input hidden type="text" id="link_file_cv_sebelum_modal">
											<input hidden type="text" id="link_file_cv_modal">
											<input type="file" class="filepond filepond-input-multiple" multiple id="file_cv_modal" data-allow-reorder="true" data-max-file-size="5MB" data-max-files="1" accept="image/png, image/jpeg, application/pdf">
											<span id='pesan_file_cv_modal'></span>
											<!-- </div> -->
										</td>
										<td style='width:30%'>
											<span id="button_verify_file_cv_modal"></span>
											<span id="button_unverify_file_cv_modal"></span>
											<!-- <button id="button_verify_file_cv_modal" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>
											<?php //if (($user[0]->user_role_id == "1") || ($user[0]->user_role_id == "11") || ($user[0]->user_role_id == "22") || ($user[0]->user_role_id == "3")) { 
											?>
												<button id="button_unverify_file_cv_modal" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>
											<?php //} 
											?> -->
										</td>
									</tr>
									<tr>
										<td style='width:25%'><strong>File SKCK <span class="icon-verify-file-skck"></span></strong></td>
										<td style='width:75%'>
											<!-- <div class="row align-items-center"> -->
											<span id='display_file_skck_modal'></span>
											<input hidden type="text" id="link_file_skck_sebelum_modal">
											<input hidden type="text" id="link_file_skck_modal">
											<input type="file" class="filepond filepond-input-multiple" multiple id="file_skck_modal" data-allow-reorder="true" data-max-file-size="5MB" data-max-files="1" accept="image/png, image/jpeg, application/pdf">
											<span id='pesan_file_skck_modal'></span>
											<!-- </div> -->
										</td>
										<td style='width:30%'>
											<span id="button_verify_file_skck_modal"></span>
											<span id="button_unverify_file_skck_modal"></span>
											<!-- <button id="button_verify_file_skck_modal" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>
											<?php //if (($user[0]->user_role_id == "1") || ($user[0]->user_role_id == "11") || ($user[0]->user_role_id == "22") || ($user[0]->user_role_id == "3")) { 
											?>
												<button id="button_unverify_file_skck_modal" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>
											<?php //} 
											?> -->
										</td>
									</tr>
									<tr>
										<td style='width:25%'><strong>File Ijazah <span class="icon-verify-file-ijazah"></span></strong></td>
										<td style='width:75%'>
											<!-- <div class="row align-items-center"> -->
											<span id='display_file_ijazah_modal'></span>
											<input hidden type="text" id="link_file_ijazah_sebelum_modal">
											<input hidden type="text" id="link_file_ijazah_modal">
											<input type="file" class="filepond filepond-input-multiple" multiple id="file_ijazah_modal" data-allow-reorder="true" data-max-file-size="5MB" data-max-files="1" accept="image/png, image/jpeg, application/pdf">
											<span id='pesan_file_ijazah_modal'></span>
											<!-- </div> -->
										</td>
										<td style='width:30%'>
											<span id="button_verify_file_ijazah_modal"></span>
											<span id="button_unverify_file_ijazah_modal"></span>
											<!-- <button id="button_verify_file_ijazah_modal" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>
											<?php //if (($user[0]->user_role_id == "1") || ($user[0]->user_role_id == "11") || ($user[0]->user_role_id == "22") || ($user[0]->user_role_id == "3")) { 
											?>
												<button id="button_unverify_file_ijazah_modal" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>
											<?php //} 
											?> -->
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- <div class="row">
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
						</div> -->
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

<!-- MODAL UNTUK PROSES -->
<div class="modal fade" id="processModal" role="dialog" aria-labelledby="processModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="processModalLabel">
					<div class="judul-modal">
						<span id="judul-modal-process"></span>
					</div>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!-- <iframe src="" style="zoom:0.60" frameborder="0" height="250" width="99.6%"></iframe> -->
				<div id="isi-modal-process"></div>
				<div id="pesan-isi-modal-process"></div>
			</div>
			<div class="modal-footer">
				<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
			</div>
		</div>
	</div>
</div>

<!-- SECTION FILTER -->
<!-- <pre>
	<?php //print_r($session); 
	?>
</pre> -->
<div class="card border-blue">
	<div class="card-header with-elements">
		<div class="col-md-6">
			<span class="card-header-title mr-2"><strong>MANAGE EMPLOYEES | </strong>FILTER</span>
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

		<?php echo form_open_multipart('/admin/importexcel/import_saltab3/'); ?>

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
					<button name="filter_employee" id="filter_employee" class="btn btn-primary btn-block"><i class="fa fa-search"></i> FILTER</button>
				</div>
			</div>
		</div>

		<?php echo form_close(); ?>

	</div>
</div>

<!-- SECTION DATA TABLES -->
<div class="row m-b-1 <?php echo $get_animate; ?>">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header with-elements">
				<div class="col-md-6">
					<span class="card-header-title mr-2"><strong>LIST EMPLOYEES</strong></span>
				</div>

				<div class="col-md-6">
					<div class="pull-right">
						<!-- <div class="card-header with-elements"> -->
						<span class="card-header-title mr-2">
							<button hidden id="button_download_data" class="btn btn-success" data-style="expand-right">Download Data</button>
							<?php if (($user_info[0]->user_role_id == "1") || ($user_info[0]->user_role_id == "3") || ($user_info[0]->user_role_id == "11")) { ?>
								<button hidden onclick="download_data_broadcast()" id="button_download_data_broadcast" class="btn btn-success ladda-button" data-style="expand-right">Download Data Broadcast</button>
							<?php } ?>
						</span>
					</div>
				</div>
			</div>

			<!-- <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>LIST EMPLOYEES</strong></span> </div> -->
			<div class="card-body">
				<!-- <div class="box-datatable table-responsive" id="btn-place">
          <table class="display dataTable table table-striped table-bordered" id="tabel_employees2" style="width:100%">
            <thead>
              <tr>
                <th>Aksi</th>
                <th>Periode Salary</th>
                <th>Periode Cutoff</th>
                <th>Project</th>
                <th>Sub Project</th>
                <th>Total MPP</th>
                <th>Release by</th>
                <th>Release on</th>
              </tr>
            </thead>
          </table>
        </div> -->
				<div class="box-datatable table-responsive">
					<table class="datatables-demo table table-striped table-bordered" id="tabel_employees">
						<thead>
							<tr>
								<th>Aksi</th>
								<th>NIP - PIN - Status</th>
								<th>NIK</th>
								<th>Nama Lengkap</th>
								<th>Verifikasi</th>
								<th>Project</th>
								<th>Sub Project</th>
								<th>Jabatan</th>
								<th>Penempatan</th>
								<th>Periode Kontrak</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- filepond js -->
<script src="<?= base_url() ?>assets/libs/filepond/filepond.min.js"></script>
<script src="<?= base_url() ?>assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js"></script>
<script src="<?= base_url() ?>assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js"></script>
<script src="<?= base_url() ?>assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js"></script>
<script src="<?= base_url() ?>assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js"></script>
<script src="<?= base_url() ?>assets/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.js"></script>
<script src="<?= base_url() ?>assets/libs/filepond-plugin-file-rename/filepond-plugin-file-rename.js"></script>
<!-- <script src="assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.js"></script> -->

<script type="text/javascript">
	//global variable
	var employee_table;
	var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
		csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
	var session_id = '<?php echo $session['employee_id']; ?>';

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

	FilePond.registerPlugin(
		FilePondPluginFileEncode,
		FilePondPluginFileValidateType,
		FilePondPluginFileValidateSize,
		FilePondPluginFileRename,
		// FilePondPluginImageEdit,
		FilePondPluginImageExifOrientation,
		FilePondPluginImagePreview
	);

	//----------BEGIN FILEPOND EDIT DOKUMEN KANDIDAT----------------------------

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

	//create object filepond untuk file buku tabungan
	var pond_file_buku_tabungan_modal = FilePond.create(document.querySelector('input[id="file_buku_tabungan_modal"]'), {
		labelIdle: 'Drag & Drop file buku tabungan atau <span class="filepond--label-action">Browse</span>',
		imagePreviewHeight: 170,
		maxFileSize: "25MB",
		// acceptedFileTypes: ['image/png', 'image/jpeg'],
		imageCropAspectRatio: "1:1",
		imageResizeTargetWidth: 200,
		imageResizeTargetHeight: 200,
		fileRenameFunction: (file) => {
			return `file_buku_tabungan${file.extension}`;
		}
	});

	//----------END FILEPOND EDIT DOKUMEN KANDIDAT----------------------------

	$(document).ready(function() {
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({
			width: '100%'
		});

		$('[data-plugin="select_modal_verifikasi"]').select2({
			width: "100%",
			dropdownParent: $("#container_modal_verifikasi")
		});

		var project = document.getElementById("aj_project").value;
		var sub_project = document.getElementById("aj_sub_project").value;
		var status = document.getElementById("status").value;
		var search_periode_from = "";
		var search_periode_to = "";

		employee_table = $('#tabel_employees').DataTable().on('search.dt', () => eventFired('Search'));

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
	});
</script>

<!-- Tombol Send PIN -->
<script type="text/javascript">
	function send_pin(nomor_kontak, first_name, employee_id, private_code, project_name, penempatan, company_name, id_kontrak) {
		// alert("masuk button send pin");
		// var first_name = '<?php //echo $first_name; 
								?>';
		// var employee_id = '<?php //echo $employee_id; 
								?>';
		// var private_code = '<?php //echo $private_code; 
								?>';
		// var project_name = '<?php //echo $project_name; 
								?>';
		// var nomor_kontak = '<?php //echo $this->Xin_model->clean_post($contact_no); 
								?>';

		var pesan_whatsapp = '*[ HR-SYSTEM NOTIFIKASI ]*\n\n' +
			'Karyawan Aktif *' + company_name +
			'*\n\nNama Lengkap: *' + first_name +
			'*\nNIP: *' + employee_id +
			'*\nPIN: *' + private_code +
			'*\nPROJECT: *' + project_name +
			'*\nAREA: *' + penempatan +
			'* \n\nSilahkan Login C.I.S Menggunakan NIP dan PIN anda melalui Link Dibawah ini.' +
			'\nLink C.I.S : https://apps-cakrawala.com/admin\n' +
			'Lakukan Pembaharuan PIN anda secara berkala, dengan cara, Pilih Menu *My Profile* kemudian *Ubah Pin*\n\n' +
			'*INFO HRD di Nomor Whatsapp: 088211158907* \n' +
			'*IT-CARE di Nomor Whatsapp: 085174123434* \n\n' +
			'Terima kasih.';

		// window.open("https://wa.me/62" + nomor_kontak + "?text=" + pesan_whatsapp, "_blank");
		// AJAX untuk ambil data buku tabungan employee terupdate
		$.ajax({
			url: '<?= base_url() ?>admin/Employees/send_pin/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				nomor_kontak: nomor_kontak,
				first_name: first_name,
				employee_id: employee_id,
				private_code: private_code,
				project_name: project_name,
				penempatan: penempatan,
				id_kontrak: id_kontrak,
				pesan_whatsapp: pesan_whatsapp,
			},
			beforeSend: function() {
				$('#judul-modal-process').html("Send PIN");
				// $('#button_download_dokumen_conditional').html("");
				$('#isi-modal-process').html(sending_html_text);
				// $('#button_save_pin').attr("hidden", true);
				$('#processModal').appendTo("body").modal('show');
			},
			success: function(response) {

				var res = jQuery.parseJSON(response);

				if (res['status'] == "200") {
					$('#isi-modal-process').html("<h2>Berhasil kirim PIN</h2>");

					var searchVal_before = $('#tabel_employees_filter').find('input').val();

					// alert("Searchval before: " + searchVal_before);

					employee_table.destroy();

					var project = document.getElementById("aj_project").value;
					var sub_project = document.getElementById("aj_sub_project").value;
					var status = document.getElementById("status").value;

					// $('#tabel_employees_filter').find('input').val(searchVal_before);

					var searchVal = $('#tabel_employees_filter').find('input').val();

					// alert("Searchval after: " + searchVal);

					if ((searchVal == "") && (project == "0")) {
						$('#button_download_data').attr("hidden", true);
						$('#button_download_data_broadcast').attr("hidden", true);

					} else {
						$('#button_download_data').attr("hidden", false);
						$('#button_download_data_broadcast').attr("hidden", false);

						employee_table = $('#tabel_employees').DataTable({
							"search": {
								"search": searchVal_before
							},
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
							'order': [
								[3, 'asc']
							],
							'ajax': {
								'url': '<?= base_url() ?>admin/reports/list_employees',
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
									data: 'ktp_no',
									"orderable": false,
									//searchable: true
								},
								{
									data: 'first_name',
									// "orderable": false,
									//searchable: true
								},
								{
									data: 'verifikasi',
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
									// "orderable": false,
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
					// alert("Berhasil kirim PIN");
				} else {
					var message_gagal = "<h2>Gagal kirim PIN</h2>";
					message_gagal = message_gagal + "<h3><br>Kode Error: " + res['status'];
					message_gagal = message_gagal + "<br>" + res['message'] + "</h3>";
					$('#isi-modal-process').html(message_gagal);
					// alert("Gagal kirim whatsapp");
				}

				// if (res['status']['filename_ktp'] == "200") {
				// 	var nama_file = res['data']['filename_ktp'];
				// 	var tipe_file = nama_file.substr(-3, 3);
				// 	var atribut = "";
				// 	var height = '';
				// 	var d = new Date();
				// 	var time = d.getTime();
				// 	nama_file = nama_file + "?" + time;

				// 	if (tipe_file == "pdf") {
				// 		atribut = "application/pdf";
				// 		height = 'height="500px"';
				// 	} else {
				// 		atribut = "image/jpg";
				// 	}

				// 	var button_download = "<a href='" + nama_file + "' target='_blank'><button type='button' class='btn btn-sm btn-outline-success mx-2'>Download File</button></a>";

				// 	$('#button_download_dokumen_conditional').html(button_download);

				// 	var html_text = '<embed ' + height + ' class="col-md-12" type="' + atribut + '" src="' + nama_file + '"></embed>';

				// 	$('.isi-modal').html(html_text);
				// 	$('#button_save_pin').attr("hidden", true);
				// } else {
				// 	html_text = res['pesan']['filename_ktp'];
				// 	$('.isi-modal').html(html_text);
				// 	$('#button_save_pin').attr("hidden", true);
				// }
			},
			error: function(xhr, status, error) {
				html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
				html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
				// html_text = "Gagal fetch data. Kode error: " + xhr.status;
				// $('.isi-modal').html(html_text); //coba pake iframe
				// $('#button_save_pin').attr("hidden", true);
			}
		});

	};
</script>

<!-- Tombol Filter -->
<script type="text/javascript">
	document.getElementById("filter_employee").onclick = function(e) {
		employee_table.destroy();

		e.preventDefault();

		var project = document.getElementById("aj_project").value;
		var sub_project = document.getElementById("aj_sub_project").value;
		var status = document.getElementById("status").value;

		var searchVal = $('#tabel_employees_filter').find('input').val();

		if ((searchVal == "") && (project == "0")) {
			$('#button_download_data').attr("hidden", true);
			$('#button_download_data_broadcast').attr("hidden", true);

		} else {
			$('#button_download_data').attr("hidden", false);
			$('#button_download_data_broadcast').attr("hidden", false);

			employee_table = $('#tabel_employees').DataTable({
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
				'order': [
					[3, 'asc']
				],
				'ajax': {
					'url': '<?= base_url() ?>admin/reports/list_employees',
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
						data: 'ktp_no',
						"orderable": false,
						//searchable: true
					},
					{
						data: 'first_name',
						// "orderable": false,
						//searchable: true
					},
					{
						data: 'verifikasi',
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
						// "orderable": false,
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
	document.getElementById("button_download_data").onclick = function(e) {
		var project = document.getElementById("aj_project").value;
		var sub_project = document.getElementById("aj_sub_project").value;
		var status = document.getElementById("status").value;

		// ambil input search dari datatable
		var filter = $('.dataTables_filter input').val(); //cara 1
		var searchVal = $('#tabel_employees_filter').find('input').val(); //cara 2

		if (searchVal == "") {
			searchVal = "-no_input-";
		}

		var text_pesan = "Project: " + project;
		text_pesan = text_pesan + "\nSub Project: " + sub_project;
		text_pesan = text_pesan + "\nStatus: " + status;
		text_pesan = text_pesan + "\nSearch: " + searchVal;
		// alert(text_pesan);

		window.open('<?php echo base_url(); ?>admin/reports/printExcel/' + project + '/' + sub_project + '/' + status + '/' + searchVal + '/' + session_id + '/', '_self');

	};

	function download_data_broadcast() {
		var project = document.getElementById("aj_project").value;
		var sub_project = document.getElementById("aj_sub_project").value;
		var status = document.getElementById("status").value;

		// ambil input search dari datatable
		var filter = $('.dataTables_filter input').val(); //cara 1
		var searchVal = $('#tabel_employees_filter').find('input').val(); //cara 2

		if (searchVal == "") {
			searchVal = "-no_input-";
		}

		var text_pesan = "Project: " + project;
		text_pesan = text_pesan + "\nSub Project: " + sub_project;
		text_pesan = text_pesan + "\nStatus: " + status;
		text_pesan = text_pesan + "\nSearch: " + searchVal;
		// alert(text_pesan);

		window.open('<?php echo base_url(); ?>admin/reports/printExcelBroadcast/' + project + '/' + sub_project + '/' + status + '/' + searchVal + '/' + session_id + '/', '_self');

	};

	//-----lihat employee-----
	function viewEmployee(id) {
		//alert("masuk fungsi lihat. id: " + id);
		window.open('<?= base_url() ?>admin/employees/emp_view/' + id, "_blank");
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
			$('#button_download_data_broadcast').attr("hidden", true);
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
			$('#button_download_data_broadcast').attr("hidden", false);
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

<!-- Tombol Open Kontrak -->
<script type="text/javascript">
	function open_kontrak(kontrakid) {
		// alert(uniqueid);
		// AJAX untuk ambil data kontrak employee terupdate
		$.ajax({
			url: '<?= base_url() ?>admin/Employees/get_data_dokumen_kontrak/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				kontrakid: kontrakid,
			},
			beforeSend: function() {
				$('#judul-modal-edit').html("File Kontrak");
				$('#button_download_dokumen_conditional').html("");
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

					// var html_text = "";
					// html_text = html_text + '<embed ' + height + ' class="col-md-12" type="' + atribut + '" src="' + nama_file + '"></embed>';
					var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-lg btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE KONTRAK</button></a></br><object height="500px" data="' + nama_file + '" type="application/pdf" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';

					$('.isi-modal').html(html_text);
					// $('#button_save_pin').attr("hidden", true);
				} else {
					html_text = res['pesan'];
					$('.isi-modal').html(html_text);
					// $('#button_save_pin').attr("hidden", true);
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

<!-- Tombol Lihat Draft Kontrak -->
<script type="text/javascript">
	function open_draft_kontrak(uniqueid, sub_project) {
		//testing
		// alert(uniqueid);
		// alert(sub_project);

		var d = new Date();
		var time = d.getTime();

		var link_eslip = '<?= base_url() ?>admin/pkwt' + sub_project + '/view/' + uniqueid + '?' + time;


		// var link_eslip = '<?= base_url() ?>admin/pkwt' + sub_project + '/view/' + uniqueid;
		var html_text = '<a href="' + link_eslip + '" target="_blank"><button class="btn btn-lg btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE KONTRAK</button></a></br><object height="500px" data="' + link_eslip + '" type="application/pdf" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
		// var html_text = '<embed height="500px" class="col-md-12" type="application/pdf" src="https://docs.google.com/viewerng/viewer?url=' + 'https://apps-cakrawala.com/admin/pkwt1/view/bYqHsn9BkHeoaumXMggr' + '&embedded=true"></embed>';
		// var html_text = '<embed height="500px" class="col-md-12" type="application/pdf" src="https://docs.google.com/viewerng/viewer?url=' + link_eslip + '&embedded=true"></embed>';
		// var html_text = "<iframe src='" + link_eslip + "' style='zoom:1' frameborder='0' height='500' width='100%'></iframe>"

		$('#judul-modal-edit').html("Lihat Draft Kontrak");
		$('#button_download_dokumen_conditional').html("");
		$('.isi-modal').html(html_text);
		$('#button_save_pin').attr("hidden", true);
		$('#editModal').appendTo("body").modal('show');

	}

	// $('.isi-modal').change(function() {
	// 	$('.pesan-isi-modal').html("LOADING");
	// });

	// document.getElementById("dokumen_object").contentWindow.onloadstart = function() {
	//   $('.pesan-isi-modal').html("LOADING");
	// };
</script>

<!-- Tombol Verifikasi -->
<script type="text/javascript">
	function verifikasi(nip) {
		// alert("Under Construction. Masuk button verifikasi");

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
		$('#link_file_buku_tabungan_modal').val("");
		$('#link_file_cv_modal').val("");
		$('#link_file_skck_modal').val("");
		$('#link_file_ijazah_modal').val("");

		//inisialisasi attribut input
		$('#file_ktp_modal').prop("hidden", false);
		$('#file_kk_modal').prop("hidden", false);
		$('#file_buku_tabungan_modal').prop("hidden", false);
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
		$('#pesan_file_buku_tabungan_modal').html("");
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
		$('#button_verify_file_buku_tabungan_modal').html("");
		$('#button_unverify_file_buku_tabungan_modal').html("");
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
			url: '<?= base_url() ?>admin/Employees/get_data_diri/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				nip: nip,
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
					$('#nik_modal_sebelum_verifikasi').val(res['data']['ktp_no']);
					$("#kk_modal_sebelum").val(res['data']['kk_no']);
					$('#nama_modal_sebelum').val(res['data']['first_name']);
					$("#bank_modal_sebelum").val(res['data']['bank_name']).change();
					$('#rekening_modal_sebelum').val(res['data']['nomor_rek']);
					$('#pemilik_rekening_modal_sebelum').val(res['data']['pemilik_rek']);

					$('#nik_modal_verifikasi').val(res['data']['ktp_no']);
					$("#kk_modal").val(res['data']['kk_no']);
					$('#nama_modal').val(res['data']['first_name']);
					$("#bank_modal").val(res['data']['bank_name']).change();
					$('#rekening_modal').val(res['data']['nomor_rek']);
					$('#pemilik_rekening_modal').val(res['data']['pemilik_rek']);

					//isi dokumen
					$.ajax({
						url: '<?= base_url() ?>admin/Employees/get_data_dokumen_pribadi/',
						method: 'post',
						data: {
							[csrfName]: csrfHash,
							nip: nip,
						},
						// beforeSend: function() {
						// 	$('.ktp-modal').html(loading_html_text);
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
									height = 'height="500px"';
								} else {
									atribut = "image/jpg";
								}

								var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
								$('#display_file_ktp_modal').html(html_text);
							} else {
								$('#link_file_ktp_sebelum_modal').val(res2['database_record']['filename_ktp']);
								var html_text = '<strong>' + res2['pesan']['filename_ktp'] + '</strong>';
								$('#display_file_ktp_modal').html(html_text);
							}

							//append nip dan identifier ke objek filepond file ktp
							pond_file_ktp_modal.setOptions({
								server: {
									process: {
										url: '<?php echo base_url() ?>admin/Employees/upload_dokumen',
										method: 'POST',
										ondata: (formData) => {
											formData.append('nip', nip);
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
												var nama_file = '<?= base_url() ?>' + serverResponse['0']['link_file'];
												var tipe_file = nama_file.slice(-3);
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

												var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
												$('#display_file_ktp_modal').html(html_text);

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
									height = 'height="500px"';
								} else {
									atribut = "image/jpg";
								}

								var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
								$('#display_file_kk_modal').html(html_text);
							} else {
								$('#link_file_kk_sebelum_modal').val(res2['database_record']['filename_kk']);
								var html_text = '<strong>' + res2['pesan']['filename_kk'] + '</strong>';
								$('#display_file_kk_modal').html(html_text);
							}

							//append nip dan identifier ke objek filepond file kk
							pond_file_kk_modal.setOptions({
								server: {
									process: {
										url: '<?php echo base_url() ?>admin/Employees/upload_dokumen',
										method: 'POST',
										ondata: (formData) => {
											formData.append('nip', nip);
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
												var nama_file = '<?= base_url() ?>' + serverResponse['0']['link_file'];
												var tipe_file = nama_file.slice(-3);
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

												var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
												$('#display_file_kk_modal').html(html_text);

												$('#link_file_kk_modal').val(serverResponse['0']['link_file']);

												// alert($('#link_file_kk_modal').val());

												pond_file_kk_modal.removeFile();
											}
										}
									}
								}
							});

							//dokumen Buku tabungan
							if (res2['status']['filename_rek'] == "200") {
								var nama_file = res2['data']['filename_rek'];
								$('#link_file_buku_tabungan_sebelum_modal').val(res2['database_record']['filename_rek']);
								$('#link_file_buku_tabungan_modal').val(res2['database_record']['filename_rek']);
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

								var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
								$('#display_file_buku_tabungan_modal').html(html_text);
							} else {
								$('#link_file_buku_tabungan_sebelum_modal').val(res2['database_record']['filename_rek']);
								var html_text = '<strong>' + res2['pesan']['filename_rek'] + '</strong>';
								$('#display_file_buku_tabungan_modal').html(html_text);
							}

							//append nip dan identifier ke objek filepond file buku tabungan
							pond_file_buku_tabungan_modal.setOptions({
								server: {
									process: {
										url: '<?php echo base_url() ?>admin/Employees/upload_dokumen',
										method: 'POST',
										ondata: (formData) => {
											formData.append('nip', nip);
											formData.append('identifier', 'rekening');
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
												var nama_file = '<?= base_url() ?>' + serverResponse['0']['link_file'];
												var tipe_file = nama_file.slice(-3);
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

												var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
												$('#display_file_buku_tabungan_modal').html(html_text);

												$('#link_file_buku_tabungan_modal').val(serverResponse['0']['link_file']);

												// alert($('#link_file_buku_tabungan_modal').val());

												pond_file_buku_tabungan_modal.removeFile();
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
									height = 'height="500px"';
								} else {
									atribut = "image/jpg";
								}

								var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
								$('#display_file_cv_modal').html(html_text);
							} else {
								$('#link_file_cv_sebelum_modal').val(res2['database_record']['filename_cv']);
								var html_text = '<strong>' + res2['pesan']['filename_cv'] + '</strong>';
								$('#display_file_cv_modal').html(html_text);
							}

							//append nip dan identifier ke objek filepond file cv
							pond_file_cv_modal.setOptions({
								server: {
									process: {
										url: '<?php echo base_url() ?>admin/Employees/upload_dokumen',
										method: 'POST',
										ondata: (formData) => {
											formData.append('nip', nip);
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
												var nama_file = '<?= base_url() ?>' + serverResponse['0']['link_file'];
												var tipe_file = nama_file.slice(-3);
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

												var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
												$('#display_file_cv_modal').html(html_text);

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
									height = 'height="500px"';
								} else {
									atribut = "image/jpg";
								}

								var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
								$('#display_file_skck_modal').html(html_text);
							} else {
								$('#link_file_skck_sebelum_modal').val(res2['database_record']['filename_skck']);
								var html_text = '<strong>' + res2['pesan']['filename_skck'] + '</strong>';
								$('#display_file_skck_modal').html(html_text);
							}

							//append nip dan identifier ke objek filepond file skck
							pond_file_skck_modal.setOptions({
								server: {
									process: {
										url: '<?php echo base_url() ?>admin/Employees/upload_dokumen',
										method: 'POST',
										ondata: (formData) => {
											formData.append('nip', nip);
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
												var nama_file = '<?= base_url() ?>' + serverResponse['0']['link_file'];
												var tipe_file = nama_file.slice(-3);
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

												var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
												$('#display_file_skck_modal').html(html_text);

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
									height = 'height="500px"';
								} else {
									atribut = "image/jpg";
								}

								var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
								$('#display_file_ijazah_modal').html(html_text);
							} else {
								$('#link_file_ijazah_sebelum_modal').val(res2['database_record']['filename_isd']);
								var html_text = '<strong>' + res2['pesan']['filename_isd'] + '</strong>';
								$('#display_file_ijazah_modal').html(html_text);
							}

							//append nip dan identifier ke objek filepond file ijazah
							pond_file_ijazah_modal.setOptions({
								server: {
									process: {
										url: '<?php echo base_url() ?>admin/Employees/upload_dokumen',
										method: 'POST',
										ondata: (formData) => {
											formData.append('nip', nip);
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
												var nama_file = '<?= base_url() ?>' + serverResponse['0']['link_file'];
												var tipe_file = nama_file.slice(-3);
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

												var html_text = '<a href="' + nama_file + '" target="_blank"><button class="btn btn-sm btn-outline-primary ladda-button my-1 mx-1 col-12" data-style="expand-right">DOWNLOAD FILE</button></a></br><object ' + height + ' data="' + nama_file + '" type="' + atribut + '" width="100%"><p>Klik tombol diatas untuk download file.</p></object>';
												$('#display_file_ijazah_modal').html(html_text);

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
								$('#button_verify_file_ktp_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'dokumen_ktp\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');
								// if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
								// 	$('#button_unverify_file_ktp_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'dokumen_ktp\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
									$('#button_unverify_file_ktp_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'dokumen_ktp\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
								$('#button_verify_nik_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'nik\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

								$('#button_unverify_nik_modal').html('');

								//icon
								$('.icon-verify-nik').html(res['data']['validate_nik']);

								//attribut input
								$('#nik_modal_verifikasi').prop('readonly', false);
							} else {
								//button
								$('#button_verify_nik_modal').html('');
								if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
									$('#button_unverify_nik_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'nik\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
								$('#button_verify_nama_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'nama\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

								$('#button_unverify_nama_modal').html('');

								//icon
								$('.icon-verify-nama').html(res['data']['validate_nama']);

								//attribut input
								$('#nama_modal').prop('readonly', false);
							} else {
								//button
								$('#button_verify_nama_modal').html('');
								if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
									$('#button_unverify_nama_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'nama\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
								$('#button_verify_file_kk_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'dokumen_kk\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

								$('#button_unverify_file_kk_modal').html('');

								//icon
								$('.icon-verify-file-kk').html(res['data']['validate_dokumen_kk']);

								//attribut input
								$('#file_kk_modal').prop("hidden", false);
							} else {
								//button
								$('#button_verify_file_kk_modal').html('');
								if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
									$('#button_unverify_file_kk_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'dokumen_kk\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
								$('#button_verify_kk_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'kk\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

								$('#button_unverify_kk_modal').html('');

								//icon
								$('.icon-verify-kk').html(res['data']['validate_kk']);

								//attribut input
								$('#kk_modal').prop('readonly', false);
							} else {
								//button
								$('#button_verify_kk_modal').html('');
								if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
									$('#button_unverify_kk_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'kk\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
								} else {
									$('#button_unverify_kk_modal').html('');
								}

								//icon
								$('.icon-verify-kk').html(res['data']['validate_kk']);

								//attribut input
								$('#kk_modal').prop('readonly', true);
							}
							//FILE BUKU TABUNGAN
							if (res['data']['buku_rekening_validation'] == "0") {
								//button
								$('#button_verify_file_buku_tabungan_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'buku_rekening\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

								$('#button_unverify_file_buku_tabungan_modal').html('');

								//icon
								$('.icon-verify-file-buku-tabungan').html(res['data']['validate_buku_rekening']);

								//attribut input
								$('#file_buku_tabungan_modal').prop("hidden", false);
							} else {
								//button
								$('#button_verify_file_buku_tabungan_modal').html('');
								if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
									$('#button_unverify_file_buku_tabungan_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'buku_rekening\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
								} else {
									$('#button_unverify_file_buku_tabungan_modal').html('');
								}

								//icon
								$('.icon-verify-file-buku-tabungan').html(res['data']['validate_buku_rekening']);

								//attribut input
								$('#file_buku_tabungan_modal').prop("hidden", true);
							}
							//BANK
							if (res['data']['bank_validation'] == "0") {
								//button
								$('#button_verify_bank_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'bank\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

								$('#button_unverify_bank_modal').html('');

								//icon
								$('.icon-verify-bank').html(res['data']['validate_bank']);

								//attribut input
								$('#bank_modal').prop('disabled', false);
							} else {
								//button
								$('#button_verify_bank_modal').html('');
								if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
									$('#button_unverify_bank_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'bank\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
								$('#button_verify_norek_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'norek\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

								$('#button_unverify_norek_modal').html('');

								//icon
								$('.icon-verify-norek').html(res['data']['validate_norek']);

								//attribut input
								$('#rekening_modal').prop('readonly', false);
							} else {
								//button
								$('#button_verify_norek_modal').html('');
								if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
									$('#button_unverify_norek_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'norek\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
								$('#button_verify_pemilik_rek_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'pemilik_rekening\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

								$('#button_unverify_pemilik_rek_modal').html('');

								//icon
								$('.icon-verify-pemilik-rek').html(res['data']['validate_pemilik_rekening']);

								//attribut input
								$('#pemilik_rekening_modal').prop('readonly', false);
							} else {
								//button
								$('#button_verify_pemilik_rek_modal').html('');
								if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
									$('#button_unverify_pemilik_rek_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'pemilik_rekening\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
								$('#button_verify_file_cv_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'cv\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

								$('#button_unverify_file_cv_modal').html('');

								//icon
								$('.icon-verify-file-cv').html(res['data']['validate_cv']);

								//attribut input
								$('#file_cv_modal').prop("hidden", false);
							} else {
								//button
								$('#button_verify_file_cv_modal').html('');
								if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
									$('#button_unverify_file_cv_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'cv\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
								$('#button_verify_file_skck_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'skck\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

								$('#button_unverify_file_skck_modal').html('');

								//icon
								$('.icon-verify-file-skck').html(res['data']['validate_skck']);

								//attribut input
								$('#file_skck_modal').prop("hidden", false);
							} else {
								//button
								$('#button_verify_file_skck_modal').html('');
								if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
									$('#button_unverify_file_skck_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'skck\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
								$('#button_verify_file_ijazah_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'ijazah\',\'' + res['data']['verification_id'] + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

								$('#button_unverify_file_ijazah_modal').html('');

								//icon
								$('.icon-verify-file-ijazah').html(res['data']['validate_ijazah']);

								//attribut input
								$('#file_ijazah_modal').prop("hidden", false);
							} else {
								//button
								$('#button_verify_file_ijazah_modal').html('');
								if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
									$('#button_unverify_file_ijazah_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'ijazah\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
							$('#display_file_ktp_modal').html(html_text);
							$('#display_file_kk_modal').html(html_text);
							$('#display_file_buku_tabungan_modal').html(html_text);
							$('#display_file_cv_modal').html(html_text);
							$('#display_file_skck_modal').html(html_text);
							$('#display_file_ijazah_modal').html(html_text);

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

	};
</script>

<!-- Tombol Save Verifikasi Dokumen -->
<script type="text/javascript">
	function save_verifikasi_draft(jenis_dokumen, nip) {
		alert("Coming Soon." + "\nNIP: " + nip + "\nJenis Dokumen: " + jenis_dokumen);
		// $("#tipe_dokumen").val(jenis_dokumen);
		// var kandidat_id = "<?php //echo $id_kandidat; 
								?>";
		// var nama_verifikasi = $("#nama_modal_verifikasi").val();
		// var nik_verifikasi = $("#nik_modal_verifikasi").val();
		// var user_nip = "<?php //echo $isi_session['employee_id']; 
							?>";
		// var user_name = "<?php //echo $isi_session['fullname']; 
							?>";

		// // AJAX save data verifikasi terbaru
		// $.ajax({
		// 	url: '<?= base_url() ?>admin/profile/save_status_verifikasi/',
		// 	method: 'post',
		// 	data: {
		// 		[csrfName]: csrfHash,
		// 		kandidat_id: kandidat_id,
		// 		nama_verifikasi: nama_verifikasi,
		// 		nik_verifikasi: nik_verifikasi,
		// 		user_nip: user_nip,
		// 		user_name: user_name,
		// 		status_verifikasi: "1",
		// 		jenis_dokumen: jenis_dokumen,
		// 	},
		// 	// dataType: 'json',
		// 	beforeSend: function() {
		// 		// $('#judul-modal-edit').html("File KTP");
		// 		// $('#button_download_dokumen_conditional').html("");
		// 		$('.info-modal-verifikasi-screening').html(loading_html_text);
		// 		$('.info-modal-verifikasi-screening').attr("hidden", false);
		// 		$('.isi-modal-verifikasi-screening').attr("hidden", true);
		// 		// $('#verifikasiScreeningModal').appendTo("body").modal('show');
		// 	},
		// 	success: function(response) {
		// 		// alert("sukses ajax");
		// 		var res = jQuery.parseJSON(response);
		// 		var tes = JSON.stringify(response);

		// 		// alert(jenis_dokumen);
		// 		// alert(tes);
		// 		// alert(res["verifikasi"]["status"]);

		// 		if (jenis_dokumen == "nama") {
		// 			// alert("masuk jenis dokumen nama");
		// 			if (res["status_respon"] == "0") {
		// 				// alert("respon 0");
		// 				message_modal = "Gagal verifikasi";
		// 				$('.info-modal-verifikasi-screening').html(message_modal);
		// 				$('.info-modal-verifikasi-screening').attr("hidden", false);
		// 				$('.isi-modal-verifikasi-screening').attr("hidden", true);
		// 				// $('.status_verifikasi_nama_profile').html(icon_not_verified);
		// 			} else if (res["status_respon"] == "1") {
		// 				// alert("respon 1");
		// 				if (res["verifikasi"]["status"] == "1") {
		// 					// alert("status 1");
		// 					$('.status_verifikasi_nama_profile').html(icon_verified);
		// 					$('.display_nama_profile').html(res["verifikasi"]["nilai_sesudah"]);
		// 					// $('#nama_lengkap_tabel').html(res["verifikasi"]["nilai_sesudah"]);
		// 				} else if (res["verifikasi"]["status"] == "0") {
		// 					// alert("status 0");
		// 					$('.status_verifikasi_nama_profile').html(icon_not_verified);
		// 					$('.display_nama_profile').html(res["verifikasi"]["nilai_sesudah"]);
		// 					// $('#nama_lengkap_tabel').html(res["verifikasi"]["nilai_sesudah"]);
		// 				}

		// 				$('.info-modal-verifikasi-screening').html(success_html_text);

		// 				$('#nama_modal_verifikasi').val(res["verifikasi"]["nilai_sesudah"]);
		// 				// $('#nik_modal_verifikasi').val(res["verifikasi"]["nilai_sesudah"]);

		// 				cek_verifikasi();

		// 				$('#verifikasi_ktp_modal').attr("hidden", false);
		// 				$('#verifikasi_kk_modal').attr("hidden", true);
		// 				$('.info-modal-verifikasi-screening').attr("hidden", false);
		// 				$('.isi-modal-verifikasi-screening').attr("hidden", true);
		// 			}
		// 		} else if (jenis_dokumen == "nik") {
		// 			if (res["status_respon"] == "0") {
		// 				message_modal = "Gagal verifikasi";
		// 				$('.info-modal-verifikasi-screening').html(message_modal);
		// 				$('.info-modal-verifikasi-screening').attr("hidden", false);
		// 				$('.isi-modal-verifikasi-screening').attr("hidden", true);
		// 				// $('.status_verifikasi_nama_profile').html(icon_not_verified);
		// 			} else if (res["status_respon"] == "1") {
		// 				if (res["verifikasi"]["status"] == "1") {
		// 					$('.status_verifikasi_ktp_profile').html(icon_verified);
		// 					$('.display_nik_profile').html(res["verifikasi"]["nilai_sesudah"]);
		// 					// $('#nik_name_tabel').html(res["verifikasi"]["nilai_sesudah"]);
		// 				} else if (res["verifikasi"]["status"] == "0") {
		// 					$('.status_verifikasi_ktp_profile').html(icon_not_verified);
		// 					$('.display_nik_profile').html(res["verifikasi"]["nilai_sesudah"]);
		// 					// $('#nik_name_tabel').html(res["verifikasi"]["nilai_sesudah"]);
		// 				}

		// 				$('.info-modal-verifikasi-screening').html(success_html_text);

		// 				// $('#nama_modal_verifikasi').val(res["verifikasi"]["nilai_sesudah"]);
		// 				$('#nik_modal_verifikasi').val(res["verifikasi"]["nilai_sesudah"]);

		// 				cek_verifikasi();

		// 				$('#verifikasi_ktp_modal').attr("hidden", false);
		// 				$('#verifikasi_kk_modal').attr("hidden", true);
		// 				$('.info-modal-verifikasi-screening').attr("hidden", false);
		// 				$('.isi-modal-verifikasi-screening').attr("hidden", true);
		// 			}
		// 		}
		// 	}
		// });
	}
</script>

<!-- Tombol Verifikasi Data NIK -->
<script type="text/javascript">
	function save_verifikasi(nip, jenis_dokumen, verification_id, status) {
		// e.preventDefault();
		// alert("masuk verify nik");base_url
		// alert("Coming Soon." + "\nVerification id: " + verification_id + "\nJenis Dokumen: " + jenis_dokumen);

		var base_url_cis = "<?php echo base_url(); ?>";
		var user_role = <?php echo $user[0]->user_role_id; ?>;
		var verified_by = "<?php echo $user[0]->first_name; ?>";
		var verified_by_id = "<?php echo $session['user_id']; ?>";

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
		} else if (jenis_dokumen == "buku_rekening") {
			var nilai_sebelum = $("#link_file_buku_tabungan_sebelum_modal").val();
			var nilai_sesudah = $("#link_file_buku_tabungan_modal").val();
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
			url: '<?= base_url() ?>admin/Employees/valiadsi_employee_existing/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				employee_id: nip,
				id_employee_request: verification_id,
				kolom: jenis_dokumen,
				nilai_sebelum: nilai_sebelum,
				nilai_sesudah: nilai_sesudah,
				status: status,
				verified_by: verified_by,
				verified_by_id: verified_by_id,
			},
			success: function(response) {
				var res = jQuery.parseJSON(response);

				// alert("NIP: " + nip + "\nVerification id: " + verification_id + "\nJenis Dokumen: " + jenis_dokumen + "\nNilai sebelum: " + nilai_sebelum + "\nNilai Sesudah: " + nilai_sesudah + "\nStatus: " + status + "\nverified_by: " + verified_by + "\nverified_by_id: " + verified_by_id);

				if (jenis_dokumen == "dokumen_ktp") {
					//file KTP
					if (status == "0") {
						//button
						$('#button_verify_file_ktp_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'dokumen_ktp\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');
						// if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
						// 	$('#button_unverify_file_ktp_modal').html('<button onclick="save_verifikasi(\'' + res['data']['employee_id'] + '\',\'dokumen_ktp\',\'' + res['data']['verification_id'] + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
							$('#button_unverify_file_ktp_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'dokumen_ktp\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
						$('#button_verify_nik_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'nik\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

						$('#button_unverify_nik_modal').html('');

						//icon
						$('.icon-verify-nik').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

						//attribut input
						$('#nik_modal_verifikasi').prop('readonly', false);
					} else {
						//button
						$('#button_verify_nik_modal').html('');
						if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
							$('#button_unverify_nik_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'nik\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
						$('#button_verify_nama_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'nama\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

						$('#button_unverify_nama_modal').html('');

						//icon
						$('.icon-verify-nama').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

						//attribut input
						$('#nama_modal').prop('readonly', false);
					} else {
						//button
						$('#button_verify_nama_modal').html('');
						if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
							$('#button_unverify_nama_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'nama\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
						$('#button_verify_file_kk_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'dokumen_kk\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

						$('#button_unverify_file_kk_modal').html('');

						//icon
						$('.icon-verify-file-kk').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

						//attribut input
						$('#file_kk_modal').prop("hidden", false);
					} else {
						//button
						$('#button_verify_file_kk_modal').html('');
						if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
							$('#button_unverify_file_kk_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'dokumen_kk\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
						$('#button_verify_kk_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'kk\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

						$('#button_unverify_kk_modal').html('');

						//icon
						$('.icon-verify-kk').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

						//attribut input
						$('#kk_modal').prop('readonly', false);
					} else {
						//button
						$('#button_verify_kk_modal').html('');
						if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
							$('#button_unverify_kk_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'kk\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
						} else {
							$('#button_unverify_kk_modal').html('');
						}

						//icon
						$('.icon-verify-kk').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

						//attribut input
						$('#kk_modal').prop('readonly', true);
					}
				} else if (jenis_dokumen == "buku_rekening") {
					//FILE BUKU TABUNGAN
					if (status == "0") {
						//button
						$('#button_verify_file_buku_tabungan_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'buku_rekening\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

						$('#button_unverify_file_buku_tabungan_modal').html('');

						//icon
						$('.icon-verify-file-buku-tabungan').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

						//attribut input
						$('#file_buku_tabungan_modal').prop("hidden", false);
					} else {
						//button
						$('#button_verify_file_buku_tabungan_modal').html('');
						if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
							$('#button_unverify_file_buku_tabungan_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'buku_rekening\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
						} else {
							$('#button_unverify_file_buku_tabungan_modal').html('');
						}

						//icon
						$('.icon-verify-file-buku-tabungan').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

						//attribut input
						$('#file_buku_tabungan_modal').prop("hidden", true);
					}
				} else if (jenis_dokumen == "bank") {
					//BANK
					if (status == "0") {
						//button
						$('#button_verify_bank_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'bank\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

						$('#button_unverify_bank_modal').html('');

						//icon
						$('.icon-verify-bank').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

						//attribut input
						$('#bank_modal').prop('disabled', false);
					} else {
						//button
						$('#button_verify_bank_modal').html('');
						if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
							$('#button_unverify_bank_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'bank\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
						$('#button_verify_norek_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'norek\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

						$('#button_unverify_norek_modal').html('');

						//icon
						$('.icon-verify-norek').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

						//attribut input
						$('#rekening_modal').prop('readonly', false);
					} else {
						//button
						$('#button_verify_norek_modal').html('');
						if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
							$('#button_unverify_norek_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'norek\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
						$('#button_verify_pemilik_rek_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'pemilik_rekening\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

						$('#button_unverify_pemilik_rek_modal').html('');

						//icon
						$('.icon-verify-pemilik-rek').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

						//attribut input
						$('#pemilik_rekening_modal').prop('readonly', false);
					} else {
						//button
						$('#button_verify_pemilik_rek_modal').html('');
						if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
							$('#button_unverify_pemilik_rek_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'pemilik_rekening\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
						$('#button_verify_file_cv_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'cv\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

						$('#button_unverify_file_cv_modal').html('');

						//icon
						$('.icon-verify-file-cv').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

						//attribut input
						$('#file_cv_modal').prop("hidden", false);
					} else {
						//button
						$('#button_verify_file_cv_modal').html('');
						if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
							$('#button_unverify_file_cv_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'cv\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
						$('#button_verify_file_skck_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'skck\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

						$('#button_unverify_file_skck_modal').html('');

						//icon
						$('.icon-verify-file-skck').html("<img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'>");

						//attribut input
						$('#file_skck_modal').prop("hidden", false);
					} else {
						//button
						$('#button_verify_file_skck_modal').html('');
						if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
							$('#button_unverify_file_skck_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'skck\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
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
						$('#button_verify_file_ijazah_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'ijazah\',\'' + verification_id + '\',\'1\')" class="btn btn-success mr-1 my-1" data-style="expand-right">Verifikasi</button>');

						$('#button_unverify_file_ijazah_modal').html('');

						//icon
						$('.icon-verify-file-ijazah').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

						//attribut input
						$('#file_ijazah_modal').prop("hidden", false);
					} else {
						//button
						$('#button_verify_file_ijazah_modal').html('');
						if ((user_role == "1") || (user_role == "11") || (user_role == "22") || (user_role == "3")) {
							$('#button_unverify_file_ijazah_modal').html('<button onclick="save_verifikasi(\'' + nip + '\',\'ijazah\',\'' + verification_id + '\',\'0\')" class="btn btn-danger mr-1 my-1" data-style="expand-right">Cancel</button>');
						} else {
							$('#button_unverify_file_ijazah_modal').html('');
						}

						//icon
						$('.icon-verify-file-ijazah').html("<img src='<?php echo base_url('/assets/icon/verified.png'); ?>' width='20'>");

						//attribut input
						$('#file_ijazah_modal').prop("hidden", true);
					}
				}
				alert("Berhasil melakukan verifikasi");
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