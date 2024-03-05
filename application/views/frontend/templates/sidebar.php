<!-- Sidebar -->
<ul class="navbar-nav bg-gray-900 sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
		<div class="sidebar-brand-icon rotate-n-15">
			<i class="fab fa-autoprefixer"></i>
		</div>
		<div class="sidebar-brand-text mx-3">HRD-GA Prima</div>
	</a>

	<!-- Divider / Garis Pembatas -->
	<hr class="sidebar-divider">

	<!-- Query Relasi Menu -->
	<?php
	$role_id = $this->session->userdata('role_id');
	$queryMenu = "SELECT `user_menu`.`id`,`menu` 
                    FROM `user_menu` JOIN `user_access_menu`
                    ON  `user_menu`.`id` = `user_access_menu`.`menu_id`
        WHERE `user_access_menu`.`role_id` = $role_id
        ORDER BY `user_access_menu`.`menu_id` ASC ";
	$menu = $this->db->query($queryMenu)->result_array();

	?>

	<?php foreach ($menu as $n) : ?>
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#<?= $n['menu']; ?>" aria-expanded="true" aria-controls="collapseTwo">
				<i class="fas fa-fw fa-folder"></i>
				<span><?= $n['menu']; ?></span>
			</a>
			<div id="<?= $n['menu']; ?>" class="collapse" aria-labelledby="<?= $n['menu']; ?>" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<?php
					$menuID = $n['id'];
					$querySubMenu = "SELECT * 
                                    FROM `user_sub_menu` 
                                    WHERE `menu_id` = $menuID 
                                    AND  `is_active` = 1 ";
					$subMenus = $this->db->query($querySubMenu)->result_array();
					?>
					<?php foreach ($subMenus as $sms) : ?>

						<a class="collapse-item" href="<?= base_url($sms['url']); ?> "><i class="<?= $sms['icon']; ?>"></i>
							<span><?= $sms['title']; ?></span></a>
					<?php endforeach; ?>
				</div>
			</div>
		</li>
		<hr class="sidebar-divider my-0">
	<?php endforeach; ?>

	<?php
	/* Tampilan Menu Dalam Bentuk Lain
    <!-- Looping Menu -->
    <?php foreach ($menu as $m) : ?>
    <div class="sidebar-heading">
        <?= $m['menu']; ?>
    </div>

    <!-- Siapkan Sub Menu Sesuai Menu -->
    <!-- Query Sub Menu -->
    <?php
        $menuID = $m['id'];
        $querySubMenu = "SELECT * 
                        FROM `user_sub_menu` 
                        WHERE `menu_id` = $menuID 
                        AND  `is_active` = 1 ";
        $subMenu = $this->db->query($querySubMenu)->result_array();
        ?>
    <?php foreach ($subMenu as $sm) : ?>
    <?php if ($title == $sm['title']) : ?>
    <li class="nav-item active">
        <?php else : ?>
    <li class="nav-item">
        <?php endif; ?>
        <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
            <i class="<?= $sm['icon']; ?>"></i>
            <span><?= $sm['title']; ?></span></a>
    </li>
    <?php endforeach; ?>
    <hr class="sidebar-divider my-0 mt-2">
    <?php endforeach; ?>
    */
	?>

	<!-- Logout -->
	<li class="nav-item">
		<a class="nav-link" href="<?= base_url('auth/logout'); ?>">
			<i class="fas fa-fw fa-sign-out-alt"></i>
			<span>Logout</span></a>
	</li>
	<!-- End of Logout -->

	<!-- Divider / Garis Pembatas -->
	<hr class="sidebar-divider my-0">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>

</ul>
<!-- End of Sidebar -->
