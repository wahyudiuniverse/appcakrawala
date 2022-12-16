<?php $result = $this->Esign_model->ajax_proj_emp_info($project_id);?>

<div class="form-group">
  <label for="employee"><?php echo $this->lang->line('xin_daftar_karyawan');?></label>
  <select class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_daftar_karyawan');?>" name="manag_sign">
    <option value=""></option>
    <?php foreach($result as $company) {

                if(!is_null($company->bln_skrng)){

                  $now = new DateTime(date("Y-m-d"));
                  $expiredate = new DateTime($company->date_of_leaving);
                  $d = $now->diff($expiredate)->days;

                  if($d<='30'){
            ?>
                    <option value="<?php echo $company->employee_id?>"><?php echo $company->fullname.' (NEW)';?></option>
            <?php
                  } else {
            ?>
<option value="<?php echo $company->employee_id?>"><?php echo $company->fullname?></option>
            <?php
                  }
                } else {
            ?>
<option value="<?php echo $company->employee_id?>"><?php echo $company->fullname?></option>
            <?php
                }
                ?>



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