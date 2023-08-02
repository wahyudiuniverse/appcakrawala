<div class="container">

	<div class="my-account">

		<div class="tabs-container">
			<!-- Register -->
			<div class="tab-content" id="tab2">

                <?php $attributes = array('id' => 'xin-form', 'class' => 'register', 'autocomplete' => 'on');?>
				<?php $hidden = array('register' => '1');?>
                <?php echo form_open('daftar/tambah_kandidat/', $attributes, $hidden);?>	


                <input type="hidden" name="hrpremium_view" value="1" />

				<p class="form-row form-row-wide">
					<label for="company_id">Perusahaan/PT:
						<i class="ln ln-icon-Male"></i>					
						<select id="department_id" name="company_id" data-placeholder="Pilih salah satu" class="chosen-select">
						<option value=""></option>
                        <?php foreach($all_companies as $company):?>
                        <option value="<?php echo $company->company_id;?>"><?php echo $company->name;?></option>
                        <?php endforeach;?>
					</select>
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="first_name">Nama Lengkap:
						<i class="ln ln-icon-Male"></i>
						<input type="text" class="input-text" name="first_name" id="first_name1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="tempat_lahir">Tempat Kelahiran:
						<i class="ln ln-icon-Home"></i>
						<input type="text" class="input-text" name="tempat_lahir" id="first_name1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="tanggal_lahir">Tanggal Lahir:
						<i class="ln ln-icon-Calendar"></i>
						<input type="text" class="input-text date" name="tanggal_lahir"  value="">
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="alamat_domisili">Alamat Lengkap Domisili:
						<i class="ln ln-icon-Home"></i>
						<input type="text" class="input-text" name="alamat_domisili" id="first_name1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="alamat_ktp">Alamat Sesuai KTP:
						<i class="ln ln-icon-Home"></i>
						<input type="text" class="input-text" name="alamat_ktp" id="first_name1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="contact_number">Nomor HP/Whatsapp:
						<i class="ln ln-icon-Phone-2"></i>
						<input type="text" class="input-text" name="contact_number" id="contact_number1" value="" />
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="email">Email Address:
						<i class="ln ln-icon-Mail"></i>
						<input type="text" class="input-text" name="email" id="email1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="nomor_ktp">Nomor KTP:
						<i class="ln ln-icon-ID-Card"></i>
						<input type="text" class="input-text" name="nomor_ktp" id="contact_number1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="nomor_kk">Nomor KK:
						<i class="ln ln-icon-ID-Card"></i>
						<input type="text" class="input-text" name="nomor_kk" id="contact_number1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="npwp">Nomor NPWP (jika ada):
						<i class="ln ln-icon-ID-Card"></i>
						<input type="text" class="input-text" name="npwp" id="contact_number1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="ibu_kandung">Nama Ibu Kandung:
						<i class="ln ln-icon-Family-Sign"></i>
						<input type="text" class="input-text" name="ibu_kandung" id="contact_number1" value="" />
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="jenis_kelamin">Jenis Kelamin:
						<i class="ln ln-icon-Male"></i>					
						<select name="jenis_kelamin" data-placeholder="Pilih salah satu" class="chosen-select">
						<option value=""></option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
					</select>
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="agama">Agama/Kepercayaan:
						<i class="ln ln-icon-Male"></i>					
						<select name="agama" data-placeholder="Pilih salah satu" class="chosen-select">
						<option value=""></option>
                        <option value="1">Islam</option>
                        <option value="2">Kristen Protestan</option>
                        <option value="3">Kristen Katolik</option>
                        <option value="4">Hindu</option>
                        <option value="5">Buddha</option>
                        <option value="6">Konghucu</option>
					</select>
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="pernikahan">Status Pernikahan:
						<i class="ln ln-icon-Male"></i>					
						<select name="pernikahan" data-placeholder="Pilih salah satu" class="chosen-select">
						<option value=""></option>
                        <option value="Belum Menikah">Belum Menikah</option>
                        <option value="Menikah (0 Anak)">Menikah (0 Anak)</option>
                        <option value="Menikah (1 Anak)">Menikah (1 Anak)</option>
                        <option value="Menikah (2 Anak)">Menikah (2 Anak)</option>
                        <option value="Menikah (3 Anak)">Menikah (3 Anak)</option>
                        <option value="Janda/Duda (0 Anak)">Janda/Duda (0 Anak)</option>
                        <option value="Janda/Duda (1 Anak)">Janda/Duda (1 Anak)</option>
                        <option value="Janda/Duda (2 Anak)">Janda/Duda (2 Anak)</option>
                        <option value="Janda/Duda (3 Anak)">Janda/Duda (3 Anak)</option>
                        
					</select>
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="tinggi_badan">Tinggi Badan:
						<i class="ln ln-icon-Bodybuilding"></i>
						<input type="text" class="input-text" name="tinggi_badan" id="contact_number1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="berat_badan">Berat Badan:
						<i class="ln ln-icon-Bodybuilding"></i>
						<input type="text" class="input-text" name="berat_badan" id="contact_number1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="last_company">Perusahaan/PT Tempat Bekerja Sebelumnya:
						<i class="ln ln-icon-Post-Office"></i>
						<input type="text" class="input-text" name="last_company" id="contact_number1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="last_posisi">Posisi/Jabatan Sebelumnya:
						<i class="ln ln-icon-Post-Office"></i>
						<input type="text" class="input-text" name="last_posisi" id="contact_number1" value="" />
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="last_edu">Pendidikan Terakhir:
						<i class="ln ln-icon-Male"></i>					
						<select name="last_edu" data-placeholder="Pilih salah satu" class="chosen-select">
						<option value=""></option>
                        <option value="1">Sekolah Dasar (SD)</option>
                        <option value="2">Sekolah Menengah Pertama (SMP/MTS)</option>
                        <option value="3">Sekolah Menengah Atas (SMA/SMK/MA)</option>
                        <option value="4">Diploma (D1,D2,D3)</option>
                        <option value="5">Strata 1 (S1)</option>
                        <option value="6">Strata 2 (S2)</option>
                        <option value="7">Strata 3 (S3)</option>
					</select>
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="school_name">Nama Sekolah/Universitas:
						<i class="ln ln-icon-University"></i>
						<input type="text" class="input-text" name="school_name" id="contact_number1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="jurusan">Jurusan:
						<i class="ln ln-icon-University"></i>
						<input type="text" class="input-text" name="jurusan" id="contact_number1" value="" />
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="project_id">Project:
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
					<label for="posisi_lamar">Posisi/Jabatan yg dilamar:
						<i class="ln ln-icon-Engineering"></i>
						<input type="text" class="input-text" name="posisi_lamar" id="contact_number1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="penempatan">Area/Penempatan Kerja:
						<i class="ln ln-icon-Engineering"></i>
						<input type="text" class="input-text" name="penempatan" id="contact_number1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="bank_name">NAMA BANK:
						<i class="ln ln-icon-Bank"></i>
						<input type="text" class="input-text" name="bank_name" id="contact_number1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="nomor_rek">NOMOR REKENING:
						<i class="ln ln-icon-Bank"></i>
						<input type="text" class="input-text" name="nomor_rek" id="contact_number1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="pemilik_rek">NAMA PEMILIK REKENING:
						<i class="ln ln-icon-Bank"></i>
						<input type="text" class="input-text" name="pemilik_rek" id="contact_number1" value="" />
					</label>
				</p>
				

<br>
                <p class="form-row">
                    <label>Foto KTP</label>
                        <input type="file" id="foto_ktp" name="foto_ktp" />
 
				</p>

                <p class="form-row">
                    <label>Foto KK</label>
                        <input type="file" id="foto_kk" name="foto_kk" />
 
				</p>

                <p class="form-row">
                    <label>Foto Buku Rekening/M-Banking</label>
                        <input type="file" id="foto_rek" name="foto_rek" />
 
				</p>
				<br>
				<p class="form-row">
					<input type="submit" class="button border fw margin-top-10" name="register" value="Register" />
				</p>

				</form>
			</div>
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