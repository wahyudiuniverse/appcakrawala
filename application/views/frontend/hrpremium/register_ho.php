<div class="container">

<h3 style="text-align: center;" hidden><strong><span style="color:red;">PORTAL PENGISIAN DATABASE KARYAWAN CUSSONS</span></strong></h3>
<h3 style="text-align: center;" hidden><strong><span style="color:red;">AKAN DITUTUP JUM'AT 4 AGUSTUS PUKUL 17:00 WIB</span></strong></h3>
<h3 style="text-align: center;" hidden><strong><span style="color:red;">MOHON SEGERA MENGISI DATA DIRI ANDA.</span></strong></h3>


		<a href="<?php echo site_url('ho/success/');?>" class="button" target="_blank">LIHAT DAFTAR TERSIMPAN</a>

	<div class="my-account">





			<div class="tab-content" id="tab2">

                <?php $attributes = array('id' => 'xin-form', 'class' => 'register', 'autocomplete' => 'on');?>
				<?php $hidden = array('register' => '1');?>
                <?php echo form_open('ho/tambah_kandidat/', $attributes, $hidden);?>	


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
					<label for="project_id">PROJECT:
						<i class="ln ln-icon-Male"></i>					
						<select id="project_id" name="project_id" data-placeholder="Choose Category" class="chosen-select">
						<option value="22">PT. SIPRAMA CAKRAWALA</option>
					</select>
					</label>
				</p>

                <p class="form-row form-row-wide">
					<label for="posisi_lamar">POSISI/JABATAN YG DILAMAR: <strong><span style="color:red;">*</span></strong>
						<i class="ln ln-icon-Engineering"></i>

						<select name="posisi_lamar" data-placeholder="Pilih salah satu" class="chosen-select">
								<option value="">--Pilih Salah Satu--</option>
                        <option value="15">ACCCOUNT RECIEVABLE</option>
<option value="16">ACCOUNT PAYMENT</option>
<option value="39">ADMIN AREA</option>
<option value="28">ADMIN BPJS</option>
<option value="48">ADMIN FINANCE</option>
<option value="595">ADMIN FREELANCE</option>
<option value="29">ADMIN HRD</option>
<option value="551">ADMIN LEGAL</option>
<option value="552">ADMIN MARKETING</option>
<option value="56">ADMIN OPERATIONAL</option>
<option value="22">ADMIN PAYROLL</option>
<option value="43">ADMIN PROJECT</option>
<option value="516">ADMIN TAX</option>
<option value="38">ADMIN</option>
<option value="461">APROVAL TOKEN</option>
<option value="40">AREA MANAGER</option>
<option value="7">ASSISTANT MANAGER HRD</option>
<option value="1">BOD</option>
<option value="90">CLEANING SERVICE</option>
<option value="523">FINANCE & ACCOUNTING AP</option>
<option value="37">FREELANCE</option>
<option value="32">GA </option>
<option value="26">IT  SUPPORT</option>
<option value="27">IT DESIGN OFFICER</option>
<option value="25">IT PROGRAMMER</option>
<option value="21">LEADER PAYROLL</option>
<option value="126">LEARNING AND DEVELOPMENT </option>
<option value="441">LEGAL & FIELD EXECUTIVE</option>
<option value="125">LEGAL STAFF</option>
<option value="462">MAGANG</option>
<option value="565">MANAGER SDM</option>
<option value="491">MARKETING MANAGER</option>
<option value="14">MESSANGER</option>
<option value="17">NAE ADMIN / PIC NASIONAL</option>
<option value="18">NAE ADMIN RATECARD</option>
<option value="8">NATIONAL OPERATION MANAGER</option>
<option value="274">OFFICE BOY</option>
<option value="155">PIC</option>
<option value="164">QUALITY SUPPORT</option>
<option value="36">RECEPTIONIST</option>
<option value="33">RTO </option>
<option value="208">SECURITY</option>
<option value="4">SM FINANCE</option>
<option value="2">SM HR & GA</option>
<option value="3">SM OPERASIONAL</option>
<option value="5">SM SALES & MARKETING</option>
<option value="484">SOCIAL MEDIA AND DESIGN</option>
<option value="478">SOCIAL MEDIA CONTENT CREATOR</option>
<option value="9">STAFF MARKETING</option>
<option value="24">STAFF PROCUREMENT</option>
<option value="13">TAX</option>
<option value="12">TREASURY</option>

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
						<i class="ln ln-icon-Bank"></i>
						<input type="text" class="input-text" name="bank_name" id="contact_number1" value="" />
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

