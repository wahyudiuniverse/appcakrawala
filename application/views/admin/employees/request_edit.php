<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $system = $this->Xin_model->read_setting_info(1);
$sub_project_id = $sub_project; ?>
<?php $count_emp_request_cancel = '-'; ?>
<?php $count_emp_request_nae = $this->Xin_model->count_emp_request_nae($session['employee_id']); ?>
<?php $count_emp_request_nom = $this->Xin_model->count_emp_request_nom($session['employee_id']); ?>
<?php $count_emp_request_hrd = $this->Xin_model->count_emp_request_hrd($session['employee_id']); ?>



<?php //$list_bank = $this->Xin_model->get_bank_code();
?>
<!-- $data['list_bank'] = $this->Xin_model->get_bank_code(); -->

<hr class="border-light m-0 mb-3">
<?php $employee_id = $this->Xin_model->generate_random_employeeid(); ?>
<?php $employee_pincode = $this->Xin_model->generate_random_pincode(); ?>

<!-- Filepond css -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/filepond/filepond.min.css" type="text/css" />
<!-- <link href="assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="<?= base_url() ?>assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css">

<!-- MODAL UNTUK VERIFIKASI V2-->
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
								<div class="col-md-8">
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
								<div class="col-md-6">
									<div class="form-group">
										<label for="nomor_ktp" class="control-label">Nomor KTP<i class="hrpremium-asterisk">*</i></label>
										<span class="icon-verify-nik"></span>
										<input class="form-control" placeholder="Nomor KTP" name="nomor_ktp" id="nomor_ktp" type="text" value="<?php echo $ktp_no; ?>" maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
									</div>
								</div>

								<!--NOMOR KK-->
								<div class="col-md-6">
									<div class="form-group">
										<label for="nomor_kk" class="control-label">Nomor KK<i class="hrpremium-asterisk">*</i></label>
										<span class="icon-verify-kk"></span>
										<input class="form-control" placeholder="Nomor KK" name="nomor_kk" id="nomor_kk" type="text" value="<?php echo $kk_no; ?>" maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
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
										<label for="pemilik_rekening" class="control-label">Pemilik Rekening<i class="hrpremium-asterisk">*</i></label><span class="icon-verify-pemilik-rek"></span>
										<input class="form-control" placeholder="Nama Pemilik Rekening" id="pemilik_rekening" name="pemilik_rekening" type="text" value="<?php echo $pemilik_rek; ?>">
									</div>
								</div>

							</div>

							<div class="row">
								<!--NAMA KONDAR-->
								<div class="col-md-4">
									<div class="form-group">
										<label for="nama_kondar" class="control-label">Nama Kontak Darurat</label>
										<input readonly class="form-control" placeholder="Nama Kontak Darurat" id="nama_kondar" name="nama_kondar" type="text" value="<?php echo $nama_kontak_darurat; ?>">
									</div>
								</div>

								<!--HUBUNGAN KONDAR-->
								<div class="col-md-4">
									<div class="form-group">
										<label for="hubungan_kondar" class="control-label">Hubungan Kontak Darurat</label>
										<input readonly class="form-control" placeholder="Hubungan Kontak Darurat" id="hubungan_kondar" name="hubungan_kondar" type="text" value="<?php echo $hubungan_kontak_darurat; ?>">
									</div>
								</div>

								<!--NOMOR TLPN KONDAR-->
								<div class="col-md-4">
									<div class="form-group">
										<label for="nomor_kondar" class="control-label">Nomor Kontak Darurat</label>
										<input readonly class="form-control" placeholder="Nomor Kontak Darurat" id="nomor_kondar" name="nomor_kondar" type="text" value="<?php echo $nomor_kontak_darurat; ?>">
									</div>
								</div>

							</div>
						</div>

						<div class="col-md-6">

							<div class="row">
								<!--PROJECT-->

								<div class="col-md-6">
									<div class="form-group">
										<label for="aj_project"><?php echo $this->lang->line('left_projects'); ?><i class="hrpremium-asterisk">*</i></label>
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
											<option value="<?php echo $sbproject->secid ?>" <?php if ($sub_project_id == $sbproject->secid) : ?> selected <?php endif; ?>><?php echo $sbproject->sub_project_name ?></option>
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

								<!--REGION-->
								<div class="col-md-6">
									<div class="form-group">
										<label for="region">Region</label>
										<input class="form-control" placeholder="Region" name="region" id="region" type="text" value="<?php echo $region_name ?>">
									</div>
								</div>

								<!-- DC -->
								<div class="col-md-6">
									<div class="form-group">
										<label for="dc">DC</label>
										<input class="form-control" placeholder="Penempatan" name="dc" id="dc" type="text" value="<?php echo $dc_name ?>">
									</div>
								</div>

							</div>

							<div class="row">

								<!--REG-TKHL-->
								<div class="col-md-6">

									<div class="form-group">
										<label for="e_status">Jenis Dokumen<i class="hrpremium-asterisk">*</i></label>
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

							<div class="row">
								<!--ALAMAT SESUAI KTP-->
								<div class="col-md-12">
									<div class="form-group">
										<label for="alamat_ktp"><?php echo $this->lang->line('xin_address_1'); ?><i class="hrpremium-asterisk">*</i></label>
										<textarea id="alamat_ktp" name="alamat_ktp" class='form-control' placeholder='Alamat KTP' rows="4"><?php echo $alamat_ktp; ?></textarea>
										<!-- <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1'); ?>" name="alamat_ktp" type="text" value="<?php //echo $alamat_ktp; 
																																												?>"> -->
									</div>
								</div>

								<!--Kota Domisili-->
								<div class="col-md-12">
									<div class="form-group">
										<label for="kota_domisili">Kota Domisili</i></label>
										<input hidden type="text" id="nama_kota_domisili" name="nama_kota_domisili">
										<select class="form-control" id="kota_domisili" name="kota_domisili" data-plugin="xin_select" data-placeholder="Kota Domisili">
											<option value="">Pilih Kota Domisili</option>
											<?php foreach ($all_kabupaten_kota as $kota): ?>
												<option value="<?php echo $kota['id_kab_kota_bps']; ?>" <?php if ($id_kota_domisili == $kota['id_kab_kota_bps']): echo "selected";
																										endif; ?>>[<?php echo strtoupper($kota['provinsi']); ?>] <?php echo strtoupper($kota['nama']); ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>

								<!--ALAMAT DOMISILI-->
								<div class="col-md-12">
									<div class="form-group">
										<label for="alamat_domisili">Alamat Domisili</i></label>
										<textarea id="alamat_domisili" name="alamat_domisili" class='form-control' placeholder='Alamat Domisili' rows="4"><?php echo $alamat_domisili; ?></textarea>
										<!-- <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1'); ?>" name="alamat_domisili" type="text" value="<?php //echo $alamat_domisili; 
																																													?>"> -->
									</div>
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
							<label>Foto KTP</label> <span class="icon-verify-file-ktp"></span>
							<span class="display_file_ktp_modal"></span>
						</div>

						<!-- upload kk -->
						<div class="form-group col-md-2">
							<label>Foto KK</label> <span class="icon-verify-file-kk"></span>
							<span class="display_file_kk_modal"></span>
						</div>

						<!-- upload npwp -->
						<div class="form-group col-md-2">
							<label>Foto NPWP</label>
							<span class="display_file_npwp_modal"></span>
						</div>

						<!-- upload ijazah -->
						<div class="form-group col-md-2">
							<label>Foto Ijazah</label> <span class="icon-verify-file-ijazah"></span>
							<span class="display_file_ijazah_modal"></span>
						</div>

						<!-- upload CV -->
						<div class="form-group col-md-2">
							<label>Foto CV</label> <span class="icon-verify-file-cv"></span>
							<span class="display_file_cv_modal"></span>
						</div>

						<!-- upload SKCK -->
						<div class="form-group col-md-2">
							<label>Foto SKCK</label> <span class="icon-verify-file-skck"></span>
							<span class="display_file_skck_modal"></span>
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
										<label for="tunjangan_jabatan" class="control-label">1) Tunj. Jabatan<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_jabatan" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_jabatan); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah2">
									</div>
								</div>

								<!--TUNJANGAN AREA-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_area" class="control-label">2) Tunj. Area<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_area" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_area); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah3">
									</div>
								</div>

								<!--TUNJANGAN MASA KERJA-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_masakerja">3) Tunj. Masa Kerja<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_masakerja" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_masakerja); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah4">
									</div>
								</div>
							</div>

							<div class="row">

								<!--TUNJANGAN MAKAN-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_makan" class="control-label">4) Tunj. Makan<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_makan" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_konsumsi); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah5">
									</div>
								</div>

								<!--TUNJANGAN TRANSPORT-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_transport" class="control-label">5) Tunj. Transport<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_transport" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_transport); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah6">
									</div>
								</div>

								<!--TUNJANGAN KOMUNIKASI-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_komunikasi" class="control-label">6) Tunj. Komunikasi<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_komunikasi" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_comunication); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah7">
									</div>
								</div>

								<!--TUNJANGAN DEVICE-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_device" class="control-label">7) Tunj. Laptop/HP<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_device" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_device); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah8">
									</div>
								</div>

							</div>

							<div class="row">

								<!--TUNJANGAN TEMPAT TINGGAL-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_tempat_tinggal">8) Tunj. Tempat Tinggal<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_tempat_tinggal" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_residence_cost); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah9">
									</div>
								</div>

								<!--TUNJANGAN RENTAL-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_rental">9) Tunj. Rental<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_rental" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_rent); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah10">
									</div>
								</div>

								<!--TUNJANGAN PARKIR-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_parkir" class="control-label">10) Tunj. Parkir<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_parkir" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_parking); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah11">
									</div>
								</div>

								<!--TUNJANGAN KESEHATAN-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_kesehatan" class="control-label">11) Tunj. Kesehatan<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_kesehatan" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_medicine); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah12">
									</div>
								</div>

							</div>

							<div class="row">

								<!--TUNJANGAN AKOMODASI-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_akomodasi">12) Tunj. Akomodasi<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_akomodasi" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_akomodsasi); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah13">
									</div>
								</div>

								<!--TUNJANGAN KASIR-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_kasir" class="control-label">13) Tunj. Kasir<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_kasir" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_kasir); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah14">
									</div>
								</div>

								<!--TUNJANGAN OPERATIONAL-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_operational" class="control-label">14) Tunj. Operational<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_operational" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_operational); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah15">
									</div>
								</div>

								<!--TUNJANGAN KEAHLIAN-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_keahlian" class="control-label">15) Tunj. Keahlian<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_keahlian" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_skill); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah18">
									</div>
								</div>

							</div>


							<div class="row">

								<!--TUNJANGAN MAKAN TRANSPORT-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_makan_trans" class="control-label">16) Tunj. Makan & Transport<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_makan_trans" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_trans_meal); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah16">
									</div>
								</div>

								<!--TUNJANGAN TRANSPORT RENTAL-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_trans_rent" class="control-label">17) Tunj. Transport & Rental<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_trans_rent" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_trans_rent); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah17">
									</div>
								</div>

								<!--TUNJANGAN PELATIHAN-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_pelatihan" class="control-label">18) Tunj. Pelatihan<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_pelatihan" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_training); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah19">
									</div>
								</div>

								<!--TUNJANGAN PELATIHAN-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_grooming" class="control-label">19) Tunj. Grooming<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_grooming" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_grooming); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah24">
									</div>
								</div>

							</div>

							<div class="row">

								<!--TUNJANGAN KEHADIRAN-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_kehadiran" class="control-label">20) Tunj. Kehadiran<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_kehadiran" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_kehadiran); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah20">
									</div>
								</div>

								<!--TUNJANGAN KINERJA-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_kinerja" class="control-label">21) Tunj. Kinerja<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_kinerja" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_kinerja); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah21">
									</div>
								</div>

								<!--TUNJANGAN DISIPLIN-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_disiplin" class="control-label">22) Tunj. Disiplin<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_disiplin" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_disiplin); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah22">
									</div>
								</div>

								<!--TUNJANGAN OTHER-->
								<div class="col-md-3">
									<div class="form-group">
										<label for="tunjangan_others" class="control-label">23) Tunj. Others<i class="hrpremium-asterisk">*</i></label>
										<input class="form-control" placeholder="0" name="tunjangan_others" type="text" value="<?php echo $this->Xin_model->rupiah_titik($allow_others); ?>" style="text-align: right;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" id="rupiah23">
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
											<option value="11" <?php if ($contract_periode == '11') : ?> selected <?php endif; ?>>11 (Bulan)</option>
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
				<?php echo form_close(); ?>
				<?php if (in_array('1012', $role_resources_ids)) { ?>
					<button onclick="verifikasi(<?php echo $secid; ?>)" id="button_verifikasi" class="btn btn-success ladda-button" data-style="expand-right">Verifikasi Data</button>
				<?php } ?>
			</div>
			<!-- <?php //echo form_close(); 
					?> -->
		</div>
	</div>

	</div>

