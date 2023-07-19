<?php
/* Employee Import view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">


</div>


<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> History E-SLIP</span> </div>
  <div class="card-body">
    <div class="card-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th>UpDate</th>
            <th>Periode</th>
            <th>Project</th>
            <th>Sub Project</th>
            <th>Total MPP</th>
            <th><i class="fa fa-user"></i> Dibuat Oleh</th>
            <th><i class="fa fa-user"></i> Diunduh Oleh</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>