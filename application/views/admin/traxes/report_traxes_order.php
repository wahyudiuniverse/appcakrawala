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

<!-- MODAL APPROVE PENGAJUAN -->
<div class="modal fade" id="editRekeningModal" tabindex="-1" role="dialog" aria-labelledby="editRekeningModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="judul_dialog">DIALOG REVISI PENJUALAN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-edit-rekening">
          <div class="container" id="container_modal_rekening">

            <div class="row">
              <table class="table table-striped col-md-12">
                <tbody>


                  <tr>
                    <td style='width:25%'><strong>NIP / Nama Lengkap <span class="icon-verify-bank"></span></strong></td>
                      
                    <td ><strong><span class="icon-verify-bank" id="fullname_modal" name="fullname_modal"></span></strong></td>
                    </td>
                  </tr>

                  <tr>
                    <td style='width:25%'><strong>Project / Posisi <span class="icon-verify-bank"></span></strong></td>
                    <td ><strong><span class="icon-verify-bank" id="propos_modal" name="propos_modal"></span></strong></td>
                    </td>
                  </tr>

                  <tr>
                    <td style='width:25%'><strong>Toko/Outlet <span class="icon-verify-bank"></span></strong></td>
                    <td ><strong><span class="icon-verify-bank" id="toko_modal" name="toko_modal"></span></strong></td>
                    </td>
                  </tr>


                  <tr>
                    <td style='width:25%'><strong>Produk/SKU Material <span class="icon-verify-bank"></span></strong></td>
                    <td ><strong><span class="icon-verify-bank" id="material_modal" name="material_modal"></span></strong></td>
                    </td>
                  </tr>



                  <tr style="background: #ffec83;">
                    <td><strong> Jumlah Produk (QTY) <span class="icon-verify-norek"></span></strong></td>
                    <td>

                      <input style="text-align: right;" class="form-control" placeholder="Pastikan Jumlah Produk (QTY) angka." name="order_qty" id="order_qty"></input>
                      <span id='pesan_isi_qty'></span>
                    </td>
                  </tr>


                  <tr>
                    <td style='width:25%'><strong> Harga Satuan @Rp.<span class="icon-verify-bank"></span></strong></td>
                    <td style="text-align: right;"><strong><span class="icon-verify-bank" id="harga_satuan" name="harga_satuan"></span></strong></td>
                    </td>
                  </tr>

                  <tr style="background: #ffec83;">
                    <td><strong>Total Harga (Values) Rp.<span class="icon-verify-norek"></span></strong></td>
                    <td>


                      <input style="text-align: right;" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Pastikan Total Harga (Value) angka." name="total_harga" id="total_harga"></input>
                      <span id='pesan_total_harga'></span>
                    </td>
                  </tr>


                </tbody>
              </table>


                <input hidden type="text" id="field_secid" value="0">
                <input hidden type="text" id="field_toko_id" value="0">
                <input hidden type="text" id="field_employee_id" value="0">
                <input hidden type="text" id="field_fullname" value="0">

            </div>
          </div>
        </div>

        <div class="info-modal-edit-rekening"></div>

      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Tutup</button>

      
              <button
                type="button" id="btn_revisi"
                onclick="save_revisi()"
                class="btn btn-success btn-label float-right ms-auto">
                <i
                  class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>SAVE REVISI PENJUALAN
              </button>

      </div>

    </div>
  </div>
</div>



<hr class="border-light m-0 mb-3">

<!-- SECTION FILTER -->
<div class="card border-blue">
  <div class="card-header with-elements">
    <div class="col-md-6">
      <span class="card-header-title mr-2"><strong>MANAGE REPORT | </strong>FILTER</span>
    </div>

    <!-- <div class="col-md-6">
      <div class="pull-right">
        <span class="card-header-title mr-2">
          <button id="button_clear_search" class="btn btn-success" data-style="expand-right">Clear Filter</button>
        </span>
      </div>
    </div> -->
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

      <div class="col-md-3" id="subproject_ajax">
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


          <div class="col-md mb-3">
              <label class="form-label">Tanggal Awal</label>
              <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly name="start_date" id="aj_sdate" type="text" value="<?php echo date('Y-m-d');?>">
          </div>
            
            <div class="col-md mb-3">
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
          <span class="card-header-title mr-2"><strong>TABEL SELL-OUT</strong></span>
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
                <th>NIP/Nama Lengkap</th>
                <th>Project</th>
                <th>Posisi/Jabatan</th>
                <th>Area/Penempatan</th>
                <th>Toko</th>
                <th>Produk/Material</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Tanggal Order</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var rupiah_tot = document.getElementById("total_harga");
  rupiah_tot.addEventListener("keyup", function(e) {
    rupiah_tot.value = convertRupiah(this.value);
  });


  function convertRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
      split = number_string.split(","),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
      separator = sisa ? "." : "";
      rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? prefix + rupiah : "";
  }

