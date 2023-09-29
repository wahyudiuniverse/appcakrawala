<?php
/* Employee Import view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">

  <div class="sw-container tab-content">

    <?php 
    if(in_array('469',$role_resources_ids)) { 
    ?>
      <div id="smartwizard-2-step-1" class="card animated fadeIn tab-pane step-content" style="display: block;">   

      <!-- employee import standard -->
      <div class="card-header with-elements"> 
        <span class="card-header-title mr-2">
          <strong><?php echo $this->lang->line('xin_eslip');?></strong> 
            <?php echo $this->lang->line('xin_employee_import_csv_file');?>
        </span>
      </div> 

      <div class="card-body">

          <h6>
            <a href="<?php echo base_url();?>uploads/csv/TEMPLATE E-SLIP CIS (29092023).xlsx" class="btn btn-primary"> 
              <i class="fa fa-download"></i> 
              <?php echo $this->lang->line('xin_employee_import_download_sample');?> 
            </a>
          </h6>

          <?php 
          $attributes = array(
            'name' => 'import_newemp_temp', 
            'id' => 'import_newemp_temp', 
            'autocomplete' => 'off');
          ?>

          <?php 
          $hidden = array(
            'user_id' => $session['user_id']);
          ?>

          <?php echo form_open_multipart('admin/importexcel/import_eslip', $attributes, $hidden);?>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <fieldset class="form-group">
                    <label for="logo"><?php echo $this->lang->line('xin_employee_upload_file');?><i class="hrpremium-asterisk">*</i></label>
                    <input type="file" class="form-control-file" id="file" name="file">
                    <small><?php echo $this->lang->line('xin_employee_imp_allowed_size');?></small>
                  </fieldset>
                </div>
              </div>
            </div>
          
          <div class="mt-1">             
            <div class="form-actions box-footer"> 
              <?php 
                echo form_button(
                  array(
                    'name' => 'hrpremium_form', 
                    'type' => 'submit', 
                    'class' => $this->Xin_model->form_button_class(), 
                    'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_empactive_import')
                  )
                ); 
              ?> 
            </div>
          </div>

          <?php echo form_close(); ?> 
        </div>
      </div>
    <?php 
    } 
    ?>


  </div>
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
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>