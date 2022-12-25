<?php $result = $this->Employees_model->get_all_employees_byproject($company_id);?>

<div class="form-group">
   <label class="form-label"><?php echo $this->lang->line('xin_karyawan');?></label>
   <select name="employee_id" id="aj_employee" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_karyawan');?>" required>
    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
    <?php foreach($result as $employee) {?>
    <option value="<?php echo $employee->employee_id;?>"> <?php echo $employee->fullname;?></option>
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