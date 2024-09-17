<?php
/* Employee Import view
*/
?>
<?php $session = $this->session->userdata('username'); ?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<!-- MODAL RELEASE ESLIP -->
<div class="modal fade" id="releaseEslipModal" tabindex="-1" role="dialog" aria-labelledby="releaseEslipModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="releaseEslipModalLabel">Release e-Slip</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-release-eslip">
          <div class="container" id="container_modal_release_eslip">
            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <td style='width:25%'><strong>Tanggal Penggajian</strong></td>
                    <td style='width:75%'>
                      <span id="tanggal_penggajian_modal"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Periode Cutoff</strong></td>
                    <td>
                      <span id="periode_cutoff_modal"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Project</strong></td>
                    <td>
                      <span id="project_modal"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Sub Project</strong></td>
                    <td>
                      <span id="sub_project_modal"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Total MPP</strong></td>
                    <td>
                      <span id="total_mpp_modal"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Finalize By</strong></td>
                    <td>
                      <span id="finalize_by_modal"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Tanggal terbit e-Slip</strong></td>
                    <td>
                      <input type='date' class='form-control date' name='tanggal_terbit_eslip_modal' id='tanggal_terbit_eslip_modal' placeholder='Tanggal Terbit Eslip' value=''>
                      <input hidden type='text' class='form-control' name='id_batch_saltab' id='id_batch_saltab' placeholder='id batch saltab' value=''>
                      <input hidden type='text' class='form-control' name='value_tanggal_penggajian_modal' id='value_tanggal_penggajian_modal' placeholder='tanggal penggajian saltab' value=''>
                      <span id='pesan_tanggal_terbit_eslip_modal'></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="info-modal-release-eslip"></div>

      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <button id='button_release_eslip' name='button_release_eslip' type='button' class='btn btn-primary'>Release e-Slip</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL DETAIL RELEASE ESLIP -->
<div class="modal fade" id="detailReleaseEslipModal" tabindex="-1" role="dialog" aria-labelledby="detailReleaseEslipModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailReleaseEslipModalLabel">Detail Release e-Slip</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-detail-release-eslip">
          <div class="container" id="container_modal_detail_release_eslip">
            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <td style='width:25%'><strong>Tanggal Penggajian</strong></td>
                    <td style='width:75%'>
                      <span id="tanggal_penggajian_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Periode Cutoff</strong></td>
                    <td>
                      <span id="periode_cutoff_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Project</strong></td>
                    <td>
                      <span id="project_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Sub Project</strong></td>
                    <td>
                      <span id="sub_project_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Total MPP</strong></td>
                    <td>
                      <span id="total_mpp_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Finalize By</strong></td>
                    <td>
                      <span id="finalize_by_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Tanggal Terbit e-Slip</strong></td>
                    <td>
                      <span id="tanggal_terbit_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Release e-Slip By</strong></td>
                    <td>
                      <span id="release_eslip_by_modal_detail"></span>
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Release e-Slip On</strong></td>
                    <td>
                      <span id="release_eslip_on_modal_detail"></span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="info-modal-detail-release-eslip"></div>

      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <!-- <button id='button_release_eslip' name='button_release_eslip' type='button' class='btn btn-primary'>Release e-Slip</button> -->
      </div>
    </div>
  </div>
</div>

