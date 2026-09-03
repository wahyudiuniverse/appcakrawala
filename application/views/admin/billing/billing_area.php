<?php
/* Employees report view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $_tasks = $this->Timesheet_model->get_tasks(); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<!-- <pre>
<?php //print_r($all_billing_area); 
?>
</pre> -->

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
			<span class="card-header-title mr-2"><strong>BILLING AREA | </strong>FILTER</span>
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

		<?php //echo form_open_multipart('/admin/importexcel/import_saltab3/'); 
		?>

		<input type="hidden" id="nik" name="nik" value=<?php echo $session['employee_id']; ?>>

		<div class="form-row">
			<div class="col-md-3">
				<div class="form-group project-option">
					<label class="form-label">AREA</label>
					<select class="form-control dropdown-billing-area" name="area_filter" id="area_filter">
						<option value="0">Pilih area billing</option>
						<?php foreach ($all_billing_area as $billing) { ?>
							<?php if ($billing['billing_area'] != null) { ?>
								<option value="<?php echo $billing['billing_area']; ?>"> <?php echo $billing['billing_area']; ?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="col-md-3" id="subproject_ajax">
				<label class="form-label">TAHUN</label>
				<select class="form-control dropdown-billing-area" name="tahun_filter" id="tahun_filter">
					<option value="0">ALL</option>
					<?php $mulai_tahun = 2020; ?>
					<?php $end_tahun = date('Y'); ?>
					<?php while ($mulai_tahun <= $end_tahun) { ?>
						<option value="<?php echo $mulai_tahun; ?>" <?php if ($mulai_tahun == $end_tahun) {
																		echo " selected";
																	} ?>> <?php echo $mulai_tahun; ?></option>
						<?php $mulai_tahun++; ?>
					<?php } ?>
				</select>
			</div>

			<div class="col-md-3">
				<label class="form-label">BULAN</label>
				<select class="form-control dropdown-billing-area" name="bulan_filter" id="bulan_filter">
					<option value="0">ALL</option>
					<option value="01">JANUARI</option>
					<option value="02">FEBRUARI</option>
					<option value="03">MARET</option>
					<option value="04">APRIL</option>
					<option value="05">MEI</option>
					<option value="06">JUNI</option>
					<option value="07">JULI</option>
					<option value="08">AGUSTUS</option>
					<option value="09">SEPTEMBER</option>
					<option value="10">OKTOBER</option>
					<option value="11">NOVEMBER</option>
					<option value="12">DESEMBER</option>
				</select>
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<!-- button submit -->
					<label class="form-label">&nbsp;</label>
					<button onclick="filter_tabel()" name="filter_tabel" id="filter_tabel" class="btn btn-primary btn-block"><i class="fa fa-search"></i> FILTER</button>
				</div>
			</div>
		</div>

		<?php //echo form_close(); 
		?>

	</div>
</div>

<!-- SECTION DATA TABLES -->
<div class="row m-b-1 <?php echo $get_animate; ?>">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header with-elements">
				<div class="col-md-6">
					<span class="card-header-title mr-2"><strong>LIST BILLING</strong></span>
				</div>

				<div class="col-md-6">
					<div class="pull-right">
						<!-- <div class="card-header with-elements"> -->
						<span class="card-header-title mr-2">
							<button hidden onclick="download_data()" id="button_download_data" class="btn btn-success" data-style="expand-right">Download Data</button>
						</span>
					</div>
				</div>
			</div>

			<!-- <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>LIST EMPLOYEES</strong></span> </div> -->
			<div class="card-body">
				<div class="box-datatable table-responsive">
					<table class="datatables-demo table table-striped table-bordered" id="tabel_billing">
						<thead>
							<tr>
								<th>Aksi</th>
								<th>Billing Area</th>
								<th>Project</th>
								<th>Total MPP</th>
								<th>Total Billing</th>
								<th>Manfee</th>
								<th>Total</th>
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
	var billing_table;
	var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
		csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
	var session_id = '<?php echo $session['employee_id']; ?>';

	var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
	var loading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	loading_html_text = loading_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
	loading_html_text = loading_html_text + '<h2>LOADING...</h2>';
	loading_html_text = loading_html_text + '</div>';

	$(document).ready(function() {
		//inisialisasi select2 untuk searchable dropdown
		$('.dropdown-billing-area').select2({
			width: '100%'
		});

		var area_filter = $("#area_filter").val();
		var tahun_filter = $("#tahun_filter").val();
		var bulan_filter = $("#bulan_filter").val();

		billing_table = $('#tabel_billing').DataTable().on('search.dt', () => eventFired('Search'));
	});
</script>

<!-- Tombol Filter -->
<script type="text/javascript">
	function filter_tabel() {
		billing_table.destroy();

		e.preventDefault();

		var area_filter = $("#area_filter").val();
		var tahun_filter = $("#tahun_filter").val();
		var bulan_filter = $("#bulan_filter").val();

		var searchVal = $('#tabel_billing_filter').find('input').val();

		// if ((searchVal == "") && (project == "0")) {
		// 	$('#button_download_data').attr("hidden", true);

		// } else {
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
				'url': '<?= base_url() ?>admin/billing_area/list_billing_area',
				data: {
					[csrfName]: csrfHash,
					session_id: session_id,
					area_filter: area_filter,
					tahun_filter: tahun_filter,
					bulan_filter: bulan_filter,
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

		$('#filter_tabel').attr("disabled", false);
		$('#filter_tabel').removeAttr("data-loading");
		// }

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
