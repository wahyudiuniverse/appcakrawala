
<?php $result = $this->Employees_model->get_empdeactive_byproject($id_project);
?>

                  <div class="form-group">
                   <label for="employee_id"><?php echo $this->lang->line('xin_karyawan');?><i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="employee_id" id="aj_ktp" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_karyawan');?>">
                      <option value=""></option>
                      <?php foreach($result as $empactive) {?>
                      <option value="<?php echo $empactive->employee_id;?>"><?php echo $empactive->fullname?></option>
                      <?php } ?>
                    </select>
                  </div>

<?php
//}
?>
<script type="text/javascript">
$(document).ready(function(){

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });

			//get project
	jQuery("#aj_ktp").change(function(){
		var p_id = jQuery(this).val();
		jQuery.get(base_url+"/get_ktp/"+p_id, function(data, status){
			jQuery('#ktp_ajax').html(data);			
		});
	});

	// get departments
	jQuery("#aj_ktp").change(function(){
		jQuery.get(base_url+"/get_info/"+jQuery(this).val(), function(data, status){
			jQuery('#info_ajax').html(data);
		});
	});

					//get project
	jQuery("#aj_ktp").change(function(){
		var p_id = jQuery(this).val();
		jQuery.get(base_url+"/get_ket/"+p_id, function(data, status){
			jQuery('#ket_ajax').html(data);			
		});
	});

					//get project
	jQuery("#aj_ktp").change(function(){
		var p_id = jQuery(this).val();
		jQuery.get(base_url+"/get_rdate/"+p_id, function(data, status){
			jQuery('#rdate_ajax').html(data);			
		});
	});

});
</script>