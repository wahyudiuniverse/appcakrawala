<?php $result = $this->Employees_model->read_employee_info_by_nik($employee_id);

  
        $designation = $this->Designation_model->read_designation_information($result[0]->designation_id);
        if(!is_null($designation)){
          $designation_name = $designation[0]->designation_name;
        } else {
          $designation_name = '--'; 
        }

?>



            <div class="col-md-12">

              <div class="row">
                <!--TANGGAL BERGABUNG-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="department_id"><?php echo $this->lang->line('xin_employee_doj');?><i class="hrpremium-asterisk"></i></label>
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="form-group">
                    <label for="department_id">: <?php echo $result[0]->date_of_joining;?><i class="hrpremium-asterisk"></i></label>
                  </div>
                </div>
              </div>

              <div class="row">
                <!--POSISI JABATAN-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="department_id"><?php echo $this->lang->line('dashboard_designation');?><i class="hrpremium-asterisk"></i></label>
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="form-group">
                    <label for="department_id">: <?php echo $designation_name;?><i class="hrpremium-asterisk"></i></label>
                  </div>
                </div>
              </div>


              <div class="row">
                <!--LOKASI PENEMPATAN-->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="department_id"><?php echo $this->lang->line('left_lokasi_penempatan');?><i class="hrpremium-asterisk"></i></label>
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="form-group">
                    <label for="department_id">: <?php echo $result[0]->penempatan;?><i class="hrpremium-asterisk"></i></label>
                  </div>
                </div>
              </div>

            <!-- end row -->
            </div>


<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });

});
</script>