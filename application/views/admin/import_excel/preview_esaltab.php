<?php
/* Invoices view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<!-- Modal -->
<div class="modal fade" id="viewDetailModal" tabindex="-1" role="dialog" aria-labelledby="viewDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewDetailModalLabel">
          <div class="judul-modal">
            Detail data
          </div>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"> x </span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal">
          ...
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Close </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Error -->
<div class="modal fade" id="modal-error" tabindex="-1" role="dialog" aria-labelledby="modal-errorLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-errorLabel">
          <div class="judul-modal-error">
            Pesan Error
          </div>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"> x </span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-error">
          ...
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Close </button>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <!-- Section Data PKWT -->
  <div class="card-header with-elements">
    <div class="col-md-6">
      <span class="card-header-title mr-2"><strong>DATA BATCH </strong> | E-Saltab Temporary</span>
    </div>
    <div class="col-md-6">
      <div class="pull-right">
        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewDetailModal">
          Launch demo modal
        </button> -->
        <!-- <span class="card-header-title mr-2">
          <button id="button_save_attribut" class="btn btn-primary ladda-button" data-style="expand-right">Save Atribut Batch</button>
        </span> -->
      </div>
    </div>
  </div>

  <div class="card-body">

    <div class="form-body">
      <div class="form-row">
        <div class="col-md-4">
          <div class="form-group">
            <label class="form-label">Project</label>
            <input readonly class="form-control" placeholder="Project" name="project" id="project" type="text" value="<?php echo $batch_saltab['project_name']; ?>">
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Sub Project</label>
                <input readonly class="form-control" placeholder="Sub Project" name="sub_project" id="sub_project" type="text" value="<?php echo $batch_saltab['sub_project_name']; ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Tanggal Penggajian</label>
                <input type="text" class="form-control" readonly name="saltab_to" id="saltab_to" placeholder="Periode Saltab To" value="<?php echo $batch_saltab['periode_salary']; ?>">
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-group">
                <!-- input periode -->
                <label class="form-label">Periode Saltab from</label>
                <input type="text" class="form-control" readonly name="saltab_from" id="saltab_from" placeholder="Periode Saltab From" value="<?php echo $batch_saltab['periode_cutoff_from']; ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <!-- input periode -->
                <label class="form-label">Periode Saltab to</label>
                <input type="text" class="form-control" readonly name="saltab_to" id="saltab_to" placeholder="Periode Saltab To" value="<?php echo $batch_saltab['periode_cutoff_to']; ?>">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="card">

  <div class="card-header with-elements">
    <div class="col-md-6">
      <span class="card-header-title mr-2"><strong>LIST ALL</strong> | Detail E-Saltab Temporary</span>
    </div>

    <div class="col-md-6">
      <div class="pull-right">
        <!-- <div class="card-header with-elements"> -->
        <span class="card-header-title mr-2">
          <button id="button_release_all" class="btn btn-success ladda-button" data-style="expand-right">Finalize All</button>
          <button id="button_delete_all" class="btn btn-danger ladda-button" data-style="expand-right">Delete All</button>
        </span>
        <!-- </div> -->
      </div>
    </div>
  </div>
  <div class=" card-body">
    <div class="box-datatable table-responsive" id="btn-place">
      <table class="display dataTable table table-striped table-bordered" id="detail_saltab_table" style="width:100%">
        <thead>
          <tr>
            <th>Status</th>
            <th>NIK</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Sub Project</th>
            <th>Posisi</th>
            <th>Area</th>
            <th>Hari Kerja</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<!-- </div> -->

<script>
  var detail_saltab_table;
  var id_batch = '<?php echo $id_batch; ?>';
  if ((id_batch == null) || (id_batch == "")) {
    id_batch = 0;
  }
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

  $(document).ready(function() {
    //alert(id_batch);
    $('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
    $('[data-plugin="xin_select"]').select2({
      width: '100%'
    });

    // Project Change - Sub Project (on Change)
    $('#project').change(function() {
      var project = $(this).val();

      // AJAX request
      $.ajax({
        url: '<?= base_url() ?>registrasi/getSubByProject/',
        method: 'post',
        data: {
          [csrfName]: csrfHash,
          project: project
        },
        dataType: 'json',
        success: function(response) {
          //csrfName = data.csrfName;
          //csrfHash = data.csrfHash;
          // Remove options 
          $('#sub_project').find('option').not(':first').remove();

          // Add options
          $(response).each(function(index, data) {
            $('#sub_project').append('<option value="' + data['secid'] + '">' + data['sub_project_name'] + '</option>');
          }).show();
        },
        error: function(xhr, ajaxOptions, thrownError) {
          var error_text = "Error Load Data Sub Project. Status : " + xhr.status;
          $('.judul-modal-error').html("ERROR ! ");
          $('.isi-modal-error').html(xhr.responseText);
          $('#modal-error').modal('show');
        },
      });
    });

    detail_saltab_table = $('#detail_saltab_table').DataTable({
      //"bDestroy": true,
      'processing': true,
      'serverSide': true,
      //'stateSave': true,
      'bFilter': true,
      'serverMethod': 'post',
      //'dom': 'plBfrtip',
      'dom': 'lBfrtip',
      "buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
      //'columnDefs': [{
      //  targets: 11,
      //  type: 'date-eu'
      //}],
      'order': [
        [3, 'desc']
      ],
      'ajax': {
        'url': '<?= base_url() ?>admin/importexcel/list_detail_saltab',
        data: {
          [csrfName]: csrfHash,
          id_batch: id_batch,
          // nip: nip,
          // contract_id: contract_id,
          //idsession: idsession,
          // emp_id: emp_id
          //base_url_catat: base_url_catat
        },
        error: function(xhr, ajaxOptions, thrownError) {
          var error_text = "Error Load Data Table. Status : " + xhr.status;
          $('.judul-modal-error').html("ERROR ! ");
          $('.isi-modal-error').html(xhr.responseText);
          $('#modal-error').modal('show');
        },
      },
      'columns': [{
          data: 'aksi',
          "orderable": false
        },
        {
          data: 'nik',
          //"orderable": false,
          //searchable: true
        },
        {
          data: 'nip',
          //"orderable": false,
          //searchable: true
        },
        {
          data: 'fullname',
          //"orderable": false
        },
        {
          data: 'sub_project',
          "orderable": false,
        },
        {
          data: 'jabatan',
          //"orderable": false,
        },
        {
          data: 'area',
          //"orderable": false,
        },
        {
          data: 'hari_kerja',
          //"orderable": false,
        },
      ]
    });

  });

  //-----delete detail saltab-----
  function deleteDetailSaltab(id) {
    // alert("masuk fungsi delete detail saltab. id: " + id);
    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Importexcel/delete_detail_saltab/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id: id
      },
      success: function(response) {
        alert("Berhasil Delete Data");
        detail_saltab_table.ajax.reload(null, false);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        var error_text = "Gagal Delete Data Saltab. Status : " + xhr.status;
        $('.judul-modal-error').html("ERROR ! ");
        $('.isi-modal-error').html(xhr.responseText);
        $('#modal-error').modal('show');
      },
    });
    // alert("Beres Ajax. id: " + id);
  }

  //-----lihat batch saltab-----
  function lihatDetailSaltab(id) {
    var html_text = '<table class="table table-striped col-md-12"><thead class="thead-dark"><tr><th class="col-md-4">ATRIBUT</th><th class="col-md-8">VALUE</th></thead></tr>';
    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/importexcel/get_detail_saltab/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id: id,
      },
      dataType: 'json',
      success: function(response) {
        // var response2 = JSON.parse(response);
        // Add options
        $(response).each(function(index, data) {
          html_text = html_text + "<tr><td>" + data[0] + "</td><td>" + data[1] + "</td></tr>";
          // html_text = html_text + "<tr><td>" + data[0] + "</td><td><input type='text' class='form-control' readonly placeholder='Periode Saltab To' value='" + data[1] + "'></td></tr>";
          // html_text = html_text + data;
        });
        // html_text = html_text + response;

        html_text = html_text + "</table>";
        // alert(html_text);
        $('.isi-modal').html(html_text);
        $('#viewDetailModal').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        var error_text = "Error Load Data Sub Project. Status : " + xhr.status;
        $('.judul-modal-error').html("ERROR ! ");
        $('.isi-modal-error').html(xhr.responseText);
        $('#modal-error').modal('show');
      },
    });

    // alert("masuk fungsi lihat. id: " + id);
    // var html_text = 'This is the dummy data added using jQuery. Id: ' + id;

    // window.open('<?= base_url() ?>admin/Importexcel/view_batch_saltab_temporary/' + id, "_self");
  }
</script>

<!-- Tombol Delete ALL Detail Saltab -->
<script type="text/javascript">
  document.getElementById("button_delete_all").onclick = function() {
    var id = "<?php echo $id_batch; ?>";

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Importexcel/delete_batch_saltab/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id: id
      },
      success: function(response) {
        alert("Berhasil Delete Batch Saltab");
        detail_saltab_table.ajax.reload(null, false);

        window.open('<?= base_url() ?>admin/Importexcel/importesaltab/', "_self");
      },
      error: function(xhr, ajaxOptions, thrownError) {
        var error_text = "Gagal Delete Batch Saltab. Status : " + xhr.status;
        $('.judul-modal-error').html("ERROR ! ");
        $('.isi-modal-error').html(xhr.responseText);
        $('#modal-error').modal('show');
      },
    });

    // alert("masuk fungsi delete ALL saltab. id: " + id);
  };
</script>

<!-- Tombol Release ALL Detail Saltab -->
<script type="text/javascript">
  document.getElementById("button_release_all").onclick = function() {
    var id = "<?php echo $id_batch; ?>";

    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Importexcel/release_batch_saltab/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id: id
      },
      success: function(response) {
        alert("Berhasil Release Batch Saltab");
        detail_saltab_table.ajax.reload(null, false);

        window.open('<?= base_url() ?>admin/Importexcel/importesaltab/', "_self");
      },
      error: function(xhr, ajaxOptions, thrownError) {
        var error_text = "Gagal Release Batch Saltab. Status : " + xhr.status;
        $('.judul-modal-error').html("ERROR ! ");
        $('.isi-modal-error').html(error_text + xhr.responseText);
        $('#modal-error').modal('show');

        // alert("Gagal Release Batch Saltab. Status : " + xhr.status);
        // alert("responseText :" + xhr.responseText);
      },
    });

    // alert("masuk fungsi Release ALL saltab. id: " + id);
  };
</script>