<!-- Filepond css -->
<link rel="stylesheet" href="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond/filepond.min.css" type="text/css" />
<!-- <link href="assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="<?= base_url() ?>assets/assets_data_karyawan/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css" type="text/css" />

<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

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
if (in_array('1501', $role_resources_ids)) {
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
					<strong>RATECARD | </strong>IMPORT FILE
				</span>
			</div>

			<div class="col-md-6">
				<div class="pull-right">
					<!-- <div class="card-header with-elements"> -->
					<span class="card-header-title mr-2">
						<a href="<?php echo base_url(); ?>admin/importexcel/download_template_ratecard" class="btn btn-primary">
							<i class="fa fa-download"></i>
							Download template ratecard
						</a>
					</span>
					<!-- </div> -->
				</div>
			</div>
		</div>

		<?php
		// $attributes = array('class' => 'form_ratecar', 'id' => 'form_ratecar');
		// echo form_open_multipart('/admin/importexcel/import_saltab2/', $attributes);
		// echo form_open_multipart('/admin/importexcel/import_excel_ratecard/', $attributes);
		?>

		<div class="card-body border-bottom-blue ">

			<input type="hidden" id="nip" name="nip" value=<?php echo $session['employee_id']; ?>>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="form-label">Upload File Excel Ratecard<font color="#FF0000">*</font></label>
						<input type="file" class="filepond filepond-input-multiple" multiple id="file_excel" data-allow-reorder="true" data-max-file-size="64MB" data-max-files="1" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
						<input type="hidden" id="link_file_excel" name="link_file_excel" value="">
						<input type="hidden" id="tipe_file_excel" name="tipe_file_excel" value="">
						<small class="text-muted">File bertipe xlsx. Ukuran maksimal 64 MB</small>
						<span id='pesan_file_excel'></span>
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
						<!-- input tahun -->
						<label class="form-label">Tahun<font color="#FF0000">*</font></label>
						<input type="number" class="form-control" name="tahun_ratecard" id="tahun_ratecard" placeholder="Tahun" required>
						<span id='pesan_tahun_ratecard'></span>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-12">
					<div class="form-row">
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-label">Jenis Ratecard<font color="#FF0000">*</font></label>
								<select class="form-control" data-live-search="true" name="jenis_ratecard" id="jenis_ratecard" data-plugin="xin_select" data-placeholder="Jenis Ratecard" required>
									<option value="">Pilih Jenis Ratecard</option>
									<option value="1">Approval Client</option>
									<option value="2">Approval Internal</option>
									<option value="3">Database</option>
								</select>
								<span id='pesan_jenis_ratecard'></span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<!-- input periode -->
								<label class="form-label">Periode Start<font color="#FF0000">*</font></label>
								<input type="text" class="form-control date" name="periode_start" id="periode_start" placeholder="Periode Ratecard Start" required>
								<span id='pesan_periode_start'></span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<!-- input periode -->
								<label class="form-label">Periode End<font color="#FF0000">*</font></label>
								<input type="text" class="form-control date" name="periode_end" id="periode_end" placeholder="Periode Ratecard End" required>
								<span id='pesan_periode_end'></span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md mb-12">
					<div class="form-group">
						<!-- button submit -->
						<button onclick="proses_import()" type="button" id="button_submit" name="button_submit" class="btn btn-primary btn-block"><i class="fa fa-upload"></i> PROSES IMPORT</button>
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
	<div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>LIST RATECARD </strong> </span> </div>
	<div class="card-body">
		<div class="box-datatable table-responsive" id="btn-place">
			<table class="display dataTable table table-striped table-bordered" id="ratecard_table" style="width:100%">
				<thead>
					<tr>
						<th>Aksi</th>
						<th>Tahun</th>
						<th>Periode Ratecard</th>
						<th>Project</th>
						<th>Entitas/Sub Project</th>
						<th>Jenis Ratecard</th>
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
	var ratecard_table;
	var session_id = '<?php echo $session['employee_id']; ?>';
	var nip = '<?php echo $session['employee_id']; ?>';
	//var myData = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Philadelphia', 'Phoenix', 'San Antonio', 'San Diego', 'Dallas', 'San Jose', 'Jacksonville', "Algiers", "Annaba", "Azazga", "Batna City", "Blida", "Bordj", "Bordj Bou Arreridj", "Bougara", "Cheraga", "Chlef", "Constantine", "Djelfa", "Draria", "El Tarf", "Hussein Dey", "Illizi", "Jijel", "Kouba", "Laghouat", "Oran", "Ouargla", "Oued Smar", "Relizane", "Rouiba", "Saida", "Souk Ahras", "Tamanghasset", "Tiaret", "Tissemsilt", "Tizi", "Tizi Ouzou", "Tlemcen"];
	// var myData = JSON.parse('<?php //echo json_encode($tabel_saltab); 
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

	var failed = "<?php echo base_url('assets/icon/silang_merah.png'); ?>";
	var failed_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	failed_html_text = failed_html_text + '<img src="' + failed + '" alt="" width="100px">';
	failed_html_text = failed_html_text + '<h2 style="color: #ca1710;">GAGAL IMPORT DATA</h2>';
	failed_html_text = failed_html_text + '<h2 id="message_modal" style="color: #ca1710;"></h2>';
	failed_html_text = failed_html_text + '<iframe class="col-12" id="message_modal2"></iframe>';
	failed_html_text = failed_html_text + '</div>';

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
	var pond_ratecard = FilePond.create(document.querySelector('input[id="file_excel"]'), {
		labelIdle: 'Drag & Drop file Ratecard atau klik <span class="filepond--label-action">Browse</span>',
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

		//append nip dan identifier ke objek filepond file ktp
		pond_ratecard.setOptions({
			server: {
				process: {
					url: '<?php echo base_url() ?>admin/Employees/upload_dokumen',
					method: 'POST',
					ondata: (formData) => {
						formData.append('nip', nip);
						formData.append('identifier', 'ratecard');
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

		ratecard_table = $('#ratecard_table').DataTable({
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
				'url': '<?= base_url() ?>admin/importexcel/list_batch_ratecard',
				data: {
					[csrfName]: csrfHash,
					session_id: session_id,
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
					data: 'tahun',
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
					data: 'jenis_ratecard',
					"orderable": false,
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

	//-----delete batch ratecard-----
	function deleteBatchRatecard(id) {
		// alert("masuk fungsi delete saltab. id: " + id);
		// AJAX request
		$.ajax({
			url: '<?= base_url() ?>admin/Importexcel/delete_batch_ratecard/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				id: id
			},
			success: function(response) {
				alert("Berhasil Delete Batch Ratecard");
				ratecard_table.ajax.reload(null, false);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert("Gagal Delete Batch Ratecard. Status : " + xhr.status);
				alert("responseText :" + xhr.responseText);
			},
		});
		// alert("Beres Ajax. id: " + id);
	}

	//-----lihat batch ratecard-----
	function lihatBatchRatecard(id) {
		// alert("Under Construction. Masuk fungsi lihat. id: " + id);
		window.open('<?= base_url() ?>admin/Importexcel/view_batch_ratecard/' + id, "_self");
	}

	//-----download batch saltab-----
	function downloadBatchRatecard(id) {
		alert("Under Construction. Masuk fungsi download. id: " + id);
		// window.open('<?= base_url() ?>admin/Importexcel/downloadDetailSaltab/' + id, "_self");
	}
</script>

<!-- PROSES IMPORT -->
<script>
	function proses_import() {
		var link_file_excel = $('#link_file_excel').val();
		var tipe_file_excel = $('#tipe_file_excel').val();
		var project = $('#project').val();
		var sub_project = $('#sub_project').val();
		var tahun_ratecard = $('#tahun_ratecard').val();
		var jenis_ratecard = $('#jenis_ratecard').val();
		var periode_start = $('#periode_start').val();
		var periode_end = $('#periode_end').val();

		//inisialisasi pesan
		$('#pesan_file_excel').html("");
		$('#pesan_project').html("");
		$('#pesan_sub_project').html("");
		$('#pesan_tahun_ratecard').html("");
		$('#pesan_jenis_ratecard').html("");
		$('#pesan_periode_start').html("");
		$('#pesan_periode_end').html("");

		//-------cek apakah ada yang tidak diisi-------
		var pesan_file_excel = "";
		var pesan_project = "";
		var pesan_sub_project = "";
		var pesan_tahun_ratecard = "";
		var pesan_jenis_ratecard = "";
		var pesan_periode_start = "";
		var pesan_periode_end = "";
		if (periode_end == "") {
			pesan_periode_end = "<small style='color:#FF0000;'>Periode End tidak boleh kosong</small>";
			// $('#periode_end').focus();
		}
		if (periode_start == "") {
			pesan_periode_start = "<small style='color:#FF0000;'>Periode Start tidak boleh kosong</small>";
			// $('#periode_start').focus();
		}
		if (jenis_ratecard == "") {
			pesan_jenis_ratecard = "<small style='color:#FF0000;'>Jenis Ratecard tidak boleh kosong</small>";
			$('#jenis_ratecard').focus();
		}
		if (tahun_ratecard == "") {
			pesan_tahun_ratecard = "<small style='color:#FF0000;'>Tahun Ratecard tidak boleh kosong</small>";
			$('#tahun_ratecard').focus();
		}
		if (sub_project == "") {
			pesan_sub_project = "<small style='color:#FF0000;'>Entitas/Sub Project tidak boleh kosong</small>";
			$('#sub_project').focus();
		}
		if (project == "") {
			pesan_project = "<small style='color:#FF0000;'>Project tidak boleh kosong</small>";
			$('#project').focus();
		}
		if (link_file_excel == "") {
			pesan_file_excel = "<br><small style='color:#FF0000;'>File Excel tidak boleh kosong</small>";
			$('#link_file_excel').focus();
		}
		$('#pesan_periode_end').html(pesan_periode_end);
		$('#pesan_periode_start').html(pesan_periode_start);
		$('#pesan_jenis_ratecard').html(pesan_jenis_ratecard);
		$('#pesan_tahun_ratecard').html(pesan_tahun_ratecard);
		$('#pesan_sub_project').html(pesan_sub_project);
		$('#pesan_project').html(pesan_project);
		$('#pesan_file_excel').html(pesan_file_excel);

		//-------action-------
		if (
			(pesan_periode_end != "") || (pesan_periode_start != "") || (pesan_tahun_ratecard != "") ||
			(pesan_sub_project != "") || (pesan_project != "") || (pesan_file_excel != "") || (pesan_jenis_ratecard != "")
		) { //kalau ada input kosong 
			alert("Tidak boleh ada input kosong");
			//do nothing
		} else { //kalau semua terisi
			// AJAX request
			$.ajax({
				url: '<?= base_url() ?>admin/Importexcel/import_excel_ratecard/',
				method: 'post',
				data: {
					[csrfName]: csrfHash,
					nip: nip,
					link_file_excel: link_file_excel,
					tipe_file_excel: tipe_file_excel,
					project: project,
					sub_project: sub_project,
					tahun_ratecard: tahun_ratecard,
					jenis_ratecard: jenis_ratecard,
					periode_start: periode_start,
					periode_end: periode_end,
				},
				beforeSend: function() {
					$('.pesan-info-modal').attr("hidden", false);
					$('.pesan-info-modal').html(loading_html_text);
					$('#infoModal').appendTo("body").modal('show');
				},
				success: function(response) {
					var res = jQuery.parseJSON(response);

					if (res['status'] == "1") {
						$('.pesan-info-modal').html(success_html_text);
					} else {
						$('.pesan-info-modal').html(failed_html_text);
						$('#message_modal').html(res['message']);
					}
					ratecard_table.ajax.reload(null, false);
				},
				error: function(xhr, ajaxOptions, thrownError) {
					var pesan_gagal = "Gagal Import Ratecard. Pastikan anda menggunakan template terbaru. Status : " + xhr.status;

					$('.pesan-info-modal').html(failed_html_text);
					$('#message_modal').html(pesan_gagal);
					$('#message_modal2').attr('srcdoc', xhr.responseText);

					ratecard_table.ajax.reload(null, false);
				},
			});
		}
	}
</script>

<!-- Script event filepond -->
<script>
	pond_ratecard.on('removefile', (error, file) => {
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
