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

<!-- START MODAL CEK REKENING -->
<div class="modal fade" id="cekRekeningModal" tabindex="-1" role="dialog" aria-labelledby="cekRekeningModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="cekRekeningModalLabel"><span class="judulModalRekening">Cek Rekening</span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body bg-light">
				<div class="isi-modal-cek-rekening">
					<div class="container" id="container_modal_cek_rekening">
						<div class="row">
							<div class="col-lg-12">
								<div class="card col-12">
									<div class="card-header">
										<div class="d-flex justify-content-between align-items-center">
											<h5 class="card-title mb-0"><span class="judulModalRekening">Cek Rekening</span></h5>
											<div id="kumpulan_button2">
												<button onclick="download_template_cek_rekening()" id="button_download_template_cek_rekening" class="btn btn-success btn-block">Download Template Cek Rekening</button>
											</div>
											<!-- <button hidden id="button_download_data" class="btn btn-success btn-block">Download Data</button> -->
										</div>
									</div>
									<div class="card-body">
										<div class="form-row">
											<div class="col-md-12">
												<div class="form-group">
													<label class="form-label">Upload File Excel Cek Rekening <font color="#FF0000">*</font></label>
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
						<div hidden id="list_data_hasil_cek">
							<div class="card">
								<div class="card-header">
									<div class="d-flex justify-content-between align-items-center">
										<h5 class="card-title mb-0">Data Hasil</h5>
										<div id="kumpulan_button3">
											<button hidden onclick="download_data_hasil_cek()" id="button_download_data_invalid" class="btn btn-success btn-block">Download Data Hasil</button>
										</div>
									</div>
								</div>

								<div class="card-body">
									<div class="row">
										<div class="col-lg-12">
											<span id="status_pengecekan"></span>
											<div style="max-height: 300px; overflow: auto; border: 1px solid #ccc;">
												<table id="tabel_rek_rekening" class="table table-striped col-md-12">
													<thead>
														<tr>
															<th style="position: sticky; top: 0; background-color: #f9f9f9; z-index: 1;">
																<!-- <th> -->
																NAMA
															</th>
															<th style="position: sticky; top: 0; background-color: #f9f9f9; z-index: 1;">
																(BANK) NOREK
															</th>
															<th style="position: sticky; top: 0; background-color: #f9f9f9; z-index: 1;">
																STATUS REKENING
															</th>
															<th style="position: sticky; top: 0; background-color: #f9f9f9; z-index: 1;">
																NAMA PEMILIK
															</th>
															<th style="position: sticky; top: 0; background-color: #f9f9f9; z-index: 1;">
																SCORE KECOCOKAN
															</th>
															<th style="position: sticky; top: 0; background-color: #f9f9f9; z-index: 1;">
																PESAN
															</th>
															<th style="position: sticky; top: 0; background-color: #f9f9f9; z-index: 1;">
																NOTE
															</th>
															<th style="position: sticky; top: 0; background-color: #f9f9f9; z-index: 1;">
																CHECK ON
															</th>
														</tr>
													</thead>
													<tbody>
														<div id="isi_tabel_cek_rekening">
														</div>
													</tbody>
												</table>
											</div>
										</div>
										<!--end col-->
									</div>
									<!--end row-->

								</div>
							</div>
						</div>

					</div>
				</div>

				<div class="info-modal-cek_rekening"></div>

			</div>
			<div class="modal-footer">
				<button type='button' class='btn btn-secondary mt-2' data-dismiss='modal'>Close</button>
				<!-- <button hidden onclick="cek_batch_rekening()" id='button_cek_batch_rekening' name='button_cek_batch_rekening' type='button' class='btn btn-primary mt-2'>Cek Batch Rekening</button> -->
			</div>
		</div>
	</div>
</div>
<!-- END MODAL CEK REKENING -->

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

