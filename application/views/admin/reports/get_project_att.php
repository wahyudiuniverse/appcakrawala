
<?php $result = $this->Employees_model->get_all_employees_byproject($id_project);

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
});
</script>