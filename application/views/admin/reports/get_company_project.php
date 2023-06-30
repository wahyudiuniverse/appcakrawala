<?php //$result = $this->Project_model->ajax_company_department($id_company);


    $session = $this->session->userdata('username');
    if(empty($session)){ 
      redirect('admin/');
    }

    $result = $this->Project_model->get_project_maping($session['employee_id']);

?>

            <label class="form-label">Projects <?php echo $session['employee_id'];?></label>
            <select class="form-control" name="sub_project_id" id="aj_project" data-plugin="xin_select" data-placeholder="Sub Project">

    <option value="0">--</option>
                  <?php foreach($result as $proj) {?>
    <option value="<?php echo $proj->project_id;?>"> <?php echo $proj->title;?></option>
    <?php } ?>

            </select>
            

<script type="text/javascript">
$(document).ready(function(){

  $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
  $('[data-plugin="select_hrm"]').select2({ width:'100%' });

  $('[data-plugin="xin_select"]').select2($(this).attr('data-options'));
  $('[data-plugin="xin_select"]').select2({ width:'100%' });

});

  jQuery("#aj_project").change(function(){
    jQuery.get(base_url+"/get_sub_project/"+jQuery(this).val(), function(data, status){
      jQuery('#subproject_ajax').html(data);
    });
  });

</script>