<!-- Filepond css -->
<link rel="stylesheet" href="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond/filepond.min.css" type="text/css" />
<!-- <link href="assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css" type="text/css" />

<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<!-- START MODAL IMPORT absensi -->
<div class="modal fade" id="importAbsensiModal" tabindex="-1" role="dialog" aria-labelledby="importAbsensiModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="importAbsensiModalLabel"><span class="judulModalAbsensi">Import absensi</span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body bg-light">
				<div class="isi-modal-absensi">
					<div class="container" id="container_modal_absensi">
						<div class="row">
							<div class="col-lg-12">
								<div class="card col-12">
									<div class="card-header">
										<div class="d-flex justify-content-between align-items-center">
											<h5 class="card-title mb-0"><span class="judulModalAbsensi">Import absensi</span></h5>
											<div id="kumpulan_button2">
												<button onclick="download_template_absensi()" id="button_download_template_absensi" class="btn btn-success btn-block">Download Template absensi</button>
											</div>
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
														<tr>
															<td style='width:30%'><strong>Agency Fee (Dalam %)</strong></td>
															<td style='width:70%'><span id="agency_fee_table"></span></td>
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
															<td style='width:30%'><strong>Periode absensi</strong></td>
															<td style='width:70%'><span id="periode_absensi_table"></span></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-12">
												<div class="form-group">
													<label class="form-label">Upload File Excel absensi <font color="#FF0000">*</font></label>
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
										<table id="invalid-absensi-datatables" class="display table table-bordered" style="width:100%">
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

				<div class="info-modal-absensi"></div>

			</div>
			<div class="modal-footer">
				<button type='button' class='btn btn-secondary mt-2' data-dismiss='modal'>Close</button>
				<button onclick="save_absensi()" id='button_save_absensi' name='button_save_absensi' type='button' class='btn btn-primary mt-2'>Save Data absensi</button>
			</div>
		</div>
	</div>
</div>
<!-- END MODAL IMPORT absensi -->

<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">      
				<h5 class="modal-title" id="infoModalLabel">
					<div class="judul-modal">
						INFORMASI
					</div>
				</h5>
				<button type="button" name="button_close2" id="button_close2" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						x
					</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="pesan-info-modal"></div>
			</div>
			<div class="modal-footer">
				<button type="button" name="button_close" id="button_close" class="btn btn-secondary" data-dismiss="modal"> Close </button>
			</div>
		</div>
	</div>
</div>