</script>


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
        //"buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
        //'columnDefs': [{
        //  targets: 11,
        //  type: 'date-eu'
        //}],
        // 'order': [
        //   [4, 'asc']
        // ],
        'ajax': {
          'url': '<?= base_url() ?>admin/Traxes_report_order/list_tx_order',
          data: {
            [csrfName]: csrfHash,
            session_id: session_id,
            project: project,
            sub_project: sub_project,
            sdate: sdate,
            edate: edate,
            //base_url_catat: base_url_catat
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert("Status :" + xhr.status);
            alert("responseText :" + xhr.responseText);
          },

        },
        'columns': [{
            data: 'fullname',
            "orderable": false,
            //searchable: true
          },
          {
            data: 'project_name',
            "orderable": false,
            //searchable: true
          },
          {
            data: 'jabatan_name',
            "orderable": false
          },
          {
            data: 'penempatan',
            "orderable": false,
          },
          {
            data: 'customer_name',
            "orderable": false,
          },
          {
            data: 'nama_material',
            "orderable": false,
          },
          {
            data: 'qty',
            "orderable": false,
          },
          {
            data: 'price',
            "orderable": false,
          },
          {
            data: 'total',
            "orderable": false,
          },
          {
            data: 'order_date',
            "orderable": false,
          },
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

    window.open('<?php echo base_url(); ?>admin/Traxes_report_order/printExcel/' + project + '/' + sub_project + '/' + sdate + '/' + edate + '/' + searchVal + '/' + session_id + '/', '_self');

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

<!-- filter project to subproject -->
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
</script>


<!-- Tombol Open Revisi Order -->
<script type="text/javascript">
  function open_revisi(secid) {


    // alert(nip);
    // AJAX untuk ambil data buku tabungan employee terupdate
    $.ajax({
      url: '<?= base_url() ?>admin/Traxes_report_order/get_data_sellout/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        secid: secid,
      },
      beforeSend: function() {
        // $('#judul-modal-edit').html("File Exit Clearance");
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



        if (res['status'] == "200") {

          $('#fullname_modal').html(res['data']['employee_id'] + ' / ' +res['data']['employee_name']);
          $('#propos_modal').html(res['data']['project_name'] + ' / ' +res['data']['jabatan']);
          $('#toko_modal').html(res['data']['customer_name']);
          $('#material_modal').html(res['data']['material_name']);
          $('#order_qty').val(res['data']['qty']);
          $('#harga_satuan').html(res['data']['price']);
          $('#total_harga').val(res['data']['total']);


          $('#field_secid').val(res['data']['secid']);
          $('#field_toko_id').val(res['data']['customer_id']);
          $('#field_material_id').val(res['data']['material_id']);
 
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

</script>

<script>
  
  function save_revisi() {
    var secid = $("#field_secid").val();
    // var employee_id = $("#field_employee_id").val();
    // var employee_name = $("#field_fullname").val();
    // var ktp = $("#field_ktp").val();
    // var jabatan = $("#field_jabatan").val();
    // var project_id = $("#field_project_id").val();
    // var project_name = $("#field_project_name").val();
    // var company_id = $("#field_company_id").val();
    // var company_name = $("#field_company_name").val();

    var qty = $("#order_qty").val();
    var total_harga = $("#total_harga").val();

    // var bpjs_join = $("#joindate_field").val();
    // var bpjs_date = $("#leavedate_field").val();
    // var jenis_dokumen = $("#jenis_dokumen").val();
    // var resign_status = $("#status_resign_select").val();
    // var exit_clearance = $("#link_file_exitclear").val();
    // var resign_letter = $("#link_file_resign").val();
    // var cancel_description = $("#isi_tolak").val();


    // const uniqueTimestamp = Date.now();
    var pesan_qty ="";
    var pesan_total ="";

    if (qty == "") {
          pesan_qty = "<small style='color:#FF0000;'>Jumlah (QTY) produk tidak boleh kosong..!</small>";
          $('#pesan_perusahaan_id_modal').focus();
    }
    if (total_harga == "") {
          pesan_total = "<small style='color:#FF0000;'>Total Harga tidak boleh kosong..!</small>";
          $('#pesan_leavedate').focus();
    }

    $('#pesan_isi_qty').html(pesan_qty);
    $('#pesan_total_harga').html(pesan_total);

  
    var session_id = '<?php echo $session['employee_name']; ?>';

    if(pesan_qty!="" || pesan_total!=""){

    } else {

          // AJAX untuk save data diri
          $.ajax({
            // url: '<?= base_url() ?>admin/Employee_resign_new/save_pengajuan_skk/',
            url: '<?= base_url() ?>admin/Traxes_report_order/update_sellout/',
            method: 'post',
            data: {
              [csrfName]: csrfHash,
              secid: secid,
              qty: qty,
              total: total_harga,
              modifiedby: session_id,

            },
            beforeSend: function() {},
            success: function() {

              employee_table.ajax.reload(null, true);
              // tabel_employees.ajax.reload(null, false);

              alert("Behasil simpan Perubahan Penjualan");
              $('#editRekeningModal').modal('hide');
            },
            error: function(xhr, status, error) {
              alert("error save perubahan");
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
