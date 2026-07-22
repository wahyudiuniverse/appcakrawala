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

<!-- MODAL UNTUK EMAIL -->
<div class="modal fade" id="emailModal" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="emailModalLabel">
					<div class="judul-modal-email">Kirim Email</div>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="isi-modal-email">
					<div class="container" id="container_modal_email">
						<div class="row">
							<table class="table table-striped col-md-12">
								<tbody>
									<tr>
										<td style='width:15%'><strong>From</strong></td>
										<td style='width:85%'>
											<input hidden type="text" id="email_nip">
											<select name="email_from" id="email_from" class="form-control" data-plugin="select_modal_email">
												<option value="hrd@spcakrawala.co.id">hrd@spcakrawala.co.id</option>
											</select>
											<!-- <input type="text" id="email_from" class="form-control" placeholder="From"> -->
										</td>
									</tr>
									<tr>
										<td style='width:10%'><strong>To</strong></td>
										<td style='width:85%'>
											<input type="text" id="email_to" class="form-control" placeholder="Tujuan Email">
										</td>
									</tr>
									<tr>
										<td style='width:10%'><strong>Subject Email</strong></td>
										<td style='width:85%'>
											<input type="text" id="email_subject" class="form-control" placeholder="Subject Email">
										</td>
									</tr>
									<tr>
										<td style='width:100%' colspan="2">
											<div id="container">
												<!-- The toolbar will be rendered in this container. -->
												<div id="toolbar-container"></div>
												<div id="editor">
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="info-modal-email">
				</div>
			</div>
			<div class="modal-footer">
				<button type='button' id="close_modal_email" class='btn btn-secondary' data-dismiss='modal'>Close</button>
				<button onclick="coba_lagi()" id='button_coba_lagi' name='button_coba_lagi' type='button' class='btn btn-primary'>Coba Lagi</button>
				<button onclick="send_email()" id='button_send_email' name='button_send_email' type='button' class='btn btn-primary'>Send Email</button>
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

<!-- SECTION FILTER -->
<!-- <pre>
	<?php //print_r($session); 
	?>
</pre> -->
<div hidden class="card border-blue">
	<div class="card-header with-elements">
		<div class="col-md-6">
			<span class="card-header-title mr-2"><strong>LOG BLAST EMAIL | </strong>FILTER</span>
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
					<span class="card-header-title mr-2"><strong>LOG BLAST EMAIL</strong></span>
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
								<th>Nama</th>
								<th>Email Tujuan</th>
								<th>Subject Email</th>
								<th>Blast on</th>
								<th>Blast by</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-----------------Script CKEdior5----------------------->

<!--Load Core Script-->
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/super-build/ckeditor.js"></script>