<?php } ?>

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

	var rupiah20 = document.getElementById("rupiah20");
	rupiah20.addEventListener("keyup", function(e) {
		rupiah20.value = convertRupiah(this.value);
	});

	var rupiah21 = document.getElementById("rupiah21");
	rupiah21.addEventListener("keyup", function(e) {
		rupiah21.value = convertRupiah(this.value);
	});

	var rupiah22 = document.getElementById("rupiah22");
	rupiah22.addEventListener("keyup", function(e) {
		rupiah22.value = convertRupiah(this.value);
	});

	var rupiah23 = document.getElementById("rupiah23");
	rupiah23.addEventListener("keyup", function(e) {
		rupiah23.value = convertRupiah(this.value);
	});

	var rupiah24 = document.getElementById("rupiah24");
	rupiah24.addEventListener("keyup", function(e) {
		rupiah24.value = convertRupiah(this.value);
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
	var employee_id = "<?php print($secid); ?>";

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

	//icon status verifikasi
	$('.icon-verify-file-ktp').html("<?php echo $validate_dokumen_ktp; ?>");
	$('.icon-verify-nik').html("<?php echo $validate_nik; ?>");
	$('.icon-verify-nama').html("<?php echo $validate_nama; ?>");
	$('.icon-verify-file-kk').html("<?php echo $validate_dokumen_kk; ?>");
	$('.icon-verify-kk').html("<?php echo $validate_kk; ?>");
	$('.icon-verify-bank').html("<?php echo $validate_bank; ?>");
	$('.icon-verify-norek').html("<?php echo $validate_norek; ?>");
	$('.icon-verify-pemilik-rek').html("<?php echo $validate_pemilik_rekening; ?>");
	$('.icon-verify-file-cv').html("<?php echo $validate_cv; ?>");
	$('.icon-verify-file-skck').html("<?php echo $validate_skck; ?>");
	$('.icon-verify-file-ijazah').html("<?php echo $validate_ijazah; ?>");
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

		// Kota domisili Change - isi text ke variable hidden bank_name (untuk save)
		$('#kota_domisili').change(function() {
			var id_kota_domisili = $("#kota_domisili").val();
			var nama_kota_domisili = $("#kota_domisili option:selected").text();
			nama_kota_domisili = nama_kota_domisili.trim();

			$("#nama_kota_domisili").val(nama_kota_domisili);

			// alert($("#nama_kota_domisili").val());
			// alert(id_kota_domisili);
		});

		//Display dokumen
		var id_karyawan_request = "<?php print($secid); ?>";
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
	});
