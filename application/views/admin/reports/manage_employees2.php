<?php
/* Employees report view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $_tasks = $this->Timesheet_model->get_tasks(); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

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

<div class="modal fade" id="dokumenModal" tabindex="-1" role="dialog" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Dokumen Karyawan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Modal body text goes here.</p>
				<div class="form-group row">
					<!-- <pre>
            <?php //print_r($user_info); 
						?>
          </pre><br> -->
					<div class="col-md-3">NIK <span class="icon-verify-nik"></span>
					</div>
					<div class="col-md-5"><input type='text' id="nik_modal" class='form-control' placeholder='Nomor NIK KTP' value='<?php echo $ktp_no; ?>'></div>
					<div class="col-md-4">
						<button id="button_verify_nik_modal" class="btn btn-success ladda-button" data-style="expand-right">Verifikasi</button>
						<?php if (($user_info[0]->user_role_id == "1") || ($user_info[0]->user_role_id == "11")) { ?>
							<button id="button_unverify_nik_modal" class="btn btn-danger ladda-button" data-style="expand-right">Cancel</button>
						<?php } ?>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-3"><button id="button_show_ktp_modal" class="btn btn-xs btn-outline-success" data-style="expand-right">Show/Hide KTP</button></div>
					<div class="col-md-3"><button id="button_show_kk_modal" class="btn btn-xs btn-outline-success" data-style="expand-right">Show/Hide KK</button></div>
					<div class="col-md-3"><button id="button_show_rekening_modal" class="btn btn-xs btn-outline-success" data-style="expand-right">Show/Hide Rekening</button></div>
				</div>

				<div class="isi-modal">
					<div class="rekening-modal"></div>
					<div class="ktp-modal"></div>
					<div class="kk-modal"></div>
					<div class="api-rekening-modal"></div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="close_modal" class="btn btn-primary ladda-button" data-style="expand-right">Close Modal</button>
				<button type="button" class="btn btn-primary">Save changes</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- SECTION FILTER -->
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
								<th>NIP - Status</th>
								<th>PIN</th>
								<th>NIK</th>
								<th>Nama Lengkap</th>
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

	$(document).ready(function() {
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
	function send_pin(nomor_kontak, first_name, employee_id, private_code, project_name, penempatan, company_name) {
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

					} else {
						$('#button_download_data').attr("hidden", false);

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
							// 'order': [
							//   [4, 'asc']
							// ],
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
					// alert("Berhasil kirim PIN");
				} else {
					$('#isi-modal-process').html("<h2>Gagal kirim PIN</h2>");
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

		} else {
			$('#button_download_data').attr("hidden", false);

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
				// 'order': [
				//   [4, 'asc']
				// ],
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

	//-----lihat employee-----
	function viewEmployee(id) {
		//alert("masuk fungsi lihat. id: " + id);
		window.open('<?= base_url() ?>admin/employees/emp_view/' + id, "_blank");
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