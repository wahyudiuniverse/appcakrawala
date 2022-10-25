<?php $result = $this->Employees_model->read_employee_info_by_nik($company_id);?>

          <div class="form-group">
                        <label for="join_date">Join Date</label>
                        <input class="form-control date" placeholder="Tanggal Bergabung" readonly="readonly" name="join_date" type="text" value="<?php echo $result[0]->date_of_joining;?>">
          </div>

          <div class="form-group">
                        <label for="resign_date">Resign Date</label>
                        <input class="form-control date" placeholder="Resign Date" readonly="readonly" name="resign_date" type="text" value="<?php echo $result[0]->date_of_leaving;?>">
          </div>

<?php
//}
?>
<script type="text/javascript">
$(document).ready(function(){
// get designations
// jQuery("#aj_department").change(function(){
// 	jQuery.get(base_url+"/designation/"+jQuery(this).val(), function(data, status){
// 		jQuery('#designation_ajax').html(data);
// 	});
// });
$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
});
</script>