<?php
if (in_array('514', $role_resources_ids)) {
?>


  <div class="card border-blue">
    <div class="card-header with-elements">
      <div class="col-md-6">
        <span class="card-header-title mr-2"><strong>E-SALTAB | </strong>FILTER FILE</span>
      </div>

      <div class="col-md-6">
        <div class="pull-right">
          <!-- <div class="card-header with-elements"> -->
          <span class="card-header-title mr-2">
            <button id="button_clear_search" class="btn btn-success" data-style="expand-right">Clear Filter</button>
          </span>
        </div>
      </div>
    </div>

    <div class="card-body border-bottom-blue ">

      <?php echo form_open_multipart('/admin/importexcel/import_saltab2/'); ?>

      <input type="hidden" id="nik" name="nik" value=<?php echo $session['employee_id']; ?>>

      <div class="form-row">
        <div class="col-md-6">
          <div class="form-group project-option">
            <label class="form-label">Project</label>
            <select class="form-control" data-live-search="true" name="project" id="project" data-plugin="xin_select" data-placeholder="Project" required>
              <option value="0">-ALL-</option>
              <?php foreach ($all_projects as $proj) { ?>
                <option value="<?php echo $proj->project_id; ?>"> <?php echo $proj->title; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-group periode-from">
                <!-- input periode -->
                <label class="form-label">Search Tanggal Penggajian from</label>
                <input type="text" class="form-control date" readonly name="search_periode_from" id="search_periode_from" placeholder="Periode From" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group periode-to">
                <!-- input periode -->
                <label class="form-label">Search Tanggal Penggajian to</label>
                <input type="text" class="form-control date" readonly name="search_periode_to" id="search_periode_to" placeholder="Periode To" required>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md mb-12">
          <div class="form-group">
            <!-- button submit -->
            <button name="search_batch" id="search_batch" class="btn btn-primary btn-block"><i class="fa fa-search"></i> SEARCH</button>
          </div>
        </div>
      </div>

      <?php echo form_close(); ?>

    </div>
  </div>


<?php
}
?>

<!-- <div id="ms1" class="form-control"></div> -->
<!-- <div id="langOpt" class="form-control"></div> -->

<!-- <?php
      // echo '<pre>';
      // print_r($tabel_saltab);
      // echo '</pre>';
      ?> -->
<div class="card <?php echo $get_animate; ?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>E-SALTAB | </strong>DATA LIST BATCH</div>
  <div class="card-body">
    <div class="box-datatable table-responsive" id="btn-place">
      <table class="display dataTable table table-striped table-bordered" id="saltab_table2" style="width:100%">
        <thead>
          <tr>
            <th>Aksi</th>
            <th>Tanggal Penggajian</th>
            <th>Periode Cutoff</th>
            <th>Project</th>
            <th>Sub Project</th>
            <th>Total MPP</th>
            <th>Finalize by</th>
            <th>Finalize on</th>
            <th>Eslip Status</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>


<script>
  //global variable
  var ms1;
  var langopt;
  var saltab_table;
  var session_id = '<?php echo $session['employee_id']; ?>';
  // var kolom_saltab = JSON.parse('<?php //echo json_encode($tabel_saltab); 
                                    ?>');
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

  var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
  var loading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
  loading_html_text = loading_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
  loading_html_text = loading_html_text + '<h2>LOADING...</h2>';
  loading_html_text = loading_html_text + '</div>';

  var uploading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
  var uploading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
  uploading_html_text = uploading_html_text + '<img src="' + uploading_image + '" alt="" width="100px">';
  uploading_html_text = uploading_html_text + '<h2>PROCESSING...</h2>';
  uploading_html_text = uploading_html_text + '</div>';

  var success_image = "<?php echo base_url('assets/icon/ceklis_hijau.png'); ?>";
  var success_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
  success_html_text = success_html_text + '<img src="' + success_image + '" alt="" width="100px">';
  success_html_text = success_html_text + '<h2 style="color: #00FFA3;">BERHASIL UPDATE DATA</h2>';
  success_html_text = success_html_text + '</div>';

  $(document).ready(function() {

    // var idsession = "<?php //print($session['employee_id']); 
                        ?>";

    // baseURL variable
    var baseURL = "<?php echo base_url(); ?>";

    var project = document.getElementById("project").value;
    var search_periode_from = document.getElementById("search_periode_from").value;
    var search_periode_to = document.getElementById("search_periode_to").value;

    $('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
    $('[data-plugin="xin_select"]').select2({
      width: '100%'
    });

    saltab_table = $('#saltab_table2').DataTable({
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
        [7, 'desc']
      ],
      'ajax': {
        'url': '<?= base_url() ?>admin/importexcel/list_batch_saltab_release_download',
        data: {
          [csrfName]: csrfHash,
          session_id: session_id,
          project: project,
          search_periode_from: search_periode_from,
          search_periode_to: search_periode_to,
          //base_url_catat: base_url_catat
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert("Status :" + xhr.status);
          alert("responseText :" + xhr.responseText);
        },
      },
      'columns': [{
          data: 'aksi',
          "orderable": false
        },
        {
          data: 'periode_salary',
          // "orderable": false,
          //searchable: true
        },
        {
          data: 'periode',
          "orderable": false,
          //searchable: true
        },
        {
          data: 'project_name',
          //"orderable": false
        },
        {
          data: 'sub_project_name',
          //"orderable": false,
        },
        {
          data: 'total_mpp',
          "orderable": false,
        },
        {
          data: 'release_by',
          //"orderable": false,
        },
        {
          data: 'release_on',
          //"orderable": false,
        },
        {
          data: 'release_eslip',
          "orderable": false,
        },
      ]
    });

  });

  //-----delete Batch Saltab-----
  function deleteBatchSaltabRelease(id) {
    // alert("masuk fungsi delete saltab. id: " + id);
    // AJAX request
    $.ajax({
      url: '<?= base_url() ?>admin/Importexcel/delete_batch_saltab_release/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id: id
      },
      success: function(response) {
        alert("Berhasil Delete Batch Saltab");
        saltab_table.ajax.reload(null, false);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert("Gagal Delete Batch Saltab. Status : " + xhr.status);
        alert("responseText :" + xhr.responseText);
      },
    });
    // alert("Beres Ajax. id: " + id);
  }

  //-----delete Batch Saltab-----
  function detailReleaseEslip(id) {
    // AJAX untuk ambil data detail eslip
    $.ajax({
      url: '<?= base_url() ?>admin/Importexcel/get_data_eslip_release/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id: id,
      },
      beforeSend: function() {
        $('.info-modal-detail-release-eslip').attr("hidden", false);
        $('.isi-modal-detail-release-eslip').attr("hidden", true);
        $('.info-modal-detail-release-eslip').html(loading_html_text);
        $('#detailReleaseEslipModal').modal('show');
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          $('#tanggal_penggajian_modal_detail').html(res['data']['tanggal_penggajian']);
          $("#periode_cutoff_modal_detail").html(res['data']['periode_cutoff']);
          $('#project_modal_detail').html(res['data']['project_name']);
          $('#sub_project_modal_detail').html(res['data']['sub_project_name']);
          $("#total_mpp_modal_detail").html(res['data']['total_mpp']);
          $('#finalize_by_modal_detail').html(res['data']['release_by']);
          $('#tanggal_terbit_modal_detail').html(res['data']['tanggal_terbit']);
          $('#release_eslip_by_modal_detail').html(res['data']['eslip_release_by']);
          $('#release_eslip_on_modal_detail').html(res['data']['eslip_release_on']);

          $('.isi-modal-detail-release-eslip').attr("hidden", false);
          $('.info-modal-detail-release-eslip').attr("hidden", true);
        } else {
          html_text = res['pesan'];
          $('.info-modal-detail-release-eslip').html(html_text);
          $('.isi-modal-detail-release-eslip').attr("hidden", true);
          $('.info-modal-detail-release-eslip').attr("hidden", false);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-detail-release-eslip').html(html_text); //coba pake iframe
        $('.isi-modal-detail-release-eslip').attr("hidden", true);
        $('.info-modal-detail-release-eslip').attr("hidden", false);
      }
    });
  }

  //-----detail Release e-Slip-----
  function releaseEslip(id) {
    //inisialisasi pesan
    $('#pesan_tanggal_terbit_eslip_modal').html("");

    // AJAX untuk ambil data employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Importexcel/get_data_eslip_release/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id: id,
      },
      beforeSend: function() {
        $('.info-modal-release-eslip').attr("hidden", false);
        $('.isi-modal-release-eslip').attr("hidden", true);
        $('.info-modal-release-eslip').html(loading_html_text);
        $('#button_release_eslip').attr("hidden", true);
        $('#releaseEslipModal').modal('show');
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {
          //   $('#tanggal_penggajian_modal').val(res['data']['bank_name']).change();
          $('#tanggal_penggajian_modal').html(res['data']['tanggal_penggajian']);
          $("#periode_cutoff_modal").html(res['data']['periode_cutoff']);
          $('#project_modal').html(res['data']['project_name']);
          $('#sub_project_modal').html(res['data']['sub_project_name']);
          $("#total_mpp_modal").html(res['data']['total_mpp']);
          $('#finalize_by_modal').html(res['data']['release_by']);
          $('#id_batch_saltab').val(id);
          $('#tanggal_terbit_eslip_modal').val("");
          $('#value_tanggal_penggajian_modal').val(res['data']['periode_salary']);
          $('#pesan_tanggal_terbit_eslip_modal').html("<small style='color:#FF0000;'>Jika tanggal terbit tidak diisi, akan diisi dengan tanggal penggajian secara otomatis</small>");

          $('.isi-modal-release-eslip').attr("hidden", false);
          $('.info-modal-release-eslip').attr("hidden", true);
          $('#button_release_eslip').attr("hidden", false);
        } else {
          html_text = res['pesan'];
          $('.info-modal-release-eslip').html(html_text);
          $('.isi-modal-release-eslip').attr("hidden", true);
          $('.info-modal-release-eslip').attr("hidden", false);
          $('#button_release_eslip').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-release-eslip').html(html_text); //coba pake iframe
        $('.isi-modal-release-eslip').attr("hidden", true);
        $('.info-modal-release-eslip').attr("hidden", false);
        $('#button_release_eslip').attr("hidden", true);
      }
    });
  }

  //action button release e-slip
  document.getElementById("button_release_eslip").onclick = function(e) {
    //-------ambil isi variabel-------
    var tanggal_terbit = $("#tanggal_terbit_eslip_modal").val();
    var id_saltab = $("#id_batch_saltab").val();
    var tanggal_penggajian = $("#value_tanggal_penggajian_modal").val();
    var release_by = '<?php echo $session['user_id']; ?>';

    //-------testing-------
    // alert(tanggal_terbit);
    // alert(id_saltab);

    // AJAX untuk save data employee
    $.ajax({
      url: '<?= base_url() ?>admin/Importexcel/release_eslip_batch_saltab_release/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id: id_saltab,
        tanggal_terbit: tanggal_terbit,
        tanggal_penggajian: tanggal_penggajian,
        release_by: release_by,
      },
      beforeSend: function() {
        $('.info-modal-release-eslip').attr("hidden", false);
        $('.isi-modal-release-eslip').attr("hidden", true);
        $('.info-modal-release-eslip').html(loading_html_text);
        $('#button_release_eslip').attr("hidden", true);
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        //tampilkan pesan sukses
        $('.info-modal-release-eslip').attr("hidden", false);
        $('.isi-modal-release-eslip').attr("hidden", true);
        $('.info-modal-release-eslip').html(success_html_text);
        $('#button_release_eslip').attr("hidden", true);
        saltab_table.ajax.reload(null, false);
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-release-eslip').html(html_text); //coba pake iframe
        $('.isi-modal-release-eslip').attr("hidden", true);
        $('.info-modal-release-eslip').attr("hidden", false);
        $('#button_release_eslip').attr("hidden", true);
      }
    });

  };

  //-----lihat addendum----- 
  function lihatBatchSaltabRelease(id) {
    //alert("masuk fungsi lihat. id: " + id);
    window.open('<?= base_url() ?>admin/Importexcel/view_batch_saltab_release_download/' + id, "_blank");
  }

  //-----download raw data saltab-----
  function downloadBatchSaltabRelease(id) {
    //alert("masuk fungsi download. id: " + id);downloadDetailSaltab
    // window.open('<?= base_url() ?>admin/addendum/edit/' + id, "_blank");
    window.open('<?= base_url() ?>admin/Importexcel/downloadDetailSaltabRelease/' + id, "_self");
  }

  //-----download salab BPJS-----
  function downloadBatchSaltabReleaseBPJS(id) {
    //alert("masuk fungsi download. id: " + id);downloadDetailSaltab
    // window.open('<?= base_url() ?>admin/addendum/edit/' + id, "_blank");
    window.open('<?= base_url() ?>admin/Importexcel/downloadDetailSaltabReleaseBPJS/' + id, "_self");
  }

  //-----download salab BPJS-----
  function downloadBatchSaltabReleasePayroll(id) {
    //alert("masuk fungsi download. id: " + id);downloadDetailSaltab
    // window.open('<?= base_url() ?>admin/addendum/edit/' + id, "_blank");
    window.open('<?= base_url() ?>admin/Importexcel/downloadDetailSaltabReleasePayroll/' + id, "_self");
  }

  // function cek_isi() {
  //   var isi = langopt.getValue();
  //   //alert("tes");
  //   alert("Isi pilihan: " + isi);
  // }
