<?php
defined('BASEPATH') or exit('No direct script access allowed');
if (isset($_GET['jd']) && isset($_GET['role_id']) && $_GET['data'] == 'role') {
	$role_resources_ids = explode(',', $role_resources);
?>
	<div class="modal-header">
		<?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
		<h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_role_editrole'); ?></h4>
	</div>
	<?php $attributes = array('name' => 'edit_role', 'id' => 'edit_role', 'autocomplete' => 'off', 'class' => '"m-b-1'); ?>
	<?php $hidden = array('_method' => 'EDIT', 'ext_name' => $role_name, '_token' => $role_id); ?>
	<?php echo form_open('admin/roles/update/' . $role_id, $attributes, $hidden); ?>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="role_name"><?php echo $this->lang->line('xin_role_name'); ?><i class="hrpremium-asterisk">*</i></label>
							<input class="form-control" placeholder="<?php echo $this->lang->line('xin_role_name'); ?>" name="role_name" type="text" value="<?php echo $role_name; ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<input type="checkbox" name="role_resources[]" value="0" checked style="display:none;" />
					<div class="col-md-12">
						<div class="form-group">
							<label for="role_access"><?php echo $this->lang->line('xin_role_access'); ?><i class="hrpremium-asterisk">*</i></label>
							<select class="form-control custom-select" id="role_access_modal" name="role_access" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_role_access'); ?>">
								<option value="">&nbsp;</option>
								<option value="1" <?php if ($role_access == 1) : ?> selected="selected" <?php endif; ?>><?php echo $this->lang->line('xin_role_all_menu'); ?></option>
								<option value="2" <?php if ($role_access == 2) : ?> selected="selected" <?php endif; ?>><?php echo $this->lang->line('xin_role_cmenu'); ?></option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<p><strong><?php echo $this->lang->line('xin_role_note_title'); ?></strong></p>
						<p><?php echo $this->lang->line('xin_role_note1'); ?></p>
						<p><?php echo $this->lang->line('xin_role_note2'); ?></p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="resources"><?php echo $this->lang->line('xin_role_resource'); ?></label>
							<div id="all_resources">
								<div class="demo-section k-content">
									<div>
										<div id="treeview_m1"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<div id="all_resources">
								<div class="demo-section k-content">
									<div>
										<div id="treeview_m2"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> ' . $this->lang->line('xin_close'))); ?> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> ' . $this->lang->line('xin_update'))); ?>
	</div>
	<?php echo form_close(); ?>
	<script type="text/javascript">
		$(document).ready(function() {

			$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
			$('[data-plugin="select_hrm"]').select2({
				width: '100%'
			});
			Ladda.bind('button[type=submit]');

			/* Edit data */
			$("#edit_role").submit(function(e) {
				e.preventDefault();
				var obj = $(this),
					action = obj.attr('name');
				$('.save').prop('disabled', true);

				$.ajax({
					type: "POST",
					url: e.target.action,
					data: obj.serialize() + "&is_ajax=1&edit_type=role&form=" + action,
					cache: false,
					success: function(JSON) {
						if (JSON.error != '') {
							toastr.error(JSON.error);
							$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						} else {
							// On page load: datatable
							var xin_table = $('#xin_table').dataTable({
								"bDestroy": true,
								"ajax": {
									url: "<?php echo site_url("admin/roles/role_list") ?>",
									type: 'GET'
								},
								dom: 'lBfrtip',
								"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
								"fnDrawCallback": function(settings) {
									$('[data-toggle="tooltip"]').tooltip();
								}
							});
							xin_table.api().ajax.reload(function() {
								toastr.success(JSON.result);
							}, true);
							$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
							$('.edit-modal-data').modal('toggle');
							$('.save').prop('disabled', false);
							Ladda.stopAll();
						}
					}
				});
			});
		});
	</script>
	<script>
		jQuery("#treeview_m1").kendoTreeView({
			checkboxes: {
				checkChildren: true,
				//template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'  /><span class='custom-control-indicator'></span><span class='custom-control-description'>#= item.text #</span><span class='custom-control-info'>#= item.add_info #</span></label>"
				/*template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class='custom-control-label'>#= item.text # <small>#= item.add_info #</small></span></label>"
				template: "<label><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'> #= item.text #</label>"
				},*/
				template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class='custom-control-label'>#= item.text # <small>#= item.add_info #</small></span></label>"
			},
			check: onCheck,
			dataSource: [

				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "Dashboard",
					add_info: "",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('103', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					value: "103",
					items: [


						// MY PROFILE
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('header_my_profile'); ?>",
							add_info: "",
							value: "132",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "132",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('132', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Verification Profile",
									add_info: "",
									value: "1000",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('1000', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Verification Button",
									add_info: "",
									value: "1012",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('1012', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Send PIN",
									add_info: "",
									value: "1002",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('1002', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Send Whatsapp",
									add_info: "",
									value: "1003",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('1003', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Edit Data Diri",
									add_info: "",
									value: "1001",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('1001', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Edit No KK, KTP, NO HP, Ibu, Alamat",
									add_info: "",
									value: "1004",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('1004', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Edit Jabatan",
									add_info: "",
									value: "1005",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('1005', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Edit Kontak Darurat",
									add_info: "",
									value: "1006",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('1006', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Edit Rekening Bank",
									add_info: "",
									value: "1007",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('1007', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Edit Dokumen Pribadi",
									add_info: "",
									value: "1008",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('1008', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},


								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Download Dokumen Pribadi",
									add_info: "",
									value: "1016",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('1016', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Edit BPJS KS & TK",
									add_info: "",
									value: "1009",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('1009', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Hapus Kontrak",
									add_info: "",
									value: "1010",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('1010', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Edit Kontrak",
									add_info: "",
									value: "1014",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('1014', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Download/Upload Kontrak",
									add_info: "",
									value: "1011",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('1011', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Tambah Addendum",
									add_info: "",
									value: "1015",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('1015', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Role Karyawan",
									add_info: "",
									value: "1013",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('1013', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]
						},


						// CEK NIP
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "CEK NIP",
							add_info: "CEK NIP",
							value: "134",
							items: [{
								id: "",
								class: "role-checkbox-modal custom-control-input",
								text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
								add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
								value: "134",
								check: "<?php if (isset($_GET['role_id'])) {
											if (in_array('134', $role_resources_ids)) : echo 'checked';
											else : echo '';
											endif;
										} ?>"
							}]
						},


						{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Login JOB ORDER",
									add_info: "",
									value: "13",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('13', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
						},


						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_download_profile_title'); ?>",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "421",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('421', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},


						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('left_employees_last_login'); ?>",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "22",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('22', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_lock_user'); ?>",
							add_info: "<?php echo $this->lang->line('xin_lock_user'); ?>",
							value: "465",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('465', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
					]
				},



				//MENU CALL CENTER CS
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "<?php echo $this->lang->line('xin_menu_cs'); ?>",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('479', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					add_info: "",
					value: "479",
					items: [{
						id: "",
						class: "role-checkbox-modal custom-control-input",
						text: "<?php echo $this->lang->line('xin_whatsapp_blast'); ?>",
						add_info: "Wa.me",
						value: "480",
						check: "<?php if (isset($_GET['role_id'])) {
									if (in_array('480', $role_resources_ids)) : echo 'checked';
									else : echo '';
									endif;
								} ?>"
					}]
				},

				//MODUL PKWT (OLD)
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "Modul PKWT (Old)",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('34', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					add_info: "",
					value: "34",
					items: [{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_pkwt_list'); ?>",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "34",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('34', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "34",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('34', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},

								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_add'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "35",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('35', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},

								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_edit'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "38",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('38', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},

								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_delete'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "39",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('39', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]

						},

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_pkwt_expired'); ?>",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "58",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('4', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "58",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('58', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_add'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "58",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('58', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_edit'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "58",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('58', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_delete'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "58",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('58', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]

						},

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_pkwt_approval'); ?>",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "67",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('67', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "67",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('67', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_edit'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "68",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('68', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]

						},

					]
				}, // sub 1 end


				//MODUL CMO USER MOBILE (OLD)
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "Modul CMO User Mobile (Old)",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('59', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					add_info: "",
					value: "59",
					items: [{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
							add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
							value: "59",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('59', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_role_add'); ?>",
							add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
							value: "64",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('64', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_role_edit'); ?>",
							add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
							value: "65",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('65', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_role_delete'); ?>",
							add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
							value: "66",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('66', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						}
					]
				},


				//MODUL DATABSAE KARYAWAN
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "Modul Database Karyawan",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('467', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					add_info: "",
					value: "467",
					items: [

						// REQUEST EMP
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_request_employee'); ?>",
							add_info: "",
							value: "327",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "327",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('327', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_request'); ?>",
									add_info: "<?php echo $this->lang->line('xin_request'); ?>",
									value: "337",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('337', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Cancel REQ",
									add_info: "<?php echo $this->lang->line('xin_request'); ?>",
									value: "338",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('338', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Approve Level #1",
									add_info: "",
									value: "374",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('374', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Approve Level #2",
									add_info: "",
									value: "375",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('375', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Approve HRD",
									add_info: "",
									value: "378",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('378', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Release PKWT",
									add_info: "",
									value: "382",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('382', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]
						},

						// REQUEST PKWT
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_request_pkwt'); ?>",
							add_info: "",
							value: "376",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "376",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('376', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Cancel PKWT",
									add_info: "<?php echo $this->lang->line('xin_request'); ?>",
									value: "379",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('379', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_request'); ?>",
									add_info: "<?php echo $this->lang->line('xin_request'); ?>",
									value: "377",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('377', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_request_employee_approvenae'); ?>",
									add_info: "#",
									value: "503",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('503', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_request_employee_approvenom'); ?>",
									add_info: "#",
									value: "504",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('504', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_request_employee_approvehrd'); ?>",
									add_info: "#",
									value: "505",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('505', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "PKWT Report",
									add_info: "Pkwt Report",
									value: "380",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('380', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]
						},

						// REQUEST TKHL
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Request TKHL",
							add_info: "",
							value: "312",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "312",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('312', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Cancel PKWT",
									add_info: "<?php echo $this->lang->line('xin_request'); ?>",
									value: "312",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('312', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_request'); ?>",
									add_info: "<?php echo $this->lang->line('xin_request'); ?>",
									value: "312",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('312', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_request_employee_approvenae'); ?>",
									add_info: "#",
									value: "312",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('312', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_request_employee_approvenom'); ?>",
									add_info: "#",
									value: "312",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('312', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_request_employee_approvehrd'); ?>",
									add_info: "#",
									value: "312",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('312', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]
						},

						// RESIGN EMP
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('left_resignations'); ?>",
							add_info: "",
							value: "490",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "490",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('490', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_request'); ?>",
									add_info: "<?php echo $this->lang->line('xin_request'); ?>",
									value: "491",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('491', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_request_employee_approvenae'); ?>",
									add_info: "#",
									value: "492",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('492', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_request_employee_approvenom'); ?>",
									add_info: "#",
									value: "493",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('493', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_request_employee_approvehrd'); ?>",
									add_info: "#",
									value: "494",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('494', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_request_resign_cancelled'); ?>",
									add_info: "#",
									value: "506",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('506', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]
						},
						
						// DATABASE
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('left_db_employee'); ?>",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('470', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							add_info: "",
							value: "470",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "470",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('470', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_e_details_edit_profile'); ?>",
									add_info: "<?php echo $this->lang->line('xin_e_details_edit_profile'); ?>",
									value: "471",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('471', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_e_details_edit_grade'); ?>",
									add_info: "<?php echo $this->lang->line('xin_e_details_edit_grade'); ?>",
									value: "473",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('473', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_manage_employees_bpjs'); ?>",
									add_info: "<?php echo $this->lang->line('xin_manage_employees_bpjs'); ?>",
									value: "472",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('472', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_manage_employees_rekening'); ?>",
									add_info: "<?php echo $this->lang->line('xin_manage_employees_rekening'); ?>",
									value: "474",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('474', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_manage_employees_blacklist'); ?>",
									add_info: "<?php echo $this->lang->line('xin_manage_employees_blacklist'); ?>",
									value: "475",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('475', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]
						},


					]
				},


				//MODUL BPJS EMPLOYEE (OLD)
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "Modul BPJS Employee (Old)",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('476', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					add_info: "",
					value: "476",
					items: [{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
							add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
							value: "476",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('476', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Saltab",
							add_info: "saltab",
							value: "477",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('477', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						}

					]
				},


				//KARYAWAN INHOUSE (OLD)
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "Modul Akses Inhouse (Old)",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('117', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					add_info: "",
					value: "117",
					items: [{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_inhouse'); ?>",
							add_info: "<?php echo $this->lang->line('xin_inhouse'); ?>",
							value: "139",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('139', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_project'); ?>",
							add_info: "<?php echo $this->lang->line('xin_project'); ?>",
							value: "117",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('117', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						}
					]
				},


				//MODUL IMPORT (OLD)
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "Modul Import (Old)",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('126', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					add_info: "",
					value: "126",
					items: [{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_import_excl_employee'); ?>",
							add_info: "",
							value: "127",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('127', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Import PKWT",
							add_info: "",
							value: "128",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('128', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_import_excl_ratecard'); ?>",
							add_info: "",
							value: "232",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('232', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Import Saltab to BPJS",
							add_info: "",
							value: "481",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('481', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_import_excl_eslip'); ?>",
							add_info: "",
							value: "469",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('469', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						}
					]
				},


				//MODUL SALTAB PAYROLL
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "Modul Saltab",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('501', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					add_info: "",
					value: "501",
					items: [{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Import SALTAB",
							add_info: "",
							value: "511",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('511', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Konfigurasi Import SALTAB",
							add_info: "",
							value: "512",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('512', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Edit NIP SALTAB",
							add_info: "",
							value: "1101",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('1101', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Manage SALTAB",
							add_info: "",
							value: "513",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('513', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Download SALTAB",
							add_info: "",
							value: "514",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('514', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Konfigurasi Download SALTAB",
							add_info: "",
							value: "515",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('515', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Release E-Slip",
							add_info: "",
							value: "1100",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('1100', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						}
					]
				},


				//MODUL BUPOT ACCOUNTING
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "Modul Bupot",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('1300', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					add_info: "",
					value: "1300",
					items: [{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "View Bupot",
							add_info: "",
							value: "1300",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('1300', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Import Bupot",
							add_info: "",
							value: "1301",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('1301', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Release Bupot",
							add_info: "",
							value: "1302",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('1302', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Delete Bupot",
							add_info: "",
							value: "1303",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('1303', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},

					]
				},

				//MODUL BPJS IMPORT
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "Modul Import BPJS",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('1400', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					add_info: "",
					value: "1400",
					items: [{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Import Nomor BPJS",
							add_info: "",
							value: "1401",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('1401', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Management Nomor BPJS",
							add_info: "",
							value: "1402",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('1402', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},

					]
				},


				// MODUL DOKUMEN SK KERJA
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "<?php echo $this->lang->line('xin_document_id'); ?>",
					add_info: "",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('486', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					value: "486",
					items: [

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_surat_keterangan_kerja'); ?>",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('486', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							add_info: "",
							value: "486",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "487",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('487', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_add'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "488",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('488', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_edit'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "488",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('488', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_delete'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "489",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('489', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]
						},

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_sk_report'); ?>",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "499",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('499', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "499",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('499', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_delete'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "500",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('500', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]
						}
					]
				},


				//LAPORAN ADMIN
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "Laporan Admin",
					add_info: "",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('486', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					value: "486",
					items: [

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Laporan PKWT",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('486', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							add_info: "",
							value: "486",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "487",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('487', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_add'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "488",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('488', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_edit'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "488",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('488', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_delete'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "489",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('489', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]
						},

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Lapran Adendum",
							add_info: "Addendum Report",
							value: "520",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('520', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "520",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('520', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Import Adendum",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "521 ",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('521 ', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]
						}
					]
				},

				// ORGANIZATION
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "<?php echo $this->lang->line('left_organization'); ?>",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('2', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					add_info: "",
					value: "2",
					items: [

						// company
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('left_company'); ?>",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "5",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('5', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "5",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('5', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_add'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "246",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('246', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_edit'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "247",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('247', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_delete'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "248",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('248', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
							]
						},
						// project
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('left_projects'); ?>",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "44",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('44', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "44",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('44', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>",
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_add'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "45",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('45', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>",
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_edit'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "47",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('47', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>",
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_delete'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "90",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('90', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>",
								},
							]
						},
						// Sub-project
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Sub Project",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "130",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('130', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "130",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('130', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>",
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_add'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "130",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('130', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>",
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_edit'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "131",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('131', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>",
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_delete'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "131",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('131', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>",
								},
							]
						},
						// designation
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('left_designation'); ?>",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "4",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('4', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "4",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('4', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_add'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "243",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('243', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_edit'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "244",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('244', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_delete'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "245",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('245', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo '<small>' . $this->lang->line('xin_role_view') . ' ' . $this->lang->line('left_designation') . '</small>'; ?>",
									add_info: "<?php echo $this->lang->line('xin_role_view'); ?>",
									value: "249",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('249', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]
						},
						// mapping subproject-posisi
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Mapping Posisi/Jabatan",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "3",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('207', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "3",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('207', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_add'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "208",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('208', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_delete'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "209",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('209', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]
						},
						// akses project
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_akses_project'); ?>",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "207",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('207', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "207",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('207', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_add'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "208",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('208', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_delete'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "209",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('209', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]
						},
						// daftar esign
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_esign_register'); ?>",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "478",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('478', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							items: [{
								id: "",
								class: "role-checkbox-modal custom-control-input",
								text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
								add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
								value: "478",
								check: "<?php if (isset($_GET['role_id'])) {
											if (in_array('478', $role_resources_ids)) : echo 'checked';
											else : echo '';
											endif;
										} ?>"
							}]
						},
					]
				}, // sub 1 end

			]
		});

		jQuery("#treeview_m2").kendoTreeView({
			checkboxes: {
				checkChildren: true,
				//template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'  /><span class='custom-control-indicator'></span><span class='custom-control-description'>#= item.text #</span><span class='custom-control-info'>#= item.add_info #</span></label>"
				/*template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class='custom-control-label'>#= item.text # <small>#= item.add_info #</small></span></label>"
				template: "<label><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'> #= item.text #</label>"
				},*/
				template: "<label class='custom-control custom-checkbox'><input type='checkbox' #= item.check# class='#= item.class #' name='role_resources[]' value='#= item.value #'><span class='custom-control-label'>#= item.text # <small>#= item.add_info #</small></span></label>"
			},
			check: onCheck,
			dataSource: [
				
				// HRD CORE
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "HRD Core",
					add_info: "",
					value: "12",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('12', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					items: [
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Riwayat Karyawan Baru",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "121",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('121', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "Billing",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "122",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('122', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								
							]
				},
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "<?php echo $this->lang->line('xin_system'); ?>",
					add_info: "",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('57', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					value: "57",
					items: [{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('left_settings'); ?>",
							add_info: "<?php echo $this->lang->line('xin_view_update'); ?>",
							value: "60",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('60', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('left_constants'); ?>",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "61",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('61', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('left_db_backup'); ?>",
							add_info: "<?php echo $this->lang->line('xin_create_delete_download'); ?>",
							value: "62",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('62', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('left_email_templates'); ?>",
							add_info: "<?php echo $this->lang->line('xin_update'); ?>",
							value: "63",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('63', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_setup_modules'); ?>",
							add_info: "<?php echo $this->lang->line('xin_update'); ?>",
							value: "93",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('93', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_acc_payment_gateway'); ?>",
							add_info: "<?php echo $this->lang->line('xin_update'); ?>",
							value: "118",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('118', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_system'); ?>",
							add_info: "<?php echo $this->lang->line('xin_view_update'); ?>",
							value: "297",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('297', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_general'); ?>",
							add_info: "<?php echo $this->lang->line('xin_view_update'); ?>",
							value: "431",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('431', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_employee_role'); ?>",
							add_info: "<?php echo $this->lang->line('xin_view_update'); ?>",
							value: "432",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('432', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('left_payroll'); ?>",
							add_info: "<?php echo $this->lang->line('xin_view_update'); ?>",
							value: "433",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('433', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('left_recruitment'); ?>",
							add_info: "<?php echo $this->lang->line('xin_view_update'); ?>",
							value: "434",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('434', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('left_performance'); ?>",
							add_info: "<?php echo $this->lang->line('xin_view_update'); ?>",
							value: "435",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('435', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_system_logos'); ?>",
							add_info: "<?php echo $this->lang->line('xin_view_update'); ?>",
							value: "436",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('436', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_email_notifications'); ?>",
							add_info: "<?php echo $this->lang->line('xin_view_update'); ?>",
							value: "437",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('437', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_page_layouts'); ?>",
							add_info: "<?php echo $this->lang->line('xin_view_update'); ?>",
							value: "438",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('438', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_notification_position'); ?>",
							add_info: "<?php echo $this->lang->line('xin_view_update'); ?>",
							value: "439",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('439', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_files_manager'); ?>",
							add_info: "<?php echo $this->lang->line('xin_view_update'); ?>",
							value: "440",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('440', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_org_chart_title'); ?>",
							add_info: "<?php echo $this->lang->line('xin_view_update'); ?>",
							value: "441",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('441', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_manage_top_menu'); ?>",
							add_info: "<?php echo $this->lang->line('xin_view_update'); ?>",
							value: "466",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('466', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},

					]
				},

				//MODUL TARGET BUDGETING
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "Modul Budgeting",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('71', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					add_info: "",
					value: "71",
					items: [{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Enable Budgeting",
							add_info: "-",
							value: "71",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('71', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Pengajuan SP",
							add_info: "-",
							value: "711",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('711', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Invoice",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('712', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							add_info: "-",
							value: "712",
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Monitoring SP",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('713', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							add_info: "-",
							value: "713",
						},
					]
				},
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "<?php echo $this->lang->line('xin_acc_transactions'); ?>",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('74', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					add_info: "",
					value: "74",
					items: [{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_acc_deposit'); ?>",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('75', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "75",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "75",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('75', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_add'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "355",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('355', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_edit'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "356",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('356', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_delete'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "357",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('357', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_acc_expense'); ?>",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('76', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "76",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "76",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('76', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_add'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "358",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('358', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_edit'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "359",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('359', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_delete'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "360",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('360', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_acc_transfer'); ?>",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('77', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "77",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "77",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('77', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_add'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "361",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('361', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_edit'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "362",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('362', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_delete'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "363",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('363', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_acc_view_transactions'); ?>",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('78', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							add_info: "<?php echo $this->lang->line('xin_view'); ?>",
							value: "78",
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_payslip_history'); ?>",
							add_info: "<?php echo $this->lang->line('xin_view_payslip'); ?>",
							value: "37",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('37', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "37",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('37', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo '<small>' . $this->lang->line('xin_role_view') . ' ' . $this->lang->line('left_payment_history') . '</small>'; ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "391",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('391', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
							]
						},
					]
				},

				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "<?php echo $this->lang->line('xin_acc_payees_payers'); ?>",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('79', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					add_info: "",
					value: "79",
					items: [{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_acc_payees'); ?>",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('80', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "80",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "80",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('80', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_add'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "364",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('364', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_edit'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "365",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('365', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_delete'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "366",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('366', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]
						},

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_acc_payers'); ?>",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('81', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
							value: "81",
							items: [{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
									value: "81",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('81', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_add'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "367",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('367', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_edit'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "368",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('368', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								},
								{
									id: "",
									class: "role-checkbox-modal custom-control-input",
									text: "<?php echo $this->lang->line('xin_role_delete'); ?>",
									add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
									value: "369",
									check: "<?php if (isset($_GET['role_id'])) {
												if (in_array('369', $role_resources_ids)) : echo 'checked';
												else : echo '';
												endif;
											} ?>"
								}
							]
						},
					]
				},

				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "<?php echo $this->lang->line('xin_acc_accounts') . ' ' . $this->lang->line('xin_acc_reports'); ?>",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('82', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					add_info: "",
					value: "82",
					items: [{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_acc_account_statement'); ?>",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('83', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							add_info: "<?php echo $this->lang->line('xin_view'); ?>",
							value: "83"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_acc_expense_reports'); ?>",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('84', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							add_info: "<?php echo $this->lang->line('xin_view'); ?>",
							value: "84",
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_acc_income_reports'); ?>",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('85', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							add_info: "<?php echo $this->lang->line('xin_view'); ?>",
							value: "85",
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_acc_transfer_report'); ?>",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('86', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>",
							add_info: "<?php echo $this->lang->line('xin_view'); ?>",
							value: "86",
						},
					]
				},

				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "<?php echo $this->lang->line('xin_lang_settings'); ?>",
					add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info'); ?>",
					value: "89",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('89', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					items: [{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_role_enable'); ?>",
							add_info: "<?php echo $this->lang->line('xin_role_enable'); ?>",
							value: "89",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('89', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_role_add'); ?>",
							add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
							value: "370",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('370', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_role_delete'); ?>",
							add_info: "<?php echo $this->lang->line('xin_role_add'); ?>",
							value: "371",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('371', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						}
					]
				},



				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "<?php echo $this->lang->line('xin_hr_calendar_title'); ?>",
					add_info: "<?php echo $this->lang->line('xin_view'); ?>",
					value: "95",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('95', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>"
				},
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "<?php echo $this->lang->line('xin_hr_chat_box'); ?>",
					add_info: "<?php echo $this->lang->line('xin_hr_chat_box'); ?>",
					value: "446",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('446', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>"
				},

				// TRAXES REPORT
				{
					id: "",
					class: "role-checkbox-modal custom-control-input",
					text: "Traxes Report",
					check: "<?php if (isset($_GET['role_id'])) {
								if (in_array('11', $role_resources_ids)) : echo 'checked';
								else : echo '';
								endif;
							} ?>",
					add_info: "",
					value: "11",
					items: [{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Check in-out Report",
							add_info: "Laporan Absensi",
							value: "110",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('110', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Sell-Out Report",
							add_info: "Laporan Penjualan",
							value: "111",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('111', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Sell-In Report",
							add_info: "Laporan Stock",
							value: "112",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('112', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Display Report",
							add_info: "Laporan Display",
							value: "114",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('114', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},
						

						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "Resume Report",
							add_info: "Laporan Bulanan",
							value: "113",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('113', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						},

						// USER ROLL
						{
							id: "",
							class: "role-checkbox-modal custom-control-input",
							text: "<?php echo $this->lang->line('xin_hr_report_user_roles'); ?>",
							add_info: "<?php echo $this->lang->line('xin_view'); ?>",
							value: "116",
							check: "<?php if (isset($_GET['role_id'])) {
										if (in_array('116', $role_resources_ids)) : echo 'checked';
										else : echo '';
										endif;
									} ?>"
						}
					]
				},
			]
		});

		// show checked node IDs on datasource change
		function onCheck() {
			var checkedNodes = [],
				treeView = jQuery("#treeview").data("kendoTreeView"),
				message;
			//checkedNodeIds(treeView.dataSource.view(), checkedNodes);
			jQuery("#result").html(message);
		}
		$(document).ready(function() {
			$("#role_access_modal").change(function() {
				var sel_val = $(this).val();
				if (sel_val == '1') {
					$('.role-checkbox-modal').prop('checked', true);
				} else {
					$('.role-checkbox-modal').prop("checked", false);
				}
			});
		});
	</script>
<?php }
?>