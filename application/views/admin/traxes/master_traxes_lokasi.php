<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>


<!-- MODAL EDIT REKENING BANK -->
<div class="modal fade" id="editRekeningModal" tabindex="-1" role="dialog" aria-labelledby="editRekeningModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editRekeningModalLabel">DIALOG DETAIL LOKASI/TOKO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-edit-rekening">
          <div class="container" id="container_modal_rekening">
            <?php $attributes = array('name' => 'rekening_form', 'id' => 'rekening_form', 'autocomplete' => 'off', 'class' => 'm-b-1'); ?>
            <?php echo form_open_multipart('admin/profile/uploadaddendum/', $attributes); ?>
            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>

                  <tr>
                    <td style='width:25%'><strong>ID Lokasi/Toko <span class="icon-verify-lokasi"></span></strong></td>
                    <td style='width:75%'>
                      <input class="form-control" readonly placeholder="ID Lokasi/Toko" id="input_idlokasi" name="input_idlokasi" type="text" value="">
                    </td>
                  </tr>

                  <tr>
                    <td><strong>Nama Lokasi/Toko</strong></td>
                    <td>
                      
                      <input class="form-control" placeholder="Nama Lokasi/Toko" id="input_nama_lokasi" name="input_nama_lokasi" type="text" value="">
                      <span id='pesan_nama_lokasi'></span>
                    </td>
                  </tr>

                  <tr>
                    <td><strong>Alamat Lokasi/Toko</strong></td>
                    <td>

                      <select name="select_provinsi" id="select_provinsi" class="form-control" data-plugin="xin_select" data-placeholder="Provinsi">
                        <option value="0">Provinsi</option>
                      </select>

                      <br>

                      <select name="select_kota" id="select_kota" class="form-control" data-plugin="xin_select" data-placeholder="Kota / Kabupaten">
                        <option value="0">Kota / Kabupaten</option>
                      </select>

                      <br>

                      <textarea class="form-control" placeholder="Alamat Lokasi/Toko" id="input_alamat_lokasi" name="input_alamat_lokasi" rows="2"></textarea>
                      <span id='pesan_nama_lokasi'></span>

                    </td>
                  </tr>


                  <tr>
                    <td style='width:25%'><strong>Maps<span class="icon-verify-lokasi"></span></strong></td>
                    <td style='width:75%'>
                      <input class="form-control" readonly placeholder="Latitude / Longitude" id="input_latlong" name="input_latlong" type="text" value="">
                    </td>
                  </tr>

                </tbody>
              </table>


                <input hidden type="text" id="field_secid" value="0">
                <input hidden type="text" id="field_customer_id" value="0">
                <!-- <input hidden type="text" id="field_employee_id" value="0"> -->

            </div>
          </div>
        </div>

        <div class="info-modal-edit-rekening"></div>

      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <button id='button_save_rekening' name='button_save_rekening' type='submit' class='btn btn-primary'>Save Rekening</button>
      </div>

      <?php echo form_close(); ?>
    </div>
  </div>
</div>



<hr class="border-light m-0 mb-3">

