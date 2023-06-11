
<?php $result = $this->Employees_model->ajax_project_sub($id_project);?>
<?php $projcomp = $this->Project_model->read_single_project($id_project);?>


<div class="form-group">
  <label class="form-label"><?php echo $this->lang->line('left_sub_projects');?><i class="hrpremium-asterisk">*</i></label>
  <select class="form-control" name="sub_project_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_sub_projects');?>">
    <option value=""><?php echo $this->lang->line('left_sub_projects');?></option>
    <?php foreach($result as $subproject) {?>
    <option value="<?php echo $subproject->secid?>"><?php echo $subproject->sub_project_name;?></option>
    <?php } ?>
  </select>

  <input type="text" name="company_id" value="<?php echo $projcomp[0]->company_id?>" hidden>
</div>
<?php
//}
?>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	// get departments
	// jQuery("#aj_location_id").change(function(){
	// 	jQuery.get(base_url+"/get_location_departments/"+jQuery(this).val(), function(data, status){
	// 		jQuery('#department_ajax').html(data);
	// 	});
	// });
});
</script>