<script>
	CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
			// https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
			toolbar: {
				items: [
					'findAndReplace', 'selectAll', '|',
					'heading', '|',
					'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
					'bulletedList', 'numberedList', 'todoList', '|',
					'outdent', 'indent', '|',
					'undo', 'redo',
					'-',
					'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
					'alignment', '|',
					'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
					'specialCharacters', 'horizontalLine', 'pageBreak', '|',
					'textPartLanguage', '|',
					'sourceEditing'
				],
				shouldNotGroupWhenFull: true
			},
			// Changing the language of the interface requires loading the language file using the <script> tag.
			// language: 'es',
			list: {
				properties: {
					styles: true,
					startIndex: true,
					reversed: true
				}
			},
			// https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
			heading: {
				options: [{
						model: 'paragraph',
						title: 'Paragraph',
						class: 'ck-heading_paragraph'
					},
					{
						model: 'heading1',
						view: 'h1',
						title: 'Heading 1',
						class: 'ck-heading_heading1'
					},
					{
						model: 'heading2',
						view: 'h2',
						title: 'Heading 2',
						class: 'ck-heading_heading2'
					},
					{
						model: 'heading3',
						view: 'h3',
						title: 'Heading 3',
						class: 'ck-heading_heading3'
					},
					{
						model: 'heading4',
						view: 'h4',
						title: 'Heading 4',
						class: 'ck-heading_heading4'
					},
					{
						model: 'heading5',
						view: 'h5',
						title: 'Heading 5',
						class: 'ck-heading_heading5'
					},
					{
						model: 'heading6',
						view: 'h6',
						title: 'Heading 6',
						class: 'ck-heading_heading6'
					}
				]
			},
			// https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
			placeholder: 'Isi Email',
			//placeholder: templateAddendum,
			// https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
			fontFamily: {
				options: [
					'default',
					'Arial, Helvetica, sans-serif',
					'Courier New, Courier, monospace',
					'Georgia, serif',
					'Lucida Sans Unicode, Lucida Grande, sans-serif',
					'Tahoma, Geneva, sans-serif',
					'Times New Roman, Times, serif',
					'Trebuchet MS, Helvetica, sans-serif',
					'Verdana, Geneva, sans-serif'
				],
				supportAllValues: true
			},
			// https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
			fontSize: {
				options: [10, 12, 14, 'default', 18, 20, 22],
				supportAllValues: true
			},
			// Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
			// https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
			htmlSupport: {
				allow: [{
					name: /.*/,
					attributes: true,
					classes: true,
					styles: true
				}]
			},
			// Be careful with enabling previews
			// https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
			htmlEmbed: {
				showPreviews: true
			},
			// https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
			link: {
				decorators: {
					addTargetToExternalLinks: true,
					defaultProtocol: 'https://',
					toggleDownloadable: {
						mode: 'manual',
						label: 'Downloadable',
						attributes: {
							download: 'file'
						}
					}
				}
			},
			// https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
			mention: {
				feeds: [{
					marker: '@',
					feed: [
						'@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
						'@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
						'@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
						'@sugar', '@sweet', '@topping', '@wafer'
					],
					minimumCharacters: 1
				}]
			},
			// The "superbuild" contains more premium features that require additional configuration, disable them below.
			// Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
			removePlugins: [
				// These two are commercial, but you can try them out without registering to a trial.
				// 'ExportPdf',
				// 'ExportWord',
				'AIAssistant',
				'CKBox',
				'CKFinder',
				'EasyImage',
				// This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
				// https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
				// Storing images as Base64 is usually a very bad idea.
				// Replace it on production website with other solutions:
				// https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
				// 'Base64UploadAdapter',
				'RealTimeCollaborativeComments',
				'RealTimeCollaborativeTrackChanges',
				'RealTimeCollaborativeRevisionHistory',
				'PresenceList',
				'Comments',
				'TrackChanges',
				'TrackChangesData',
				'RevisionHistory',
				'Pagination',
				'WProofreader',
				// Careful, with the Mathtype plugin CKEditor will not load when loading this sample
				// from a local file system (file://) - load this site via HTTP server if you enable MathType.
				'MathType',
				// The following features are part of the Productivity Pack and require additional license.
				'SlashCommand',
				'Template',
				'DocumentOutline',
				'FormatPainter',
				'TableOfContents',
				'PasteFromOfficeEnhanced',
				'CaseChange'
			]
		})
		.then(editor => {
			window.editor = editor;

			//handleStatusChanges(editor);
			//handleSaveButton(editor);
			//handleBeforeunload(editor);
		});
