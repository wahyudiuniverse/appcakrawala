<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['designation_id']) && $_GET['data']=='designation'){
?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data">EDIT PROJECT</h4>
</div>
<?php $attributes = array('name' => 'edit_designation', 'id' => 'edit_designation', 'autocomplete' => 'off', 'class'=>'m-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $project_id, 'ext_name' => $title);?>
<?php echo form_open('admin/project/update/'.$project_id, $attributes, $hidden);?>
  <div class="modal-body">
     <div class="row">


      <div class="col-md-4">   
        <div class="form-group">
        <label for="designation">Nama Project/PT</label>
        <input type="text" class="form-control" name="title" value="<?php echo $title;?>">
        </div>
      </div>

      <div class="col-md-4">   
        <div class="form-group">
        <label for="designation">Project Alias</label>
        <input type="text" class="form-control" name="priority" value="<?php echo $priority;?>">
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group">
          <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
          <select class="form-control" name="company_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
            <option value=""></option>
            <?php foreach($get_all_companies as $company) {?>
            <option value="<?php echo $company->company_id?>" <?php if($company->company_id==$company_id) {?> selected="selected" <?php } ?>><?php echo $company->name?></option>
            <?php } ?>
          </select>
        </div>
      </div>



    </div> 

  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_update');?></button>
  </div>
<?php echo form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
  
  $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
  $('[data-plugin="select_hrm"]').select2({ width:'100%' });
  
  jQuery("#ajx_company").change(function(){
    jQuery.get(base_url+"/get_model_departments/"+jQuery(this).val(), function(data, status){
      jQuery('#ajx_department_modal').html(data);
    });
  }); 
  jQuery("#aj_subdepartments_model").change(function(){
    jQuery.get(base_url+"/get_sub_departments/"+jQuery(this).val(), function(data, status){
      jQuery('#subdepartment_ajax_modal').html(data);
    });
  });  
  Ladda.bind('button[type=submit]');
  
  /* Edit data */
  $("#edit_designation").submit(function(e){
  e.preventDefault();
    var obj = $(this), action = obj.attr('name');
    $('.save').prop('disabled', true);
    
    $.ajax({
      type: "POST",
      url: e.target.action,
      data: obj.serialize()+"&is_ajax=1&edit_type=designation&form="+action,
      cache: false,
      success: function (JSON) {
        if (JSON.error != '') {
          toastr.error(JSON.error);
          $('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
          $('.save').prop('disabled', false);
          Ladda.stopAll();
        } else {
          // On page load: datatable
          var xin_table = $('#xin_table').dataTable({
            "bDestroy": true,
            "ajax": {
              url : "<?php echo site_url("admin/project/project_list") ?>",
              type : 'GET'
            },
            dom: 'lBfrtip',
            "buttons": ['csv', 'excel', 'pdf', 'print'], // colvis > if needed
            "fnDrawCallback": function(settings){
            $('[data-toggle="tooltip"]').tooltip();          
            }
          });
          xin_table.api().ajax.reload(function(){ 
            toastr.success(JSON.result);
          }, true);
          $('input[name="csrf_hrpremium"]').val(JSON.csrf_hash);
          $('.edit-modal-data').modal('toggle');
          $('.save').prop('disabled', false);
          Ladda.stopAll();
        }
      }
    });
  });
}); 
</script>
<?php }
?>
