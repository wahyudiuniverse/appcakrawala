<?php 
if($nomor_ktp==null || $nomor_ktp==''){
	$nik_ktp = '';
	$nip = '';
	$fullname = '';
	$jabatan = '';
	$project = '';
	$status_emp = '';
	
} else {
	$nik_ktp = $nomor_ktp;
	$result = $this->Employees_model->checknik($nomor_ktp);
	if(!is_null($result)){
			$nip = $result[0]->employee_id;
			$fullname = $result[0]->first_name;
			$jabatan = $result[0]->designation_name;
			$project = $result[0]->title;
			if($result[0]->status_resign=='1'){
				$status_emp = 'KARYAWAN AKTIF';
			} else if ($result[0]->status_resign=='2' || $result[0]->status_resign=='4' || $result[0]->status_resign=='5'){
				$status_emp = 'TIDAK AKTIF';
			} else if ($result[0]->status_resign=='3') {
				$status_emp = '<b style="color:red;">BLACKLIST</b>';
			} else {
				$status_emp = 'tidak ditemukan';
			}

		} else {
			$nip = 'tidak ditemukan';
			$fullname = 'tidak ditemukan';
			$jabatan = 'tidak ditemukan';
			$project = 'tidak ditemukan';
			$status_emp = 'tidak ditemukan';
		}

}

?>


<div class="container">
	<div class="my-account">
		<div class="tab-content" id="tab2">

                <?php $attributes = array('id' => 'xin-form', 'class' => 'register', 'autocomplete' => 'on');?>
				<?php $hidden = array('register' => '1');?>
                <?php echo form_open('ceknik/', $attributes, $hidden);?>	

                <input type="hidden" name="hrpremium_view" value="1" />

                <p class="form-row form-row-wide">
					<label for="nomor_ktp">NOMOR KTP: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-ID-Card"></i>
						<input type="number" maxlength="16" class="input-text" placeholder="CARI NIK" name="nomor_ktp" id="nomor_ktpx" value="<?php echo $nik_ktp;?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
					</label>
				</p>

				<br>
				<p class="form-row">
					<input type="submit" class="button border fw margin-top-10" name="register" value="CEK KTP" />
				</p>

				</form>
			</div>
			
			 <table border="1" style="border-style: solid; border-color: coral;">

			        <tr>
			            <td>NIK KTP&ensp;&ensp;&ensp;</td>
			            <td><b> : <?php echo $nik_ktp;?></b></td>
			        </tr>

			        <tr>
			            <td>NIP&ensp;&ensp;&ensp;</td>
			            <td><b> : <?php echo $nip;?></b></td>
			        </tr>

			        <tr>
			            <td>NAMA LENGKAP&ensp;&ensp;&ensp;</td>
			            <td><b> : <?php echo $fullname;?></b></td>
			        </tr>

			        <tr>
			            <td>JABATAN&ensp;&ensp;&ensp;</td>
			            <td><b> : <?php echo $jabatan;?></b></td>
			        </tr>
			        <tr>
			            <td>PROJECT&ensp;&ensp;&ensp;</td>
			            <td><b> : <?php echo $project;?></b></td>
			        </tr>
			        <tr>
			            <td>STATUS&ensp;&ensp;&ensp;</td>
			            <td><b> : <?php echo $status_emp;?></b></td>
			        </tr>
			    </table>

			    <br><br>

		</div>

	</div>




</div>

<style type="text/css">
	
	input[type=file]::file-selector-button {
  margin-right: 20px;
  border: none;
  background: #26ae61;
  padding: 10px 20px;
  border-radius: 2px;
  color: #fff;
  cursor: pointer;
  transition: background .2s ease-in-out;
}

input[type=file]::file-selector-button:hover {
  background: #0d45a5;
}



</style>
<!-- Container -->

