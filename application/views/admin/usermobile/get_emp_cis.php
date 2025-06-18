
<?php //$result = $this->Project_model->get_project_bycompany($company_id, $employee_id);?>

<?php $result = $this->Usersmobile_model->get_employee_cis($company_id);?>

		<input type="hidden" name="employee_id" value="<?php echo $result[0]->employee_id;?>">
		<input type="hidden" name="fullname" value="<?php echo $result[0]->first_name;?>">
		<input type="hidden" name="company_id" value="<?php echo $result[0]->company_id;?>">
		<input type="hidden" name="project_id" value="<?php echo $result[0]->project_id;?>">

          <label class="form-label">PT. / Perusahaan</label>
          <select class="form-control" name="company_name" data-plugin="select_hrm">
            <option value="<?php echo $result[0]->comp_name;?>"><?php echo $result[0]->comp_name;?></option>
          </select>
		<br><br>
          <label class="form-label">Project</label>
          <select class="form-control" name="project_name" data-plugin="select_hrm">
            <option value="<?php echo $result[0]->title;?>"><?php echo $result[0]->title;?></option>
          </select>
		<br><br>
          <label class="form-label">Sub Project</label>
          <select class="form-control" name="subproject" data-plugin="select_hrm">
            <option value="<?php echo $result[0]->sub_project_name;?>"><?php echo $result[0]->sub_project_name;?></option>
          </select>
		<br><br>
          <label class="form-label">Posisi/Jabatan</label>
          <select class="form-control" name="jabatan" data-plugin="select_hrm">
            <option value="<?php echo $result[0]->designation_name;?>"><?php echo $result[0]->designation_name;?></option>
          </select>
		<br><br>
          <label class="form-label">Penempatan</label>
          <input class="form-control" type="text" name="penempatan" value="<?php echo $result[0]->penempatan;?>">
          
 

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
	// jQuery("#aj_project").change(function(){
	// 	var p_id = jQuery(this).val();
	// 	jQuery.get(base_url+"/get_subprojects/"+p_id, function(data, status){
	// 		jQuery('#subproject_ajax').html(data);			
	// 	});
	// });

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