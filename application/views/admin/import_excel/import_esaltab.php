<!-- Filepond css -->
<link rel="stylesheet" href="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond/filepond.min.css" type="text/css" />
<!-- <link href="assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css" type="text/css" />

<?php
/* Employee Import view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<!-- START MODAL IMPORT SALTAB -->
<div class="modal fade" id="importSaltabModal" tabindex="-1" role="dialog" aria-labelledby="importSaltabModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="importSaltabModalLabel"><span class="judulModalSaltab">Import Saltab</span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body bg-light">
				<div class="isi-modal-edit-outlet">
					<div class="container" id="container_modal_outlet">
						<div class="row">
							<div class="col-lg-12">
								<div class="card col-12">
									<div class="card-header">
										<div class="d-flex justify-content-between align-items-center">
											<h5 class="card-title mb-0"><span class="judulModalSaltab">Import Saltab</span></h5>
											<div id="kumpulan_button2">
												<button onclick="download_template_saltab()" id="button_download_template_outlet" class="btn btn-success btn-block">Download Template Saltab</button>
											</div>
											<!-- <button hidden id="button_download_data" class="btn btn-success btn-block">Download Data</button> -->
										</div>
									</div>
									<div class="card-body">
										<div class="form-row">
											<div class="col-md-6">
												<table class="table table-striped table-bordered col-md-12">
													<tbody>
														<tr>
															<td style='width:30%'><strong>Project</strong></td>
															<td style='width:70%'><span id="project_table"></span></td>
														</tr>
														<tr>
															<td style='width:30%'><strong>Sub Project</strong></td>
															<td style='width:70%'><span id="sub_project_table"></span></td>
														</tr>
													</tbody>
												</table>
											</div>

											<div class="col-md-6">
												<table class="table table-striped table-bordered col-md-12">
													<tbody>
														<tr>
															<td style='width:30%'><strong>Periode Penggajian</strong></td>
															<td style='width:70%'><span id="periode_penggajian_table"></span></td>
														</tr>
														<tr>
															<td style='width:30%'><strong>Periode Saltab</strong></td>
															<td style='width:70%'><span id="periode_saltab_table"></span></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-12">
												<div class="form-group">
													<label class="form-label">Upload File Excel Saltab <font color="#FF0000">*</font></label>
													<input type="file" class="filepond filepond-input-multiple" multiple id="file_excel" data-allow-reorder="true" data-max-file-size="64MB" data-max-files="1" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
													<input type="hidden" id="link_file_excel" name="link_file_excel" value="">
													<input type="hidden" id="tipe_file_excel" name="tipe_file_excel" value="">
													<small class="text-muted">File bertipe xlsx. Ukuran maksimal 64 MB</small>
													<span id='pesan_file_excel'></span>
												</div>
											</div>
										</div>

									</div>
								</div>
							</div>
							<!--end col-->
						</div>
						<!--end row-->
						<div hidden id="list_data_invalid">
							<div class="card">
								<div class="card-header">
									<div class="d-flex justify-content-between align-items-center">
										<h5 class="card-title mb-0">Data Invalid</h5>
										<div id="kumpulan_button3">
											<button onclick="download_data_invalid()" id="button_download_data_invalid" class="btn btn-success btn-block">Download Data Invalid</button>
										</div>
									</div>
								</div>

								<div class="card-body">
									<div class="table-responsive">
										<table id="invalid-saltab-datatables" class="display table table-bordered" style="width:100%">
											<thead>
												<tr>
													<th>STATUS VALID</th>
													<th>KETERANGAN VALID</th>
													<th>NIP</th>
													<th>NIK</th>
													<th>NAMA</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>STATUS VALID</th>
													<th>KETERANGAN VALID</th>
													<th>NIP</th>
													<th>NIK</th>
													<th>NAMA</th>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>

				<div class="info-modal-edit-outlet"></div>

			</div>
			<div class="modal-footer">
				<button type='button' class='btn btn-secondary mt-2' data-dismiss='modal'>Close</button>
				<button onclick="save_saltab()" id='button_save_saltab' name='button_save_saltab' type='button' class='btn btn-primary mt-2'>Save Data Saltab</button>
			</div>
		</div>
	</div>
</div>
<!-- END MODAL IMPORT SALTAB -->

<!-- Modal -->
<div class="modal fade" id="requestOpenModal" tabindex="-1" role="dialog" aria-labelledby="requestOpenModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<h5 class="modal-title" id="requestOpenModalLabel">
					<div class="judul-modal">
						<img src='<?php echo base_url('/assets/icon/warning.png'); ?>' width='30'>
						<font color="#FFFFFF"> Import Periode Saltab Dikunci </font>
						<!-- <img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'> -->
					</div>
				</h5>
				<button type="button" name="button_close2" id="button_close2" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						<font color="#FFFFFF"> x </font>
					</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="pesan-modal"></div>
				<div class="pesan-request-modal"></div>
			</div>
			<div class="modal-footer">
				<button type="button" name="button_request" id="button_request" class="btn btn-primary"> Request Open </button>
				<button type="button" name="button_close" id="button_close" class="btn btn-secondary" data-dismiss="modal"> Close </button>
			</div>
		</div>
	</div>
</div>

<?php
if (in_array('511', $role_resources_ids)) {
?>

	<div class="card border-blue">
		<!-- <div class="card-header with-elements">
      <span class="card-header-title mr-2">
        <strong>E-SALTAB | </strong>IMPORT FILE
      </span>
    </div> -->

		<div class="card-header with-elements">
			<div class="col-md-6">
				<span class="card-header-title mr-2">
					<strong>E-SALTAB | </strong>IMPORT SALTAB
				</span>
			</div>

			<div hidden class="col-md-6">
				<div class="pull-right">
					<!-- <div class="card-header with-elements"> -->
					<span class="card-header-title mr-2">
						<a href="<?php echo base_url(); ?>admin/importexcel/downloadTemplateSaltab" class="btn btn-primary">
							<i class="fa fa-download"></i>
							Download template saltab
						</a>
					</span>
					<!-- </div> -->
				</div>
			</div>
		</div>

		<!-- <?php
				// $attributes = array('class' => 'myform', 'id' => 'myform');
				// echo form_open_multipart('/admin/importexcel/import_saltab2/', $attributes);
				?> -->

		<div class="card-body border-bottom-blue ">

			<input type="hidden" id="nip" name="nip" value=<?php echo $session['employee_id']; ?>>

			<div class="form-row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="form-label">Project <font color="#FF0000">*</font></label>
						<select class="form-control" data-live-search="true" name="project" id="project" data-plugin="xin_select" data-placeholder="Project" required>
							<option value="">Pilih Project</option>
							<?php foreach ($all_projects as $proj) { ?>
								<option value="<?php echo $proj->project_id; ?>"> <?php echo $proj->title; ?></option>
							<?php } ?>
						</select>
						<span id="pesan_project"></span>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label class="form-label">Sub Project <font color="#FF0000">*</font></label>
						<select class="form-control" data-live-search="true" name="sub_project" id="sub_project" data-plugin="xin_select" data-placeholder="Sub-Project" required>
							<option value="0">--ALL--</option>
						</select>
						<span id="pesan_sub_project"></span>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-6">
					<div class="form-group">
						<!-- input periode -->
						<label class="form-label">Tanggal Penggajian <font color="#FF0000">*</font></label>
						<input type="text" class="form-control date" name="periode_salary" id="periode_salary" placeholder="Tanggal Penggajian" required>
						<span id="pesan_periode_salary"></span>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-row">
						<div class="col-md-6">
							<div class="form-group">
								<!-- input periode -->
								<label class="form-label">Periode Cutoff from <font color="#FF0000">*</font></label>
								<input type="text" class="form-control date" name="saltab_from" id="saltab_from" placeholder="Periode Saltab From" required>
								<span id="pesan_saltab_from"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<!-- input periode -->
								<label class="form-label">Periode Cutoff to <font color="#FF0000">*</font></label>
								<input type="text" class="form-control date" name="saltab_to" id="saltab_to" placeholder="Periode Saltab To" required>
								<span id="pesan_saltab_to"></span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md mb-12">
					<div class="form-group">
						<!-- button submit -->
						<button onclick="start_import_saltab()" type="button" id="button_start_import" name="button_start_import" class="btn btn-primary btn-block"><i class="fa fa-upload"></i> START IMPORT SALTAB</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- <?php //echo form_close(); 
			?> -->

<?php
}
?>

<!-- <div id="ms1" class="form-control"></div> -->
<!-- <div id="langOpt" class="form-control"></div> -->

<!-- <?php
		// echo '<pre>';
		// print_r($tabel_saltab);
		// echo '</pre>';
		?> -->
<div class="card <?php echo $get_animate; ?>">
	<div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>LIST BATCH |</strong> History E-SALTAB (Belum Release)</span> </div>
	<div class="card-body">
		<div class="box-datatable table-responsive" id="btn-place">
			<table class="display dataTable table table-striped table-bordered" id="saltab_table2" style="width:100%">
				<thead>
					<tr>
						<th>Aksi</th>
						<th>Tanggal Penggajian</th>
						<th>Periode Cutoff</th>
						<th>Project</th>
						<th>Sub Project</th>
						<th>Total MPP</th>
						<th>Upload/Hitung by</th>
						<th>Upload/Hitung on</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<!-- filepond js -->
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond/filepond.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.js"></script>
<script src="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-file-rename/filepond-plugin-file-rename.js"></script>


<script>
	//global variable
	var ms1;
	var langopt;
	var saltab_table;
	var invalid_saltab_table;
	var array_data_import;
	var array_data_import_validasi;
	var jumlah_data_import;
	var jumlah_data_invalid;
	var array_data_header = [];
	var session_id = '<?php echo $session['employee_id']; ?>';
	//var myData = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Philadelphia', 'Phoenix', 'San Antonio', 'San Diego', 'Dallas', 'San Jose', 'Jacksonville', "Algiers", "Annaba", "Azazga", "Batna City", "Blida", "Bordj", "Bordj Bou Arreridj", "Bougara", "Cheraga", "Chlef", "Constantine", "Djelfa", "Draria", "El Tarf", "Hussein Dey", "Illizi", "Jijel", "Kouba", "Laghouat", "Oran", "Ouargla", "Oued Smar", "Relizane", "Rouiba", "Saida", "Souk Ahras", "Tamanghasset", "Tiaret", "Tissemsilt", "Tizi", "Tizi Ouzou", "Tlemcen"];
	// var myData = JSON.parse('<?php //echo json_encode($tabel_saltab); 
								?>');
	var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
		csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

	var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
	var loading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	loading_html_text = loading_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
	loading_html_text = loading_html_text + '<h2>LOADING...</h2>';
	loading_html_text = loading_html_text + '</div>';

	var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
	var generating_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	generating_html_text = generating_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
	generating_html_text = generating_html_text + '<h2>GENERATING FILE...</h2>';
	generating_html_text = generating_html_text + '</div>';

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

	var success_image = "<?php echo base_url('assets/icon/ceklis_hijau.png'); ?>";
	var success_delete_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	success_delete_html_text = success_delete_html_text + '<img src="' + success_image + '" alt="" width="100px">';
	success_delete_html_text = success_delete_html_text + '<h2 style="color: #00FFA3;">BERHASIL HAPUS DATA</h2>';
	success_delete_html_text = success_delete_html_text + '</div>';

	var success_image = "<?php echo base_url('assets/icon/ceklis_hijau.png'); ?>";
	var success_generating_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	success_generating_html_text = success_generating_html_text + '<img src="' + success_image + '" alt="" width="100px">';
	success_generating_html_text = success_generating_html_text + '<h2 style="color: #00FFA3;">BERHASIL GENERATE FILE</h2>';
	success_generating_html_text = success_generating_html_text + '</div>';

	FilePond.registerPlugin(
		FilePondPluginFileEncode,
		FilePondPluginFileValidateType,
		FilePondPluginFileValidateSize,
		FilePondPluginFileRename,
		// FilePondPluginImageEdit,
		FilePondPluginImageExifOrientation,
		FilePondPluginImagePreview
	);

	//create object filepond untuk file saltab
	var pond_saltab = FilePond.create(document.querySelector('input[id="file_excel"]'), {
		labelIdle: 'Drag & Drop file Saltab atau klik <span class="filepond--label-action">Browse</span>',
		labelFileTypeNotAllowed: 'Format tidak sesuai',
		// allowMultiple: 1,
		// maxParallelUploads: 10,
		fileValidateTypeLabelExpectedTypes: 'Format hanya xlsx',
		imagePreviewHeight: 170,
		maxFileSize: "64MB",
		// acceptedFileTypes: ['*'],
		imageCropAspectRatio: "1:1",
		imageResizeTargetWidth: 200,
		imageResizeTargetHeight: 200,
		// fileRenameFunction: (file) => {
		//   return `bupot${file.extension}`;
		// }
	});

	$(document).ready(function() {

		var idsession = "<?php print($session['employee_id']); ?>";

		// baseURL variable
		var baseURL = "<?php echo base_url(); ?>";


		$('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
		$('[data-plugin="xin_select"]').select2({
			width: '100%'
		});

		invalid_saltab_table = $('#invalid-saltab-datatables').DataTable();

		//append identifier ke objek filepond file saltab
		pond_saltab.setOptions({
			server: {
				process: {
					url: '<?php echo base_url() ?>admin/Importexcel/upload_dokumen',
					method: 'POST',
					ondata: (formData) => {
						$('#button_save_saltab').attr("hidden", true);
						$('#pesan_file_excel').html("</br><strong><img src='" + loading_image + "' alt='' width='30px'><span style='color:blue;'> Reading data... (Akan lama jika data banyak)</span></strong>");

						formData.append('identifier', 'saltab');
						formData.append([csrfName], csrfHash);
						return formData;
					},
					onload: (res) => {
						// select the right value in the response here and return
						// return res;
						var serverResponse = jQuery.parseJSON(res);

						alert(serverResponse['message']);
						var data_excel = JSON.stringify(serverResponse['data']);
						var header_data_excel = JSON.stringify(serverResponse['data_header']);

						array_data_import = serverResponse['data'];
						jumlah_data_import = serverResponse['jumlah_data'];

						var html_pesan_file = "</br><strong><span style='color:blue;'>Jumlah data terbaca: " + jumlah_data_import + " data</span></strong>";

						$('#pesan_file_excel').html(html_pesan_file);

						//validating data
						if (
							(jumlah_data_import < 1)
						) { //kalau ada input kosong 
							alert("Data yang diupload kosong");
						} else {
							//action insert data
							$.ajax({
								url: '<?= base_url() ?>admin/Importexcel/validasi_import_saltab/',
								method: 'post',
								data: {
									[csrfName]: csrfHash,
									array_data_import: JSON.stringify(array_data_import),
								},
								beforeSend: function() {
									html_pesan_file = html_pesan_file + "</br><strong><img src='" + loading_image + "' alt='' width='30px'><span style='color:blue;'> Validating data... (Akan lama jika data banyak)</span></strong>";
									$('#pesan_file_excel').html(html_pesan_file);
								},
								success: function(response) {

									var res2 = jQuery.parseJSON(response);

									if (res2['status'] == "200") {
										array_data_import_validasi = res2['data'];
										html_pesan_file = "</br><strong><span style='color:blue;'>Jumlah data terbaca: " + jumlah_data_import + " data</span></strong>";

										jumlah_data_invalid = res2['jumlah_data_invalid'];

										//tampilkan list data invalid
										if (res2['jumlah_data_invalid'] > 0) {
											html_pesan_file = html_pesan_file + "</br><strong><span style='color:red;'>Jumlah data invalid: " + res2['jumlah_data_invalid'] + " data</span></strong>";

											//tampilkan pesan sukses
											$('#pesan_file_excel').html(html_pesan_file);

											$('#list_data_invalid').attr("hidden", false);
											let dataSet = res2['data_invalid'];

											invalid_saltab_table.destroy();

											invalid_saltab_table = $('#invalid-saltab-datatables').DataTable({
												data: dataSet,
												order: [],
												columns: [{
														data: 'status_valid',
														"orderable": false,
														// title: 'Name'
													}, {
														data: 'keterangan_valid',
														"orderable": false,
														// title: 'Name'
													},
													{
														data: 'nip',
														"orderable": false,
														// title: 'Name'
													},
													{
														data: 'nik',
														"orderable": false,
														// title: 'Name'
													},
													{
														data: 'fullname',
														"orderable": false,
														// title: 'Name'
													},
												]
											});
										} else {
											html_pesan_file = html_pesan_file + "</br><strong><span style='color:blue;'>Jumlah data invalid: " + res2['jumlah_data_invalid'] + " data</span></strong>";

											//tampilkan pesan sukses
											$('#pesan_file_excel').html(html_pesan_file);
										}

										$('#button_save_saltab').attr("hidden", false);

										// filter_outlet_product();
										saltab_table.ajax.reload(null, false);
									} else {
										html_pesan_file = "</br><strong><span style='color:blue;'>Jumlah data terbaca: " + jumlah_data_import + " data</span></strong>";
										html_pesan_file = html_pesan_file + "</br><strong><span style='color:blue;'>Gagal Melakukan Validasi, Silahkan ulangi proses import saltab</span></strong>";

										//tampilkan pesan sukses
										$('#pesan_file_excel').html(html_pesan_file);

										// $('#area').attr("hidden", true);
										array_data_import = "";
										array_data_import_validasi = "";
										array_data_header = [];
										jumlah_data_import = 0;
										jumlah_data_invalid = 0;
										pond_saltab.removeFile();
									}
								},
								error: function(xhr, status, error) {
									html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan ulangi proses import saltab</strong>";
									html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
									// html_text = "Gagal fetch data. Kode error: " + xhr.status;
									$('#pesan_file_excel').html(html_text);
									$('#button_save_outlet').attr("hidden", true);
									array_data_import = "";
									array_data_import_validasi = "";
									array_data_header = [];
									jumlah_data_import = 0;
									jumlah_data_invalid = 0;
									pond_outlet.removeFile();
								}
							});
						}
					}
				}
			}
		});

		// Project Change - Sub Project (on Change)
		$('#project').change(function() {
			var project = $(this).val();

			// AJAX request
			$.ajax({
				url: '<?= base_url() ?>registrasi/getSubByProject/',
				method: 'post',
				data: {
					[csrfName]: csrfHash,
					project: project
				},
				dataType: 'json',
				success: function(response) {
					//csrfName = data.csrfName;
					//csrfHash = data.csrfHash;
					// Remove options 
					$('#sub_project').find('option').not(':first').remove();

					// Add options
					$(response).each(function(index, data) {
						$('#sub_project').append('<option value="' + data['secid'] + '">' + data['sub_project_name'] + '</option>');
					}).show();
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert("Status :" + xhr.status);
					alert("responseText :" + xhr.responseText);
				},
			});
		});

		saltab_table = $('#saltab_table2').DataTable({
			//"bDestroy": true,
			'processing': true,
			'serverSide': true,
			//'stateSave': true,
			'bFilter': true,
			'serverMethod': 'post',
			//'dom': 'plBfrtip',
			'dom': 'lBfrtip',
			"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
			//'columnDefs': [{
			//  targets: 11,
			//  type: 'date-eu'
			//}],
			'order': [
				[7, 'desc']
			],
			'ajax': {
				'url': '<?= base_url() ?>admin/importexcel/list_batch_saltab',
				data: {
					[csrfName]: csrfHash,
					session_id: session_id,
					// nip: nip,
					// contract_id: contract_id,
					//idsession: idsession,
					// emp_id: emp_id
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
					data: 'periode_salary',
					// "orderable": false,
					//searchable: true
				},
				{
					data: 'periode',
					"orderable": false,
					//searchable: true
				},
				{
					data: 'project_name',
					//"orderable": false
				},
				{
					data: 'sub_project_name',
					//"orderable": false,
				},
				{
					data: 'total_mpp',
					"orderable": false,
				},
				{
					data: 'upload_by',
					//"orderable": false,
				},
				{
					data: 'upload_on',
					//"orderable": false,
				},
			]
		});



	});

	//-----delete batch saltab-----
	function deleteBatchSaltab(id) {
		// alert("masuk fungsi delete saltab. id: " + id);
		// AJAX request
		$.ajax({
			url: '<?= base_url() ?>admin/Importexcel/delete_batch_saltab/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				id: id
			},
			success: function(response) {
				alert("Berhasil Delete Batch Saltab");
				saltab_table.ajax.reload(null, false);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert("Gagal Delete Batch Saltab. Status : " + xhr.status);
				alert("responseText :" + xhr.responseText);
			},
		});
		// alert("Beres Ajax. id: " + id);
	}

	//-----lihat batch saltab-----
	function lihatBatchSaltab(id) {
		//alert("masuk fungsi lihat. id: " + id);
		window.open('<?= base_url() ?>admin/Importexcel/view_batch_saltab_temporary/' + id, "_self");
	}

	//-----edit batch saltab-----
	function downloadBatchSaltab(id) {
		//alert("masuk fungsi download. id: " + id);downloadDetailSaltab
		// window.open('<?= base_url() ?>admin/addendum/edit/' + id, "_blank");
		window.open('<?= base_url() ?>admin/Importexcel/downloadDetailSaltab/' + id, "_self");
	}
</script>

<!-- Action Tombol Download Excel -->
<script type="text/javascript">
	function download_template_saltab() {
		$.ajax({
			url: '<?= base_url() ?>admin/importexcel/downloadTemplateSaltab/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
			},
			xhrFields: {
				responseType: 'blob' // tipe untuk binary data
			},
			beforeSend: function() {
				//judul modal
				$('.judulModalSaltab').html("Download Template Saltab");
				$('.info-modal-edit-outlet').attr("hidden", false);
				$('.isi-modal-edit-outlet').attr("hidden", true);
				$('.info-modal-edit-outlet').html(generating_html_text);
				$('#button_save_saltab').attr("hidden", true);
				$('#button_delete_outlet').attr("hidden", true);
				$('#button_reset_device_user_mobile').attr("hidden", true);
				$('#button_enable_web_user_mobile').attr("hidden", true);
				$('#button_disable_web_user_mobile').attr("hidden", true);
				$('#importSaltabModal').modal('show');
			},
			success: function(data) {
				var now = new Date();
				var tanggal = now.toLocaleString();
				// var jam = now.toLocaleTimeString();

				// Create a temporary link to trigger download
				var a = document.createElement('a');
				var url = window.URL.createObjectURL(data);
				a.href = url;
				a.download = 'Template Import Data Saltab.xlsx';
				document.body.append(a);
				a.click();
				window.URL.revokeObjectURL(url);
				a.remove();

				$('.info-modal-edit-outlet').attr("hidden", false);
				$('.isi-modal-edit-outlet').attr("hidden", true);
				$('.info-modal-edit-outlet').html(success_generating_html_text);

				setTimeout(() => {
					//judul modal
					$('.judulModalSaltab').html("Import Data Saltab");

					$('.info-modal-edit-outlet').attr("hidden", true);
					$('.isi-modal-edit-outlet').attr("hidden", false);
				}, 1000);
			},
			error: function() {
				alert("Failed to download file.");
			}
			// success: function(response) {
			// 	alert("selesai download");
			// 	// alert(response);
			// }
		});
	}
</script>

<!-- <script>
  $('form#myform').on('submit', function(e) {
    const hari_ini = new Date().toJSON().slice(0, 10);
    // const hari_ini = new Date();
    const jam_sekaran = new Date().getHours();
    const tgl_gajian = document.getElementById("periode_salary").value;

    if (tgl_gajian == hari_ini) {
      e.preventDefault();
      alert("tanggal sama");
    } else {
      alert("tanggal beda");
    }
  });
</script> -->


<!-- Cek tanggal upload -->
<!-- <script>
	// var l = Ladda.create(document.querySelector('#button_submit'));
	const btn = document.getElementById("button_submit");

	btn.onclick = (e) => {
		var hari_ini = new Date().toJSON().slice(0, 10);
		var hari_ini2 = new Date();
		var jam_sekarang = new Date().getHours();
		var waktu_sekarang = new Date().getHours() + ":" + new Date().getMinutes() + ":" + new Date().getSeconds();

		var tgl_gajian = document.getElementById("periode_salary").value;
		var project_id = document.getElementById("project").value;
		var project_name = $('#project').find(":selected").text();
		var sub_project_id = document.getElementById("sub_project").value;
		var sub_project_name = $('#sub_project').find(":selected").text();
		var periode_saltab_from = document.getElementById("saltab_from").value;
		var periode_saltab_to = document.getElementById("saltab_to").value;

		var file_data = $('#file_excel').prop('files')[0];
		var fileName = file_data.name;
		var fileSize = file_data.size;
		var status = "";

		// var form = $('.myform');

		var kondisi = "";
		var html_text = '<div class="container"><div class="row"><table class="table table-striped col-md-12"><thead class="thead-dark"><tr><th class="col-4">ATRIBUT</th><th class="col-8">VALUE</th></thead></tr>';
		html_text = html_text + "<tr><td>" + "Project" + "</td><td><input type='text' class='form-control' readonly placeholder='Project' value='" + project_name + "'></td></tr>";
		html_text = html_text + "<tr><td>" + "Sub Project" + "</td><td><input type='text' class='form-control' readonly placeholder='Sub Project' value='" + sub_project_name + "'></td></tr>";
		html_text = html_text + "<tr><td>" + "Tanggal Penggajian" + "</td><td><input id='tanggal_penggajian_modal' name='tanggal_penggajian_modal' type='text' class='form-control' readonly placeholder='Tanggal Penggajian' value='" + tgl_gajian + "'></td></tr>";
		html_text = html_text + "<tr><td>" + "Periode Saltab From" + "</td><td><input id='saltab_from_modal' name='saltab_from_modal' type='text' class='form-control' readonly placeholder='Periode Saltab From' value='" + periode_saltab_from + "'></td></tr>";
		html_text = html_text + "<tr><td>" + "Periode Saltab To" + "</td><td><input id='saltab_to_modal' name='saltab_to_modal' type='text' class='form-control' readonly placeholder='Periode Saltab To' value='" + periode_saltab_to + "'></td></tr>";
		html_text = html_text + "<tr><td>" + "Alasan pengajuan buka kunci" + "</td><td><textarea id='note_open' name='note_open' class='form-control' rows='4'></textarea></td></tr>";
		html_text = html_text + "</div></div>";

		pesan_request = "";

		// alert(project_name + " - " + sub_project_name);
		// alert(jam_sekarang);

		if (fileName == "" || project_id == "" || sub_project_id == "" || tgl_gajian == "" || periode_saltab_from == "" || periode_saltab_to == "") {
			//do nothing. Jalankan proses validasi form. Munculkan pesan untuk isi field kosong
		} else {
			//cek boleh import?
			if (tgl_gajian <= hari_ini) {
				// alert("tanggal sama");
				e.preventDefault(); //stop post value

				// AJAX request
				$.ajax({
					url: '<?= base_url() ?>admin/Importexcel/cek_request_open_import/',
					method: 'post',
					data: {
						[csrfName]: csrfHash,
						tgl_gajian: tgl_gajian,
						project_id: project_id,
						project_name: project_name,
						sub_project_name: sub_project_name,
						sub_project_id: sub_project_id,
						periode_saltab_from: periode_saltab_from,
						periode_saltab_to: periode_saltab_to,
						jam_sekarang: jam_sekarang
					},
					success: function(response) {
						var res = jQuery.parseJSON(response);

						if (res['status'] == "101" || res['status'] == "103" || res['status'] == "105") {
							$('#myform').submit();
						} else if (res['status'] == "104") {
							kondisi = res['pesan'] + "<br><small>Waktu server: " + hari_ini2 + "</small><br><br>";
							pesan_request = "Sudah pernah ada request open import untuk saltab ini.<br>";
							pesan_request = pesan_request + "Nama Project: " + res['data']['project_name'] + "<br>";
							pesan_request = pesan_request + "Nama Sub Project: " + res['data']['sub_project_name'] + "<br>";
							pesan_request = pesan_request + "Tanggal Penggajian: " + res['data']['tanggal_gajian'] + "<br>";
							pesan_request = pesan_request + "Periode Saltab: " + res['data']['periode_saltab_from'] + " sampai " + res['data']['periode_saltab_to'] + "<br>";
							pesan_request = pesan_request + "Alasan Pengajuan Buka Kunci: " + res['data']['note'] + "<br>";
							pesan_request = pesan_request + "Request Oleh: " + res['data']['request_by_name'] + "<br>";
							pesan_request = pesan_request + "Waktu Request: " + res['data']['request_on'] + "<br>";
							$('.pesan-modal').html(kondisi + html_text);
							$('.pesan-request-modal').html(pesan_request);
							$('#button_request').attr("hidden", true);
							$('#note_open').attr("readonly", true);
							$('#requestOpenModal').appendTo("body").modal('show');
						} else {
							kondisi = res['pesan'] + "<br><small>Waktu server: " + hari_ini2 + "</small><br><br>";
							$('.pesan-modal').html(kondisi + html_text);
							$('#requestOpenModal').appendTo("body").modal('show');
						}
					},
					error: function(xhr, status, error) {
						// var res = jQuery.parseJSON(response);
						kondisi = "Gagal Import: Tanggal penggajian sudah lewat.</br>Silahkan ajukan untuk membuka kunci import saltab.<br>Waktu server: " + hari_ini2 + "<br><br>";
						$('.pesan-modal').html(kondisi + html_text);
						$('.pesan-request-modal').html(pesan_request);
						$('#requestOpenModal').appendTo("body").modal('show');
					}
				});
			}
			// else if (tgl_gajian < hari_ini) {
			//   e.preventDefault(); //stop post value

			//   kondisi = "Tidak bisa backdate. Tanggal penggajian sudah lewat.<br><small>Waktu server: " + hari_ini2 + "</small><br><br>";
			//   $('.pesan-modal').html(kondisi + html_text);
			//   $('.pesan-request-modal').html("");
			//   $('#button_request').attr("hidden", true);
			//   $('#note_open').attr("readonly", true);
			//   $('#requestOpenModal').appendTo("body").modal('show');
			// }
		}

	};
</script> -->

<!-- Tombol Request Open Import -->
<script type="text/javascript">
	document.getElementById("button_request").onclick = function(e) {
		e.preventDefault();

		var employee_id = '<?php echo $session['employee_id']; ?>';
		var user_name = "<?php print($user_info['0']->first_name); ?>";

		var note_open = $("#note_open").val();
		var hari_ini = new Date().toJSON().slice(0, 10);
		var hari_ini2 = new Date();
		var jam_sekarang = new Date().getHours();
		var waktu_sekarang = new Date().getHours() + ":" + new Date().getMinutes() + ":" + new Date().getSeconds();
		var tgl_request = hari_ini + " " + waktu_sekarang;

		var tgl_gajian = document.getElementById("periode_salary").value;
		var project_id = document.getElementById("project").value;
		var sub_project_id = document.getElementById("sub_project").value;
		var periode_saltab_from = document.getElementById("saltab_from").value;
		var periode_saltab_to = document.getElementById("saltab_to").value;

		// alert(csrfName);
		// alert(csrfHash);

		// AJAX request
		$.ajax({
			url: '<?= base_url() ?>admin/Importexcel/request_open_import/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				employee_id: employee_id,
				request_by_name: user_name,
				tgl_request: tgl_request,
				tgl_gajian: tgl_gajian,
				project_id: project_id,
				sub_project_id: sub_project_id,
				periode_saltab_from: periode_saltab_from,
				periode_saltab_to: periode_saltab_to,
				note_open: note_open,
			},
			success: function(response) {

				alert("Berhasil melakukan request");
				$('#button_submit').attr("disabled", false);
				$('#button_submit').removeAttr("data-loading");
				$('#requestOpenModal').appendTo("body").modal('hide');
			},
			error: function(xhr, status, error) {
				// var res = jQuery.parseJSON(response);
				html_text = "Gagal melakukan request.\n";
				html_text = html_text + "Error :\n";
				html_text = html_text + xhr.responseText;
				alert(html_text);
			}
		});

	};
</script>

<!-- Tombol Request Open Import -->
<script type="text/javascript">
	document.getElementById("button_close").onclick = function(e) {
		$('.pesan-modal').html("");
		$('.pesan-request-modal').html("");
		$('#button_submit').attr("disabled", false);
		$('#button_request').attr("hidden", false);
		$('#note_open').attr("readonly", false);
		$('#button_submit').removeAttr("data-loading");
	};
</script>

<!-- Tombol Request Open Import -->
<script type="text/javascript">
	document.getElementById("button_close2").onclick = function(e) {
		$('.pesan-modal').html("");
		$('.pesan-request-modal').html("");
		$('#button_submit').attr("disabled", false);
		$('#button_request').attr("hidden", false);
		$('#note_open').attr("readonly", false);
		$('#button_submit').removeAttr("data-loading");
	};
</script>

<!-- SHOW MODAL import saltab -->
<script>
	function start_import_saltab() {
		// alert("start import");

		//judul modal
		$('.judulModalSaltab').html("Import Data Saltab");

		$('#list_data_invalid').attr("hidden", true);

		//ambil value
		var nip = $('#nip').val();
		var project = $('#project').val();
		var project_name = $("#project option:selected").text();
		project_name = project_name.trim();
		var sub_project = $('#sub_project').val();
		var sub_project_name = $("#sub_project option:selected").text();
		sub_project_name = sub_project_name.trim();
		var periode_salary = $('#periode_salary').val();
		var saltab_from = $('#saltab_from').val();
		var saltab_to = $('#saltab_to').val();

		array_data_header.nip = nip;
		array_data_header.project = project;
		array_data_header.project_name = project_name;
		array_data_header.sub_project = sub_project;
		array_data_header.sub_project_name = sub_project_name;
		array_data_header.periode_salary = periode_salary;
		array_data_header.saltab_from = saltab_from;
		array_data_header.saltab_to = saltab_to;

		//debugging
		// alert(array_data_header.project_name);
		// alert(array_data_header.sub_project_name);
		// alert(array_data_header.periode_salary);
		// alert(array_data_header.saltab_from);
		// alert(array_data_header.saltab_to);

		//inisialisasi pesan
		$('#pesan_project').html("");
		$('#pesan_sub_project').html("");
		$('#pesan_periode_salary').html("");
		$('#pesan_saltab_from').html("");
		$('#pesan_saltab_to').html("");

		//-------cek apakah ada yang tidak diisi-------
		var pesan_project = "";
		var pesan_periode_salary = "";
		var pesan_saltab_from = "";
		var pesan_saltab_to = "";
		if ((saltab_to == "") || (saltab_to == null)) {
			pesan_saltab_to = "<small style='color:#FF0000;'>Periode Saltab to tidak boleh kosong</small>";
			// $('#saltab_to').focus();
		}
		if ((saltab_from == "") || (saltab_from == null)) {
			pesan_saltab_from = "<small style='color:#FF0000;'>Periode Saltab from tidak boleh kosong</small>";
			// $('#saltab_from').focus();
		}
		if ((periode_salary == "") || (periode_salary == null)) {
			pesan_periode_salary = "<small style='color:#FF0000;'>Periode penggajian tidak boleh kosong</small>";
			// $('#periode_salary').focus();
		}
		if ((project == "") || (project == null)) {
			pesan_project = "<small style='color:#FF0000;'>Project tidak boleh kosong</small>";
			// $('#project').focus();
		}
		$('#pesan_project').html(pesan_project);
		$('#pesan_periode_salary').html(pesan_periode_salary);
		$('#pesan_saltab_from').html(pesan_saltab_from);
		$('#pesan_saltab_to').html(pesan_saltab_to);

		//-------action-------
		if (
			(pesan_project != "") || (pesan_periode_salary != "") || (pesan_saltab_from != "") ||
			(pesan_saltab_to != "")
		) { //kalau ada input kosong 
			// alert("Tidak boleh ada input kosong");
		} else {
			$('#project_table').html(project_name);
			$('#sub_project_table').html(sub_project_name);
			$('#periode_penggajian_table').html(periode_salary);
			$('#periode_saltab_table').html(saltab_from + " s/d " + saltab_to);

			$('.info-modal-edit-outlet').attr("hidden", true);
			$('.isi-modal-edit-outlet').attr("hidden", false);
			$('#button_save_saltab').attr("hidden", false);
			$('#importSaltabModal').appendTo("body").modal('show');
		}
	}
</script>

<!-- ACTION ADD BATCH SKU -->
<script type="text/javascript">
	function save_saltab() {
		//-------action-------
		if (
			(array_data_import_validasi == null) || (array_data_import_validasi == "") || (array_data_import_validasi == "0")
		) { //kalau ada input kosong 
			alert("Upload File Excel template terlebih dulu");
		} else {
			//-------cek apakah ada yang tidak diisi-------
			// var pesan_file_excel = "";
			// if ((project_modal == "") || (project_modal == null)) {
			// 	pesan_project_modal = "<small style='color:#FF0000;'>Project tidak boleh kosong</small>";
			// 	$('#project_modal').focus();
			// }
			// $('#pesan_file_excel').html(pesan_file_excel);

			if (
				(jumlah_data_import < 1)
			) { //kalau ada input kosong 
				alert("Data yang diupload kosong");
			} else {
				//debugging
				// alert(array_data_header.project_name);
				// alert(array_data_header.sub_project_name);
				// alert(array_data_header.periode_salary);
				// alert(array_data_header.saltab_from);
				// alert(array_data_header.saltab_to);


				console.log(array_data_header);
				//action insert data
				$.ajax({
					url: '<?= base_url() ?>admin/Importexcel/save_saltab_temp/',
					method: 'post',
					data: {
						[csrfName]: csrfHash,
						array_data_import_validasi: JSON.stringify(array_data_import_validasi),
						nip: array_data_header.nip,
						project: array_data_header.project,
						project_name: array_data_header.project_name,
						sub_project: array_data_header.sub_project,
						sub_project_name: array_data_header.sub_project_name,
						saltab_from: array_data_header.saltab_from,
						saltab_to: array_data_header.saltab_to,
						periode_salary: array_data_header.periode_salary,
					},
					beforeSend: function() {
						html_pesan_file = "</br><strong><span style='color:blue;'>Jumlah data terbaca: " + jumlah_data_import + " data</span></strong>";
						if (jumlah_data_invalid > 0) {
							html_pesan_file = html_pesan_file + "</br><strong><span style='color:blue;'>Jumlah data invalid: " + jumlah_data_invalid + " data</span></strong>";
						} else {
							html_pesan_file = html_pesan_file + "</br><strong><span style='color:red;'>Jumlah data invalid: " + jumlah_data_invalid + " data</span></strong>";
						}
						html_pesan_file = html_pesan_file + "</br><strong><img src='" + loading_image + "' alt='' width='30px'><span style='color:blue;'> Saving data... (Akan lama jika data banyak)</span></strong>";
						$('#pesan_file_excel').html(html_pesan_file);
					},
					success: function(response) {

						var res = jQuery.parseJSON(response);

						if (res['status'] == "200") {
							alert("berhasil save saltab temporary");
							//tampilkan pesan sukses
							html_pesan_file = "</br><strong><span style='color:blue;'>Jumlah data terbaca: " + jumlah_data_import + " data</span></strong>";
							if (jumlah_data_invalid > 0) {
								html_pesan_file = html_pesan_file + "</br><strong><span style='color:red;'>Jumlah data invalid: " + jumlah_data_invalid + " data</span></strong>";
							} else {
								html_pesan_file = html_pesan_file + "</br><strong><span style='color:blue;'>Jumlah data invalid: " + jumlah_data_invalid + " data</span></strong>";
							}
							html_pesan_file = html_pesan_file + "</br><strong><span style='color:blue;'>Berhasil save data</span></strong>";
							$('#pesan_file_excel').html(html_pesan_file);

							window.open("<?= base_url() ?>admin/Importexcel/view_batch_saltab_temporary/" + res['id_batch'], "_self");
						} else {
							alert("gagal save saltab temporary");
							html_pesan_file = "</br><strong><span style='color:blue;'>Jumlah data terbaca: " + jumlah_data_import + " data</span></strong>";
							if (jumlah_data_invalid > 0) {
								html_pesan_file = html_pesan_file + "</br><strong><span style='color:red;'>Jumlah data invalid: " + jumlah_data_invalid + " data</span></strong>";
							} else {
								html_pesan_file = html_pesan_file + "</br><strong><span style='color:blue;'>Jumlah data invalid: " + jumlah_data_invalid + " data</span></strong>";
							}
							html_pesan_file = html_pesan_file + "</br><strong><span style='color:blue;'>Gagal save data</span></strong>";
							$('#pesan_file_excel').html(html_pesan_file);
						}
					},
					error: function(xhr, status, error) {
						html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
						html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
						// html_text = "Gagal fetch data. Kode error: " + xhr.status;
						$('.info-modal-edit-outlet').html(html_text); //coba pake iframe
						$('.isi-modal-edit-outlet').attr("hidden", true);
						$('.info-modal-edit-outlet').attr("hidden", false);
						$('#button_save_saltab').attr("hidden", true);
						array_data_import = "";
						array_data_import_validasi = "";
						array_data_header = [];
						jumlah_data_import = 0;
						jumlah_data_invalid = 0;
						pond_outlet.removeFile();
					}
				});
			}
			// alert("Tidak ada input kosong");
		}
	};
</script>
