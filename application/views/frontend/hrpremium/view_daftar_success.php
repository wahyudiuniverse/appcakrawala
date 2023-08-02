<?php $session = $this->session->userdata('c_user_id'); ?>
<?php //$jobs = $this->Job_post_model->get_employer_jobs($session['c_user_id']);?>
<?php $jobs = $this->Employees_model->get_monitoring_daftar(); ?>

<!--<div class="container">
  <p class="margin-bottom-25">Your listings are shown in the table below.</p>
  <table id="xin_table" class="display hover manage-table responsive-table" style="width:100%">
    <thead>
      <tr>
        <th width="80">Action</th>
        <th>Title</th>
        <th>Category</th>
        <th>Job Type</th>
        <th>Vacancies</th>
        <th>Closing Date</th>
      </tr>
    </thead>
  </table>
</div>-->
<div class="container">
	<!-- Table -->
	<div class="sixteen columns">

		<p class="margin-bottom-25">Your listings are shown in the table below.</p>

		<table class="manage-table responsive-table">

			<tr>
				<th><i class="fa fa-file-text"></i> Title</th>
				<th><i class="fa fa-check-square-o"></i> Category</th>
				<th><i class="fa fa-life-bouy"></i> Job Type</th>
				<th><i class="fa fa-calendar"></i> Date Posted</th>
				<th><i class="fa fa-user"></i> Applications</th>
				<th></th>
			</tr>
					
			<?php foreach($jobs->result() as $r) { ?>
  
			<tr>
				<td class="title">A</td>
				<td class="centered"><?php echo $category_name;?></td>
				<td>aa</td>
				<td>bb</td>
				<td class="centered">cc</td>
				<td class="action">
					<a href="<?php echo site_url('employer/edit_job/').$r->job_url;?>"><i class="fa fa-pencil"></i> Edit</a>
                    <a href="#" class="delete" data-toggle="modal" data-target=".delete-modal" data-record-id="<?php echo $r->job_id;?>"><i class="fa fa-remove"></i> Delete</a>
				</td>
			</tr>
			<?php  } ?>
		</table>

		<br>
		<a href="<?php echo site_url('daftar');?>" class="button">KEMBALI KE FORM PENDAFTARAN</a>

	</div>

</div>
<div class="margin-top-60"></div>
