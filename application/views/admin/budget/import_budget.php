<!-- Tambahkan link CSS DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<div class="container mt-4">
    <h4>Laporan Budget</h4>

    <div class="row mb-3">
        <!-- Dropdown Tahun -->
        <div class="col-md-3">
            <label for="tahun">Tahun</label>
            <select class="form-control" id="tahun">
                <option value="">-- Pilih Tahun --</option>
                <?php foreach ($tahun_list as $tahun): ?>
                    <option value="<?= $tahun->tahun ?>"><?= $tahun->tahun ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Dropdown PT -->
        <div class="col-md-3">
            <label for="nama_pt">Nama PT</label>
            <select class="form-control" id="nama_pt">
                <option value="">-- Pilih PT --</option>
                <?php foreach ($pt_list as $pt): ?>
                    <option value="<?= $pt->id ?>"><?= $pt->pt ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Dropdown Area -->
        <div class="col-md-3">
            <label for="area">Area</label>
            <select class="form-control" id="area">
                <option value="">-- Pilih Area --</option>
                <?php foreach ($area_list as $area): ?>
                    <option value="<?= $area->id ?>"><?= $area->area ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Tombol Show -->
        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary" id="btnShow">Show</button>
        </div>
    </div>

    <!-- Tempat hasil -->
    <div id="result" class="mt-4"></div>
</div>

<!-- CSRF Token -->
<script>
    const csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
    const csrfHash = '<?= $this->security->get_csrf_hash(); ?>';
</script>

<!-- JQuery & DataTables -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    document.getElementById('btnShow').addEventListener('click', function() {
        const tahun = document.getElementById('tahun').value;
        const pt = document.getElementById('nama_pt').value;
        const area = document.getElementById('area').value;

        if (!tahun || !pt || !area) {
            alert("Mohon isi semua filter terlebih dahulu.");
            return;
        }

        const formData = new URLSearchParams();
        formData.append(csrfName, csrfHash);
        formData.append('tahun', tahun);
        formData.append('pt', pt);
        formData.append('area', area);

        fetch("<?= base_url('admin/budget/get_budget_report') ?>", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if ($.fn.DataTable.isDataTable('#tableBudget')) {
                    $('#tableBudget').DataTable().destroy();
                }

                let html = `
            <table id="tableBudget" class="display table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Target</th>
                        <th>Actual</th>
                        <th>Selisih</th>
                    </tr>
                </thead>
                <tbody>
        `;

                const bulanList = [
                    "", "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ];

                if (data.length === 0) {
                    html += `<tr><td colspan="4" class="text-center">Data tidak ditemukan.</td></tr>`;
                } else {
                    data.forEach(row => {
                        const target = parseInt(row.target) || 0;
                        const actual = parseInt(row.actual) || 0;
                        const selisih = target - actual;

                        html += `<tr>
                    <td>${bulanList[row.bulan]}</td>
                    <td>${target.toLocaleString('id-ID')}</td>
                    <td>${actual.toLocaleString('id-ID')}</td>
                    <td>${selisih.toLocaleString('id-ID')}</td>
                </tr>`;
                    });
                }

                html += `</tbody></table>`;
                document.getElementById('result').innerHTML = html;

                // Inisialisasi DataTable
                $('#tableBudget').DataTable();
            })
            .catch(err => {
                console.error(err);
                alert("Terjadi kesalahan saat memuat data.");
            });
    });
</script>