<?php
/* Departments view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>


<style>
body {font-family: Arial, Helvetica, sans-serif;}

#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}
}

</style>

<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">

</div>
<hr class="border-light m-0 mb-3">
<div class="row m-b-1 <?php echo $get_animate;?>">
  <?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
  <?php if(in_array('240',$role_resources_ids)) {?>
  <div class="col-md-3">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_department');?></span>
    </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_department', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/esign/add_esign', $attributes, $hidden);?>


        <div class="form-group">
          <label for="jenis_dokumen"><?php echo $this->lang->line('xin_jenis_dokumen');?></label>
          <select class=" form-control" name="jenis_dokumen" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_jenis_dokumen');?>">
            <option value=""></option>
            <option value="1">PKWT</option>
            <option value="2">PAKLARING</option>
          </select>
        </div>

        <div class="form-group">
          <label for="manag_sign"><?php echo $this->lang->line('xin_sign_manager');?></label>
          <select class=" form-control" name="manag_sign" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_sign_manager');?>">
            <option value="21300023">MAITSA PRISTIYANTY</option>
          </select>
        </div>

        <div class="form-group">
          <label for="nodoc"><?php echo $this->lang->line('xin_no_dokumen');?></label>
          <input type="text" class="form-control" name="nomordoc" value="">
        </div>

        <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <?php $colmdval = 'col-md-9';?>
  <?php } else {?>
  <?php $colmdval = 'col-md-13';?>
  <?php } ?>
  <div class="<?php echo $colmdval;?>">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_departments');?></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_action');?></th>
                <th><?php echo $this->lang->line('xin_jenis_dokumen');?></th>
                <th><i class="fa fa-building-o"></i> <?php echo $this->lang->line('xin_no_dokumen');?></th>
                <th>Tanggal Terbit</th>
                <th>QR Code</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>