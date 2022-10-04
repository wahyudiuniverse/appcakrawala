<?php $result = $this->Project_model->ajax_proj_subproj_info($project_id);?>

<div class="form-group">
  <label for="subproject"><?php echo $this->lang->line('left_sub_projects');?></label>
  <select class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_sub_projects');?>" name="subproject_id" id="aj_subproject" >
    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
    <?php foreach($result as $subprj) {?>
    <option value="<?php echo $subprj->secid?>"><?php echo $subprj->sub_project_name?></option>
    <?php } ?>
  </select>
</div>
<?php
//}
?>
<script type="text/javascript">
$(document).ready(function(){
// get designations
// jQuery("#aj_subproject").change(function(){
// 	jQuery.get(base_url+"/designation/"+jQuery(this).val(), function(data, status){
// 		jQuery('#designation_ajax').html(data);
// 	});
// });
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>