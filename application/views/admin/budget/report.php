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
                <?php foreach ($pt_list as $p): ?>
                    <option value="<?= $p->pt ?>"><?= $p->pt ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="area">Area</label>
            <select class="form-control" id="area">
                <option value="">-- Pilih Area --</option>
                <?php foreach ($area_list as $a): ?>
                    <option value="<?= $a->area ?>"><?= $a->area ?></option>
                <?php endforeach; ?>
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

<!-- Modal Dialog Input Budget Target -->
<div class="modal fade" id="inputBudgetModal" tabindex="-1" aria-labelledby="inputBudgetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inputBudgetModalLabel">Input Budget Target Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="budgetForm">
                    <div class="mb-3">
                        <label for="modalTahun" class="form-label">Tahun</label>
                        <input type="text" class="form-control" id="modalTahun" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalPT" class="form-label">PT</label>
                        <input type="text" class="form-control" id="modalPT" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalArea" class="form-label">Area</label>
                        <input type="text" class="form-control" id="modalArea" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalBulan" class="form-label">Bulan</label>
                        <input type="text" class="form-control" id="modalBulan" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalTarget" class="form-label">Target</label>
                        <input type="number" class="form-control" id="modalTarget" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitBudget">Submit</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Dialog Input Data Aktual -->
<div class="modal fade" id="inputActualModal" tabindex="-1" aria-labelledby="inputActualModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inputActualModalLabel">Input Data Aktual Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="actualForm">
                    <div class="mb-3">
                        <label for="modalTahunActual" class="form-label">Tahun</label>
                        <input type="text" class="form-control" id="modalTahunActual" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalPTActual" class="form-label">PT</label>
                        <input type="text" class="form-control" id="modalPTActual" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalAreaActual" class="form-label">Area</label>
                        <input type="text" class="form-control" id="modalAreaActual" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalBulanActual" class="form-label">Bulan</label>
                        <input type="text" class="form-control" id="modalBulanActual" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalActual" class="form-label">Actual</label>
                        <input type="number" class="form-control" id="modalActual" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalTglInvoice" class="form-label">Tanggal Invoice</label>
                        <input type="date" class="form-control" id="modalTglInvoice" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalNomorInvoice" class="form-label">Nomor Invoice</label>
                        <input type="text" class="form-control" id="modalNomorInvoice" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalNomorPS" class="form-label">Nomor PS</label>
                        <input type="text" class="form-control" id="modalNomorPS" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitActual">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let table = $('#budgetTable').DataTable();
        var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

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

                        table.row.add([
                            row.id,
                            row.tahun,
                            row.pt,
                            row.area,
                            row.bulan,
                            row.target,
                            row.actual ?? 0,
                            percentage,
                            `<button class="btn btn-info btn-sm" onclick="openInputDialog()">Input Target Baru</button>
                            <button class="btn btn-secondary btn-sm" onclick="openInputDialog1()">Input Target Actual</button>`


                        ]).draw(false);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    alert("Gagal mengambil data.");
                }
            });
        });

        // Menampilkan dialog input target
        window.openInputDialog = function() {
            // Reset form
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

                if (!tahun || !pt || !area || !bulan || !target) {
                    alert("Semua form harus diisi.");
                    return;
                }

                // Kirim data ke controller untuk menambah data baru
                $.ajax({
                    url: "<?= base_url('admin/budget/add_budget_target') ?>",
                    type: "POST",
                    data: {
                        tahun: tahun,
                        pt: pt,
                        area: area,
                        bulan: bulan,
                        target: target,
                        [csrfName]: csrfHash
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Data budget target berhasil ditambahkan');
                            $('#inputBudgetModal').modal('hide');
                            $('#btnShow').click(); // Refresh data
                        } else {
                            alert('Data budget target berhasil ditambahkan');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        alert("Gagal menambahkan data target.");
                    }
                });
            });
        };



        // Menampilkan dialog input target
        window.openInputDialog1 = function() {
            // Reset form
            $('#modalTahunActual').val('');
            $('#modalPTActual').val('');
            $('#modalAreaActual').val('');
            $('#modalBulanActual').val('');
            $('#modalActual').val('');
            $('#modalTglInvoice').val('');
            $('#modalNomorInvoice').val('');
            $('#modalNomorPS').val('');

            $('#inputActualModal').modal('show');

            $('#submitBudget').off('click').on('click', function() {
                let tahun = $('#modalTahunActual').val();
                let pt = $('#modalPTActual').val();
                let area = $('#modalAreaActual').val();
                let bulan = $('#modalBulanActual').val();
                let actual = $('#modalActual').val();
                let tgl_invoice = $('#modalTglInvoice').val();
                let nomor_invoice = $('#modalNomorInvoice').val();
                let nomor_ps = $('#modalNomorPS').val();

                if (!tahun || !pt || !area || !bulan || !actual || !tgl_invoice || !nomor_invoice || !nomor_ps) {
                    alert("Semua form harus diisi.");
                    return;
                }

                // Kirim data ke controller untuk menambah data baru
                $.ajax({
                    url: "<?= base_url('admin/budget/add_actual_data') ?>",
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
                        [csrfName]: csrfHash
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Data budget actual berhasil ditambahkan');
                            $('#inputActualModal').modal('hide');
                            $('#btnShow').click(); // Refresh data
                        } else {
                            alert('Data budget actual berhasil ditambahkan');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                        alert("Gagal menambahkan data actual.");
                    }
                });
            });
        };


        // function openInputActualDialog() {
        //     // Reset form
        //     $('#modalTahunActual').val('');
        //     $('#modalPTActual').val('');
        //     $('#modalAreaActual').val('');
        //     $('#modalBulanActual').val('');
        //     $('#modalActual').val('');
        //     $('#modalTglInvoice').val('');
        //     $('#modalNomorInvoice').val('');
        //     $('#modalNomorPS').val('');

        //     // Tampilkan modal
        //     $('#inputActualModal').modal('show');

        //     // Tangani klik tombol Submit
        //     $('#submitActual').off('click').on('click', function() {
        //         let tahun = $('#modalTahunActual').val();
        //         let pt = $('#modalPTActual').val();
        //         let area = $('#modalAreaActual').val();
        //         let bulan = $('#modalBulanActual').val();
        //         let actual = $('#modalActual').val();
        //         let tglInvoice = $('#modalTglInvoice').val();
        //         let nomorInvoice = $('#modalNomorInvoice').val();
        //         let nomorPS = $('#modalNomorPS').val();

        //         // Validasi input
        //         if (!tahun || !pt || !area || !bulan || !actual || !tglInvoice || !nomorInvoice || !nomorPS) {
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
        //                 tgl_invoice: tglInvoice,
        //                 nomor_invoice: nomorInvoice,
        //                 nomor_ps: nomorPS,
        //                 [csrfName]: csrfHash
        //             },
        //             success: function(response) {
        //                 if (response.success) {
        //                     alert('Data aktual berhasil ditambahkan');
        //                     $('#inputActualModal').modal('hide');
        //                     $('#btnShow').click(); // Refresh data
        //                 } else {
        //                     alert('Gagal menambahkan data aktual');
        //                 }
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error("AJAX Error:", error);
        //                 alert("Gagal menambahkan data aktual.");
        //             }
        //         });
        //     });
        // }


    });
</script>