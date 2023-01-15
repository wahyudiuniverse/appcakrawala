
<?php $result = $this->Employees_model->get_all_employees_byposisi($id_project);
?>

                  <div class="form-group">
                   <label for="posisi">Posisi/Jabatan<i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="posisi" id="aj_posisi" data-plugin="xin_select" data-placeholder="Pilih">
                      <option value=""></option>
                      <?php foreach($result as $emppos) {?>
                      <option value="<?php echo $emppos->posisi_jabatan;?>"><?php echo $emppos->posisi_jabatan?></option>
                      <?php } ?>
                    </select>
                  </div>

<?php
//}
?>
<script type="text/javascript">
$(document).ready(function(){

	$('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
	$('[data-plugin="xin_select"]').select2({ width:'100%' });

	// get departments
	jQuery("#aj_posisi").change(function(){
		jQuery.get(base_url+"/get_project_area/"+jQuery(this).val(), function(data, status){
			jQuery('#project_area_ajax').html(data);
		});
	});

	// get departments
	jQuery("#aj_posisi").change(function(){
		jQuery.get(base_url+"/get_pkwt_posisi/"+jQuery(this).val(), function(data, status){
			jQuery('#pkwt_posisi_ajax').html(data);
		});
	});

	// // get departments
	// jQuery("#aj_ktp").change(function(){
	// 	jQuery.get(base_url+"/get_info/"+jQuery(this).val(), function(data, status){
	// 		jQuery('#info_ajax').html(data);
	// 	});
	// });

});
</script>