<!-- SECTION FILTER -->
<div class="card border-blue">
  <div class="card-header with-elements">
    <div class="col-md-6">
      <span class="card-header-title mr-2"><strong>MANAGE LOKASI/TOKO | </strong>FILTER</span>
    </div>
  </div>

  <div class="card-body border-bottom-blue ">

    <?php echo form_open_multipart('/admin/importexcel/import_saltab2/'); ?>

    <input type="hidden" id="nik" name="nik" value=<?php echo $session['employee_id']; ?>>

    <div class="form-row">
      <div class="col-md-3">
        <div class="form-group project-option">
          <label class="form-label">Project/Golongan</label>
          <select class="form-control select_hrm" data-live-search="true" name="project_id" id="aj_project" data-plugin="select_hrm" data-placeholder="Project" required>
            <option value="0">-ALL-</option>
            <?php foreach ($all_projects as $proj) { ?>
              <option value="<?php echo $proj->project_id; ?>"> <?php echo $proj->title; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <div class="col-md-3" id="subproject_ajax" hidden>
        <label class="form-label">Sub Project/Witel</label>
        <select class="form-control select_hrm" data-live-search="true" name="sub_project_id" id="aj_sub_project" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_projects'); ?>">
          <option value="0">--ALL--</option>
          <!-- <?php foreach ($all_projects as $proj) { ?>
            <option value="<?php echo $proj->project_id; ?>" <?php if ($project_karyawan == $proj->project_id) {
                                                                echo " selected";
                                                              } ?>> <?php echo $proj->title; ?></option>
          <?php } ?> -->
        </select>
      </div>


          <div class="col-md mb-3" hidden>
              <label class="form-label">Tanggal Awal</label>
              <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly name="start_date" id="aj_sdate" type="text" value="<?php echo date('Y-m-d');?>">
          </div>
            
            <div class="col-md mb-3" hidden>
              <label class="form-label">Tanggal Akhir</label>
              <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly name="end_date" id="aj_edate" type="text" value="<?php echo date('Y-m-d');?>">
            </div>


      <div class="col-md-3">
        <div class="form-group">
          <!-- button submit -->
          <label class="form-label">&nbsp;</label>
          <button name="filter_employee" id="filter_employee" class="btn btn-primary btn-block"><i class="fa fa-search"></i> FILTER</button>
        </div>
      </div>
    </div>

    <?php echo form_close(); ?>

  </div>
</div>

<!-- SECTION DATA TABLES -->
<div class="row m-b-1 <?php echo $get_animate; ?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements">
        <div class="col-md-6">
          <span class="card-header-title mr-2"><strong>TABEL MASTER LOKASI/TOKO</strong></span>
        </div>

        <div class="col-md-6">
          <div class="pull-right">
            <!-- <div class="card-header with-elements"> -->
            <span class="card-header-title mr-2">
              <button hidden id="button_download_data" class="btn btn-success" data-style="expand-right">Download Data</button>
            </span>
          </div>
        </div>
      </div>

      <div class="card-body">

        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="tabel_employees">
            <thead>
              <tr>
                <th>Action</th>
                <th>ID</th>
                <th>Nama Lokasi</th>
                <th>Project</th>
                <th>Kota</th>
                <th>Alamat</th>
                <th>Tanggal Dibuat</th>
              </tr>

            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
  //global variable
  var employee_table;
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
  var session_id = '<?php echo $session['employee_id']; ?>';

  var loading_image = "<?php echo base_url('assets/icon/loading_animation3.gif'); ?>";
  var loading_html_text = '<div class="col-12 col-md-12 col-auto text-center align-self-center">';
  loading_html_text = loading_html_text + '<img src="' + loading_image + '" alt="" width="100px">';
  loading_html_text = loading_html_text + '<h2>LOADING...</h2>';
  loading_html_text = loading_html_text + '</div>';

  $(document).ready(function() {


    $('.select_hrm').select2({
                width: '100%',
                // dropdownParent: $("#container_modal_mulai_screening")
            });


    // $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    // $('[data-plugin="select_hrm"]').select2({
    //   width: '100%'
    // });


    var project = "";
    var sub_project = "";
    var sdate = "";
    var edate = "";

    employee_table = $('#tabel_employees').DataTable().on('search.dt', () => eventFired('Search'));

  });
</script>


<!-- Tombol Filter -->
<script type="text/javascript">
  document.getElementById("filter_employee").onclick = function(e) {
    employee_table.destroy();

    e.preventDefault();

    var project     = document.getElementById("aj_project").value;
    var sub_project = document.getElementById("aj_sub_project").value;
    var sdate       =  $('#aj_sdate').val();
    var edate       = $('#aj_edate').val();

    var searchVal = $('#tabel_employees_filter').find('input').val();

    if ((searchVal == "") && (project == "0")) {
      $('#button_download_data').attr("hidden", true);

    } else {
      $('#button_download_data').attr("hidden", false);

      employee_table = $('#tabel_employees').DataTable({
        //"bDestroy": true,
        'processing': true,
        'serverSide': true,
        // 'stateSave': true,
        'bFilter': true,
        'serverMethod': 'post',
        //'dom': 'plBfrtip',
        'dom': 'lfrtip',
        'ajax': {
          'url': '<?= base_url() ?>admin/Traxes_master_lokasi/list_lokasi',
          data: {
            [csrfName]: csrfHash,
            session_id: session_id,
            project: project,
            sub_project: sub_project
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
            data: 'customer_id',
            "orderable": false
          },
          {
            data: 'customer_name',
            "orderable": false,
            //searchable: true
          },
          {
            data: 'project_name',
            "orderable": false,
            //searchable: true
          },
          {
            data: 'city_name',
            "orderable": false
          },
          {
            data: 'address',
            "orderable": false,
          },
          {
            data: 'date_noo',
            "orderable": false,
          }
        ]
      }).on('search.dt', () => eventFired('Search'));

      $('#tombol_filter').attr("disabled", false);
      $('#tombol_filter').removeAttr("data-loading");
    }

    // alert(project);
    // alert(sub_project);
    // alert(status);
  };
</script>

<!-- Tombol Download -->
<script type="text/javascript">
  document.getElementById("button_download_data").onclick = function(e) {
    var project = document.getElementById("aj_project").value;
    var sub_project = document.getElementById("aj_sub_project").value;
    // var sub_project = sub_project.replace(" ","");
    
    var sdate       =  $('#aj_sdate').val();
    var edate       = $('#aj_edate').val();

    // ambil input search dari datatable
    var filter = $('.dataTables_filter input').val(); //cara 1
    var searchVal = $('#tabel_employees_filter').find('input').val(); //cara 2

    if (searchVal == "") {
      searchVal = "-no_input-";
    }

    var text_pesan = "Project: " + project;
    text_pesan = text_pesan + "\nSub Project: " + sub_project;
    text_pesan = text_pesan + "\nSdate: " + sdate;
    text_pesan = text_pesan + "\nEdate: " + edate;
    text_pesan = text_pesan + "\nSearch: " + searchVal;
    // alert(sub_project);

    window.open('<?php echo base_url(); ?>admin/Traxes_report_stock/printExcel/' + project + '/' + sub_project + '/' + sdate + '/' + edate + '/' + searchVal + '/' + session_id + '/', '_self');

  };

  //-----lihat employee-----
  function viewEmployee(id) {
    //alert("masuk fungsi lihat. id: " + id);
    window.open('<?= base_url() ?>admin/employees/emp_view/' + id, "_blank");
  }

  //-----lihat dokumen employee-----
  function viewDocumentEmployee(id) {
    //alert("masuk fungsi lihat. id: " + id);
    $('#dokumenModal').appendTo("body").modal('show');
    // $('#dokumenModal').modal('show');
    // window.open('<?= base_url() ?>admin/employees/emp_edit/' + id, "_blank");
  }

  // employee_table.on('search.dt', function() {
  //   alert("ada search");
  // });

  function eventFired(type) {
    var searchVal = $('#tabel_employees_filter').find('input').val();
    var project = document.getElementById("aj_project").value;
    var sub_project = document.getElementById("aj_sub_project").value;
    var sdate       = $("#aj_sdate").val();
    var edate       = $("#aj_edate").val();
    // alert(searchVal.length);

    if ((searchVal.length <= 2) && (project == "0")) {
      $('#button_download_data').attr("hidden", true);
    } else {

      $('#button_download_data').attr("hidden", false);
    }
    // let n = document.querySelector('#demo_info');
    // n.innerHTML +=
    //   '<div>' + type + ' event - ' + new Date().getTime() + '</div>';
    // n.scrollTop = n.scrollHeight;

  }
</script>


<!-- Tombol Open Form Pengajuan -->
<script type="text/javascript">
  function open_lokasi(secid) {


    // pond_exitclear.removeFile();
    // pond_resign.removeFile();
    // alert(nip);
    // AJAX untuk ambil data buku tabungan employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Traxes_master_lokasi/get_data_lokasi/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        secid: secid,
      },
      beforeSend: function() {
        $('#judul-modal-edit').html("Detail Lokasi/Toko");
        // $('#button_download_dokumen_conditional').html("");
        // $('.isi-modal').html(loading_html_text);
        // $('#button_save_pin').attr("hidden", true);
        $('#editRekeningModal').appendTo("body").modal('show');

        // $('#editRekeningModal').modal('show');
        // $('.info-modal-edit-rekening').attr("hidden", false);
        // $('.isi-modal-edit-rekening').attr("hidden", true);
        // $('.info-modal-edit-rekening').html(loading_html_text);
        // $('#button_save_rekening').attr("hidden", true);
      },
      success: function(response) {
        // alert("TES1");
        var res = jQuery.parseJSON(response);
        const uniqueTimestamp = Date.now();

        // pond_exitclear.setOptions({
        //     server: {
        //       process: {
        //         url: 'https://karir.onecorp.co.id/upload/upload_dokumen_eksternal',
        //         // url: '<?= base_url() ?>admin/Employee_resign_new/list_employees',

        //         method: 'POST',
        //         ondata: (formData) => {
        //           formData.append('id_client', res);
        //           formData.append('nama_client', uniqueTimestamp);
        //           formData.append('identifier', 'cis_exitclear');
        //           formData.append([csrfName], csrfHash);
        //           return formData;
        //         },
        //         // onload: (response) => response.key,
        //         onload: (res) => {
        //           // select the right value in the response here and return
        //           // return res;
        //           var serverResponse = jQuery.parseJSON(res);
        //           $('#link_file_exitclear').val(serverResponse['0']['link_file']);
        //           // serverResponse = JSON.parse(res);
        //           // console.log(serverResponse['0']['link_file']);
        //           // alert(serverResponse['0']['link_file']);
        //         }
        //       },
        //     }
        //   });


        if (res['status'] == "200") {

          $('#input_idlokasi').val(res['data']['customer_id']);
          $('#input_nama_lokasi').val(res['data']['customer_name']);
          $('#input_alamat_lokasi').val(res['data']['address']);
          $('#input_latlong').val(res['data']['latitude']+ ' / ' +res['data']['longitude']);

          $('#fullname_modal').html(res['data']['employee_id'] + ' / ' +res['data']['first_name']);
          $('#nikpt_modal').html(res['data']['ktp_no'] + ' / ' +res['data']['company_name']);
          $('#propos_modal').html(res['data']['project_name'] + ' / ' +res['data']['designation_name']);
          $('#joindate_field').val(res['data']['join_date']);
          $('#leavedate_field').val(res['data']['resign_date']);

          $('#field_secid').val(res['data']['secid']);
          $('#field_customer_id').val(res['data']['employee_id']);

          $('#field_fullname').val(res['data']['first_name']);
          $('#field_ktp').val(res['data']['ktp_no']);
          $('#field_jabatan').val(res['data']['designation_name']);
          $('#field_project_id').val(res['data']['project_id']);
          $('#field_project_name').val(res['data']['project_name']);
          $('#field_company_id').val(res['data']['company_id']);
          $('#field_company_name').val(res['data']['company_name']);

          $('#link_file_exitclear').val(res['data']['link_exit_clearance']);
          $('#link_file_resign').val(res['data']['link_surat_resign']);

          $('#output_exitclearance').html(res['data']['exit_clearance']);
          $('#output_surat_resign').html(res['data']['surat_resign']);

          // $('#status_resign_select').val(res['data']['status_resign']).change();
          // if(res['data']['status_resign']=="2"){
          //   $('#input_exit_clearance').attr("hidden", false);
          //   $('#input_surat_resign').attr("hidden", false);

          // } else if (res['data']['status_resign']=="4"){
          //   $('#input_exit_clearance').attr("hidden", false);
          //   $('#input_surat_resign').attr("hidden", true);
          // } else {

          //   $('#input_exit_clearance').attr("hidden", false);
          //   $('#input_surat_resign').attr("hidden", true);
          // }

          // if(res['data']['working_days'] >= 90){
          //   $('#jenis_dokumen').val('2').change();
          // } else {
          //   $('#jenis_dokumen').val('1').change();
          // }

        } else {
          html_text = res['pesan'];
          // $('.isi-modal').html(html_text);
          // $('#button_save_pin').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        alert("error");
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.isi-modal').html(html_text); //coba pake iframe
        $('#button_save_pin').attr("hidden", true);
      }
    });

  }

  // function open_upload_buku_tabungan(nip) {
  //   $('#form_upload_buku_tabungan').attr("hidden", false);
  //   $('#button_open_upload_buku_tabungan').attr("hidden", true);
  // }
