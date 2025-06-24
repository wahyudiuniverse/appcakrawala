<div class="container mt-4">
    <!-- Tambahkan tombol di sini -->
    <div class="row mb-3">
        <div class="col-md-3">
            <button class="btn btn-info btn-sm" onclick="openInputDialog()">Input Invoice</button>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="tahun">Tahun</label>
                <select class="form-control" id="tahun">
                    <option value="">-- Pilih Tahun --</option>
                    <?php foreach ($tahun_list as $t): ?>
                        <option value="<?= $t->tahun ?>"><?= $t->tahun ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="pt">PT</label>
                <select class="form-control" id="pt">
                    <option value="">-- Pilih PT --</option>

                </select>
            </div>
            <div class="col-md-3">
                <label for="area">Area</label>
                <select class="form-control" id="area">
                    <option value="">-- Pilih Area --</option>

                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary" id="btnShow">Show</button>
            </div>
        </div>

        <table class="table table-bordered" id="invoiceTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nomor Invoice</th>
                    <th>Tanggal Invoice</th>
                    <th>Nilai Invoice</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

    </div>

    <?php
    // Tahun dinamis - dari 5 tahun ke belakang sampai 5 tahun ke depan
    $currentYear = (int) date('Y');
    $tahun_list = range($currentYear - 5, $currentYear + 5);

    // Cek data PT dan Area (simulasi)
    $pt_list = isset($pt_list) ? $pt_list : [];
    $area_list = isset($area_list) ? $area_list : [];
    ?>


    <!-- Modal Input Invoice -->
    <div class="modal fade" id="inputBudgetModal" tabindex="-1" aria-labelledby="inputBudgetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Invoice</h5>
                </div>
                <div class="modal-body">
                    <form id="budgetForm">
                        <input type="hidden" id="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                        <!-- Dropdown Project -->
                        <div class="form-group">
                            <label for="projectSelector">Pilih Project</label>
                            <select id="projectSelector" class="form-control" required>
                                <option value="">-- Pilih Project --</option>
                                <?php foreach ($pengajuan_list as $pengajuan): ?>
                                    <option value="<?= $pengajuan->project_id ?>">
                                        <?= $pengajuan->project_id ?> - <?= $pengajuan->area ?> (<?= $pengajuan->tahun ?>/<?= $pengajuan->periode ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Info Readonly -->
                        <div class="form-group"><label>Tahun</label><input type="text" id="modalTahun" class="form-control" readonly></div>
                        <div class="form-group"><label>PT</label><input type="text" id="modalPT" class="form-control" readonly></div>
                        <div class="form-group"><label>Area</label><input type="text" id="modalArea" class="form-control" readonly></div>
                        <div class="form-group"><label>Periode</label><input type="text" id="modalBulan" class="form-control" readonly></div>

                        <!-- Nomor SP -->
                        <div class="form-group">
                            <label for="dropdownSP">Pilih Nomor SP</label>
                            <select id="dropdownSP" class="form-control" required>
                                <option value="">-- Pilih Nomor SP --</option>
                            </select>
                        </div>

                        <!-- Auto Fill Data dari SP -->
                        <div class="form-group"><label>Jumlah PS PSB dan PDA</label><input type="text" id="modalJumlahPS" class="form-control" readonly></div>
                        <div class="form-group"><label>Total Nilai PSB & PDA</label><input type="text" id="modalPSB" class="form-control" readonly></div>
                        <div class="form-group"><label>Total Nilai Pekerjaan Lain-Lain</label><input type="text" id="modalLain" class="form-control" readonly></div>
                        <div class="form-group"><label>Total Nilai Pendapatan Di SP</label><input type="text" id="modalTarget" class="form-control" readonly></div>

                        <!-- Input Invoice -->
                        <div class="form-group"><label>Nomor Invoice</label><input type="text" id="nomorInvoice" class="form-control" required></div>
                        <div class="form-group"><label>Tanggal Invoice</label><input type="date" id="tanggalInvoice" class="form-control" required></div>
                        <div class="form-group"><label>Nilai Invoice</label><input type="text" id="nilaiInvoice" class="form-control" required></div>
                        <div class="form-group"><label>Keterangan</label><textarea id="keteranganInvoice" class="form-control" rows="3"></textarea></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="submitBudget">Submit</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modalTargetAktual2" tabindex="-1" aria-labelledby="modalTargetAktual2Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTargetAktual2Label">Input Target Aktual</h5>
                    <!-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">
                    <form id="formTargetAktual2">
                        <!-- Readonly fields (diisi otomatis) -->
                        <div class="mb-3">
                            <label for="modalTahunActual2" class="form-label">Tahun</label>
                            <input type="text" class="form-control" id="modalTahunActual2" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="modalPTActual2" class="form-label">PT</label>
                            <input type="text" class="form-control" id="modalPTActual2" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="modalAreaActual2" class="form-label">Area</label>
                            <input type="text" class="form-control" id="modalAreaActual2" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="modalBulanActual2" class="form-label">Bulan</label>
                            <input type="text" class="form-control" id="modalBulanActual2" readonly>
                        </div>

                        <!-- Input yang diisi manual oleh user -->
                        <div class="mb-3">
                            <label for="modalActual2" class="form-label">Actual</label>
                            <input type="text" class="form-control" id="modalActual2" required placeholder="Rp 0">
                        </div>
                        <div class="mb-3">
                            <label for="modalTglInvoice2" class="form-label">Tanggal Invoice</label>
                            <input type="date" class="form-control" id="modalTglInvoice2">
                        </div>
                        <div class="mb-3">
                            <label for="modalNomorInvoice2" class="form-label">Nomor Invoice</label>
                            <input type="text" class="form-control" id="modalNomorInvoice2" placeholder="Masukkan nomor invoice">
                        </div>
                        <div class="mb-3">
                            <label for="modalNomorPS2" class="form-label">Nomor PS</label>
                            <input type="text" class="form-control" id="modalNomorPS2" placeholder="Masukkan nomor PS">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button> -->
                    <button type="button" class="btn btn-primary" id="submitActual2">Simpan</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="modalTargetAktual3" tabindex="-1" aria-labelledby="modalTargetAktual3Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTargetAktual3Label">Input Target Aktual</h5>
                    <!-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">
                    <form id="formTargetAktual3">
                        <!-- Readonly fields (diisi otomatis) -->
                        <div class="mb-3">
                            <label for="modalTahunActual3" class="form-label">Tahun</label>
                            <input type="text" class="form-control" id="modalTahunActual3" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="modalPTActual3" class="form-label">PT</label>
                            <input type="text" class="form-control" id="modalPTActual3" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="modalAreaActual3" class="form-label">Area</label>
                            <input type="text" class="form-control" id="modalAreaActual3" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="modalBulanActual3" class="form-label">Bulan</label>
                            <input type="text" class="form-control" id="modalBulanActual3" readonly>
                        </div>

                        <!-- Input yang diisi manual oleh user -->
                        <div class="mb-3">
                            <label for="modalActual3" class="form-label">Actual</label>
                            <input type="text" class="form-control" id="modalActual3" required placeholder="Rp 0">
                        </div>
                        <div class="mb-3">
                            <label for="modalTglInvoice3" class="form-label">Tanggal Invoice</label>
                            <input type="date" class="form-control" id="modalTglInvoice3">
                        </div>
                        <div class="mb-3">
                            <label for="modalNomorInvoice3" class="form-label">Nomor Invoice</label>
                            <input type="text" class="form-control" id="modalNomorInvoice3" placeholder="Masukkan nomor invoice">
                        </div>
                        <div class="mb-3">
                            <label for="modalNomorPS3" class="form-label">Nomor PS</label>
                            <input type="text" class="form-control" id="modalNomorPS3" placeholder="Masukkan nomor PS">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button> -->
                    <button type="button" class="btn btn-primary" id="submitActual3">Simpan</button>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="modalDetailInvoice" tabindex="-1" role="dialog" aria-labelledby="modalDetailInvoiceLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Invoice</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nomor Invoice</th>
                                <th>Tanggal</th>
                                <th>Nomor PS</th>
                                <th>Actual</th>
                            </tr>
                        </thead>
                        <tbody id="invoiceDetailBody">
                            <!-- Data dari AJAX -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>







    <!-- Include jQuery and Bootstrap JS (Optional, for Modal functionality) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        const BASE_URL = "<?= base_url() ?>";
        const CSRF_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
        const CSRF_HASH = "<?= $this->security->get_csrf_hash(); ?>";
        // Ambil token CSRF dari elemen input yang tersembunyi
        var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';

        let csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
        let csrfHash = '<?= $this->security->get_csrf_hash(); ?>';


        // Fungsi format angka ke Rupiah (tanpa Rp untuk data mentah)
        function formatRupiah(angka, prefix = 'Rp ') {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix + rupiah;
        }

        // Format input saat user ketik
        $('#modalTarget').on('keyup', function(e) {
            let val = $(this).val();
            $(this).val(formatRupiah(val));
        });

        // Saat submit, ambil angka asli tanpa "Rp" dan titik
        function getRawNumberFromFormatted(str) {
            return str.replace(/[^0-9]/g, '');
        }



        // ketik angka di actual
        function formatRupiah(angka, prefix = 'Rp ') {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix + rupiah;
        }

        function getRawNumberFromFormatted(str) {
            return str.replace(/[^0-9]/g, '');
        }

        $('#modalActual2').on('keyup', function(e) {
            $(this).val(formatRupiah($(this).val()));
        });




        // ketik angka di actual3
        function formatRupiah(angka, prefix = 'Rp ') {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix + rupiah;
        }

        function getRawNumberFromFormatted(str) {
            return str.replace(/[^0-9]/g, '');
        }

        $('#modalActual3').on('keyup', function(e) {
            $(this).val(formatRupiah($(this).val()));
        });




        function formatRupiah(angka, prefix = 'Rp ') {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix + rupiah;
        }

        function getRawNumberFromFormatted(str) {
            return str.replace(/[^0-9]/g, '');
        }

        $('#modalPSB').on('keyup', function(e) {
            $(this).val(formatRupiah($(this).val()));
        });




        function formatRupiah(angka, prefix = 'Rp ') {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix + rupiah;
        }

        function getRawNumberFromFormatted(str) {
            return str.replace(/[^0-9]/g, '');
        }

        $('#modalLain').on('keyup', function(e) {
            $(this).val(formatRupiah($(this).val()));
        });




        // rupiah pada data table
        function formatRupiah(angka, prefix = 'Rp ') {
            let number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix + rupiah;
        }







        // Format Target sebagai Rp secara otomatis
        // $('#modalTarget').on('input', function() {
        //     let value = $(this).val();
        //     value = value.replace(/[^0-9]/g, ''); // Hanya angka yang diizinkan
        //     if (value.length > 0) {
        //         value = 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Format Rupiah
        //     }
        //     $(this).val(value);
        // });

        // $('#modalActual2').on('input', function() {
        //     let value = $(this).val();
        //     value = value.replace(/[^0-9]/g, ''); // Hanya angka yang diizinkan
        //     if (value.length > 0) {
        //         value = 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Format Rupiah
        //     }
        //     $(this).val(value);
        // });


        $('#tahun').on('change', function() {
            var tahun = $(this).val();
            if (tahun) {
                // Reset dropdown PT dan Area
                $('#pt').html('<option value="">Pilih PT</option>');
                $('#area').html('<option value="">Pilih Area</option>');

                $.ajax({
                    url: '<?= base_url("admin/budget/get_pt_list4") ?>', // pastikan URL ini benar
                    type: 'POST',
                    data: {
                        tahun: tahun,
                        <?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
                    },
                    success: function(data) {
                        var colum_pt = jQuery.parseJSON(data);
                        console.log("Data PT:", data); // Debugging data yang diterima
                        if (colum_pt && Array.isArray(colum_pt)) {
                            $.each(colum_pt, function(index, value) {
                                $('#pt').append('<option value="' + value.pt + '">' + value.pt + '</option>');
                            });
                        } else {
                            console.log("Data PT tidak valid", data);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX Error:", error); // Log error jika ada masalah dengan AJAX request
                    }
                });
            }
        });


        $('#pt').on('change', function() {
            var pt = $(this).val();

            if (pt) {
                $.ajax({
                    url: '<?= base_url("admin/budget/get_area_by_pt4") ?>',
                    type: 'POST',
                    data: {
                        pt: pt,
                        <?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'

                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#area').empty().append('<option value="">Pilih Area</option>');
                        $.each(data, function(index, value) {
                            $('#area').append('<option value="' + value.area + '">' + value.area + '</option>');
                        });
                    },
                    error: function() {
                        alert('Gagal mengambil data area.');
                    }
                });
            } else {
                $('#area').html('<option value="">Pilih Area</option>');
            }
        });


        $(document).ready(function() {
            // Inisialisasi DataTable
            let table = $('#budgetTable').DataTable();

            const namaBulan = [
                '', 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI',
                'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
            ];

            // Event listener untuk tombol Show
            $('#btnShow').on('click', function() {
                const tahun = $('#tahun').val();
                const pt = $('#pt').val();
                const area = $('#area').val();

                console.log('Filter - Tahun: ', tahun, 'PT: ', pt, 'Area: ', area); // Debug filter

                if (!tahun || !pt || !area) {
                    alert("Semua filter wajib diisi.");
                    return;
                }

                // Melakukan AJAX ke server
                $.ajax({
                    url: BASE_URL + "admin/budget/get_budget_data4",
                    type: "POST",
                    data: {
                        tahun: tahun,
                        pt: pt,
                        area: area,
                        [CSRF_NAME]: CSRF_HASH
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data); // Debug data yang diterima dari server

                        // Memastikan data adalah array dan tidak kosong
                        if (Array.isArray(data) && data.length > 0) {
                            // Proses data jika ada
                            table.clear().draw(); // Bersihkan DataTable
                            data.forEach(row => {
                                const bulanNama = namaBulan[parseInt(row.periode)] || '-';

                                // Ambil nilai, konversi ke angka
                                const psb = parseFloat(row.total_nilai_psb_dan_pda) || 0;
                                const lain = parseFloat(row.total_nilai_pekerjaan_lainlain) || 0;
                                const pendapatan = parseFloat(row.total_nilai_pendapatan_disp) || 0;

                                const totalGabungan = psb + lain;

                                // Validasi apakah total cocok
                                const isCocok = Math.abs(totalGabungan - pendapatan) < 1; // Bolehkan sedikit toleransi angka

                                // Hitung KPI jika pendapatan tidak nol
                                let kpi = 0;
                                if (pendapatan !== 0) {
                                    kpi = (totalGabungan / pendapatan) * 100;
                                }

                                // Tampilkan di konsol untuk debug
                                console.log(`Row ${row.id_pengajuan}: PSB+Lain = ${totalGabungan}, Pendapatan = ${pendapatan}, KPI = ${kpi.toFixed(2)}%`);

                                // Tambahkan ke DataTable
                                table.row.add([
                                    row.id_invoice || '-',
                                    row.tahun || '-',
                                    bulanNama,
                                    row.pt || '-',
                                    row.area || '-',
                                    row.nomor_sp || '-',
                                    row.jmlh_ps_psb_dan_pda || '-',
                                    `${kpi.toFixed(2)}%`, // Menampilkan KPI hasil hitung
                                    formatRupiah(psb),
                                    formatRupiah(lain),
                                    formatRupiah(pendapatan),

                                    //                             `<button class="btn btn-secondary btn-sm" onclick="openInputDialog3('${row.tahun}', '${row.pt}', '${row.area}', '${row.periode}')">Input Invoice</button>
                                    //  <button class="btn btn-info btn-sm" onclick="lihatInvoice('${row.tahun}', '${row.pt}', '${row.area}', '${row.periode}')">Lihat Invoice</button>`
                                ]).draw(false);

                                // Bisa juga tandai baris yang tidak cocok jika perlu
                                if (!isCocok) {
                                    console.warn(`‼️ WARNING: Total tidak sesuai pada row ID ${row.id_budget}`);
                                }
                            });

                        } else {
                            alert("Tidak ada data ditemukan.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        console.log(xhr.responseText); // Lihat isi error-nya
                        alert("Gagal mengambil data. Silakan cek konsol.");
                    }
                });
            });



            $(document).ready(function() {
                let table = $('#invoiceTable').DataTable();

                $('#btnShow').on('click', function() {
                    const tahun = $('#tahun').val();
                    const pt = $('#pt').val();
                    const area = $('#area').val();

                    if (!tahun || !pt || !area) {
                        alert("Semua filter wajib diisi.");
                        return;
                    }

                    $.ajax({
                        url: BASE_URL + "admin/budget/get_budget_data4", // Sesuaikan dengan route Anda
                        type: "POST",
                        data: {
                            tahun: tahun,
                            pt: pt,
                            area: area,
                            [CSRF_NAME]: CSRF_HASH
                        },
                        dataType: "json",
                        success: function(data) {
                            table.clear().draw();
                            data.forEach(row => {
                                table.row.add([
                                    row.id_invoice,
                                    row.nomor_invoice,
                                    row.tanggal_invoice,
                                    formatRupiah(row.nilai_invoice),
                                    row.keterangan
                                ]).draw(false);
                            });
                        },
                        error: function(xhr) {
                            console.error("Gagal ambil data:", xhr.responseText);
                        }
                    });
                });
            });


            // rupiah pada data table
            function formatRupiah(angka, prefix = 'Rp ') {
                let number_string = angka.toString().replace(/[^,\d]/g, ''),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix + rupiah;
            }


            window.openInputDialog = function() {
                $('#budgetForm')[0].reset();
                $('#inputBudgetModal').modal('show');

                $('#projectSelector').off('change').on('change', function() {
                    const projectId = $(this).val();

                    $.post('<?= base_url("admin/budget/get_pengajuan_by_projectid1") ?>', {
                        project_id: projectId,
                        <?= $this->security->get_csrf_token_name(); ?>: $('#csrf_token').val()
                    }, function(res) {
                        const data = JSON.parse(res);
                        if (data.success) {
                            $('#modalTahun').val(data.data.tahun);
                            $('#modalPT').val(data.data.pt);
                            $('#modalArea').val(data.data.area);
                            $('#modalBulan').val(data.data.periode);
                        }

                        $('#csrf_token').val(data.csrf_hash);
                    });

                    // Load SP list
                    $.post('<?= base_url("admin/budget/get_sp_by_projectid") ?>', {
                        project_id: projectId,
                        <?= $this->security->get_csrf_token_name(); ?>: $('#csrf_token').val()
                    }, function(res) {
                        const data = JSON.parse(res);
                        $('#dropdownSP').html('<option value="">-- Pilih Nomor SP --</option>');
                        data.sp_list.forEach(sp => {
                            $('#dropdownSP').append(`<option value="${sp.nomor_sp}">${sp.nomor_sp}</option>`);
                        });
                    });
                });

                $('#dropdownSP').off('change').on('change', function() {
                    const nomor_sp = $(this).val();
                    const project_id = $('#projectSelector').val();

                    $.post('<?= base_url("admin/budget/get_data_sp") ?>', {
                        project_id,
                        nomor_sp,
                        <?= $this->security->get_csrf_token_name(); ?>: $('#csrf_token').val()
                    }, function(res) {
                        const data = JSON.parse(res);
                        if (data.success) {
                            $('#modalJumlahPS').val(data.row.jmlh_ps_psb_dan_pda);
                            $('#modalPSB').val(data.row.total_nilai_psb_dan_pda);
                            $('#modalLain').val(data.row.total_nilai_pekerjaan_lainlain);
                            $('#modalTarget').val(data.row.total_nilai_pendapatan_disp);
                        }
                    });
                });

                $('#submitBudget').off('click').on('click', function() {
                    // const cleanNilaiInvoice = cleanRupiah($('#nilaiInvoice').val());
                    const nilaiInvoiceAsli = cleanRupiah($('#nilaiInvoice').val()); // HANYA ANGKA!
                    const data = {
                        project_id: $('#projectSelector').val(),
                        tahun: $('#modalTahun').val(),
                        periode: $('#modalBulan').val(),
                        pt: $('#modalPT').val(),
                        area: $('#modalArea').val(),
                        nomor_sp: $('#dropdownSP').val(),
                        jmlh_ps_psb_dan_pda: $('#modalJumlahPS').val(),
                        total_nilai_psb_dan_pda: $('#modalPSB').val(),
                        total_nilai_pekerjaan_lainlain: $('#modalLain').val(),
                        total_nilai_pendapatan_disp: $('#modalTarget').val(),
                        nomor_invoice: $('#nomorInvoice').val(),
                        tanggal_invoice: $('#tanggalInvoice').val(),
                        // nilai_invoice: $('#nilaiInvoice').val(),
                        nilai_invoice: nilaiInvoiceAsli,
                        keterangan: $('#keteranganInvoice').val(),
                        <?= $this->security->get_csrf_token_name(); ?>: $('#csrf_token').val()
                    };

                    $.post('<?= base_url("admin/budget/save_invoice_budget") ?>', data, function(res) {
                        const result = JSON.parse(res);
                        if (result.success) {
                            alert('Data invoice berhasil disimpan!');
                            $('#inputBudgetModal').modal('hide');
                        }
                    });
                });
            };


            // Format angka dengan Rp dan titik
            function formatRupiah(angka, prefix = 'Rp') {
                let number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix + ' ' + rupiah;
            }

            // Hapus Rp dan titik sebelum kirim ke server
            function cleanRupiah(value) {
                return value.replace(/[^0-9]/g, '');
            }

            // Aktifkan formatting saat input diisi
            $('#nilaiInvoice').off('keyup').on('keyup', function() {
                let value = $(this).val();
                $(this).val(formatRupiah(value));
            });



            window.openInputDialog2 = function(tahun, pt, area, bulan) {
                // Set value langsung ke input
                $('#modalTahunActual2').val(tahun);
                $('#modalPTActual2').val(pt);
                $('#modalAreaActual2').val(area);
                $('#modalBulanActual2').val(bulan);

                // Kosongkan input lainnya jika ada
                $('#modalActual2').val('');
                $('#modalTglInvoice2').val('');
                $('#modalNomorInvoice2').val('');
                $('#modalNomorPS2').val('');

                // Tampilkan modal
                $('#modalTargetAktual2').modal('show');

                // Tangani tombol submit
                $('#submitActual2').off('click').on('click', function() {
                    // let actual = $('#modalActual2').val();
                    let tgl_invoice = $('#modalTglInvoice2').val();
                    let nomor_invoice = $('#modalNomorInvoice2').val();
                    let nomor_ps = $('#modalNomorPS2').val();
                    let actualFormatted = $('#modalActual2').val();
                    let actual = getRawNumberFromFormatted(actualFormatted); // angka murni

                    // Validasi input
                    if (!actual || !tgl_invoice || !nomor_invoice || !nomor_ps) {
                        alert("Semua form harus diisi.");
                        return;
                    }

                    $.ajax({
                        url: "<?= base_url('admin/budget/add_actual_data2') ?>", // Pastikan URL sesuai dengan rute controller
                        type: "POST",
                        data: {
                            tahun: tahun,
                            pt: pt,
                            area: area,
                            bulan: bulan,
                            actual: actual,
                            tgl_invoice: tgl_invoice,
                            nomor_invoice: nomor_invoice,
                            nomor_ps: nomor_ps,
                            [csrfName]: csrfHash // Pastikan CSRF token juga disertakan jika digunakan
                        },
                        success: function(response) {
                            const res = JSON.parse(response);
                            if (res.success) {
                                alert('Data budget actual berhasil ditambahkan');
                                $('#modalTargetAktual2').modal('hide');
                                $('#btnShow').click(); // Refresh tabel jika perlu
                            } else {
                                alert('Gagal menambahkan data actual');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", error);
                            alert("Gagal menambahkan data actual.");
                        }
                    });
                });
            };



            // window.openInputDialog3 = function(tahun, pt, area, bulan) {
            //     // Set value langsung ke input
            //     $('#modalTahunActual2').val(tahun);
            //     $('#modalPTActual2').val(pt);
            //     $('#modalAreaActual2').val(area);
            //     $('#modalBulanActual2').val(bulan);

            //     // Kosongkan input lainnya jika ada
            //     $('#modalActual2').val('');
            //     $('#modalTglInvoice2').val('');
            //     $('#modalNomorInvoice2').val('');
            //     $('#modalNomorPS2').val('');

            //     // Tampilkan modal
            //     $('#modalTargetAktual3').modal('show');

            //     // Tangani tombol submit
            //     $('#submitActual3').off('click').on('click', function() {
            //         // let actual = $('#modalActual2').val();
            //         let tgl_invoice = $('#modalTglInvoice2').val();
            //         let nomor_invoice = $('#modalNomorInvoice2').val();
            //         let nomor_ps = $('#modalNomorPS2').val();
            //         let actualFormatted = $('#modalActual2').val();
            //         let actual = getRawNumberFromFormatted(actualFormatted); // angka murni

            //         // Validasi input
            //         if (!actual || !tgl_invoice || !nomor_invoice || !nomor_ps) {
            //             alert("Semua form harus diisi.");
            //             return;
            //         }

            //         $.ajax({
            //             url: "<?= base_url('admin/budget/add_actual_data3') ?>", // Pastikan URL sesuai dengan rute controller
            //             type: "POST",
            //             data: {
            //                 tahun: tahun,
            //                 pt: pt,
            //                 area: area,
            //                 bulan: bulan,
            //                 actual: actual,
            //                 tgl_invoice: tgl_invoice,
            //                 nomor_invoice: nomor_invoice,
            //                 nomor_ps: nomor_ps,
            //                 [csrfName]: csrfHash // Pastikan CSRF token juga disertakan jika digunakan
            //             },
            //             success: function(response) {
            //                 const res = JSON.parse(response);
            //                 if (res.success) {
            //                     alert('Data budget actual berhasil ditambahkan');
            //                     $('#modalTargetAktual3').modal('hide');
            //                     $('#btnShow').click(); // Refresh tabel jika perlu
            //                 } else {
            //                     alert('Gagal menambahkan data actual');
            //                 }
            //             },
            //             error: function(xhr, status, error) {
            //                 console.error("AJAX Error:", error);
            //                 alert("Gagal menambahkan data actual.");
            //             }
            //         });
            //     });
            // };




            window.openInputDialog3 = function(tahun, pt, area, bulan) {
                $('#modalTahunActual3').val(tahun);
                $('#modalPTActual3').val(pt);
                $('#modalAreaActual3').val(area);
                $('#modalBulanActual3').val(bulan);

                $('#modalActual3').val('');
                $('#modalTglInvoice3').val('');
                $('#modalNomorInvoice3').val('');
                $('#modalNomorPS3').val('');

                $('#modalTargetAktual3').modal('show');

                $('#submitActual3').off('click').on('click', function() {
                    let tgl_invoice = $('#modalTglInvoice3').val();
                    let nomor_invoice = $('#modalNomorInvoice3').val();
                    let nomor_ps = $('#modalNomorPS3').val();
                    let actualFormatted = $('#modalActual3').val();
                    let actual = getRawNumberFromFormatted(actualFormatted);

                    if (!actual || !tgl_invoice || !nomor_invoice || !nomor_ps) {
                        alert("Semua form harus diisi.");
                        return;
                    }

                    $.ajax({
                        url: "<?= base_url('admin/budget/add_actual_data3') ?>",
                        type: "POST",
                        data: {
                            tahun: tahun,
                            pt: pt,
                            area: area,
                            bulan: bulan,
                            actual: actual,
                            tgl_invoice: tgl_invoice,
                            nomor_invoice: nomor_invoice,
                            nomor_ps: nomor_ps,
                            [csrfName]: csrfHash // Pastikan csrfName dan csrfHash sesuai
                        },
                        success: function(response) {
                            const res = JSON.parse(response);
                            if (res.success) {
                                alert('Data budget actual berhasil ditambahkan');
                                $('#modalTargetAktual3').modal('hide');
                                $('#btnShow').click(); // Refresh data
                            } else {
                                alert('Gagal menambahkan data actual');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", error);
                            alert("Gagal menambahkan data actual.");
                        }
                    });
                });
            };





            window.lihatInvoice = function(tahun, pt, area, bulan) {
                $.ajax({
                    url: '<?= base_url("admin/budget/get_invoice_detail") ?>',
                    type: 'GET',
                    data: {
                        tahun: tahun,
                        pt: pt,
                        area: area,
                        bulan: bulan
                    },
                    dataType: 'json',
                    success: function(data) {
                        let html = '';
                        if (data.length > 0) {
                            data.forEach(function(item) {
                                html += `
                        <tr>
                            <td>${item.nomor_invoice}</td>
                            <td>${item.tgl_invoice}</td>
                            <td>${item.nomor_ps}</td>
                            <td>Rp ${parseInt(item.actual).toLocaleString()}</td>
                        </tr>`;
                            });
                        } else {
                            html = `<tr><td colspan="4" class="text-center">Tidak ada data invoice</td></tr>`;
                        }
                        $('#invoiceDetailBody').html(html);
                        $('#modalDetailInvoice').modal('show');
                    },
                    error: function() {
                        alert('Gagal mengambil data invoice.');
                    }
                });
            }


        });
    </script>



    <!-- button update jika ingin dipakai -->
    <!-- <button class="btn btn-secondary btn-sm" onclick="openInputDialog2('${row.tahun}', '${row.pt}', '${row.area}', '${row.bulan}')"> Invoice Update</button> -->