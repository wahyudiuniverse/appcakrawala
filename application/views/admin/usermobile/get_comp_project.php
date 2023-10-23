
<?php $result = $this->Project_model->get_project_bycompany($company_id, $employee_id);?>


          <label class="form-label"><?php echo $this->lang->line('left_projects').'c';?></label>
          <select class="form-control" name="project_id" id="aj_project" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_projects');?>">
            <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
            <?php 
              foreach ($result as $projects) {
            ?>
                <option value="<?php echo $projects->project_id?>"><?php echo $projects->title?></option>
            <?php 
              } 
            ?>
          </select>


<?php
//}
?>
<script type="text/javascript">
$(document).ready(function(){

	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });


	// jQuery("#aj_project").change(function(){
	// 	jQuery.get(base_url+"/get_subprojects/"+jQuery(this).val(), function(data, status){
	// 		jQuery('#subproject_ajax').html(data);
	// 	});
	// });

	//get project
	jQuery("#aj_project").change(function(){
		var p_id = jQuery(this).val();
		jQuery.get(base_url+"/get_subprojects/"+p_id, function(data, status){
			jQuery('#subproject_ajax').html(data);			
		});
	});

	// get departments
	// jQuery("#aj_ktp").change(function(){
	// 	jQuery.get(base_url+"/get_info/"+jQuery(this).val(), function(data, status){
	// 		jQuery('#info_ajax').html(data);
	// 	});
	// });
	// // get departments
	// jQuery("#aj_ktp").change(function(){
	// 	jQuery.get(base_url+"/get_pkwt_kontrak/"+jQuery(this).val(), function(data, status){
	// 		jQuery('#pkwt_kontrak_ajax').html(data);
	// 	});
	// });
	// // get departments
	// jQuery("#aj_ktp").change(function(){
	// 	jQuery.get(base_url+"/get_pkwt_begin/"+jQuery(this).val(), function(data, status){
	// 		jQuery('#pkwt_begin_ajax').html(data);
	// 	});
	// });
	// // get departments
	// jQuery("#aj_ktp").change(function(){
	// 	jQuery.get(base_url+"/get_info_pkwt/"+jQuery(this).val(), function(data, status){
	// 		jQuery('#info_ajax').html(data);
	// 	});
	// });

});
</script>