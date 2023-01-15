<?php $result = $this->Employees_model->read_employee_info_by_nik($employee_id);


        // get company
        $company = $this->Xin_model->read_company_info($result[0]->company_id);
        if(!is_null($company)){
          $comp_name = $company[0]->name;
        } else {
          $comp_name = '--';  
        }

        // department
        $department = $this->Department_model->read_department_information($result[0]->department_id);
        if(!is_null($department)){
        $department_name = $department[0]->department_name;
        } else {
        $department_name = '--';  
        }

        $projects = $this->Project_model->read_single_project($result[0]->project_id);
        if(!is_null($projects)){
          $nama_project = $projects[0]->title;
        } else {
          $nama_project = '--'; 
        }

        $designation = $this->Designation_model->read_designation_information($result[0]->designation_id);
        if(!is_null($designation)){
          $designation_name = $designation[0]->designation_name;
        } else {
          $designation_name = '--'; 
        }


        // get company
        $pkwtinfo = $this->Pkwt_model->read_pkwt_by_nip($employee_id);
        if(!is_null($pkwtinfo)){
          $end_date = $pkwtinfo[0]->to_date;
        } else {
          $end_date = '--';  
        }


?>



            <div class="col-md-12">

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">NIP</label>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="projects">: <?php echo $result[0]->employee_id;?></label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Nama Lengkap</label>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="projects">: <?php echo $result[0]->first_name;?></label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Perusahaan</label>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="projects">:  <?php echo $comp_name;?></label>
                    <input name="company" type="text" value="<?php echo $comp_name;?>" hidden>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Departmen</label>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="projects">: <?php echo $department_name;?></label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Project</label>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="projects">: <?php echo $nama_project;?></label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Posisi/Jabatan</label>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="projects">: <?php echo $designation_name;?></label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Penempatan</label>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="projects">: <?php echo $result[0]->penempatan;?></label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Tanggal Bergabung</label>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="projects">: <?php echo $result[0]->date_of_joining;?></label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="projects">Berakhir PKWT</label>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="projects">: <?php echo $end_date;?></label>
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