<!-- CARD CEK REKENING SINGLE -->
<div class="card border-blue mb-3">
	<!-- <div class="card-header with-elements">
      <span class="card-header-title mr-2">
        <strong>E-SALTAB | </strong>IMPORT FILE
      </span>
    </div> -->

	<div class="card-header with-elements">
		<div class="col-md-6">
			<span class="card-header-title mr-2">
				<strong>REKENING | </strong>CEK SINGLE REKENING
			</span>
		</div>
	</div>

	<div class="card-body border-bottom-blue ">
		<div class="form-row">
			<div class="col-md-3">
				<div class="form-group">
					<label class="form-label">Bank <font color="#FF0000">*</font></label>
					<select name="bank_input" id="bank_input" class="form-control" data-plugin="xin_select" data-placeholder="Pilih Bank">
						<option value=""></option>
						<?php
						foreach ($all_bank as $bank) {
						?>
							<option value="<?php echo $bank->bank_code_verification_api; ?>">(<?php echo substr($bank->bank_code, -3); ?>) <?php echo $bank->bank_name; ?></option>
						<?php
						}
						?>
					</select>
					<span id='pesan_bank_input'></span>
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<!-- input periode -->
					<label class="form-label">Nomor Rekening <font color="#FF0000">*</font></label>
					<input type="number" class="form-control" name="norek_input" id="norek_input" placeholder="Nomor Rekening" required>
					<span id="pesan_norek_input"></span>
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<!-- input periode -->
					<label class="form-label">Pemilik Rekening <font color="#FF0000">*</font></label>
					<input type="text" class="form-control" name="pemilik_rekening_input" id="pemilik_rekening_input" placeholder="Nama Pemilik Rekening" required>
					<span id="pesan_pemilik_rekening_input"></span>
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<label class="form-label">&nbsp;</label>
					<!-- button cek rekening single -->
					<button onclick="cek_rekening_single()" type="button" id="button_cek_rekening_single" name="button_cek_rekening_single" class="btn btn-primary btn-block"><i class="fa fa-search"></i> Cek Rekening</button>
				</div>
			</div>
		</div>

		<div class="form-row">
			<div class="col-md-12">
				<span id="hasil_cek_rekening_single"></span>
			</div>
		</div>
	</div>
</div>

