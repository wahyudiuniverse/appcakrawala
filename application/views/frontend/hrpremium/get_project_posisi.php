
<?php $results = $this->Employees_model->ajax_project_posisi($id_project);?>


					<label for="psosisi">POSISI/JABATAN: <strong><span style="color:red;">*</span></strong>
								

						<select name="posisi_id" data-placeholder="Pilih salah satu" class="chosen-select" style="height: 50px;padding-left: 20px;">
							<option value="">--</option>
	                        <?php foreach($results as $pos):?>
	                        <option value="<?php echo $pos->posisi;?>"><?php echo $pos->designation_name;?></option>
	                        <?php endforeach;?>
						</select>

					</label>




</style>
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