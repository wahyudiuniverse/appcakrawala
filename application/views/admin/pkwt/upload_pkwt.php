<?php
/* Invoices view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>


<hr class="border-light m-0 mb-3">

<!-- DOKUMEN -->
                  <div class="tab-pane fade" id="account-document">
                    <div class="box">
                      <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_e_details_documents');?> </span> </div>
                      <div class="card-body">
                        <div class="box-datatable table-responsive">
                          <table class="table table-striped table-bordered dataTable" id="xin_table_document" style="width:100%;">
                            <thead>
                              <tr>
                                <th><?php echo $this->lang->line('xin_action');?></th>
                                <th><?php echo $this->lang->line('xin_e_details_dtype');?></th>
                                <th><?php echo $this->lang->line('xin_employee_document_number');?></th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_e_details_document');?> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'document_info', 'id' => 'document_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_document_info' => 'UPDATE');?>
                      <?php echo form_open_multipart('admin/employees/document_info', $attributes, $hidden);?>
                      <?php
              $data_usr2 = array(
                'type'  => 'hidden',
                'name'  => 'user_id',
                'value' => $user_id,
             );
            echo form_input($data_usr2);
            ?>



                      <div class="row">

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="relation"><?php echo $this->lang->line('xin_e_details_dtype');?><i class="hrpremium-asterisk">*</i></label>
                            <select name="document_type_id" id="document_type_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_e_details_choose_dtype');?>">
                              <option value=""></option>
                              <?php foreach($all_document_types as $document_type) {?>
                              <option value="<?php echo $document_type->document_type_id;?>"> <?php echo $document_type->document_type;?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="title" class="control-label"><?php echo $this->lang->line('xin_employee_document_number');?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_document_number');?>" name="title" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="16">
                          </div>
                        </div>


                        <div class="col-md-6">
                          <div class="form-group">
                            <fieldset class="form-group">
                              <label for="logo"><?php echo $this->lang->line('xin_e_details_document_file');?></label>
                              <input type="file" class="form-control-file" id="document_file" name="document_file">
                              <small><?php echo $this->lang->line('xin_e_details_d_type_file');?></small>
                            </fieldset>
                          </div>
                        </div>
<!--                         <div class="col-md-6">
                          <div class="form-group">
                            <label for="date_of_expiry" class="control-label"><?php /*echo $this->lang->line('xin_e_details_doe');*/?><i class="hrpremium-asterisk">*</i></label>
                            <input class="form-control date" readonly placeholder="<?php /*echo $this->lang->line('xin_e_details_doe');*/?>" name="date_of_expiry" type="text">
                          </div>
                        </div> -->

                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="form-actions"> <?php echo form_button(array('name' => 'hrpremium_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_save'))); ?> </div>
                          </div>
                        </div>
                      </div>
                      <?php echo form_close(); ?> </div>
                  </div>
                  
<style type="text/css">
.info-box-number {
  font-size:15px !important;
  font-weight:300 !important;
}
</style>