<!-- CARD CEK BATCH REKENING -->
<div class="card border-blue">
	<div class="card-header with-elements">
		<div class="col-md-12">
			<span class="card-header-title mr-2">
				<strong>REKENING | </strong>CEK BATCH REKENING (OPEN BETA)</br>
				<font color="#FF0000"><strong>Sudah bisa dicoba. Kalau ada bug/error, lapor ya</strong></font>
			</span>
		</div>
	</div>

	<div class="card-body border-bottom-blue ">

		<input type="hidden" id="nip" name="nip" value=<?php echo $session['employee_id']; ?>>

		<div class="form-row">
			<div class="col-md mb-12">
				<div class="form-group">
					<!-- button submit -->
					<button onclick="start_cek_rekening()" type="button" id="button_start_cek_rekening" name="button_start_cek_rekening" class="btn btn-primary btn-block"><i class="fa fa-upload"></i> START CEK REKENING</button>
				</div>
			</div>
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
	var invalid_cek_rekening_table;
	var data_saltab_invalid;
	var array_data_import;
	var array_data_hasil_cek = [];
	var array_total_data_hasil_cek = [];
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
	var pond_cek_rekening = FilePond.create(document.querySelector('input[id="file_excel"]'), {
		labelIdle: 'Drag & Drop file Cek Rekening atau klik <span class="filepond--label-action">Browse</span>',
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

		invalid_cek_rekening_table = $('#cek-rekening-datatables').DataTable();

		//append identifier ke objek filepond file saltab
		pond_cek_rekening.setOptions({
			server: {
				process: {
					url: '<?php echo base_url() ?>admin/Rekening/upload_dokumen',
					method: 'POST',
					ondata: (formData) => {
						$('#button_download_data_invalid').attr("hidden", true);
						$('#list_data_hasil_cek').attr("hidden", true);
						$('#status_pengecekan').html("");
						// $('#button_cek_batch_rekening').attr("hidden", true);
						$('#pesan_file_excel').html("</br><strong><img src='" + loading_image + "' alt='' width='30px'><span style='color:blue;'> Reading data... (Akan lama jika data banyak)</span></strong>");

						formData.append('identifier', 'cek_rekening');
						formData.append([csrfName], csrfHash);
						return formData;
					},
					onload: (res) => {
						// select the right value in the response here and return
						// return res;
						var serverResponse = jQuery.parseJSON(res);

						//refresh data total
						array_total_data_hasil_cek = [];

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
							$('#list_data_hasil_cek').attr("hidden", false);
							proses_cek_rekening_aktif(array_data_import);
						}
					}
				}
			}
		});
	});

	//-----download data invalid-----
	function download_data_hasil_cek() {
		$.ajax({
			// url: '<?= base_url() ?>admin/importexcel/downloadTemplateSaltab/',
			url: '<?= base_url() ?>admin/Rekening/download_data_hasil_cek_from_import/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				array_total_data_hasil_cek: JSON.stringify(array_total_data_hasil_cek),
			},
			xhrFields: {
				responseType: 'blob' // tipe untuk binary data
			},
			beforeSend: function() {
				//judul modal
				$('.judulModalRekening').html("Download Data Hasil Cek Rekening");
				$('.info-modal-cek_rekening').attr("hidden", false);
				$('.isi-modal-cek-rekening').attr("hidden", true);
				$('.info-modal-cek_rekening').html(generating_html_text);
				// $('#button_cek_batch_rekening').attr("hidden", true);
				$('#cekRekeningModal').modal('show');
			},
			success: function(data) {
				var now = new Date();
				var tanggal = now.toLocaleString();
				// var jam = now.toLocaleTimeString();

				// Create a temporary link to trigger download
				var a = document.createElement('a');
				var url = window.URL.createObjectURL(data);
				a.href = url;
				a.download = 'Data Hasil Cek.xlsx';
				document.body.append(a);
				a.click();
				window.URL.revokeObjectURL(url);
				a.remove();

				$('.info-modal-cek_rekening').attr("hidden", false);
				$('.isi-modal-cek-rekening').attr("hidden", true);
				$('.info-modal-cek_rekening').html(success_generating_html_text);

				setTimeout(() => {
					//judul modal
					$('.judulModalRekening').html("Cek Batch Rekening");

					$('#button_cek_batch_rekening').attr("hidden", false);

					$('.info-modal-cek_rekening').attr("hidden", true);
					$('.isi-modal-cek-rekening').attr("hidden", false);
				}, 1000);
			},
			error: function() {
				alert("Failed to download file.");

				setTimeout(() => {
					//judul modal
					$('.judulModalRekening').html("Cek Batch Rekening");

					$('#button_cek_batch_rekening').attr("hidden", false);

					$('.info-modal-cek_rekening').attr("hidden", true);
					$('.isi-modal-cek-rekening').attr("hidden", false);
				}, 1000);
			}
			// success: function(response) {
			// 	alert("selesai download");
			// 	// alert(response);
			// }
		});
	}
</script>

