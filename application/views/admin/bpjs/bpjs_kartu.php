<?php
/* Employees view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php

// if(!is_null($pkwtinfo)){
//   $pkwtid = $pkwtinfo[0]->contract_id;
//   $nomorsurat = $pkwtinfo[0]->no_surat;
//   $approve_pkwt = $pkwtinfo[0]->status_approve;

//   $pkwt_file = $this->Pkwt_model->get_pkwt_file($pkwtinfo[0]->contract_id);


// reports to 
$reports_to = get_reports_team_data($session['user_id']); ?>

<hr class="border-light m-0 mb-3">
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


