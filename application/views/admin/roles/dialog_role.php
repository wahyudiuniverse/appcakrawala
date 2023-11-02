<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['role_id']) && $_GET['data']=='role'){
$role_resources_ids = explode(',',$role_resources);
?>
<div class="modal-header">
  <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_role_editrole');?></h4>
</div>
<?php $attributes = array('name' => 'edit_role', 'id' => 'edit_role', 'autocomplete' => 'off','class' => '"m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', 'ext_name' => $role_name, '_token' => $role_id);?>
<?php echo form_open('admin/roles/update/'.$role_id, $attributes, $hidden);?>
  <div class="modal-body">
    <div class="row">
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="role_name"><?php echo $this->lang->line('xin_role_name');?><i class="hrpremium-asterisk">*</i></label>
              <input class="form-control" placeholder="<?php echo $this->lang->line('xin_role_name');?>" name="role_name" type="text" value="<?php echo $role_name;?>">
            </div>
          </div>
        </div>
        <div class="row">
        	<input type="checkbox" name="role_resources[]" value="0" checked style="display:none;"/>
          <div class="col-md-12">
            <div class="form-group">
              <label for="role_access"><?php echo $this->lang->line('xin_role_access');?><i class="hrpremium-asterisk">*</i></label>
              <select class="form-control custom-select" id="role_access_modal" name="role_access" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_role_access');?>">
                <option value="">&nbsp;</option>
                <option value="1" <?php if($role_access==1):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('xin_role_all_menu');?></option>
                <option value="2" <?php if($role_access==2):?> selected="selected" <?php endif;?>><?php echo $this->lang->line('xin_role_cmenu');?></option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <p><strong><?php echo $this->lang->line('xin_role_note_title');?></strong></p>
            <p><?php echo $this->lang->line('xin_role_note1');?></p>
            <p><?php echo $this->lang->line('xin_role_note2');?></p>
            </div>
          </div>
      </div>
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="resources"><?php echo $this->lang->line('xin_role_resource');?></label>
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
    <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_close'))); ?> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_update'))); ?> 
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
 $(document).ready(function(){
		
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		 Ladda.bind('button[type=submit]');

		/* Edit data */
		$("#edit_role").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=role&form="+action,
				cache: false,
				success: function (JSON) {
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
								url : "<?php echo site_url("admin/roles/role_list") ?>",
								type : 'GET'
							},
							dom: 'lBfrtip',
							"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
							"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
							}
						});
						xin_table.api().ajax.reload(function(){ 
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
	text: "<?php echo $this->lang->line('let_staff');?>",  
	add_info: "", 
	check: "<?php if(isset($_GET['role_id'])) { if(in_array('103',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
	value: "103",  
	items: [
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('dashboard_employees');?>",  
		add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", 
		value: "13", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('13',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_enable');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
			value: "13", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('13',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_add');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "201", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('201',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_edit');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_edit');?>", 
			value: "202", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('202',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_delete');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_delete');?>", 
			value: "203", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('203',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_view_company_emp_title');?>",  
			add_info: "<?php echo $this->lang->line('xin_view_company_emp_title');?>", 
			value: "372", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('372',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_view_location_emp_title');?>",  
			add_info: "<?php echo $this->lang->line('xin_view_location_emp_title');?>", 
			value: "373", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('373',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
		]
	},
	
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_hotspot');?>",  
		add_info: "<?php echo $this->lang->line('xin_hotspot');?>", 
		value: "393",  
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_enable');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
			value: "393",
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('393',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_add');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "394",
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('394',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		}
		]
	},

// MY PROFILE
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('header_my_profile');?>",  
		add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", 
		value: "132",  
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_enable');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
			value: "132",
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('132',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_edit');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_edit');?>", 
			value: "133",
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('133',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
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
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_enable');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
			value: "134",
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('134',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		}
		]
	},

// MY PKWT
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('header_my_contract');?>",  
		add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", 
		value: "137",  
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_enable');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
			value: "137",
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('137',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_edit');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_edit');?>", 
			value: "138",
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('138',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		}
		]
	},


// MY ESLIP
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_eslip');?>",  
		add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", 
		value: "140",  
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_enable');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
			value: "140",
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('140',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		}
		]
	},


// BPJS KARTU
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_manage_employees_bpjs');?>",  
		add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", 
		value: "502",  
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_enable');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
			value: "502",
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('140',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		}
		]
	},


// IMPORT NEW EMPLOYEE
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_import_new_employee');?>",  
		add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", 
		value: "109",  
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_enable');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
			value: "109",
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('109',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_edit');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_edit');?>", 
			value: "136",
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('136',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		}
		]
	},

	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('hr_staff_dashboard_title');?>",  
		add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
		value: "422", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('422',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_set_employees_salary');?>",  
		add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
		value: "351", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('351',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
	},
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_download_profile_title');?>",  
		add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
		value: "421", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('421',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
	},

	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('left_employees_directory');?>",  
		add_info: "<?php echo $this->lang->line('xin_view');?>", value: "88", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('88',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
	},
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('left_employees_exit');?>",  
		add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "23", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('23',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
		items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "23", check: "<?php if(isset($_GET['role_id'])) { if(in_array('23',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "204", check: "<?php if(isset($_GET['role_id'])) { if(in_array('204',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_edit');?>", value: "205", check: "<?php if(isset($_GET['role_id'])) { if(in_array('205',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "206", check: "<?php if(isset($_GET['role_id'])) { if(in_array('206',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_employees_exit').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "231", check: "<?php if(isset($_GET['role_id'])) { if(in_array('231',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
	]},

	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_paklaring');?>",  
		add_info: "<?php echo $this->lang->line('xin_view');?>", 
		value: "501",
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('501',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
	},
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('left_employees_last_login');?>",  
		add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
		value: "22", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('22',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
	},

	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_lock_user');?>",  
		add_info: "<?php echo $this->lang->line('xin_lock_user');?>", 
		value: "465",
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('465',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
	},
	]},