<script>
	async function proses_cek_rekening_aktif(dataArray) {
		var html_pesan_file = "";
		var jumlah_data = dataArray.length;
		var data_checked = 0;

		for (const item of dataArray) {
			data_checked++;
			try {
				// The loop pauses here until the request completes
				const response = await $.ajax({
					url: '<?= base_url() ?>admin/Rekening/cek_batch_rekening_via_API/',
					method: 'POST',
					data: {
						[csrfName]: csrfHash,
						kode_bank: item.kode_bank,
						nomor_rekening: item.nomor_rekening,
						pemilik_rekening: item.pemilik_rekening,
					},
					beforeSend: function() {
						//judul modal status_pengecekan isi_tabel_cek_rekening
						html_pesan_file = "<strong><img src='" + loading_image + "' alt='' width='30px'><span style='color:blue;'> Cek Rekening a.n " + item.pemilik_rekening + "</br>Checked: " + data_checked + "/" + jumlah_data + "</span></strong></br>";
						$('#status_pengecekan').html(html_pesan_file);
						$('.judulModalRekening').html("Cek Batch Rekening");
						$('#cekRekeningModal').modal('show');
					},
					success: function(resp) {
						var res = jQuery.parseJSON(resp);

						if (res['hasil']['is_success']) {
							var status_hasil = "";
							if (res['hasil']['data']['is_valid']) {
								status_hasil_html = "<span style='color:blue;'>AKTIF</span>";
								status_hasil = "AKTIF";
							} else {
								status_hasil_html = "<span style='color:red;'>TIDAK AKTIF</span>";
								status_hasil = "TIDAK AKTIF";
							}
							var html_hasil = "<tr><td>" + res['input']['pemilik_rekening'] + "</td><td>(" + res['bank_name'] + ") " + res['input']['nomor_rekening'] + "</td><td>" + status_hasil_html + "</td><td>" + res['hasil']['data']['name'] + "</td><td>" + res['hasil']['data']['score'] + "</td><td>" + res['hasil']['data']['message'] + "</td><td>" + res['hasil']['data']['note'] + "</td><td>" + res['check_on'] + "</td></tr>";

							$("#tabel_rek_rekening tbody").append(html_hasil);

							array_data_hasil_cek.nama = res['input']['pemilik_rekening'];
							array_data_hasil_cek.bank = res['bank_name'];
							array_data_hasil_cek.nomor_rekening = res['input']['nomor_rekening'];
							array_data_hasil_cek.status_hasil = status_hasil;
							array_data_hasil_cek.nama_pemilik = res['hasil']['data']['name'];
							array_data_hasil_cek.score = res['hasil']['data']['score'];
							array_data_hasil_cek.message = res['hasil']['data']['message'];
							array_data_hasil_cek.note = res['hasil']['data']['note'];
							array_data_hasil_cek.check_on = res['check_on'];

							console.log(array_data_hasil_cek);

							// array_total_data_hasil_cek.push(array_data_hasil_cek);

							// console.log(array_total_data_hasil_cek);
						} else {
							status_hasil_html = "<span style='color:red;'>TIDAK AKTIF</span>";
							status_hasil = "TIDAK AKTIF";

							var html_hasil = "<tr><td>" + res['input']['pemilik_rekening'] + "</td><td>(" + res['bank_name'] + ") " + res['input']['nomor_rekening'] + "</td><td>" + status_hasil_html + "</td><td></td><td></td><td>" + res['hasil']['message'] + "</td><td></td><td>" + res['hasil']['check_on'] + "</td></tr>";

							$("#tabel_rek_rekening tbody").append(html_hasil);

							array_data_hasil_cek.nama = res['input']['pemilik_rekening'];
							array_data_hasil_cek.bank = res['bank_name'];
							array_data_hasil_cek.nomor_rekening = res['input']['nomor_rekening'];
							array_data_hasil_cek.status_hasil = status_hasil;
							array_data_hasil_cek.nama_pemilik = "";
							array_data_hasil_cek.score = "";
							array_data_hasil_cek.message = res['hasil']['message'];
							array_data_hasil_cek.note = "";
							array_data_hasil_cek.check_on = res['check_on'];

							console.log(array_data_hasil_cek);

							// array_total_data_hasil_cek.push(array_data_hasil_cek);
						}
					},
				});

				// console.log(response);
				// hasil = jQuery.parseJSON(response);
				// var res = jQuery.parseJSON(response);
				// if (res['hasil']['is_success']) {
				// 	var status_hasil = "";
				// 	if (res['hasil']['data']['is_valid']) {
				// 		status_hasil_html = "<span style='color:blue;'>AKTIF</span>";
				// 		status_hasil = "AKTIF";
				// 	} else {
				// 		status_hasil_html = "<span style='color:red;'>TIDAK AKTIF</span>";
				// 		status_hasil = "TIDAK AKTIF";
				// 	}
				// 	// var html_hasil = "<tr><td>" + res['input']['pemilik_rekening'] + "</td><td>(" + res['bank_name'] + ") " + res['input']['nomor_rekening'] + "</td><td>" + status_hasil_html + "</td><td>" + res['hasil']['data']['name'] + "</td><td>" + res['hasil']['data']['score'] + "</td><td>" + res['hasil']['data']['message'] + "</td><td>" + res['hasil']['data']['note'] + "</td><td>" + res['check_on'] + "</td></tr>";

				// 	// $("#tabel_rek_rekening tbody").append(html_hasil);

				// 	array_data_hasil_cek.nama = res['input']['pemilik_rekening'];
				// 	array_data_hasil_cek.bank = res['bank_name'];
				// 	array_data_hasil_cek.nomor_rekening = res['input']['nomor_rekening'];
				// 	array_data_hasil_cek.status_hasil = status_hasil;
				// 	array_data_hasil_cek.nama_pemilik = res['hasil']['data']['name'];
				// 	array_data_hasil_cek.score = res['hasil']['data']['score'];
				// 	array_data_hasil_cek.message = res['hasil']['data']['message'];
				// 	array_data_hasil_cek.note = res['hasil']['data']['note'];
				// 	array_data_hasil_cek.check_on = res['check_on'];

				// 	console.log(array_data_hasil_cek);

				// 	array_total_data_hasil_cek.push(array_data_hasil_cek);

				// 	// console.log(array_total_data_hasil_cek);
				// } else {
				// 	status_hasil_html = "<span style='color:red;'>TIDAK AKTIF</span>";
				// 	status_hasil = "TIDAK AKTIF";

				// 	// var html_hasil = "<tr><td>" + res['input']['pemilik_rekening'] + "</td><td>(" + res['bank_name'] + ") " + res['input']['nomor_rekening'] + "</td><td>" + status_hasil_html + "</td><td></td><td></td><td>" + res['hasil']['message'] + "</td><td></td><td>" + res['hasil']['check_on'] + "</td></tr>";

				// 	// $("#tabel_rek_rekening tbody").append(html_hasil);

				// 	array_data_hasil_cek.nama = res['input']['pemilik_rekening'];
				// 	array_data_hasil_cek.bank = res['bank_name'];
				// 	array_data_hasil_cek.nomor_rekening = res['input']['nomor_rekening'];
				// 	array_data_hasil_cek.status_hasil = status_hasil;
				// 	array_data_hasil_cek.nama_pemilik = "";
				// 	array_data_hasil_cek.score = "";
				// 	array_data_hasil_cek.message = res['hasil']['message'];
				// 	array_data_hasil_cek.note = "";
				// 	array_data_hasil_cek.check_on = res['check_on'];

				// 	array_total_data_hasil_cek.push(array_data_hasil_cek);
				// }

				array_total_data_hasil_cek.push(jQuery.parseJSON(response));
				console.log(array_total_data_hasil_cek);
			} catch (error) {
				status_hasil_html = "<span style='color:red;'>TIDAK AKTIF</span>";
				status_hasil = "TIDAK AKTIF";

				var html_hasil = "<tr><td>" + res['input']['pemilik_rekening'] + "</td><td>(" + res['bank_name'] + ") " + res['input']['nomor_rekening'] + "</td><td>" + status_hasil_html + "</td><td></td><td></td><td>" + res['hasil']['message'] + "</td><td></td><td>" + res['check_on'] + "</td></tr>";

				$("#tabel_rek_rekening tbody").append(html_hasil);

				array_data_hasil_cek.nama = res['input']['pemilik_rekening'];
				array_data_hasil_cek.bank = res['bank_name'];
				array_data_hasil_cek.nomor_rekening = res['input']['nomor_rekening'];
				array_data_hasil_cek.status_hasil = status_hasil;
				array_data_hasil_cek.nama_pemilik = "";
				array_data_hasil_cek.score = "";
				array_data_hasil_cek.message = res['hasil']['message'];
				array_data_hasil_cek.note = "";
				array_data_hasil_cek.check_on = res['check_on'];

				array_total_data_hasil_cek.push(array_data_hasil_cek);

				// console.error('Error processing item:', error);
			}

			// console.log(response);

			// cek_jumlah_invalid(id_batch);
			// cek_jumlah_rekening_tidak_aktif(id_batch);
			// refresh_datatable();

			// array_total_data_hasil_cek.push(array_data_hasil_cek);

			// console.log(array_total_data_hasil_cek);
		}

		// cek_jumlah_invalid(id_batch);
		// cek_jumlah_rekening_tidak_aktif(id_batch);
		// refresh_datatable();

		html_pesan_file = "<strong><span style='color:blue;'>Selesai Melakukan Pengecekan Rekening</br>Checked: " + data_checked + "/" + jumlah_data + "</span></strong></br>";
		$('#status_pengecekan').html(html_pesan_file);
		$('#button_download_data_invalid').attr("hidden", false);
		// console.log('All requests finished sequentially.');

		// console.log(array_total_data_hasil_cek);
	}
