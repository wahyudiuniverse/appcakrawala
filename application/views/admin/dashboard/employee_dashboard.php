<?php 
$session = $this->session->userdata('username');
$user_info = $this->Exin_model->read_user_info($session['user_id']);
$theme = $this->Xin_model->read_theme_info(1);
if($user_info[0]->profile_picture!='' && $user_info[0]->profile_picture!='no file') {
  $lde_file = base_url().'uploads/profile/'.$user_info[0]->profile_picture;
} else { 
  if($user_info[0]->gender=='L') {
    $lde_file = base_url().'uploads/profile/default_male.jpg'; 
  } else {  
    $lde_file = base_url().'uploads/profile/default_female.jpg';
  }
}
// PAKLARING CEK


  $skk_release = $this->Esign_model->read_skk_by_nip($user_info[0]->employee_id);

// PKWT START

$pkwtinfo = $this->Pkwt_model->get_single_pkwt_by_userid($user_info[0]->employee_id);
$emp = $this->Employees_model->read_employee_info_by_nik($user_info[0]->employee_id);
        if(!is_null($emp)){
          $fullname = $emp[0]->first_name;
          $sub_project = 'pkwt'.$emp[0]->sub_project_id;
        } else {
          $fullname = '--'; 
          $sub_project = '0';
        }


if(!is_null($pkwtinfo)){
  $pkwtid         = $pkwtinfo[0]->contract_id;
  $nomorsurat     = $pkwtinfo[0]->no_surat;
  $approve_pkwt   = $pkwtinfo[0]->status_pkwt;
  $uniqueid       = $pkwtinfo[0]->uniqueid;

  $pkwt_file = $this->Pkwt_model->get_pkwt_file($pkwtinfo[0]->contract_id);
  if(!is_null($pkwt_file)){
    $file_name = $pkwt_file[0]->document_file;
    $uploaded = 1;
  } else {
    $file_name = '';
    $uploaded = 0;
  }

} else {
  $pkwtid = '0';
}

// PKWT END


$last_login =  new DateTime($user_info[0]->last_login_date);
// get designation
$designation = $this->Designation_model->read_designation_information($user_info[0]->designation_id);
if(!is_null($designation)){
  $designation_name = $designation[0]->designation_name;
} else {
  $designation_name = '--'; 
}

$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
  $role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
  $role_resources_ids = explode(',',0); 
}

$dokumen_checker = $this->Xin_model->read_dokumen_checker($user_info[0]->employee_id);
if(!is_null($dokumen_checker)){
  if($dokumen_checker[0]->filename_ktp == null || $dokumen_checker[0]->filename_ktp=='0'){
    $doc_ktp = 0;
  } else {
    $doc_ktp = 1;
  }

  if($dokumen_checker[0]->filename_kk=='0'){
    $doc_kk = 0;
  } else {
    $doc_kk = 1;
  }

  if($dokumen_checker[0]->filename_skck == null || $dokumen_checker[0]->filename_skck=='0'){
    $doc_skck = 0;
  } else {
    $doc_skck = 1;
  }

  if($dokumen_checker[0]->filename_isd == null || $dokumen_checker[0]->filename_isd=='0'){
    $doc_ijazah = 0;
  } else {
    $doc_ijazah = 1;
  }

  if($dokumen_checker[0]->filename_cv == null || $dokumen_checker[0]->filename_cv=='0'){
    $doc_cv = 0;
  } else {
    $doc_cv = 1;
  }

} else {
  $doc_ktp = 0;
  $doc_kk = 0;
  $doc_skck = 0;
  $doc_ijazah = 0;
  $doc_cv = 0;
}

?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $system = $this->Xin_model->read_setting_info(1);?>


<?php
$att_date =  date('d-M-Y');
$attendance_date = date('d-M-Y');
// get office shift for employee
$get_day = strtotime($att_date);
$day = date('l', $get_day);
$strtotime = strtotime($attendance_date);
$new_date = date('d-M-Y', $strtotime);
?>

<?php $sys_arr = explode(',',$system[0]->system_ip_address); ?>
<?php

    $session = $this->session->userdata('username');
    $user_info = $this->Exin_model->read_user_info($session['user_id']);
    $eslip_release = $this->Employees_model->read_eslip_by_nip($session['employee_id']);
?>

<div class="row mt-6">
  <div class="d-flex col-xl-12 align-items-stretch">
    <!-- Stats + Links -->
    <div class="card d-flex w-100 mb-4">
      <div class="row no-gutters row-bordered h-100">

