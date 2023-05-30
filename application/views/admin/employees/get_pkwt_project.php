<?php //$result = $this->Employees_model->read_employee_info_by_nik($id_project);

  
        // // get company
        // $company = $this->Xin_model->read_company_info($result[0]->company_id);
        // if(!is_null($company)){
        //   $comp_name = $company[0]->name;
        // } else {
        //   $comp_name = '--';  
        // }

        // // department
        // $department = $this->Department_model->read_department_information($result[0]->department_id);
        // if(!is_null($department)){
        // $department_name = $department[0]->department_name;
        // } else {
        // $department_name = '--';  
        // }

        $projects = $this->Project_model->read_single_project($id_project);
        if(!is_null($projects)){
          $nama_project = $projects[0]->title;
          $idproject = $projects[0]->project_id;
        } else {
          $nama_project = '--'; 
          $idproject = $projects[0]->project_id;
        }

        // $designation = $this->Designation_model->read_designation_information($result[0]->designation_id);
        // if(!is_null($designation)){
        //   $designation_name = $designation[0]->designation_name;
        // } else {
        //   $designation_name = '--'; 
        // }

?>

                    <label for="projects">: <?php echo $nama_project;?></label>
                    <input name="allow" type="text" value="<?php echo $idproject;?>" hidden>



<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });

});
</script>