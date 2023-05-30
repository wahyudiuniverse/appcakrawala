<?php //$result = $this->Pkwt_model->read_info_ratecard($proj,str_replace("%20"," ",$posi),$area);
<?php $result = $this->Employees_model->read_employee_info_by_nik(str_replace("%20"," ",$id_project));
  
        // get company
        // $company = $this->Xin_model->read_company_info($result[0]->company_id);
        // if(!is_null($result)){
        //   $dm_grade             = $result[0]->dm_grade;
        //   $allow_grade          = $result[0]->allow_grade;
        //   $dm_masa_kerja        = $result[0]->dm_masa_kerja;
        //   $allow_masa_kerja     = $result[0]->allow_masa_kerja;
        //   $dm_konsumsi          = $result[0]->dm_konsumsi;
        //   $allow_konsumsi       = $result[0]->allow_konsumsi;
        //   $dm_transport         = $result[0]->dm_transport;
        //   $allow_transport      = $result[0]->allow_transport;
        //   $dm_rent              = $result[0]->dm_rent;
        //   $allow_rent           = $result[0]->allow_rent;
        //   $dm_comunication      = $result[0]->dm_comunication;
        //   $allow_comunication   = $result[0]->allow_comunication;
        //   $dm_parking           = $result[0]->dm_parking;
        //   $allow_parking        = $result[0]->allow_parking;
        //   $dm_residance         = $result[0]->dm_residance;
        //   $allow_residance      = $result[0]->allow_residance;
        //   $dm_device            = $result[0]->dm_device;
        //   $allow_device         = $result[0]->allow_device;
        //   $dm_kasir             = $result[0]->dm_kasir;
        //   $allow_kasir          = $result[0]->allow_kasir;
        //   $dm_trans_meal        = $result[0]->dm_trans_meal;
        //   $allow_trans_meal     = $result[0]->allow_trans_meal;
        //   $dm_medicine          = $result[0]->dm_medicine;
        //   $allow_medicine       = $result[0]->allow_medicine;
        // } else {
        //   $dm_grade             = '--';
        //   $allow_grade          = '0';  
        //   $dm_masa_kerja        = '--';
        //   $allow_masa_kerja     = '0';  
        //   $dm_konsumsi          = '--';
        //   $allow_konsumsi       = '0';
        //   $dm_transport         = '--';
        //   $allow_transport      = '0';
        //   $dm_rent              = '--';
        //   $allow_rent           = '0';
        //   $dm_comunication      = '--';
        //   $allow_comunication   = '0';
        //   $dm_parking           = '--';
        //   $allow_parking        = '0';
        //   $dm_residance         = '--';
        //   $allow_residance      = '0';
        //   $dm_device            = '--';
        //   $allow_device         = '0';
        //   $dm_kasir             = '--';
        //   $allow_kasir          = '0';
        //   $dm_trans_meal        = '--';
        //   $allow_trans_meal     = '0';
        //   $dm_medicine          = '--';
        //   $allow_medicine       = '0';
        // }

        // $name_grade="";
        // $masa_kerja="";
        // $konsumsi="";
        // $name_transport="";
        // $rent="";
        // $comunication="";
        // $parking="";
        // $residance="";
        // $device="";
        // $trans_meal="";
        // $medicine="";

        // if($allow_grade!="0"){$name_grade="Jabatan, ";}
        // if($allow_masa_kerja!="0"){$masa_kerja="Masa Kerja, ";}
        // if($allow_konsumsi!="0"){$konsumsi="Konsumsi, ";}
        // if($allow_transport!="0"){$name_transport="Transport, ";}
        // if($allow_rent!="0"){$rent="Rental, ";}
        // if($allow_comunication!="0"){$comunication="Komunikasi, ";}
        // if($allow_parking!="0"){$parking="Parkir, ";}
        // if($allow_residance!="0"){$residance="Tempat Tinggal, ";}
        // if($allow_device!="0"){$device="Laptop, ";}
        // if($allow_kasir!="0"){$kasir="Kasir, ";}
        // if($allow_trans_meal!="0"){$trans_meal="Makan - Transport, ";}
        // if($allow_medicine!="0"){$medicine="Kesehatan, ";}


        // $all_allowance = $name_grade.$masa_kerja.$konsumsi.$name_transport.$rent.$comunication.$parking.$residance.$device.$trans_meal.$medicine;
        // $all_allowance = $result[0]->allow_jabatan;
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

?>

                    <label for="allow">: <?php echo $result[0]->hari_kerja;?></label>
                    <input name="allow" type="text" value="<?php echo $result[0]->hari_kerja;?>" hidden>


<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });

});
</script>