</script>

<!-- Action Tombol Download Excel -->
<script type="text/javascript">
	function download_template_cek_rekening() {
		$.ajax({
			url: '<?= base_url() ?>admin/Rekening/downloadTemplateRekening/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
			},
			xhrFields: {
				responseType: 'blob' // tipe untuk binary data
			},
			beforeSend: function() {
				//judul modal
				$('.judulModalRekening').html("Download Template Cek Rekening");
				$('.info-modal-cek_rekening').attr("hidden", false);
				$('.isi-modal-cek-rekening').attr("hidden", true);
				$('.info-modal-cek_rekening').html(generating_html_text);
				$('#button_cek_batch_rekening').attr("hidden", true);
				$('#cekRekeningModal').modal('show');
			},
			success: function(data) {
				var now = new Date();
				var tanggal = now.toLocaleString();
				// var jam = now.toLocaleTimeString();

				// Create a temporary link to trigger download
				var a = document.createElement('a');
				var url = window.URL.createObjectURL(data);
				a.href = url;
				a.download = 'Template Cek Rekening.xlsx';
				document.body.append(a);
				a.click();
				window.URL.revokeObjectURL(url);
				a.remove();

				$('.info-modal-cek_rekening').attr("hidden", false);
				$('.isi-modal-cek-rekening').attr("hidden", true);
				$('.info-modal-cek_rekening').html(success_generating_html_text);

				setTimeout(() => {
					//judul modal
					$('.judulModalRekening').html("Cek Batch Rekening");

					$('.info-modal-cek_rekening').attr("hidden", true);
					$('.isi-modal-cek-rekening').attr("hidden", false);
				}, 1000);
			},
			error: function() {
				alert("Failed to download file.");

				setTimeout(() => {
					//judul modal
					$('.judulModalRekening').html("Cek Batch Rekening");

					$('.info-modal-cek_rekening').attr("hidden", true);
					$('.isi-modal-cek-rekening').attr("hidden", false);
				}, 1000);
			}
		});
	}
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

