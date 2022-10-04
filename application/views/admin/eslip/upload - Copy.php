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
              <div class="col-md-4 pt-0">

                  <div class="tab-pane fade show active">
 
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> <?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_e_details_document');?> </span> </div>
                    <div class="card-body pb-2">
                      <?php $attributes = array('name' => 'document_info', 'id' => 'document_info', 'autocomplete' => 'off');?>
                      <?php $hidden = array('u_document_info' => 'UPDATE');?>
                      <?php echo form_open_multipart('admin/mypkwt/document_pkwt', $attributes, $hidden);?>
                      <?php
              $data_usr2 = array(
                'type'  => 'hidden',
                'name'  => 'user_id',
                'value' => '64',
             );
            echo form_input($data_usr2);
            ?>


                              <input name="employee_id" type="hidden" value="<?php echo $employee_id;?>">
                              <input name="contract_id" type="hidden" value="<?php echo $contract_id;?>">



                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <fieldset class="form-group">
<div class="custom-file">
  <label class="file">
  <input type="file" id="document_file" name="document_file">
  <span class="file-custom"></span>
</label>
</div>




                              <small><?php echo $this->lang->line('xin_pkwt_type_file');?></small>
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
              <div class="col-md-8">
                <div class="tab-content">
 

<!-- DOKUMEN -->
                  <div class="tab-pane fade show active" id="account-document">
 
                    <div class="card-header with-elements"> <span class="card-header-title mr-2"> <strong> </strong> <?php echo $this->lang->line('xin_e_details_document');?> </span> </div>






<div class="row">


<?php 
for($i=0;$i<count($pkwtresult);$i++){
  $numb = $i + 1;


  $pkwt_file = $this->Pkwt_model->get_pkwt_file($pkwtresult[$i]->contract_id);
  if(!is_null($pkwt_file)){
    $file_name = $pkwt_file[0]->document_file;
    $uploaded = 1;
  } else {
    $file_name = '';
    $uploaded = 0;
  }

?>


  <div class="col-sm-6 col-xl-3">
    <div class="card mb-2">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ml-3" style="text-align: center;">

  <a href="<?php echo site_url('uploads/document/'.$file_name);?>" target="_blank">
              <?php   $de_file = base_url().'uploads/users/logo_pdf.png';?>
              
              <img src="<?php  echo $de_file;?>" alt="unlock-user" class="img-circle" style="width: 130px;padding: 10px;">

    </a>
            <div class="text-center small" style="text-align: center;"><?php echo $pkwtresult[$i]->no_surat;?></div>

            <?php 
            if(strtotime($pkwtresult[$i]->to_date) > strtotime(date("Y-m-d"))){
            ?>

            <div class="text-center" style="text-align: center;"><?php echo 'No-Active';?></div>

            <?php
            } else {
            ?>

            <div class="text-center" style="text-align: center;"><?php echo 'Active';?></div>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php
}
?>


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
</div>
