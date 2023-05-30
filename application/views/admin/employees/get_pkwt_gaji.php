<?php $result = $this->Employees_model->read_employee_info_by_nik(str_replace("%20"," ",$id_project));

  
        // get company
        // $company = $this->Xin_model->read_company_info($result[0]->company_id);
        // if(!is_null($result)){
        //   $gaji_pokok = $result[0]->gaji_pokok;
        // } else {
        //   $gaji_pokok = '--';  
        // }

        // // department
        // $department = $this->Department_model->read_department_information($result[0]->department_id);
        // if(!is_null($department)){
        // $department_name = $department[0]->department_name;
        // } else {
        // $department_name = '--';  
        // }

        // $projects = $this->Project_model->read_single_project($result[0]->project_id);
        // if(!is_null($projects)){
        //   $nama_project = $projects[0]->title;
        // } else {
        //   $nama_project = '--'; 
        // }

        // $designation = $this->Designation_model->read_designation_information($result[0]->designation_id);
        // if(!is_null($designation)){
        //   $designation_name = $designation[0]->designation_name;
        // } else {
        //   $designation_name = '--'; 
        // }

?>
        <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Gaji Pokok</label>
                  </div>
                </div>

                <!--PROJECT-->
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="gaji">: <?php echo $result[0]->basic_salary;?></label>
                    <input name="gaji" type="text" value="<?php echo $result[0]->basic_salary;?>" hidden>
                  </div>
                </div>

                <?php if($result[0]->allow_jabatan!=0 || $result[0]->allow_jabatan!=null) { ?>
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Tunjangan Jabatan</label>
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="form-group" >
                    <label for="allow_grade">: <?php echo $result[0]->allow_jabatan;?></label>
                    <input name="allow_grade" type="text" value="<?php echo $result[0]->allow_jabatan;?>" hidden>
                  </div>
                </div>
                <?php } ?>

                <?php if($result[0]->allow_area!=0 || $result[0]->allow_area!=null) { ?>
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Tunjangan Area</label>
                  </div>
                </div>

                <!--PROJECT-->  
                <div class="col-md-8">
                  <div class="form-group" >
                    <label for="allow_area">: <?php echo $result[0]->allow_area;?></label>
                    <input name="allow_area" type="text" value="<?php echo $result[0]->allow_area;?>" hidden>
                  </div>
                </div>
                <?php } ?>

                <?php if($result[0]->allow_masakerja!=0 || $result[0]->allow_masakerja!=null) { ?>
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Tunjangan Masa Kerja</label>
                  </div>
                </div>

                <!--PROJECT-->  
                <div class="col-md-8">
                  <div class="form-group" >
                    <label for="allow_masakerja">: <?php echo $result[0]->allow_masakerja;?></label>
                    <input name="allow_masakerja" type="text" value="<?php echo $result[0]->allow_masakerja;?>" hidden>
                  </div>
                </div>
                <?php } ?>

                <?php if($result[0]->allow_trans_meal!=0 || $result[0]->allow_trans_meal!=null) { ?>
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Tunjangan Makan Transport</label>
                  </div>
                </div>

                <!--PROJECT-->  
                <div class="col-md-8">
                  <div class="form-group" >
                    <label for="allow_trans_meal">: <?php echo $result[0]->allow_trans_meal;?></label>
                    <input name="allow_trans_meal" type="text" value="<?php echo $result[0]->allow_trans_meal;?>" hidden>
                  </div>
                </div>
                <?php } ?>

                <?php if($result[0]->allow_konsumsi!=0 || $result[0]->allow_konsumsi!=null) { ?>
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Tunjangan Makan</label>
                  </div>
                </div>

                <!--PROJECT-->  
                <div class="col-md-8">
                  <div class="form-group" >
                    <label for="allow_konsumsi">: <?php echo $result[0]->allow_konsumsi;?></label>
                    <input name="allow_konsumsi" type="text" value="<?php echo $result[0]->allow_konsumsi;?>" hidden>
                  </div>
                </div>
                <?php } ?>

                <?php if($result[0]->allow_transport!=0 || $result[0]->allow_transport!=null) { ?>
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Tunjangan Transport</label>
                  </div>
                </div>

                <!--PROJECT-->  
                <div class="col-md-8">
                  <div class="form-group" >
                    <label for="allow_transport">: <?php echo $result[0]->allow_transport;?></label>
                    <input name="allow_transport" type="text" value="<?php echo $result[0]->allow_transport;?>" hidden>
                  </div>
                </div>
                <?php } ?>

                <?php if($result[0]->allow_comunication!=0 || $result[0]->allow_comunication!=null) { ?>
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Tunjangan Komunikasi</label>
                  </div>
                </div>

                <!--PROJECT-->  
                <div class="col-md-8">
                  <div class="form-group" >
                    <label for="allow_comunication">: <?php echo $result[0]->allow_comunication;?></label>
                    <input name="allow_comunication" type="text" value="<?php echo $result[0]->allow_comunication;?>" hidden>
                  </div>
                </div>
                <?php } ?>

                <?php if($result[0]->allow_device!=0 || $result[0]->allow_device!=null) { ?>
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Tunjangan Laptop/HP</label>
                  </div>
                </div>

                <!--PROJECT-->  
                <div class="col-md-8">
                  <div class="form-group" >
                    <label for="allow_device">: <?php echo $result[0]->allow_device;?></label>
                    <input name="allow_device" type="text" value="<?php echo $result[0]->allow_device;?>" hidden>
                  </div>
                </div>
                <?php } ?>

                <?php if($result[0]->allow_residence_cost!=0 || $result[0]->allow_residence_cost!=null) { ?>
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Tunjangan Tempat Tinggal</label>
                  </div>
                </div>

                <!--PROJECT-->  
                <div class="col-md-8">
                  <div class="form-group" >
                    <label for="allow_residance">: <?php echo $result[0]->allow_residence_cost;?></label>
                    <input name="allow_residance" type="text" value="<?php echo $result[0]->allow_residence_cost;?>" hidden>
                  </div>
                </div>
                <?php } ?>

                <?php if($result[0]->allow_rent!=0 || $result[0]->allow_rent!=null) { ?>
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Tunjangan Rental/Sewa</label>
                  </div>
                </div>

                <!--PROJECT-->  
                <div class="col-md-8">
                  <div class="form-group" >
                    <label for="allow_rent">: <?php echo $result[0]->allow_rent;?></label>
                    <input name="allow_rent" type="text" value="<?php echo $result[0]->allow_rent;?>" hidden>
                  </div>
                </div>
                <?php } ?>

                <?php if($result[0]->allow_parking!=0 || $result[0]->allow_parking!=null) { ?>
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Tunjangan Parkir</label>
                  </div>
                </div>

                <!--PROJECT-->  
                <div class="col-md-8">
                  <div class="form-group" >
                    <label for="allow_parking">: <?php echo $result[0]->allow_parking;?></label>
                    <input name="allow_parking" type="text" value="<?php echo $result[0]->allow_parking;?>" hidden>
                  </div>
                </div>
                <?php } ?>

                <?php if($result[0]->allow_medichine!=0 || $result[0]->allow_medichine!=null) { ?>
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Tunjangan Kesehatan/Vitamin</label>
                  </div>
                </div>

                <!--PROJECT-->  
                <div class="col-md-8">
                  <div class="form-group" >
                    <label for="allow_medichine">: <?php echo $result[0]->allow_medichine;?></label>
                    <input name="allow_medichine" type="text" value="<?php echo $result[0]->allow_medichine;?>" hidden>
                  </div>
                </div>
                <?php } ?>

                <?php if($result[0]->allow_akomodsasi!=0 || $result[0]->allow_akomodsasi!=null) { ?>
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Tunjangan Akomodasi</label>
                  </div>
                </div>

                <!--PROJECT-->  
                <div class="col-md-8">
                  <div class="form-group" >
                    <label for="allow_akomodsasi">: <?php echo $result[0]->allow_akomodsasi;?></label>
                    <input name="allow_akomodsasi" type="text" value="<?php echo $result[0]->allow_akomodsasi;?>" hidden>
                  </div>
                </div>
                <?php } ?>

                <?php if($result[0]->allow_kasir!=0 || $result[0]->allow_kasir!=null) { ?>
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Tunjangan Kasir</label>
                  </div>
                </div>

                <!--PROJECT-->  
                <div class="col-md-8">
                  <div class="form-group" >
                    <label for="allow_kasir">: <?php echo $result[0]->allow_kasir;?></label>
                    <input name="allow_kasir" type="text" value="<?php echo $result[0]->allow_kasir;?>" hidden>
                  </div>
                </div>
                <?php } ?>

                <?php if($result[0]->allow_operational!=0 || $result[0]->allow_operational!=null) { ?>
                <!--PROJECT-->
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Tunjangan Operasional</label>
                  </div>
                </div>

                <!--PROJECT-->  
                <div class="col-md-8">
                  <div class="form-group" >
                    <label for="allow_operational">: <?php echo $result[0]->allow_operational;?></label>
                    <input name="allow_operational" type="text" value="<?php echo $result[0]->allow_operational;?>" hidden>
                  </div>
                </div>
                <?php } ?>

        </div>



                    
                    



<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });

});
</script>