<?php
/* Invoices view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>



<hr class="border-light m-0 mb-3">

<div class="card <?php echo $get_animate;?>">


    <div class="form-row">
      <div class="col-md mb-3">
        <div class="card-header with-elements"> 
          <span class="card-header-title mr-2">
            <strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_pkwt');?>
          </span>
        </div>
      </div>

      <div class="col-md mb-3">
      </div>

      <div class="col-md mb-3">   
      </div>

      <div class="col-md-3">
      </div>         

      <div class="col-md col-xl-2 mb-4" style="padding-right: 0px;">
        <label class="form-label d-none d-md-block">&nbsp;</label>

      <div class="btn btn-success" data-toggle="tooltip" data-state="primary" data-placement="top" style="padding: inherit;">
                  <div>
                    <a class="dropdown-item importall" href="javascript:void(0)" data-status="1" data-user-id="<?php echo $uploadid;?>" style="color: azure;">Import Semua</a>
                  </div>
                </div>
      </div>
    </div>

        <input readonly id="uploadid" name="uploadid" type="hidden" value="<?php echo $uploadid;?>">


  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table" style="table-layout: fixed;">
        <thead>
          <tr>
            <th style="width: 100px;">Action / <?php echo $this->lang->line('xin_import_status_error');?></th>
            <th style="width: 180px;"><?php echo $this->lang->line('xin_nomor_surat');?></th>
            <th style="width: 180px;"><?php echo $this->lang->line('xin_nomor_spb');?></th>
            <th style="width: 80px;"><?php echo $this->lang->line('dashboard_employee_id');?></th>
            <th style="width: 50px;"><?php echo $this->lang->line('xin_e_details_contract_type');?></th>
            <th style="width: 45px;"><?php echo $this->lang->line('xin_import_import_designation_id');?></th>
            <th style="width: 45px;"><?php echo $this->lang->line('xin_import_pkwt_posisi_lama');?></th>
            <th style="width: 45px;"><?php echo $this->lang->line('xin_project_id');?></th>
            <th style="width: 45px;"><?php echo $this->lang->line('xin_import_import_location_id');?></th>
            <th style="width: 50px;"><?php echo $this->lang->line('xin_contract_time');?></th>
            <th style="width: 50px;"><?php echo $this->lang->line('xin_working_day');?></th>
            <th style="width: 70px;"><?php echo $this->lang->line('xin_pkwt_tjmakan');?></th>
            <th style="width: 70px;"><?php echo $this->lang->line('xin_pkwt_tjtransport');?></th>
            <th style="width: 70px;"><?php echo $this->lang->line('xin_pkwt_tjbbm');?></th>
            <th style="width: 70px;"><?php echo $this->lang->line('xin_pkwt_tjpulsa');?></th>
            <th style="width: 70px;"><?php echo $this->lang->line('xin_pkwt_tjrental');?></th>
            <th style="width: 70px;"><?php echo $this->lang->line('xin_pkwt_tjgrade');?></th>
            <th style="width: 70px;"><?php echo $this->lang->line('xin_pkwt_tjlaptop');?></th>
            <th style="width: 80px;"><?php echo $this->lang->line('xin_pkwt_tgl_mulai');?></th>
            <th style="width: 80px;"><?php echo $this->lang->line('xin_pkwt_tgl_akhir');?></th>
            <th style="width: 100px;"><?php echo $this->lang->line('xin_pkwt_tgl_mulai_periode_payment');?></th>
            <th style="width: 100px;"><?php echo $this->lang->line('xin_pkwt_tgl_akhir_periode_payment');?></th>
            <th style="width: 100px;"><?php echo $this->lang->line('xin_pkwt_tgl_payment');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
.info-box-number {
  font-size:15px !important;
  font-weight:300 !important;
}
</style>
