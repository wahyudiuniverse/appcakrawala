<div class="container mt-4">
    <!-- Tambahkan tombol di sini -->
    <div class="row mb-3">
        <div class="col-md-3">
            <button class="btn btn-info btn-sm" onclick="openInputDialog()">Input Target Baru</button>
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
                    <th>PT</th>
                    <th>Area</th>
                    <th>Bulan</th>
                    <th>Target</th>
                    <th>Actual</th>
                    <th>Percentage</th>
                    <th>Action</th> <!-- Kolom Action untuk tombol Input Target -->
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
                    <h5 class="modal-title" id="inputBudgetModalLabel">Input Budget Target Baru</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">
                    <form id="budgetForm">
                        <!-- Token CSRF -->
                        <input type="hidden"
                            name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>"
                            id="csrf_token">
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
                        <!-- <div class="mb-3">
                            <label for="modalPT" class="form-label">PT</label>
                            <input type="text" class="form-control" id="modalPT" required placeholder="Nama PT">
                        </div> -->

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
                            <label for="modalBulan" class="form-label">Bulan</label>
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

                        <!-- Target -->
                        <div class="mb-3">
                            <label for="modalTarget" class="form-label">Target</label>
                            <input type="number" class="form-control" id="modalTarget" required placeholder="Rp 0">
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button> -->
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
                            <input type="number" class="form-control" id="modalActual2" required placeholder="Rp 0">
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




    <script>
        // Ambil token CSRF dari elemen input yang tersembunyi
        var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrf_hash = '<?php echo $this->security->get_csrf_hash(); ?>';


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
                    url: '<?= base_url("admin/budget/get_pt_list") ?>', // pastikan URL ini benar
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
                    url: '<?= base_url("admin/budget/get_area_by_pt") ?>',
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
            let table = $('#budgetTable').DataTable();
            var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
            var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

            // Mapping angka ke nama bulan
            const namaBulan = [
                '', 'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI',
                'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
            ];


            $('#btnShow').on('click', function() {
                let tahun = $('#tahun').val();
                let pt = $('#pt').val();
                let area = $('#area').val();

                if (!tahun || !pt || !area) {
                    alert("Semua filter wajib diisi.");
                    return;
                }

                $.ajax({
                    url: "<?= base_url('admin/budget/get_budget_data') ?>",
                    type: "POST",
                    data: {
                        tahun: tahun,
                        pt: pt,
                        area: area,
                        [csrfName]: csrfHash
                    },
                    dataType: "json",
                    success: function(data) {
                        table.clear().draw();
                        data.forEach((row) => {
                            const percentage = row.target > 0 && row.actual !== null ?
                                ((row.actual / row.target) * 100).toFixed(2) + '%' :
                                '0%';

                            // Konversi angka bulan ke nama bulan
                            const bulanNama = namaBulan[parseInt(row.bulan)];

                            table.row.add([
                                row.id,
                                row.tahun,
                                row.pt,
                                row.area,
                                bulanNama,
                                row.target,
                                row.actual ?? 0,
                                percentage,
                                `
                            <button class="btn btn-secondary btn-sm" onclick="openInputDialog2('${row.tahun}', '${row.pt}', '${row.area}', '${row.bulan}')">Input Invoice</button>`


                            ]).draw(false);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        alert("Gagal mengambil data.");
                    }
                });
            });



            window.openInputDialog = function() {
                // Reset form input
                $('#modalTahun').val('');
                $('#modalPT').val('');
                $('#modalArea').val('');
                $('#modalBulan').val('');
                $('#modalTarget').val('');

                $('#inputBudgetModal').modal('show');

                $('#submitBudget').off('click').on('click', function() {
                    let tahun = $('#modalTahun').val();
                    let pt = $('#modalPT').val();
                    let area = $('#modalArea').val();
                    let bulan = $('#modalBulan').val();
                    let target = $('#modalTarget').val();

                    // CSRF token dari input hidden
                    let csrfTokenName = $('#csrf_token').attr('name');
                    let csrfTokenValue = $('#csrf_token').val();

                    if (!tahun || !pt || !area || !bulan || !target) {
                        alert("Semua form harus diisi.");
                        return;
                    }

                    // Kirim data via AJAX
                    $.ajax({
                        // url: 'http://localhost/cis_clone/admin/budget/add_budget_target',
                        url: "<?= base_url('admin/budget/add_budget_target') ?>",
                        type: 'POST',
                        data: {
                            tahun: tahun,
                            pt: pt,
                            area: area,
                            bulan: bulan,
                            target: target,
                            [csrfTokenName]: csrfTokenValue // Gunakan properti dinamis
                        },
                        success: function(response) {
                            try {
                                let res = JSON.parse(response);
                                if (res.success) {
                                    alert('Data berhasil ditambahkan');
                                    $('#inputBudgetModal').modal('hide');

                                    // Tambah tahun ke dropdown #tahun jika belum ada
                                    let existingOption = $('#tahun option[value="' + tahun + '"]');
                                    if (existingOption.length === 0) {
                                        $('#tahun').append(`<option value="${tahun}">${tahun}</option>`);
                                    }

                                    // Perbarui CSRF token jika diberikan oleh server
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
                            alert('Terjadi kesalahan saat kirim data.');
                        }
                    });
                });
            };

            //     $('#submitBudget').off('click').on('click', function() {
            //         let tahun = $('#modalTahun').val();
            //         let pt = $('#modalPT').val();
            //         let area = $('#modalArea').val();
            //         let bulan = $('#modalBulan').val();
            //         let target = $('#modalTarget').val();

            //         if (!tahun || !pt || !area || !bulan || !target) {
            //             alert("Semua form harus diisi.");
            //             return;
            //         }

            //         // Kirim data ke controller untuk menambah data baru
            //         $.ajax({
            //             url: "<?= base_url('admin/budget/add_budget_target') ?>",
            //             type: "POST",
            //             data: {
            //                 tahun: tahun,
            //                 pt: pt,
            //                 area: area,
            //                 bulan: bulan,
            //                 target: target,
            //                 [csrfName]: csrfHash
            //             },
            //             success: function(response) {
            //                 if (response.success) {
            //                     alert('Data budget target berhasil ditambahkan');
            //                     $('#inputBudgetModal').modal('hide');
            //                     $('#btnShow').click(); // Refresh data
            //                 } else {
            //                     alert('Data budget target berhasil ditambahkan');
            //                 }
            //             },
            //             error: function(xhr, status, error) {
            //                 console.error("AJAX Error:", error);
            //                 alert("Gagal menambahkan data target.");
            //             }
            //         });
            //     });
            // };



            // // Menampilkan dialog input target
            // window.openInputDialog1 = function() {
            //     // Reset form
            //     $('#modalTahunActual').val('');
            //     $('#modalPTActual').val('');
            //     $('#modalAreaActual').val('');
            //     $('#modalBulanActual').val('');
            //     $('#modalActual').val('');
            //     $('#modalTglInvoice').val('');
            //     $('#modalNomorInvoice').val('');
            //     $('#modalNomorPS').val('');

            //     $('#inputActualModal').modal('show');

            //     $('#submitActual').off('click').on('click', function() {
            //         let tahun = $('#modalTahunActual').val();
            //         let pt = $('#modalPTActual').val();
            //         let area = $('#modalAreaActual').val();
            //         let bulan = $('#modalBulanActual').val();
            //         let actual = $('#modalActual').val();
            //         let tgl_invoice = $('#modalTglInvoice').val();
            //         let nomor_invoice = $('#modalNomorInvoice').val();
            //         let nomor_ps = $('#modalNomorPS').val();

            //         if (!tahun || !pt || !area || !bulan || !actual || !tgl_invoice || !nomor_invoice || !nomor_ps) {
            //             alert("Semua form harus diisi.");
            //             return;
            //         }

            //         // Kirim data ke controller untuk menambah data baru
            //         $.ajax({
            //             url: "<?= base_url('admin/budget/add_actual_data') ?>",
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
            //                 [csrfName]: csrfHash
            //             },
            //             success: function(response) {
            //                 if (response.success) {
            //                     alert('Data budget actual berhasil ditambahkan');
            //                     $('#inputActualModal').modal('hide');
            //                     $('#btnShow').click(); // Refresh data
            //                 } else {
            //                     alert('Data budget actual berhasil ditambahkan');
            //                 }
            //             },
            //             error: function(xhr, status, error) {
            //                 console.error("AJAX Error:", error);
            //                 alert("Gagal menambahkan data actual.");
            //             }
            //         });
            //     });
            // };


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
                    let actual = $('#modalActual2').val();
                    let tgl_invoice = $('#modalTglInvoice2').val();
                    let nomor_invoice = $('#modalNomorInvoice2').val();
                    let nomor_ps = $('#modalNomorPS2').val();

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



        });
    </script>