//MENU CALL CENTER CS
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_menu_cs');?>",  
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('479',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		add_info: "<?php echo $this->lang->line('xin_menu_cs');?>", 
		value: "479",
		items: 
		[
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_whatsapp_blast');?>",  
			add_info: "Wa.me", 
			value: "480", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('480',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		}
		]
	},

//PKWT
	{
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_pkwt');?>", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('34',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		add_info: "", 
		value:"34", 
		items: [
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_pkwt_list');?>",  
				add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
				value: "34", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('34',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
				items: [
					{ 
						id: "", 
						class: "role-checkbox-modal custom-control-input", 
						text: "<?php echo $this->lang->line('xin_role_enable');?>",  
						add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
						value: "34", 
						check: "<?php if(isset($_GET['role_id'])) { if(in_array('34',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
					},

					{ 
						id: "", 
						class: "role-checkbox-modal custom-control-input", 
						text: "<?php echo $this->lang->line('xin_role_add');?>",  
						add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
						value: "35", 
						check: "<?php if(isset($_GET['role_id'])) { if(in_array('35',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
					},

					{ 
						id: "", 
						class: "role-checkbox-modal custom-control-input", 
						text: "<?php echo $this->lang->line('xin_role_edit');?>",  
						add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
						value: "38", 
						check: "<?php if(isset($_GET['role_id'])) { if(in_array('38',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
					},

					{ 
						id: "", 
						class: "role-checkbox-modal custom-control-input", 
						text: "<?php echo $this->lang->line('xin_role_delete');?>",  
						add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
						value: "39", 
						check: "<?php if(isset($_GET['role_id'])) { if(in_array('39',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
					}
				]

			},

			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_pkwt_expired');?>",  
				add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
				value: "58", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
				items: [
					{ 
						id: "", 
						class: "role-checkbox-modal custom-control-input", 
						text: "<?php echo $this->lang->line('xin_role_enable');?>",  
						add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
						value: "58", 
						check: "<?php if(isset($_GET['role_id'])) { if(in_array('58',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
					},
					{ 
						id: "", 
						class: "role-checkbox-modal custom-control-input", 
						text: "<?php echo $this->lang->line('xin_role_add');?>",  
						add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
						value: "58", 
						check: "<?php if(isset($_GET['role_id'])) { if(in_array('58',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
					},
					{ 
						id: "", 
						class: "role-checkbox-modal custom-control-input", 
						text: "<?php echo $this->lang->line('xin_role_edit');?>",  
						add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
						value: "58", 
						check: "<?php if(isset($_GET['role_id'])) { if(in_array('58',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
					},
					{ 
						id: "", 
						class: "role-checkbox-modal custom-control-input", 
						text: "<?php echo $this->lang->line('xin_role_delete');?>",  
						add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
						value: "58", 
						check: "<?php if(isset($_GET['role_id'])) { if(in_array('58',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
					}
				]

			},

			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_pkwt_approval');?>",  
				add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
				value: "67", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('67',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
				items: [
					{ 
						id: "", 
						class: "role-checkbox-modal custom-control-input", 
						text: "<?php echo $this->lang->line('xin_role_enable');?>",  
						add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
						value: "67", 
						check: "<?php if(isset($_GET['role_id'])) { if(in_array('67',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
					},
					{ 
						id: "", 
						class: "role-checkbox-modal custom-control-input", 
						text: "<?php echo $this->lang->line('xin_role_edit');?>",  
						add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
						value: "68", 
						check: "<?php if(isset($_GET['role_id'])) { if(in_array('68',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
					}
				]

			},

		]
	}, // sub 1 end
	