</script>

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

	var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
	var sending_email_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	sending_email_html_text = sending_email_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
	sending_email_html_text = sending_email_html_text + '<h2>Sending Email...</h2>';
	sending_email_html_text = sending_email_html_text + '</div>';

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
	var success_email_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	success_email_html_text = success_email_html_text + '<img src="' + success_image + '" alt="" width="100px">';
	success_email_html_text = success_email_html_text + '<h2 style="color: #00FFA3;">BERHASIL KIRIM EMAIL</h2>';
	success_email_html_text = success_email_html_text + '</div>';

	$(document).ready(function() {
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({
			width: '100%'
		});

		$('[data-plugin="select_modal_verifikasi"]').select2({
			width: "100%",
			dropdownParent: $("#container_modal_verifikasi")
		});

		$('[data-plugin="select_modal_email"]').select2({
			width: "100%",
			dropdownParent: $("#container_modal_email")
		});

		var project = document.getElementById("aj_project").value;
		var sub_project = document.getElementById("aj_sub_project").value;
		var status = document.getElementById("status").value;
		var search_periode_from = "";
		var search_periode_to = "";

		// employee_table = $('#tabel_employees').DataTable().on('search.dt', () => eventFired('Search'));

		employee_table = $('#tabel_employees').DataTable({
			"searchDelay": 1000,
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
				[3, 'desc']
			],
			'ajax': {
				'url': '<?= base_url() ?>admin/reports/list_log_blast_email',
				data: {
					[csrfName]: csrfHash,
					// session_id: session_id,
					// project: project,
					// sub_project: sub_project,
					// status: status,
					//base_url_catat: base_url_catat
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert("Status :" + xhr.status);
					alert("responseText :" + xhr.responseText);
				},
			},
			'columns': [{
					data: 'nama',
					// "orderable": false
				},
				{
					data: 'email',
					// "orderable": false,
					//searchable: true
				},
				{
					data: 'email_subject',
					// "orderable": false,
					//searchable: true
				},
				{
					data: 'blast_on',
					// "orderable": false,
					//searchable: true
				},
				{
					data: 'blast_name',
					// "orderable": false,
					//searchable: true
				},
			]
		});
	});
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
				"searchDelay": 1000,
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
						"defaultContent": '',
						"orderable": false,
						render: function(data, type, row, meta) {
							if (type === 'display') {
								var currentCell = $("#tabel_employees").DataTable().cells({
									"row": meta.row,
									"column": meta.col
								}).nodes(0);
								$.ajax({
									url: '<?= base_url() ?>admin/Reports/get_detail_verifikasi_employee/',
									method: 'post',
									dataType: 'html',
									data: {
										[csrfName]: csrfHash,
										employee_id: row.periode,
										actual_verification_id: data,
									},
									beforeSend: function() {
										// return loading_html_text;
										$(currentCell).html(loading_html_text);
									},
									success: function(response) {
										$(currentCell).html(response);
										// return response;
									},
									error: function(xhr, status, error) {
										// html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
										// html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
										// // html_text = "Gagal fetch data. Kode error: " + xhr.status;
										// $('.isi-modal').html(html_text); //coba pake iframe
										// $('#button_save_pin').attr("hidden", true);
									}
								});
								// return null;
								// return '<a href="/edit/' + data + '">Edit</a>';
							}
						}
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
						"defaultContent": '',
						"orderable": false,
						render: function(data, type, row, meta) {
							if (type === 'display') {
								var currentCell = $("#tabel_employees").DataTable().cells({
									"row": meta.row,
									"column": meta.col
								}).nodes(0);
								$.ajax({
									url: '<?= base_url() ?>admin/Reports/get_detail_pkwt_employee/',
									method: 'post',
									dataType: 'html',
									data: {
										[csrfName]: csrfHash,
										employee_id: data,
									},
									beforeSend: function() {
										// return loading_html_text;
										$(currentCell).html(loading_html_text);
									},
									success: function(response) {
										$(currentCell).html(response);
										// return response;
									},
									error: function(xhr, status, error) {
										// html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
										// html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
										// // html_text = "Gagal fetch data. Kode error: " + xhr.status;
										// $('.isi-modal').html(html_text); //coba pake iframe
										// $('#button_save_pin').attr("hidden", true);
									}
								});
								// return null;
								// return '<a href="/edit/' + data + '">Edit</a>';
							}
						}
					},
				]
			});
			// }).on('search.dt', () => eventFired('Search'));

			$('#tombol_filter').attr("disabled", false);
			$('#tombol_filter').removeAttr("data-loading");
		}

		// alert(project);
		// alert(sub_project);
		// alert(status);
	};
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
</script>

