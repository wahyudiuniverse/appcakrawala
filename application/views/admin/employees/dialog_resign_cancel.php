<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['company_id']) && $_GET['data']=='company'){
?>

<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
  <?php 

    if(!is_null($request_by)){
      $request_name = $request_by[0]->first_name;
      $request_date = $request_resign_date;
    } else {
      $request_name = '-';
      $request_date = '-';
    }

    if(!is_null($approve_nae)){
      $approve_nae_by = $approve_nae[0]->first_name;
      $approve_nae_date = $approve_resignnae_on;
    } else {
      $approve_nae_by = '-';
      $approve_nae_date = '-';
    }

    if(!is_null($approve_nom)){
      $approve_nom_by = $approve_nom[0]->first_name;
      $approve_nom_date = $approve_resignnom_on;
    } else {
      $approve_nom_by = '-';
      $approve_nom_date = '-';
    }

    if(!is_null($approve_hrd)){
      $approve_hrd_by = $approve_hrd[0]->first_name;
      $approve_hrd_date = $approve_resignhrd_on;
    } else {
      $approve_hrd_by = '-';
      $approve_hrd_date = '-';
    }

    if($status_resign==2){
      $statusResign = 'RESIGN';
    } else if ($status_resign == 3) {
      $statusResign = 'BLACKLIST';
    } else {
      $statusResign = 'END CONTRACT';
    }
    
  ?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><i class="icon-pencil7"></i> REVISI PENGAJUAN PAKLARING</h4>
  </div>


  <?php $attributes = array('name' => 'edit_company', 'id' => 'edit_company', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $_GET['company_id'], 'ext_name' => $idrequest);?>
  <?php echo form_open_multipart('admin/Employee_resign_cancelled/update/'.$idrequest.'/YES', $attributes, $hidden);?>

 <hr style="height:1px;border-width:0;color:gray;background-color:gray; margin: auto;">

  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- KTP -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi">Nomor KTP</label>
        </div>
      </div>
      <div class="col-sm-6">
        <div>
          <label for="plant"><?php echo ': '.$nik_ktp.' ['.$statusResign.']';?></label>
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
          <label for="no_transaksi"><?php echo $this->lang->line('xin_employees_full_name');?></label>
        </div>
      </div>
      <div class="col-sm-6">
        <div>
          <label for="plant"><?php echo ': '.$fullname;?></label>
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
          <label for="no_transaksi"><?php echo $this->lang->line('left_projects');?></label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': '.$project[0]->title;?></label>
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
          <label for="plant"><?php echo ': '.$posisi[0]->designation_name;?></label>
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
          <label for="no_transaksi"><?php echo $this->lang->line('xin_employee_doj');?></label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': '.$doj;?></label>
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
          <label for="no_transaksi"><?php echo $this->lang->line('xin_contact_number');?></label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': '.$contact_no;?></label>
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
          <label for="alamat_ktp"><?php echo $this->lang->line('xin_address');?></label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': '.$alamat_ktp;?></label>
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
          <label for="penempatan"><?php echo $this->lang->line('xin_placement');?></label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': '.$penempatan;?></label>
        </div>
      </div>
    </div>
  </div>


<!-- SURAT RESIGN -->
 <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;" <?php if($status_resign!=2){?> hidden <?php } ?>>
    <div class="row">
      <!-- PENEMPATAN -->

      <input name="dsresign" type="text" value="<?php echo $dok_resign_letter;?>" hidden>

      <div class="col-sm-4">
        <div>
          <label for="penempatan">Surat Resign</label>
        </div>
      </div>
      <div class="col-sm-6">
        <div>
                          <div class="form-group">
                            <fieldset class="form-group">
                              <input type="file" class="form-control-file" id="dok_sresign" name="dok_sresign">
                              <small>Jenis File: .pdf</small>
                            </fieldset>
                          </div>
        </div>
      </div>
                          <?php 


        if(is_null($dok_resign_letter)) {
          $vsrs = '';
        } else {

          $nama_file_sresign = $dok_resign_letter;
          //kalau blm ada folder path nya
          if (file_exists($nama_file_sresign)) {
            // $pesan = "ada file"; //tampil file skema terbaru
              echo '<a href="'.base_url().$nama_file_sresign.'" target="_blank"><button type="button" class="btn btn-xs btn-outline-info" style="height: max-content;padding: 10px;">Lihat Dokumen</button></a>';
          } else {
              echo '<a href="'.base_url().'uploads/document/exit/2023/12/'.$nama_file_sresign.'" target="_blank"><button type="button" class="btn btn-xs btn-outline-info" style="height: max-content;padding: 10px;">Lihat Dokumen</button></a>';
          }
        }
    ?>
    </div>
  </div>



<!-- EXIT CLEARANCE -->
 <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- PENEMPATAN -->

      <input name="dexitc" type="text" value="<?php echo $dok_exit_clearance;?>" hidden>

      <div class="col-sm-4">
        <div>
          <label for="penempatan">Exit Clearance</label>
        </div>
      </div>

      <div class="col-sm-6">
        <div>
          
                          <div class="form-group">
                            <fieldset class="form-group">
                              <input type="file" class="form-control-file" id="dok_exitc" name="dok_exitc">
                              <small>Jenis File: .pdf</small>
                            </fieldset>
                          </div>
        </div>
      </div>

                          <?php 

        if(is_null($dok_exit_clearance)) {
          $vexc = '';
        } else {

          $nama_file_exit = $dok_exit_clearance;
          //kalau blm ada folder path nya
          if (file_exists($nama_file_exit)) {
            // $pesan = "ada file"; //tampil file skema terbaru
              echo '<a href="'.base_url().$nama_file_exit.'" target="_blank"><button type="button" class="btn btn-xs btn-outline-info" style="height: max-content;padding: 10px;">Lihat Dokumen</button></a>';
          } else {
              echo '<a href="'.base_url().'uploads/document/exit/2023/12/'.$nama_file_exit.'" target="_blank"><button type="button" class="btn btn-xs btn-outline-info" style="height: max-content;padding: 10px;">Lihat Dokumen</button></a>';
          }
        }
    ?>

    </div>
  </div>


<!-- SURAT HAND OVER -->
 <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- PENEMPATAN -->

      <input name="dhover" type="text" value="<?php echo $dok_over_hand;?>" hidden>

      <div class="col-sm-4">
        <div>
          <label for="penempatan">Hand Over</label>
        </div>
      </div>

      <div class="col-sm-6">
        <div>
          
                          <div class="form-group">
                            <fieldset class="form-group">
                              <input type="file" class="form-control-file" id="dok_hover" name="dok_hover">
                              <small>Jenis File: .pdf</small>
                            </fieldset>
                          </div>
        </div>
      </div>

                          <?php 

        if(is_null($dok_over_hand)) {
          $vexc = '';
        } else {

          $nama_file_over = $dok_over_hand;
          //kalau blm ada folder path nya
          if (file_exists($nama_file_over)) {
            // $pesan = "ada file"; //tampil file skema terbaru
              echo '<a href="'.base_url().$nama_file_over.'" target="_blank"><button type="button" class="btn btn-xs btn-outline-info" style="height: max-content;padding: 10px;">Lihat Dokumen</button></a>';
          } else {
              echo '<a href="'.base_url().'uploads/document/exit/2023/12/'.$nama_file_over.'" target="_blank"><button type="button" class="btn btn-xs btn-outline-info" style="height: max-content;padding: 10px;">Lihat Dokumen</button></a>';
          }
        }
    ?>

    </div>
  </div>



 <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 1px; padding-bottom: 1px;" >
    <div class="row" style="background-color: #ff4f4f;">
      <!-- REQUESTED -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi" style="color: white;">Tanggal Ditolak</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant" style="color: white;"><?php echo ': '.$cancel_date;?></label>
        </div>
      </div>
    </div>
  </div>

 <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 1px; padding-bottom: 1px;" >
    <div class="row" style="background-color: #ff4f4f;">
      <!-- REQUESTED -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi" style="color: white;">Alasan Ditolak</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant" style="color: white;"><?php echo ': '.$info_revisi;?></label>
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
          <label for="no_transaksi"><?php echo $this->lang->line('xin_request_employee_by');?></label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': '.$request_name. ' ('.$request_date.')';?></label>
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
          <label for="no_transaksi"><?php echo $this->lang->line('xin_request_employee_approvenae');?></label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': '.$approve_nae_by. ' ('.$approve_nae_date.')';?></label>
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
          <label for="no_transaksi"><?php echo $this->lang->line('xin_request_employee_approvenom');?></label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': '.$approve_nom_by. ' ('.$approve_nom_date.')';?></label>
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
          <label for="no_transaksi"><?php echo $this->lang->line('xin_request_employee_approvehrd');?></label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': '.$approve_hrd_by. ' ('.$approve_hrd_date.')';?></label>
        </div>
      </div>
    </div>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>

    <?php if(in_array('490',$role_resources_ids)) { ?>
    <button type="submit" class="btn btn-success save">SAVE REVISI</button>
    <?php } ?>
    
  </div>
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

<?php echo form_close(); ?>
<script type="text/javascript">

 $(document).ready(function(){
							
		$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
		$('[data-plugin="select_hrm"]').select2({ width:'100%' });	
		$('.d_date').bootstrapMaterialDatePicker({
			weekStart: 0,
			time: false,
			clearButton: false,
			format: 'YYYY-MM-DD'
		}); 
		
		Ladda.bind('button[type=submit]');
		/* Edit data */
		$("#edit_company").submit(function(e){
			var fd = new FormData(this);
			var obj = $(this), action = obj.attr('name');
			fd.append("is_ajax", 2);
			fd.append("edit_type", 'company');
			fd.append("form", action);
			e.preventDefault();
			$('.save').prop('disabled', true);
			$.ajax({
				url: e.target.action,
				type: "POST",
				data:  fd,
				contentType: false,
				cache: false,
				processData:false,
				success: function(JSON)
				{
					if (JSON.error != '') {
						toastr.error(JSON.error);
						$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
						$('.save').prop('disabled', false);
						Ladda.stopAll();
					} else {
						// On page load: datatable
               var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
    "ajax": {
            url : base_url+"/resign_list_cancel/",
            type : 'GET'
        },
    dom: 'lBfrtip',
    "buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
    "fnDrawCallback": function(settings){
    $('[data-toggle="tooltip"]').tooltip();          
    }
    });

						xin_table.api().ajax.reload(function(){ 
							toastr.success(JSON.result);
						}, true);
						$('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
						$('.edit-modal-data').modal('toggle');
						$('.save').prop('disabled', false);
						Ladda.stopAll();
					}
				},
				error: function() 
				{
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

