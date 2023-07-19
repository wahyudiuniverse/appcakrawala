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
  <h4 class="modal-title" id="edit-modal-data">TANDAI UNDUH BPJS - SALTAB <?php echo $keywords; ?></h4>
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
		'_token' => $keywords, 
		'ext_name' => $downloadby
	);
?>

<?php echo form_open('admin/bpjs/update/'.$keywords, $attributes, $hidden);?>
<div class="modal-body">
	
  <input name="uploadid" type="text" value="<?php echo $keywords;?>" hidden>

        <div class="form-group">
          <label for="first_name">Diunduh Oleh:</label>
          <select class=" form-control" name="downloadby" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_user_area_extra2');?>">
            <option value=""></option>
      			<option value="<?php echo $downloadby?>" selected> <?php echo ucwords(strtolower($downloadby))?></option>

          </select>
        </div>


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
								url : "<?php echo htmlspecialchars(site_url("admin/bpjs/usermobile_list")); ?>",
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
