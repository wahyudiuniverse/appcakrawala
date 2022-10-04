<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $favicon = base_url().'uploads/logo/favicon/'.$company[0]->favicon;?>
<?php $session = $this->session->userdata('c_user_id'); ?>
<?php $session_username = $this->session->userdata('username'); ?>
<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->

<head>

<!-- Basic Page Needs
================================================== -->
<meta charset="utf-8">
<title><?php echo $title;?></title>

<!-- Mobile Specific Metas
================================================== -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="icon" type="image/x-icon" href="<?php echo $favicon;?>">
<!-- CSS
================================================== -->
<link rel="stylesheet" href="<?php echo base_url();?>skin/jobs/hrpremium/css/style.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/jobs/hrpremium/css/colors/green.css" id="colors">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrpremium_vendor/assets/vendor/toastr/toastr.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrpremium_vendor/assets/vendor/libs/jquery-ui/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrpremium_vendor/assets/vendor/Trumbowyg/dist/ui/trumbowyg.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrpremium_vendor/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrpremium_vendor/assets/vendor/libs/flatpickr/flatpickr.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrpremium_vendor/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
  <link rel="stylesheet" href="<?php echo base_url();?>skin/hrpremium_vendor/assets/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css">
<!--<link rel="stylesheet" href="<?php echo base_url();?>skin/hrpremium_assets/css/hrpremium/xin_hrpremium.css">-->
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>

<body>

<!-- Header
================================================== -->
<header class="sticky-header">
<div class="container">
	<div class="sixteen columns">

		<!-- Logo -->
		<div id="logo">
			<h1><a href="<?php echo site_url('');?>"><img src="<?php echo base_url();?>uploads/logo/job/<?php echo $system[0]->job_logo;?>" alt="<?php echo $title;?>" /></a></h1>
		</div>

		<!-- Menu -->
		<nav id="navigation" class="menu">
			<ul id="responsive">

			</ul>
			<ul class="responsive float-right">

				<li><a href="<?php echo site_url('');?>">Home</a><li>
                <li><a href="<?php echo site_url('page/view/');?>xl9wkRy7tqOehBo6YCDjFG2JTucpKI4gMNsn8Zdf">About Us</a></li>
				
				<?php
				if(!empty($session_username)){ 
				?>
					<li><a href="<?php echo site_url('admin/');?>"><i class="fa fa-lock"></i> Go Dashboard</a></li>
				<?php
				} else {
				?>
					<li><a href="<?php echo site_url('admin/');?>"><i class="fa fa-lock"></i> Log In</a></li>
				<?php
				}
				?>

			</ul>
		</nav>

		<!-- Navigation -->
		<div id="mobile-navigation">
			<a href="#menu" class="menu-trigger"><i class="fa fa-reorder"></i> Menu</a>
		</div>

	</div>
</div>
</header>
<div class="clearfix"></div>

<?php if($this->router->fetch_class()!='welcome' && $this->router->fetch_class()!='jobs') { ?>
<!-- Titlebar
================================================== -->
<?php
	if($this->router->fetch_class() == 'employer' && $this->router->fetch_method()=='post_job'){
		$adJb = 'single submit-page';
	} else {
		$adJb = 'single';
	}
?>
<div id="titlebar" class="single">
	<div class="container">

		<div class="ten columns">
			<h2><?php echo $title;?></h2>
			<nav id="breadcrumbs">
				<ul>
					<li>You are here:</li>
					<li><a href="<?php echo site_url('');?>">Home</a></li>
					<li><?php echo $title;?></li>
				</ul>
			</nav>
		</div>
		
	</div>
</div>
<?php } ?>

<?php if($this->router->fetch_class()=='jobs' && $this->router->fetch_method()!='detail') { ?>
<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="ten columns">

            <div class="six columns">
                <a href="<?php echo site_url('employer/post_job');?>" class="button">Post a Job, It’s Free!</a>
            </div>
		</div>

	</div>
</div>
<?php } ?>
<!-- Container -->
<?php echo $subview;?>
<!-- Container / End -->

<!-- Footer
================================================== -->
<!--<div class="margin-top-20"></div>-->

<?php $this->load->view('frontend/hrpremium/job_components/jfooter');?>
<!-- Back To Top Button -->
<!--<div id="backtotop"><a href="#"></a></div>

</div>-->
<!-- Wrapper / End -->
<?php $this->load->view('frontend/hrpremium/job_components/html_jfooter');?>




</body>
</html>