//USER MOBILE
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_user_mobile');?>",  
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('59',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		add_info: "<?php echo $this->lang->line('xin_create_edit_view_delete');?>", 
		value: "59",
		items: 
		[
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_enable');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
			value: "59", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('59',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_add');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "64", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('64',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_edit');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "65", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('65',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_delete');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "66", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('66',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		}
		]
	},

// CUSTOMER
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_customer');?>",  
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('69',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		add_info: "<?php echo $this->lang->line('xin_create_edit_view_delete');?>", 
		value: "69",
		items: 
		[
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_enable');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
			value: "69", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('69',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_view_menu');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "70", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('70',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_add');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "100", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('100',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_edit');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "101", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('101',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_delete');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "102", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('102',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		}
		]
	},

//USER CALLPLAN
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_callplan');?>",  
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('105',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		add_info: "<?php echo $this->lang->line('xin_create_edit_view_delete');?>", 
		value: "105",
		items: 
		[
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_enable');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
			value: "105", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('105',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_add');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "123", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('123',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_edit');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "124", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('124',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_delete');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "125", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('125',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		}
		]
	},


//MANAGE KARYAWAN
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_manage_employees');?>",  
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('467',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		add_info: "<?php echo $this->lang->line('xin_create_edit_view_delete');?>", 
		value: "467",
		items: 
		[

			// REQUEST EMP
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_request_employee');?>",  
				add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", 
				value: "327",  
				items: [
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_enable');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
					value: "327",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('327',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_request');?>",  
					add_info: "<?php echo $this->lang->line('xin_request');?>", 
					value: "337",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('337',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "",
					class: "role-checkbox-modal custom-control-input", 
					text: "Cancel REQ",
					add_info: "<?php echo $this->lang->line('xin_request');?>",
					value: "338",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('338',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "Approve Level #1",  
					add_info: "", 
					value: "374",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('374',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "Approve Level #2",  
					add_info: "", 
					value: "375",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('375',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "Approve HRD",  
					add_info: "", 
					value: "378",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('378',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "Release PKWT",  
					add_info: "", 
					value: "382",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('382',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				}
				]
			},
			// REQUEST PKWT
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_request_pkwt');?>",  
				add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", 
				value: "376",  
				items: [
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_enable');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
					value: "376",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('376',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "Cancel PKWT",  
					add_info: "<?php echo $this->lang->line('xin_request');?>", 
					value: "379",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('379',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_request');?>",  
					add_info: "<?php echo $this->lang->line('xin_request');?>", 
					value: "377",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('377',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_request_employee_approvenae');?>",  
					add_info: "#", 
					value: "503",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('503',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_request_employee_approvenom');?>",  
					add_info: "#", 
					value: "504",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('504',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_request_employee_approvehrd');?>",  
					add_info: "#", 
					value: "505",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('505',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				}
				]
			},

			// REQUEST TKHL
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "Request TKHL",  
				add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", 
				value: "312",  
				items: [
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_enable');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
					value: "312",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('312',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "Cancel PKWT",  
					add_info: "<?php echo $this->lang->line('xin_request');?>", 
					value: "312",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('312',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_request');?>",  
					add_info: "<?php echo $this->lang->line('xin_request');?>", 
					value: "312",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('312',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_request_employee_approvenae');?>",  
					add_info: "#", 
					value: "312",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('312',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_request_employee_approvenom');?>",  
					add_info: "#", 
					value: "312",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('312',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_request_employee_approvehrd');?>",  
					add_info: "#", 
					value: "312",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('312',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				}
				]
			},

			// RESIGN EMP
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('left_resignations');?>",  
				add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", 
				value: "490",  
				items: [
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_enable');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
					value: "490",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('490',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_request');?>",  
					add_info: "<?php echo $this->lang->line('xin_request');?>", 
					value: "491",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('491',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_request_employee_approvenae');?>",  
					add_info: "#", 
					value: "492",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('492',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_request_employee_approvenom');?>",  
					add_info: "#", 
					value: "493",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('493',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_request_employee_approvehrd');?>",  
					add_info: "#", 
					value: "494",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('494',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_request_resign_cancelled');?>",  
					add_info: "#", 
					value: "506",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('506',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				}
				]
			},
			// DATABASE
			{
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('left_db_employee');?>",  
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('470',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
				add_info: "<?php echo $this->lang->line('xin_create_edit_view_delete');?>", 
				value: "470",
				items: 
				[
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_enable');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
					value: "470", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('470',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_e_details_edit_profile');?>",  
					add_info: "<?php echo $this->lang->line('xin_e_details_edit_profile');?>", 
					value: "471", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('471',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_e_details_edit_grade');?>",  
					add_info: "<?php echo $this->lang->line('xin_e_details_edit_grade');?>", 
					value: "473", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('473',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_manage_employees_bpjs');?>",  
					add_info: "<?php echo $this->lang->line('xin_manage_employees_bpjs');?>", 
					value: "472", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('472',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_manage_employees_rekening');?>",  
					add_info: "<?php echo $this->lang->line('xin_manage_employees_rekening');?>", 
					value: "474", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('474',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_manage_employees_blacklist');?>",  
					add_info: "<?php echo $this->lang->line('xin_manage_employees_blacklist');?>", 
					value: "475", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('475',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				}
				]
			},


		]
	},


//KARYAWAN BPJS EMPLOYEE
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_emp_bpjs');?>",  
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('476',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		add_info: "<?php echo $this->lang->line('xin_create_edit_view_delete');?>", 
		value: "476",
		items: 
		[
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_enable');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
			value: "476", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('476',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},

		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "Saltab",  
			add_info: "saltab", 
			value: "477", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('477',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		}
		
		]
	},


//KARYAWAN AKSES
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_hr_report_employees');?>",  
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('117',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		add_info: "<?php echo $this->lang->line('xin_create_edit_view_delete');?>", 
		value: "117",
		items: 
		[
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_inhouse');?>",  
			add_info: "<?php echo $this->lang->line('xin_inhouse');?>", 
			value: "139", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('139',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},

		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_project');?>",  
			add_info: "<?php echo $this->lang->line('xin_project');?>", 
			value: "117", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('117',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		}
		]
	},


//IMPORT MODUL
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_import_modul');?>",  
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('126',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		add_info: "", 
		value: "126",
		items: 
		[
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_import_excl_employee');?>",  
			add_info: "", 
			value: "127", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('127',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_import_excl_pkwt');?>",  
			add_info: "", 
			value: "128", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('128',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_import_excl_ratecard');?>",  
			add_info: "", 
			value: "232", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('232',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},

		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "Import Saltab to BPJS",  
			add_info: "", 
			value: "481", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('481',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},

		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_import_excl_eslip');?>",  
			add_info: "", 
			value: "469", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('469',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		}
		]
	},


	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_document_id');?>",  
		add_info: "", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('486',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		value: "486",  
		items: [

		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_surat_keterangan_kerja');?>",  
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('486',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
			add_info: "<?php echo $this->lang->line('xin_create_edit_view_delete');?>", 
			value: "486",
			items: 
			[
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_enable');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
				value: "487", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('487',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_add');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "488", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('488',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_edit');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "488", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('488',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_delete');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "489", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('489',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			}
			]
		},

		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_sk_report');?>",  
			add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
			value: "499", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('499',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
			items: [
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_enable');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
				value: "499", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('499',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_delete');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "500", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('500',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			}
			]
		}
	]},
	
// ORGANIZATION
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('left_organization');?>", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('2',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		add_info: "", 
		value:"2", 
		items: [
			// department
			{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('left_department');?>",  
			add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
			value: "3", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
			items: [
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_enable');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
				value: "3", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('3',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_add');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "240", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('240',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_edit');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "241", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('241',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_delete');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "242", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('242',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			}]
		},
			// designation
			{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('left_designation');?>",  
			add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
			value: "4", check: "<?php if(isset($_GET['role_id'])) { if(in_array('4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
			items: [
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_enable');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
				value: "4", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('4',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_add');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "243", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('243',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_edit');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "244", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('244',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_delete');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "245", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('245',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_designation').'</small>';?>",  
				add_info: "<?php echo $this->lang->line('xin_role_view');?>", 
				value: "249",
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('249',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			}]
		},
			// project
			{
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('left_projects');?>",  
				add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
				value: "44", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('44',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
				items: [
					{ 
						id: "", 
						class: "role-checkbox-modal custom-control-input", 
						text: "<?php echo $this->lang->line('xin_role_enable');?>",  
						add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
						value: "44", 
						check: "<?php if(isset($_GET['role_id'])) { if(in_array('44',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
					},
					{ 
						id: "", 
						class: "role-checkbox-modal custom-control-input", 
						text: "<?php echo $this->lang->line('xin_role_add');?>",  
						add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
						value: "45", 
						check: "<?php if(isset($_GET['role_id'])) { if(in_array('45',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
					},
					{ 
						id: "", 
						class: "role-checkbox-modal custom-control-input", 
						text: "<?php echo $this->lang->line('xin_role_edit');?>", 
						add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
						value: "47", 
						check: "<?php if(isset($_GET['role_id'])) { if(in_array('47',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
					},
					{ 
						id: "", 
						class: "role-checkbox-modal custom-control-input", 
						text: "<?php echo $this->lang->line('xin_role_delete');?>", 
						add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
						value: "90", 
						check: "<?php if(isset($_GET['role_id'])) { if(in_array('90',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
					},
				]
			},
			// Sub-project
			{
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "Sub Project",  
				add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
				value: "130", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('130',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
				items: [
					{ 
						id: "", 
						class: "role-checkbox-modal custom-control-input", 
						text: "<?php echo $this->lang->line('xin_role_enable');?>",  
						add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
						value: "130", 
						check: "<?php if(isset($_GET['role_id'])) { if(in_array('130',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
					},
					{ 
						id: "", 
						class: "role-checkbox-modal custom-control-input", 
						text: "<?php echo $this->lang->line('xin_role_add');?>",  
						add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
						value: "130", 
						check: "<?php if(isset($_GET['role_id'])) { if(in_array('130',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
					},
					{ 
						id: "", 
						class: "role-checkbox-modal custom-control-input", 
						text: "<?php echo $this->lang->line('xin_role_edit');?>", 
						add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
						value: "131", 
						check: "<?php if(isset($_GET['role_id'])) { if(in_array('131',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
					},
					{ 
						id: "", 
						class: "role-checkbox-modal custom-control-input", 
						text: "<?php echo $this->lang->line('xin_role_delete');?>", 
						add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
						value: "131", 
						check: "<?php if(isset($_GET['role_id'])) { if(in_array('131',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
					},
				]
			},
			// akses project
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_akses_project');?>",  
				add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
				value: "207", check: "<?php if(isset($_GET['role_id'])) { if(in_array('207',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
				items: [
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_enable');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
					value: "207", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('207',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_add');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
					value: "208", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('208',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_delete');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
					value: "209", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('209',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				}]
			},
			// company
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('left_company');?>",  
				add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
				value: "5", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
				items: [
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_enable');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
					value: "5", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('5',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_add');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
					value: "246", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('246',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_edit');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
					value: "247", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('247',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_delete');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
					value: "248", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('248',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				]
			},
			// location
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('left_location');?>",  
				add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
				value: "6", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('6',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
				items: [
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_enable');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
					value: "6", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('6',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_add');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
					value: "250", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('250',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_edit');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
					value: "251", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('251',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_delete');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
					value: "252", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('252',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				]
			},
			// daftar esign
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_esign_register');?>",  
				add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
				value: "478", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('478',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
				items: [
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_enable');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
					value: "478", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('478',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				}]
			},
	]}, // sub 1 end
	
// ASSETS
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_assets');?>",  add_info: "", check: "<?php if(isset($_GET['role_id'])) { if(in_array('24',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", value: "24",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_assets');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "25", check: "<?php if(isset($_GET['role_id'])) { if(in_array('25',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "25", check: "<?php if(isset($_GET['role_id'])) { if(in_array('25',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "262", check: "<?php if(isset($_GET['role_id'])) { if(in_array('262',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "263", check: "<?php if(isset($_GET['role_id'])) { if(in_array('263',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "264", check: "<?php if(isset($_GET['role_id'])) { if(in_array('264',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('xin_assets').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "265", check: "<?php if(isset($_GET['role_id'])) { if(in_array('265',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_category');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "26", check: "<?php if(isset($_GET['role_id'])) { if(in_array('26',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "26", check: "<?php if(isset($_GET['role_id'])) { if(in_array('26',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "266", check: "<?php if(isset($_GET['role_id'])) { if(in_array('266',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "267", check: "<?php if(isset($_GET['role_id'])) { if(in_array('267',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "268", check: "<?php if(isset($_GET['role_id'])) { if(in_array('268',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
	]},
	]},
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_hr_events_meetings');?>",  
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('97',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		add_info: "", 
		value: "97",  
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_hr_events');?>",  
			add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", 
			value: "98", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('98',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
			items: [
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_enable');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
				value: "98", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('98',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_add');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "269", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('269',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_edit');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "270", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('270',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_delete');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "271", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('271',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('xin_hr_events').'</small>';?>",  
				add_info: "<?php echo $this->lang->line('xin_role_view');?>", 
				value: "272", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('272',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			}
			]
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_hr_meetings');?>",  
			add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", 
			value: "99", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('99',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
			items: [
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_enable');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
				value: "99", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('99',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_add');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "273", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('273',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "274", check: "<?php if(isset($_GET['role_id'])) { if(in_array('274',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "275", check: "<?php if(isset($_GET['role_id'])) { if(in_array('275',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('xin_hr_meetings').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "276", check: "<?php if(isset($_GET['role_id'])) { if(in_array('276',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
	]},
	]},

	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('left_timesheet');?>",  
		add_info: "", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('27',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		value: "27",  
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('left_attendance');?>",  
			add_info: "<?php echo $this->lang->line('xin_view');?>", 
			value: "28", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('28',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
			items: [
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_enable');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
				value: "28", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('28',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_timesheet').'</small>';?>",  
				add_info: "<?php echo $this->lang->line('xin_role_view');?>", 
				value: "397", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('397',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			}
			]
		},

		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_month_timesheet_title');?>",  
			add_info: "<?php echo $this->lang->line('xin_view');?>", 
			value: "10", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('10',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
			items: [
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_enable');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
					value: "10", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('10',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('xin_month_timesheet_title').'</small>';?>",  
					add_info: "<?php echo $this->lang->line('xin_role_view');?>", 
					value: "253",
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('253',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
			]
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_attendance_timecalendar');?>",  
			add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", 
			value: "261",
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('261',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('left_date_wise_attendance');?>",  
			add_info: "<?php echo $this->lang->line('xin_view');?>", 
			value: "29", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('29',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
			items: [
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_enable');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
					value: "29", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('29',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_date_wise_attendance').'</small>';?>",  
					add_info: "<?php echo $this->lang->line('xin_role_view');?>", 
					value: "381", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('381',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
			]
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('left_update_attendance');?>",  
			add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", 
			value: "30", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('30',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
			items: [
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_enable');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
					value: "30", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('30',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_add');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
					value: "277", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('277',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_edit');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
					value: "278", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('278',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo $this->lang->line('xin_role_delete');?>",  
					add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
					value: "279", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('279',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
				{ 
					id: "", 
					class: "role-checkbox-modal custom-control-input", 
					text: "<?php echo '<small>'.$this->lang->line('xin_role_upd_company_attendance').'</small>';?>",  
					add_info: "<?php echo $this->lang->line('xin_role_view');?>", 
					value: "310", 
					check: "<?php if(isset($_GET['role_id'])) { if(in_array('310',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
				},
			]
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_overtime_request');?>",  
			add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", 
			value: "401", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('401',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
			items: [
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_enable');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
				value: "401", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('401',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_edit');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "402", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('402',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_delete');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "403", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('403',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
		]},




	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_leave_status');?>",  add_info: "<?php echo $this->lang->line('xin_leave_status');?>", value: "31", check: "<?php if(isset($_GET['role_id'])) { if(in_array('31',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_office_shifts');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "7", check: "<?php if(isset($_GET['role_id'])) { if(in_array('7',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "7", check: "<?php if(isset($_GET['role_id'])) { if(in_array('7',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "280", check: "<?php if(isset($_GET['role_id'])) { if(in_array('280',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "281", check: "<?php if(isset($_GET['role_id'])) { if(in_array('281',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "282", check: "<?php if(isset($_GET['role_id'])) { if(in_array('282',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_change_default');?>",  add_info: "<?php echo $this->lang->line('xin_role_change_default');?>", value: "2822", check: "<?php if(isset($_GET['role_id'])) { if(in_array('2822',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_office_shifts').'</small>';?>",  
		add_info: "<?php echo $this->lang->line('xin_role_view');?>", 
		value: "311", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('311',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
	}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_holidays');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "8", check: "<?php if(isset($_GET['role_id'])) { if(in_array('8',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "8", check: "<?php if(isset($_GET['role_id'])) { if(in_array('8',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "283", check: "<?php if(isset($_GET['role_id'])) { if(in_array('283',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "284", check: "<?php if(isset($_GET['role_id'])) { if(in_array('284',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "285", check: "<?php if(isset($_GET['role_id'])) { if(in_array('285',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_leaves');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "46", check: "<?php if(isset($_GET['role_id'])) { if(in_array('46',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "46", check: "<?php if(isset($_GET['role_id'])) { if(in_array('46',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "287", check: "<?php if(isset($_GET['role_id'])) { if(in_array('287',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "288", check: "<?php if(isset($_GET['role_id'])) { if(in_array('288',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "289", check: "<?php if(isset($_GET['role_id'])) { if(in_array('289',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_leaves').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "290", check: "<?php if(isset($_GET['role_id'])) { if(in_array('290',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	]},
	]},
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('left_recruitment');?>",  
		add_info: "", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('48',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		value: "48",  
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('left_job_posts');?>",  
			add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
			value: "49", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('49',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
			items: [
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_enable');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
				value: "49", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('49',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_add');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>",
				value: "291", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('291',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "292", check: "<?php if(isset($_GET['role_id'])) { if(in_array('292',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "293", check: "<?php if(isset($_GET['role_id'])) { if(in_array('293',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_jobs_listing');?> <small><?php echo $this->lang->line('left_frontend');?></small>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "50", check: "<?php if(isset($_GET['role_id'])) { if(in_array('50',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_job_candidates');?>",  add_info: "<?php echo $this->lang->line('xin_update_status_delete');?>", value: "51", check: "<?php if(isset($_GET['role_id'])) { if(in_array('51',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "51", check: "<?php if(isset($_GET['role_id'])) { if(in_array('51',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_dwn_resume');?>",  add_info: "<?php echo $this->lang->line('xin_role_dwn_resume');?>", value: "294", check: "<?php if(isset($_GET['role_id'])) { if(in_array('294',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_delete');?>", value: "295", check: "<?php if(isset($_GET['role_id'])) { if(in_array('295',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_view_own');?>",  add_info: "<?php echo $this->lang->line('xin_role_view_own');?>", value: "387", check: "<?php if(isset($_GET['role_id'])) { if(in_array('387',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
	]},
	
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_jobs_employer');?>",  
				add_info: "<?php echo $this->lang->line('xin_view');?>", 
				value: "52",
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('52',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_jobs_cms_pages');?>",  
				add_info: "<?php echo $this->lang->line('xin_view');?>", 
				value: "296",
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('296',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
		]
	},
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('left_payroll');?>",  
		add_info: "", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('32',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		value: "32",  
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('left_generate_payslip');?>",  
			add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", 
			value: "36", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('36',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
			items: [
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_enable');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
				value: "36",
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('36',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_delete');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "313",
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('313',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo '<small>'.$this->lang->line('xin_role_generate_company_payslips').'</small>';?>",  
				add_info: "<?php echo $this->lang->line('xin_role_view');?>", 
				value: "314",
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('314',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			}]
		},
	/**/
		{
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_payroll_verifier_title');?>",  
			add_info: "<?php echo $this->lang->line('xin_payroll_verifier_title');?>", 
			value: "404", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('404',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_payroll_approver_title');?>",  
			add_info: "<?php echo $this->lang->line('xin_payroll_approver_title');?>", 
			value: "405", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('405',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_advance_salary');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "467", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('467',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_advance_salary_report');?>",  
			add_info: "<?php echo $this->lang->line('xin_view');?>", 
			value: "468", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('468',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
	]},
	
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('left_performance');?>",  
		add_info: "", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('40',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		value: "40",  
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('left_performance_indicator');?>",  
			add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", 
			value: "41", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('41',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
			items: [
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_enable');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
				value: "41", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('41',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_add');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "298", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('298',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_edit');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "299", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('299',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_delete');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "300", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('300',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo '<small>'.$this->lang->line('xin_role_view').'<br>'.$this->lang->line('left_performance_indicator').'</small>';?>",  
				add_info: "<?php echo $this->lang->line('xin_role_view');?>", 
				value: "301", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('301',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_performance_appraisal');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "42",check: "<?php if(isset($_GET['role_id'])) { if(in_array('42',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "42", check: "<?php if(isset($_GET['role_id'])) { if(in_array('42',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "302", check: "<?php if(isset($_GET['role_id'])) { if(in_array('302',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "303", check: "<?php if(isset($_GET['role_id'])) { if(in_array('303',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "304", check: "<?php if(isset($_GET['role_id'])) { if(in_array('304',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').'<br>'.$this->lang->line('left_performance_appraisal').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "305", check: "<?php if(isset($_GET['role_id'])) { if(in_array('305',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	]},
	]},
	
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('left_tickets');?>",  
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('43',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		add_info: "<?php echo $this->lang->line('xin_create_edit_view_delete');?>", 
		value: "43",items: [
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_enable');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
				value: "43", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('43',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_add');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "306", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('306',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_edit');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "307", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('307',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_delete');?>",  
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "308", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('308',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_tickets').'</small>';?>",  
				add_info: "<?php echo $this->lang->line('xin_role_view');?>", 
				value: "309", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('309',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			}
		]
	}
	
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
//
{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_training');?>",  add_info: "", value: "53", check: "<?php if(isset($_GET['role_id'])) { if(in_array('53',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", items: [
{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_training_list');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('54',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "54",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "54", check: "<?php if(isset($_GET['role_id'])) { if(in_array('54',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "341", check: "<?php if(isset($_GET['role_id'])) { if(in_array('341',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "342", check: "<?php if(isset($_GET['role_id'])) { if(in_array('342',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "343", check: "<?php if(isset($_GET['role_id'])) { if(in_array('343',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_training').'</small>';?>",  add_info: "<?php echo $this->lang->line('xin_role_view');?>", value: "344", check: "<?php if(isset($_GET['role_id'])) { if(in_array('344',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	]},
{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_training_type');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('55',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "55",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "55", check: "<?php if(isset($_GET['role_id'])) { if(in_array('55',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "345", check: "<?php if(isset($_GET['role_id'])) { if(in_array('345',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "346", check: "<?php if(isset($_GET['role_id'])) { if(in_array('346',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "347", check: "<?php if(isset($_GET['role_id'])) { if(in_array('347',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
	]},
{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_trainers_list');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('56',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "56",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "56", check: "<?php if(isset($_GET['role_id'])) { if(in_array('56',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "348", check: "<?php if(isset($_GET['role_id'])) { if(in_array('348',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "349", check: "<?php if(isset($_GET['role_id'])) { if(in_array('349',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "350", check: "<?php if(isset($_GET['role_id'])) { if(in_array('350',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
	]},
]},
{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_system');?>",  add_info: "", check: "<?php if(isset($_GET['role_id'])) { if(in_array('57',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",value: "57",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_settings');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "60", check: "<?php if(isset($_GET['role_id'])) { if(in_array('60',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_constants');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "61", check: "<?php if(isset($_GET['role_id'])) { if(in_array('61',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_db_backup');?>",  add_info: "<?php echo $this->lang->line('xin_create_delete_download');?>", value: "62", check: "<?php if(isset($_GET['role_id'])) { if(in_array('62',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_email_templates');?>",  add_info: "<?php echo $this->lang->line('xin_update');?>", value: "63", check: "<?php if(isset($_GET['role_id'])) { if(in_array('63',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_setup_modules');?>",  add_info: "<?php echo $this->lang->line('xin_update');?>", value: "93", check: "<?php if(isset($_GET['role_id'])) { if(in_array('93',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_acc_payment_gateway');?>",  
		add_info: "<?php echo $this->lang->line('xin_update');?>", 
		value: "118", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('118',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
	},
	
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_system');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "297",check: "<?php if(isset($_GET['role_id'])) { if(in_array('297',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_general');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "431",check: "<?php if(isset($_GET['role_id'])) { if(in_array('431',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_employee_role');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "432",check: "<?php if(isset($_GET['role_id'])) { if(in_array('432',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_payroll');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "433",check: "<?php if(isset($_GET['role_id'])) { if(in_array('433',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_recruitment');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "434",check: "<?php if(isset($_GET['role_id'])) { if(in_array('434',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_performance');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "435",check: "<?php if(isset($_GET['role_id'])) { if(in_array('435',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_system_logos');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "436",check: "<?php if(isset($_GET['role_id'])) { if(in_array('436',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_email_notifications');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "437",check: "<?php if(isset($_GET['role_id'])) { if(in_array('437',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_page_layouts');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "438",check: "<?php if(isset($_GET['role_id'])) { if(in_array('438',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_notification_position');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "439",check: "<?php if(isset($_GET['role_id'])) { if(in_array('439',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_files_manager');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "440",check: "<?php if(isset($_GET['role_id'])) { if(in_array('440',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_org_chart_title');?>",  add_info: "<?php echo $this->lang->line('xin_view_update');?>", value: "441",check: "<?php if(isset($_GET['role_id'])) { if(in_array('441',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_manage_top_menu');?>",  
		add_info: "<?php echo $this->lang->line('xin_view_update');?>", 
		value: "466",
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('466',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
	},
	
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('left_constants');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "447",check: "<?php if(isset($_GET['role_id'])) { if(in_array('447',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_e_details_contract_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "448",check: "<?php if(isset($_GET['role_id'])) { if(in_array('448',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_e_details_qualification');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "449",check: "<?php if(isset($_GET['role_id'])) { if(in_array('449',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_e_details_dtype');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "450",check: "<?php if(isset($_GET['role_id'])) { if(in_array('450',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_award_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "451",check: "<?php if(isset($_GET['role_id'])) { if(in_array('451',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_ethnicity_type_title');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "452",check: "<?php if(isset($_GET['role_id'])) { if(in_array('452',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_leave_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "453",check: "<?php if(isset($_GET['role_id'])) { if(in_array('453',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_warning_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "454",check: "<?php if(isset($_GET['role_id'])) { if(in_array('454',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_expense_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "455",check: "<?php if(isset($_GET['role_id'])) { if(in_array('455',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_income_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "456",check: "<?php if(isset($_GET['role_id'])) { if(in_array('456',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_job_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "457",check: "<?php if(isset($_GET['role_id'])) { if(in_array('457',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_rec_job_categories');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "458",check: "<?php if(isset($_GET['role_id'])) { if(in_array('458',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_currency_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "459",check: "<?php if(isset($_GET['role_id'])) { if(in_array('459',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_company_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "460",check: "<?php if(isset($_GET['role_id'])) { if(in_array('460',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_security_level');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "461",check: "<?php if(isset($_GET['role_id'])) { if(in_array('461',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_termination_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "462",check: "<?php if(isset($_GET['role_id'])) { if(in_array('462',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_employee_exit_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "463",check: "<?php if(isset($_GET['role_id'])) { if(in_array('463',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_travel_arrangement_type');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "464",check: "<?php if(isset($_GET['role_id'])) { if(in_array('464',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	]},
	
{ id: "", class: "role-checkbox-modal custom-control-input",text: "<?php echo $this->lang->line('xin_acc_accounts');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('71',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "",value: "71",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('hr_accounting_dashboard_title');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "286",check: "<?php if(isset($_GET['role_id'])) { if(in_array('286',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_account_list');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('72',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "72",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "72", check: "<?php if(isset($_GET['role_id'])) { if(in_array('72',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "352", check: "<?php if(isset($_GET['role_id'])) { if(in_array('352',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "353", check: "<?php if(isset($_GET['role_id'])) { if(in_array('353',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "354", check: "<?php if(isset($_GET['role_id'])) { if(in_array('354',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_account_balances');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('73',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "73",},
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input",text: "<?php echo $this->lang->line('xin_acc_transactions');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('74',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "",value: "74",  items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_deposit');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('75',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "75",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "75", check: "<?php if(isset($_GET['role_id'])) { if(in_array('75',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "355", check: "<?php if(isset($_GET['role_id'])) { if(in_array('355',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "356", check: "<?php if(isset($_GET['role_id'])) { if(in_array('356',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "357", check: "<?php if(isset($_GET['role_id'])) { if(in_array('357',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_expense');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('76',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "76",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "76", check: "<?php if(isset($_GET['role_id'])) { if(in_array('76',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "358", check: "<?php if(isset($_GET['role_id'])) { if(in_array('358',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "359", check: "<?php if(isset($_GET['role_id'])) { if(in_array('359',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "360", check: "<?php if(isset($_GET['role_id'])) { if(in_array('360',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_transfer');?>", check: "<?php if(isset($_GET['role_id'])) { if(in_array('77',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "77",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "77", check: "<?php if(isset($_GET['role_id'])) { if(in_array('77',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "361", check: "<?php if(isset($_GET['role_id'])) { if(in_array('361',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "362", check: "<?php if(isset($_GET['role_id'])) { if(in_array('362',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "363", check: "<?php if(isset($_GET['role_id'])) { if(in_array('363',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
	]},
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_acc_view_transactions');?>", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('78',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		add_info: "<?php echo $this->lang->line('xin_view');?>", 
		value: "78",
	},
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_payslip_history');?>",  
		add_info: "<?php echo $this->lang->line('xin_view_payslip');?>", 
		value: "37", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('37',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_enable');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
			value: "37", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('37',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo '<small>'.$this->lang->line('xin_role_view').' '.$this->lang->line('left_payment_history').'</small>';?>",  
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "391", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('391',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
	]},
	]},
	
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input",
		text: "<?php echo $this->lang->line('xin_acc_payees_payers');?>", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('79',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		add_info: "",
		value: "79",  
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_acc_payees');?>", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('80',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
			add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
			value: "80",
			items: [
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_enable');?>", 
				add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
				value: "80", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('80',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_add');?>", 
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "364", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('364',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_edit');?>", 
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "365", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('365',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			},
			{ 
				id: "", 
				class: "role-checkbox-modal custom-control-input", 
				text: "<?php echo $this->lang->line('xin_role_delete');?>", 
				add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
				value: "366", 
				check: "<?php if(isset($_GET['role_id'])) { if(in_array('366',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
			}
	]},

	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_acc_payers');?>", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('81',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
		value: "81",
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_enable');?>",  
			add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
			value: "81", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('81',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_add');?>", 
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "367", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('367',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_edit');?>", 
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "368", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('368',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_delete');?>", 
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "369", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('369',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		}]
	},
]},
	
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input",
		text: "<?php echo $this->lang->line('xin_acc_accounts').' '.$this->lang->line('xin_acc_reports');?>", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('82',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		add_info: "",
		value: "82",  
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_acc_account_statement');?>", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('83',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
			add_info: "<?php echo $this->lang->line('xin_view');?>", 
			value: "83"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_acc_expense_reports');?>", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('84',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
			add_info: "<?php echo $this->lang->line('xin_view');?>", 
			value: "84",
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_acc_income_reports');?>", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('85',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
			add_info: "<?php echo $this->lang->line('xin_view');?>", 
			value: "85",
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_acc_transfer_report');?>", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('86',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",  
			add_info: "<?php echo $this->lang->line('xin_view');?>", 
			value: "86",
		},
	]},
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_quote_manager');?>",  
		add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
		value: "87", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('87',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		items: [
		{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_leads');?>", 
		add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
		value: "410", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('410',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_enable');?>", 
			add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
			value: "411", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('411',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_add');?>", 
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "412", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('412',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_edit');?>", 
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "413", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('413',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_delete');?>", 
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "414", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('414',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_view');?>", 
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "420", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('420',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
		},
	]},

	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_estimates');?>", 
		add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", 
		value: "415", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('415',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_enable');?>", 
			add_info: "<?php echo $this->lang->line('xin_role_enable');?>", 
			value: "416", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('416',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_create');?>", 
			add_info: "<?php echo $this->lang->line('xin_role_create');?>", 
			value: "417", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('417',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_edit');?>", 
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "418", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('418',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_role_delete');?>", 
			add_info: "<?php echo $this->lang->line('xin_role_add');?>", 
			value: "419", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('419',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",
		}
	]},

	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_invoices_title');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "121", check: "<?php if(isset($_GET['role_id'])) { if(in_array('121',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "121", check: "<?php if(isset($_GET['role_id'])) { if(in_array('121',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_create');?>",  add_info: "<?php echo $this->lang->line('xin_role_create');?>", value: "120", check: "<?php if(isset($_GET['role_id'])) { if(in_array('120',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_edit');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "328", check: "<?php if(isset($_GET['role_id'])) { if(in_array('328',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "329", check: "<?php if(isset($_GET['role_id'])) { if(in_array('329',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",}
	]},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_acc_invoice_payments');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_view_delete_role_info');?>", value: "330", check: "<?php if(isset($_GET['role_id'])) { if(in_array('330',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_invoice_calendar');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "426",check: "<?php if(isset($_GET['role_id'])) { if(in_array('426',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_quote_calendar');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "427",check: "<?php if(isset($_GET['role_id'])) { if(in_array('427',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_quoted_projects');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "428",check: "<?php if(isset($_GET['role_id'])) { if(in_array('428',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_estimate_leads');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "429",check: "<?php if(isset($_GET['role_id'])) { if(in_array('429',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_estimate_timelogs');?>",  add_info: "<?php echo $this->lang->line('xin_view');?>", value: "430",check: "<?php if(isset($_GET['role_id'])) { if(in_array('430',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	]},

	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_lang_settings');?>",  add_info: "<?php echo $this->lang->line('xin_add_edit_delete_role_info');?>", value: "89", check: "<?php if(isset($_GET['role_id'])) { if(in_array('89',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>",items: [
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_enable');?>",  add_info: "<?php echo $this->lang->line('xin_role_enable');?>", value: "89", check: "<?php if(isset($_GET['role_id'])) { if(in_array('89',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_add');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "370", check: "<?php if(isset($_GET['role_id'])) { if(in_array('370',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"},
	{ id: "", class: "role-checkbox-modal custom-control-input", text: "<?php echo $this->lang->line('xin_role_delete');?>",  add_info: "<?php echo $this->lang->line('xin_role_add');?>", value: "371", check: "<?php if(isset($_GET['role_id'])) { if(in_array('371',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"}
	]},
	
	
	
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_hr_calendar_title');?>",  
		add_info: "<?php echo $this->lang->line('xin_view');?>", 
		value: "95", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('95',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
	},
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_import_employees');?>",  
		add_info: "<?php echo $this->lang->line('xin_import_employees');?>", 
		value: "92", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('92',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
	},

	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('str_import_employees_active');?>",  
		add_info: "<?php echo $this->lang->line('str_import_employees_active');?>", 
		value: "33",
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('33',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
	},

	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('left_import_attendance');?>",  
		add_info: "<?php echo $this->lang->line('left_import_attendance');?>", 
		value: "443",
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('443',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
	},
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_import_leads');?>",  
		add_info: "<?php echo $this->lang->line('xin_import_leads');?>", 
		value: "444",
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('444',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
	},
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input", 
		text: "<?php echo $this->lang->line('xin_hr_chat_box');?>",  
		add_info: "<?php echo $this->lang->line('xin_hr_chat_box');?>", 
		value: "446",
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('446',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
	},
	{ 
		id: "", 
		class: "role-checkbox-modal custom-control-input",
		text: "<?php echo $this->lang->line('xin_hr_report_title');?>", 
		check: "<?php if(isset($_GET['role_id'])) { if(in_array('110',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>", 
		add_info: "",
		value: "110", 
		items: [
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_hr_reports_attendance_employee');?>",  
			add_info: "<?php echo $this->lang->line('xin_view');?>", 
			value: "112", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('112',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_hr_reports_projects');?>",  
			add_info: "<?php echo $this->lang->line('xin_view');?>", 
			value: "114", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('114',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		},
		{ 
			id: "", 
			class: "role-checkbox-modal custom-control-input", 
			text: "<?php echo $this->lang->line('xin_hr_report_user_roles');?>",  
			add_info: "<?php echo $this->lang->line('xin_view');?>", 
			value: "116", 
			check: "<?php if(isset($_GET['role_id'])) { if(in_array('116',$role_resources_ids)): echo 'checked'; else: echo ''; endif; }?>"
		}
	]},
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
$(document).ready(function(){
	$("#role_access_modal").change(function(){
		var sel_val = $(this).val();
		if(sel_val=='1') {
			$('.role-checkbox-modal').prop('checked', true);
		} else {
			$('.role-checkbox-modal').prop("checked", false);
		}
	});
});
</script>
<?php }
?>
