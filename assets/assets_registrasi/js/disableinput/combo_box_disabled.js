function enabledisabletext() {
	if (document.formkaryawan.statusnikah.value == 'Single') {
		document.formkaryawan.nik_istri_suami.disabled = true;
		document.formkaryawan.nama_istri_suami.disabled = true;
		document.formkaryawan.tempat_lahir_istri_suami.disabled = true;
		document.formkaryawan.tanggal_lahir_istri_suami.disabled = true;
		document.formkaryawan.nik_anak1.disabled = true;
		document.formkaryawan.nama_anak1.disabled = true;
		document.formkaryawan.tempat_lahir_anak1.disabled = true;
		document.formkaryawan.tanggal_lahir_anak1.disabled = true;
		document.formkaryawan.jenis_kelamin_anak1.disabled = true;
		document.formkaryawan.nik_anak2.disabled = true;
		document.formkaryawan.nama_anak2.disabled = true;
		document.formkaryawan.tempat_lahir_anak2.disabled = true;
		document.formkaryawan.tanggal_lahir_anak2.disabled = true;
		document.formkaryawan.jenis_kelamin_anak2.disabled = true;
		document.formkaryawan.nik_anak3.disabled = true;
		document.formkaryawan.nama_anak3.disabled = true;
		document.formkaryawan.tempat_lahir_anak3.disabled = true;
		document.formkaryawan.tanggal_lahir_anak3.disabled = true;
		document.formkaryawan.jenis_kelamin_anak3.disabled = true;
		document.formkaryawan.nomor_jkn_istri_suami.disabled = true;
		document.formkaryawan.nomor_jkn_anak1.disabled = true;
		document.formkaryawan.nomor_jkn_anak2.disabled = true;
		document.formkaryawan.nomor_jkn_anak3.disabled = true;
	}

	if (document.formkaryawan.statusnikah.value == 'Menikah') {
		document.formkaryawan.nik_istri_suami.disabled = false;
		document.formkaryawan.nama_istri_suami.disabled = false;
		document.formkaryawan.tempat_lahir_istri_suami.disabled = false;
		document.formkaryawan.tanggal_lahir_istri_suami.disabled = false;
		document.formkaryawan.nik_anak1.disabled = false;
		document.formkaryawan.nama_anak1.disabled = false;
		document.formkaryawan.tempat_lahir_anak1.disabled = false;
		document.formkaryawan.tanggal_lahir_anak1.disabled = false;
		document.formkaryawan.jenis_kelamin_anak1.disabled = false;
		document.formkaryawan.nik_anak2.disabled = false;
		document.formkaryawan.nama_anak2.disabled = false;
		document.formkaryawan.tempat_lahir_anak2.disabled = false;
		document.formkaryawan.tanggal_lahir_anak2.disabled = false;
		document.formkaryawan.jenis_kelamin_anak2.disabled = false;
		document.formkaryawan.nik_anak3.disabled = false;
		document.formkaryawan.nama_anak3.disabled = false;
		document.formkaryawan.tempat_lahir_anak3.disabled = false;
		document.formkaryawan.tanggal_lahir_anak3.disabled = false;
		document.formkaryawan.jenis_kelamin_anak3.disabled = false;
		document.formkaryawan.nomor_jkn_istri_suami.disabled = false;
		document.formkaryawan.nomor_jkn_anak1.disabled = false;
		document.formkaryawan.nomor_jkn_anak2.disabled = false;
		document.formkaryawan.nomor_jkn_anak3.disabled = false;
	}

	if (document.formkaryawan.statusnikah.value == 'Janda') {
		document.formkaryawan.nik_istri_suami.disabled = true;
		document.formkaryawan.nama_istri_suami.disabled = true;
		document.formkaryawan.tempat_lahir_istri_suami.disabled = true;
		document.formkaryawan.tanggal_lahir_istri_suami.disabled = true;
		document.formkaryawan.nik_anak1.disabled = false;
		document.formkaryawan.nama_anak1.disabled = false;
		document.formkaryawan.tempat_lahir_anak1.disabled = false;
		document.formkaryawan.tanggal_lahir_anak1.disabled = false;
		document.formkaryawan.jenis_kelamin_anak1.disabled = false;
		document.formkaryawan.nik_anak2.disabled = false;
		document.formkaryawan.nama_anak2.disabled = false;
		document.formkaryawan.tempat_lahir_anak2.disabled = false;
		document.formkaryawan.tanggal_lahir_anak2.disabled = false;
		document.formkaryawan.jenis_kelamin_anak2.disabled = false;
		document.formkaryawan.nik_anak3.disabled = false;
		document.formkaryawan.nama_anak3.disabled = false;
		document.formkaryawan.tempat_lahir_anak3.disabled = false;
		document.formkaryawan.tanggal_lahir_anak3.disabled = false;
		document.formkaryawan.jenis_kelamin_anak3.disabled = false;
		document.formkaryawan.nomor_jkn_istri_suami.disabled = true;
		document.formkaryawan.nomor_jkn_anak1.disabled = false;
		document.formkaryawan.nomor_jkn_anak2.disabled = false;
		document.formkaryawan.nomor_jkn_anak3.disabled = false;
	}

	if (document.formkaryawan.statusnikah.value == 'Duda') {
		document.formkaryawan.nik_istri_suami.disabled = true;
		document.formkaryawan.nama_istri_suami.disabled = true;
		document.formkaryawan.tempat_lahir_istri_suami.disabled = true;
		document.formkaryawan.tanggal_lahir_istri_suami.disabled = true;
		document.formkaryawan.nik_anak1.disabled = false;
		document.formkaryawan.nama_anak1.disabled = false;
		document.formkaryawan.tempat_lahir_anak1.disabled = false;
		document.formkaryawan.tanggal_lahir_anak1.disabled = false;
		document.formkaryawan.jenis_kelamin_anak1.disabled = false;
		document.formkaryawan.nik_anak2.disabled = false;
		document.formkaryawan.nama_anak2.disabled = false;
		document.formkaryawan.tempat_lahir_anak2.disabled = false;
		document.formkaryawan.tanggal_lahir_anak2.disabled = false;
		document.formkaryawan.jenis_kelamin_anak2.disabled = false;
		document.formkaryawan.nik_anak3.disabled = false;
		document.formkaryawan.nama_anak3.disabled = false;
		document.formkaryawan.tempat_lahir_anak3.disabled = false;
		document.formkaryawan.tanggal_lahir_anak3.disabled = false;
		document.formkaryawan.jenis_kelamin_anak3.disabled = false;
		document.formkaryawan.nomor_jkn_istri_suami.disabled = true;
		document.formkaryawan.nomor_jkn_anak1.disabled = false;
		document.formkaryawan.nomor_jkn_anak2.disabled = false;
		document.formkaryawan.nomor_jkn_anak3.disabled = false;
	}
}