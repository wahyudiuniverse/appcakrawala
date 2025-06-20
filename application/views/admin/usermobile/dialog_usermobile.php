<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['department_id']) && $_GET['data']=='department'){
?>

<div class="modal-header"> 
	<?php 
		echo form_button ( 
			array (
				'aria-label' => 'Close', 
				'data-dismiss' => 'modal', 
				'type' => 'button', 
				'class' => 'close', 
				'content' => '<span aria-hidden="true">×</span>')
			); 
	?>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_usermobile_edit');?></h4>
</div>

<?php 
	$attributes = array (
		'name' => 'edit_department', 
		'id' => 'edit_department', 
		'autocomplete' => 'off', 
		'class'=>'m-b-1'
	);
?>

<?php 
	$hidden = array (
		'_method' => 'EDIT', 
		'_token' => $usermobile_id, 
		'ext_name' => $fullname
	);
?>

<?php echo form_open('admin/usermobile/update/'.$usermobile_id, $attributes, $hidden);?>
<div class="modal-body">
  <div class="form-group">
    <label for="department-name" class="form-control-label"><?php echo $this->lang->line('xin_name');?>:</label>
    <input type="text" class="form-control" name="department_name" value="<?php echo '('.$usermobile_id.') '.$fullname;?>"/>
  </div>


  <div class="form-group">
    <label for="first_name">PT / Perusahaan</label>
    <input class="form-control" type="text" value="<?php echo $company_name;?>">
  </div>

  <div class="form-group">
    <label for="first_name">Project</label>
    <input class="form-control" type="text" value="<?php echo $project_name;?>">
  </div>

  <div class="form-group">
    <label for="first_name">Sub Project</label>
    <input class="form-control" type="text" value="<?php echo $project_sub;?>">
  </div>

  <div class="form-group">
    <label for="first_name">Posisi Jabatan</label>
    <input class="form-control" type="text" value="<?php echo $posisi;?>">
  </div>

  <div class="form-group">
    <label for="first_name">Area / Penempatan</label>
    <input class="form-control" type="text" placeholder="Area/Penempatan" value="<?php echo $penempatan;?>">
  </div>

	<div class="form-group">
  	<label for="first_name"><?php echo $this->lang->line('xin_deviceid');?></label>
    <input type="text" class="form-control" placeholder="Device ID" name="device_id" value="<?php echo $device_id ?>"/>
  </div>

  <input type="hidden" name="employeeid" value="<?php echo $usermobile_id ?>"/>
  <input type="hidden" name="project" value="<?php echo $project_id ?>"/>

</div>

<div class="modal-footer"> 
	<?php echo form_button( 
		array (
			'data-dismiss' => 'modal', 
			'type' => 'button', 
			'class' => 'btn btn-secondary', 
			'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_close')
			)
		); 
	?> 

	<?php echo form_button( 
		array (
			'name' => 'hrpremium_form', 
			'type' => 'submit', 
			'class' => $this->Xin_model->form_button_class(), 
			'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_update')
			)
		); 
	?> 
</div>

<?php echo form_close(); ?> 

<script type="text/javascript">
 $(document).ready(function(){
							
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	 
		
		jQuery("#ajx_company").change(function(){
			jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
				jQuery('#employee_ajx').html(data);
			});
			jQuery.get(base_url+"/get_company_locations/"+jQuery(this).val(), function(data, status){
				jQuery('#location_ajaxx').html(data);
			});
		});	 
		 Ladda.bind('button[type=submit]');
		/*jQuery("#aj_company").change(function(){
		jQuery.get(escapeHtmlSecure(base_url+"/get_company_locations/"+jQuery(this).val()), function(data, status){
			jQuery('#location_ajax').html(data);
		});
	});*/
		/* Edit data */
		$("#edit_department").submit(function(e){
		e.preventDefault();
			var obj = $(this), action = obj.attr('name');
			$('.save').prop('disabled', true);
			
			$.ajax({
				type: "POST",
				url: e.target.action,
				data: obj.serialize()+"&is_ajax=1&edit_type=department&form="+action,
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
								url : "<?php echo htmlspecialchars(site_url("admin/usermobile/usermobile_list")); ?>",
								type : 'GET'
							},
							"fnDrawCallback": function(settings){
							$('[data-toggle="tooltip"]').tooltip();          
							}
						});
						xin_table.api().ajax.reload(function(){ 
							toastr.success(JSON.result);
							$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
						}, true);
						$('.edit-modal-data').modal('toggle');
						$('.save').prop('disabled', false);
						Ladda.stopAll();
					}
				}
			});
		});
	});	
</script>
<?php }
?>
