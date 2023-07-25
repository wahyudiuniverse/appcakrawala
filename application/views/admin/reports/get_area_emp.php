<?php $result = $this->Project_model->ajax_area_employees($area,$sub_id,$pro_id);?>

<div class="form-group">
  <label for="xin_area_emp">Area/Penempatan X</label>
   <select name="area_emp" id="aj_area_emp" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
    <option value="0">ALL</option>
    <?php foreach($result as $areas) {?>
    <option value="<?php echo $areas->penempatan;?>"> <?php echo $areas->penempatan;?></option>
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

  // jQuery("#aj_subproject").change(function(){

  //   var project_id = document.getElementById("aj_project").value;
  //   var subproject_id = document.getElementById("aj_subproject").value;

  //   jQuery.get(base_url+"/get_area_emp/"+jQuery(this).val()+"/"+subproject_id+"/"+project_id, function(data, status){
  //     jQuery('#areaemp_ajax').html(data);
  //   });
  // });

</script>