</script>

<!-- Sub Project -->
<script>
  // Project Vacant Change - Jabatan vacant
    $('#aj_project').change(function() {
        var project = $(this).val();

        // alert("Project: " + project);

        // AJAX request Jabatan
        $.ajax({
            url: '<?= base_url() ?>admin/Traxes_report_cio/get_subprojects2/',
            method: 'post',
            data: {
                [csrfName]: csrfHash,
                project: project,
            },
            // dataType: 'json',
            success: function(response) {
                var res = jQuery.parseJSON(response);

                // Remove options
                $('#aj_sub_project').find('option').not(':first').remove();

                // Add options
                $.each(res, function(index, data) {
                    $('#aj_sub_project').append('<option value="' + data['sub_project_name'] + '" style="text-wrap: wrap;">' + data['sub_project_name'] + '</option>');
                });

                // alert("Company name: " + res["company"]["company_name"]);
            }
        });
    });

  function release_paklaring() {

    var secid = $("#field_secid").val();
    var employee_id = $("#field_employee_id").val();
    var employee_name = $("#field_fullname").val();
    var ktp = $("#field_ktp").val();
    var jabatan = $("#field_jabatan").val();
    var project_id = $("#field_project_id").val();
    var project_name = $("#field_project_name").val();
    var company_id = $("#field_company_id").val();
    var company_name = $("#field_company_name").val();


    const uniqueTimestamp = Date.now();
    var pesan_joindate ="";
    var pesan_leavedate ="";

    if (join_date == "") {
          pesan_joindate = "<small style='color:#FF0000;'>Tanggal Bergabung tidak boleh kosong..!</small>";
          $('#pesan_perusahaan_id_modal').focus();
    }
    if (resign_date == "") {
          pesan_leavedate = "<small style='color:#FF0000;'>Tanggal Resign tidak boleh kosong..!</small>";
          $('#pesan_leavedate').focus();
    }

    $('#pesan_joindate').html(pesan_joindate);
    $('#pesan_leavedate').html(pesan_leavedate);

    // cara menentukan nomor dokumen
    const tanggal = new Date();
    const nomorBulan = tanggal.getMonth();
    const bulanRomawi = nomorBulanKeRomawi(nomorBulan);

    if($("#field_company_id").val()=='2'){
      var ns = 'REF-HRD/SC/'+bulanRomawi+'/'+'2025';
    } else if ($("#field_company_id").val()=='3'){
      var ns = 'REF-HRD/KAC/'+bulanRomawi+'/'+'2025';
    } else if ($("#field_company_id").val()=='4'){
      var ns = 'REF-HRD/MATA/'+bulanRomawi+'/'+'2025';
    } else {
      var ns = 'REF-HRD/ONECORP/'+bulanRomawi+'/'+'2025';
    }
    
    var nomor_surat = '00'+secid+'/'+ns;
    var session_id = '<?php echo $session['employee_name']; ?>';
    alert(secid);
    if(pesan_joindate!="" || pesan_leavedate!="") {

    } else {

          // AJAX untuk save data diri
          $.ajax({
            url: '<?= base_url() ?>admin/Employee_paklaring_status/update_pengajuan_skk/',
            method: 'post',
            data: {
              [csrfName]: csrfHash,
              secid: secid,
              docid: uniqueTimestamp,
              jenis_dokumen: jenis_dokumen,
              nomor_dokumen: nomor_surat,
              join_date: join_date,
              resign_date: resign_date,
              bpjs_join: bpjs_join,
              bpjs_date: bpjs_date,
              resign_status: resign_status,
              exit_clearance: exit_clearance,
              resign_letter: resign_letter,
              session_hrd: session_id,
              company_id: company_id,
              company_name : company_name,

            },
            beforeSend: function() {},
            success: function() {

              employee_table.ajax.reload(null, true);
              // tabel_employees.ajax.reload(null, false);

              alert("Behasil simpan Pengajuan Paklaring");
              $('#editRekeningModal').modal('hide');
            },
            error: function(xhr, status, error) {
              alert("error save kontak client");
            }
          });

    }

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