<?php
if (in_array('516', $role_resources_ids)) {
?>

	<div class="card border-blue">
		<!-- <div class="card-header with-elements">
      <span class="card-header-title mr-2">
        <strong>E-absensi | </strong>IMPORT FILE
      </span>
    </div> -->

		<div class="card-header with-elements">
			<div class="col-md-6">
				<span class="card-header-title mr-2">
					<strong>ABSENSI | </strong>IMPORT FILE
				</span>
			</div>

			<div hidden class="col-md-6">
				<div class="pull-right">
					<!-- <div class="card-header with-elements"> -->
					<span class="card-header-title mr-2">
						<a href="<?php echo base_url(); ?>admin/importexcel/download_template_absensi" class="btn btn-primary">
							<i class="fa fa-download"></i>
							Download template absensi
						</a>
					</span>
					<!-- </div> -->
				</div>
			</div>
		</div>

		<?php
		// $attributes = array('class' => 'form_ratecar', 'id' => 'form_ratecar');
		// echo form_open_multipart('/admin/importexcel/import_absensi2/', $attributes);
		// echo form_open_multipart('/admin/importexcel/import_excel_ratecard/', $attributes);
		?>

		<div class="card-body border-bottom-blue ">

			<input type="hidden" id="nip" name="nip" value=<?php echo $session['employee_id']; ?>>

			<!-- <div class="form-row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="form-label">Upload File Excel Absensi<font color="#FF0000">*</font></label>
						<input type="file" class="filepond filepond-input-multiple" multiple id="file_excel" data-allow-reorder="true" data-max-file-size="64MB" data-max-files="1" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
						<input type="hidden" id="link_file_excel" name="link_file_excel" value="">
						<input type="hidden" id="tipe_file_excel" name="tipe_file_excel" value="">
						<small class="text-muted">File bertipe xlsx. Ukuran maksimal 64 MB</small>
						<span id='pesan_file_excel'></span>
					</div>
				</div>
			</div> -->

			<div class="form-row">
				<div class="col-md-4">
					<div class="form-group">
						<!-- input periode -->
						<label class="form-label">Tanggal Penggajian<font color="#FF0000">*</font></label>
						<input type="text" class="form-control date" name="periode_salary" id="periode_salary" placeholder="Tanggal Penggajian" required>
						<span id='pesan_periode_salary'></span>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<!-- input periode -->
						<label class="form-label">Periode Cutoff from<font color="#FF0000">*</font></label>
						<input type="text" class="form-control date" name="absensi_from" id="absensi_from" placeholder="Periode absensi From" required>
						<span id='pesan_absensi_from'></span>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<!-- input periode -->
						<label class="form-label">Periode Cutoff to<font color="#FF0000">*</font></label>
						<input type="text" class="form-control date" name="absensi_to" id="absensi_to" placeholder="Periode absensi To" required>
						<span id='pesan_absensi_to'></span>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-label">Project<font color="#FF0000">*</font></label>
						<select class="form-control" data-live-search="true" name="project" id="project" data-plugin="xin_select" data-placeholder="Project" required>
							<option value="">Pilih Project</option>
							<?php foreach ($all_projects as $proj) { ?>
								<option value="<?php echo $proj->project_id; ?>"> <?php echo $proj->title; ?></option>
							<?php } ?>
						</select>
						<span id='pesan_project'></span>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label class="form-label">Entitas/Sub Project<font color="#FF0000">*</font></label>
						<select class="form-control" data-live-search="true" name="sub_project" id="sub_project" data-plugin="xin_select" data-placeholder="Sub-Project" required>
							<option value="">Pilih Entitas/Sub Project</option>
						</select>
						<span id='pesan_sub_project'></span>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<!-- input periode -->
						<label class="form-label">Fee (dalam %)<font color="#FF0000">*</font></label>
						<input type="text" class="form-control" name="agency_fee" id="agency_fee" placeholder="Fee (dalam %)" required>
						<span id='pesan_agency_fee'></span>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md mb-12">
					<div class="form-group">
						<!-- button submit -->
						<button onclick="start_import_absensi()" type="button" id="button_submit" name="button_submit" class="btn btn-primary btn-block"><i class="fa fa-upload"></i> PROSES IMPORT</button>
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
		// print_r($tabel_absensi);
		// echo '</pre>';
		?> -->
<div class="card <?php echo $get_animate; ?>">
	<div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>LIST ABSENSI </strong> </span> </div>
	<div class="card-body">
		<div class="box-datatable table-responsive" id="btn-place">
			<table class="display dataTable table table-striped table-bordered" id="table_absensi" style="width:100%">
				<thead>
					<tr>
						<th>Status</th>
						<th>Draft absensi</th>
						<th>Tanggal Penggajian</th>
						<th>Periode Cutoff</th>
						<th>Project</th>
						<th>Sub Project</th>
						<th>MPP</th>
						<th>Fee</th>
						<th>Upload by</th>
						<th>Upload on</th>
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
	var absensi_table;
	var invalid_absensi_table;
	var data_absensi_invalid;
	var array_data_import;
	var array_data_import_validasi;
	var jumlah_data_import;
	var jumlah_data_invalid;
	var array_data_header = [];
	var session_id = '<?php echo $session['employee_id']; ?>';
	var nip = '<?php echo $session['employee_id']; ?>';
	//var myData = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Philadelphia', 'Phoenix', 'San Antonio', 'San Diego', 'Dallas', 'San Jose', 'Jacksonville', "Algiers", "Annaba", "Azazga", "Batna City", "Blida", "Bordj", "Bordj Bou Arreridj", "Bougara", "Cheraga", "Chlef", "Constantine", "Djelfa", "Draria", "El Tarf", "Hussein Dey", "Illizi", "Jijel", "Kouba", "Laghouat", "Oran", "Ouargla", "Oued Smar", "Relizane", "Rouiba", "Saida", "Souk Ahras", "Tamanghasset", "Tiaret", "Tissemsilt", "Tizi", "Tizi Ouzou", "Tlemcen"];
	// var myData = JSON.parse('<?php //echo json_encode($tabel_absensi); 
								?>');
	var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
		csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

	var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
	var loading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	loading_html_text = loading_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
	loading_html_text = loading_html_text + '<h2>PROSES FILE EXCEL...</h2>';
	loading_html_text = loading_html_text + '</div>';

	var success_image = "<?php echo base_url('assets/icon/ceklis_hijau.png'); ?>";
	var success_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	success_html_text = success_html_text + '<img src="' + success_image + '" alt="" width="100px">';
	success_html_text = success_html_text + '<h2 style="color: #00FFA3;">BERHASIL IMPORT DATA</h2>';
	success_html_text = success_html_text + '<span id="message_modal" style="color: #00FFA3;"></span>';
	success_html_text = success_html_text + '</div>';

	var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
	var generating_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	generating_html_text = generating_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
	generating_html_text = generating_html_text + '<h2>GENERATING FILE...</h2>';
	generating_html_text = generating_html_text + '</div>';

	var failed = "<?php echo base_url('assets/icon/silang_merah.png'); ?>";
	var failed_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	failed_html_text = failed_html_text + '<img src="' + failed + '" alt="" width="100px">';
	failed_html_text = failed_html_text + '<h2 style="color: #ca1710;">GAGAL IMPORT DATA</h2>';
	failed_html_text = failed_html_text + '<h2 id="message_modal" style="color: #ca1710;"></h2>';
	failed_html_text = failed_html_text + '<iframe class="col-12" id="message_modal2"></iframe>';
	failed_html_text = failed_html_text + '</div>';

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

	//create object filepond untuk file bupot
	var pond_absensi = FilePond.create(document.querySelector('input[id="file_excel"]'), {
		labelIdle: 'Drag & Drop file Absensi atau klik <span class="filepond--label-action">Browse</span>',
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
		// baseURL variable
		var baseURL = "<?php echo base_url(); ?>";


		$('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
		$('[data-plugin="xin_select"]').select2({
			width: '100%'
		});

		//append nip dan identifier ke objek filepond file absensi
		pond_absensi.setOptions({
			server: {
				process: {
					url: '<?php echo base_url() ?>admin/Employees/upload_dokumen',
					method: 'POST',
					ondata: (formData) => {
						formData.append('nip', nip);
						formData.append('identifier', 'absensi');
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
							$('#link_file_excel').val(serverResponse['0']['link_file']);
							$('#tipe_file_excel').val(serverResponse['0']['type_file']);

							alert("link file excel: " + serverResponse['0']['link_file']);
							alert("tipe file excel: " + serverResponse['0']['type_file']);
							alert("Start proses import");

							//start proses import
							proses_import();

							// alert($('#link_file_excel').val());

							// pond_file_ktp_modal.removeFile();
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

		absensi_table = $('#table_absensi').DataTable({
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
				[9, 'desc']
			],
			'ajax': {
				'url': '<?= base_url() ?>admin/importexcel/list_batch_absensi',
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
					data: 'saltab',
					"orderable": false,
					//searchable: true
				},
				{
					data: 'periode_salary',
					// "orderable": false,
					//searchable: true
				},
				{
					data: 'saltab_from',
					// "orderable": false,
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
					data: 'mpp',
					// "orderable": false,
				},
				{
					data: 'fee',
					// "orderable": false,
				},
				{
					data: 'upload_by_name',
					//"orderable": false,
				},
				{
					data: 'upload_on',
					//"orderable": false,
				},
			]
		});



	});

	//-----delete batch absensi-----
	function deleteBatchAbsensi(id) {
		// alert("masuk fungsi delete absensi. id: " + id);
		// AJAX request
		$.ajax({
			url: '<?= base_url() ?>admin/Importexcel/delete_batch_absensi/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				id: id
			},
			success: function(response) {
				alert("Berhasil Delete Batch Absensi");
				absensi_table.ajax.reload(null, false);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert("Gagal Delete Batch Absensi. Status : " + xhr.status);
				alert("responseText :" + xhr.responseText);
			},
		});
		// alert("Beres Ajax. id: " + id);
	}

	//-----lihat batch absensi-----
	function lihatBatchAbsensi(id) {
		// alert("Under Construction. Masuk fungsi lihat. id: " + id);
		window.open('<?= base_url() ?>admin/Importexcel/view_batch_absensi/' + id, "_self");
	}

	//-----lihat absensi temporary-----
	function lihat_absensi_temp(id) {
		alert("Under Construction. Masuk fungsi lihat absensi temp. id: " + id);
		// window.open('<?= base_url() ?>admin/Importexcel/view_batch_absensi/' + id, "_self");
	}

	//-----download batch absensi-----
	function downloadBatchAbsensi(id) {
		alert("Under Construction. Masuk fungsi download. id: " + id);
		// window.open('<?= base_url() ?>admin/Importexcel/downloadDetailabsensi/' + id, "_self");
	}
</script>

<!-- Action Tombol Download Excel -->
<script type="text/javascript">
	//-----download data invalid-----
	function download_data_invalid() {
		$.ajax({
			// url: '<?= base_url() ?>admin/importexcel/downloadTemplateabsensi/',
			url: '<?= base_url() ?>admin/importexcel/download_data_invalid_from_import/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				data_absensi_invalid: JSON.stringify(data_absensi_invalid),
			},
			xhrFields: {
				responseType: 'blob' // tipe untuk binary data
			},
			beforeSend: function() {
				//judul modal
				$('.judulModalAbsensi').html("Download Template absensi");
				$('.info-modal-absensi').attr("hidden", false);
				$('.isi-modal-absensi').attr("hidden", true);
				$('.info-modal-absensi').html(generating_html_text);
				$('#button_save_absensi').attr("hidden", true);
				$('#button_delete_outlet').attr("hidden", true);
				$('#button_reset_device_user_mobile').attr("hidden", true);
				$('#button_enable_web_user_mobile').attr("hidden", true);
				$('#button_disable_web_user_mobile').attr("hidden", true);
				$('#importAbsensiModal').modal('show');
			},
			success: function(data) {
				var now = new Date();
				var tanggal = now.toLocaleString();
				// var jam = now.toLocaleTimeString();

				// Create a temporary link to trigger download
				var a = document.createElement('a');
				var url = window.URL.createObjectURL(data);
				a.href = url;
				a.download = 'Data Invalid.xlsx';
				document.body.append(a);
				a.click();
				window.URL.revokeObjectURL(url);
				a.remove();

				$('.info-modal-absensi').attr("hidden", false);
				$('.isi-modal-absensi').attr("hidden", true);
				$('.info-modal-absensi').html(success_generating_html_text);

				setTimeout(() => {
					//judul modal
					$('.judulModalAbsensi').html("Import Data absensi");

					$('#button_save_absensi').attr("hidden", false);

					$('.info-modal-absensi').attr("hidden", true);
					$('.isi-modal-absensi').attr("hidden", false);
				}, 1000);
			},
			error: function() {
				alert("Failed to download file.");

				setTimeout(() => {
					//judul modal
					$('.judulModalAbsensi').html("Import Data absensi");

					$('#button_save_absensi').attr("hidden", false);

					$('.info-modal-absensi').attr("hidden", true);
					$('.isi-modal-absensi').attr("hidden", false);
				}, 1000);
			}
			// success: function(response) {
			// 	alert("selesai download");
			// 	// alert(response);
			// }
		});
	}
</script>

<!-- Action Tombol Download Excel template absensi -->
<script type="text/javascript">
	function download_template_absensi() {
		var project = $('#project').val();
		var sub_project = $('#sub_project').val();
		var absensi_from = $('#absensi_from').val();
		var absensi_to = $('#absensi_to').val();

		$.ajax({
			url: '<?= base_url() ?>admin/Saltab/download_template_absensi/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				project_id: project,
				sub_project_id: sub_project,
				absensi_from: absensi_from,
				absensi_to: absensi_to,
			},
			xhrFields: {
				responseType: 'blob' // tipe untuk binary data
			},
			beforeSend: function() {
				//judul modal
				$('.judulModalAbsensi').html("Download Template absensi");
				$('.info-modal-absensi').attr("hidden", false);
				$('.isi-modal-absensi').attr("hidden", true);
				$('.info-modal-absensi').html(generating_html_text);
				$('#button_save_absensi').attr("hidden", true);
				$('#importAbsensiModal').modal('show');
			},
			success: function(data) {
				var now = new Date();
				var tanggal = now.toLocaleString();
				// var jam = now.toLocaleTimeString();

				// Create a temporary link to trigger download
				var a = document.createElement('a');
				var url = window.URL.createObjectURL(data);
				a.href = url;
				a.download = 'Template Import Data absensi.xlsx';
				document.body.append(a);
				a.click();
				window.URL.revokeObjectURL(url);
				a.remove();

				$('.info-modal-absensi').attr("hidden", false);
				$('.isi-modal-absensi').attr("hidden", true);
				$('.info-modal-absensi').html(success_generating_html_text);

				setTimeout(() => {
					//judul modal
					$('.judulModalAbsensi').html("Import Data absensi");

					$('.info-modal-absensi').attr("hidden", true);
					$('.isi-modal-absensi').attr("hidden", false);
				}, 1000);
			},
			error: function() {
				alert("Failed to download file.");

				setTimeout(() => {
					//judul modal
					$('.judulModalAbsensi').html("Import Data absensi");

					$('.info-modal-absensi').attr("hidden", true);
					$('.isi-modal-absensi').attr("hidden", false);
				}, 1000);
			}
			// success: function(response) {
			// 	alert("selesai download");
			// 	// alert(response);
			// }
		});
	}
</script>

<!-- PROSES IMPORT -->
<script>
	function proses_import() {
		var link_file_excel = $('#link_file_excel').val();
		var tipe_file_excel = $('#tipe_file_excel').val();
		var periode_salary = $('#periode_salary').val();
		var absensi_from = $('#absensi_from').val();
		var absensi_to = $('#absensi_to').val();
		var project = $('#project').val();
		var sub_project = $('#sub_project').val();
		var fee = $('#fee_input').val();

		// alert(fee);

		// AJAX request
		$.ajax({
			url: '<?= base_url() ?>admin/Importexcel/import_excel_absensi/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				nip: nip,
				link_file_excel: link_file_excel,
				tipe_file_excel: tipe_file_excel,
				periode_salary: periode_salary,
				absensi_from: absensi_from,
				absensi_to: absensi_to,
				project: project,
				sub_project: sub_project,
				fee: fee,
			},
			beforeSend: function() {
				$('.isi-modal-absensi').attr("hidden", true);
				$('#button_save_absensi').attr("hidden", true);
				$('.info-modal-absensi').attr("hidden", false);
				$('.info-modal-absensi').html(loading_html_text);
				$('#importAbsensiModal').appendTo("body").modal('show');
			},
			success: function(response) {
				var res = jQuery.parseJSON(response);

				if (res['status'] == "1") {
					$('.pesan-info-modal').html(success_html_text);

					//reset variable untuk import berikutnya
					pond_absensi.removeFile();
					$('#link_file_excel').val("");
					$('#tipe_file_excel').val("");
					$('#periode_salary').val("");
					$('#absensi_from').val("");
					$('#absensi_to').val("");
					$('#project').val("").change();
					$('#sub_project').val("").change();
					$('#fee_input').val("");
				} else {
					$('.pesan-info-modal').html(failed_html_text);
					$('#message_modal').html(res['message']);
				}
				absensi_table.ajax.reload(null, false);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				var pesan_gagal = "Gagal Import Absensi. Pastikan anda menggunakan template terbaru. Status : " + xhr.status;

				$('.pesan-info-modal').html(failed_html_text);
				$('#message_modal').html(pesan_gagal);
				$('#message_modal2').attr('srcdoc', xhr.responseText);

				absensi_table.ajax.reload(null, false);
			},
		});
	}
</script>

<!-- Script event filepond -->
<script>
	pond_absensi.on('removefile', (error, file) => {
		// alert("remove file " + file['name']); ->
		// $('#status_file_exitclear').val("0");

		// alert("Before");
		// alert($('#link_file_excel').val());
		// alert($('#tipe_file_excel').val());

		$('#link_file_excel').val("");
		$('#tipe_file_excel').val("");

		// alert("After");
		// alert($('#link_file_excel').val());
		// alert($('#tipe_file_excel').val());
	});
</script>

<!-- SHOW MODAL import absensi -->
<script>
	function start_import_absensi() {
		// alert("start import");

		//judul modal
		$('.judulModalAbsensi').html("Import Data absensi");

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
		var absensi_from = $('#absensi_from').val();
		var absensi_to = $('#absensi_to').val();
		var agency_fee = $('#agency_fee').val();

		array_data_header.nip = nip;
		array_data_header.project = project;
		array_data_header.project_name = project_name;
		array_data_header.sub_project = sub_project;
		array_data_header.sub_project_name = sub_project_name;
		array_data_header.periode_salary = periode_salary;
		array_data_header.absensi_from = absensi_from;
		array_data_header.absensi_to = absensi_to;
		array_data_header.fee = agency_fee;

		//debugging
		// alert(array_data_header.project_name);
		// alert(array_data_header.sub_project_name);
		// alert(array_data_header.periode_salary);
		// alert(array_data_header.absensi_from);
		// alert(array_data_header.absensi_to);

		//inisialisasi pesan
		$('#pesan_project').html("");
		$('#pesan_sub_project').html("");
		$('#pesan_periode_salary').html("");
		$('#pesan_absensi_from').html("");
		$('#pesan_absensi_to').html("");
		$('#pesan_agency_fee').html("");

		//-------cek apakah ada yang tidak diisi-------
		var pesan_project = "";
		var pesan_sub_project = "";
		var pesan_periode_salary = "";
		var pesan_absensi_from = "";
		var pesan_absensi_to = "";
		var pesan_agency_fee = "";
		if ((absensi_to == "") || (absensi_to == null)) {
			pesan_absensi_to = "<small style='color:#FF0000;'>Periode absensi to tidak boleh kosong</small>";
			// $('#absensi_to').focus();
		}
		if ((absensi_from == "") || (absensi_from == null)) {
			pesan_absensi_from = "<small style='color:#FF0000;'>Periode absensi from tidak boleh kosong</small>";
			// $('#absensi_from').focus();
		}
		if ((periode_salary == "") || (periode_salary == null)) {
			pesan_periode_salary = "<small style='color:#FF0000;'>Periode penggajian tidak boleh kosong</small>";
			// $('#periode_salary').focus();
		}
		if ((agency_fee == "") || (agency_fee == null)) {
			pesan_agency_fee = "<small style='color:#FF0000;'>Agency fee tidak boleh kosong</small>";
			// $('#project').focus();
		}
		if ((sub_project == "") || (sub_project == null)) {
			pesan_sub_project = "<small style='color:#FF0000;'>Sub Project tidak boleh kosong</small>";
			// $('#project').focus();
		}
		if ((project == "") || (project == null)) {
			pesan_project = "<small style='color:#FF0000;'>Project tidak boleh kosong</small>";
			// $('#project').focus();
		}
		$('#pesan_project').html(pesan_project);
		$('#pesan_sub_project').html(pesan_sub_project);
		$('#pesan_periode_salary').html(pesan_periode_salary);
		$('#pesan_absensi_from').html(pesan_absensi_from);
		$('#pesan_absensi_to').html(pesan_absensi_to);
		$('#pesan_agency_fee').html(pesan_agency_fee);

		//-------action-------
		if (
			(pesan_project != "") || (pesan_sub_project != "") || (pesan_periode_salary != "") || (pesan_absensi_from != "") ||
			(pesan_absensi_to != "") || (pesan_agency_fee != "")
		) { //kalau ada input kosong 
			// alert("Tidak boleh ada input kosong");
		} else {
			$('#project_table').html(project_name);
			$('#sub_project_table').html(sub_project_name);
			$('#agency_fee_table').html(agency_fee + " %");
			$('#periode_penggajian_table').html(periode_salary);
			$('#periode_absensi_table').html(absensi_from + " s/d " + absensi_to);

			$('.info-modal-absensi').attr("hidden", true);
			$('.isi-modal-absensi').attr("hidden", false);
			$('#button_save_absensi').attr("hidden", false);
			$('#importAbsensiModal').appendTo("body").modal('show');
		}
	}
</script>

<!-- ACTION ADD BATCH SKU -->
<script type="text/javascript">
	function save_absensi() {
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
				// alert(array_data_header.absensi_from);
				// alert(array_data_header.absensi_to);


				console.log(array_data_header);
				//action insert data
				$.ajax({
					url: '<?= base_url() ?>admin/Importexcel/save_absensi_temp/',
					method: 'post',
					data: {
						[csrfName]: csrfHash,
						array_data_import_validasi: JSON.stringify(array_data_import_validasi),
						nip: array_data_header.nip,
						project: array_data_header.project,
						project_name: array_data_header.project_name,
						sub_project: array_data_header.sub_project,
						sub_project_name: array_data_header.sub_project_name,
						absensi_from: array_data_header.absensi_from,
						absensi_to: array_data_header.absensi_to,
						periode_salary: array_data_header.periode_salary,
						fee: array_data_header.fee,
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
							alert("berhasil save absensi temporary");
							//tampilkan pesan sukses
							html_pesan_file = "</br><strong><span style='color:blue;'>Jumlah data terbaca: " + jumlah_data_import + " data</span></strong>";
							if (jumlah_data_invalid > 0) {
								html_pesan_file = html_pesan_file + "</br><strong><span style='color:red;'>Jumlah data invalid: " + jumlah_data_invalid + " data</span></strong>";
							} else {
								html_pesan_file = html_pesan_file + "</br><strong><span style='color:blue;'>Jumlah data invalid: " + jumlah_data_invalid + " data</span></strong>";
							}
							html_pesan_file = html_pesan_file + "</br><strong><span style='color:blue;'>Berhasil save data</span></strong>";
							$('#pesan_file_excel').html(html_pesan_file);

							window.open("<?= base_url() ?>admin/Importexcel/view_batch_absensi_temporary/" + res['id_batch'], "_self");
						} else {
							alert("gagal save absensi temporary");
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
						$('.info-modal-absensi').html(html_text); //coba pake iframe
						$('.isi-modal-absensi').attr("hidden", true);
						$('.info-modal-absensi').attr("hidden", false);
						$('#button_save_absensi').attr("hidden", true);
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
