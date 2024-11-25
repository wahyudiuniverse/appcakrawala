<?php
/* Invoices view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<!-- Modal -->
<div class="modal fade" id="viewDetailModal" tabindex="1" role="dialog" aria-labelledby="viewDetailModalLabel" aria-hidden="true">
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
<div class="modal fade" id="modal-error" tabindex="1" role="dialog" aria-labelledby="modal-errorLabel" aria-hidden="true">
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

<!-- MODAL UNTUK EDIT -->
<div class="modal fade" id="editModal" tabindex="1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">
          <div class="judul-modal">
            <span id="judul-modal-edit"></span>
            <?php if (in_array('1016', $role_resources_ids)) { ?>
              <span id="button_download_dokumen_conditional">tes</span>
            <?php } ?>
          </div>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- <iframe src="" style="zoom:0.60" frameborder="0" height="250" width="99.6%"></iframe> -->
        <div class="isi-modal-edit"></div>
      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
        <button onclick="save_nip()" hidden id='button_save_nip' name='button_save_nip' type='button' class='btn btn-primary'>Save NIP</button>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <!-- Section Data PKWT -->
  <div class="card-header with-elements">
    <div class="col-md-6">
      <span class="card-header-title mr-2"><strong>DATA BATCH </strong> | E-Saltab</span>
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
                <input type="text" class="form-control" readonly name="tanggal_penggajian" id="tanggal_penggajian" placeholder="Periode Saltab To" value="<?php echo $batch_saltab['periode_salary']; ?>">
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

<!-- <div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        Featured
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-3 text-center align-self-center">
            <img src="https://i.pinimg.com/originals/3f/b7/27/3fb72716c6549de64858403367612f4c.gif" width="100%">
          </div>
          <div class="col-sm-9 text-left align-self-center">
            <h5 class="card-title">tanggal foto</h5>
            <p class="card-text">
              Employee ID<br>
              Status Verifikasi<br>
              Verifikasi Oleh<br>
              Waktu Verifikasi<br>
            </p>
            <button type="button" class="btn btn-primary"> Verifikasi </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->

<div class="card">

  <div class="card-header with-elements">
    <div class="col-md-6">
      <span class="card-header-title mr-2"><strong>LIST ALL</strong> | Detail E-Saltab</span>
    </div>

    <div class="col-md-6">
      <div class="pull-right">
        <!-- <div class="card-header with-elements"> -->
        <!-- <span class="card-header-title mr-2">
          <button id="button_delete_all" class="btn btn-danger ladda-button" data-style="expand-right">Delete All</button>
        </span> -->
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
        'url': '<?= base_url() ?>admin/importexcel/list_detail_saltab_release_download',
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
      url: '<?= base_url() ?>admin/Importexcel/delete_detail_saltab_release/',
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
      url: '<?= base_url() ?>admin/importexcel/get_detail_saltab_release/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id: id,
      },
      dataType: 'json',
      beforeSend: function() {
        $('.isi-modal').html(loading_html_text);
        // $('#button_save_pin').attr("hidden", true);
        // $('#editModal').modal('show');
        $('#viewDetailModal').modal('show');
      },
      success: function(response) {
        // var response2 = JSON.parse(response);
        // Add options
        $(response).each(function(index, data) {
          html_text = html_text + "<tr><td>" + data[0] + "</td><td>" + data[1] + "</td></tr>";
          // html_text = html_text + data;
        });
        // html_text = html_text + response;

        html_text = html_text + "</table>";
        // alert(html_text);
        $('.isi-modal').html(html_text);
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

<!-- Tombol Edit NIP -->
<script type="text/javascript">
  var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
  var loading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
  loading_html_text = loading_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
  loading_html_text = loading_html_text + '<h2>LOADING...</h2>';
  loading_html_text = loading_html_text + '</div>';

  function edit_nip(id, nip_lama) {
    // alert(id);
    // alert(nip_lama);

    var html_text = '<div class="container"><div class="row"><table class="table table-striped col-md-12"><tbody>';
    html_text = html_text + "<tr><td style='width:25%'>" + "NIP Lama" + "</td><td style='width:75%'><input readonly id='nip_lama' name='nip_lama' type='text' class='form-control' placeholder='NIP Lama' value='" + nip_lama + "'></td></tr>";
    html_text = html_text + "<tr><td>" + "NIP Baru" + "</td><td><input id='nip_baru' name='nip_baru' type='text' class='form-control' placeholder='NIP Baru' value=''></td></tr>";
    html_text = html_text + "<tr><td>" + "Konfirmasi NIP Baru" + "</td><td><input id='konfirmasi_nip_baru' name='konfirmasi_nip_baru' type='text' class='form-control' placeholder='Konfirmasi NIP Baru' value=''></td></tr>";
    html_text = html_text + "</tbody></div></div>";
    html_text = html_text + '<input hidden id="id_detail_saltab" type="text" value="' + id + '">';

    $('#judul-modal-edit').html("Edit NIP");
    $('#button_download_dokumen_conditional').html("");
    $('.isi-modal-edit').html(html_text);
    $('#button_save_nip').attr("hidden", false);
    $('#editModal').modal('show');
    // $('#viewDetailModal').modal('hide');

  };
</script>

<!-- Tombol save nip -->
<script type="text/javascript">
  function save_nip() {
    var id = $("#id_detail_saltab").val();
    var nip_lama = $("#nip_lama").val();
    var nip_baru = $("#nip_baru").val();
    var konfirmasi_nip_baru = $("#konfirmasi_nip_baru").val();

    // alert(id);
    // alert(nip_lama);
    // alert(nip_baru);
    // alert(konfirmasi_nip_baru);

    var pesan_nip_baru = "";
    var pesan_konfirmasi_nip_baru = "";
    var html_text = "";

    if (nip_baru == "") {
      pesan_nip_baru = "<small style='color:#FF0000;'>NIP baru tidak boleh kosong</small>";
      $('#nip_baru').focus();
    } else {
      if ($.isNumeric(nip_baru)) {
        if (nip_baru.length < 5) {
          pesan_nip_baru = "<small style='color:#FF0000;'>NIP baru minimal 5 digit</small>";
          $('#pin_baru').focus();
        } else {
          if (nip_baru != konfirmasi_nip_baru) {
            pesan_nip_baru = "<small style='color:#FF0000;'>NIP baru harus sama dengan konfirmasi nip baru</small>";
            pesan_konfirmasi_nip_baru = "<small style='color:#FF0000;'>NIP baru harus sama dengan konfirmasi nip baru</small>";
            $('#nip_baru').focus();
          } else {
            pesan_nip_baru = "";
          }
        }
      } else {
        pesan_nip_baru = "<small style='color:#FF0000;'>NIP baru harus berupa angka</small>";
        $('#nip_baru').focus();
      }
    }

    if (konfirmasi_nip_baru == "") {
      pesan_konfirmasi_nip_baru = "<small style='color:#FF0000;'>NIP baru tidak boleh kosong</small>";
      $('#konfirmasi_nip_baru').focus();
    } else {
      if ($.isNumeric(konfirmasi_nip_baru)) {
        if (konfirmasi_nip_baru.length < 5) {
          pesan_konfirmasi_nip_baru = "<small style='color:#FF0000;'>NIP baru minimal 5 digit</small>";
          $('#konfirmasi_nip_baru').focus();
        } else {
          if (nip_baru != konfirmasi_nip_baru) {
            pesan_nip_baru = "<small style='color:#FF0000;'>NIP baru harus sama dengan konfirmasi nip baru</small>";
            pesan_konfirmasi_nip_baru = "<small style='color:#FF0000;'>NIP baru harus sama dengan konfirmasi nip baru</small>";
            $('#konfirmasi_nip_baru').focus();
          } else {
            pesan_konfirmasi_nip_baru = "";
          }
        }
      } else {
        pesan_konfirmasi_nip_baru = "<small style='color:#FF0000;'>NIP baru harus berupa angka</small>";
        $('#konfirmasi_nip_baru').focus();
      }
    }

    //cek pin baru dengan konfirmasi pin baru
    if ((pesan_nip_baru != "") || (pesan_konfirmasi_nip_baru != "")) {
      html_text = '<div class="container"><div class="row"><table class="table table-striped col-md-12"><tbody>';
      html_text = html_text + "<tr><td style='width:25%'>" + "NIP Lama" + "</td><td style='width:75%'><input id='nip_lama' name='nip_lama' type='password' class='form-control' placeholder='PIN Lama' value='" + nip_lama + "'></td></tr>";
      html_text = html_text + "<tr><td>" + "NIP Baru" + "</td><td><input id='nip_baru' name='nip_baru' type='password' class='form-control' placeholder='PIN Baru' value='" + nip_baru + "'>" + pesan_nip_baru + "</td></tr>";
      html_text = html_text + "<tr><td>" + "Konfirmasi NIP Baru" + "</td><td><input id='konfirmasi_nip_baru' name='konfirmasi_nip_baru' type='password' class='form-control' placeholder='Konfirmasi PIN Baru' value='" + konfirmasi_nip_baru + "'>" + pesan_konfirmasi_nip_baru + "</td></tr>";
      html_text = html_text + "</tbody></div></div>";
      html_text = html_text + '<input hidden id="id_detail_saltab" type="text" value="' + id + '">';
      $('.isi-modal-edit').html(html_text);
      $('#button_save_nip').attr("hidden", false);
    } else {
      // AJAX request untuk ganti PIN
      $.ajax({
        url: '<?= base_url() ?>admin/Importexcel/ganti_nip/',
        method: 'post',
        data: {
          [csrfName]: csrfHash,
          id: id,
          nip_lama: nip_lama,
          nip_baru: nip_baru,
          konfirmasi_nip_baru: konfirmasi_nip_baru,
        },
        beforeSend: function() {
          $('.isi-modal-edit').html(loading_html_text);
          // $('#button_save_pin').attr("hidden", true);
          // $('#editModal').modal('show');
        },
        success: function(response) {
          var res = jQuery.parseJSON(response);

          if (res['status'] == "200") {
            html_text = "<h4 style='color:#00AA00;'>" + res['pesan'] + "</h4>"
            html_text = html_text + '<div class="container"><div class="row"><table class="table table-striped col-md-12"><tbody>';
            html_text = html_text + "<tr><td><strong>" + "Nama" + "</strong></td><td>" + res['data']['fullname'] + "</td></tr>";
            html_text = html_text + "<tr><td><strong>" + "NIP Lama" + "</strong></td><td>" + nip_lama + "</td></tr>";
            html_text = html_text + "<tr><td><strong>" + "NIP Baru" + "</strong></td><td>" + res['data']['nip'] + "</td></tr>";
            html_text = html_text + "</tbody></div></div>";
            $('.isi-modal-edit').html(html_text);
            $('#button_save_nip').attr("hidden", true);
            detail_saltab_table.ajax.reload(null, false);
          } else {
            html_text = res['pesan'];
            $('.isi-modal-edit').html(html_text);
            $('#button_save_nip').attr("hidden", true);
          }
        },
        error: function(xhr, status, error) {
          html_text = "Gagal ambil data";
          $('.isi-modal-edit').html(html_text);
          $('#button_save_nip').attr("hidden", true);
        }
      });
    }

  };
</script>

<!-- Script Show & Hide modal -->
<script type="text/javascript">
  $('#editModal').on('show.bs.modal', function(e) {
    // do something...
    // $('#viewDetailModal').modal('hide');
    // $('#viewDetailModal').focus();
  });

  $('#editModal').on('hide.bs.modal', function(e) {
    // do something...
    $('#viewDetailModal').modal('hide');
    // $('#viewDetailModal').focus();
  });
</script>