</script>

<!-- Tombol Search Batch Saltab -->
<script type="text/javascript">
  document.getElementById("search_batch").onclick = function(e) {
    saltab_table.destroy();
    // $('#saltab_table2').empty();

    e.preventDefault();

    // $('.icon-spinner3').hide();
    // $('.save').prop('disabled', false);
    // Ladda.stopAll();

    var project = document.getElementById("project").value;
    var search_periode_from = document.getElementById("search_periode_from").value;
    var search_periode_to = document.getElementById("search_periode_to").value;

    // alert(project);
    // alert(periode_salary);
    // alert(cutoff_from);
    // alert(cutoff_to);

    saltab_table = $('#saltab_table2').DataTable({
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
        [7, 'desc']
      ],
      'ajax': {
        'url': '<?= base_url() ?>admin/importexcel/list_batch_saltab_release_download',
        data: {
          [csrfName]: csrfHash,
          session_id: session_id,
          project: project,
          search_periode_from: search_periode_from,
          search_periode_to: search_periode_to,
          //base_url_catat: base_url_catat
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert("Status :" + xhr.status);
          alert("responseText :" + xhr.responseText);
        },
      },
      'columns': [{
          data: 'aksi',
          "orderable": false
        },
        {
          data: 'periode_salary',
          "orderable": false,
          //searchable: true
        },
        {
          data: 'periode',
          "orderable": false,
          //searchable: true
        },
        {
          data: 'project_name',
          //"orderable": false
        },
        {
          data: 'sub_project_name',
          //"orderable": false,
        },
        {
          data: 'total_mpp',
          "orderable": false,
        },
        {
          data: 'release_by',
          //"orderable": false,
        },
        {
          data: 'release_on',
          //"orderable": false,
        },
        {
          data: 'release_eslip',
          "orderable": false,
        },
      ]
    });

  };