<!-- Tombol SEND PIN VIA EMAIL -->
<script type="text/javascript">
	function open_email(nip) {
		$("#email_nip").val(nip);
		// $('#emailModal').appendTo("body").modal('show');

		// AJAX untuk ambil data buku tabungan employee terupdate
		$.ajax({
			url: '<?= base_url() ?>admin/Reports/get_email_pin/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				nip: nip,
			},
			beforeSend: function() {
				// $('#judul-modal-email').html("File KTP");
				$('.info-modal-email').html(loading_html_text);
				$('.info-modal-email').attr("hidden", false);
				$('.isi-modal-email').attr("hidden", true);
				$('#button_coba_lagi').attr("hidden", true);
				$('#button_send_email').attr("hidden", true);
				$('#emailModal').appendTo("body").modal('show');
			},
			success: function(response) {
				var res = jQuery.parseJSON(response);

				$("#email_to").val(res['tujuan_email']);
				$("#email_subject").val(res['subject_email']);
				editor.setData(res['message']);

				$('.info-modal-email').attr("hidden", true);
				$('.isi-modal-email').attr("hidden", false);
				$('#button_send_email').attr("hidden", false);
			},
			error: function(xhr, status, error) {
				html_text = "<strong><span style='color:#FF0000;'>Unknown Error. Silahkan coba lagi dengan jeda 1 menit.</strong>";
				html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
				// html_text = "Gagal fetch data. Kode error: " + xhr.status;
				$('.info-modal-email').html(html_text); //coba pake iframe
				$('.info-modal-email').attr("hidden", false);
				$('.isi-modal-email').attr("hidden", true);
				$('#button_send_email').attr("hidden", true);
			}
		});

	}
</script>

<!-- Tombol SEND PIN VIA EMAIL -->
<script type="text/javascript">
	function send_email() {
		var nip = $("#email_nip").val();
		var email_from = $("#email_from").val();
		var email_to = $("#email_to").val();
		var email_subject = $("#email_subject").val();
		var isi = editor.getData();
		var isi_encode = encodeURIComponent(isi);
		// AJAX untuk ambil data buku tabungan employee terupdate
		$.ajax({
			url: '<?= base_url() ?>admin/Reports/send_email_pin/',
			method: 'post',
			data: {
				[csrfName]: csrfHash,
				nip: nip,
				email_from: email_from,
				email_to: email_to,
				email_subject: email_subject,
				isi: isi,
			},
			beforeSend: function() {
				$('.info-modal-email').html(sending_email_html_text);
				$('.info-modal-email').attr("hidden", false);
				$('.isi-modal-email').attr("hidden", true);
				$('#button_send_email').attr("hidden", true);
			},
			success: function(response) {
				html_text = response;
				if (response == "Email sent.") {
					$('.info-modal-email').html(success_email_html_text);
				} else {
					$('#button_coba_lagi').attr("hidden", false);
					$('.info-modal-email').html(html_text);
				}

				$('#button_send_email').attr("hidden", true);
			},
			error: function(xhr, status, error) {
				html_text = "<strong><span style='color:#FF0000;'>Gagal kirim email. Silahkan coba lagi dengan jeda 1 menit.</strong>";
				html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
				// html_text = "Gagal fetch data. Kode error: " + xhr.status;
				$('.info-modal-email').html(html_text); //coba pake iframe
				$('.info-modal-email').attr("hidden", false);
				$('.isi-modal-email').attr("hidden", true);
				$('#button_send_email').attr("hidden", true);
				$('#button_coba_lagi').attr("hidden", false);
			}
		});

	}
</script>

<!-- Tombol SEND PIN VIA EMAIL -->
<script type="text/javascript">
	function coba_lagi() {
		$('#button_coba_lagi').attr("hidden", true);
		$('#button_send_email').attr("hidden", false);
		$('.info-modal-email').attr("hidden", true);
		$('.isi-modal-email').attr("hidden", false);
	}
</script>