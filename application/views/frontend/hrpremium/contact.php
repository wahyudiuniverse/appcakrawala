<!-- Container -->
<div class="container">

<div class="eleven columns">
	<?php
		if($this->session->flashdata('sent_message')):
			echo $this->session->flashdata('sent_message');
		endif;
	?>
	<h3 class="margin-bottom-15">Contact Form</h3>
	
		<!-- Contact Form -->
		<section id="contact" class="padding-right">

			<!-- Success Message -->
			<mark id="message"></mark>

			<!-- Form -->
			<?php $attributes = array('name' => 'contactform','id' => 'xin-form',  'autocomplete' => 'on');?>
			<?php $hidden = array('contact' => '1');?>
            <?php echo form_open('contact_us/send_mail/', $attributes, $hidden);?>
				<fieldset>

					<div>
						<label>Nama Lengkap:</label>
						<input name="name" type="text" id="name" />
					</div>

					<div>
						<label >NIP/NIK/Email: <span>*</span></label>
						<input name="email" type="email" id="email" pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" />
					</div>

					<div>
						<label>Pesan: <span>*</span></label>
						<textarea name="message" cols="40" rows="3" id="message" spellcheck="true"></textarea>
					</div>

				</fieldset>
				<div id="result"></div>
				<input type="submit" class="submit" id="submit" value="Send Message" />
				<div class="clearfix"></div>
				<div class="margin-bottom-40"></div>
			<?php echo form_close(); ?>

		</section>
		<!-- Contact Form / End -->

</div>
<!-- Container / End -->


<!-- Sidebar
================================================== -->
<div class="five columns">

	<!-- Information -->
	<h3 class="margin-bottom-10">Informasi</h3>
	<div class="widget-box">
		<p>Sampaikan kendala dan tujuan anda, agar kami bisa melakukan hal terbaik untuk anda.</p>

		<ul class="contact-informations">
			<li>Gedung. Graha Krista Aulia, No 20 Cinere</li>
			<li>Depok, Jawa Barat</li>
		</ul>

		<ul class="contact-informations second">
			<li><i class="fa fa-phone"></i> <p>+62 851-7412-3434</p></li>
			<li><i class="fa fa-envelope"></i> <p>itcare@spcakrawala.co.id</p></li>
			<li><i class="fa fa-globe"></i> <p>https://spcakrawala.co.id</p></li>
		</ul>

	</div>
	
	<!-- Social -->
	<div class="widget margin-top-30">
		<h3 class="margin-bottom-5">Social Media</h3>
		<ul class="social-icons">
			<li><a class="facebook" href="#"><i class="icon-facebook"></i></a></li>
			<li><a class="twitter" href="#"><i class="icon-twitter"></i></a></li>
			<li><a class="gplus" href="#"><i class="icon-gplus"></i></a></li>
			<li><a class="linkedin" href="#"><i class="icon-linkedin"></i></a></li>
		</ul>
		<div class="clearfix"></div>
		<div class="margin-bottom-50"></div>
	</div>

</div>
</div>
<!-- Container / End -->