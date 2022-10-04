<?php $session = $this->session->userdata('c_user_id');?>
<!-- Slider
================================================== -->
<div id="banner" style="background-image: url(<?php echo base_url();?>skin/vendor/jobs/hrpremium/images/banner-home-01.jpg)" class="parallax background" data-img-width="2000" data-img-height="1330" data-diff="400">
	<div class="container">
		<div class="two columns">
		 &nbsp;
		</div>
        <div class="twelve columns">
			
			<div class="search-container">

				<!-- Form -->
				<h2>Find job</h2>
				<form method="get" name="job-search" action="<?php echo site_url('jobs/');?>" accept-charset="utf-8">
                <input type="text" name="search" class="ico-01" placeholder="Enter job title..." value=""/>
				<button type="submit"><i class="fa fa-search"></i></button>
                </form>

				<!-- Browse Jobs -->
				<div class="browse-jobs">
					Browse job offers by <a href="<?php echo site_url('jobs/categories');?>"> category</a>
				</div>
				
				<!-- Announce -->
				<div class="announce">
					We’ve over <strong><?php echo $this->Job_post_model->all_active_jobs();?></strong> job offers for you!
				</div>

			</div>

		</div>
	</div>
</div>
<!-- Icon Boxes -->
<div class="section-background top-0">
	<div class="container">

		<div class="one-third column">
			<div class="icon-box rounded alt">
				<i class="ln ln-icon-Folder-Add"></i>
				<h4>Add Resume</h4>
				<p>Pellentesque habitant morbi tristique senectus netus ante et malesuada fames ac turpis egestas maximus neque.</p>
			</div>
		</div>

		<div class="one-third column">
			<div class="icon-box rounded alt">
				<i class="ln ln-icon-Search-onCloud"></i>
				<h4>Search For Jobs</h4>
				<p>Pellentesque habitant morbi tristique senectus netus ante et malesuada fames ac turpis egestas maximus neque.</p>
			</div>
		</div>

		<div class="one-third column">
			<div class="icon-box rounded alt">
				<i class="ln ln-icon-Business-ManWoman"></i>
				<h4>Find Crew</h4>
				<p>Pellentesque habitant morbi tristique senectus netus ante et malesuada fames ac turpis egestas maximus neque.</p>
			</div>
		</div>

	</div>
</div>

<?php if(is_null($session)){?>
<!-- Infobox -->
<div class="infobox">
	<div class="container">
		<div class="sixteen columns">Start Building Your Own Job Board Now <a href="<?php echo site_url('user/sign_in');?>">Get Started</a></div>
	</div>
</div>
<?php } ?>

<!-- Clients Carousel -->
<h3 class="centered-headline">Clients Who Have Trusted Us <span>The list of clients who have put their trust in us includes:</span></h3>
<div class="clearfix"></div>

<div class="container">

	<div class="sixteen columns">

		<!-- Navigation / Left -->
		<div class="one carousel column"><div id="showbiz_left_2" class="sb-navigation-left-2"><i class="fa fa-angle-left"></i></div></div>

		<!-- ShowBiz Carousel -->
		<div id="our-clients" class="showbiz-container fourteen carousel columns" >

		<!-- Portfolio Entries -->
		<div class="showbiz our-clients" data-left="#showbiz_left_2" data-right="#showbiz_right_2">
			<div class="overflowholder">

				<ul>
					<!-- Item -->
					<li><img src="<?php echo base_url();?>skin/vendor/jobs/hrpremium/images/logo-01.png" alt="" /></li>
					<li><img src="<?php echo base_url();?>skin/vendor/jobs/hrpremium/images/logo-02.png" alt="" /></li>
					<li><img src="<?php echo base_url();?>skin/vendor/jobs/hrpremium/images/logo-03.png" alt="" /></li>
					<li><img src="<?php echo base_url();?>skin/vendor/jobs/hrpremium/images/logo-04.png" alt="" /></li>
					<li><img src="<?php echo base_url();?>skin/vendor/jobs/hrpremium/images/logo-05.png" alt="" /></li>
					<li><img src="<?php echo base_url();?>skin/vendor/jobs/hrpremium/images/logo-06.png" alt="" /></li>
					<li><img src="<?php echo base_url();?>skin/vendor/jobs/hrpremium/images/logo-07.png" alt="" /></li>
				</ul>
				<div class="clearfix"></div>

			</div>
			<div class="clearfix"></div>

		</div>
		</div>

		<!-- Navigation / Right -->
		<div class="one carousel column"><div id="showbiz_right_2" class="sb-navigation-right-2"><i class="fa fa-angle-right"></i></div></div>

	</div>

</div>
<!-- Container / End -->