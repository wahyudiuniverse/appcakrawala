
<?php $result = $this->Employees_model->ajax_project_sub($id_project);?>


					<label for="subproject_id">SUB-PROJECT: <strong><span style="color:red;">*</span></strong>
								


						<select name="subproject_id" data-placeholder="Pilih salah satu" class="chosen-select" style="height: 50px;padding-left: 20px;">
													<option value="">--</option>
	                        <?php foreach($result as $sb):?>
	                        <option value="<?php echo $sb->secid;?>"><?php echo $sb->sub_project_name;?></option>
	                        <?php endforeach;?>
						</select>

					</label>




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