<?php $result = $this->Employees_model->read_employee_info_by_nik($employee_id);?>


                <!-- KTP RESIGN -->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="nomor_ktp" class="control-label">Nomor KTP<i class="hrpremium-asterisk">*</i></label>
                    <input class="form-control" placeholder="Nomor KTP" name="nomor_ktp" type="text" value="<?php echo $result[0]->ktp_no;?>">
                  </div>
                </div>

                <!--TANGGAL RESIGN-->
                <div class="col-md-4">
                  <div class="form-group" id="resign_ajax">
                  <label for="date_of_birth">Tanggal BerakhirA<i class="hrpremium-asterisk">*</i></label>
                  <input class="form-control date" readonly placeholder="Tanggal Resign" name="date_of_leave" type="text" value="<?php echo $result[0]->tanggal_resign;?>">
                  
                  </div>
                </div>

                <!--STATUS RESIGN-->
                <div class="col-md-4">
                  <div class="form-group">
                   <label for="employee_id">Status Resign<i class="hrpremium-asterisk">*</i></label>
                    <select class="form-control" name="status_resign" id="aj_dokumen" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_karyawan');?>">
                      <option value=""></option>
                      <option value="2">RESIGN</option>
                      <option value="4">END CONTRACT</option>
                      <option value="3">BAD ATITUDE</option>

                    </select>
                  </div>
                </div>


<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });


  // get departments
  jQuery("#aj_dokumen").change(function(){
    var s_id = jQuery(this).val();
    var p_id = document.getElementById("aj_project").value;
    jQuery.get(base_url+"/get_dokumen_resign/"+s_id+"/"+p_id, function(data, status){
      jQuery('#dokumen_ajax').html(data);
    });
  });
  
});
</script>