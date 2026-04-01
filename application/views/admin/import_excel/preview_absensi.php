<?php
/* Invoices view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<!-- <pre>
	<?php //print_r($kolom_detail_absensi); 
	?>
</pre> -->
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
				<div class="container" id="container_modal_detail">
					<div class="isi-modal">
						...
					</div>
					<p id="output"></p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"> Close </button>
				<button hidden onclick="save_edit()" id="button_save_edit" class="btn btn-primary">Simpan data</button>
				<button hidden onclick="add_new()" id="button_add_new" class="btn btn-primary">Create data</button>
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
				<button type="button" class="btn btn-secondary" data-dismiss="modal"> Close </button>
			</div>
		</div>
	</div>
</div>

<div class="card">
	<!-- Section Data PKWT -->
	<div class="card-header with-elements">
		<div class="col-md-6">
			<span class="card-header-title mr-2"><strong>DATA BATCH </strong> | Absensi</span>
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
				<div class="col-md-6">
					<table class="table table-striped">
						<tbody>
							<tr>
								<th scope="row" style="width: 30%">Project</th>
								<td><?php echo $batch_absensi['project_name']; ?></td>
							</tr>
							<tr>
								<th scope="row" style="width: 30%">Entitas/Sub Project</th>
								<td><?php echo $batch_absensi['sub_project_name']; ?></td>
							</tr>
							<tr>
								<th scope="row" style="width: 30%">Total MPP</th>
								<td><?php echo $batch_absensi['mpp']; ?> Orang</td>
							</tr>
							<tr>
								<th scope="row" style="width: 30%">File Excel Sumber</th>
								<td><a href="<?php echo base_url($batch_absensi['file_excel']); ?>"><button type="button" class="btn btn-xs btn-outline-success">OPEN FILE</button></a></td>
							</tr>
							<tr>
								<th scope="row" style="width: 30%">Upload By</th>
								<td><?php echo $batch_absensi['upload_by_name']; ?></td>
							</tr>
							<tr>
								<th scope="row" style="width: 30%">Upload On</th>
								<td><?php echo $tanggal_upload; ?></td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="col-md-6">
					<table class="table table-striped">
						<tbody>
							<tr>
								<th scope="row" style="width: 30%">Tanggal Penggajian</th>
								<td><?php echo $tanggal_penggajian; ?></td>
							</tr>
							<tr>
								<th scope="row" style="width: 30%">Periode Cutoff</th>
								<td><?php echo $text_periode_cutoff; ?></td>
							</tr>
							<tr>
								<th scope="row" style="width: 30%">Fee</th>
								<td><?php echo $batch_absensi['fee']; ?> %</td>
							</tr>
							<tr>
								<th scope="row" style="width: 30%">Hasil Saltab</th>
								<td><span id="hasil_saltab"><?php echo $hasil_saltab; ?></span></td>
							</tr>
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>


<div class="card">

	<div class="card-header with-elements">
		<div class="col-md-6">
			<span class="card-header-title mr-2"><strong>LIST ALL</strong> | Detail Absensi</span>
		</div>

		<div class="col-md-6">
			<div class="pull-right">
				<!-- <div class="card-header with-elements"> -->
				<span class="card-header-title mr-2">
					<button onclick="hitung_saltab()" id="button_hitung_saltab" class="btn btn-success ladda-button" data-style="expand-right">Hitung Draft Saltab</button>
					<button hidden onclick="add_record()" id="button_add_record" class="btn btn-twitter ladda-button" data-style="expand-right">Add Record Saltab</button>
					<button onclick="delete_all()" id="button_delete_all" class="btn btn-danger ladda-button" data-style="expand-right">Hapus semua data</button>
				</span>
				<!-- </div> -->
			</div>
		</div>
	</div>
	<div class=" card-body">
		<div class="box-datatable table-responsive" id="btn-place">
			<table class="display dataTable table table-striped table-bordered" id="detail_absensi" style="width:100%">
				<thead>
					<tr>
						<th>Aksi</th>
						<th>NIK - Status</th>
						<th>NIP - Nama</th>
						<th>Posisi/Jabatan</th>
						<th>Area</th>
						<th>Detail Area</th>
						<th>Region</th>
						<th>HK Target</th>
						<th>HK Actual</th>
						<th>HK Allowance</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
<!-- </div> -->

<script>
	var detail_absensi_table;
	var id_batch = '<?php echo $id_batch; ?>';
	if ((id_batch == null) || (id_batch == "")) {
		id_batch = 0;
	}
	var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
		csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

	var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
	var loading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	loading_html_text = loading_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
	loading_html_text = loading_html_text + '<h2>LOADING...</h2>';
	loading_html_text = loading_html_text + '</div>';

	var hitung_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	hitung_html_text = hitung_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
	hitung_html_text = hitung_html_text + '<h2>HITUNG DATA...</h2>';
	hitung_html_text = hitung_html_text + '</div>';

	var success_image = "<?php echo base_url('assets/icon/ceklis_hijau.png'); ?>";
	var success_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	success_html_text = success_html_text + '<img src="' + success_image + '" alt="" width="100px">';
	success_html_text = success_html_text + '<h2 style="color: #00FFA3;">BERHASIL UPDATE DATA</h2>';
	success_html_text = success_html_text + '<span id="message_modal" style="color: #00FFA3;"></span>';
	success_html_text = success_html_text + '</div>';

	var failed = "<?php echo base_url('assets/icon/silang_merah.png'); ?>";
	var failed_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	failed_html_text = failed_html_text + '<img src="' + failed + '" alt="" width="100px">';
	failed_html_text = failed_html_text + '<h2 style="color: #ca1710;">GAGAL UPDATE DATA</h2>';
	failed_html_text = failed_html_text + '<h2 id="message_modal" style="color: #ca1710;"></h2>';
	failed_html_text = failed_html_text + '<iframe class="col-12" id="message_modal2"></iframe>';
	failed_html_text = failed_html_text + '</div>';

	$(document).ready(function() {
		//alert(id_batch);
		$('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
		$('[data-plugin="xin_select"]').select2({
			width: '100%'
		});
		$('[data-plugin="select_modal_detail"]').select2({
			width: "100%",
			dropdownParent: $("#container_modal_detail")
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
					var error_text = "Error Load Data Sub Project. Status : " + xhr.status;
					$('.judul-modal-error').html("ERROR ! ");
					$('.isi-modal-error').html(xhr.responseText);
					$('#modal-error').modal('show');
				},
			});
		});

		detail_absensi_table = $('#detail_absensi').DataTable({
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
				[2, 'asc']
			],
			'ajax': {
				'url': '<?= base_url() ?>admin/importexcel/list_detail_absensi',
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
					// "orderable": false,
					//searchable: true
				},
				{
					data: 'fullname',
					//"orderable": false,
					//searchable: true
				},
				{
					data: 'jabatan_name',
					// "orderable": false
				},
				{
					data: 'kota_kabupaten',
					// "orderable": false,
				},
				{
					data: 'detail_area',
					//"orderable": false,
				},
				{
					data: 'region',
					//"orderable": false,
				},
				{
					data: 'hk_target',
					//"orderable": false,
				},
				{
					data: 'hk_actual',
					//"orderable": false,
				},
				{
					data: 'hk_allowance',
					//"orderable": false,
				},
			]
		});

	});

	//-----delete detail absensi-----
	function deleteDetailAbsensi(id) {
		// alert("masuk fungsi delete detail saltab. id: " + id);
		// AJAX request
		$.ajax({
			url: '<?= base_url() ?>admin/Importexcel/delete_detail_absensi/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				id: id
			},
			success: function(response) {
				alert("Berhasil Delete Data Absensi");
				detail_absensi_table.ajax.reload(null, false);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				var error_text = "Gagal Delete Data Absensi. Status : " + xhr.status;
				$('.judul-modal-error').html("ERROR ! ");
				$('.isi-modal-error').html('<iframe class="col-12">' + xhr.responseText + '</iframe>');
				$('#modal-error').modal('show');
			},
		});
		// alert("Beres Ajax. id: " + id);
	}

	//-----lihat batch absensi-----
	function lihatDetailAbsensi(id) {
		$('#button_save_edit').prop("hidden", true);
		var html_text = '<table class="table table-striped col-md-12"><thead class="thead-dark"><tr><th class="col-md-4">ATRIBUT</th><th class="col-md-8">VALUE</th></thead></tr>';
		// AJAX request
		$.ajax({
			url: '<?= base_url() ?>admin/importexcel/get_detail_absensi/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				id: id,
			},
			beforeSend: function() {
				$('.judul-modal').html("DETAIL DATA");
				$('.isi-modal').html(loading_html_text);
				$('#button_save_edit').prop("hidden", true);
				$('#button_add_new').prop("hidden", true);

				$('#viewDetailModal').modal('show');
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
				// $('#viewDetailModal').modal('show');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				var error_text = "Error Load Data Detail Absensi. Status : " + xhr.status;
				$('.judul-modal-error').html("ERROR ! ");
				$('.isi-modal-error').html('<iframe class="col-12">' + xhr.responseText + '</iframe>');
				$('#modal-error').modal('show');
			},
		});

		// alert("masuk fungsi lihat. id: " + id);
		// var html_text = 'This is the dummy data added using jQuery. Id: ' + id;

		// window.open('<?= base_url() ?>admin/Importexcel/view_batch_saltab_temporary/' + id, "_self");
	}
</script>

<!-- Tombol Delete ALL Detail Absensi -->
<script type="text/javascript">
	function delete_all() {
		var id = "<?php echo $id_batch; ?>";

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
				detail_absensi_table.ajax.reload(null, false);

				window.open('<?= base_url() ?>admin/Importexcel/import_absensi/', "_self");
			},
			error: function(xhr, ajaxOptions, thrownError) {
				var error_text = "Gagal Delete Batch Absensi. Status : " + xhr.status;
				$('.judul-modal-error').html("ERROR ! ");
				$('.isi-modal-error').html('<iframe class="col-12">' + xhr.responseText + '</iframe>');
				$('#modal-error').modal('show');
			},
		});

		// alert("masuk fungsi delete ALL saltab. id: " + id);
	};
</script>

<!-- Tombol edit detail absensi -->
<script type="text/javascript">
	function editDetailAbsensi(id) {
		$('#button_save_edit').prop("hidden", true);
		$('#button_add_new').prop("hidden", true);
		// alert("Under Construction");

		html_text = "<input hidden type='text' name='id_detail' id='id_detail' value='" + id + "'>";

		var html_text = html_text + '<table class="table table-striped col-md-12"><thead class="thead-dark"><tr><th class="col-md-4">ATRIBUT</th><th class="col-md-8">VALUE</th></thead></tr>';
		// AJAX request
		$.ajax({
			url: '<?= base_url() ?>admin/importexcel/get_detail_edit_absensi/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				id: id,
			},
			beforeSend: function() {
				$('.judul-modal').html("DETAIL DATA");
				$('.isi-modal').html(loading_html_text);
				$('#button_save_edit').prop("hidden", true);
				$('#button_add_new').prop("hidden", true);

				$('#viewDetailModal').modal('show');
			},
			// dataType: 'json',
			success: function(response) {

				var response2 = jQuery.parseJSON(response);

				// Add options
				$(response2['data_response']).each(function(index, data) {
					if (data[0] == "id_area") {
						html_text = html_text + "<tr><td>" + data[1] + "</td><td>";
						html_text = html_text + "<select class='form-control' id='" + data[0] + "' name='" + data[0] + "' data-plugin='select_modal_detail' data-placeholder='Pilih " + data[1] + "'>";
						html_text = html_text + "<option value=''>Pilih Area</option>";
						//add option
						$(response2['all_kabupaten_kota']).each(function(index, data_kota) {
							var selected = "";
							if (data[2] == data_kota['id_kab_kota_bps']) {
								var selected = "selected";
							} else {
								var selected = "";
							}
							html_text = html_text + "<option value='" + data_kota['id_kab_kota_bps'] + "' " + selected + ">[" + data_kota['provinsi'] + "] " + data_kota['nama'] + "</option>";
						});
						html_text = html_text + "</select></td></tr>";
					} else if (data[0] == "id_jabatan") {
						var response_jabatan = <?php echo json_encode($all_jabatan_json); ?>;

						html_text = html_text + "<tr><td>" + data[1] + "</td><td>";
						html_text = html_text + "<select class='form-control' id='" + data[0] + "' name='" + data[0] + "' data-plugin='select_modal_detail' data-placeholder='Pilih " + data[1] + "'>";
						html_text = html_text + "<option value=''>Pilih Jabatan</option>";
						//add option
						$(response_jabatan).each(function(index, data_jabatan) {
							var selected = "";
							if (data[2] == data_jabatan['designation_id']) {
								var selected = "selected";
							} else {
								var selected = "";
							}
							html_text = html_text + "<option value='" + data_jabatan['designation_id'] + "' " + selected + ">" + data_jabatan['designation_name'] + "</option>";
						});
						html_text = html_text + "</select></td></tr>";

						// html_text = html_text + "<tr><td>" + data[1] + "</td><td>" + data[2] + "</td></tr>";
					} else if ((data[0] == "status_hitung") || (data[0] == "catatan_hitung") || (data[0] == "id_detail_saltab_temp")) {
						html_text = html_text + "";
					} else {
						html_text = html_text + "<tr><td>" + data[1] + "</td><td><input type='text' class='form-control' name='" + data[0] + "' id='" + data[0] + "' placeholder='" + data[1] + "' value='" + data[2] + "'></td></tr>";
					}
					// html_text = html_text + "<tr><td>" + data[0] + "</td><td><input type='text' class='form-control' readonly placeholder='Periode Saltab To' value='" + data[1] + "'></td></tr>";
					// html_text = html_text + data;
				});
				// html_text = html_text + response;

				html_text = html_text + "</table>";

				// alert(html_text);
				$('.isi-modal').html(html_text);

				$('[data-plugin="select_modal_detail"]').select2({
					width: "100%",
					dropdownParent: $("#container_modal_detail")
				});

				$('#button_save_edit').prop("hidden", false);
				$('#button_add_new').prop("hidden", true);
				// $('#button_save_edit').prop('hidden',false);

				// $('#viewDetailModal').modal('show');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				$('#button_save_edit').prop("hidden", true);
				var error_text = "Error Load Data Detail Absensi. Status : " + xhr.status;
				$('.judul-modal-error').html("ERROR ! ");
				$('.isi-modal-error').html('<iframe class="col-12">' + xhr.responseText + '</iframe>');
				$('#modal-error').modal('show');
			},
		});
	};
</script>

<!-- Tombol simpan data detail absensi -->
<script type="text/javascript">
	function save_edit() {
		$('#button_add_new').prop("hidden", true);
		$('#button_save_edit').prop("hidden", false);
		var id = $('#id_detail').val();
		// $('#button_save_edit').prop("hidden", true);
		// alert("Under Construction");

		var kolom_detail_absensi = <?php echo json_encode($kolom_detail_absensi); ?>;

		// document.getElementById("output").innerHTML = kolom_detail_absensi[1];
		// console.log(kolom_detail_absensi[1]);

		// alert(kolom_detail_absensi);

		let data_edit_save = new Object();

		//get value
		$(kolom_detail_absensi).each(function(index, value_modal) {
			data_edit_save['' + value_modal['nama_tabel']] = $('#' + value_modal['nama_tabel'] + '').val();
			// alert($('#' + value_modal['nama_tabel'] + '').val());
			// $('#' + value_modal['nama_tabel'] + '').val();
		});

		// Object.entries(data_edit_save).forEach(([key, value]) => {
		// 	console.log(key + ": " + value);
		// });

		// AJAX request
		$.ajax({
			url: '<?= base_url() ?>admin/Importexcel/update_detail_absensi/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				id: id,
				data_edit_save: data_edit_save,
			},
			success: function(response) {
				var res = jQuery.parseJSON(response);

				//display message hasil perhitungan
				// alert(res['id_header_saltab']);

				if ((res['id_header_saltab'] == "") || (res['id_header_saltab'] == null)) {
					var button_lihat_saltab_temp = "<font style='color: rgba(133, 15, 15, 1);'><strong>[Belum Hitung]</br>Lakukan Hitung draft saltab terlebih dahulu</strong></font>";
					$('#hasil_saltab').html(button_lihat_saltab_temp);
					// alert(res['data']['id']);
				} else {
					var button_lihat_saltab_temp = '<button type="button" onclick="lihat_detail_saltab_temp(' + res['id_header_saltab'] + ')" class="btn btn-xs btn-outline-twitter" >OPEN HASIL SALTAB</button></br>' + res['message_perbandingan_mpp'];
					$('#hasil_saltab').html(button_lihat_saltab_temp);
				}

				alert("Berhasil Update Detail Absensi");
				detail_absensi_table.ajax.reload(null, false);
				$('#viewDetailModal').modal('hide');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				var error_text = "Gagal Update Detail Absensi. Status : " + xhr.status;
				$('.judul-modal-error').html("ERROR ! ");
				$('.isi-modal-error').html('<iframe class="col-12">' + xhr.responseText + '</iframe>');
				$('#modal-error').modal('show');

				// alert("Gagal Release Batch Saltab. Status : " + xhr.status);
				// alert("responseText :" + xhr.responseText);
			},
		});

	};
</script>

<!-- Tombol simpan data detail absensi -->
<script type="text/javascript">
	function add_record() {
		$('#button_add_new').prop("hidden", false);
		$('#button_save_edit').prop("hidden", true);
		// var id = $('#id_detail').val();
		// $('#button_save_edit').prop("hidden", true);
		// alert("Under Construction");

		var kolom_detail_absensi = <?php echo json_encode($kolom_detail_absensi); ?>;

		// document.getElementById("output").innerHTML = kolom_detail_absensi[1];
		// console.log(kolom_detail_absensi[1]);

		// alert(kolom_detail_absensi);

		let data_edit_save = new Object();

		//get value
		$(kolom_detail_absensi).each(function(index, value_modal) {
			data_edit_save['' + value_modal['nama_tabel']] = $('#' + value_modal['nama_tabel'] + '').val();
			// alert($('#' + value_modal['nama_tabel'] + '').val());
			// $('#' + value_modal['nama_tabel'] + '').val();
		});

		// Object.entries(data_edit_save).forEach(([key, value]) => {
		// 	console.log(key + ": " + value);
		// });

		// AJAX request
		$.ajax({
			url: '<?= base_url() ?>admin/Importexcel/update_detail_absensi/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				id: id,
				data_edit_save: data_edit_save,
			},
			success: function(response) {
				var res = jQuery.parseJSON(response);

				//display message hasil perhitungan
				// alert(res['message']);

				if ((res['id_header_saltab'] == "") || (res['id_header_saltab'] == null)) {
					var button_lihat_saltab_temp = "<font style='color: rgba(133, 15, 15, 1);'><strong>[Belum Hitung]</br>Lakukan Hitung draft saltab terlebih dahulu</strong></font>";
					$('#hasil_saltab').html(button_lihat_saltab_temp);
					// alert(res['data']['id']);
				} else {
					var button_lihat_saltab_temp = '<button type="button" onclick="lihat_detail_saltab_temp(' + res['id_header_saltab'] + ')" class="btn btn-xs btn-outline-twitter" >OPEN HASIL SALTAB</button></br>' + res['message_perbandingan_mpp'];
					$('#hasil_saltab').html(button_lihat_saltab_temp);
				}

				alert("Berhasil Update Detail Absensi");
				detail_absensi_table.ajax.reload(null, false);
				$('#viewDetailModal').modal('hide');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				var error_text = "Gagal Update Detail Absensi. Status : " + xhr.status;
				$('.judul-modal-error').html("ERROR ! ");
				$('.isi-modal-error').html('<iframe class="col-12">' + xhr.responseText + '</iframe>');
				$('#modal-error').modal('show');

				// alert("Gagal Release Batch Saltab. Status : " + xhr.status);
				// alert("responseText :" + xhr.responseText);
			},
		});

	};
</script>

<!-- Tombol Hitung all absensi -->
<script type="text/javascript">
	function hitung_saltab() {
		var id = "<?php echo $id_batch; ?>";

		// AJAX request
		$.ajax({
			url: '<?= base_url() ?>admin/Saltab/hitung_saltab/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				id: id
			},
			beforeSend: function() {
				$('.judul-modal').html("HITUNG DATA ABSENSI");
				$('.isi-modal').html(hitung_html_text);
				$('#button_save_edit').prop("hidden", true);
				$('#button_add_new').prop("hidden", true);

				$('#viewDetailModal').modal('show');
			},
			success: function(response) {
				var res = jQuery.parseJSON(response);

				//display message hasil perhitungan
				// alert(res['message']);

				if (res['status'] == "3") {
					var button_lihat_saltab_temp = '<button type="button" onclick="lihat_detail_saltab_temp(' + res['data']['id'] + ')" class="btn btn-xs btn-outline-twitter" >OPEN HASIL SALTAB</button></br>' + res['message_perbandingan_mpp'];
					$('#hasil_saltab').html(button_lihat_saltab_temp);
					// alert(res['data']['id']);
				}
				// alert("Berhasil Hitung Batch Absensi");
				detail_absensi_table.ajax.reload(null, false);

				$('.isi-modal').html("<h2>" + res['message'] + "</h2><h4></br>" + res['message_perbandingan_mpp'] + "</h4>");
			},
			error: function(xhr, ajaxOptions, thrownError) {
				var error_text = "Gagal Hitung Batch Absensi. Status : " + xhr.status;
				$('.judul-modal-error').html("ERROR ! ");
				$('.isi-modal-error').html('<iframe class="col-12">' + xhr.responseText + '</iframe>');
				$('#modal-error').modal('show');

				// alert("Gagal Release Batch Saltab. Status : " + xhr.status);
				// alert("responseText :" + xhr.responseText);
			},
		});

		// alert("masuk fungsi Release ALL saltab. id: " + id);
	};
</script>

<!-- fungsi lihat detail saltab temp -->
<script>
	//-----lihat batch saltab-----
	function lihat_detail_saltab_temp(id) {
		//alert("masuk fungsi lihat. id: " + id);
		window.open('<?= base_url() ?>admin/Importexcel/view_batch_saltab_temporary/' + id, "_blank");
	}
</script>