</script>

<!-- Tombol Clear Filter Batch Saltab -->
<script type="text/javascript">
  document.getElementById("button_clear_search").onclick = function(e) {
    saltab_table.destroy();

    e.preventDefault();

    //reset parameter filter
    document.getElementById("search_periode_from").value = "";
    document.getElementById("search_periode_to").value = "";
    $("div.project-option select").val("0").change();

    var project = document.getElementById("project").value;
    var search_periode_from = document.getElementById("search_periode_from").value;
    var search_periode_to = document.getElementById("search_periode_to").value;

    // alert(project);
    // alert(periode_salary);
    // alert(cutoff_from);
    // alert(cutoff_to);

    saltab_table = $('#saltab_table2').DataTable({
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
        [7, 'desc']
      ],
      'ajax': {
        'url': '<?= base_url() ?>admin/importexcel/list_batch_saltab_release_download',
        data: {
          [csrfName]: csrfHash,
          session_id: session_id,
          project: project,
          search_periode_from: search_periode_from,
          search_periode_to: search_periode_to,
          //base_url_catat: base_url_catat
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert("Status :" + xhr.status);
          alert("responseText :" + xhr.responseText);
        },
      },
      'columns': [{
          data: 'aksi',
          "orderable": false
        },
        {
          data: 'periode_salary',
          "orderable": false,
          //searchable: true
        },
        {
          data: 'periode',
          "orderable": false,
          //searchable: true
        },
        {
          data: 'project_name',
          //"orderable": false
        },
        {
          data: 'sub_project_name',
          //"orderable": false,
        },
        {
          data: 'total_mpp',
          "orderable": false,
        },
        {
          data: 'release_by',
          //"orderable": false,
        },
        {
          data: 'release_on',
          //"orderable": false,
        },
        {
          data: 'release_eslip',
          "orderable": false,
        },
      ]
    });

  };
</script>