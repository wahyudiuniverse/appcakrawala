<?php $result = $this->Pkwt_model->read_info_ratecard($proj,str_replace("%20"," ",$posi),$area);

  
        // get company
        // $company = $this->Xin_model->read_company_info($result[0]->company_id);
        if(!is_null($result)){
          $dm_grade             = $result[0]->dm_grade;
          $allow_grade          = $result[0]->allow_grade;
          $dm_masa_kerja        = $result[0]->dm_masa_kerja;
          $allow_masa_kerja     = $result[0]->allow_masa_kerja;
          $dm_konsumsi          = $result[0]->dm_konsumsi;
          $allow_konsumsi       = $result[0]->allow_konsumsi;
          $dm_transport         = $result[0]->dm_transport;
          $allow_transport      = $result[0]->allow_transport;
          $dm_rent              = $result[0]->dm_rent;
          $allow_rent           = $result[0]->allow_rent;
          $dm_comunication      = $result[0]->dm_comunication;
          $allow_comunication   = $result[0]->allow_comunication;
          $dm_parking           = $result[0]->dm_parking;
          $allow_parking        = $result[0]->allow_parking;
          $dm_residance         = $result[0]->dm_residance;
          $allow_residance      = $result[0]->allow_residance;
          $dm_device            = $result[0]->dm_device;
          $allow_device         = $result[0]->allow_device;
          $dm_kasir             = $result[0]->dm_kasir;
          $allow_kasir          = $result[0]->allow_kasir;
          $dm_trans_meal        = $result[0]->dm_trans_meal;
          $allow_trans_meal     = $result[0]->allow_trans_meal;
          $dm_medicine          = $result[0]->dm_medicine;
          $allow_medicine       = $result[0]->allow_medicine;
        } else {
          $dm_grade             = '--';
          $allow_grade          = '0';  
          $dm_masa_kerja        = '--';
          $allow_masa_kerja     = '0';  
          $dm_konsumsi          = '--';
          $allow_konsumsi       = '0';
          $dm_transport         = '--';
          $allow_transport      = '0';
          $dm_rent              = '--';
          $allow_rent           = '0';
          $dm_comunication      = '--';
          $allow_comunication   = '0';
          $dm_parking           = '--';
          $allow_parking        = '0';
          $dm_residance         = '--';
          $allow_residance      = '0';
          $dm_device            = '--';
          $allow_device         = '0';
          $dm_kasir             = '--';
          $allow_kasir          = '0';
          $dm_trans_meal        = '--';
          $allow_trans_meal     = '0';
          $dm_medicine          = '--';
          $allow_medicine       = '0';
        }

        $name_grade="";
        $masa_kerja="";
        $konsumsi="";
        $name_transport="";
        $rent="";
        $comunication="";
        $parking="";
        $residance="";
        $device="";
        $trans_meal="";
        $medicine="";

        if($allow_grade!="0"){$name_grade="Jabatan, ";}
        if($allow_masa_kerja!="0"){$masa_kerja="Masa Kerja, ";}
        if($allow_konsumsi!="0"){$konsumsi="Konsumsi, ";}
        if($allow_transport!="0"){$name_transport="Transport, ";}
        if($allow_rent!="0"){$rent="Rental, ";}
        if($allow_comunication!="0"){$comunication="Komunikasi, ";}
        if($allow_parking!="0"){$parking="Parkir, ";}
        if($allow_residance!="0"){$residance="Tempat Tinggal, ";}
        if($allow_device!="0"){$device="Laptop, ";}
        if($allow_kasir!="0"){$kasir="Kasir, ";}
        if($allow_trans_meal!="0"){$trans_meal="Makan - Transport, ";}
        if($allow_medicine!="0"){$medicine="Kesehatan, ";}
        // if($allow_grade!="0"){$name_grade="Jabatan, ";}


        $all_allowance = $name_grade.$masa_kerja.$konsumsi.$name_transport.$rent.$comunication.$parking.$residance.$device.$trans_meal.$medicine;
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

                    <label for="allow">: <?php echo $all_allowance;?></label>

                    <input name="dm_grade" type="text" value="<?php echo $dm_grade;?>" hidden>
                    <input name="allow_grade" type="text" value="<?php echo $allow_grade;?>" hidden>

                    <input name="dm_masa_kerja" type="text" value="<?php echo $dm_masa_kerja;?>" hidden>
                    <input name="allow_masa_kerja" type="text" value="<?php echo $allow_masa_kerja;?>" hidden>

                    <input name="dm_konsumsi" type="text" value="<?php echo $dm_konsumsi;?>" hidden>
                    <input name="allow_konsumsi" type="text" value="<?php echo $allow_konsumsi;?>" hidden>

                    <input name="dm_transport" type="text" value="<?php echo $dm_transport;?>" hidden>
                    <input name="allow_transport" type="text" value="<?php echo $allow_transport;?>" hidden>
                    
                    <input name="dm_rent" type="text" value="<?php echo $dm_rent;?>" hidden>
                    <input name="allow_rent" type="text" value="<?php echo $allow_rent;?>" hidden>
                    
                    <input name="dm_comunication" type="text" value="<?php echo $dm_comunication;?>" hidden>
                    <input name="allow_comunication" type="text" value="<?php echo $allow_comunication;?>" hidden>

                    <input name="dm_parking" type="text" value="<?php echo $dm_parking;?>" hidden>
                    <input name="allow_parking" type="text" value="<?php echo $allow_parking;?>" hidden>

                    <input name="dm_residance" type="text" value="<?php echo $dm_residance;?>" hidden>
                    <input name="allow_residance" type="text" value="<?php echo $allow_residance;?>" hidden>

                    <input name="dm_device" type="text" value="<?php echo $dm_device;?>" hidden>
                    <input name="allow_device" type="text" value="<?php echo $allow_device;?>" hidden>

                    <input name="dm_kasir" type="text" value="<?php echo $dm_kasir;?>" hidden>
                    <input name="allow_kasir" type="text" value="<?php echo $allow_kasir;?>" hidden>

                    <input name="dm_trans_meal" type="text" value="<?php echo $dm_trans_meal;?>" hidden>
                    <input name="allow_trans_meal" type="text" value="<?php echo $allow_trans_meal;?>" hidden>

                    <input name="dm_medicine" type="text" value="<?php echo $dm_medicine;?>" hidden>
                    <input name="allow_medicine" type="text" value="<?php echo $allow_medicine;?>" hidden>

<script type="text/javascript">
$(document).ready(function(){
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' });

});
</script>