<!-- cek rekening single -->
<script>
	function cek_rekening_single() {
		// alert("start import");

		//ambil value
		var bank_input = $('#bank_input').val();
		var norek_input = $('#norek_input').val();
		var pemilik_rekening_input = $('#pemilik_rekening_input').val();

		//debugging
		// alert(bank_input);
		// alert(norek_input);
		// alert(pemilik_rekening_input);

		//inisialisasi pesan
		$('#pesan_bank_input').html("");
		$('#pesan_norek_input').html("");
		$('#pesan_pemilik_rekening_input').html("");
		$('#hasil_cek_rekening_single').html("");

		//-------cek apakah ada yang tidak diisi-------
		var pesan_bank_input = "";
		var pesan_norek_input = "";
		var pesan_pemilik_rekening_input = "";
		if ((pemilik_rekening_input == "") || (pemilik_rekening_input == null)) {
			pesan_pemilik_rekening_input = "<small style='color:#FF0000;'>Pemilik rekening tidak boleh kosong</small>";
			// $('#saltab_to').focus();
		}
		if ((norek_input == "") || (norek_input == null)) {
			pesan_norek_input = "<small style='color:#FF0000;'>Nomor rekening tidak boleh kosong</small>";
			// $('#saltab_from').focus();
		}
		if ((bank_input == "") || (bank_input == null)) {
			pesan_bank_input = "<small style='color:#FF0000;'>Bank tidak boleh kosong</small>";
			// $('#periode_salary').focus();
		}
		$('#pesan_bank_input').html(pesan_bank_input);
		$('#pesan_norek_input').html(pesan_norek_input);
		$('#pesan_pemilik_rekening_input').html(pesan_pemilik_rekening_input);

		//-------action-------
		if (
			(pesan_bank_input != "") || (pesan_norek_input != "") || (pesan_pemilik_rekening_input != "")
		) { //kalau ada input kosong 
			// alert("Tidak boleh ada input kosong");
		} else {
			//action cek rekening
			$.ajax({
				url: '<?= base_url() ?>admin/Rekening/cek_rekening_via_API/',
				method: 'POST',
				data: {
					[csrfName]: csrfHash,
					bank_input: bank_input,
					norek_input: norek_input,
					pemilik_rekening_input: pemilik_rekening_input,
				},
				beforeSend: function() {
					//judul modal status_pengecekan isi_tabel_cek_rekening
					html_pesan_file = "<strong><img src='" + loading_image + "' alt='' width='30px'><span style='color:blue;'> Cek Rekening a.n " + pemilik_rekening_input + "</span></strong>";
					$('#hasil_cek_rekening_single').html(html_pesan_file);
				},
				success: function(response) {
					var res = jQuery.parseJSON(response);

					if (res['is_success']) {
						var status_hasil = "";
						if (res['data']['is_valid']) {
							status_hasil = "<span style='color:blue;'>AKTIF</span>";
						} else {
							status_hasil = "<span style='color:red;'>TIDAK AKTIF</span>";
						}
						// var html_hasil = "<tr><td>" + item.fullname + "</td><td>(" + item.nama_bank + ") " + item.norek + "</td><td>" + item.pemilik_rek + "</td><td>" + status_hasil + "</td></tr>";

						var html_hasil = "<strong>STATUS REKENING:</strong> " + status_hasil;
						html_hasil = html_hasil + "</br><strong>NAMA PEMILIK:</strong> " + res['data']['name'];
						html_hasil = html_hasil + "</br><strong>SCORE HASIL KECOCOKAN:</strong> " + res['data']['score'];
						html_hasil = html_hasil + "</br><strong>PESAN:</strong> " + res['data']['message'];
						html_hasil = html_hasil + "</br><strong>NOTE:</strong> " + res['data']['note'];
						$("#hasil_cek_rekening_single").html(html_hasil);
						// console.log(res['data']['name'] + ': ' + res['data']['is_valid']);
					} else {
						$('#hasil_cek_rekening_single').html(res['message']);
					}
				},
			});
		}
	}
