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
            <th style="width: 80px;"><?php echo $this->lang->line('xin_nik'). ' Baru';?></th>
            <th style="width: 100px;"><?php echo $this->lang->line('dashboard_fullname');?></th>
            <th style="width: 80px;"><?php echo $this->lang->line('xin_import_import_company_id');?></th>
            <th style="width: 80px;"><?php echo $this->lang->line('xin_import_import_location_id');?></th>
            <th style="width: 70px;">Depth ID</th>
            <th style="width: 70px;"><?php echo $this->lang->line('xin_import_import_designation_id');?></th>
            <th style="width: 70px;"><?php echo $this->lang->line('xin_project');?></th>
            <th style="width: 70px;"><?php echo $this->lang->line('left_sub_projects');?></th>
            <th style="width: 100px;"><?php echo $this->lang->line('dashboard_email');?></th>
            <th style="width: 60px;"><?php echo $this->lang->line('xin_employee_mstatus');?></th>
            <th style="width: 60px;"><?php echo $this->lang->line('xin_employee_gender');?></th>
            <th style="width: 80px;"><?php echo $this->lang->line('xin_employee_dob');?></th>
            <th style="width: 80px;"><?php echo $this->lang->line('xin_employee_doj');?></th>
            <th style="width: 100px;"><?php echo $this->lang->line('xin_e_details_contact');?></th>
            <th style="width: 150px;"><?php echo $this->lang->line('xin_employee_address');?></th>
            <th style="width: 120px;"><?php echo $this->lang->line('xin_kk');?></th>
            <th style="width: 120px;"><?php echo $this->lang->line('xin_ktp');?></th>
            <th style="width: 100px;"><?php echo $this->lang->line('xin_npwp');?></th>
            <th style="width: 100px;"><?php echo $this->lang->line('xin_bpjstk');?></th>
            <th style="width: 100px;"><?php echo $this->lang->line('xin_bpjsks');?></th>
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
