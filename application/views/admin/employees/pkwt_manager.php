<?php
/* Profile view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>

<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>

<!-- Menampilkan Pesan error (kalau ada) -->
<?php if ($pesan_error) : ?>
  <script type='text/javascript'>
    alert("<?php echo $pesan_error; ?>");
    //confirm("<?php echo $pesan_error; ?>");
  </script>;
<?php endif; ?>

<div class="card mb-4">
  <!-- Section Data PKWT -->
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>DATA PKWT/TKHL </strong> - <?php echo $employee[0]->first_name; ?><?php echo $lihat_pkwt; ?></span>
    <div class="card-header-elements ml-md-auto"> </div>
  </div>
  <div id="add_form" class="add-form <?php echo $get_animate; ?>" data-parent="#accordion" style="">
    <div class="card-body">
      <?php $attributes = array('name' => 'add_employee', 'id' => 'xin-form', 'autocomplete' => 'off'); ?>
      <?php $hidden = array('_user' => $session['user_id']); ?>
      <?php echo form_open_multipart('#', $attributes, $hidden); ?>
      <div class="form-body">
        <div class="row">

          <div class="col-md-4">
            <!-- Variabel hidden-->
            <input hidden name="contract_id" id="contract_id" type="text" value="<?php echo $pkwt[0]->contract_id; ?>">
            <input hidden name="emp_id" id="emp_id" type="text" value="<?php echo $employee[0]->user_id; ?>">

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input readonly class="form-control" placeholder="Nama Lengkap" name="nama" type="text" value="<?php echo $employee[0]->first_name; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">NIP di PKWT/TKHL</label>
                  <input readonly class="form-control" placeholder="NIP" name="nip" id="nip" type="text" value="<?php echo $pkwt[0]->employee_id; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Alamat KTP</label>
                  <textarea readonly class="form-control" rows="4" wrap="hard"><?php echo $employee[0]->alamat_ktp; ?></textarea>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Project di PKWT/TKHL</label>
                  <input readonly class="form-control" placeholder="Project" name="project" type="text" value="<?php echo $nama_project; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Sub Project di PKWT/TKHL</label>
                  <input readonly class="form-control" placeholder="Sub Project" name="sub_project" type="text" value="<?php echo $nama_sub_project; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Jabatan di PKWT/TKHL</label>
                  <input readonly class="form-control" placeholder="Jabatan" name="jabatan" type="text" value="<?php echo $designation_name; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Penempatan di PKWT/TKHL</label>
                  <input readonly class="form-control" placeholder="Penempatan" name="penempatan" type="text" value="<?php echo $pkwt[0]->penempatan; ?>">
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Nomor PKWT/TKHL</label>
                  <input readonly class="form-control" placeholder="Nomor PKWT" name="pkwt_number" type="text" value="<?php echo $pkwt[0]->no_surat; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Tanggal PKWT/TKHL</label>
                  <input readonly class="form-control" placeholder="Sub Project" name="sub_project" type="text" value="<?php echo $tanggal_pkwt; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nama">Periode PKWT/TKHL</label>
                  <input readonly class="form-control" placeholder="Periode PKWT" name="periode_pkwt" type="text" value="<?php echo $periode_pkwt; ?>">
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Section Data Addendum -->
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>ADDENDUM </strong> - <?php echo $tambah_addendum; ?></span>
    <div class="card-header-elements ml-md-auto"> </div>
  </div>
  <div id="add_form" class="add-form <?php echo $get_animate; ?>" data-parent="#accordion" style="">

    <div class="card-body">
      <div class="box-datatable table-responsive" id="btn-place">
        <table class="display dataTable table table-striped table-bordered" id="tabel_addendum" style="width:100%">
          <thead>
            <tr>
              <th>Aksi</th>
              <th>Nomor Addendum</th>
              <th>Tanggal Terbit</th>
              <th>Dibuat Oleh</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>

  </div>

</div>

<!-- untuk debugging-->
<!-- <?php echo base_url(); ?>
<?php echo '<pre>';
print_r($pkwt);
echo '</pre>';
?> -->


<script type="text/javascript">
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
  var nip = document.getElementById("nip").value;
  var contract_id = document.getElementById("contract_id").value;
  var emp_id = document.getElementById("emp_id").value;
  var idsession = "<?php print($session['employee_id']); ?>";
  var table;
  //var base_url_catat = '<?php echo base_url(); ?>';

  //datatable addendum
  $(document).ready(function() {
    //alert("masuk javascript");
    table = $('#tabel_addendum').DataTable({
      //"bDestroy": true,
      'processing': true,
      'serverSide': true,
      //'stateSave': true,
      'bFilter': true,
      'serverMethod': 'post',
      //'dom': 'plBfrtip',
      dom: 'lBfrtip',
      "buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
      //'columnDefs': [{
      //  targets: 11,
      //  type: 'date-eu'
      //}],
      'order': [
        [2, 'desc']
      ],
      'ajax': {
        'url': '<?= base_url() ?>admin/addendum/list_addendum',
        data: {
          [csrfName]: csrfHash,
          nip: nip,
          contract_id: contract_id,
          idsession: idsession,
          emp_id: emp_id
          //base_url_catat: base_url_catat
        },
      },
      'columns': [{
          data: 'aksi',
          //"orderable": false
        },
        {
          data: 'no_addendum',
          //"orderable": false,
          //searchable: true
        },
        {
          data: 'tgl_terbit',
          //"orderable": false
        },
        {
          data: 'created_by',
          //"orderable": false,
        },
      ]
    });

  });

  //-----delete addendum-----
  function deleteAddendum(id) {
    //alert("masuk fungsi delete addendum");
    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/addendum/delete_addendum/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id: id
      },
      success: function(response) {
        alert("Berhasil Delete Addendum");
        table.ajax.reload(null, false);
      },
      error: function() {
        alert("Gagal Delete Addendum");
      }
    });
  }

  //-----lihat addendum-----
  function lihatAddendum(id) {
    //alert("masuk fungsi lihat");
    window.open('<?= base_url() ?>admin/addendum/cetak/' + id, "_blank");
  }

  //-----edit addendum-----
  function editAddendum(id) {
    //alert("masuk fungsi lihat");
    window.open('<?= base_url() ?>admin/addendum/edit/' + id, "_blank");
  }
</script>


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
    background: #20c997;
  }
</style>