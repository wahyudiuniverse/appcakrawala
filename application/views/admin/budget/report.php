<div class="container mt-4">
    <!-- CSRF hidden input -->
    <input type="hidden" id="csrf_token_name" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

    <!-- Filter Form -->
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

    <!-- Budget Table -->
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
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- jQuery Script -->
<script>
    $(document).ready(function() {
        let table = $('#budgetTable').DataTable();

        $('#btnShow').on('click', function() {
            let tahun = $('#tahun').val();
            let pt = $('#pt').val();
            let area = $('#area').val();
            let csrfName = $('#csrf_token_name').attr('name'); // nama token
            let csrfHash = $('#csrf_token_name').val(); // value token

            if (!tahun || !pt || !area) {
                alert("Semua filter wajib diisi.");
                return;
            }

            let requestData = {
                tahun: tahun,
                pt: pt,
                area: area
            };
            requestData[csrfName] = csrfHash;

            $.ajax({
                url: "<?= base_url('admin/budget/get_budget_data') ?>",
                type: "POST",
                data: requestData,
                dataType: "json",
                success: function(response) {
                    // Optional: update CSRF token
                    $('#csrf_token_name').val(response.csrf_token);

                    table.clear().draw();
                    response.data.forEach((row) => {
                        const percentage = row.target > 0 ? ((row.actual / row.target) * 100).toFixed(2) + '%' : '0%';
                        table.row.add([
                            row.id,
                            row.tahun,
                            row.pt,
                            row.area,
                            row.bulan,
                            row.target,
                            row.actual,
                            percentage
                        ]).draw(false);
                    });
                },
                error: function(xhr, status, error) {
                    alert("Gagal mengambil data.");
                    console.error(error);
                }
            });
        });
    });
</script>