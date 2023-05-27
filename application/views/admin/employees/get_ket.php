<?php $result = $this->Employees_model->read_employee_info_by_nik($employee_id);?>


                  <div class="form-group">
                    <label for="ket_resign" class="control-label">Keterangan Resign<i class="hrpremium-asterisk"></i></label>
                    <input class="form-control" placeholder="Keterangan Resign/Bad Atitude" name="ket_resign" type="text" value="<?php echo '['.$result[0]->deactive_date.'] '.$result[0]->deactive_reason;?>">
                  </div>


<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });

});
</script>