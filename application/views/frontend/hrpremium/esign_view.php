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

<!-- 
					<img src="<?php echo base_url();?>skin/img/inka.jpg" alt="" style="width: 200px; display: block;
  margin-left: auto;
  margin-right: auto;"/> -->

                <p class="form-row form-row-wide" style="text-align: center;">
					<img src="<?php echo base_url();?>skin/img/inka.png" alt="" style="width: 200px;"/>
				</p>


 <table border="1" style="border-style: solid; border-color: coral;">

        <tr>
            <td>NAMA LENGKAP&ensp;&ensp;&ensp;</td>
            <td><b> : MAITSA PRISTIYANTY </b></td>
        </tr>
        <tr>
            <td>NIP&ensp;&ensp;&ensp;</td>
            <td><b> : 21300023 </b></td>
        </tr>
        <tr>
            <td>JABATAN&ensp;&ensp;&ensp;</td>
            <td><b> : SENIOR MANAGER HR, GA & IT</b></td>
        </tr>
        <tr>
            <td>PERUSAHAAN&ensp;&ensp;&ensp;</td>
            <td><b> : PT. SIPRAMA CAKRAWALA</b></td>
        </tr>
        <tr>
            <td>LOKASI&ensp;&ensp;&ensp;</td>
            <td><b> : INHOUSE</b></td>
        </tr>
        <tr>
            <td>NO DOKUMEN&ensp;&ensp;&ensp;</td>
            <td><b> : <?php echo $nodoc;?></b></td>
        </tr>
        <tr>
            <td>TANGGAL TERBIT&ensp;&ensp;&ensp;</td>
            <td><b> : <?php echo $nodoc;?></b></td>
        </tr>
    </table>

<br>
 <table border="1" cellpadding="2" cellspacing="0" border="1" style="text-align: justify; text-justify: inter-word;">
        <tr>
            <td><b>INFORMASI DATA INI DIPERGUNAKAN SEBAGAI ALAT UNTUK PERIKATAN KONTRAK KERJA DAN MEMILIKI KEKUATAN HUKUM YANG SETARA DAN DAPAT DI PERTANGGUNG JAWABKAN.</b></td>
        </tr>
    </table>
<br>

 <table border="1" cellpadding="2" cellspacing="0" border="1" style="text-align: justify; text-justify: inter-word;">
        <tr>
            <td><b>Powerdby LEGAL @2022</b></td>
        </tr>
    </table>



<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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