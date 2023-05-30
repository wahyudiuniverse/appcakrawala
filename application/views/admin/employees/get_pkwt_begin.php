<?php $result = $this->Employees_model->read_employee_info_by_nik($id_project);


        // get company
        $pkwtinfo = $this->Pkwt_model->read_pkwt_by_nip($id_project);
        if(!is_null($pkwtinfo)){
          // $end_date = $pkwtinfo[0]->to_date;

                $begin = $pkwtinfo[0]->to_date;
                // $tgl1 = "2018-01-23";// pendefinisian tanggal awal
                if(!is_null($waktu_kontrak)){
                  if($waktu_kontrak=='1'){
                    $end = date('Y-m-d', strtotime('+30 days', strtotime($begin)));
                  } else if ($waktu_kontrak=='3'){
                    $end = date('Y-m-d', strtotime('+90 days', strtotime($begin)));
                  } else if ($waktu_kontrak=='6'){
                    $end = date('Y-m-d', strtotime('+180 days', strtotime($begin)));
                  } else if ($waktu_kontrak=='12'){
                    $end = date('Y-m-d', strtotime('+360 days', strtotime($begin)));
                  } else {
                    $end = date('Y-m-d', strtotime('+90 days', strtotime($begin)));
                  }
                } else {
                  $end = date('Y-m-d', strtotime('+90 days', strtotime($begin)));
                }
        
        } else {
          // $end_date = '--'; 

                $begin = $result[0]->contract_start;
                // $tgl1 = "2018-01-23";// pendefinisian tanggal awal
                if(!is_null($waktu_kontrak)){
                  if($waktu_kontrak=='1'){
                    $end = date('Y-m-d', strtotime('+30 days', strtotime($begin)));
                  } else if ($waktu_kontrak=='3'){
                    $end = date('Y-m-d', strtotime('+90 days', strtotime($begin)));
                  } else if ($waktu_kontrak=='6'){
                    $end = date('Y-m-d', strtotime('+180 days', strtotime($begin)));
                  } else if ($waktu_kontrak=='12'){
                    $end = date('Y-m-d', strtotime('+360 days', strtotime($begin)));
                  } else {
                    $end = date('Y-m-d', strtotime('+90 days', strtotime($begin)));
                  }
                } else {
                  $end = date('Y-m-d', strtotime('+90 days', strtotime($begin)));
                }

        }

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

                    <label for="begin">: <?php echo $begin. ' - '.$end;?></label>
                    <input name="begin" type="text" value="<?php echo $begin. ' - '.$end;?>" hidden>




<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });

});
</script>