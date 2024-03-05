var id = 0 // Untuk menampung ID yang kaan di ubah / hapus

$(document).ready(function(){
	// Sembunyikan loading simpan, loading ubah, loading hapus, pesan error, pesan sukes, dan tombol reset
	$('#loading-simpan, #loading-ubah, #loading-hapus, #pesan-error, #pesan-sukses, #btn-reset').hide()

	// Fungsi ini akan dipanggil ketika tombol edit diklik
	$('#view').on('click', '.btn-form-ubah', function(){ // Ketika tombol dengan class btn-form-ubah pada div view di klik
		id = $(this).data('id') // Set variabel id dengan id yang kita set pada atribut data-id pada tag button edit

		$('#btn-simpan').hide() // Sembunyikan tombol simpan
		$('#btn-ubah').show() // Munculkan tombol ubah dan checkbox foto

		// Set judul modal dialog menjadi Form Ubah Data
		$('#modal-title').html('Form Ubah data')

		var tr = $(this).closest('tr') // Cari tag tr paling terdekat
		var nis = tr.find('.nis-value').val() // Ambil nis dari input type hidden
		var nama = tr.find('.nama-value').val() // Ambil nama dari input type hidden
		var jeniskelamin = tr.find('.jeniskelamin-value').val() // Ambil jenis kelamin dari input type hidden
		var telp = tr.find('.telp-value').val() // Ambil telepon dari input type hidden
		var alamat = tr.find('.alamat-value').val() // Ambil alamat dari input type hidden

		$('#nis').val(nis) // Set value dari textbox nis yang ada di form
		$('#nama').val(nama) // Set value dari textbox nama yang ada di form
		$('#jenis_kelamin').val(jeniskelamin) // Set value dari textbox nama yang ada di form
		$('#telp').val(telp) // Set value dari textbox nama yang ada di form
		$('#alamat').val(alamat) // Set value dari textbox nama yang ada di form
	})

	// Fungsi ini akan dipanggil ketika tombol hapus diklik
	$('#view').on('click', '.btn-alert-hapus', function(){ // Ketika tombol dengan class btn-alert-hapus pada div view di klik
		id = $(this).data('id') // Set variabel id dengan id yang kita set pada atribut data-id pada tag button hapus
	})

	$('#btn-tambah').click(function(){ // Ketika tombol tambah diklik
		$('#btn-ubah').hide() // Sembunyikan tombol ubah
		$('#btn-simpan').show() // Munculkan tombol simpan

		// Set judul modal dialog menjadi Form Simpan Data
		$('#modal-title').html('Form Simpan data')
	})

	$('#btn-simpan').click(function(){ // Ketika tombol simpan di klik
		$('#loading-simpan').show() // Munculkan loading simpan

		$.ajax({
			url: base_url + 'siswa/simpan', // URL tujuan
			type: 'POST', // Tentukan type nya POST atau GET
			data: $("#form-modal form").serialize(), // Ambil semua data yang ada didalam tag form
			dataType: 'json',
			beforeSend: function(e) {
				if(e && e.overrideMimeType) {
					e.overrideMimeType('application/jsoncharset=UTF-8')
				}
			},
			success: function(response){ // Ketika proses pengiriman berhasil
				$('#loading-simpan').hide() // Sembunyikan loading simpan

				if(response.status == 'sukses'){ // Jika Statusnya = sukses
					// Ganti isi dari div view dengan view yang diambil dari proses_simpan.php
					$('#view').html(response.html)

					/*
					* Ambil pesan suksesnya dan set ke div pesan-sukses
					* Lalu munculkan div pesan-sukes nya
					* Setelah 10 detik, sembunyikan kembali pesan suksesnya
					*/
					$('#pesan-sukses').html(response.pesan).fadeIn().delay(10000).fadeOut()

					$('#form-modal').modal('hide') // Close / Tutup Modal Dialog
				}else{ // Jika statusnya = gagal
					/*
					* Ambil pesan errornya dan set ke div pesan-error
					* Lalu munculkan div pesan-error nya
					*/
					$('#pesan-error').html(response.pesan).show()
				}
			},
			error: function (xhr, ajaxOptions, thrownError) { // Ketika terjadi error
				alert(xhr.responseText) // munculkan alert
			}
		})
	})

	$('#btn-ubah').click(function(){ // Ketika tombol ubah di klik
		$('#loading-ubah').show() // Munculkan loading ubah

		$.ajax({
			url: base_url + 'siswa/ubah/' + id, // URL tujuan
			type: 'POST', // Tentukan type nya POST atau GET
			data: $("#form-modal form").serialize(), // Ambil semua data yang ada didalam tag form
			dataType: 'json',
			beforeSend: function(e) {
				if(e && e.overrideMimeType) {
					e.overrideMimeType('application/jsoncharset=UTF-8')
				}
			},
			success: function(response){ // Ketika proses pengiriman berhasil
				$('#loading-ubah').hide() // Sembunyikan loading ubah

				if(response.status == 'sukses'){ // Jika Statusnya = sukses
					// Ganti isi dari div view dengan view yang diambil dari proses_ubah.php
					$('#view').html(response.html)

					/*
					* Ambil pesan suksesnya dan set ke div pesan-sukses
					* Lalu munculkan div pesan-sukes nya
					* Setelah 10 detik, sembunyikan kembali pesan suksesnya
					*/
					$('#pesan-sukses').html(response.pesan).fadeIn().delay(10000).fadeOut()

					$('#form-modal').modal('hide') // Close / Tutup Modal Dialog
				}else{ // Jika statusnya = gagal
					/*
					* Ambil pesan errornya dan set ke div pesan-error
					* Lalu munculkan div pesan-error nya
					*/
					$('#pesan-error').html(response.pesan).show()
				}
			}
		})
	})

	$('#btn-hapus').click(function(){ // Ketika tombol hapus di klik
		$('#loading-hapus').show() // Munculkan loading hapus

		$.ajax({
			url: base_url + 'siswa/hapus/' + id, // URL tujuan
			type: 'GET', // Tentukan type nya POST atau GET
			dataType: 'json',
			beforeSend: function(e) {
				if(e && e.overrideMimeType) {
					e.overrideMimeType('application/jsoncharset=UTF-8')
				}
			},
			success: function(response){ // Ketika proses pengiriman berhasil
				$('#loading-hapus').hide() // Sembunyikan loading hapus

				// Ganti isi dari div view dengan view yang diambil dari proses_hapus.php
				$('#view').html(response.html)

				/*
				* Ambil pesan suksesnya dan set ke div pesan-sukses
				* Lalu munculkan div pesan-sukes nya
				* Setelah 10 detik, sembunyikan kembali pesan suksesnya
				*/
				$('#pesan-sukses').html(response.pesan).fadeIn().delay(10000).fadeOut()

				$('#delete-modal').modal('hide') // Close / Tutup Modal Dialog
			}
		})
	})

	$('#form-modal').on('hidden.bs.modal', function (e){ // Ketika Modal Dialog di Close / tertutup
		$('#form-modal input, #form-modal select, #form-modal textarea').val('') // Clear inputan menjadi kosong
	})
})
