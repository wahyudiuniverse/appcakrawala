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


// PKWT START

  $skk_release = $this->Esign_model->read_skk_by_nip($session['employee_id']);

// if(!is_null($pkwtinfo)){
//   $pkwtid = $pkwtinfo[0]->contract_id;
//   $nomorsurat = $pkwtinfo[0]->no_surat;
//   $approve_pkwt = $pkwtinfo[0]->status_approve;

//   $pkwt_file = $this->Pkwt_model->get_pkwt_file($pkwtinfo[0]->contract_id);


// reports to 
$reports_to = get_reports_team_data($session['user_id']); ?>

<hr class="border-light m-0 mb-3">

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
  <div class="col-sm-6 col-xl-3">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-paper display-4 text-info"></div>
          <div class="ml-3">
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


