<?php $session = $this->session->userdata('c_user_id');?>
<div class="infobox margin-bottom-0">
    <div class="container">
        <?php if(!$session):?>
        <div class="sixteen columns">Start Building Your Own Job Board Now <a href="<?php echo site_url('registrasi');?>">Get Started</a></div>
        <?php else:?>
        <div class="sixteen columns">Start Building Your Own Job Board Now <a href="<?php echo site_url('registrasi');?>">Post a Job</a></div>
        <?php endif;?>
    </div>
</div>