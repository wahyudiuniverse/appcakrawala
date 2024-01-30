<?php
/* Location view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<hr class="border-light m-0">


<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> CEK NIP </div>
  <div class="card-body">
    <div class="card-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th>NIP</th>
            <th>NIK</th>
            <th>Nama Lengkap</th>
            <th>Join</th>
            <th>Whatsapp</th>
            <th>Role</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
