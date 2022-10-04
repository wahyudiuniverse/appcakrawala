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
    if(in_array('126',$role_resources_ids)) { 
    ?>
      <div id="smartwizard-2-step-1" class="card animated fadeIn tab-pane step-content" style="display: block;">   

      <!-- employee import standard -->
      <div class="card-header with-elements"> 
        <span class="card-header-title mr-2">
          <strong><?php echo $this->lang->line('xin_import_employees');?></strong> 
            <?php echo $this->lang->line('xin_employee_import_csv_file');?>
        </span>
      </div> 

      <div class="card-body">
        <p class="card-text"><?php echo $this->lang->line('xin_employee_import_description_line1');?></p>
        <p class="card-text"><?php echo $this->lang->line('xin_employee_import_description_line2');?></p>
          <h6>
            <a href="<?php echo base_url();?>uploads/csv/template_import_employees_2022.xlsx" class="btn btn-primary"> 
              <i class="fa fa-download"></i> 
              <?php echo $this->lang->line('xin_employee_import_download_sample');?> 
            </a>
          </h6>

          <?php 
          $attributes = array(
            'name' => 'import_users_temp', 
            'id' => 'import_users_temp', 
            'autocomplete' => 'off');
          ?>

          <?php 
          $hidden = array(
            'user_id' => $session['user_id']);
          ?>

          <?php echo form_open_multipart('admin/importexcel/import_employees', $attributes, $hidden);?>

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
