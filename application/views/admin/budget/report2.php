<div class="container mt-4">
    <!-- Tambahkan tombol di sini -->
    <div class="row mb-3">
        <div class="col-md-3">
            <button class="btn btn-info btn-sm" onclick="openInputDialog()">Input Pengajuan</button>
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

        <table class="table table-bordered" id="budgetTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tahun</th>
                    <th>Periode/Bulan</th>
                    <th>PT</th>
                    <th>Area</th>
                    <th>Project ID</th>
                    <th>Jumlah PS(PSB & PDA)</th>
                    <th>KPI (%)</th>
                    <th>Total Nilai PSB & PDA (Rp)</th>
                    <th>Total Nilai Pekerjaan Lain-Lain (Rp)</th>
                    <th>Total Nilai Pendapatan di Pengajuan</th>
                    <!-- <th>Nomor SP</th>
                    <th>Total Pendapatan SP</th>
                    <th>Nomor Invoice</th>
                    <th>Tanggal Invoice</th>
                    <th>Nilai Invoice</th> -->
                    <!-- <th>PT</th>
                    <th>Area</th> -->
                    <!-- <th>Keterangan</th> -->
                    <th>Opsi</th>
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


    <!-- Modal Dialog Input Budget Target -->
    <div class="modal fade" id="inputBudgetModal" tabindex="-1" aria-labelledby="inputBudgetModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputBudgetModalLabel">Input Pengajuan</h5>
                </div>
                <div class="modal-body">
                    <form id="budgetForm">
                        <!-- Token CSRF -->
                        <input type="hidden"
                            name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>" id="csrf_token">

                        <!-- Tahun -->
                        <div class="mb-3">
                            <label for="modalTahun" class="form-label">Tahun</label>
                            <select class="form-control" id="modalTahun" required>
                                <option value="">-- Pilih Tahun --</option>
                                <?php foreach ($tahun_list as $tahun): ?>
                                    <option value="<?= $tahun ?>"><?= $tahun ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- PT -->
                        <div class="mb-3">
                            <label for="modalPT" class="form-label">PT</label>
                            <select class="form-control" id="modalPT" required>
                                <option value="">-- Pilih PT --</option>
                                <?php if (!empty($pt_list)) : ?>
                                    <?php foreach ($pt_list as $pt): ?>
                                        <option value="<?= $pt->name ?>"><?= $pt->name ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">Data PT tidak tersedia</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Area -->
                        <div class="mb-3">
                            <label for="modalArea" class="form-label">Area</label>
                            <input type="text" class="form-control" id="modalArea" required placeholder="Nama Area">
                        </div>

                        <!-- Bulan -->
                        <div class="mb-3">
                            <label for="modalBulan" class="form-label">Periode/Bulan</label>
                            <select class="form-control" id="modalBulan" required>
                                <option value="">-- Pilih Bulan --</option>
                                <?php
                                $bulan_list = [
                                    '01' => 'Januari',
                                    '02' => 'Februari',
                                    '03' => 'Maret',
                                    '04' => 'April',
                                    '05' => 'Mei',
                                    '06' => 'Juni',
                                    '07' => 'Juli',
                                    '08' => 'Agustus',
                                    '09' => 'September',
                                    '10' => 'Oktober',
                                    '11' => 'November',
                                    '12' => 'Desember'
                                ];
                                foreach ($bulan_list as $key => $value): ?>
                                    <option value="<?= $key ?>"><?= $value ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Project ID -->
                        <div class="mb-3">
                            <label for="modalProjectId" class="form-label">Project ID</label>
                            <input type="text" class="form-control" id="modalProjectId" required placeholder="ID Project">
                        </div>

                        <!-- Jumlah PS PSB dan PDA -->
                        <div class="mb-3">
                            <label for="modalJumlahPS" class="form-label">Jumlah PS PSB dan PDA</label>
                            <input type="text" class="form-control" id="modalJumlahPS" required placeholder="Jumlah PS PSB dan PDA">
                        </div>

                        <!-- Total Nilai PSB & PDA -->
                        <div class="mb-3">
                            <label for="modalPSB" class="form-label">Total Nilai PSB & PDA (Rp)</label>
                            <input type="text" class="form-control" id="modalPSB" required placeholder="Rp 0">
                        </div>

                        <!-- Total Nilai Pekerjaan Lain-Lain -->
                        <div class="mb-3">
                            <label for="modalLain" class="form-label">Total Nilai Pekerjaan Lain-Lain (Rp)</label>
                            <input type="text" class="form-control" id="modalLain" required placeholder="Rp 0">
                        </div>
                        <!-- Target -->
                        <div class="mb-3">
                            <label for="modalTarget" class="form-label">Total Nilai Pendapatan Dipengajuan</label>
                            <input type="text" class="form-control" id="modalTarget" required placeholder="Rp 0">
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
                    url: '<?= base_url("admin/budget/get_pt_list2") ?>', // pastikan URL ini benar
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
                    url: '<?= base_url("admin/budget/get_area_by_pt2") ?>',
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
                    url: BASE_URL + "admin/budget/get_budget_data2",
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
                                const pendapatan = parseFloat(row.total_nilai_pendapatan_dipengajuan) || 0;

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
                                    row.id_pengajuan || '-',
                                    row.tahun || '-',
                                    bulanNama,
                                    row.pt || '-',
                                    row.area || '-',
                                    row.project_id || '-',
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

                            //         data.forEach(row => {
                            //             const bulanNama = namaBulan[parseInt(row.periode)] || '-';
                            //             table.row.add([
                            //                 row.id_budget || '-',
                            //                 row.tahun || '-',
                            //                 bulanNama,
                            //                 row.project_id || '-',
                            //                 row.jmlh_ps_psb_dan_pda || '-',
                            //                 row.kpi || '0',
                            //                 formatRupiah(row.total_nilai_psb_dan_pda || 0),
                            //                 formatRupiah(row.total_nilai_pekerjaan_lainlain || 0),
                            //                 formatRupiah(row.total_nilai_pendapatan_dipengajuan || 0),
                            //                 // row.nomor_sp || '-',
                            //                 // formatRupiah(row.total_pendapatan_sp || 0),
                            //                 // row.nomor_invoice || '-',
                            //                 // row.tanggal_invoice || '-',
                            //                 // formatRupiah(row.nilai_invoice || 0),
                            //                 row.pt || '-',
                            //                 row.area || '-',
                            //                 // row.keterangan || '-',
                            //                 `<button class="btn btn-secondary btn-sm" onclick="openInputDialog3('${row.tahun}', '${row.pt}', '${row.area}', '${row.periode}')">Input Invoice</button>
                            //  <button class="btn btn-info btn-sm" onclick="lihatInvoice('${row.tahun}', '${row.pt}', '${row.area}', '${row.periode}')">Lihat Invoice</button>`
                            //             ]).draw(false);
                            //         });
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


            window.openInputDialog = function() {
                // Reset form
                $('#modalTahun, #modalPT, #modalArea, #modalBulan, #modalTarget, #modalPSB, #modalLain, #modalJumlahPS, #modalProjectId', ).val('');

                $('#inputBudgetModal').modal('show');

                $('#submitBudget').off('click').on('click', function() {
                    let tahun = $('#modalTahun').val();
                    let pt = $('#modalPT').val();
                    let area = $('#modalArea').val();
                    let periode = $('#modalBulan').val();
                    let projectID = $('#modalProjectId').val(); // sesuai ID input
                    let jumlahPS = $('#modalJumlahPS').val(); // Ambil Jumlah PS PSB dan PDA
                    let total_nilai_psb_dan_pda = getRawNumberFromFormatted($('#modalPSB').val());
                    let total_nilai_pekerjaan_lainlain = getRawNumberFromFormatted($('#modalLain').val());
                    let total_nilai_pendapatan_dipengajuan = getRawNumberFromFormatted($('#modalTarget').val());

                    // CSRF
                    let csrfTokenName = $('#csrf_token').attr('name');
                    let csrfTokenValue = $('#csrf_token').val();

                    // Periksa jika ada field yang kosong
                    if (!tahun || !pt || !area || !periode || !total_nilai_pendapatan_dipengajuan || !projectID || !jumlahPS || !total_nilai_pekerjaan_lainlain || !total_nilai_psb_dan_pda) {
                        alert("Semua form wajib diisi.");
                        return;
                    }

                    // Kirim data via AJAX
                    $.ajax({
                        url: "<?= base_url('admin/budget/add_budget_target2') ?>",
                        type: 'POST',
                        data: {
                            tahun,
                            pt,
                            area,
                            periode,
                            project_id: projectID,
                            jmlh_ps_psb_dan_pda: jumlahPS, // Kirim jumlah PS PSB dan PDA
                            total_nilai_psb_dan_pda,
                            total_nilai_pekerjaan_lainlain,
                            total_nilai_pendapatan_dipengajuan,
                            [csrfTokenName]: csrfTokenValue
                        },
                        success: function(response) {
                            try {
                                let res = JSON.parse(response);
                                if (res.success) {
                                    alert('Data berhasil ditambahkan');
                                    $('#inputBudgetModal').modal('hide');

                                    // Tambah tahun ke dropdown jika belum ada
                                    if ($('#tahun option[value="' + tahun + '"]').length === 0) {
                                        $('#tahun').append(`<option value="${tahun}">${tahun}</option>`);
                                    }

                                    // Update CSRF
                                    if (res.csrf_hash) {
                                        $('#csrf_token').val(res.csrf_hash);
                                    }
                                } else {
                                    alert('Gagal: ' + res.message);
                                }
                            } catch (e) {
                                console.error('Respon bukan JSON valid:', response);
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                            alert('Terjadi kesalahan saat mengirim data.');
                        }
                    });
                });
            };




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