<!-- KTP -->
        <?php
        if($doc_ktp==1){
        ?>

        <div class="d-flex col-sm-8 col-md-4 col-lg-2 align-items-center list-group-item-success">
          <a href="#" class="card-body media align-items-center text-body">
            <i class="lnr lnr-checkmark-circle display-4 d-block text-primary"></i>
            <span class="media-body d-block ml-3">
              <span class="text-big font-weight-bolder">FOTO KTP</span><br>
              <small class="text-muted">Sudah diunggah</small>
            </span>
          </a>
        </div>

        <?php
        } else {
        ?>

        <div class="d-flex col-sm-8 col-md-4 col-lg-2 align-items-center list-group-item-danger">
          <a href="#" class="card-body media align-items-center text-body">
            <i class="lnr lnr-warning display-4 d-block text-danger"></i>
            <span class="media-body d-block ml-3">
              <span class="text-big font-weight-bolder">FOTO KTP</span><br>
              <small class="text-muted">Belum diunggah</small>
            </span>
          </a>
        </div>

        <?php
        }
        ?>

<!-- KK -->
        <?php
        if($doc_kk==1){
        ?>

        <div class="d-flex col-sm-8 col-md-4 col-lg-2 align-items-center list-group-item-success">
          <a href="#" class="card-body media align-items-center text-body">
            <i class="lnr lnr-checkmark-circle display-4 d-block text-primary"></i>
            <span class="media-body d-block ml-3">
              <span class="text-big font-weight-bolder">FOTO KK</span><br>
              <small class="text-muted">Sudah diunggah</small>
            </span>
          </a>
        </div>

        <?php
        } else {
        ?>

        <div class="d-flex col-sm-8 col-md-4 col-lg-2 align-items-center list-group-item-danger">
          <a href="#" class="card-body media align-items-center text-body">
            <i class="lnr lnr-warning display-4 d-block text-danger"></i>
            <span class="media-body d-block ml-3">
              <span class="text-big font-weight-bolder">FOTO KK</span><br>
              <small class="text-muted">Belum diunggah</small>
            </span>
          </a>
        </div>

        <?php
        }
        ?>

<!-- SKCK -->
        <?php
        if($doc_skck==1){
        ?>

        <div class="d-flex col-sm-8 col-md-4 col-lg-2 align-items-center list-group-item-success">
          <a href="#" class="card-body media align-items-center text-body">
            <i class="lnr lnr-checkmark-circle display-4 d-block text-primary"></i>
            <span class="media-body d-block ml-3">
              <span class="text-big font-weight-bolder">FOTO SKCK</span><br>
              <small class="text-muted">Sudah diunggah</small>
            </span>
          </a>
        </div>

        <?php
        } else {
        ?>

        <div class="d-flex col-sm-8 col-md-4 col-lg-2 align-items-center list-group-item-danger">
          <a href="#" class="card-body media align-items-center text-body">
            <i class="lnr lnr-warning display-4 d-block text-danger"></i>
            <span class="media-body d-block ml-3">
              <span class="text-big font-weight-bolder">FOTO SKCK</span><br>
              <small class="text-muted">Belum diunggah</small>
            </span>
          </a>
        </div>

        <?php
        }
        ?>

<!-- IJAZAH -->

        <?php
        if($doc_ijazah==1){
        ?>

        <div class="d-flex col-sm-8 col-md-4 col-lg-2 align-items-center list-group-item-success">
          <a href="#" class="card-body media align-items-center text-body">
            <i class="lnr lnr-checkmark-circle display-4 d-block text-primary"></i>
            <span class="media-body d-block ml-3">
              <span class="text-big font-weight-bolder">IJAZAH</span><br>
              <small class="text-muted">Sudah diunggah</small>
            </span>
          </a>
        </div>

        <?php
        } else {
        ?>

        <div class="d-flex col-sm-8 col-md-4 col-lg-2 align-items-center list-group-item-danger">
          <a href="#" class="card-body media align-items-center text-body">
            <i class="lnr lnr-warning display-4 d-block text-danger"></i>
            <span class="media-body d-block ml-3">
              <span class="text-big font-weight-bolder">IJAZAH</span><br>
              <small class="text-muted">Belum diunggah</small>
            </span>
          </a>
        </div>

        <?php
        }
        ?>

