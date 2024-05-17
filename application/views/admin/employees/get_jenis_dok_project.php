
<!-- <?php $result = $this->Employees_model->ajax_project_sub($id_project);?> -->
<?php $projcomp = $this->Project_model->getcomp_single_project($id_project);
if($projcomp[0]->doc_id == 1){
	$dokid = '1';
	$dokname = 'PKWT';
} else if ($projcomp[0]->doc_id == 2){
	$dokid = '2';
	$dokname = 'TKHL';
} else {
	$dokid = '0';
	$dokname = 'TIDAK DIKETAHUI';
}

?>

                  <div class="form-group">
                    <label for="jenis_dokumen">Jenis Dokumen<i class="hrpremium-asterisk"></i></label>
                      <select class="form-control" name="jenis_dokumen" data-plugin="select_hrm">
								    		<option value="<?php echo $dokid;?>"><?php echo $dokname;?></option>
								  		</select>
                  </div>


<?php
//}
?>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });
	// get departments
	// jQuery("#aj_location_id").change(function(){
	// 	jQuery.get(base_url+"/get_location_departments/"+jQuery(this).val(), function(data, status){
	// 		jQuery('#department_ajax').html(data);
	// 	});
	// });
});
</script>