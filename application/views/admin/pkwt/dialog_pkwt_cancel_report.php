<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['company_id']) && $_GET['data']=='company'){
?>

<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
  <?php 

    if(!is_null($employee)){
      $fullname = $employee[0]->first_name;
    } else {
      $fullname = '-';
    }

    if(!is_null($project)){
      $project_name = $project[0]->title;
    } else {
      $project_name = '-';
    }

  ?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    <h4 class="modal-title" id="edit-modal-data"><i class="icon-pencil7"></i> HAPUS PKWT REPORT</h4>
  </div>


  <?php $attributes = array('name' => 'edit_company', 'id' => 'edit_company', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
  <?php $hidden = array('_method' => 'EDIT', '_token' => $_GET['company_id'], 'ext_name' => $contract_id);?>
  <?php echo form_open_multipart('admin/Employee_pkwt_cancel/update_pkwt_report/'.$contract_id, $attributes, $hidden);?>


 <hr style="height:1px;border-width:0;color:gray;background-color:gray; margin: auto;">

  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- KTP -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi">No PKWT</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': '.$no_surat;?></label>
        </div>
      </div>
    </div>
  </div>



 <hr style="height:1px;border-width:0;color:gray;background-color:gray; margin: auto;">

  <div class="modal-body" style="padding-top: 6px; padding-bottom: 6px;">
    <div class="row">
      <!-- KTP -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi">NIP</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <input type="" name="employeeID" value="<?php echo $nip;?>" hidden>
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
          <label for="no_transaksi"><?php echo $this->lang->line('xin_employees_full_name');?></label>
        </div>
      </div>
      <div class="col-sm-4">
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
      <!-- POSISI/JABATAN -->
      <div class="col-sm-4">
        <div>
          <label for="no_transaksi">Project</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': '.$project_name;?></label>
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
          <label for="no_transaksi">Penempatan</label>
        </div>
      </div>
      <div class="col-sm-4">
        <div>
          <label for="plant"><?php echo ': '.$penempatan;?></label>
        </div>
      </div>
    </div>
  </div>


  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>

    <?php if(in_array('490',$role_resources_ids)) { ?>
    <button type="submit" class="btn btn-danger save">HAPUS PKWT</button>
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



    // var company_id = document.getElementById("aj_company").value;
    var project_id = document.getElementById("aj_project").value;
    var subproject_id = document.getElementById("aj_subproject").value;
    var area_emp = document.getElementById("aj_area_emp").value;
    var start_date = document.getElementById("start_date").value;
    var end_date = document.getElementById("end_date").value;


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

            url : site_url+"reports/pkwt_history_list/"+project_id+"/"+start_date+"/"+end_date+"/",

            // url : base_url+"/pkwt_list_appcancel/",
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

