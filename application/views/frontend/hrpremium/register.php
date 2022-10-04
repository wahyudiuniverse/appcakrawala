<div class="container">

	<div class="my-account">

		<div class="tabs-container">
			<!-- Register -->
			<div class="tab-content" id="tab2">

                <?php $attributes = array('id' => 'xin-form', 'class' => 'register', 'autocomplete' => 'on');?>
				<?php $hidden = array('register' => '1');?>
                <?php echo form_open('employer/tambah_employee/', $attributes, $hidden);?>	


                <input type="hidden" name="hrpremium_view" value="1" />
                <input type="hidden" name="company_id" value="2" />

                <p class="form-row form-row-wide">
					<label for="first_name">Nama Lengkap:
						<i class="ln ln-icon-Male"></i>
						<input type="text" class="input-text" name="first_name" id="first_name1" value="" />
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="last_name">Department:
						<i class="ln ln-icon-Male"></i>					
						<select id="department_id" name="department_id" data-placeholder="Choose Category" class="chosen-select">
						<option value=""></option>
                        <?php foreach($all_dept as $dept):?>
                        <option value="<?php echo $dept->department_id;?>"><?php echo $dept->department_name;?></option>
                        <?php endforeach;?>
					</select>
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="last_name">Posisi/Jabatan:
						<i class="ln ln-icon-Male"></i>					
						<select id="pos_id" name="pos_id" data-placeholder="Choose Category" class="chosen-select">
						<option value=""></option>
                        <?php foreach($all_designation as $posi):?>
                        <option value="<?php echo $posi->designation_id;?>"><?php echo $posi->designation_name;?></option>
                        <?php endforeach;?>
					</select>
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="last_name">Project:
						<i class="ln ln-icon-Male"></i>					
						<select id="project_id" name="project_id" data-placeholder="Choose Category" class="chosen-select">
						<option value=""></option>
                        <?php foreach($all_project as $pro):?>
                        <option value="<?php echo $pro->project_id;?>"><?php echo $pro->title;?></option>
                        <?php endforeach;?>
					</select>
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="email2">Email Address:
						<i class="ln ln-icon-Mail"></i>
						<input type="text" class="input-text" name="email" id="email1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="contact_number">Contact Number:
						<i class="ln ln-icon-Phone-2"></i>
						<input type="text" class="input-text" name="contact_number" id="contact_number1" value="" />
					</label>
				</p>
				
				<p class="form-row">
					<input type="submit" class="button border fw margin-top-10" name="register" value="Register" />
				</p>

				</form>
			</div>
		</div>
	</div>
</div>

<!-- Container -->