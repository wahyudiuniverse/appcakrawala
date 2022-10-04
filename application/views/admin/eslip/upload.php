<?php
/* Employee -> Employee Details view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php
$contract_id = $this->uri->segment(4);
$employee_id = $this->uri->segment(5);
$eresult = $this->Employees_model->read_employee_information($employee_id);
$pkwtresult = $this->Pkwt_model->get_pkwt_by_userid($employee_id);


?>

<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>

<script type="text/javascript">
  const actualBtn = document.getElementById('actual-btn');

const fileChosen = document.getElementById('file-chosen');

actualBtn.addEventListener('change', function(){
  fileChosen.textContent = this.files[0].name
})

</script>
<style type="text/css">label {
  background-color: #00B22D;
  color: white;
  padding: 1rem;
  font-family: sans-serif;
  border-radius: 0.3rem;
  cursor: pointer;
  margin-top: 1rem;
}

#file-chosen{
  margin-left: 0.3rem;
  font-family: sans-serif;
}</style>

<div class="mb-3 sw-container tab-content">
  <div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
    <hr class="border-light m-0">
    <div class="mb-3 sw-container tab-content">
      <div id="smartwizard-2-step-1" class="card animated fadeIn tab-pane step-content mt-3" style="display: block;">
        <div class="cards-body">
          <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
              
              <div class="col-md-4">
                <div class="tab-content">
 


<!-- DOKUMEN -->
                  <div>
                    <div class="box" hidden>
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
                      <?php echo form_open_multipart('admin/employees/document_info_pkwt', $attributes, $hidden);?>
                      <?php
              $data_usr2 = array(
                'type'  => 'hidden',
                'name'  => 'user_id',
                'value' => $employee_id,
             );
            echo form_input($data_usr2);
            ?>



                      <div class="row">


                              <input name="employee_id" type="hidden" value="<?php echo $employee_id;?>">
                              <input name="contract_id" type="hidden" value="<?php echo $contract_id;?>">


                        <div class="col-md-18">
                          <div class="form-group">
                            <fieldset class="form-group">

                              <div class="custom-file">
  <label class="file">
  <input type="file" id="document_file" name="document_file">
  <span class="file-custom"></span>
</label>
</div>

                            </fieldset>
                          </div>
                        </div>


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


          </div>
        </div>
      </div>
    </div>
  </div>
</div>

    </div>
  </div>
</div>
