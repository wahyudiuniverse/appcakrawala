<?php $result = $this->Employees_model->read_employee_info_by_nik($id_project);


                $begin = $result[0]->contract_start;
                $end = $result[0]->contract_end;

?>

                    <label for="begin">: <?php echo $begin. ' - '.$end;?></label>
                    <input name="begin" type="text" value="<?php echo $begin. ' - '.$end;?>" hidden>




<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });

});
</script>