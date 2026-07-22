<?php
/* Date Wise Attendance Report > EMployees view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>


<?php $count_appnae = $this->Xin_model->count_approve_nae_pkwt($session['employee_id']); ?>
<?php $count_appnom = $this->Xin_model->count_approve_nom_pkwt($session['employee_id']); ?>
<?php $count_apphrd = $this->Xin_model->count_approve_hrd_pkwt($session['employee_id']); ?>
<?php $count_pkwtcancel = $this->Xin_model->count_approve_pkwt_cancel($session['employee_id']); ?>
<?php $count_emp_request = $this->Xin_model->count_emp_request($session['employee_id']); ?>

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

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
	<ul class="nav nav-tabs step-anchor">
		<?php if (in_array('377', $role_resources_ids)) { ?>
			<li class="nav-item clickable"> <a href="<?php echo site_url('admin/reports/pkwt_expired/'); ?>" data-link-data="<?php echo site_url('admin/reports/pkwt_expired/'); ?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon fa fa-database"></span>PKWT EXPIRED
				</a> </li>
		<?php } ?>


		<?php if (in_array('505', $role_resources_ids)) { ?>
			<li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_pkwt_aphrd'); ?>" data-link-data="<?php echo site_url('admin/Employee_pkwt_aphrd/'); ?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span>HRD CHECKER
					<?php echo '(' . $count_apphrd . ')'; ?></a> </li>
		<?php } ?>

		<?php if (in_array('379', $role_resources_ids)) { ?>
			<li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_pkwt_cancel'); ?>" data-link-data="<?php echo site_url('admin/Employee_pkwt_cancel/'); ?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span>DITOLAK <?php echo '(' . $count_pkwtcancel . ')'; ?>
				</a> </li>
		<?php } ?>

		<?php if (in_array('377', $role_resources_ids)) { ?>
			<li class="nav-item active"> <a href="<?php echo site_url('admin/reports/pkwt_history'); ?>" data-link-data="<?php echo site_url('admin/reports/pkwt_history'); ?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span>PKWT REPORT
				</a> </li>
		<?php } ?>
	</ul>
</div>

<div class="row">
	<div class="col-md-12 <?php echo $get_animate; ?>">
		<div class="ui-bordered px-4 pt-4 mb-4">
			<input type="hidden" id="user_id" value="0" />
			<?php $attributes = array('name' => 'attendance_datewise_report', 'id' => 'attendance_datewise_report', 'autocomplete' => 'off', 'class' => 'add form-hrm'); ?>
			<?php $hidden = array('euser_id' => $session['user_id']); ?>
			<?php echo form_open('admin/reports/pkwt_history', $attributes, $hidden); ?>
			<?php
			$data = array(
				'name'        => 'user_id',
				'id'          => 'user_id',
				'value'       => $session['user_id'],
				'type'   		  => 'hidden',
				'class'       => 'form-control',
			);

			echo form_input($data);
			?>
			<div class="form-row">


				<div class="col-md mb-3">

					<label class="form-label">Projects <?php echo $session['employee_id']; ?></label>
					<select class="form-control" name="project_id" id="aj_project" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_projects'); ?>">
						<option value="0">--Pilih Project--</option>
						<option value="999">--ALL--</option>
						<?php foreach ($all_projects as $proj) { ?>
							<option value="<?php echo $proj->project_id; ?>"> <?php echo $proj->title; ?></option>
						<?php } ?>
					</select>
				</div>


				<div class="col-md mb-3" id="subproject_ajax" hidden>
					<label class="form-label">Sub Projects</label>
					<select class="form-control" name="sub_project_id" id="aj_subproject" data-plugin="select_hrm" data-placeholder="Sub Project">
						<option value="0">--</option>
					</select>
				</div>

				<div class="col-md mb-3" id="areaemp_ajax" hidden>
					<label class="form-label">Area/Penempatan</label>
					<select class="form-control" name="area_emp" id="aj_area_emp" data-plugin="select_hrm" data-placeholder="Area/Penempatan">
						<option value="0">--</option>
					</select>
				</div>

				<div class="col-md mb-3">
					<label class="form-label"><?php echo $this->lang->line('xin_select_date'); ?></label>
					<input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date'); ?>" readonly id="start_date" name="start_date" id="aj_sdate" type="text" value="<?php echo date('Y-m-d'); ?>">
				</div>

				<div class="col-md mb-3">
					<label class="form-label"><?php echo $this->lang->line('xin_select_date'); ?></label>
					<input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date'); ?>" readonly id="end_date" name="end_date" id="aj_edate" type="text" value="<?php echo date('Y-m-d'); ?>">
				</div>

				<div class="col-md col-xl-2 mb-4">
					<label class="form-label d-none d-md-block">&nbsp;</label>
					<button type="submit" class="btn btn-secondary btn-block"><?php echo $this->lang->line('xin_get'); ?></button>
				</div>


			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<div class="row m-b-1 <?php echo $get_animate; ?>">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_hr_reports_attendance_employee'); ?></strong></span> </div>
			<div class="card-body">
				<div class="box-datatable table-responsive">
					<table class="datatables-demo table table-striped table-bordered" id="xin_table">
						<thead>
							<tr>
								<th colspan="2"><?php echo $this->lang->line('xin_hr_info'); ?></th>
								<th colspan="9"><?php echo $this->lang->line('xin_attendance_report'); ?></th>
							</tr>
							<tr>
								<th>No.</th>
								<th>Status</th>
								<th>NIP</th>
								<th>PIN</th>
								<th>Nama Lengkap</th>
								<th>Project</th>
								<th>Sub Project</th>
								<th>Posisi/Jabatan</th>
								<th>Area/Penempatan</th>
								<th>Waktu Kontrak</th>
								<th>PKWT Terbit</th>
								<th>File PKWT</th>

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

<script>
	var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
		csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

	var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
	var loading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	loading_html_text = loading_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
	loading_html_text = loading_html_text + '<h2>LOADING...</h2>';
	loading_html_text = loading_html_text + '</div>';

	var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
	var sending_email_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	sending_email_html_text = sending_email_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
	sending_email_html_text = sending_email_html_text + '<h2>Sending Email...</h2>';
	sending_email_html_text = sending_email_html_text + '</div>';

	var success_image = "<?php echo base_url('assets/icon/ceklis_hijau.png'); ?>";
	var success_email_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
	success_email_html_text = success_email_html_text + '<img src="' + success_image + '" alt="" width="100px">';
	success_email_html_text = success_email_html_text + '<h2 style="color: #00FFA3;">BERHASIL KIRIM EMAIL</h2>';
	success_email_html_text = success_email_html_text + '</div>';
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