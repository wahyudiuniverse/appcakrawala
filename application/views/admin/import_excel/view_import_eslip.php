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
            <strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_callplan');?>
          </span>
        </div>
      </div>

      <div class="col-md mb-3">
      </div>

      <div class="col-md mb-3">   
      </div>

      <div class="col-md-3">
      </div>         

      <div class="" style="margin-right: 25px;">
        <label class="form-label d-none d-md-block">&nbsp;</label>

      <div class="btn btn-success" data-toggle="tooltip" data-state="primary" data-placement="top" style="padding: inherit;">
                  <div>
                    <a class="dropdown-item importall" href="javascript:void(0)" data-status="1" data-user-id="<?php echo $uploadid;?>" style="color: azure;">IMPORT SEMUA</a>
                  </div>


                </div>

      </div>

      <div class="" style="margin-right: 25px;">
        <label class="form-label d-none d-md-block">&nbsp;</label>

      <div class="btn btn-secondary" data-toggle="tooltip" data-state="primary" data-placement="top" style="padding: inherit;">
                  <div>
                    <a class="dropdown-item back" href="<?php echo site_url().'admin/importexcel/importeslip/';?>" data-status="1" data-user-id="<?php echo $uploadid;?>" style="color: azure;">SELESAI</a>
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
            <th style="width: 70px;">Action / <?php echo $this->lang->line('xin_import_status_error');?></th>
            <th style="width: 30px;"><?php echo $this->lang->line('xin_nik');?></th>
            <th style="width: 80px;">Fullname</th>
            <th style="width: 80px;">Periode</th>
            <th style="width: 150px;">Project</th>
            <th style="width: 150px;">Sub-Project</th>
            <th style="width: 100px;">Area</th>
            <th style="width: 30px;">Hari Kerja</th>
            <th style="width: 50px;">Gaji Pokok</th>
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
