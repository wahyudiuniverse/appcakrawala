<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['company_id']) && $_GET['data']=='company'){
?>

<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><i class="icon-pencil7"></i>UPLOAD >> Dokumen PKWT / <?php echo $idrequest;?></h4>
  </div>


  <?php $attributes = array('name' => 'edit_company', 'id' => 'edit_company', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $_GET['company_id'], 'ext_name' => $idrequest);?>
  <?php echo form_open_multipart('admin/employees/updatepkwt/'.$idrequest, $attributes, $hidden);?>


 <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- NAMA LENGKAP -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi">NIP</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': '.$nip;?></label>
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
          <label for="no_transaksi">Nama File</label>
        </div>
      </div>
      <div class="col-sm-8">
        <div>
          <label for="plant"> : <a href="<?php echo $file_name;?>" target="_blank"> <?php echo $file_name;?></a> </label> 
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
          <label for="no_transaksi">Nomor Dokumen:</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': '.$no_surat;?></label>
        </div>
      </div>
    </div>
  </div>

  <input class="form-control" name="idtransaksi" type="text" value="<?php echo $idrequest;?>" hidden>


 <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- NAMA LENGKAP -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi">Tanggal Upload PKWT</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': '.$tgl_upload_pkwt;?></label>
        </div>
      </div>
    </div>
  </div>
  
<!-- EXIT CLEARANCE -->
 <hr style="height:1px;border-width:0;color:gray;background-color:#e3e3e3; margin: auto;">
  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- PENEMPATAN -->

      <input name="dexitc" type="text" value="<?php echo $file_name;?>" hidden>

      <div class="col-sm-4" hidden>
        <div>
          <label for="penempatan">Pilih Dokumen PKWT</label>
        </div>
      </div>
      <div class="col-sm-4" hidden>
        <div>

                          <div class="form-group">
                            <fieldset class="form-group">
                              <input type="file" class="form-control-file" id="document_file_pkwt" name="document_file_pkwt" accept="application/pdf">
                              <small>Jenis File: PDF | Size MAX 3 MB</small>
                            </fieldset>
                          </div>
        </div>
      </div>

    </div>
  </div>



  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>


    
  </div>

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
               var xin_table = $('#xin_table_contract').dataTable({
        "bDestroy": true,
    "ajax": {

            url : site_url+"profile/contract/"+$('#user_id').val(),
            // url : base_url+"/profile/1",
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