</script>

<!-- Tombol Show/hide Rekening Modal -->
<!-- <script type="text/javascript">
	document.getElementById("button_show_rekening_modal").onclick = function(e) {
		e.preventDefault();

		if (flag_rekening == 0) {
			var bank_id = $("#bank_modal").val();
			// var nomor_rekening = "<?php //echo $nomor_rek; 
										?>";
			var nomor_rekening = $("#rekening_modal").val();
			var bank_code = "<?php //echo $nomor_rek; 
								?>";

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
				url: 'https://karir.onecorp.co.id/cross_site/Crosscontroller/tes_API_Bank3/' + bank_id + "/" + nomor_rekening,
				method: 'get',
				success: function(response) {
					// alert(response);
					var res = jQuery.parseJSON(response);
					// var res2 = jQuery.parseJSON(res);
					// html_text = "";
					if (res['success'] == true) {
						html_text = "";
						html_text = html_text + "<div class='row'>";
						html_text = html_text + "<div class='form-group col-md-12'>";
						html_text = html_text + "<label>Rekening  </label>";
						html_text = html_text + "<br>Pesan: " + res['message'] + "<br>";
						html_text = html_text + "nama bank: " + res['data']['account_bank'] + "<br>";
						html_text = html_text + "nomor rekening: " + res['data']['account_number'] + "<br>";
						html_text = html_text + "nama pemilik rekening: " + res['data']['account_holder'] + "<br>";
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
</script> -->

<!-- Tombol Verifikasi -->
<script type="text/javascript">
	function verifikasi(id_karyawan_request) {
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

	};
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
				var id_karyawan_request = "<?php print($secid); ?>";
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
