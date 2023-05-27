<?php $result = $this->Employees_model->read_employee_info_by_nik($employee_id);?>


                  <div class="form-group">
                  <label for="date_of_birth">Tanggal Berakhir<i class="hrpremium-asterisk">*</i></label>
                  <input class="form-control date" readonly placeholder="Tanggal Resign" name="date_of_leave" type="text" value="<?php echo substr($result[0]->deactive_date,0,10);?>">
                  </div>



<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });

});
</script>