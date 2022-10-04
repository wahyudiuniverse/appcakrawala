<?php $system = $this->Xin_model->read_setting_info(1);?>
<div class="modal fade delete-modal animated " tabindex="-1" role="dialog" aria-hidden="true" style="display:none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        <strong class="modal-title"><?php echo $this->lang->line('xin_delete_confirm');?></strong> </div>
      <div class="alert alert-danger alert-dismissible fade in m-b-0" role="alert"> <strong><?php echo $this->lang->line('xin_d_not_restored');?></strong> </div>
      <div class="modal-footer">
        <?php $attributes = array('name' => 'delete_record', 'id' => 'delete_record', 'class' => 'login', 'autocomplete' => 'on');?>
		<?php $hidden = array('_method' => 'DELETE');?>
        <?php echo form_open('', $attributes, $hidden);?>
          <input name="_token" type="hidden" value="">
          <input name="token_type" id="token_type" type="hidden" value="">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
          <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('xin_confirm_del');?></button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Scripts
================================================== -->
<script src="<?php echo base_url();?>skin/jobs/hrpremium/scripts/jquery-2.1.3.min.js"></script>
<script src="<?php echo base_url();?>skin/jobs/hrpremium/scripts/custom.js"></script>
<script src="<?php echo base_url();?>skin/jobs/hrpremium/scripts/jquery.superfish.js"></script>
<script src="<?php echo base_url();?>skin/jobs/hrpremium/scripts/jquery.themepunch.tools.min.js"></script>
<script src="<?php echo base_url();?>skin/jobs/hrpremium/scripts/jquery.themepunch.revolution.min.js"></script>
<script src="<?php echo base_url();?>skin/jobs/hrpremium/scripts/jquery.themepunch.showbizpro.min.js"></script>
<script src="<?php echo base_url();?>skin/jobs/hrpremium/scripts/jquery.flexslider-min.js"></script>
<script src="<?php echo base_url();?>skin/jobs/hrpremium/scripts/chosen.jquery.min.js"></script>
<script src="<?php echo base_url();?>skin/jobs/hrpremium/scripts/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url();?>skin/jobs/hrpremium/scripts/waypoints.min.js"></script>
<script src="<?php echo base_url();?>skin/jobs/hrpremium/scripts/jquery.counterup.min.js"></script>
<script src="<?php echo base_url();?>skin/jobs/hrpremium/scripts/jquery.jpanelmenu.js"></script>
<script src="<?php echo base_url();?>skin/jobs/hrpremium/scripts/stacktable.js"></script>
<script src="<?php echo base_url();?>skin/jobs/hrpremium/scripts/slick.min.js"></script>
<script src="<?php echo base_url();?>skin/jobs/hrpremium/scripts/headroom.min.js"></script>
<script src="<?php echo base_url();?>skin/hrpremium_vendor/assets/vendor/libs/moment/moment.js"></script>
<script src="<?php echo base_url();?>skin/hrpremium_vendor/assets/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.js"></script>
<script src="<?php echo base_url();?>skin/hrpremium_vendor/assets/vendor/libs/timepicker/timepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrpremium_vendor/assets/vendor/Trumbowyg/dist/trumbowyg.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/jobs/hrpremium/scripts/jquery.sceditor.bbcode.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/jobs/hrpremium/scripts/jquery.sceditor.js"></script>
<script type="text/javascript">var site_url = '<?php echo site_url(); ?>';</script>
<script type="text/javascript">var base_url = '<?php echo site_url().$this->router->fetch_class(); ?>';</script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrpremium_vendor/assets/vendor/toastr/toastr.min.js"></script> 
<script src="<?php echo base_url();?>skin/hrpremium_vendor/assets/vendor/libs/jquery-ui/jquery-ui.min.js"></script>
<?php if($this->router->fetch_method()=='manage_jobs' || $this->router->fetch_method()=='manage_applications') { ?>
<!--<script type="text/javascript" src="<?php echo base_url(); ?>skin/jobs/hrpremium/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>skin/jobs/hrpremium/css/jquery.dataTables.min.css">
<script data-require="bootstrap@*" data-semver="3.1.1" src="<?php echo base_url(); ?>skin/jobs/hrpremium/bootstrap.min.js"></script>
<link data-require="bootstrap-css@3.1.1" data-semver="3.1.1" rel="stylesheet" href="<?php echo base_url(); ?>skin/jobs/hrpremium/css/bootstrap.min.css" />-->
<?php } ?>    
<style type="text/css">
#xin_table th { text-align:left !important; }
.modal { z-index:999999 !important; }
</style> 
<script type="text/javascript">
$(document).ready(function(){
	toastr.options.closeButton = <?php echo $system[0]->notification_close_btn;?>;
	toastr.options.progressBar = <?php echo $system[0]->notification_bar;?>;
	toastr.options.timeOut = 3000;
	toastr.options.preventDuplicates = true;
	toastr.options.positionClass = "<?php echo $system[0]->notification_position;?>";
	$('.date').bootstrapMaterialDatePicker({
		weekStart: 0,
		time: false,
		clearButton: false,
		format: 'YYYY-MM-DD'
	});
	/*$('.date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat:'yy-mm-dd',
		yearRange: '1900:' + (new Date().getFullYear() + 15),
		beforeShow: function(input) {
			$(input).datepicker("widget").show();
		}
	});*/
});	
</script>
<script type="text/javascript" src="<?php echo base_url().'skin/hrpremium_vendor/hrpremium_scripts/jobs/'.$path_url.'.js'; ?>"></script>