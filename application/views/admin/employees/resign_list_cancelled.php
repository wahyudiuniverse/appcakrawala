<?php
/* Company view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>

<?php $count_cancel = $this->Xin_model->count_resign_cancel();?>
<?php $count_appnae = $this->Xin_model->count_approve_nae();?>
<?php $count_appnom = $this->Xin_model->count_approve_nom();?>
<?php $count_apphrd = $this->Xin_model->count_approve_hrd();?>
<?php $count_emp_request = $this->Xin_model->count_emp_resign();?>


<!-- MODAL REVISI PAKLARING DITOLAK -->
<div class="modal fade" id="openRevisiModal" tabindex="-1" role="dialog" aria-labelledby="requestOpenModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="requestOpenModalLabel">DIALOG REVISI PAKLARING DITOLAK</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="isi-modal-edit-rekening">
          <div class="container" id="container_modal_rekening">
            <?php $attributes = array('name' => 'revisi_form', 'id' => 'revisi_form', 'autocomplete' => 'off', 'class' => 'm-b-1'); ?>
            <?php echo form_open_multipart('admin/Employee_resign_cancelled/UpdateRevisiCancel/', $attributes); ?>
            <div class="row">

              <input hidden name="nip_modal" id="nip_modal" type="text">
              <input hidden name="status_resign_modal" id="status_resign_modal" type="text">

              <table class="table table-striped col-md-12">
                <tbody>
                  <tr>
                    <td style='width:30%'><strong>No KTP <span class="icon-verify-bank"></span></strong></td>
                    <td id='ktp_no_modal' style='width:70%'>-</td>
                  </tr>
                  <tr>
                    <td><strong>Nama Lengkap<span class="icon-verify-norek"></span></strong></td>
                    <td id='first_name_modal'>-</td>
                  </tr>
                  <tr>
                    <td><strong>Project<span class="icon-verify-pemilik-rek"></span></strong></td>
                    <td id='project_modal'>-</td>
                  </tr>
                  <tr hidden>
                    <td><strong>Sub Project</strong></td>
                    <td id='project_sub_modal'>-</td>
                  </tr>
                  <tr hidden>
                    <td><strong>Jabatan</strong></td>
                    <td id='jabatan_modal'>-</td>
                  </tr>
                  <tr hidden>
                    <td><strong>Alamat KTP</strong></td>
                    <td id='alamat_ktp_modal'>-</td>
                  </tr>
                  <tr hidden>
                    <td><strong>Penempatan</strong></td>
                    <td id='penempatan_modal'>-</td>
                  </tr>
                  <tr>
                    <td><strong>Upload Surat Resign</strong></td>
                    <td > 
                      <div id="input_upload_dokumen" class="form-group">
                        <fieldset class="form-group">
                          <input type="file" class="form-control-file" id="file_dokumen_sresign" name="file_dokumen_sresign" accept="application/pdf, image/png, image/jpg, image/jpeg">
                          <small>Jenis File: JPG, JPEG, PNG, PDF | Size MAX 5 MB</small>
                        </fieldset>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td><strong>Upload Exit Clearance</strong></td>
                    <td > 
                      <div id="input_upload_dokumen" class="form-group">
                        <fieldset class="form-group">
                          <input type="file" class="form-control-file" id="file_dokumen_exc" name="file_dokumen_exc" accept="application/pdf, image/png, image/jpg, image/jpeg">
                          <small>Jenis File: JPG, JPEG, PNG, PDF | Size MAX 5 MB</small>
                        </fieldset>
                      </div>
                    </td>
                  </tr>

                  <tr style="background: coral;color: white;">
                    <td><strong>Catatan Revisi</strong></td>
                    <td id='note_modal'>-</td>
                  </tr>
                  <tr>
                    <td><strong>Request By</strong></td>
                    <td id='requestby_modal'>-</td>
                  </tr>
                  <tr>
                    <td><strong>Approve Level 1</strong></td>
                    <td id='approvenae_modal'>-</td>
                  </tr>
                  <tr>
                    <td><strong>Approve Level 2</strong></td>
                    <td id=approvenom_modal>-</td>
                  </tr>
                  <tr>
                    <td><strong>Approve HRD</strong></td>
                    <td id='approvehrd_modal'>-</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="info-modal-edit-rekening"></div>

      </div>
      <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>TUTUP</button>
        <button id='button_save_revisi' name='button_save_revisi' type='submit' class='btn btn-primary'>SAVE REVISI</button>
      </div>

      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<!-- MODAL LOADING -->
<div class="modal fade" id="loadingModal" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <!-- <div class="modal-header">
        <h5 class="modal-title" id="loadingModalLabel">Edit Data Diri</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> -->
      <div class="modal-body">

        <div class="col-12 col-md-12 col-auto text-center align-self-center">
          <img src="<?php echo base_url('assets/icon/loading_animation3.gif'); ?>" alt="">
          <h2>LOADING...</h2>
        </div>

      </div>
      <!-- <div class="modal-footer">
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <button id='button_save_data_diri' name='button_save_data_diri' type='button' class='btn btn-primary'>Save Data Diri</button>
      </div> -->
    </div>
  </div>
</div>

  <!-- Modal -->
  <div class="modal fade" id="openRevisiModalx" tabindex="-1" role="dialog" aria-labelledby="requestOpenModalLabelx" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!-- <div class="modal-header bg-danger"> -->
        <div class="modal-header">
          <h5 class="modal-title" id="requestOpenModalLabelx">
            <div class="judul-modal">
              Messages
              <!-- <img src='<?php echo base_url('/assets/icon/not-verified.png'); ?>' width='20'> -->
            </div>
          </h5>
          <button type="button" name="button_close2" id="button_close2" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">
              x
            </span>
          </button>
        </div>
        <div class="modal-body">
          <div class="pesan-modal"></div>
          <div class="detail-modal"></div>
        </div>
        <div class="modal-footer">
          <div class="button-modal"></div>
          <button type="button" name="button_save" id="button_accept" class="btn btn-success"> SIMPAN </button>
          <button type="button" name="button_close" id="button_close" class="btn btn-secondary" data-dismiss="modal"> Close </button>
        </div>
      </div>
    </div>
  </div>


<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('491',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_resign/');?>" data-link-data="<?php echo site_url('admin/employee_resign/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon fa fa-database"></span> Ajukan Paklaring
      </a> </li>
    <?php } ?> 

    <?php if(in_array('506',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/Employee_resign_cancelled/');?>" data-link-data="<?php echo site_url('admin/Employee_resign_apnae/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> Paklaring Ditolak <?php echo '('.$count_cancel.')';?>
      </a> </li>
    <?php } ?>
    
    <?php if(in_array('492',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_resign_apnae/');?>" data-link-data="<?php echo site_url('admin/Employee_resign_apnae/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> Approve NAE <?php echo '('.$count_appnae.')';?>
      </a> </li>
    <?php } ?>

    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_resign_apnom/');?>" data-link-data="<?php echo site_url('admin/Employee_resign_apnom/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> Approve NOM/SM <?php echo '('.$count_appnom.')';?>
      </a> </li>
 

    <?php if(in_array('494',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_resign_aphrd/');?>" data-link-data="<?php echo site_url('admin/Employee_resign_aphrd/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> Approve HRD
      <?php echo '('.$count_apphrd.')';?></a> </li>
    <?php } ?>
    
    <?php if(in_array('491',$role_resources_ids)) { ?>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/employee_resign_history/');?>" data-link-data="<?php echo site_url('admin/Employee_resign_history/');?>" class="mb-3 nav-link hrpremium-link"> <span class="sw-icon ion ion-ios-paper"></span> History Resign
      </a> </li>
    <?php } ?>

  </ul>
</div>

<hr class="border-light m-0 mb-3">
<?php $employee_id = $this->Xin_model->generate_random_employeeid();?>
<?php $employee_pincode = $this->Xin_model->generate_random_pincode();?>

<div class="card">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>DAFTAR </strong>PAKLARING DITOLAK</span> </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="empcancel-datatables" class="display table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>AKSI</th>
                                <th>NIP</th>
                                <th>NAMA LENGKAP</th>
                                <th>PROJECT</th>
                                <th>JABATAN</th>
                                <th>PENEMPATAN</th>
                                <th>KET. DITOLAK</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

</div>


<script type='text/javascript'>
    var table_cancel;
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
        csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
    var idsession = "<?php print($session['employee_id']); ?>";
    // var identifier = '<?php //echo $identifier; ?>';

    // execute kalau page sudah ke load 
    $(document).ready(function() {
        //inisialisasi select2 untuk searchable dropdown
        $('.dropdown-dengan-search').select2({
            width: '100%'
        });

        // alert(identifier);
        // alert(jabatan);
        // alert(region);
        // alert(rekruter);

        //populate data tabel
        // if (identifier == "" || identifier == null) {

        // } else {
            table_cancel = $('#empcancel-datatables').DataTable({
                //"bDestroy": true,
                'processing': true,
                'serverSide': true,
                // 'stateSave': true,
                'bFilter': true,
                'serverMethod': 'post',
                // 'dom': 'lBfrtip',
                'dom': 'lfrtip',
                'buttons': ["copy", "csv", "excel", "print", "pdf"],
                'order': [
                    [1, 'asc']
                ],
                'ajax': {
                    'url': '<?= base_url() ?>admin/employee_resign_cancelled/resign_list_cancel2',
                    data: {
                        [csrfName]: csrfHash,
                        // identifier: identifier,
                        idsession: idsession
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert("Status :" + xhr.status);
                        alert("responseText :" + xhr.responseText);
                    },
                },
                'columns': [
                    {
                        data: 'aksi',
                        "orderable": false
                    },
                    {
                        data: 'employee_id',
                        // "orderable": false,
                        //searchable: true
                    },
                    {
                        data: 'first_name',
                        // "orderable": false,
                    },
                    {
                        data: 'project',
                        // "orderable": false,
                        //searchable: true
                    },
                    {
                        data: 'posisi',
                        // "orderable": false
                    },
                    {
                        data: 'penempatan',
                        // "orderable": false
                    },
                    {
                        data: 'cancel_ket',
                        // "orderable": false,
                    },
                    // {
                    //     data: 'employee_id',
                    //     // "orderable": false,
                    // },
                    // {
                    //     data: 'employee_id',
                    //     "orderable": false,
                    // },
                ]
            });
            // }).on('search.dt', () => eventFired('Search'));
        // }

    });



</script>

<script type="text/javascript">

  //-----open modal untuk accept request-----
  function openRevisi(id) {
    
    $('#button_save_revisi').attr("hidden", false);
    // $('.pesan-modal').html("Apakah anda yakin untuk membuka kunci import saltab ini?<br>");
    // $('.detail-modal').html('<input type="hidden" id="id_modal" name="id_modal" value="' + id + '">');


$.ajax({
      url: '<?= base_url() ?>admin/employee_resign_cancelled/get_data_diri/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        nip: id,
      },
      beforeSend: function() {
        $('#openRevisiModal').modal('show');
        $('.info-modal-edit-data-diri').attr("hidden", false);
        $('.isi-modal-edit-data-diri').attr("hidden", true);
        $('.info-modal-edit-data-diri').html("loading_html_text");
        $('#button_save_revisi').attr("hidden", true);
      },
      success: function(response) {

        var res = jQuery.parseJSON(response);

        if (res['status'] == "200") {

          $('#nip_modal').val(res['data']['employee_id']);
          $('#ktp_no_modal').html(res['data']['ktp_no']);
          $('#first_name_modal').html(res['data']['first_name']);
          $('#project_modal').html(res['data']['project_id']);
          $('#project_sub_modal').html(res['data']['project_sub_id']);
          $('#jabatan_modal').html(res['data']['designation_id']);
          $('#alamat_ktp_modal').html(res['data']['alamat_ktp']);
          $('#penempatan_modal').html(res['data']['penempatan']);
          $('#note_modal').html(res['data']['cancel_ket']);
          $('#status_resign_modal').html(res['data']['status_resign']);
          $('#requestby_modal').html(res['data']['request_resign_by']);
          $('#approvenae_modal').html(res['data']['approve_resignnae']);
          $('#approvenom_modal').html(res['data']['approve_resignnom']);
          $('#approvehrd_modal').html(res['data']['approve_resignhrd']);

          $('.isi-modal-edit-data-diri').attr("hidden", false);
          $('.info-modal-edit-data-diri').attr("hidden", true);
          $('#button_save_revisi').attr("hidden", false);
        } else {
          html_text = res['pesan'];
          $('.info-modal-edit-data-diri').html(html_text);
          $('.isi-modal-edit-data-diri').attr("hidden", true);
          $('.info-modal-edit-data-diri').attr("hidden", false);
          $('#button_save_revisi').attr("hidden", true);
        }
      },
      error: function(xhr, status, error) {
        html_text = "<strong><span style='color:#FF0000;'>ERROR.</span> Silahkan foto pesan error di bawah dan kirimkan ke whatsapp IT Care di nomor: 085174123434</strong>";
        html_text = html_text + "<iframe srcdoc='" + xhr.responseText + "' style='zoom:1' frameborder='0' height='250' width='99.6%'></iframe>";
        // html_text = "Gagal fetch data. Kode error: " + xhr.status;
        $('.info-modal-edit-data-diri').html(html_text); //coba pake iframe
        $('.isi-modal-edit-data-diri').attr("hidden", true);
        $('.info-modal-edit-data-diri').attr("hidden", false);
        $('#button_save_revisi').attr("hidden", true);
      }
    });

    $('#first_name_modal').html(id);

    $('#openRevisiModal').appendTo("body").modal('show');
    // alert("masuk fungsi accept. id: " + id);
    // window.open('<?= base_url() ?>admin/Importexcel/view_batch_saltab_release/' + id, "_self");
  }
</script>

<!-- Tombol Accept Request -->
<script type="text/javascript">
  document.getElementById("button_save_revisix").onclick = function(e) {
    var id_modal = $("#id_modal").val();


    $.ajax({
      url: '<?= base_url() ?>admin/employee_resign_cancelled/save_revisi_paklaring/',
      method: 'post',
      data: {
        [csrfName]: csrfHash,
        id: id_modal,
      },
      success: function(response) {
        alert("Berhasil Accept Request");
        saltab_table.ajax.reload(null, false);
        $('#openRevisiModal').appendTo("body").modal('hide');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert("Gagal Accept Request. Status : " + xhr.status);
        alert("responseText :" + xhr.responseText);
        $('#openRevisiModal').appendTo("body").modal('hide');
      },
    });

    // alert("ACCEPT "+id_modal);

  };
</script>