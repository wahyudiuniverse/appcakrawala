<?php //$result = $this->Employees_model->read_employee_info_by_nik($employee_id);

  
        // $designation = $this->Designation_model->read_designation_information($result[0]->designation_id);
        // if(!is_null($designation)){
        //   $designation_name = $designation[0]->designation_name;
        // } else {
        //   $designation_name = '--'; 
        // }
        if($status=='2'){ //resign

          if($project=='22'){
                ?>
                <div class="row">
                  <!--NO KP-->
                  <div class="col-md-8">
                    <br>
                    <div class="form-group">
                    <label for="dok_exitc">Upload Exit Clearance<i class="hrpremium-asterisk">*</i></label>
                    <br>
                    <p class="form-row"> &nbsp;&nbsp;
                      <input type="file" id="dok_exitc" name="dok_exitc" />
                    </p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <!--NO KP-->
                  <div class="col-md-8">
                    <br>
                    <div class="form-group">
                    <label for="dok_sresign">Upload Surat Resign<i class="hrpremium-asterisk">*</i></label>
                    <br>
                    <p class="form-row"> &nbsp;&nbsp;
                      <input type="file" id="dok_sresign" name="dok_sresign" />
                    </p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <!--NO KP-->
                  <div class="col-md-8">
                    <br>
                    <div class="form-group">
                    <label for="dok_sover">Upload Surat Hand Over<i class="hrpremium-asterisk">*</i></label>
                    <br>
                    <p class="form-row"> &nbsp;&nbsp;
                      <input type="file" id="dok_sover" name="dok_sover" />
                    </p>
                    </div>
                  </div>
                </div>
                <?php
          } else {
                ?>
                <div class="row">
                  <!--NO KP-->
                  <div class="col-md-8">
                    <br>
                    <div class="form-group">
                    <label for="date_of_birth">Upload Exit Clearance<i class="hrpremium-asterisk">*</i></label>
                    <br>
                    <p class="form-row"> &nbsp;&nbsp;
                      <input type="file" id="dok_exitc" name="dok_exitc" />
                    </p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <!--NO KP-->
                  <div class="col-md-8">
                    <br>
                    <div class="form-group">
                    <label for="date_of_birth">Upload Surat Resign<i class="hrpremium-asterisk">*</i></label>
                    <br>
                    <p class="form-row"> &nbsp;&nbsp;
                      <input type="file" id="dok_sresign" name="dok_sresign" />
                    </p>
                    </div>
                  </div>
                </div>

                <div class="row" hidden>
                  <!--NO KP-->
                  <div class="col-md-8">
                    <br>
                    <div class="form-group">
                    <label for="date_of_birth">Upload Surat Hand Over<i class="hrpremium-asterisk"></i></label>
                    <br>
                    <p class="form-row"> &nbsp;&nbsp;
                      <input type="file" id="dok_sover" name="dok_sover" />
                    </p>
                    </div>
                  </div>
                </div>
                <?php
          }

        } else if ($status=='3') { //bad atitude
                ?>
                <div class="row">
                  <!--NO KP-->
                  <div class="col-md-8">
                    <br>
                    <div class="form-group">
                    <label for="date_of_birth">Upload Exit Clearance <i class="hrpremium-asterisk"> (additional)</i></label>
                    <br>
                    <p class="form-row"> &nbsp;&nbsp;
                      <input type="file" id="dok_exitc" name="dok_exitc" />
                    </p>
                    </div>
                  </div>
                </div>

                <div class="row" hidden>
                  <!--NO KP-->
                  <div class="col-md-8">
                    <br>
                    <div class="form-group">
                    <label for="date_of_birth">Upload Surat Resign<i class="hrpremium-asterisk"></i></label>
                    <br>
                    <p class="form-row"> &nbsp;&nbsp;
                      <input type="file" id="dok_sresign" name="dok_sresign" />
                    </p>
                    </div>
                  </div>
                </div>

                <div class="row" hidden>
                  <!--NO KP-->
                  <div class="col-md-8">
                    <br>
                    <div class="form-group">
                    <label for="date_of_birth">Upload Surat Hand Over<i class="hrpremium-asterisk"></i></label>
                    <br>
                    <p class="form-row"> &nbsp;&nbsp;
                      <input type="file" id="dok_sover" name="dok_sover" />
                    </p>
                    </div>
                  </div>
                </div>
                <?php
        } else if ($status=='4') { //end contract
                ?>
                <div class="row">
                  <!--NO KP-->
                  <div class="col-md-8">
                    <br>
                    <div class="form-group">
                    <label for="date_of_birth">Upload Exit Clearance<i class="hrpremium-asterisk">*</i></label>
                    <br>
                    <p class="form-row"> &nbsp;&nbsp;
                      <input type="file" id="dok_exitc" name="dok_exitc" />
                    </p>
                    </div>
                  </div>
                </div>

                <div class="row" hidden>
                  <!--NO KP-->
                  <div class="col-md-8">
                    <br>
                    <div class="form-group">
                    <label for="date_of_birth">Upload Surat Resign<i class="hrpremium-asterisk"></i></label>
                    <br>
                    <p class="form-row"> &nbsp;&nbsp;
                      <input type="file" id="dok_sresign" name="dok_sresign" />
                    </p>
                    </div>
                  </div>
                </div>

                <div class="row" hidden>
                  <!--NO KP-->
                  <div class="col-md-8">
                    <br>
                    <div class="form-group">
                    <label for="date_of_birth">Upload Surat Hand Over<i class="hrpremium-asterisk"></i></label>
                    <br>
                    <p class="form-row"> &nbsp;&nbsp;
                      <input type="file" id="dok_sover" name="dok_sover" />
                    </p>
                    </div>
                  </div>
                </div>
                <?php
        }
?>


<!-- ?> -->


<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });

});
</script>