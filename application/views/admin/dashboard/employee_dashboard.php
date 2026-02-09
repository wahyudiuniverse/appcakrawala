<?php 
$session = $this->session->userdata('username');
$user_info = $this->Employees_model->read_employee_info($session['user_id']);
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
          $projectid = $emp[0]->project_id;
          $sub_project = 'pkwt'.$emp[0]->sub_project_id;
          $designation_id = $emp[0]->designation_id;
        } else {
          $fullname = '--'; 
          $projectid = '0';
          $sub_project = '0';
          $designation_id = '0';
        }


if(!is_null($pkwtinfo)){
  if($pkwtinfo[0]->file_name == NULL){

    $pkwtid         = $pkwtinfo[0]->contract_id;
    $nomorsurat     = $pkwtinfo[0]->no_surat;
    $approve_pkwt   = $pkwtinfo[0]->status_pkwt;
    $uniqueid       = $pkwtinfo[0]->uniqueid;
    $pkwt_periode   = 'PKWT '.$pkwtinfo[0]->from_date. ' - ' .$pkwtinfo[0]->to_date;

  } else {

    $pkwtid         = $pkwtinfo[0]->contract_id;
    $nomorsurat     = $pkwtinfo[0]->no_surat;
    $approve_pkwt   = '2';
    $uniqueid       = '0';
    $pkwt_periode   = 'PKWT '.$pkwtinfo[0]->from_date. ' - ' .$pkwtinfo[0]->to_date;


    // $file_name = '';
    // $uploaded = 0;
    // $pkwt_periode   = '-';

  }


  // $pkwt_file = $this->Pkwt_model->get_pkwt_file($pkwtinfo[0]->contract_id);
  // if(!is_null($pkwt_file)){
  //   $file_name = $pkwt_file[0]->document_file;
  //   $uploaded = 1;
  // } else {
  // }

} else {
    $pkwtid = '0';
    $nomorsurat     = '0';
    $approve_pkwt   = '0';
    $uniqueid       = '0';
    $pkwt_periode   = '-';

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
    $user_info = $this->Employees_model->read_employee_info($session['user_id']);
    $eslip_release = $this->Employees_model->read_eslip_by_nip($session['employee_id']);
    $eslip_saltab = $this->Employees_model->read_saltab_by_nip($session['employee_id']);
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



  <?php
  if($projectid=='61' && $designation_id=='165'){
    ?>


  <div class="col-sm-6 col-xl-4">
  <a href="<?php echo site_url('/uploads/document/offering/dokumen-insentif-spv.pdf');?>" target="_blank">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-4">
            <div class="text-muted small">DOWNLOAD</div>
            <div class="text-large">DOKUMEN INSENTIF SPV</div>
            <div class="text-muted small">PT. Paragon Technology and Innovation</div>
          </div>
        </div>
      </div>
    </div>
    </a>
  </div>

  <?php
  }
  ?>

  <?php
  if($projectid=='0001' && $designation_id=='0001'){
    ?>

  <div class="col-sm-6 col-xl-4">
  <a href="<?php echo site_url('/uploads/document/offering/sl-ba/'.$user_info[0]->employee_id.'.pdf');?>" target="_blank">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-4">
            <div class="text-muted small">DOWNLOAD</div>
            <div class="text-large">OFFERING LETTER SL-BA</div>
            <div class="text-muted small">PT. Paragon Technology and Innovation</div>
          </div>
        </div>
      </div>
    </div>
    </a>
  </div>


  <div class="col-sm-6 col-xl-4">
  <a href="<?php echo site_url('/uploads/document/offering/dokumen-insentif-sl-ba.pdf');?>" target="_blank">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-4">
            <div class="text-muted small">DOWNLOAD</div>
            <div class="text-large">DOKUMEN INSENTIF SL-BA</div>
            <div class="text-muted small">PT. Paragon Technology and Innovation</div>
          </div>
        </div>
      </div>
    </div>
    </a>
  </div>

  <?php
  }
  ?>

  <?php
  if($projectid=='0001' && $designation_id=='0001'){
    ?>

  <div class="col-sm-6 col-xl-4">
  <a href="<?php echo site_url('/uploads/document/offering/sl-non-ba/'.$user_info[0]->employee_id.'.pdf');?>" target="_blank">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-4">
            <div class="text-muted small">DOWNLOAD</div>
            <div class="text-large">OFFERING LETTER SL-NON BA</div>
            <div class="text-muted small">PT. Paragon Technology and Innovation</div>
          </div>
        </div>
      </div>
    </div>
    </a>
  </div>


  <div class="col-sm-6 col-xl-4">
  <a href="<?php echo site_url('/uploads/document/offering/dokumen-insentif-sl-non-ba.pdf');?>" target="_blank">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-4">
            <div class="text-muted small">DOWNLOAD</div>
            <div class="text-large">DOKUMEN INSENTIF SL-NON BA</div>
            <div class="text-muted small">PT. Paragon Technology and Innovation</div>
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


<!-- NEW E-SLIP SALTAB -->


<div class="row mt-3">


  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-4">
            <div class="text-muted small"><?php echo $this->lang->line('xin_eslip');?></div>
            <div class="text-large">CEK E-SLIP DI PROFILE KAMU..!</div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>


<div class="row mt-3">


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
 