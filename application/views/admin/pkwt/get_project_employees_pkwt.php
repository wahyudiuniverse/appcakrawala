
<?php $result = $this->Employees_model->get_all_employees_byproject($id_project);
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


	// get departments
	jQuery("#aj_ktp").change(function(){
		jQuery.get(base_url+"/get_pkwt_hk/"+jQuery(this).val(), function(data, status){
			jQuery('#pkwt_hk_ajax').html(data);
		});
	});

	// get departments
	jQuery("#aj_ktp").change(function(){
		jQuery.get(base_url+"/get_pkwt_gaji/"+jQuery(this).val(), function(data, status){
			jQuery('#pkwt_gaji_ajax').html(data);
		});
	});

	// get departments
	jQuery("#aj_ktp").change(function(){
		jQuery.get(base_url+"/get_pkwt_area/"+jQuery(this).val(), function(data, status){
			jQuery('#pkwt_area_ajax').html(data);
		});
	});

	// get departments
	jQuery("#aj_ktp").change(function(){
		jQuery.get(base_url+"/get_pkwt_posisi/"+jQuery(this).val(), function(data, status){
			jQuery('#pkwt_posisi_ajax').html(data);
		});
	});

	// get departments
	jQuery("#aj_ktp").change(function(){
		jQuery.get(base_url+"/get_pkwt_kontrak/"+jQuery(this).val(), function(data, status){
			jQuery('#pkwt_kontrak_ajax').html(data);
		});
	});
	// get departments
	jQuery("#aj_ktp").change(function(){
		jQuery.get(base_url+"/get_pkwt_begin/"+jQuery(this).val(), function(data, status){
			jQuery('#pkwt_begin_ajax').html(data);
		});
	});
	// get departments
	jQuery("#aj_ktp").change(function(){
		jQuery.get(base_url+"/get_info_pkwt/"+jQuery(this).val(), function(data, status){
			jQuery('#info_ajax').html(data);
		});
	});

});
</script>