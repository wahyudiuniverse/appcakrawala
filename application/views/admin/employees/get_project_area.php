
<?php $result = $this->Employees_model->get_all_employees_byarea($id_project);
?>

                  <div class="form-group">
                   <label for="area">Area/Penempatan<i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="area" id="aj_area" data-plugin="select_hrm" data-placeholder="Pilih">
                      <option value=""></option>
                      <?php foreach($result as $emparea) {?>
                      <option value="<?php echo $emparea->area;?>"><?php echo $emparea->area?></option>
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


	// get departments
	jQuery("#aj_area").change(function(){
		var proj = document.getElementById("aj_project").value ;
		var posi = document.getElementById("aj_posisi").value ;

		jQuery.get(base_url+"/get_pkwt_area/"+jQuery(this).val()+"/"+posi+"/"+proj, function(data, status){
			jQuery('#pkwt_area_ajax').html(data);
		});
	});

	// get departments
	jQuery("#aj_area").change(function(){
		var proj = document.getElementById("aj_project").value ;
		var posi = document.getElementById("aj_posisi").value ;

		jQuery.get(base_url+"/get_pkwt_gaji/"+jQuery(this).val()+"/"+posi+"/"+proj, function(data, status){
			jQuery('#pkwt_gaji_ajax').html(data);
		});
	});

	// get departments
	jQuery("#aj_area").change(function(){
		var proj = document.getElementById("aj_project").value ;
		var posi = document.getElementById("aj_posisi").value ;

		jQuery.get(base_url+"/get_pkwt_hk/"+jQuery(this).val()+"/"+posi+"/"+proj, function(data, status){
			jQuery('#pkwt_hk_ajax').html(data);
		});
	});

	// get departments
	jQuery("#aj_area").change(function(){
		var proj = document.getElementById("aj_project").value ;
		var posi = document.getElementById("aj_posisi").value ;

		jQuery.get(base_url+"/get_pkwt_allow/"+jQuery(this).val()+"/"+posi+"/"+proj, function(data, status){
			jQuery('#pkwt_allow_ajax').html(data);
		});
	});

});
</script>