<!-- DOK CV -->
        <?php
        if($doc_cv==1){
        ?>

        <div class="d-flex col-sm-8 col-md-4 col-lg-2 align-items-center list-group-item-success">
          <a href="#" class="card-body media align-items-center text-body">
            <i class="lnr lnr-checkmark-circle display-4 d-block text-primary"></i>
            <span class="media-body d-block ml-3">
              <span class="text-big font-weight-bolder">RIWAYAT HIDUP (CV)</span><br>
              <small class="text-muted">Sudah diunggah</small>
            </span>
          </a>
        </div>

        <?php
        } else {
        ?>

        <div class="d-flex col-sm-8 col-md-4 col-lg-3 align-items-center list-group-item-danger">
          <a href="#" class="card-body media align-items-center text-body">
            <i class="lnr lnr-warning display-4 d-block text-danger"></i>
            <span class="media-body d-block ml-3">
              <span class="text-big font-weight-bolder">RIWAYAT HIDUP (CV)</span><br>
              <small class="text-muted">Belum diunggah</small>
            </span>
          </a>
        </div>

        <?php
        }
        ?>


      </div>
    </div>
    <!-- / Stats + Links -->
  </div>  
</div>

<div class="row mt-3">


<!-- ESLIP STATUS -->
<?php
  if(!is_null($skk_release)){
    foreach($skk_release->result() as $r) {
?>

  <div class="col-sm-6 col-xl-4">
    <div class="card mb-5">
      <a href="<?php echo site_url().'admin/skk/view/'.$r->secid.'/'.$r->nip;?>" target="_blank">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-4">
            <div class="text-muted normal"><?php echo $this->lang->line('xin_paklaring'). ' '.'Periode:';?></div>
            <p style="font-size: 18px;"><?php echo $r->nomor_dokumen;?></p>
          </div>
        </div>
      </div>
      </a>
    </div>
  </div>

<?php
    }

  } else {
?>
  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-4">
            <div class="text-muted small"><?php echo $this->lang->line('xin_paklaring');?></div>
            <div class="text-large">Tidak Ditemukan..!</div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
  }
?>

</div>

<div class="row mt-3">

<!-- PKWT STATUS -->
  <?php 
  if($pkwtid=='0'){
  ?>

  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-4">
            <div class="text-muted small"><?php echo $this->lang->line('xin_pkwt');?></div>
            <div class="text-large">Belum Tersedia..!</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
  } else {
  ?>

  <div class="col-sm-6 col-xl-4">
  <a href="<?php echo site_url('admin/'.$sub_project.'/view/'.$uniqueid);?>" target="_blank">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-4">
            <div class="text-muted small"><?php echo $this->lang->line('xin_pkwt');?></div>
            <div class="text-large"><?php echo $this->lang->line('xin_download');?>
          <i class="fa fa-check-circle" aria-hidden="true" style="color:#03b403"></i></div>
            <div class="text-muted small"><?php echo $nomorsurat;?></div>
          </div>
        </div>
      </div>
    </div>
    </a>
  </div>

  <?php
  }
  ?>
</div>
<div class="row mt-3">


<!-- ESLIP STATUS -->
<?php
  if(!is_null($eslip_release)){
    foreach($eslip_release->result() as $r) {

    if($doc_ktp==0 || $doc_kk==0 || $doc_ijazah==0 || $doc_cv==0) {
?>


  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <a href="#">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-4">
            <div class="text-muted normal"><?php echo $this->lang->line('xin_eslip'). ' '.'Periode:';?>  <p style="color: #F00;">(Selesaikan Unggah Dokumen Secara Lengkap)</p></div>
            <p style="font-size: 18px;"><?php echo $r->periode;?></p>
          </div>
        </div>
      </div>
      </a>
    </div>
  </div>

<?php
    } else {
?>

  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <a href="<?php echo site_url().'admin/importexceleslip/view/'.$r->nip.'/'.$r->secid; ?>" target="_blank">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-4">
            <div class="text-muted normal"><?php echo $this->lang->line('xin_eslip'). ' '.'Periode:';?></div>
            <p style="font-size: 18px;"><?php echo $r->periode;?></p>
          </div>
        </div>
      </div>
      </a>
    </div>
  </div>
<?php
    }

?>


<?php
    }

  } else {
?>
  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-4">
            <div class="text-muted small"><?php echo $this->lang->line('xin_eslip');?></div>
            <div class="text-large">Tidak Ditemukan..!</div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
  }
?>
</div>


<div class="row mt-3">


<!-- BPJS KS STATUS -->
<?php
  if(!is_null($user_info[0]->bpjs_ks_status)){
?>

  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-4">
            <div class="text-muted small">BPJS KESEHATAN &nbsp&nbsp
              <?php 
                if($user_info[0]->bpjs_ks_status == 'AKTIF'){
                  ?>
                  <button type="button" class="btn btn-xs btn-outline-success"><?php echo $user_info[0]->bpjs_ks_status;?></button>
                  <?php
                } else {
                  ?>
                  <button type="button" class="btn btn-xs btn-outline-danger"><?php echo $user_info[0]->bpjs_ks_status;?></button>
                  <?php
                }
              ?>
              </div>
            <div class="text-large"><?php echo $user_info[0]->bpjs_ks_no;?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php 

  } else {
?>

  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-4">
            <div class="text-muted small">BPJS KESEHATAN &nbsp&nbsp
              <button type="button" class="btn btn-xs btn-outline-success">-</button></div>
            <div class="text-large">Tidak Ditemukan..!</div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php
  }
