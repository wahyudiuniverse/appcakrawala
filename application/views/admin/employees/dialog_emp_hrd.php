<?php
defined('BASEPATH') or exit('No direct script access allowed');
if (isset($_GET['jd']) && isset($_GET['company_id']) && $_GET['data'] == 'company') {
?>

  <?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
  <?php

  $session = $this->session->userdata('username');

  if (!is_null($request_empby)) {
    $requets_name = $request_empby[0]->first_name;
  } else {
    $requets_name = '--';
  }

  if (!is_null($approved_naeby)) {
    $approve_nae_name = $approved_naeby[0]->first_name;
  } else {
    $approve_nae_name = '--';
  }
  if (!is_null($approved_nomby)) {
    $approved_nom_name = $approved_nomby[0]->first_name;
  } else {
    $approved_nom_name = '--';
  }

  if (!is_null($approved_hrdby)) {
    $approved_hrd_name = $approved_hrdby[0]->first_name;
  } else {
    $approved_hrd_name = '--';
  }

  if (!is_null($sub_project)) {
    $sub_project = $sub_project[0]->sub_project_name;
  } else {
    $sub_project = '--';
  }

  if (!is_null($posisi)) {
    $jabatan = $posisi[0]->designation_name;
  } else {
    $jabatan = '--';
  }


  if($e_status==1){
    $jenis_dokumen = 'PKWT';
  } else if($e_status==2) {
    $jenis_dokumen = 'TKHL';
  } else {
    $jenis_dokumen = 'TIDKA DIKETAHUI';
  }

  ?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><i class="icon-pencil7"></i>HO - HRD >> Approval Karyawan Baru</h4>
  </div>


  <?php $attributes = array('name' => 'edit_company', 'id' => 'edit_company', 'autocomplete' => 'off', 'class' => 'm-b-1'); ?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $_GET['company_id'], 'ext_name' => $idrequest); ?>
  <?php echo form_open_multipart('admin/employee_request_hrd/update2/' . $idrequest, $attributes, $hidden); ?>

  <hr style="height:1px;border-width:0;color:gray;background-color:gray; margin: auto;">

  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- KTP -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi">Nomor KTP</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': ' . $nik_ktp; ?></label>
        </div>
      </div>
    </div>
  </div>

  <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- NAMA LENGKAP -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi"><?php echo $this->lang->line('xin_employees_full_name'); ?></label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': ' . $fullname; ?></label>
        </div>
      </div>
    </div>
  </div>


  <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- PROJECT -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi"><?php echo $this->lang->line('left_projects'); ?></label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': ' . $project[0]->title; ?></label>
        </div>
      </div>
    </div>
  </div>

  <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- SUB PROJECT -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi"><?php echo $this->lang->line('left_sub_projects'); ?></label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': ' . $sub_project; ?></label>
        </div>
      </div>
    </div>
  </div>

  <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- POSISI/JABATAN -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi">Posisi/Jabatan</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': ' . $jabatan; ?></label>
        </div>
      </div>
    </div>
  </div>

  <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- JOINDATE -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi"><?php echo $this->lang->line('xin_employee_doj'); ?></label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': ' . $doj; ?></label>
        </div>
      </div>
    </div>
  </div>

  <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- JOINDATE -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi"><?php echo $this->lang->line('xin_contact_number'); ?></label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': ' . $contact_no; ?></label>
        </div>
      </div>
    </div>
  </div>


  <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- ALAMAT KTP -->
      <div class="col-sm-4">
        <div>
          <label for="alamat_ktp"><?php echo $this->lang->line('xin_address'); ?></label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': ' . $alamat_ktp; ?></label>
        </div>
      </div>
    </div>
  </div>

  <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- PENEMPATAN -->
      <div class="col-sm-4">
        <div>
          <label for="penempatan"><?php echo $this->lang->line('xin_placement'); ?></label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': ' . $penempatan; ?></label>
        </div>
      </div>
    </div>
  </div>

  <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- JENIS DOKUMEN -->
      <div class="col-sm-4">
        <div>
          <label for="jenis_dokumen">Jenis Dokumen</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': ' . $jenis_dokumen; ?></label>
        </div>
      </div>
    </div>
  </div>

  <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- JOINDATE -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi">Waktu Kontrak</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': ' . $waktu_kontrak; ?></label>
        </div>
      </div>
    </div>
  </div>

  <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- ALAMAT KTP -->
      <div class="col-sm-4">
        <div>
          <label for="alamat_ktp">Periode Kontrak</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': ' . $begin; ?></label>
        </div>
      </div>
    </div>
  </div>

  <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- PENEMPATAN -->
      <div class="col-sm-4">
        <div>
          <label for="cutoff">CUT-OFF</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': ' . $cut_off; ?></label>
        </div>
      </div>
    </div>
  </div>

  <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- PENEMPATAN -->
      <div class="col-sm-4">
        <div>
          <label for="penempatan">HK</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': ' . $hari_kerja; ?></label>
        </div>
      </div>
    </div>
  </div>

  <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- REQUESTED -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi">Gaji Pokok</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': ' . $this->Xin_model->rupiah($basic_pay); ?></label>
        </div>
      </div>
    </div>
  </div>


  <!-- TUNJANGAN -->
  <?php if ($allowance_grade != "0") { ?>
    <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
    <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
      <div class="row">
        <!-- APPROVED -->
        <div class="col-sm-4">
          <div>
            <label for="no_transaksi">Tujangan Jabatan</label>
          </div>
        </div>
        <div class="col-sm-4">
          <div>
            <label for="plant"><?php echo ': ' . $this->Xin_model->rupiah($allowance_grade) . ' /' . $dm_allow_grade; ?></label>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php if ($allowance_masakerja != "0") { ?>
    <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
    <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
      <div class="row">
        <!-- APPROVED -->
        <div class="col-sm-4">
          <div>
            <label for="no_transaksi">Tunjangan Masa Kerja</label>
          </div>
        </div>
        <div class="col-sm-4">
          <div>
            <label for="plant"><?php echo ': ' . $this->Xin_model->rupiah($allowance_masakerja) . ' (' . $dm_allow_masakerja . ')'; ?></label>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php if ($allowance_meal != "0") { ?>
    <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
    <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
      <div class="row">
        <!-- APPROVED -->
        <div class="col-sm-4">
          <div>
            <label for="no_transaksi">Tunjangan Makan</label>
          </div>
        </div>
        <div class="col-sm-4">
          <div>
            <label for="plant"><?php echo ': ' . $this->Xin_model->rupiah($allowance_meal) . ' /' . $dm_allow_meal; ?></label>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php if ($allowance_transport != "0") { ?>
    <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
    <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
      <div class="row">
        <!-- APPROVED -->
        <div class="col-sm-4">
          <div>
            <label for="no_transaksi">Tunjangan Transport</label>
          </div>
        </div>
        <div class="col-sm-4">
          <div>
            <label for="plant"><?php echo ': ' . $this->Xin_model->rupiah($allowance_transport) . ' /' . $dm_allow_transport; ?></label>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php if ($allowance_rent != "0") { ?>
    <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
    <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
      <div class="row">
        <!-- APPROVED -->
        <div class="col-sm-4">
          <div>
            <label for="no_transaksi">Tunjangan Sewa</label>
          </div>
        </div>
        <div class="col-sm-4">
          <div>
            <label for="plant"><?php echo ': ' . $this->Xin_model->rupiah($allowance_rent) . ' /' . $dm_allow_rent; ?></label>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php if ($allowance_komunikasi != "0") { ?>
    <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
    <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
      <div class="row">
        <!-- APPROVED -->
        <div class="col-sm-4">
          <div>
            <label for="no_transaksi">Tunjangan Komunikasi</label>
          </div>
        </div>
        <div class="col-sm-4">
          <div>
            <label for="plant"><?php echo ': ' . $this->Xin_model->rupiah($allowance_komunikasi) . ' /' . $dm_allow_komunikasi; ?></label>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php if ($allowance_park != "0") { ?>
    <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
    <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
      <div class="row">
        <!-- APPROVED -->
        <div class="col-sm-4">
          <div>
            <label for="no_transaksi">Tunjangan Parkir</label>
          </div>
        </div>
        <div class="col-sm-4">
          <div>
            <label for="plant"><?php echo ': ' . $this->Xin_model->rupiah($allowance_park) . ' /' . $dm_allow_park; ?></label>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php if ($allowance_residance != "0") { ?>
    <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
    <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
      <div class="row">
        <!-- APPROVED -->
        <div class="col-sm-4">
          <div>
            <label for="no_transaksi">Tunjangan Tempat Tinggal</label>
          </div>
        </div>
        <div class="col-sm-4">
          <div>
            <label for="plant"><?php echo ': ' . $this->Xin_model->rupiah($allowance_residance) . ' /' . $dm_allow_residance; ?></label>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php if ($allowance_laptop != "0") { ?>
    <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
    <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
      <div class="row">
        <!-- APPROVED -->
        <div class="col-sm-4">
          <div>
            <label for="no_transaksi">Tunjangan Laptop</label>
          </div>
        </div>
        <div class="col-sm-4">
          <div>
            <label for="plant"><?php echo ': ' . $this->Xin_model->rupiah($allowance_laptop) . ' /' . $dm_allow_laptop; ?></label>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php if ($allowance_kasir != "0") { ?>
    <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
    <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
      <div class="row">
        <!-- APPROVED -->
        <div class="col-sm-4">
          <div>
            <label for="no_transaksi">Tunjangan Kasir</label>
          </div>
        </div>
        <div class="col-sm-4">
          <div>
            <label for="plant"><?php echo ': ' . $this->Xin_model->rupiah($allowance_kasir) . ' /' . $dm_allow_kasir; ?></label>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php if ($allowance_transmeal != "0") { ?>
    <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
    <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
      <div class="row">
        <!-- APPROVED -->
        <div class="col-sm-4">
          <div>
            <label for="no_transaksi">Tunjangan Tranport-Makan</label>
          </div>
        </div>
        <div class="col-sm-4">
          <div>
            <label for="plant"><?php echo ': ' . $this->Xin_model->rupiah($allowance_transmeal) . ' /' . $dm_allow_transmeal; ?></label>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php if ($allowance_medicine != "0") { ?>
    <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
    <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
      <div class="row">
        <!-- APPROVED -->
        <div class="col-sm-4">
          <div>
            <label for="no_transaksi">Tunjangan Kesehatan</label>
          </div>
        </div>
        <div class="col-sm-4">
          <div>
            <label for="plant"><?php echo ': ' . $this->Xin_model->rupiah($allowance_medicine) . ' /' . $dm_allow_medicine; ?></label>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>



  <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- REQUESTED -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi">Dokumen</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <?php if($ktp=='' || $ktp=='0'){?>
            <button type="button" class="btn btn-xs btn-secondary">KTP</button>
          <?php } else { ?>
            <a href="<?php echo base_url() . 'uploads/document/ktp/' . $ktp;?>" target="_blank"><button type="button" class="btn btn-xs btn-outline-success">KTP</button></a>
          <?php } ?>

          <?php if($kk=='' || $kk=='0'){?>
             <a href="#" target="_blank"><button type="button" class="btn btn-xs btn-outline-info">KK</button></a>
          <?php } else { ?>
            <a href="<?php echo base_url() . 'uploads/document/kk/' . $kk;?>" target="_blank"><button type="button" class="btn btn-xs btn-outline-success">KK</button></a>
          <?php } ?>

          <?php if($skck=='' || $skck=='0'){?>
            <button type="button" class="btn btn-xs btn-secondary">SKCK</button>
          <?php } else { ?>
            <a href="<?php echo base_url() . 'uploads/document/skck/' . $skck;?>" target="_blank"><button type="button" class="btn btn-xs btn-outline-success">SKCK</button></a>
          <?php } ?>

          <?php if($ijazah=='' || $ijazah=='0'){?>
            <button type="button" class="btn btn-xs btn-secondary">IJAZAH</button>
          <?php } else { ?>
            <a href="<?php echo base_url() . 'uploads/document/ijazah/' . $ijazah;?>" target="_blank"><button type="button" class="btn btn-xs btn-outline-success">IJAZAH</button></a>
          <?php } ?>

          <?php if($cv=='' || $cv=='0'){?>
            <button type="button" class="btn btn-xs btn-secondary">CV</button>
          <?php } else { ?>
            <a href="<?php echo base_url() . 'uploads/document/cv/' . $cv;?>" target="_blank"><button type="button" class="btn btn-xs btn-outline-success">CV</button></a>
          <?php } ?>

        </div>
      </div>
    </div>
  </div>


  <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- REQUESTED -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi"><?php echo $this->lang->line('xin_request_employee_by'); ?></label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': ' . $requets_name . ' (' . $request_empon . ')'; ?></label>
        </div>
      </div>
    </div>
  </div>

  <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- APPROVED -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi">Approve HRD</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': ' . $approved_hrd_name . ' (' . $approved_hrdon . ')'; ?></label>
        </div>
      </div>
    </div>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close'); ?></button>


    <?php if (in_array('382', $role_resources_ids)) { ?>
      <button type="submit" id="approve_new_emp" class="btn btn-primary save">APPROVE HRD</button>
    <?php } ?>

  </div>

  <?php echo form_close(); ?>
  <script type="text/javascript">
    $(document).ready(function() {

      $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
      $('[data-plugin="select_hrm"]').select2({
        width: '100%'
      });
      $('.d_date').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        clearButton: false,
        format: 'YYYY-MM-DD'
      });

      Ladda.bind('button[type=submit]');
      /* Edit data */
      $("#edit_company").submit(function(e) {
        var fd = new FormData(this);
        var obj = $(this),
          action = obj.attr('name');
        fd.append("is_ajax", 2);
        fd.append("edit_type", 'company');
        fd.append("form", action);
        e.preventDefault();
        $('.save').prop('disabled', true);
        $.ajax({
          url: e.target.action,
          type: "POST",
          data: fd,
          contentType: false,
          cache: false,
          processData: false,


          beforeSend: function() {
            $('#approve_new_emp').attr("hidden",true);
                    // $('#editKontakModal').modal('show');
                    // $('.info-modal-edit-JO').attr("hidden", false);
                    // $('.isi-modal-edit-JO').attr("hidden", true);
                    // $('.info-modal-edit-JO').html(loading_html_text);
                    // $('#button_save_JO').attr("hidden", true);
                    // $('#button_delete_JO').attr("hidden", true);
                  },

          success: function(response) {
            alert("Karyawan Berhasil di Approve");
            Ladda.stopAll();
            // var baseURL = "<?php echo base_url(); ?>";
            // var link_tujuan = "<?= base_url() ?>admin/employee_request_hrd/";
            // location.href = link_tujuan;
            //alert("masuk");
            // if (JSON.error != '') {
            //   alert("JSON Error");
            //   alert(toastr.error(JSON.error));
            //   toastr.error(JSON.error);
            //   $('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
            //   $('.save').prop('disabled', false);
            //   Ladda.stopAll();
            // } else {
            //   alert("berhasil save");
            //   // On page load: datatable
            //   var xin_table = $('#xin_table').dataTable({
            //     "bDestroy": true,
            //     "ajax": {
            //       url: base_url + "/request_list_hrd/",
            //       type: 'GET'
            //     },
            //     dom: 'lBfrtip',
            //     "buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
            //     "fnDrawCallback": function(settings) {
            //       $('[data-toggle="tooltip"]').tooltip();
            //     }
            //   });

            //   // var xin_table = $('#xin_table').dataTable({
            //   // 	"bDestroy": true,
            //   // 	"ajax": {
            //   // 		url : "<?php echo site_url("admin/employee_request/request_list/") ?>",
            //   // 		type : 'GET'
            //   // 	},
            //   // 	"fnDrawCallback": function(settings){
            //   // 	$('[data-toggle="tooltip"]').tooltip();          
            //   // 	}
            //   // });

            //   xin_table.api().ajax.reload(function() {
            //     toastr.success(JSON.result);
            //   }, true);
            //   $('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
            //   $('.edit-modal-data').modal('toggle');
            //   $('.save').prop('disabled', false);
            //   Ladda.stopAll();
            // }
          },
          error: function(xhr, status, error) {

            $('#approve_new_emp').attr("hidden",false);
            var pesan = xhr.responseText;
            alert(pesan);
            toastr.error(JSON.error);
            $('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
            $('.save').prop('disabled', false);
            Ladda.stopAll();
          }
        });
      });
    });
  </script>
<?php } ?>