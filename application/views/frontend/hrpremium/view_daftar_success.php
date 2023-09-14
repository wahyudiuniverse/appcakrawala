<?php $session = $this->session->userdata('c_user_id'); ?>
<?php //$jobs = $this->Job_post_model->get_employer_jobs($session['c_user_id']);?>
<?php $jobs = $this->Employees_model->get_monitoring_daftar(); ?>
<?php $no = $jobs->num_rows(); ?>

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

		<h3 class="margin-bottom-25">Halo, <?php echo strtoupper($fullname); ?></h3>
		<h3 class="margin-bottom-25">Data Diri Kamu Berhasil Tersimpan,</h3>


		<table class="manage-table responsive-table">

			<tr>
				<th><i class="fa fa-file-text"></i> No.</th>
				<th><i class="fa fa-user"></i> Nama Lengkap</th>
				<th><i class="fa fa-envelope"></i> Project</th>
				<th><i class="fa fa-phone"></i> No. HP/Whatsapp</th>
				<th><i class="fa fa-calendar"></i> Date Posted</th>
			</tr>
					
			<?php foreach($jobs->result() as $r) { ?>
  
			<tr>
				<td><?php echo $no;?></td>
				<td class="action"><?php echo $r->fullname;?></td>
				<td class="action"><?php echo $r->title;?></td>
				<td class="action"><?php echo str_repeat('*', MAX(4, strlen($r->contact_no)) - 4) . substr($r->contact_no, -4);?></td>
				<td class="action"><?php echo $r->createdon;?></td>
			</tr>
			<?php $no--;} ?>
		</table>

		<br>
		<a href="<?php echo site_url('daftar');?>" class="button">KEMBALI KE FORM PENDAFTARAN</a>

	</div>

</div>
<div class="margin-top-60"></div>
