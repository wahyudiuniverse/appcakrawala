<?php $result = $this->Project_model->ajax_sub_project($id_project);?>

<div class="form-group">
  <label for="xin_sub_projects">Sub Project</label>
   <select name="sub_project_id" id="aj_subproject" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
    <option value="0">--</option>
    <?php foreach($result as $sproj) {?>
    <option value="<?php echo $sproj->secid;?>"> <?php echo $sproj->sub_project_name;?></option>
    <?php } ?>
  </select>
</div>

<script type="text/javascript">
$(document).ready(function(){

  $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
  $('[data-plugin="select_hrm"]').select2({ width:'100%' });

	$('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
	$('[data-plugin="xin_select"]').select2({ width:'100%' });

});

  // jQuery("#aj_project").change(function(){
  //   jQuery.get(base_url+"/get_sub_project/"+jQuery(this).val(), function(data, status){
  //     jQuery('#subproject_ajax').html(data);
  //   });
  // });

</script>