<?php $result = $this->Pkwt_model->read_info_ratecard($proj,str_replace("%20"," ",$posi),$area);

  
        // get company
        // $company = $this->Xin_model->read_company_info($result[0]->company_id);
        if(!is_null($result)){
          $gaji_pokok = $result[0]->gaji_pokok;
        } else {
          $gaji_pokok = '--';  
        }

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

                    <label for="gaji">: <?php echo $this->Xin_model->rupiah($gaji_pokok);?></label>
                    <input name="gaji" type="text" value="<?php echo $gaji_pokok;?>" hidden>



<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });

});
</script>