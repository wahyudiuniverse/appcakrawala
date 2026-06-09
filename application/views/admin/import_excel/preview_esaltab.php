<?php
/* Invoices view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<!-- START MODAL IMPORT SALTAB -->
<div class="modal fade" id="importSaltabModal" tabindex="-1" role="dialog" aria-labelledby="importSaltabModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="importSaltabModalLabel"><span class="judulModalSaltab">Download data invalid</span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body bg-light">
				<div class="isi-modal-edit-outlet">
					<div class="container" id="container_modal_outlet"></div>
				</div>

				<div class="info-modal-edit-outlet"></div>

			</div>
			<div class="modal-footer">
				<button type='button' class='btn btn-secondary mt-2' data-dismiss='modal'>Close</button>
			</div>
		</div>
	</div>
</div>
<!-- END MODAL IMPORT SALTAB -->

<!-- START MODAL CEK REKENING AKTIF -->
<div class="modal fade" id="cekRekeningAktifModal" tabindex="-1" role="dialog" aria-labelledby="cekRekeningAktifModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="cekRekeningAktifModalLabel"><span class="judulModalCekRekeningAktif">Cek Status Aktif Rekening</span></h5>
				<button type="button" class="close mb-3" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="isi-modal-cek-rekening">
					<div class="container" id="container_modal_cek_rekening">
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
													(BANK) NOMOR REKENING
												</th>
												<th style="position: sticky; top: 0; background-color: #f9f9f9; z-index: 1;">
													PEMILIK REKENING
												</th>
												<th style="position: sticky; top: 0; background-color: #f9f9f9; z-index: 1;">
													STATUS AKTIF
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

				<div class="info-modal-cek-rekening"></div>

			</div>
			<div class="modal-footer">
				<button type='button' class='btn btn-secondary mt-2' data-dismiss='modal'>Close</button>
			</div>
		</div>
	</div>
</div>
<!-- END MODAL CEK REKENING AKTIF -->

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

<!-- Modal -->
<div class="modal fade" id="viewDetailModal" tabindex="-1" role="dialog" aria-labelledby="viewDetailModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="viewDetailModalLabel">
					<div class="judul-modal">
						Detail data
					</div>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"> x </span>
				</button>
			</div>
			<div class="modal-body">
				<div class="isi-modal">
					...
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal"> Close </button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Error -->
<div class="modal fade" id="modal-error" tabindex="-1" role="dialog" aria-labelledby="modal-errorLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-errorLabel">
					<div class="judul-modal-error">
						Pesan Error
					</div>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"> x </span>
				</button>
			</div>
			<div class="modal-body">
				<div class="isi-modal-error">
					...
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal"> Close </button>
			</div>
		</div>
	</div>
</div>

<div class="card">
	<!-- Section Data PKWT -->
	<div class="card-header with-elements">
		<div class="col-md-6">
			<span class="card-header-title mr-2"><strong>DATA BATCH </strong> | E-Saltab Temporary</span>
		</div>
		<div class="col-md-6">
			<div class="pull-right">
				<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewDetailModal">
          Launch demo modal
        </button> -->
				<!-- <span class="card-header-title mr-2">
          <button id="button_save_attribut" class="btn btn-primary ladda-button" data-style="expand-right">Save Atribut Batch</button>
        </span> -->
			</div>
		</div>
	</div>

	<div class="card-body">

		<div class="form-body">
			<div class="form-row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-label">Project</label>
						<input readonly class="form-control" placeholder="Project" name="project" id="project" type="text" value="<?php echo $batch_saltab['project_name']; ?>">
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-label">Sub Project</label>
								<input readonly class="form-control" placeholder="Sub Project" name="sub_project" id="sub_project" type="text" value="<?php echo $batch_saltab['sub_project_name']; ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-label">Tanggal Penggajian</label>
								<input type="text" class="form-control" readonly name="saltab_to" id="saltab_to" placeholder="Periode Saltab To" value="<?php echo $batch_saltab['periode_salary']; ?>">
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-row">
						<div class="col-md-6">
							<div class="form-group">
								<!-- input periode -->
								<label class="form-label">Periode Saltab from</label>
								<input type="text" class="form-control" readonly name="saltab_from" id="saltab_from" placeholder="Periode Saltab From" value="<?php echo $batch_saltab['periode_cutoff_from']; ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<!-- input periode -->
								<label class="form-label">Periode Saltab to</label>
								<input type="text" class="form-control" readonly name="saltab_to" id="saltab_to" placeholder="Periode Saltab To" value="<?php echo $batch_saltab['periode_cutoff_to']; ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-label"><span style="color:red;">JUMLAH DATA INVALID</span></label>
						<input readonly class="form-control" placeholder="Project" name="jumlah_data_invalid" id="jumlah_data_invalid" type="text" value="0">
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label class="form-label"><span style="color:orange;">JUMLAH DATA PEMILIK REKENING BEDA</span></label>
						<input readonly class="form-control" placeholder="Sub Project" name="jumlah_data_warning" id="jumlah_data_warning" type="text" value="0">
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label class="form-label"><span style="color:red;">JUMLAH REKENING TIDAK AKTIF/BELUM CEK</span></label>
						<input readonly class="form-control" placeholder="Sub Project" name="jumlah_rekening_tidak_aktif" id="jumlah_rekening_tidak_aktif" type="text" value="0">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="card">

	<div class="card-header with-elements">
		<div class="col-md-6">
			<span class="card-header-title mr-2"><strong>LIST ALL</strong> | Detail E-Saltab Temporary</span>
		</div>

		<div class="col-md-6">
			<div class="pull-right">
				<!-- <div class="card-header with-elements"> -->
				<span class="card-header-title mr-2">
					<button onclick="cek_status_aktif_rekening()" id="button_cek_rekening_aktif" class="btn btn-primary ladda-button" data-style="expand-right">Cek Rekening Aktif All</button>
					<button onclick="release_all()" id="button_release_all" class="btn btn-success ladda-button" data-style="expand-right">Finalize All</button>
					<button type="button" class="btn btn-outline-success dropdown-toggle" data-toggle="dropdown">
						DOWNLOAD <span class="caret"></span></button>
					<ul class="dropdown-menu" role="menu" style="width: 100px;background-color:#faf7f0;">
						<span style="color:#3F72D5;">DOWNLOAD OPTION:</span>
						<li class="mb-1"><button type="button" onclick="download_data('all')" id="button_download_data_all" class="btn btn-sm btn-outline-primary col-12">Download Data All</button></li>
						<li class="mb-1"><button type="button" onclick="download_data('invalid')" id="button_download_data_invalid" class="btn btn-sm btn-outline-danger col-12">Download Data Invalid</button></li>
						<li class="mb-1"><button type="button" onclick="download_data('pemilik_rekening_beda')" id="button_download_data_pemilik_rekening_beda" class="btn btn-sm btn-outline-danger col-12">Download Data Pemilik Rekening Beda</button></li>
						<li class="mb-1"><button type="button" onclick="download_data('rekening_non_aktif')" id="button_download_data_rekening_nonaktif" class="btn btn-sm btn-outline-danger col-12">Download Data Rekening Nonaktif</button></li>
					</ul>
					<button hidden id="button_delete_all" class="btn btn-danger ladda-button" data-style="expand-right">Delete All</button>
				</span>
				<!-- </div> -->
			</div>
		</div>
	</div>
	<div class=" card-body">
		<div class="box-datatable table-responsive" id="btn-place">
			<table class="display dataTable table table-striped table-bordered" id="detail_saltab_table" style="width:100%">
				<thead>
					<tr>
						<th>Status</th>
						<th>NIK</th>
						<th>NIP</th>
						<th>Nama</th>
						<th>Sub Project</th>
						<th>Posisi</th>
						<th>Area</th>
						<th>Hari Kerja</th>
						<th>Rekening</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
<!-- </div> -->

<script>
	var detail_saltab_table;
	var id_batch = '<?php echo $id_batch; ?>';
	if ((id_batch == null) || (id_batch == "")) {
		id_batch = 0;
	}
	var jumlah_invalid = 0;
	var jumlah_warning = 0;
	var jumlah_rekening_tidak_aktif = 0;
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

	$(document).ready(function() {
		//alert(id_batch);
		$('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
		$('[data-plugin="xin_select"]').select2({
			width: '100%'
		});

		cek_jumlah_invalid(id_batch);
		cek_jumlah_rekening_tidak_aktif(id_batch);
		cek_jumlah_warning(id_batch);

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
					var error_text = "Error Load Data Sub Project. Status : " + xhr.status;
					$('.judul-modal-error').html("ERROR ! ");
					$('.isi-modal-error').html(xhr.responseText);
					$('#modal-error').modal('show');
				},
			});
		});

		detail_saltab_table = $('#detail_saltab_table').DataTable({
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
				[3, 'asc']
			],
			'ajax': {
				'url': '<?= base_url() ?>admin/importexcel/list_detail_saltab',
				data: {
					[csrfName]: csrfHash,
					id_batch: id_batch,
					// nip: nip,
					// contract_id: contract_id,
					//idsession: idsession,
					// emp_id: emp_id
					//base_url_catat: base_url_catat
				},
				error: function(xhr, ajaxOptions, thrownError) {
					var error_text = "Error Load Data Table. Status : " + xhr.status;
					$('.judul-modal-error').html("ERROR ! ");
					$('.isi-modal-error').html(xhr.responseText);
					$('#modal-error').modal('show');
				},
			},
			'columns': [{
					data: 'aksi',
					"orderable": false
				},
				{
					data: 'nik',
					//"orderable": false,
					//searchable: true
				},
				{
					data: 'nip',
					//"orderable": false,
					//searchable: true
				},
				{
					data: 'fullname',
					//"orderable": false
				},
				{
					data: 'sub_project',
					"orderable": false,
				},
				{
					data: 'jabatan',
					//"orderable": false,
				},
				{
					data: 'area',
					//"orderable": false,
				},
				{
					data: 'hari_kerja',
					//"orderable": false,
				},
				{
					data: 'rekening',
					//"orderable": false,
				},
			]
		});

	});

	//-----delete detail saltab-----
	function deleteDetailSaltab(id) {
		// alert("masuk fungsi delete detail saltab. id: " + id);
		// AJAX request
		$.ajax({
			url: '<?= base_url() ?>admin/Importexcel/delete_detail_saltab/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				id: id
			},
			success: function(response) {
				alert("Berhasil Delete Data");
				detail_saltab_table.ajax.reload(null, false);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				var error_text = "Gagal Delete Data Saltab. Status : " + xhr.status;
				$('.judul-modal-error').html("ERROR ! ");
				$('.isi-modal-error').html(xhr.responseText);
				$('#modal-error').modal('show');
			},
		});
		// alert("Beres Ajax. id: " + id);
	}

	//-----lihat batch saltab-----
	function lihatDetailSaltab(id) {
		var html_text = '<table class="table table-striped col-md-12"><thead class="thead-dark"><tr><th class="col-md-4">ATRIBUT</th><th class="col-md-8">VALUE</th></thead></tr>';
		// AJAX request
		$.ajax({
			url: '<?= base_url() ?>admin/importexcel/get_detail_saltab/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				id: id,
			},
			dataType: 'json',
			success: function(response) {
				// var response2 = JSON.parse(response);
				// Add options
				$(response).each(function(index, data) {
					html_text = html_text + "<tr><td>" + data[0] + "</td><td>" + data[1] + "</td></tr>";
					// html_text = html_text + "<tr><td>" + data[0] + "</td><td><input type='text' class='form-control' readonly placeholder='Periode Saltab To' value='" + data[1] + "'></td></tr>";
					// html_text = html_text + data;
				});
				// html_text = html_text + response;

				html_text = html_text + "</table>";
				// alert(html_text);
				$('.isi-modal').html(html_text);
				$('#viewDetailModal').modal('show');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				var error_text = "Error Load Data Sub Project. Status : " + xhr.status;
				$('.judul-modal-error').html("ERROR ! ");
				$('.isi-modal-error').html(xhr.responseText);
				$('#modal-error').modal('show');
			},
		});

		// alert("masuk fungsi lihat. id: " + id);
		// var html_text = 'This is the dummy data added using jQuery. Id: ' + id;

		// window.open('<?= base_url() ?>admin/Importexcel/view_batch_saltab_temporary/' + id, "_self");
	}

	//-----download data-----
	function download_data(jenis) {
		var id = "<?php echo $id_batch; ?>";
		alert(jenis);

		$.ajax({
			// url: '<?= base_url() ?>admin/importexcel/downloadTemplateSaltab/',
			url: '<?= base_url() ?>admin/importexcel/download_data_from_saltab_temp/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				id: id,
				jenis: jenis,
			},
			xhrFields: {
				responseType: 'blob' // tipe untuk binary data
			},
			beforeSend: function() {
				//judul modal
				$('.judulModalSaltab').html("Download Data Saltab");
				$('.info-modal-edit-outlet').attr("hidden", false);
				$('.isi-modal-edit-outlet').attr("hidden", true);
				$('.info-modal-edit-outlet').html(generating_html_text);
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
				a.download = 'Data ' + jenis + '.xlsx';
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
					$('#importSaltabModal').modal('hide');
				}, 1000);
			},
			error: function() {
				alert("Failed to download file.");

				setTimeout(() => {
					//judul modal
					$('.judulModalSaltab').html("Import Data Saltab");

					$('.info-modal-edit-outlet').attr("hidden", true);
					$('.isi-modal-edit-outlet').attr("hidden", false);
					$('#importSaltabModal').modal('hide');
				}, 1000);
			}
			// success: function(response) {
			// 	alert("selesai download");
			// 	// alert(response);
			// }
		});
	}
</script>

<!-- Tombol Delete ALL Detail Saltab -->
<script type="text/javascript">
	document.getElementById("button_delete_all").onclick = function() {
		var id = "<?php echo $id_batch; ?>";

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
				detail_saltab_table.ajax.reload(null, false);

				window.open('<?= base_url() ?>admin/Importexcel/importesaltab/', "_self");
			},
			error: function(xhr, ajaxOptions, thrownError) {
				var error_text = "Gagal Delete Batch Saltab. Status : " + xhr.status;
				$('.judul-modal-error').html("ERROR ! ");
				$('.isi-modal-error').html(xhr.responseText);
				$('#modal-error').modal('show');
			},
		});

		// alert("masuk fungsi delete ALL saltab. id: " + id);
	};
</script>

<!-- Tombol Delete ALL Detail Saltab -->
<script type="text/javascript">
	function refresh_datatable() {
		// alert("Masuk refresh datatable");
		detail_saltab_table.destroy();

		detail_saltab_table = $('#detail_saltab_table').DataTable({
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
				[3, 'asc']
			],
			'ajax': {
				'url': '<?= base_url() ?>admin/importexcel/list_detail_saltab',
				data: {
					[csrfName]: csrfHash,
					id_batch: id_batch,
					// nip: nip,
					// contract_id: contract_id,
					//idsession: idsession,
					// emp_id: emp_id
					//base_url_catat: base_url_catat
				},
				error: function(xhr, ajaxOptions, thrownError) {
					var error_text = "Error Load Data Table. Status : " + xhr.status;
					$('.judul-modal-error').html("ERROR ! ");
					$('.isi-modal-error').html(xhr.responseText);
					$('#modal-error').modal('show');
				},
			},
			'columns': [{
					data: 'aksi',
					"orderable": false
				},
				{
					data: 'nik',
					//"orderable": false,
					//searchable: true
				},
				{
					data: 'nip',
					//"orderable": false,
					//searchable: true
				},
				{
					data: 'fullname',
					//"orderable": false
				},
				{
					data: 'sub_project',
					"orderable": false,
				},
				{
					data: 'jabatan',
					//"orderable": false,
				},
				{
					data: 'area',
					//"orderable": false,
				},
				{
					data: 'hari_kerja',
					//"orderable": false,
				},
				{
					data: 'rekening',
					//"orderable": false,
				},
			]
		});
	};
</script>

<!-- Tombol Release ALL Detail Saltab -->
<script type="text/javascript">
	function release_all() {
		var id = "<?php echo $id_batch; ?>";

		// cek_jumlah_invalid(id);

		// AJAX request
		$.ajax({
			url: '<?= base_url() ?>admin/Importexcel/release_batch_saltab/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				id: id
			},
			success: function(response) {
				alert("Berhasil Release Batch Saltab");
				detail_saltab_table.ajax.reload(null, false);

				window.open('<?= base_url() ?>admin/Importexcel/importesaltab/', "_self");
			},
			error: function(xhr, ajaxOptions, thrownError) {
				var error_text = "Gagal Release Batch Saltab. Status : " + xhr.status;
				$('.judul-modal-error').html("ERROR ! ");
				$('.isi-modal-error').html(error_text + xhr.responseText);
				$('#modal-error').modal('show');

				// alert("Gagal Release Batch Saltab. Status : " + xhr.status);
				// alert("responseText :" + xhr.responseText);
			},
		});

		// alert("masuk fungsi Release ALL saltab. id: " + id);
	};
</script>

<!-- cek jumlah invalid -->
<script type="text/javascript">
	function cek_jumlah_invalid(id_batch) {
		var id = id_batch;
		jumlah_invalid = 0;

		// AJAX request
		$.ajax({
			url: '<?= base_url() ?>admin/Importexcel/cek_jumlah_invalid/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				id: id
			},
			success: function(response) {
				var res = jQuery.parseJSON(response);
				$('#jumlah_data_invalid').val(res);
				jumlah_invalid = res;
				// alert(jumlah_invalid);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				var error_text = "Gagal Release Batch Saltab. Status : " + xhr.status;
				$('.judul-modal-error').html("ERROR ! ");
				$('.isi-modal-error').html(error_text + xhr.responseText);
				$('#modal-error').modal('show');

				// alert("Gagal Release Batch Saltab. Status : " + xhr.status);
				// alert("responseText :" + xhr.responseText);
			},
		});

		// return jumlah_invalid;
	};
</script>

<!-- cek jumlah data invalid -->
<script type="text/javascript">
	function cek_jumlah_warning(id_batch) {
		var id = id_batch;
		jumlah_warning = 0;

		// AJAX request
		$.ajax({
			url: '<?= base_url() ?>admin/Importexcel/cek_jumlah_warning/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				id: id
			},
			success: function(response) {
				var res = jQuery.parseJSON(response);
				$('#jumlah_data_warning').val(res);
				jumlah_warning = res;
				// alert(jumlah_invalid);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				var error_text = "Gagal Release Batch Saltab. Status : " + xhr.status;
				$('.judul-modal-error').html("ERROR ! ");
				$('.isi-modal-error').html(error_text + xhr.responseText);
				$('#modal-error').modal('show');

				// alert("Gagal Release Batch Saltab. Status : " + xhr.status);
				// alert("responseText :" + xhr.responseText);
			},
		});

		// return jumlah_invalid;
	};
</script>

<!-- cek jumlah rekening tidak aktif -->
<script type="text/javascript">
	function cek_jumlah_rekening_tidak_aktif(id_batch) {
		var id = id_batch;
		jumlah_rekening_tidak_aktif = 0;

		// AJAX request
		$.ajax({
			url: '<?= base_url() ?>admin/Importexcel/cek_jumlah_rekening_tidak_aktif/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				id: id
			},
			success: function(response) {
				var res = jQuery.parseJSON(response);
				$('#jumlah_rekening_tidak_aktif').val(res);
				jumlah_rekening_tidak_aktif = res;
				// alert(jumlah_invalid);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				var error_text = "Gagal Release Batch Saltab. Status : " + xhr.status;
				$('.judul-modal-error').html("ERROR ! ");
				$('.isi-modal-error').html(error_text + xhr.responseText);
				$('#modal-error').modal('show');

				// alert("Gagal Release Batch Saltab. Status : " + xhr.status);
				// alert("responseText :" + xhr.responseText);
			},
		});

		// return jumlah_invalid;
	};
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
					url: '<?= base_url() ?>admin/Importexcel/tes_API_Bank3/',
					method: 'POST',
					data: {
						[csrfName]: csrfHash,
						secid: item.secid,
						id_bank: item.id_bank,
						norek: item.norek,
						pemilik_rekening: item.pemilik_rek,
					},
					beforeSend: function() {
						//judul modal status_pengecekan isi_tabel_cek_rekening
						html_pesan_file = "<strong><img src='" + loading_image + "' alt='' width='30px'><span style='color:blue;'> Cek Rekening a.n " + item.pemilik_rek + "</br>Checked: " + data_checked + "/" + jumlah_data + "</span></strong></br>";
						$('#status_pengecekan').html(html_pesan_file);
						$('.judulModalCekRekeningAktif').html("Cek Status Aktif Rekening");
						$('#cekRekeningAktifModal').modal('show');
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
							var html_hasil = "<tr><td>" + item.fullname + "</td><td>(" + item.nama_bank + ") " + item.norek + "</td><td>" + item.pemilik_rek + "</td><td>" + status_hasil + "</td></tr>";

							$("#tabel_rek_rekening tbody").append(html_hasil);
							console.log(res['data']['name'] + ': ' + res['data']['is_valid']);
						} else {
							var html_hasil = "<tr><td>" + item.fullname + "</td><td>(" + item.nama_bank + ") " + item.norek + "</td><td>" + item.pemilik_rek + "</td><td>" + res['message'] + "</td></tr>";

							$("#tabel_rek_rekening tbody").append(html_hasil);
							console.log(item.fullname + ': ' + res['message']);
						}
					},
				});
			} catch (error) {
				var html_hasil = "<tr><td>" + item.fullname + "</td><td>(" + item.nama_bank + ") " + item.norek + "</td><td>" + item.pemilik_rek + "</td><td>Error processing item: " + error + "</td></tr>";

				$("#tabel_rek_rekening tbody").append(html_hasil);
				console.error('Error processing item:', error);
			}

			cek_jumlah_invalid(id_batch);
			cek_jumlah_rekening_tidak_aktif(id_batch);
			refresh_datatable();
		}

		// cek_jumlah_invalid(id_batch);
		// cek_jumlah_rekening_tidak_aktif(id_batch);
		// refresh_datatable();

		html_pesan_file = "<strong><span style='color:blue;'>Selesai Melakukan Pengecekan Rekening</br>Checked: " + data_checked + "/" + jumlah_data + "</span></strong></br>";
		$('#status_pengecekan').html(html_pesan_file);
		console.log('All requests finished sequentially.');
	}
</script>

<!-- Tombol Cek status aktif rekening batch saltab -->
<script type="text/javascript">
	function cek_status_aktif_rekening() {
		var html_pesan_file = "";
		// AJAX request
		$.ajax({
			url: '<?= base_url() ?>admin/Importexcel/all_detail_saltab_cek_aktif/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				id_batch: id_batch
			},
			beforeSend: function() {
				//judul modal status_pengecekan
				html_pesan_file = "<strong><img src='" + loading_image + "' alt='' width='30px'><span style='color:blue;'> Mulai Pengecekan Rekening</span></strong>";
				$('#status_pengecekan').html(html_pesan_file);
				$('.judulModalCekRekeningAktif').html("Cek Status Aktif Rekening");
				$('#cekRekeningAktifModal').modal('show');
			},
			success: function(response) {
				// alert("Berhasil Delete Batch Saltab");
				var res = jQuery.parseJSON(response);
				proses_cek_rekening_aktif(res);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				// var error_text = "Gagal Delete Batch Saltab. Status : " + xhr.status;
				// $('.judul-modal-error').html("ERROR ! ");
				// $('.isi-modal-error').html(xhr.responseText);
				// $('#modal-error').modal('show');
			},
		});

		// alert("masuk fungsi delete ALL saltab. id: " + id);
	};
</script>
