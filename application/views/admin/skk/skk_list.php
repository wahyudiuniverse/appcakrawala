<?php
/* Departments view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

 <?php //$all_employees = $this->Employees_model->get_all_employees_resign();?>
<?php $count_skk = $this->Esign_model->count_skk();?>
<?php $romawi = $this->Xin_model->tgl_pkwt();?>
<?php $nomor_surat = '/'.'REF-HRD/SC/'.$romawi;?>

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
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> SKK</span>
    </div>
      <div class="card-body">
        <?php $attributes = array('name' => 'add_department', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/esign/add_esign', $attributes, $hidden);?>



        <div class="form-group">
          <label for="nodoc"><?php echo $this->lang->line('xin_no_dokumen');?></label>
          <input type="text" class="form-control" name="nomordoc" value="<?php echo $nomor_surat;?>">
        </div>

        <div class="form-group">
          <label for="first_name"><?php echo $this->lang->line('xin_daftar_karyawan');?></label>
          <select class="form-control" name="manag_sign" id="aj_employee" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_daftar_karyawan');?>" onkeyup="isi_otomatis()">
            <option value=""></option>
            <?php foreach($all_employees as $company) {?>
            <option value="<?php echo $company->employee_id?>"><?php echo $company->fullname?></option>
            <?php } ?>
          </select>
        </div>


          <div class="form-group" id="department_ajax">
                        <label for="join_date">Join Date</label>
                        <input class="form-control date" placeholder="Tanggal Bergabung" readonly="readonly" name="join_date" type="text" value="">
          </div>


          <div class="form-group">
                        <label for="join_date">Closing BPJS</label>
                        <input class="form-control date" placeholder="Tanggal Penutupan BPJS" readonly="readonly" name="closing_date_bpjs" type="text" value="">
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
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> SKK</span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_action');?></th>
                <th><i class="fa fa-building-o"></i> <?php echo $this->lang->line('xin_no_dokumen');?></th>
                <th>NIP</th>
                <th>Nama Lengkap</th>
                <th><?php echo $this->lang->line('xin_jenis_dokumen');?></th>
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
