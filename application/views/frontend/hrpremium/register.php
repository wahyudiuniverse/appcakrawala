<div class="container">


		<a href="<?php echo site_url('register/success/');?>" class="button" target="_blank">LIHAT DAFTAR TERSIMPAN</a>

	<div class="my-account">


			<div class="tab-content" id="tab2">

                <?php $attributes = array('id' => 'xin-form', 'class' => 'register', 'autocomplete' => 'on');?>
				<?php $hidden = array('register' => '1');?>
                <?php echo form_open('register/tambah_kandidat/', $attributes, $hidden);?>	


                <input type="hidden" name="hrpremium_view" value="1" />

				<p class="form-row form-row-wide" hidden>
					<label for="company_id">Perusahaan/PT: <strong><span style="color:red;">*</span></strong>
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
					<label for="first_name">NAMA LENGKAP (SESUAI KTP): <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Male"></i>
						<input type="text" class="input-text" name="first_name" id="nomor_ktp" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="tempat_lahir">KOTA/TEMPAT KELAHIRAN: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Home"></i>
						<input type="text" class="input-text" name="tempat_lahir" id="first_name1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="tanggal_lahir">TANGGAL LAHIR: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Calendar"></i>
						<input type="text" class="input-text date" name="tanggal_lahir"  value="">
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="alamat_ktp">ALAMAT (SESUAI KTP): <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Home"></i>
						<input type="text" class="input-text" name="alamat_ktp" id="first_name1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="alamat_domisili">ALAMAT (DOMISILI): <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Home"></i>
						<input type="text" class="input-text" name="alamat_domisili" id="first_name1" value="" />
					</label>
				</p>


                <p class="form-row form-row-wide">
					<label for="contact_number">NOMOR KONTAK/HP/Whatsapp: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Phone-2"></i>
						<input type="number" class="input-text" name="contact_number" id="contact_number1" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="email">EMAIL: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Mail"></i>
						<input type="text" class="input-text" name="email" id="email1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="nomor_ktp">NOMOR KTP: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-ID-Card"></i>
						<input type="number" class="input-text" name="nomor_ktp" id="nomor_ktpx" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="nomor_kk">NOMOR KK: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-ID-Card"></i>
						<input type="number" class="input-text" name="nomor_kk" id="contact_number1" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="npwp">NOMOR NPWP (Jika ada): 
						<i class="ln ln-icon-ID-Card"></i>
						<input type="text" class="input-text" name="npwp" id="contact_number1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="ibu_kandung">NAMA IBU KANDUNG: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Family-Sign"></i>
						<input type="text" class="input-text" name="ibu_kandung" id="contact_number1" value="" />
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="jenis_kelamin">JENIS KELAMIN: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Male"></i>					
						<select name="jenis_kelamin" data-placeholder="Pilih salah satu" class="chosen-select">
						<option value="">--Pilih Salah Satu--</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
					</select>
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="agama">AGAMA/KEPERCAYAAN: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Male"></i>					
						<select name="agama" data-placeholder="Pilih salah satu" class="chosen-select">
						<option value="">--Pilih Salah Satu--</option>
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
					<label for="pernikahan">STATUS PERNIKAHAN: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Male"></i>					
						<select name="pernikahan" data-placeholder="Pilih salah satu" class="chosen-select">
						<option value="">--Pilih Salah Satu--</option>
                        <option value="TK/0">Belum Menikah/Janda/Duda</option>
                        <option value="K/0">Menikah (0 Anak)</option>
                        <option value="K/1">Menikah (1 Anak)</option>
                        <option value="K/2">Menikah (2 Anak)</option>
                        <option value="K/3">Menikah (3 Anak)</option>
                        <option value="TK/1">Janda/Duda (1 Anak)</option>
                        <option value="TK/2">Janda/Duda (2 Anak)</option>
                        <option value="TK/3">Janda/Duda (3 Anak)</option>
                        
					</select>
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="tinggi_badan">TINGGI BADAN (cm):
						<i class="ln ln-icon-Bodybuilding"></i>
						<input type="number" class="input-text" name="tinggi_badan" id="contact_number1" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="berat_badan">BERATA BADAN (kg):
						<i class="ln ln-icon-Bodybuilding"></i>
						<input type="number" class="input-text" name="berat_badan" id="contact_number1" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="last_company">PERUSAHAAN/PT TEMPAT KERJA SEBELUMNYA : <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Post-Office"></i>
						<input type="text" class="input-text" name="last_company" id="contact_number1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="last_posisi">POSISI/JABATAN SEBELUMNYA: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Post-Office"></i>
						<input type="text" class="input-text" name="last_posisi" id="contact_number1" value="" />
					</label>
				</p>

				<p class="form-row form-row-wide">
					<label for="last_edu">PENDIDIKAN TERAKHIR: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Male"></i>					
						<select name="last_edu" data-placeholder="Pilih salah satu" class="chosen-select">
						<option value="">--Pilih Salah Satu--</option>
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
					<label for="school_name">NAMA SEKOLAH/UNIVERSITAS:
						<i class="ln ln-icon-University"></i>
						<input type="text" class="input-text" name="school_name" id="contact_number1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="jurusan">JURUSAN:
						<i class="ln ln-icon-University"></i>
						<input type="text" class="input-text" name="jurusan" id="contact_number1" value="" />
					</label>
				</p>


				<p class="form-row form-row-wide">
					<label for="project">PROJECT: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Male"></i>		

						<select id="aj_project" name="project_id" data-placeholder="Pilih salah satu" class="chosen-select" style="height: 50px;padding-left: 20px;">
							<option value=""></option>
	                        <?php foreach($all_project as $project):?>
	                        <option value="<?php echo $project->project_id;?>"><?php echo $project->title;?></option>
	                        <?php endforeach;?>
						</select>

					</label>
				</p>


				<p class="form-row form-row-wide" id="projectsubproject">
					
					<label for="subproject_id">SUB-PROJECT: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Male"></i>		

						<select name="subproject_id" data-placeholder="Pilih salah satu" class="chosen-select" disabled>
							<option value="">--</option>
						</select>

					</label>
				</p>


				<p class="form-row form-row-wide" id="project_position">
					<label for="posisi_id">POSISI/JABATAN YG DILAMAR: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Male"></i>		

						<select name="posisi_id" data-placeholder="Pilih salah satu" class="chosen-select" disabled>
							<option value="">--</option>
						</select>

					</label>
				</p>
				

                <p class="form-row form-row-wide">
					<label for="penempatan">AREA/PENEMPATAN KERJA: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Engineering"></i>
						<input type="text" class="input-text" name="penempatan" id="contact_number1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
                	<label for="bank_name">NAMA BANK: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Male"></i>		

						<select name="bank_name" data-placeholder="Pilih salah satu" class="chosen-select" style="height: 50px;padding-left: 20px;">
							<option value=""></option>
	            <option value="1">Bank OCBC NISP</option>
							<option value="2">Bank BCA</option>
							<option value="3">Bank Mandiri</option>
							<option value="4">Bank BNI</option>
							<option value="5">Bank BRI</option>
							<option value="6">Bank Danamon</option>
							<option value="7">Permata Bank</option>
							<option value="8">Bank CIMB Niaga</option>
							<option value="9">Bank BII Maybank</option>
							<option value="10">Bank Mega</option>
							<option value="11">Bank Syariah Indonesia (BSI)</option>
							<option value="14">Bank CIMB Niaga Syariah</option>
							<option value="15">Bank Muamalat</option>
							<option value="16">Bank Tabungan Negara (BTN)</option>
							<option value="17">Citibank</option>
							<option value="18">Bank Jabar dan Banten (BJB)</option>
							<option value="19">Bank DKI</option>
							<option value="20">BPD DIY</option>
							<option value="21">Bank Jateng</option>
							<option value="22">Bank Jatim</option>
							<option value="23">BPD Jambi</option>
							<option value="24">BPD Aceh, BPD Aceh Syariah</option>
							<option value="25">Bank Sumut</option>
							<option value="26">Bank Nagari</option>
							<option value="27">Bank Riau</option>
							<option value="28">Bank Sumsel Babel</option>
							<option value="29">SINARMAS</option>
						</select>

					</label>
					
				</p>

                <p class="form-row form-row-wide">
					<label for="nomor_rek">NOMOR REKENING: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Bank"></i>
						<input type="text" class="input-text" name="nomor_rek" id="contact_number1" value="" />
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="pemilik_rek">NAMA PEMILIK REKENING: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Bank"></i>
						<input type="text" class="input-text" name="pemilik_rek" id="contact_number1" value="" />
					</label>
				</p>