</script>

<!-- SHOW MODAL cek rekenign -->
<script>
	function start_cek_rekening() {
		// alert("start cek rekening");

		//judul modal
		$('.judulModalRekening').html("Cek Batch Rekening");

		$('#list_data_hasil_cek').attr("hidden", true);

		$('.info-modal-cek_rekening').attr("hidden", true);
		$('.isi-modal-cek-rekening').attr("hidden", false);
		$('#button_cek_batch_rekening').attr("hidden", false);
		$('#cekRekeningModal').appendTo("body").modal('show');
	}
</script>

<!-- ACTION ADD BATCH SKU -->
<script type="text/javascript">
	function cek_batch_rekening() {
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
					url: '<?= base_url() ?>admin/Importexcel/cek_batch_rekening_temp/',
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
						$('.info-modal-cek_rekening').html(html_text); //coba pake iframe
						$('.isi-modal-cek-rekening').attr("hidden", true);
						$('.info-modal-cek_rekening').attr("hidden", false);
						$('#button_cek_batch_rekening').attr("hidden", true);
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

<!-- Script event filepond -->
<script>
	pond_cek_rekening.on('removefile', (error, file) => {
		$('#status_pengecekan').html("");
		$('#pesan_file_excel').html("");
		$('#button_download_data_invalid').attr("hidden", true);
		$('#list_data_hasil_cek').attr("hidden", true);

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