?>



<!-- BPJS TK STATUS -->
<?php
  if(!is_null($user_info[0]->bpjs_tk_status)){
?>

  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-4">
            <div class="text-muted small">BPJS KETENAGAKERJAAN &nbsp&nbsp
              <?php 
                if($user_info[0]->bpjs_tk_status == 'AKTIF'){
                  ?>
                  <button type="button" class="btn btn-xs btn-outline-success"><?php echo $user_info[0]->bpjs_tk_status;?></button>
                  <?php
                } else {
                  ?>
                  <button type="button" class="btn btn-xs btn-outline-danger"><?php echo $user_info[0]->bpjs_tk_status;?></button>
                  <?php
                }
              ?>
              </div>
            <div class="text-large"><?php echo $user_info[0]->bpjs_tk_no;?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php 

  } else {
?>

  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-4">
            <div class="text-muted small">BPJS KETENAGAKERJAAN &nbsp&nbsp
              <button type="button" class="btn btn-xs btn-outline-success">-</button></div>
            <div class="text-large">Tidak Ditemukan..!</div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php
  }
?>

</div>




<?php if(in_array('37',$role_resources_ids)) { ?>
<div class="card mb-4">
  <h6 class="card-header with-elements">
    <div class="card-header-title"><?php echo $this->lang->line('left_payroll');?></div>
  </h6>
  <div class="row no-gutters row-bordered">
    <div class="col-md-8 col-lg-12 col-xl-8">
      <div class="card-body">
        <div style="height: 210px;">
          <canvas id="hrpremium_user_payroll" style="display: block; height: 210px; width: 754px;" width="942" height="262"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-lg-12 col-xl-4">
      <div class="card-body"> 
        
        <!-- Numbers -->
        <div class="row">
          <div class="col-6 col-xl-5 text-muted mb-3"><?php echo $this->lang->line('xin_attendance_this_month');?></div>
          <div class="col-6 col-xl-7 mb-3"> <span class="text-big"><?php echo $this->Xin_model->currency_sign(hrpremium_user_payroll_this_month($session['user_id']));?></span> </div>
          <div class="col-6 col-xl-5 text-muted mb-3"><?php echo $this->lang->line('xin_last_6_month');?></div>
          <div class="col-6 col-xl-7 mb-3"> <span class="text-big"><?php echo $this->Xin_model->currency_sign(hrpremium_user_payroll_last_6_month($session['user_id']));?></span> </div>
          <div class="col-6 col-xl-5 text-muted mb-3"><?php echo $this->lang->line('xin_last_1_year');?></div>
          <div class="col-6 col-xl-7 mb-3"> <span class="text-big"><?php echo $this->Xin_model->currency_sign(hrpremium_user_payroll_last_1year($session['user_id']));?></span> </div>
          <div class="col-6 col-xl-5 text-muted mb-3"><?php echo $this->lang->line('xin_last_2_year');?></div>
          <div class="col-6 col-xl-7 mb-3"> <span class="text-big"><?php echo $this->Xin_model->currency_sign(hrpremium_user_payroll_last_2years($session['user_id']));?></span> </div>
          <div class="col-6 col-xl-5 text-muted mb-3"><?php echo $this->lang->line('xin_last_3_year');?></div>
          <div class="col-6 col-xl-7 mb-3"> <span class="text-big"><?php echo $this->Xin_model->currency_sign(hrpremium_user_payroll_last_3years($session['user_id']));?></span> </div>
        </div>
        <!-- / Numbers --> 
        
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php if(in_array('44',$role_resources_ids) || in_array('45',$role_resources_ids)) { ?>
<div class="row">
    <?php if(in_array('44',$role_resources_ids)) { ?>
    <div class="col-md-6">
      <div class="card mb-4">
        <h6 class="card-header with-elements border-0 pr-0 pb-0">
          <div class="card-header-title"><?php echo $this->lang->line('xin_projects_status');?></div>
        </h6>
        <div class="row">
          <div class="col-md-6">
            <div id="overflow-scrolls" class="py-2 px-3 " style="overflow:auto; height:200px;">
              <div class="table-responsive">
                <table class="table mb-0 table-dashboard">
                  <tbody>
                    <?php //$dc_color = array(,'#2196f3','#02bc77','#d3733b','#673AB7');?>
                    <?php $dj=0;$projects = get_user_projects_status($session['user_id']); foreach($projects->result() as $eproject) { ?>
                    <?php
                    //$row = total_user_projects_status($eproject->status,$session['user_id']);
                    if($eproject->status==0){
                        $row = total_user_projects_status($eproject->status,$session['user_id']);
                        $csname = htmlspecialchars_decode($this->lang->line('xin_not_started'));
                        $bdcolor = '#647c8a';
                    } else if($eproject->status==1){
                        $csname = htmlspecialchars_decode($this->lang->line('xin_in_progress'));
                        $row = total_user_projects_status($eproject->status,$session['user_id']);
                        $bdcolor = '#2196f3';
                    } else if($eproject->status==2){
                        $csname = htmlspecialchars_decode($this->lang->line('xin_completed'));
                        $row = total_user_projects_status($eproject->status,$session['user_id']);
                        $bdcolor = '#02bc77';
                    } else if($eproject->status==3){
                        $csname = htmlspecialchars_decode($this->lang->line('xin_project_cancelled'));
                        $row = total_user_projects_status($eproject->status,$session['user_id']);
                        $bdcolor = '#d3733b';
                    } else if($eproject->status==4){
                        $csname = htmlspecialchars_decode($this->lang->line('xin_project_hold'));
                        $row = total_user_projects_status($eproject->status,$session['user_id']);
                        $bdcolor = '#673AB7';
                    }
                ?>
                    <tr>
                      <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid <?php echo $bdcolor;?>;"></div></td>
                      <td><?php echo htmlspecialchars_decode($csname);?> (<?php echo $row;?>)</td>
                    </tr>
                    <?php $dj++; } ?>
                    <?php  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div style="height:120px;">
              <canvas id="hrpremium_user_chart_projects"  style="display: block; height: 150px; width:300px;"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
    <?php if(in_array('45',$role_resources_ids)) { ?>
    <div class="col-md-6">
      <div class="card mb-4">
        <h6 class="card-header with-elements border-0 pr-0 pb-0">
          <div class="card-header-title"><?php echo $this->lang->line('xin_tasks_status');?></div>
        </h6>
        <div class="row">
          <div class="col-md-6">
            <div class="overflow-scrolls py-2 px-3" style="overflow:auto; height:200px;">
              <div class="table-responsive">
                <table class="table mb-0 table-dashboard">
                  <tbody>
                    <?php $dc_color = array('#3c8dbc','#006400','#dd4b39','#a98852','#f39c12','#605ca8');?>
                    <?php $sj=0;$tasks = get_user_tasks_status($session['user_id']); foreach($tasks->result() as $etask) { ?>
                    <?php
                    if($etask->task_status==0){
                        $sname = htmlspecialchars_decode($this->lang->line('xin_not_started'));
                        $trow = total_user_tasks_status($etask->task_status,$session['user_id']);
                        $tbdcolor = '#647c8a';
                    } else if($etask->task_status==1){
                        $sname = htmlspecialchars_decode($this->lang->line('xin_in_progress'));
                        $trow = total_user_tasks_status($etask->task_status,$session['user_id']);
                        $tbdcolor = '#2196f3';
                    } else if($etask->task_status==2){
                        $sname = htmlspecialchars_decode($this->lang->line('xin_completed'));
                        $trow = total_user_tasks_status($etask->task_status,$session['user_id']);
                        $tbdcolor = '#02bc77';
                    } else if($etask->task_status==3){
                        $sname = htmlspecialchars_decode($this->lang->line('xin_project_cancelled'));
                        $trow = total_user_tasks_status($etask->task_status,$session['user_id']);
                        $tbdcolor = '#d3733b';
                    } else if($etask->task_status==4){
                        $sname = htmlspecialchars_decode($this->lang->line('xin_project_hold'));
                        $trow = total_user_tasks_status($etask->task_status,$session['user_id']);
                        $tbdcolor = '#673AB7';
                    } 
                ?>
                    <tr>
                      <td style="vertical-align: inherit;"><div style="width:4px;border:5px solid <?php echo $tbdcolor;?>;"></div></td>
                      <td><?php echo htmlspecialchars_decode($sname);?> (<?php echo $trow;?>)</td>
                    </tr>
                    <?php $sj++; } ?>
                    <?php  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div style="height:120px;">
              <canvas id="hrpremium_user_tasks" style="display: block; height: 150px; width:300px;"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
   </div>
 <?php } ?>  