<br>

                <p class="form-row">
                            <fieldset class="form-group">
                              <label for="foto_ktp">FOTO KTP <strong><span style="color:red;">*</span></strong></label>
                              <input type="file" class="form-control-file" id="foto_ktp" name="foto_ktp" accept="image/png,image/jpg, image/jpeg">
                              <small>Jenis Foto: png & jpg | Size MAX 2 MB</small>
                            </fieldset>
                        </p>

                <p class="form-row">
                            <fieldset class="form-group">
                              <label for="foto_kk">FOTO KK <strong><span style="color:red;">*</span></strong></label>
                              <input type="file" class="form-control-file" id="foto_kk" name="foto_kk" accept="image/png,image/jpg, image/jpeg">
                              <small>Jenis Foto: png & jpg | Size MAX 2 MB</small>
                            </fieldset>
                        </p>

                <p class="form-row">
                            <fieldset class="form-group">
                              <label for="foto_npwp">FOTO NPWP (Jika ada) </label>
                              <input type="file" class="form-control-file" id="foto_npwp" name="foto_npwp" accept="image/png,image/jpg, image/jpeg">
                              <small>Jenis Foto: png & jpg | Size MAX 2 MB</small>
                            </fieldset>
                        </p>

                <p class="form-row">
                            <fieldset class="form-group">
                              <label for="foto_skck">FOTO SKCK (Jika ada) </label>
                              <input type="file" class="form-control-file" id="foto_skck" name="foto_skck" accept="image/png,image/jpg, image/jpeg">
                              <small>Jenis Foto: png & jpg | Size MAX 2 MB</small>
                            </fieldset>
                        </p>

                <p class="form-row">
                            <fieldset class="form-group">
                              <label for="dokumen_cv">RIWAYAT HIDUP/CV <strong><span style="color:red;">*</span></strong></label>
                              <input type="file" class="form-control-file" id="dokumen_cv" name="dokumen_cv" accept="application/pdf">
                              <small>Jenis Foto: PDF | Size MAX 2 MB</small>
                            </fieldset>
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

